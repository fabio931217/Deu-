<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('txtdirigido', 'Dirigido', array('required' => true, 'maxLength' => 30) );
		$v->addRules('txtasunto', 'Asunto', array('required' => true) );
		$v->addRules('txtnombre', 'Nombre', array('required' => true) );
		$v->addRules('txtcorreo', 'Correo', array('required' => true,"mail" => true) );
		$v->addRules('txtdescripcion', 'Descripcion', array('required' => true) );

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


    function aceptar() {
        $this->validar();
        
        $dirigo=$_POST['txtdirigo'];
        $asunto=$_POST['txtasunto'];
        $nombre=$_POST['txtnombre'];
        $descripcion=$_POST['txtdescripcion'];
        $correo=$_POST['txtcorreo'];


        $sql="INSERT INTO contactar(asunto, nombre, correo, mensaje,fecha_respuesta, estado)
        VALUES ('$asunto','$nombre','$correo','$descripcion','','1')";

         $db = $this->db;
         $db->query($sql);



        $result=array();
        $result["error"] = false;
        $result["msg"] = "Datos guardados con exito"; 
        echo json_encode($result);
    }

}
$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>