<?php
require_once("php/formulario_basico.php");
class Horas extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 40) );
		$v->addRules('conversion', 'Conversion', array('required' => true, 'maxLength' => 40) );

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
        if ($_GET["conversion"] != "" && $_GET["conversion"] != "NULL") { 
            $s.= " AND conversion LIKE '%" . str_replace(" ","%",$_GET['conversion']) ."%' ";
        }
        $sql = "SELECT * FROM horas WHERE 1 $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Horas("horas", "id", true);
$f->$accion();
?>