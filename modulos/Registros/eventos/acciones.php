<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmcertificado', 'Buscar certificado', array('required' => true, 'maxLength' => 30) );

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
            function comboHoras() {
        $db = $this->db;
        $sql = "SELECT * FROM horas";
        $rs = $db->query($sql);
      
        while ($row=$db->fetch_assoc($rs))
        {
          
            $combo.=" <option value='$row[id]'>$row[conversion]</option>";
                    
        } 
             
        echo json_encode($combo);
    }
        function comboEscenario() {
        $db = $this->db;
        $sql = "SELECT * FROM escenario WHERE estado_id='1'";
        $rs = $db->query($sql);
      
        while ($row=$db->fetch_assoc($rs))
        {
          
            $combo.=" <option value='$row[id]'>$row[nombre]</option>";
                    
        } 
             
        echo json_encode($combo);
    }

function comboFuncion() {
        $db = $this->db;
        $sql = "SELECT * FROM Funcion";
        $rs = $db->query($sql);
      
        while ($row=$db->fetch_assoc($rs))
        {
          
            $combo.=" <option value='$row[codigo]'>$row[nombre]</option>";
                    
        } 
             
        echo json_encode($combo);
    }

    function comboDependencia() {
        $db = $this->db;
        $sql = "SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre";
        $rs = $db->query($sql);
      
        while ($row=$db->fetch_assoc($rs))
        {
          
            $combo.=" <option value='$row[codigo]'>$row[nombre]</option>";
                    
        } 
             
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
    function buscar() {
       // $this->validar();
        
        //PONER CODIGO AQUI

$nombre_evento= $_POST['txtnombre'];
$descripciones=$_POST['descripcion'];
$objetivos= $_POST['objetivos'];
$conclusiones=$_POST['conclusiones'];




$usuario = count($_POST['usuario']);
$funcion = count($_POST['cbmfuncion']);
$dependencia = count($_POST['cbmdependencia']);
$fecha = count($_POST['txtfecha']);
$exponente = count($_POST['txtexponente']);
$tema = count($_POST['txttema']);
$cupos = count($_POST['txtcupos']);

$db = $this->db;
//validar
$e1=0;
$e2=0;
$us=0;
$us2=0;


for($i=0; $i<$usuario; $i++) {

//ACA COLOCAS TU INSERT INTO Y TU VALOR ($valor[$i]) A INSERTAR LO HACES ASI:
    if ($_POST['usuario'][$i]=="" or $_POST['cbmfuncion'][$i]=="" or $_POST['cbmdependencia'][$i]=="" ) {
        $e1+=1;
        
    }else
    {
        $u=explode("-", $_POST['usuario'][$i]); 
        $buscar=  trim($u[0]);

        $s="SELECT id FROM general.persona WHERE identifica='$buscar'";


$r= $db->query($s);

 if($db->num_rows($r)==0)
 {
    $us-=1;
 }

    }
} //FIN FOR

for($i=0; $i<$exponente; $i++) {

//ACA COLOCAS TU INSERT INTO Y TU VALOR ($valor[$i]) A INSERTAR LO HACES ASI:

$hora_inicia =$_POST['txthorainicia'][$i];
$hora_fin=$_POST['txthorafin'][$i];
$fecha= $_POST['txtfecha'][$i];
$escenario= $_POST['cbmescenario'][$i];
$e="";
$n2=$i+1;

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and '$hora_inicia'<=h_inicia and '$hora_fin'>=h_termina";


$r= $db->query($s);

if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA y HORA FIN , estan tomando horas de otro acto : en PROGRAMAR AGENDA NUMERO: $n2 <br/>";}


$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and h_inicia='$hora_inicia' and h_termina='$hora_fin'";


$r= $db->query($s);

if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA y HORA FIN , estan ocupadas por otro acto : en PROGRAMAR AGENDA NUMERO: $n2 <br/>";}

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and '$hora_inicia'>=h_inicia and '$hora_inicia'< h_termina";
//$e.=$s.'<br/>';

$r= $db->query($s);

 if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA, Interfiere con otro acto : en PROGRAMAR AGENDA NUMERO: $n2 <br/>";}

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and h_inicia<'$hora_fin' and '$hora_fin'<=h_termina";
//$e.=$s.'<br/>';
$r= $db->query($s);

 if($db->num_rows($r)>0)
 {$e.="-) HORA FIN, Interfiere con otro acto : en PROGRAMAR AGENDA NUMERO: $n2 <br/>";}

if ($e!="") {
    $result=array();
        $result["error"] = false;
        $result["msg"] = $e; 
        echo json_encode($result); 
        exit(0);
}

if ($hora_fin<=$hora_inicia) {
    $n=$i+1;
   
   $error="-) Hora fin menor ó igual a hora inicia en : PROGRAMAR AGENDA NUMERO: $n </br>\n\n";
        $result=array();
        $result["error"] = false;
        $result["msg"] = $error; 
        echo json_encode($result); 
        exit(0);
}

    if ($_POST['txtfecha'][$i]=="" or $_POST['txttema'][$i]=="" or $_POST['txtexponente'][$i]=="" or $_POST['txtcupos'][$i]=="") {
        $e2+=1;
    }else
    {
        $u=explode("-", $_POST['txtexponente'][$i]); 
        $buscar=  trim($u[0]);

        $s="SELECT id FROM general.persona WHERE identifica='$buscar'";



$r= $db->query($s);

 if($db->num_rows($r)==0)
 {
    $us2-=1;

 }

        
    }


} // FIN FOR  
$error="";
if ($e1>0) {
    $error.= "-) Ingrese los datos completos de los ORGANIZADORES   </br>\n\n";

}
if ($e2>0) {
    $error.= "-) Ingrese los datos completos de las AGENDA(S)   </br>\n\n ";

}
if ($us<0) {
    $error.= "-) Ingrese los datos completos de los USUARIOS EN REGISTRAR ORGANIZADORES, SIN MODIFICAR   </br>\n\n";

}
if ($us2<0) {
    $error.= "-) Ingrese los datos completos de los EXPONENTES EN PROGRAMAR AGENDA, SIN MODIFICAR   </br>\n\n";

}
if ($error!="")
{
$result=array();
        $result["error"] = false;
        $result["msg"] = $error; 
        echo json_encode($result); 
        exit(0);
}
else
{

//INICIA MANI


    $s="INSERT INTO acto(
    nombre,
    descripcion,
    objetivo,
    tipo_id
    )
     values(
        '$nombre_evento',
        '$descripciones',
        '$objetivos',
        '1')";

//echo"$s";
$db->query($s);

//###############################################################################################
$s="SELECT MAX(id) as id FROM acto ";

$r= $db->query($s);

 if($db->num_rows($r))
 {
    $rw=$db->fetch_assoc($r);
    $id_acto =$rw['id'];
    //echo $id_acto;
    
 }

//REGISTRAR ORGANIZADORES
for($i=0; $i<$usuario; $i++) {

//ACA COLOCAS TU INSERT INTO Y TU VALOR ($valor[$i]) A INSERTAR LO HACES ASI:
    if ($_POST['usuario'][$i]=="" or $_POST['cbmfuncion'][$i]=="" or $_POST['cbmdependencia'][$i]=="" ) {
        
    }else

    {


        $u=explode("-", $_POST['usuario'][$i]); 
        $buscar=  trim($u[0]);

        $s="SELECT id FROM general.persona WHERE identifica='$buscar'";


$r=$db->query($s);

 if($db->num_rows($r)>0)
 {
    $rw=$db->fetch_assoc($r);
    $docu =$rw['id'];

        $depe= $_POST['cbmdependencia'][$i];
        $funci= $_POST['cbmfuncion'][$i];
$r=$db->query("SELECT * FROM organizador WHERE acto_id='$id_acto' and dependencia_id='$depe' and persona_id='$docu' and funcion_id='$funci'");

if ($db->num_rows($r)==0)
{
        $s="INSERT INTO organizador(
    acto_id,
    dependencia_id,
    persona_id,
    funcion_id
    )
     values(
        '$id_acto',
        '$depe',
        '$docu',
        '$funci'
        )";

$db->query($s);
}
 }

        
    }

} // FIN FOR


//PROGRAMAR AGENDA
for($i=0; $i<$exponente; $i++) {

//ACA COLOCAS TU INSERT INTO Y TU VALOR ($valor[$i]) A INSERTAR LO HACES ASI:
    if ($_POST['txtfecha'][$i]=="" or $_POST['txttema'][$i]=="" or $_POST['txtexponente'][$i]=="" or $_POST['txtcupos'][$i]=="") {
        
    }else
    {
        $fech =$_POST['txtfecha'][$i];
        $cup= $_POST['txtcupos'][$i];
        $tem =  $_POST['txttema'][$i];
        $inicia= $_POST['txthorainicia'][$i];
        $fin =$_POST['txthorafin'][$i];
        $escenario= $_POST['cbmescenario'][$i];

     
        $u=explode("-", $_POST['txtexponente'][$i]); 
        $buscar=  trim(($u[0]));

        $s="SELECT id FROM general.persona WHERE identifica='$buscar'";


$r=$db->query($s);

 if($db->num_rows($r)>0)
 {
    $rw=$db->fetch_assoc($r);
    $docu =$rw['id'];

        $depe= $_POST['cbmdependencia'][$i];
        $funci= $_POST['cbmfuncion'][$i];

        $s="INSERT INTO agenda(
    acto_id,
    fecha,
    h_inicia,
    h_termina,
    exponente,
    tema,
    cupos,
    escenario_id
    )
     values(
        '$id_acto',
        '$fech',
        '$inicia',
        '$fin',
        '$docu',
        '$tem',
        '$cup',
        '$escenario'
        )";

$db->query($s);

    }
}
} // FIN FOR

$s="INSERT INTO conclusion(
    acto_id,
    contenido
    )
     values(
        '$id_acto',
        '$conclusiones')";

$db->query($s);




        $result=array();
        $result["error"] = false;
        $result["msg"] = 1; 
        echo json_encode($result);
}
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>