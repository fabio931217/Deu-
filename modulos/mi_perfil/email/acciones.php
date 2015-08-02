<?php
require_once("php/formulario_basico.php");
class Email extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
        $v->addRules('identifica', 'Identifica', array('required' => true) );
		$v->addRules('correo', 'Correo', array('required' => true, "mail" => true,'maxLength' => 100) );

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

        if ($_GET["correo"] != "" && $_GET["correo"] != "NULL") { 
            $s.= " AND correo LIKE '%" . str_replace(" ","%",$_GET['correo']) ."%' ";
        }

        $id= $_SESSION['persona_id']; 
        $sql = "SELECT * FROM email e WHERE e.identifica=$id $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Email("email", "id", true);
$f->$accion();
?>