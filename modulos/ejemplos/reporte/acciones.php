<?php
require_once("php/tcpdf/tcpdf.php");
require_once("php/tcpdf_reporte.php");

class Formulario extends Base {

    function validar() {
        $v = new Validation($_POST);
        $v->addRules('nombre', 'Nombre', array('required' => true));
        $v->addRules('nacimiento', 'Nacimiento', array('required' => true));

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

    function mostrar() {
        global $DRAW_COLOR, $FILL_COLOR, $FILL_COLOR_TITULO;
        $db = $this->db;

        $sql = "SELECT d.nombre as departamento, m.nombre as municipio
                FROM departamento d, municipio m
                WHERE m.departamento_id=d.id 
                LIMIT 300";

        $rs = $db->query($sql);
        ob_start();
        ?>

        <table style="font-family:'Times New Roman', Times, serif; font-size:8.5pt; 
               border-collapse:collapse" border="1" bordercolor="<?php echo BORDE_HTML ?>" 
               cellpadding="1" cellspacing="0">
            <thead>
                <!-- TODO LO QUE VA AQUI SE REPITE EN EL ENCABEZADO -->
                <tr style="font-weight:bold; text-align:left; background-color:<?= FONDO_HTML_TITULO ?>">
                    <th style="width: 30pt">NO</th>
                    <th style="width: 242pt; text-align: left">DEPARTAMENTO</th>
                    <th style="width: 300pt; text-align: left">MUNICIPIO</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                while ($rw = $db->fetch_assoc($rs)) {
                    $fondo = ($fondo == "#fff" ? FONDO_HTML : "#fff");
                    ?>
                    <tr style="text-align:left; background-color:<?= $fondo ?>" >
                        <td style="width: 30pt"> <?= ++$x ?> </td>
                        <td style="width: 242pt"> <?php echo $rw['departamento'] ?> </td>	
                        <td style="width: 300pt"> <?php echo $rw['municipio'] ?> </td>

                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

        <?php
        $html = ob_get_contents();
        ob_clean();
        ob_flush();

        
        $p = new TCPDF_REPORTE(PDF_PAGE_ORIENTATION, "pt", "LETTER", true);
        $p->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $p->SetMargins(20, 70, 20);
        $p->SetFooterMargin(30);
	$p->SetAutoPageBreak(TRUE,30);

        $p->setPrintHeader(true);
        $p->setPrintFooter(true);
        $p->SetDisplayMode(100);
        $p->setImageScale(PDF_IMAGE_SCALE_RATIO);
       	
	$p->SetDrawColorArray($DRAW_COLOR);
	$p->SetFillColorArray($FILL_COLOR);        

        $p->SetLeftData(EMPRESA, EMPRESA_NIT, "VICERRECTORIA DE INVESTIGACIÓN", "LISTADO DE MUNICIPIOS");
        $p->SetRightData("TITULO 2", "TITULO 3", "TITULO 4", "TITULO 5");

        $p->AddPage();
	
        $p->SetFont("times","",5);
	$p->writeHTML($html, true, 0, true, 0); 
        
        $archivo = "reporte";
        $p->Output("{$archivo}.pdf", PDF_MODO_IMPRESION);
    }

}

//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA

$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>