<?php
require_once("php/formulario_basico.php");
class Persona extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('identifica', 'Identifica', array('required' => true, 'maxLength' => 15) );
		//$v->addRules('fechaexp', 'Fechaexp', array('date' => true) );
		$v->addRules('tipoide', 'Tipoide', array('maxLength' => 2) );
		$v->addRules('municipioexp', 'Municipioexp', array('required' => true) );
		$v->addRules('apellido1', 'Apellido1', array('maxLength' => 80) );
		$v->addRules('apellido2', 'Apellido2', array('maxLength' => 80) );
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 80) );
		$v->addRules('nombre1', 'Nombre1', array('maxLength' => 80) );
		$v->addRules('nombre2', 'Nombre2', array('maxLength' => 80) );
	//	$v->addRules('fechanaci', 'Fechanaci', array('date' => true) );
		$v->addRules('municipionaci', 'Municipionaci', array('required' => true) );
		$v->addRules('direccion', 'Direccion', array('maxLength' => 80) );
		$v->addRules('municipiores', 'Municipiores', array('required' => true) );
		$v->addRules('clave', 'Clave', array('maxLength' => 40) );
		$v->addRules('tag', 'Tag', array('maxLength' => 1) );
		$v->addRules('fecha', 'Fecha', array('required' => true) );
		$v->addRules('hash', 'Hash', array('maxLength' => 40) );
		$v->addRules('foto', 'Foto', array('maxLength' => 100) );

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

        if ($_GET["identifica"] != "" && $_GET["identifica"] != "NULL") { 
            $s.= " AND identifica LIKE '%" . str_replace(" ","%",$_GET['identifica']) ."%' ";
        }
        $sql = "SELECT * FROM persona WHERE 1 $s ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Persona("persona", "id", true);
$f->$accion();
?>