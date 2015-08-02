<?php
require_once("php/Encryptar.php");
require_once("php/clase_base.php");

class Sesion extends clase_base {

    function validar() {
        $v = new Validation($_POST);
        $v->addRules('usuario', 'Usuario', array('required' => true, 'length' => array(5, 15)));
        $v->addRules('clave', 'Clave', array('required' => true, 'length' => array(5, 16)));

        $result = $v->validate();
        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else {
            //Errores de validación
            /*
              $r['error'] = true;
              $r['msg'] = $result['messages'];
              $r['bad_fields'] = $result['bad_fields'];
              $r['errors'] = $result['errors'];
              echo json_encode($r);
              exit(0);

             */
            $this->denegarSesion($result['messages'], 4);
        }
    }

    function iniciar() {
        $this->validar();

        if (isset($_SESSION['usuario'])) {
            $this->denegarSesion("Acceso denegado !", 3);
        }

        if (isset($_POST['usuario']) && isset($_POST['clave'])) {
            $sql = "SELECT * FROM persona WHERE identifica='$_POST[usuario]'";
            $rw = $this->db->select_row($sql);

            $clave =Encrypter::encrypt($_POST['clave']);

            if ($rw['hash'] == $clave) {

                $rol = $this->db->select_one("SELECT rol FROM admin_usuario WHERE persona_id='$rw[id]'");
                if ($rol == "") {
                    //Usuario y clave valido pero no tiene permiso para ingresar a este modulo
                   // $this->denegarSesion("Acceso denegado!!", 2);
                }

                $row['usuario'] = $_POST['usuario'];
                $row['session_id'] = session_id();
                $row['user_agent'] = $this->db->escape_string($_SERVER['HTTP_USER_AGENT']);
                $row['refer'] = $_SERVER['HTTP_REFERER'];
                $row['ip'] = $_SERVER['REMOTE_ADDR'];
                $row['inicio'] = date('Y-m-d H:i:s');
                $row['fin'] = date('Y-m-d H:i:s');
                $row['salida'] = "N";
                $this->db->insert("admin_sesion", $row);
                
                echo $this->db->error();
                
                $id = $this->db->last_insert_id();
                if ($id == "") {
                    //Error al crear la sesion en la base de datos
                    $this->denegarSesion("Acceso denegado!!!", 5);
                }

                //Datos de sesion
                $_SESSION['sesion_id'] = $id;
                $_SESSION['usuario'] = $_POST['usuario'];
                $_SESSION['nombre_usuario'] = $rw['nombre'] . " " . $rw['apellido1'] . " " . $rw['apellido2'];
                $_SESSION['persona_id'] = $rw['id'];
                $_SESSION['usuario_rol'] = $rol;

                //Determinar accesos
                $_SESSION['acceso_menu'] = array();
                $_SESSION['acceso_menu'][] = 1; //Permisos para todos los usuarios
                $_SESSION['acceso_menu'][] = 3; //Permisos para usuarios logueados
                $_SESSION['acceso_menu'][] = 7; //Menus que dependen del rol

                $r = array();
                $r['error'] = false;
                $r['msg'] = "Ok";
                echo json_encode($r);
                exit(0);
            }
        }

        $this->denegarSesion("Acceso denegado!!!", 1);
    }

    private function denegarSesion($msg, $tipo) {

        /*
         * Tipo
         * 1: Usuario o clave incorrecta
         * 2: No tiene rol para este aplicativo
         * 3: Ya habia iniciado sesión previamente
         * 4: Error de validación
         * 5: Error al crear la sesion en la base de datos
         */
        $db = $this->db;
        $row['session_id'] = session_id();
        $row['user_agent'] = $db->escape_string($_SERVER['HTTP_USER_AGENT']);
        $row['refer'] = $_SERVER['HTTP_REFERER'];
        $row['ip'] = $_SERVER['REMOTE_ADDR'];
        $row['fecha'] = date('Y-m-d H:i:s');
        $row['usuario'] = $_POST['usuario'];
        $row['tipo'] = $tipo;

        $db->insert("admin_sesion_denegada", $row);
        $r = array();
        $r['error'] = true;
        $r['msg'] = $msg ." ($tipo)";
        echo json_encode($r);
        exit(0);
    }

}

$accion = ACCION;

$c = new Sesion();
$c->$accion();
?>