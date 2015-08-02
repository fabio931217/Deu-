<?php
require_once("php/formulario_basico.php");
class Municipio extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 60) );
		$v->addRules('departamento_id', 'Departamento id', array('required' => true) );

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
        if ($_GET["departamento_id"] != "" && $_GET["departamento_id"] != "NULL") { 
            $s.= " AND departamento_id = '$_GET[departamento_id]'";
        }
        $sql = "SELECT * FROM municipio WHERE 1 $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
$_POST['_usuario'] = $_SESSION['usuario'];
$_POST['_fecha'] = date('Y-m-d H:i:s');

$accion = ACCION;
$f = new Municipio("municipio", "id", true);
$f->$accion();
?>