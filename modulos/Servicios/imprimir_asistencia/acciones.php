<?php
require_once("php/tcpdf/tcpdf.php");
require_once("php/tcpdf_reporte.php");

class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('txtbuscar', 'Acto', array('required' => true, 'maxLength' => 30) );
		$v->addRules('tipo', 'Tipo de Reporte', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmagenda', 'Agenda', array('required' => true, 'maxLength' => 30) );
        $v->addRules('cbmdependencia', 'Dependencia', array('required' => true, 'maxLength' => 30) );
          $v->addRules('cbmtipo', 'Tipo evento', array('required' => true, 'maxLength' => 30) );

		$v->addRules('formato', 'Formato', array('required' => true, 'maxLength' => 30) );

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

 function cargarEventos() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipo]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

function cargarAgendas() {
        $db = $this->db;

$s= "SELECT a.id as codigo,a.tema,a.h_inicia,a.h_termina,CONCAT_WS(' ',p.nombre,p.apellido1,p.apellido2) as nombre
FROM agenda a, general.persona p
WHERE a.acto_id='$_POST[txtbuscar]' and p.id=a.exponente
GROUP BY codigo";
 
$combo="<option value='0'> RELACION GENERAL </option>";
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
       echo json_encode($combo);
    }

function mostrar() {
        global $DRAW_COLOR, $FILL_COLOR, $FILL_COLOR_TITULO;
        $db = $this->db;

$criterio="";
$criterio2="";

$sexo =$_POST["tipo"];
$agenda =$_POST["cbmagenda"];
$dependencia =$_POST["cbmdependencia"];
$ordenar=$_POST["cbmordenar"];
$criterio="and p.sexo='$sexo'";
$criterio2="and a.agenda_id='$agenda'";
$criterio3="and dependencia_id='$dependencia'";

switch ($ordenar) {
    case 0:
       $orden="ORDER BY p.nombre";
        break;
    case 1:
       $orden="ORDER BY p.apellido1";
        break;
    case 2:
       $orden="ORDER BY p.tipoide";
        break;
    case 3:
        $orden="ORDER BY s.nombre";
        break;
    case 4:
       $orden="ORDER BY i.nombre";
        break;
    case 4:
      $orden="ORDER BY d.nombre";
        break;
    case 6:
      $orden="ORDER BY f.nombre";
        break;
    default:
       $orden="";
        break;
}

if ($sexo=='0') {
  $criterio="";
}
if ($agenda=='0') {
  $criterio2="";
}
if($dependencia=='0')
{
    $criterio3="";
}

        $sql = "SELECT
s.nombre as sexo, 
p.identifica,
p.tipoide as tipo,
p.nombre,p.apellido1,p.apellido2,
d.nombre as dependencia,
f.nombre as funcion,
i.nombre as institucion
FROM agenda ag, asistencia a, general.persona p,funcion f,dependencia d,institucion i,sexo s

WHERE 
p.id=a.persona_id
and a.funcion_id=f.codigo
and a.dependencia_id=d.id
and d.institucion_id=i.codigo
and p.sexo=s.codigo
and ag.id=a.agenda_id
and ag.acto_id='$_POST[txtbuscar]'
".$criterio."
".$criterio2."
".$criterio3."
GROUP BY p.identifica
".$orden."";
//echo ;
        $rs = $db->query($sql);
        ob_start();
        ?>
<center>
<table width="98%" style="font-family:'Times New Roman', Times, serif; font-size:8.5pt; 
               border-collapse:collapse;" border="1" bordercolor="<?php echo BORDE_HTML ?>" 
               cellpadding="1" cellspacing="0">
    <tr style="font-weight:bold; text-align:left; background-color:<?= FONDO_HTML_TITULO ?>">
    <td>TOTAL ASISTENTES</td>
        <td> <?php echo $db->num_rows($rs);?></td>
    </tr>
</table>
<br/>
<br/>
<br/>
        <table style="font-family:'Times New Roman', Times, serif; font-size:8.5pt; 
               border-collapse:collapse;" border="1" bordercolor="<?php echo BORDE_HTML ?>" 
               cellpadding="1" cellspacing="0">
            <thead>
                <!-- TODO LO QUE VA AQUI SE REPITE EN EL ENCABEZADO -->
                <tr style="font-weight:bold; text-align:left; background-color:<?= FONDO_HTML_TITULO ?>">
                    <th style="width: 30pt">NO</th>
		<th style="width: 30pt">TIPO</th>
		<th style="width: 100pt">DOCUMENTO</th>
		<th style="width: 200pt">NOMBRE COMPLETO</th>
        <th style="width: 120pt">INSTITUCION</th>
		<th style="width: 120pt">DEPENDENCIA</th>
		<th style="width: 50pt">FUNCION</th>
        <th style="width: 60pt">SEXO </th>
		 

                </tr>
            </thead>
            <tbody>
                <?php
                while ($rw = $db->fetch_assoc($rs)) {
                    $fondo = ($fondo == "#fff" ? FONDO_HTML : "#fff");
                    ?>
                    <tr style="text-align:left; background-color:<?= $fondo ?>" >
                        <td style="width: 30pt"> <?= ++$x ?> </td>

		    <td style="width: 30pt"> <?php echo $rw["tipo"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["identifica"] ?></td>
			<td style="width: 200pt">
             

             <?php 
if ($ordenar==0) 
            {
              echo $rw["nombre"]."  " ;
              echo $rw["apellido1"]."  " ;
              echo $rw["apellido2"];
            }
            else
            {
             
			 echo $rw["apellido1"]."  " ;
			 echo $rw["apellido2"]."  " ;
             echo $rw["nombre"] ;
            }

              ?>
              </td>
		
			<td style="width: 120pt"> <?php echo $rw["institucion"] ?></td>
            <td style="width: 120pt"> <?php echo $rw["dependencia"] ?></td>
            <td style="width: 50pt"> <?php echo $rw["funcion"] ?></td>
            <td style="width: 60pt"> <?php echo $rw["sexo"] ?></td>
           
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
</center>
        <?php
        $html = ob_get_contents();
        ob_clean();
        ob_flush();

        
        $nombre_archivo = "reporte";
        
        $formato = $_POST['formato'];
       
        if ($formato == "XLS") {
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment; filename={$nombre_archivo}.xls;");
            echo $html;
        } else if ($formato == "DOC") {
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment; filename={$nombre_archivo}.doc;");
            echo $html;
        } else if ($formato == "PDF") {
            $p = new TCPDF_REPORTE("L", "pt", "LETTER", true);
            $p->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $p->SetMargins(30, 70, 30);
            $p->SetFooterMargin(30);
            $p->SetAutoPageBreak(TRUE, 45);

            $p->setPrintHeader(true);
            $p->setPrintFooter(true);
            $p->SetDisplayMode(100);
            $p->setImageScale(PDF_IMAGE_SCALE_RATIO);

            $p->SetDrawColorArray($DRAW_COLOR);
            $p->SetFillColorArray($FILL_COLOR);

            $p->SetLeftData(EMPRESA, EMPRESA_NIT, "VICERRECTORIA DE INVESTIGACIÓN", "TITULO DE REPORTE");
            $p->SetRightData("REPORTE", "ASISTENCIA", "", "");

            $p->AddPage();

            $p->SetFont("times", "", 5);
            $p->writeHTML($html, true, 0, true, 0);   
            $p->Output("{$archivo}.pdf", PDF_MODO_IMPRESION);
        } else {
            //Formato = HTML
            echo $html;
        }
    }
 
}
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>