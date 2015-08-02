<?php
require_once("php/formulario_basico.php");
class Sexo extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('codigo', 'Codigo', array('required' => true) );
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 20) );

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
        $sql = "SELECT * FROM sexo WHERE 1 $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Sexo("sexo", "codigo", false);
$f->$accion();
?>