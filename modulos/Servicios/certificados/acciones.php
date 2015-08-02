<?php
require_once("php/tcpdf/tcpdf.php");
//require_once("php/tcpdf_reporte.php");
require_once("php/encabezado_documento.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmcertificado', 'Buscar certificado', array('required' => true) );

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
function listarCertificados() {
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
        $this->validar();
        
        //PONER CODIGO AQUI
        
        $r=array();
        $r['tabla']= '<tr>
             <td>12</td>
            <td>2014 2</td>
            <td>Ponente 2</td>
            <td>Carrasquilla 2</td>
            <td><div class="arrow"></div></td>
        </tr> ';
        echo json_encode($r);

        /*
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);*/
    }

function mostrar() 
{
     
$db=$this->db;

     
     $agendaid=$_POST['idagenda'];

$s="SELECT r.id,ag.acto_id,r.fecha_hora,r.funcion_id as funcion_id,f.nombre as funcion, CONCAT_WS(' : ',i.nombre,d.nombre) as dependencia 
FROM asistencia r,funcion f,dependencia d,institucion i,agenda ag 
WHERE f.codigo=r.funcion_id and ag.id=r.agenda_id and d.id=r.dependencia_id and d.institucion_id=i.codigo and r.id='$agendaid' and r.persona_id='$_SESSION[persona_id]'";
//echo $s;
$r=$db->query($s);
$rw=$db->fetch_assoc($r);

    $funcion=$rw['funcion'] ;
    $funcion_id=$rw['funcion_id'] ;
    $dependencia=$rw['dependencia'];

     $evento=$_POST['idacto']  ;
     $objeto=1; 
     $id=$_SESSION['persona_id'] ;
     $fondo=0;
   

if ($objeto==1) // si es certificado
{
    

$sql="SELECT * FROM certificado_escarapela WHERE cod_acto='$evento' and cod_diseno='2' and cod_objeto='$objeto' and cod_funcion='$funcion_id'";

$r=$db->query($sql);

if ($db->num_rows($r)>0)
{
    //certificado propio
$rw=$db->fetch_assoc($r);

$imagen=$rw['imagen'];
            if ($fondo==1) {
                $imagen="";
            }
    $this->certificado_propio($id,$evento,$funcion_id,$imagen);

}
else
{
   // echo "certificado predeterminad";
     $this->certificado_predeterminados($id,$evento,$funcion_id,$imagen,$dependencia);
}


}

   
}




function certificado_propio($id,$evento,$funcion,$imagen)
{
  ini_set('memory_limit', '512M'); //Amplá la capacidad de memoria. Importante cuando se generan archivos muy pesados
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


 $sql="SELECT p.identifica,p.tipoide, CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre,t.nombre as tipo_identifica
 FROM general.persona p, general.tipoidentificacion t
 WHERE p.tipoide=t.codigo and p.id='$id'";

/*
$sql="SELECT count(*) AS total, p.identifica, p.tipoide as tipo_identifica, CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
 FROM agenda ag, asistencia a, general.persona p WHERE p.id=a.persona_id and ag.id=a.agenda_id and ag.acto_id='$evento'
 GROUP BY p.identifica";
 */
/*
$sql = "SELECT
p.identifica,
t.nombre as tipo_identifica,
CONCAT_WS('',p.nombre,' ',p.apellido1,' ',p.apellido2) as nombre
FROM agenda ag, asistencia a, general.persona  p,general.tipoidentificacion t
WHERE 
p.id=a.persona_id
and a.persona_id!='47934'
and a.persona_id!='47960'
and p.tipoide='TI'
and a.funcion_id='2'
and ag.id=a.agenda_id
and p.tipoide=t.codigo
and ag.acto_id='$evento'
GROUP BY p.identifica
ORDER BY nombre";
*/
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

$pdf->ezText("<b>$nombre</b>",28,array('justification'=>'center'));
if ($funcion=='2') {
  $pdf->ezText("<b>Con $tipo_documento  </b>Numero $numero_documento \n\n",18,array('justification'=>'center'));

}
//$pdf->ezNewPage();


//$pdf->ezText("\n\n\n", 20);
//$pdf->ezText("<b>                 $nombre                   $nombre </b>",18,array('justification'=>'left'));

}
 ob_end_clean();

$pdf->ezStream();
}


//CERTIFICADOS Y ESCARAPELAS PREDETERMINADOS

function certificado_predeterminados($id,$evento,$funcion,$imagen,$dependencia)
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
$sql ="SELECT nombre FROM funcion WHERE codigo='$funcion'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$funcion=utf8_decode($rw['nombre']);


$sql ="SELECT nombre FROM acto WHERE id='$evento'";
$db=$this->db;
$rs = $db->query($sql);
$rw  = $db->fetch_assoc($rs);
$nombre_evento=utf8_decode($rw['nombre']);

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
        $fecha = strftime("%A %d de %B del %Y - %H:%M:%S");
        $fecha2 = strtoupper($fecha);
$dependencia1=explode(":", $dependencia);

  

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
         cumpliendo la funcion de <b><?php echo $funcion ?></b>, de parte de la institucion <b><?php echo $dependencia1[0].":".$dependencia1[1] ?></b> del programa de <b><?php echo $dependencia1[2] ?></b>.
                 
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


<?php

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
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>