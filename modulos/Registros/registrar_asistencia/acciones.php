<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmtipo', 'Tipo Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmevento', 'Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmagenda', 'Agenda', array('required' => true, 'maxLength' => 30) );
       $v->addRules('txtdocumento', 'Documento', array('required' => true) );
           $v->addRules('cbminstitucion', 'Institucion', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmdependencia', 'Dependencia', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmfuncion', 'Funcion', array('required' => true, 'maxLength' => 30) );
	

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
                FROM   general.persona p
                WHERE p.id = '$_GET[txtidentificacion]'";
       $db = $this->db;
       $rs=$db->query($sql);
       $n=0;

 while ($row=$db->fetch_assoc($rs))
        {$n++;}

        $r=array();
        $r['nombre'] = $n;
        echo json_encode($r);
    }
function cargarEventos() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipo]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }
    function cargarDependencia() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM dependencia WHERE institucion_id='$_POST[cbminstitucion]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }
    function cargarInstitucion() {
        $db = $this->db;
        $sql = "SELECT * FROM institucion ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

function RegistrarInstitucion()
{

 $v = new Validation($_POST);
        $v->addRules('nombre_institucion', 'Nombre Institucion', array('required' => true, 'maxLength' => 100) );
       
        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
           // return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        //return true;
        $sql="INSERT INTO institucion (nombre) VALUES('$_POST[nombre_institucion]')";

$db=$this->db;
$db->query($sql);

        $result=array();
        $result["error"] = false;
        $result["msg"] = "Registrado con exito"; 
        echo json_encode($result);


}
function RegistrarDependencia()
{

 $v = new Validation($_POST);
        $v->addRules('institucion_id', 'Institucion', array('required' => true, 'maxLength' => 100) );
         $v->addRules('nombre_dependencia', 'Nombre Dependencia', array('required' => true, 'maxLength' => 100) );
       
        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
           // return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        //return true;
 $sql="INSERT INTO dependencia (nombre,institucion_id) VALUES('$_POST[nombre_dependencia]','$_POST[institucion_id]')";

$db=$this->db;
$db->query($sql);

        $result=array();
        $result["error"] = false;
        $result["msg"] = "Registrado con exito, seleccione institucion"; 
        echo json_encode($result);


}

function cargarAgendas() {
        $db = $this->db;

$s='SELECT CURDATE() AS fecha,CURTIME() as hora';
$rs=$db->query($s);
$rw=$db->fetch_assoc($rs);


$f=$rw['fecha'];



$s= "SELECT a.id as codigo,a.tema,a.h_inicia,a.h_termina,CONCAT_WS(' ',p.nombre,p.apellido1,p.apellido2) as nombre
FROM agenda a, general.persona p
WHERE a.acto_id='$_POST[cbmevento]' and p.id=a.exponente and a.fecha='$f'
GROUP BY codigo";
 
//$db = $this->db;
//$combo="<option value='0'> No aplica </option>";



$r = $db->query($s);

while ($rw=$db->fetch_assoc($r))
{

$r2=$db->query("SELECT * from horas");
$rw2=$db->fetch_assoc($r2);

while ($rw2=$db->fetch_assoc($r2) /* paso los datos de $r a $rt (rtable) */)
{
    
if ($rw2['id']==$rw['h_inicia'])
{
  $inicia=$rw2['conversion'];
}
if ($rw2['id']==$rw['h_termina'])
{
  $fin=$rw2['conversion'];
}

}
//$combo.=" <option value='$rw[codigo]'>TEMA: $rw[tema] HORA: $inicia á $fin EXPONENTE : ( $rw[nombre] )</option>";
$combo.=" <option value='$rw[codigo]'>TEMA: $rw[tema] HORA: $inicia á $fin</option>";

}

        //$datos = $db->select_all($sql);
        echo json_encode($combo);
    }
function listarPersonas() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
    }
    function registrar() {
        $this->validar();
        
$db=$this->db;

$evento=$_POST['cbmevento'];
$tipo_evento=$_POST['cbmtipo'];
$agenda_evento=$_POST['cbmagenda'];
$dependencia=$_POST['cbmdependencia'];
$funcion=$_POST['cbmfuncion'];
$user_registra=$_SESSION['persona_id'];
$usuario=$_POST['persona_id'];


   $criterio="asistencia";
    $criterio2="agenda_id";
    $inser=$agenda_evento;

     $sql="SELECT * FROM asistencia
    WHERE persona_id='$usuario' AND
dependencia_id ='$dependencia' AND
funcion_id     ='$funcion' AND
agenda_id        ='$agenda_evento'";
 $r=$db->query($sql);

    if ($db->num_rows($r)>0) {
        $result=array();
        $result["error"] = true;
         $result["e"] = 1;
        $result["msg"] = "Usuario ya esta registrado: <br/>1) A la misma agenda  <br/>2) Con Igual Dependencia  <br/>3) Con la misma funcion"; 
        
        echo json_encode($result);
        exit(0);
}
  

$s="INSERT INTO ".$criterio."(
".$criterio2.",
persona_id,
dependencia_id,
funcion_id,
usuario
    )
     VALUES(
    ".$inser.",
    $usuario,
    $dependencia,
    $funcion,
    $user_registra

    )";

$db->query($s);

        $result=array();
        $result["error"] = false;
        $result["msg"] = "Registrado con exito"; 
        echo json_encode($result);
    }



function RegistrarUsuario()
{

    $v = new Validation($_POST);
        $v->addRules('cbmidentificacion', 'Tipo identificación', array('required' => true, 'maxLength' => 30) );
        $v->addRules('txtidentificacion', 'Identificacion', array('required' => true/* ,"integer" => true*/) );
       // $v->addRules('fecha_exp', 'Fecha Expedicion', array('required' => true,"date" => true) );
        //$v->addRules('muni_exp', 'Municipio expedicion', array('required' => true) );
        $v->addRules('txtnombre', 'Nombre', array('required' => true,"letters" => true) );
        $v->addRules('txtp1', 'Primer Apellido', array('required' => true,"letters" => true) );
        //$v->addRules('txtp2', 'Segundo Apellido', array('required' => true,"letters" => true) );
        //$v->addRules('fecha_nac', 'Fecha Nacimiento', array('required' => true,"date" => true) );
        $v->addRules('cbmsexo', 'Sexo', array('required' => true, 'maxLength' => 30) );
        //$v->addRules('muni_naci', 'Municipio Nacimiento', array('required' => true) );

       // $v->addRules('muni_res', 'Municipio Residencia', array('required' => true, 'maxLength' => 30) );
       // $v->addRules('txtdireccion', 'Direccion', array('required' => true) );
        $v->addRules('correo1', 'Correo 1', array('required' => true,"mail" => true) );
    // $v->addRules('correo2', 'Correo 2', array("mail" => true) );
       // $v->addRules('tipotelefono1', 'Tipo Telefono 1', array('required' => true) );
       // $v->addRules('telefono1', 'Telefono 1', array('required' => true /* ,"integer" => true*/) );
      //  $v->addRules('tipotelefono2', 'Tipo Telefono 2', array('required' => true) );
     //$v->addRules('telefono2', 'Telefono 1', array("integer" => true) );

       // $v->addRules('clave1', 'Clave 1', array('required' => true,'minLength' => 6, 'maxLength' => 30) );
        //$v->addRules('clave2', 'Clave 2', array('required' => true,'minLength' => 6, 'maxLength' => 30) );
       // $v->addRules('captcha', 'Texto de la Imagen', array('required' => true) );

        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
           // return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        //return true;

  $error="";

 $sql="SELECT *
                FROM   general.persona p
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
        $result["error"] = true;
        $result["msg"] = $error; 
        echo json_encode($result); 
        exit(0);
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

$direccion ="SIN ESPECIFICAR";

$clave =clave($_POST['txtidentificacion']);

$sexo =$_POST['cbmsexo'];
$fechaexp="30/10/2014";
$fechanacimiento ="30/10/2014";

$municipio_nacimiento='2000';
$municipio_residencia ='2000';
$municipioexp='2000';
$mensaje="
<br/>Registrado con exito , Informar al usuario lo siguiente:
<br/>
<br/>Actualizar Municipio de Nacimiento
<br/>Actualizar Fecha de Nacimiento
<br/>
<br/>Actualizar Municipio de Residencia
<br/>Actualizar direccion
<br/>
<br/>Actualizar Municipio del Documento de Expedicion
<br/>
<br/>Contraseña = Documento
";
$sql="INSERT INTO general.persona(
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
    tag,
    fecha, 
    hash,
    foto
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
        '',
        '$clave',
        '')";

$db = $this->db;
$db->query($sql);

$s="SELECT id FROM general.persona WHERE identifica='$documento'";

$r=$db->query($s);

 while ($row=$db->fetch_assoc($r))
        {$n++;$docu =$row['id'];}
/*
$error= $s;
$error.=$n;
$error.=$docu;*/

//################################################################################################

$correo1 =$_POST['correo1'];

 $sql="INSERT INTO general.email(
    identifica,
    correo
    
    )
     values(

        '$docu',
        '$correo1')";
//$error.= $sql;
$db->query($sql);



}
 

        $result=array();
        $result["error"] = false;
        //$result['cap'] = $_SESSION['cap_code'];
        $result["msg"] = $mensaje; 
        echo json_encode($result); 
    
}

}
$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>