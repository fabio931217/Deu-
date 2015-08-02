<?php
require_once("php/formulario_basico.php");
class Escenario extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 50) );
		$v->addRules('ubicacion', 'Ubicacion', array('required' => true, 'maxLength' => 200) );
		$v->addRules('estado_id', 'Estado id', array('required' => true) );

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
        if ($_GET["ubicacion"] != "" && $_GET["ubicacion"] != "NULL") { 
            $s.= " AND ubicacion LIKE '%" . str_replace(" ","%",$_GET['ubicacion']) ."%' ";
        }
        if ($_GET["estado_id"] != "" && $_GET["estado_id"] != "NULL") { 
            $s.= " AND estado_id = '$_GET[estado_id]'";
        }
         $sql = "SELECT e.*, es.nombre as estado
        FROM escenario e ,estado es
        WHERE es.codigo=e.estado_id $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Escenario("escenario", "id", true);
$f->$accion();
?>