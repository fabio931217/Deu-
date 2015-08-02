<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmevento', 'Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmtipodiseño', 'Tipo Diseño', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmobjeto', 'Tipo Objeto', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmfuncion', 'Funcion Persona', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmtipo', 'Tipo', array('required' => true) );

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


function cargarEventos()
{
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipo]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

function aceptar() {
        $this->validar();
        
        //PONER CODIGO AQUI
$acto=$_POST['cbmevento'];
$cod_diseno=$_POST['cbmtipodiseño'];
$funcion=$_POST['cbmfuncion'];
$imagen=$_POST['file-input'];
$objeto=$_POST['cbmobjeto'];

if ($cod_diseno==2)
{
    $v = new Validation($_POST);
       $v->addRules('archivo', 'Archivo', array('required' => true) );

        $result = $v->validate();

        if ($result['messages'] == "")
        {//No hay errores de validacion
            //return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
}


    $sql="INSERT INTO certificado_escarapela(cod_acto,cod_diseno,imagen,cod_funcion,cod_objeto)
         VALUES ()";
        
        $result=array();
        $result["error"] = true;
        $result["msg"] = $tamano; 
        echo json_encode($result);


}
}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>