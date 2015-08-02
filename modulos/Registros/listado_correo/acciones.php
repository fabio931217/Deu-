<?php
require_once("php/formulario_basico.php");
class Listado_correo extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cod_persona', 'Persona', array('required' => true) );

        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        return true;
    }

    function getSQL() {
        $s="";

        if ($_GET["nombre"] != "" && $_GET["nombre"] != "NULL") { 
            $s.= " AND nombre LIKE '%" . str_replace(" ","%",$_GET['nombre']) ."%' ";
        }
        if ($_GET["cod_persona"] != "" && $_GET["cod_persona"] != "NULL") { 
            $s.= " AND cod_persona = '$_GET[cod_persona]'";
        }
        $sql = "SELECT * FROM listado_correo WHERE 1 $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Listado_correo("listado_correo", "id", true);
$f->$accion();
?>