<?php
require_once("php/formulario_basico.php");
class Destalles_listado_correo extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cod_persona', 'Cod persona', array('required' => true) );
		$v->addRules('cod_listado', 'Cod listado', array('required' => true) );

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

        if ($_GET["cod_persona"] != "" && $_GET["cod_persona"] != "NULL") { 
            $s.= " AND cod_persona = '$_GET[cod_persona]'";
        }
        if ($_GET["cod_listado"] != "" && $_GET["cod_listado"] != "NULL") { 
            $s.= " AND cod_listado = '$_GET[cod_listado]'";
        }
        $sql = "SELECT d.* ,l.nombre as listado ,CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2, ' [',p.identifica,']') as nombre
         FROM destalles_listado_correo d,general.persona p, listado_correo l
          WHERE d.cod_listado=l.id and d.cod_persona=p.id and l.cod_persona='$_SESSION[persona_id]' $s ";
        return $sql;
    }

      function listarPersonas() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Destalles_listado_correo("destalles_listado_correo", "id", true);
$f->$accion();
?>