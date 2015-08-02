<?php
require_once("php/formulario_basico.php");
class Telefonos extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('identifica', 'Identifica', array('required' => true) );
		$v->addRules('numero', 'Numero', array('required' => true,"integer" => true,'maxLength' => 80) );
		$v->addRules('ubicacion', 'Ubicacion', array('required' => true) );

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

        if ($_GET["numero"] != "" && $_GET["numero"] != "NULL") { 
            $s.= " AND numero LIKE '%" . str_replace(" ","%",$_GET['numero']) ."%' ";
        }
        if ($_GET["ubicacion"] != "" && $_GET["ubicacion"] != "NULL") { 
            $s.= " AND ubicacion = '$_GET[ubicacion]'";
        }
        $id= $_SESSION['persona_id']; 

        $sql = "SELECT t.*, l.nombre as lugar
         FROM telefonos t , lugartel l
         WHERE t.identifica=$id  AND t.ubicacion=l.codigo $s ";

        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Telefonos("telefonos", "id", true);
$f->$accion();
?>