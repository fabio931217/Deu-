<?php

class Formulario extends Base {
    
function listarEventos() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

$sql="SELECT a.id , CONCAT_WS('',a.nombre,' : ',ag.fecha, ' [',t.nombre,']') as text
 FROM acto a,tipo t,agenda ag 
 WHERE a.tipo_id=t.codigo and a.id=ag.acto_id
AND CONCAT_WS('',a.nombre,' : ',ag.fecha, ' [',t.nombre,']') LIKE '%$q%'
/*GROUP BY t.nombre */
LIMIT 100";

       /* $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";*/
        echo $this->db->select_json($sql);
    }
  
    function mostrar()
    {

require_once('php/tcpdf/config/lang/eng.php');
require_once("php/tcpdf/tcpdf.php");
require_once("php/encabezado_reporte.php");
ini_set('memory_limit', '512M'); //Amplá la capacidad de memoria. Importante cuando se generan archivos muy pesados
set_time_limit(0); //Libera la capacidad del tiempo de respuesta

ob_start(); //Hace que el contenido HTML que se esta generando, no se vaya directamente al navegador
    /*echo "<pre>";
    print_r($_POST);
    echo "</pre>"; 
*/
$criterio="";
$id=$_POST["txtcodigo"];
$nombre=$_POST["txtnombreevento2"];
$descripcion=$_POST["txtdescrip"];
$objetivo=$_POST["txtobjetiv"];

$sql="SELECT 
a.id as codigo,
a.fecha,
a.tema,
a.cupos,
a.h_inicia,
a.h_termina,

p.nombre,
p.apellido1,
p.apellido2,

e.nombre as escenario,
e.ubicacion as ubicacion


FROM agenda a, general.persona p, escenario e

WHERE 
a.acto_id='$id'
and p.id=a.exponente
and a.escenario_id=e.id 
ORDER BY codigo ASC";

           // echo $sql;

$db=$this->db;
$r=$db->query($sql);
//echo(mysql_num_rows($r));

?>

<br/>

<table border="0">
<tr> 

<th colspan="3" style="text-align:center;font-size:13px;background-color:#004000;color:#fff"> <b>INFORMACION DE ACTO</b>


</th>

</tr>
 <tr  style="color:#000;text-align:center;font-size:12px;">

                   <td colspan="3"> <hr/> </td>              
           
 </tr>
<br/>
<tr><td style="width:90px"> Nombre acto </td> <td style="width:10px">:</td> <td style="width:78%"> <?php echo $nombre; ?> </td>  </tr>
    
<tr><td style="width:90px"> Objetivo acto </td> <td style="width:10px">:</td>  <td style="width:78%"><?php echo $objetivo; ?>  </td> </tr>
    
<tr><td style="width:90px"> Descripcion acto </td> <td style="width:10px">:</td> <td style="width:78%"> <?php echo $descripcion; ?> </td> </tr>

</table>
<br/>
<br/>

<table id="datos" border="0" cellspacing="0" width="100%" >

    <tbody>

    <?php
$no=0;
    while($rw=$db->fetch_assoc($r))
        {
        $Fecha=$rw['fecha'];

$r2=$db->query("select * from horas");
$no++;
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

$escenario=$rw['escenario'];
$ubicacion =$rw['ubicacion'];
$cupos =$rw['cupos'];
if ($cupos==0) {
  $cupos="Ilimitados";
}

$nom2=$rw['nombre']." ".$rw['apellido1']." ".$rw['apellido2'];
$nombre2= $nom2;
$tema=$rw['tema'];


        echo "
   <tr  style=\"color:#fff;text-align:center;font-size:13px;background-color:#004000;\">

                   <th colspan=\"3\"> <b> AGENDA NUMERO: $no </b></th>              
                  </tr>
                    <tr  style=\"color:#000;text-align:center;font-size:12px;\">

                   <td colspan=\"3\"> <hr/> </td>              
                  </tr>
 <tr style=\"background-color:#eee;\">
                   <td style=\"width:90px;text-align:left\" >Fecha</td ><td style=\"width:10px\">:</td> <td style=\"width:78%\">$Fecha</td>                     
                  </tr>
                   <tr style=\"background-color:#bbb;\">
                    <td style=\"width:90px;text-align:left\">Hora inicio</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$inicia</td>                     
                  </tr>
                   <tr style=\"background-color:#eee;\">
                    <td style=\"width:90px;text-align:left\">Hora termina</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$fin</td>                     
                  </tr>
                   <tr style=\"background-color:#bbb;\">
                    <td style=\"width:90px;text-align:left\">Exponente</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$nombre2</td>                     
                  </tr>
                   <tr style=\"background-color:#eee;\">
                    <td style=\"width:90px;text-align:left\">Tema</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$tema</td>                     
                  </tr>
                   <tr style=\"background-color:#bbb;\">
                    <td style=\"width:90px;text-align:left\">Cupos</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$cupos</td>                     
                  </tr>
                   <tr style=\"background-color:#eee;\">
                    <td style=\"width:90px;text-align:left\">Escenario</td><td style=\"width:10px\">:</td> <td style=\"width:78%\">$escenario</td>                     
                  </tr>
                   <tr style=\"background-color:#bbb;\">
                    <td style=\"width:90px;text-align:left\">Ubicacion(direccion)</td><td style=\"width:10px\">:</td > <td style=\"width:78%\">$ubicacion</td>                     
                  </tr> <br/><br/>";
        }
    ?>

    </tbody>
</table>

<?php


$html = ob_get_contents(); //Pasa el contenido html anterior a una variable
ob_end_clean(); //Limpiar los datos anterios 

$nombre_archivo="Agenda";
$formato=$_POST['formato'];
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
{
  
  //$p = new TCPDF_REPORTE("L", "pt", "LETTER", true); Si es tamaño carta horizantal
  //$p = new TCPDF_REPORTE("P", "pt", "LEGAL", true); Si es tamaño oficio
  //$p = new TCPDF_REPORTE("L", "pt", "LEGAL", true); Si es tamaño oficio horizontal
  $p = new TCPDF_REPORTE("P", "pt", "LETTER", true);
  $p->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $p->SetMargins(85,100,55);// margenes de izquierda, arriba y abajo
  $p->setFooterMargin (30); 
  
  $p->setPrintHeader(true);
  $p->setPrintFooter(true);
  
  $p->SetDrawColorArray( array(50,50,50) );
   
  $p->SetDisplayMode(100);
  $p->SetAutoPageBreak(TRUE,40);
  
  $p->SetLeftData("UNIVERSIDAD TECNOLOGICA DEL CHOCO","DIEGO LUIS CORDOBA","EVENTO Y REUNIONES", "Quibdó - Chocó"); //Dejar con "" el texto que no vaya.
  $p->SetRightData("EVENTO NUMERO $id","REPORTE DE AGENDAS","REPORTE DE AGENDAS","REPORTE DE AGENDAS"); //Dejar con "" el texto que no vaya.
  
  $p->AddPage();
  $p->SetFont("times","",10);
  $p->writeHTML($html, true, 0, true, 0); 
  $p->Output("reporte.pdf"); 

}

    }
}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>