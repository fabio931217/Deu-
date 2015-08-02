<?php
session_start();
require_once("php/Encryptar.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmidentificacion', 'Tipo identificación', array('required' => true, 'maxLength' => 30) );
		$v->addRules('txtidentificacion', 'Identificacion', array('required' => true) );
		$v->addRules('fecha_exp', 'Fecha Expedicion', array('required' => true,"date" => true) );
		$v->addRules('muni_exp', 'Municipio expedicion', array('required' => true) );
		$v->addRules('txtnombre', 'Nombre', array('required' => true,"letters" => true) );
		$v->addRules('txtp1', 'Primer Apellido', array('required' => true,"letters" => true) );
		$v->addRules('txtp2', 'Segundo Apellido', array('required' => true,"letters" => true) );
		$v->addRules('fecha_nac', 'Fecha Nacimiento', array('required' => true,"date" => true) );
		$v->addRules('cbmsexo', 'Sexo', array('required' => true, 'maxLength' => 30) );
		$v->addRules('muni_naci', 'Municipio Nacimiento', array('required' => true) );

        $v->addRules('muni_res', 'Municipio Residencia', array('required' => true, 'maxLength' => 30) );
        $v->addRules('txtdireccion', 'Direccion', array('required' => true) );
        $v->addRules('correo1', 'Correo 1', array('required' => true,"mail" => true) );
     $v->addRules('correo2', 'Correo 2', array("mail" => true) );
        $v->addRules('tipotelefono1', 'Tipo Telefono 1', array('required' => true) );
        $v->addRules('telefono1', 'Telefono 1', array('required' => true /* ,"integer" => true*/) );
               $v->addRules('cbmpregunta', 'Pregunta Secreta', array('required' => true, 'maxLength' => 30) );
          $v->addRules('respuesta', 'Respuesta', array('required' => true, 'maxLength' => 30) );

      //  $v->addRules('tipotelefono2', 'Tipo Telefono 2', array('required' => true) );
     //$v->addRules('telefono2', 'Telefono 1', array("integer" => true) );

        $v->addRules('clave1', 'Clave 1', array('required' => true,'minLength' => 6, 'maxLength' => 30) );
        $v->addRules('clave2', 'Clave 2', array('required' => true,'minLength' => 6, 'maxLength' => 30) );
        $v->addRules('captcha', 'Texto de la Imagen', array('required' => true) );

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
function verificar_usuario() {

        $sql="SELECT *
                FROM   persona p
                WHERE p.identifica = '$_GET[txtidentificacion]'";
       $db = $this->db;
       $rs=$db->query($sql);
       $n=0;

 while ($row=$db->fetch_assoc($rs))
        {$n++;}

        $r=array();
        $r['nombre'] = $n;
        echo json_encode($r);
    }


    function aceptar() {

        $this->validar();
   /*  
     echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; */

//inicia el mani para registrar
$error="";

 $sql="SELECT *
                FROM  persona p
                WHERE p.identifica = '$_POST[txtidentificacion]'";
       $db = $this->db;
       $rs=$db->query($sql);
       $n=0;

 while ($row=$db->fetch_assoc($rs))
        {$n++;}

if($n>0)
{
    $error.="Usuario ya existe";
        $result=array();
        $result["error"] = false;
        $result["msg"] = $error; 
        echo json_encode($result); 
        exit(0);
}

        if($_POST['clave1'] != $_POST['clave2'])
        {
             $error.= "las claves no son iguales\n";
             
        }


$cap = 'notEq';
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Verificamos si el captcha es correcto
    if (strtolower($_POST['captcha']) == $_SESSION['cap_code']) {
        
        // "Imagen de verificacion correcta";
        $cap = 'Eq';
       
    } 
    else 
    {
        

        $error.= " Imagen de verificacion incorrecta\n";
        $cap = '';

$ranStr = md5(microtime()); 
$ranStr = substr($ranStr, 0, 6);
//le asigno a la session el valor de mi captcha
$_SESSION['cap_code'] = $ranStr;

    }
  }

if($error=="")
{

  //PONER CODIGO AQUI
$error=1; 

$tipodocumento =$_POST['cbmidentificacion'];
$documento =$_POST['txtidentificacion'];

$nombre =$_POST['txtnombre'];

$nom=explode(" ", $nombre);
$nombre1=$nom[0];
$nombre2=$nom[1];

$apellido1 =$_POST['txtp1'];
$apellido2 =$_POST['txtp2'];

$direccion =$_POST['txtdireccion'];

$tipotele1=$_POST['tipotele1'];
$telefono1 =$_POST['telefono1'];

$tipotele2=$_POST['tipotele2'];
$telefono2 =$_POST['telefono2'];


$clave =Encrypter::encrypt($_POST['clave1']);

$sexo =$_POST['cbmsexo'];
$fechaexp=$_POST['fecha_exp'];
$fechanacimiento =$_POST['fecha_nac'];
$pregunta =$_POST['cbmpregunta'];
$respuesta=Encrypter::encrypt($_POST['respuesta']);
$municipio_nacimiento=$_POST['muni_naci'];
$municipio_residencia =$_POST['muni_res'];
$municipioexp=$_POST['muni_exp'];

$sql="INSERT INTO persona(
    identifica,
    fechaexp,
    tipoide,
    municipioexp,
    apellido1,
    apellido2,
    nombre,
    nombre1,
    nombre2,
    fechanaci,
    sexo, 
    municipionaci,
    direccion,
    municipiores, 
    clave,
    fecha, 
    hash,
    foto,
    cod_pregunta,
    respuesta
         )
     values(
        '$documento',
        '$fechaexp',
        '$tipodocumento',
        '$municipioexp',
        '$apellido1',
        '$apellido2',
        '$nombre',
        '$nombre1',
        '$nombre2',
        '$fechanacimiento',
        '$sexo',
        '$municipio_nacimiento',
        '$direccion',
        '$municipio_residencia',
        '$clave',
        '',
        '$clave',
        '',
        '$pregunta',
        '$respuesta')";

echo $sql;
$db = $this->db;
$db->query($sql);

$s="SELECT id FROM persona WHERE identifica='$documento'";

$r=$db->query($s);

 while ($row=$db->fetch_assoc($r))
        {$n++;$docu =$row['id'];}
/*
$error= $s;
$error.=$n;
$error.=$docu;*/

//################################################################################################

$correo1 =$_POST['correo1'];
$correo2 =$_POST['correo2'];

 $sql="INSERT INTO email(
    identifica,
    correo
    
    )
     values(

        '$docu',
        '$correo1')";
//$error.= $sql;
$db->query($sql);

if(!empty($correo2))
{
   
$s="INSERT INTO email(
    identifica,
    correo
    
    )
     values(

        '$docu',
        '$correo2')";
       $db->query($s);

}

//##########################################################
$tipotele1 =$_POST['tipotelefono1'];
$telefono1 =$_POST['telefono1'];

$tipotele2 =$_POST['tipotelefono2'];
$telefono2 =$_POST['telefono2'];

 $s="INSERT INTO telefonos(
    identifica,
    numero,
    ubicacion
    
    )
     values(

        '$docu',
        '$telefono1',
        '$tipotele1')";
//$error.= $s;
$db->query($s);

if(!empty($telefono2) && !empty($tipotele2) )
{
   
$s="INSERT INTO telefonos(
    identifica,
    numero,
    ubicacion
    
    )
     values(

        '$docu',
        '$telefono2',
        '$tipotele2')";
 $db->query($s);       

}

}
 

        $result=array();
        $result["error"] = false;
        $result['cap'] = $_SESSION['cap_code'];
        $result["msg"] = $error; 
        echo json_encode($result); 
    }

}
$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>