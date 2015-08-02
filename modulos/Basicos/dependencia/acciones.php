<?php
require_once("php/formulario_basico.php");
class Dependencia extends formulario_basico {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre', 'Nombre', array('required' => true, 'maxLength' => 100) );
		$v->addRules('alias', 'Alias', array('required' => true, 'maxLength' => 20) );
		$v->addRules('institucion_id', 'Institucion', array('required' => true) );

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
        if ($_GET["institucion_id"] != "" && $_GET["institucion_id"] != "NULL") { 
            $s.= " AND institucion_id = '$_GET[institucion_id]'";
        }
        $sql = "SELECT d.*,i.nombre as institucion FROM dependencia d,institucion i 
        WHERE 1 $s and i.codigo=d.institucion_id and id!='1' ";
        return $sql;
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Dependencia("dependencia", "id", true);
$f->$accion();
?>