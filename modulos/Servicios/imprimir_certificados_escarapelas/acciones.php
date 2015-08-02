<?php
require_once("php/tcpdf/tcpdf.php");
//require_once("php/tcpdf_reporte.php");
require_once("php/encabezado_documento.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmtipoevento', 'Tipo Evento', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmevento', 'Evento', array('required' => true, 'maxLength' => 30) );
        
			$v->addRules('cbmfuncion', 'Funcion', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmobjeto', 'Objeto', array('required' => true, 'maxLength' => 30) );
    $v->addRules('cbmimprimir', 'Imprimir', array('required' => true, 'maxLength' => 30) );

if ($_POST['cbmimprimir']=='0') {
  $v->addRules('txtdocumento', 'Documento', array('required' => true, 'maxLength' => 100) );
}
    

        $result = $v->validate();

        if ($result['messages'] == "")

{//No hay errores de validacion
          
              if ($_POST['cbmimprimir']=='0' and $_POST['cbmobjeto']=='0')
    {
      $sql = "SELECT * FROM agenda ag, asistencia a WHERE 
a.persona_id='$_POST[persona_id]'
and a.funcion_id='$_POST[cbmfuncion]'
and ag.acto_id='$_POST[cbmevento]'
and ag.id=a.agenda_id";

$db=$this->db;
$rs = $db->query($sql);

if ($db->num_rows($rs)==0)
       {
            $r['error'] = true;
            $r['msg'] = "El usuario no cumplio esta funcion en el evento";
            echo json_encode($r);
            exit(0);
        }else{return true;}
      }

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

function cargarDependencias(){

   /*  echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);*/
       
 
       $evento=$_POST['cbmevento'];
       $id_persona=$_POST['persona_id'];

       /* $sql = "SELECT CONCAT_WS(' ',i.nombre,d.nombre) as codigo, CONCAT_WS(' ',i.nombre,d.nombre) as nombre
         FROM dependencia d,institucion i,asistencia a,registro_acto r,agenda ag
         WHERE d.institucion_id=i.codigo and 
          (a.acto_id='$evento' and a.persona_id='$id_persona') or (ag.acto_id='$eventos' and ag.id=r.agenda_id and r.persona_id='$id_persona')
         GROUP BY nombre";*/

      $sql="SELECT CONCAT_WS(' : ',i.nombre,d.nombre) as codigo, CONCAT_WS(' ',i.nombre,d.nombre) as nombre 
         FROM dependencia d,institucion i,asistencia a,agenda ag 
         WHERE d.institucion_id=i.codigo and  (ag.acto_id='$evento' and ag.id=a.agenda_id and a.persona_id='$id_persona' and d.id=a.dependencia_id)
          GROUP BY nombre";

             $db = $this->db;
       $r = $db->query($sql);

while ($rw=$db->fetch_assoc($r))
{
$datos.=" <option value='$rw[codigo]'>$rw[nombre]</option>";
}
        echo json_encode($datos);

    }
function cargarEventos()
{
           $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipoevento]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

    function mostrar() 
{
     
$db=$this->db;

     $evento=$_POST['cbmevento']  ;
     $funcion=$_POST['cbmfuncion'] ;
     $objeto=$_POST['cbmobjeto'] ; 
     $id=$_POST['persona_id']  ;
     $fondo=$_POST['fondo_imagen'];
     $dependencia=$_POST['cbmdependencia'];
     $imprimir=$_POST['cbmimprimir'];
if ($objeto==1) // si es certificado
{
     
    

$sql="SELECT * FROM certificado_escarapela WHERE cod_acto='$evento' and cod_diseno='2' and cod_objeto='$objeto' and cod_funcion='$funcion'";


$r=$db->query($sql);

if ($db->num_rows($r)>0)
{
    //certificado propio
$rw=$db->fetch_assoc($r);

$imagen=$rw['imagen'];
            if ($fondo==1) {
                $imagen="";
            }

    $this->certificado_propio($id,$evento,$funcion,$imagen,$imprimir);

}
else
{
   // echo "certificado predeterminad";
     $this->certificado_predeterminados($id,$evento,$funcion,$imagen,$dependencia,$imprimir);
}


}
elseif ($objeto==2) // si es escarapela
{



$sql="SELECT * FROM certificado_escarapela WHERE cod_acto='$evento' and cod_diseno='2' and cod_objeto='$objeto' and cod_funcion='$funcion'";

$r=$db->query($sql);

if ($db->num_rows($r)>0)
{
    $rw=$db->fetch_assoc($r);

$imagen=$rw['imagen'];
      
      if ($fondo==1) {
                $imagen="";
            }

     
            $this->escarapela($id,$evento,$funcion,$imagen,$dependencia,$imprimir);
    
    

}
else
{
                  $imagen="img/asistente_predeterminado.jpg";
                    if ($fondo==1) {
                $imagen="";
            }
             $this->escarapela($id,$evento,$funcion,$imagen,$dependencia,$imprimir);
   
}




}



        
 
}


function escarapela($id,$evento,$funcion,$imagen,$dependencia,$imprimir)
{
  ini_set('memory_limit', '2024M'); //Amplá la capacidad de memoria. Importante cuando se generan archivos muy pesados
set_time_limit(0); //Libera la capacidad del tiempo de respuesta
ob_start(); // al inicio

require_once('php/class.ezpdf.php');
require_once('php/class.backgroundpdf.php'); 

$pdf = new backgroundPDF('c7', 'portrait', 'image', array('img' => "$imagen"));   
//$pdf =new Cezpdf('c7');
$pdf->selectFont('fonts/Helvetica-Bold.afm'); 
$pdf->ezSetCmMargins(1,0,1,0.5);

$sql ="SELECT nombre FROM acto WHERE id='$evento'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$nombre_evento=utf8_decode($rw['nombre']);

  
$funcion2=$funcion;
$sql ="SELECT nombre FROM funcion WHERE codigo='$funcion'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$funcion=utf8_decode($rw['nombre']);

if ($imprimir==0) 
{

$sql="SELECT p.foto, p.identifica,p.tipoide,CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre,t.nombre as tipo_identifica
 FROM general.persona p, general.tipoidentificacion t
 WHERE p.tipoide=t.codigo and p.id='$id'  ";

}
else
{
  $sql = "SELECT
i.nombre as institucion,d.nombre as dependencia,f.nombre as funcion,
p.identifica,p.foto,
t.nombre as tipo_identifica,
CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
FROM agenda ag, asistencia a, general.persona  p,general.tipoidentificacion t,institucion i, dependencia d,funcion f
WHERE 
p.id=a.persona_id
and a.dependencia_id=d.id and i.codigo=d.institucion_id
and ag.id=a.agenda_id
and p.tipoide=t.codigo
and a.funcion_id='$funcion2'
and ag.acto_id='$evento'
GROUP BY p.identifica
ORDER BY nombre";
}
$db=$this->db;
$rs = $db->query($sql);

while ($rw  = $db->fetch_assoc($rs)) 
{

$nombre=utf8_decode($rw['nombre']);
$apellido=utf8_decode($rw['apellido1']." ".$rw['apellido2']);
$tipo_documento=utf8_decode($rw['tipoide']);
$numero_documento=utf8_decode($rw['identifica']);
if ($imprimir==0)
{
 $dependencia=utf8_decode($dependencia); 
}else
{
$dependencia=utf8_decode($rw['dependencia']);
}

$foto=$rw['foto'];

if ($foto=="" or $foto==NULL) {
  $foto="img/usuario.jpg";
}

$pdf->ezImage("$foto",40,90,"none",left,2);
$pdf->ezText("<b>$funcion</b>",12,array('justification'=>'center'));
$pdf->ezText("\n\n\n", 1);
$pdf->ezText("<b>$nombre_evento</b>",6,array('justification'=>'center'));
$pdf->ezText("\n\n\n", 6);

$pdf->ezText("<b>$nombre</b>",12,array('justification'=>'left'));

$pdf->ezText("\n\n\n", 1);
$pdf->ezText("<b>$apellido</b>",12,array('justification'=>'left'));



$pdf->ezText("\n\n\n", 5);
$pdf->ezText("<b>$dependencia</b>\n\n",7,array('justification'=>'left'));
if ($imprimir==1)
{
  $pdf->ezNewPage(); 
}

}
 ob_end_clean();

$pdf->ezStream();


}


function certificado_propio($id,$evento,$funcion,$imagen,$imprimir)
{
  ini_set('memory_limit', '2024M'); //Amplá la capacidad de memoria. Importante cuando se generan archivos muy pesados
set_time_limit(0); //Libera la capacidad del tiempo de respuesta


            ob_start();

//$imagen="";
require_once('php/class.ezpdf.php');
require_once('php/class.backgroundpdf.php'); 
 
$pdf = new backgroundPDF('Carta', 'landscape', 'image', array('img' => "$imagen"));  
$pdf->selectFont('fonts/Helvetica-Bold.afm'); 

// arriba,abajo,izquierda,derecha
if ($funcion=='2') {
  $pdf->ezSetCmMargins(9.5,8,4,3); 
}else
{
$pdf->ezSetCmMargins(8.5,8,4,3); }

if ($imprimir==0) 
{
 $sql="SELECT p.identifica,p.tipoide, CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre,t.nombre as tipo_identifica
 FROM general.persona p, general.tipoidentificacion t
 WHERE p.tipoide=t.codigo and p.id='$id'";
  
}

else
{

 /* $sql="SELECT count(*) AS total, p.identifica, p.tipoide as tipo_identifica, CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
 FROM agenda ag, asistencia a, general.persona p WHERE p.id=a.persona_id and ag.id=a.agenda_id and ag.acto_id='$evento'
 GROUP BY p.identifica";
 */

$sql = "SELECT
p.identifica,
t.nombre as tipo_identifica,
CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
FROM agenda ag, asistencia a, general.persona  p,general.tipoidentificacion t
WHERE 
p.id=a.persona_id
/* and a.persona_id!='47934'
and a.persona_id!='47960' 
and p.tipoide='TI'
and a.funcion_id='2' */
and ag.id=a.agenda_id
and p.tipoide=t.codigo
and a.funcion_id='$funcion'
and ag.acto_id='$evento'
GROUP BY p.identifica
ORDER BY nombre";
}

$db=$this->db;
$rs = $db->query($sql);

/*$rw  = $db->fetch_assoc($rs);

$nombre=utf8_decode($rw['nombre']);
$tipo_documento=$rw['tipo_identifica'];
$numero_documento=$rw['identifica'];
*/

while ($rw  = $db->fetch_assoc($rs)) 
{
 $nombre=utf8_decode($rw['nombre']);
$tipo_documento=$rw['tipo_identifica'];
$numero_documento=$rw['identifica'];

//$pdf->ezText("\n\n\n", 55);

$pdf->ezText("<b>$nombre $imprimir</b>",28,array('justification'=>'center'));
if ($funcion=='2') {
  $pdf->ezText("<b>Con $tipo_documento  </b>Numero $numero_documento \n\n",18,array('justification'=>'center'));

}

if ($imprimir==1)
 {
  $pdf->ezNewPage();
}


//$pdf->ezText("\n\n\n", 20);
//$pdf->ezText("<b>                 $nombre                   $nombre </b>",18,array('justification'=>'left'));

}
 ob_end_clean();

$pdf->ezStream();
}


//CERTIFICADOS Y ESCARAPELAS PREDETERMINADOS

function certificado_predeterminados($id,$evento,$funcion,$imagen,$dependencia,$imprimir)
{
require_once('php/tcpdf/config/lang/eng.php');

ini_set('memory_limit', '512M'); //Amplá la capacidad de memoria. Importante cuando se generan archivos muy pesados
set_time_limit(0); //Libera la capacidad del tiempo de respuesta

ob_start();
/*
echo "<pre>";
    print_r($_POST);
    echo "</pre>"; 
*/

$sql ="SELECT nombre FROM acto WHERE id='$evento'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$nombre_evento=utf8_decode($rw['nombre']);

    if ($imprimir==0)
    {
      
$funcion2=$funcion;
$sql ="SELECT nombre FROM funcion WHERE codigo='$funcion'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$funcion=utf8_decode($rw['nombre']);



$sql="SELECT p.identifica,p.tipoide, CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre,t.nombre as tipo_identifica
 FROM general.persona p, general.tipoidentificacion t
 WHERE p.tipoide=t.codigo and p.id='$id'";

$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);

$nombre=utf8_decode($rw['nombre']);
$tipo_documento=$rw['tipo_identifica'];
$numero_documento=$rw['identifica'];

//$this->SetFont('times', '', 10);
      

  
$sql="SELECT i.nombre as institucion,d.nombre as dependencia FROM institucion i, dependencia d,agenda ag, asistencia a WHERE a.persona_id='$id' and a.funcion_id='$funcion2' and ag.acto_id='$evento' and ag.id=a.agenda_id and a.dependencia_id=d.id and i.codigo=d.institucion_id";
}
else
{
  $sql = "SELECT
i.nombre as institucion,d.nombre as dependencia,f.nombre as funcion,
p.identifica,
t.nombre as tipo_identifica,
CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
FROM agenda ag, asistencia a, general.persona  p,general.tipoidentificacion t,institucion i, dependencia d,funcion f
WHERE 
p.id=a.persona_id
and a.dependencia_id=d.id and i.codigo=d.institucion_id
and ag.id=a.agenda_id
and p.tipoide=t.codigo
and a.funcion_id='$funcion'
and ag.acto_id='$evento'
GROUP BY p.identifica
ORDER BY nombre";
}

 $fecha = strftime("%A %d de %B del %Y - %H:%M:%S");
        $fecha2 = strtoupper($fecha);
$db=$this->db;
$rs = $db->query($sql);
//echo $sql;
while ($rw  = $db->fetch_assoc($rs)) 
{
 $dependencia= $rw['dependencia'];
  $institucion= $rw['institucion'];
  if ($imprimir==1) {
     $nombre=utf8_decode($rw['nombre']);
$tipo_documento=$rw['tipo_identifica'];
$numero_documento=$rw['identifica'];
        $funcion=$rw['funcion'];
  }

?>

<table border="0" align="center" >
    <tr style="background-image: url('../img/logo.png');">
        <td colspan="3" style="width:460px;text-align:justify;font-size:13px;">
        <br/>
        <br/>
        <br/>

        El Jefe de la oficina de Registro y Control Académico,
        <br/>
        <br/>

        <p align="center" style="font-size:20px;font-weight:bold" >
       CERTIFICA:
       </p>
        <br/>
        
        Que, revisados los registros de esta institución de educación superior, se pudo certificar que <b><?php echo $nombre ?></b>, identifificado(a) con la <b><?php echo $tipo_documento ?> </b> número<b> <?php echo $numero_documento ?> </b>, asistio al acto <b><?php echo $nombre_evento ?> </b>
         cumpliendo la funcion de <b><?php echo $funcion ?></b>, de parte de la institucion <b><?php echo $institucion ?></b> del programa de <b><?php echo $dependencia ?></b>.
                 
        <br/>
        <br/>
        <br/>
        <br/>
        Quibdó, <b><?php echo $fecha2 ?> </b>
       
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <b>JOSE DE LOS SANTOS RENTERÍA CÓRDOBA</b>
        
        
        
        </td>
    </tr>
    


</table>

<br/><br/><br/><br/><br/><br/>
<br/><br/><br/><br/><br/><br/>


<?php
}
$html = ob_get_contents(); //Pasa el contenido html anterior a una variable
ob_end_clean(); //Limpiar los datos anterios 

/*$formato=$_POST['formato'];
$formato="pdf";
if($formato=="excel")
{
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename={$nombre_archivo}.xls;");
    echo $html;
}


if($formato=="word")
{
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename={$nombre_archivo}.doc;");
    echo $html; 
}


if($formato=="html")
{ 
    echo $html; 
}


if($formato=="pdf")
{   }*/ 
    //$p->NewPage();
    $p = new TCPDF_REPORTE("P", "pt", "LETTER", true);
    $p->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $p->SetMargins(85,100,55);// margenes de izquierda, arriba y abajo
    $p->setFooterMargin (30);   
    
    $p->setPrintHeader(true);
    $p->setPrintFooter(true);
    
    $p->SetDrawColorArray( array(50,50,50) );
     
    $p->SetDisplayMode(100);
    $p->SetAutoPageBreak(TRUE,40);
    
    $p->AddPage();
    $p->SetFont("times","",10);
    $p->writeHTML($html, true, 0, true, 0); 
    $p->Output("documento.pdf"); 


}

}
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>