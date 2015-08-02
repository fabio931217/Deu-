<?php
require_once("php/Encryptar.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
	
        $v->addRules('cbmidentificacion', 'Tipo identificación', array('required' => true, 'maxLength' => 30) );
        $v->addRules('txtidentificacion', 'Identificacion', array('required' => true,"integer" => true) );
        $v->addRules('fecha_exp', 'Fecha Expedicion', array('required' => true,"date" => true) );
        $v->addRules('muni_exp', 'Municipio expedicion', array('required' => true) );
        $v->addRules('txtnombre', 'Nombre', array('required' => true,"letters" => true) );
        $v->addRules('txtp1', 'Primer Apellido', array('required' => true,"letters" => true) );
        $v->addRules('txtp2', 'Segundo Apellido', array('required' => true,"letters" => true) );
        $v->addRules('fecha_nac', 'Fecha Nacimiento', array('required' => true,"date" => true) );
        $v->addRules('cbmsexo', 'Sexo', array('required' => true, 'maxLength' => 30) );
        $v->addRules('muni_naci', 'Municipio Nacimiento', array('required' => true) );
          $v->addRules('cbmpregunta', 'Pregunta Secreta', array('required' => true, 'maxLength' => 30) );
          $v->addRules('respuesta', 'Respuesta', array('required' => true, 'maxLength' => 30) );
        $v->addRules('muni_res', 'Municipio Residencia', array('required' => true, 'maxLength' => 30) );
        $v->addRules('txtdireccion', 'Direccion', array('required' => true) );
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


    function actualizar() {
        $this->validar();
        $db = $this->db;

$documento =$_SESSION['usuario'];

$nombre =$_POST['txtnombre'];
$apellido1 =$_POST['txtp1'];
$apellido2 =$_POST['txtp2'];
$sexo =$_POST['cbmsexo'];

$fechaexp=$_POST['fecha_exp'];
$municipio_exp=$_POST['muni_exp'];

$fechanacimiento =$_POST['fecha_nac'];
$municipio_nacimiento=$_POST['muni_naci'];

$municipio_residencia =$_POST['muni_res'];
$direccion =$_POST['txtdireccion'];
$pregunta =$_POST['cbmpregunta'];

$respuesta=Encrypter::encrypt($_POST['respuesta']);

$nombre_division=(explode(" ", $nombre));
    $nombre1=$nombre_division[0];
    $nombre2=$nombre_division[1];

$sql="UPDATE persona SET
 fechaexp='$fechaexp',
 municipioexp='$municipio_exp',
 apellido1='$apellido1',
 apellido2='$apellido2',
 nombre='$nombre',
 nombre1='$nombre1',
 nombre2='$nombre2',
 fechanaci='$fechanacimiento',
 sexo='$sexo',
 municipionaci='$municipio_nacimiento',
 direccion='$direccion',
 municipiores='$municipio_residencia', 
 cod_pregunta='$pregunta',
 respuesta='$respuesta'
 
  WHERE identifica='$documento'";

$db->query($sql);
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "Actualizado con exito."; 
        echo json_encode($result);
    }

}
$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>