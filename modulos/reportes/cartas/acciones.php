<?php
require_once("php/tcpdf/tcpdf.php");
require_once("php/tcpdf_reporte.php");

class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);

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

        $sql = "
                select * from datos
                ";

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
		<th style="width: 100pt">CEDULA</th>
		<th style="width: 100pt">NOMBRES</th>
		<th style="width: 100pt">APELLIDOS</th>
		<th style="width: 100pt">GENERO</th>
		<th style="width: 100pt">INSTITUCION</th>
		<th style="width: 100pt">PROFESION</th>
		<th style="width: 100pt">ID</th>

                </tr>
            </thead>
            <tbody>
                <?php
                while ($rw = $db->fetch_assoc($rs)) {
                    $fondo = ($fondo == "#fff" ? FONDO_HTML : "#fff");
                    ?>
                    <tr style="text-align:left; background-color:<?= $fondo ?>" >
                        <td style="width: 30pt"> <?= ++$x ?> </td>
			<td style="width: 100pt"> <?php echo $rw["Cedula"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["Nombres"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["Apellidos"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["Genero"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["Institucion"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["Profesion"] ?></td>
			<td style="width: 100pt"> <?php echo $rw["id"] ?></td>

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
            $p->SetMargins(20, 70, 20);
            $p->SetFooterMargin(30);
            $p->SetAutoPageBreak(TRUE, 45);

            $p->setPrintHeader(true);
            $p->setPrintFooter(true);
            $p->SetDisplayMode(100);
            $p->setImageScale(PDF_IMAGE_SCALE_RATIO);

            $p->SetDrawColorArray($DRAW_COLOR);
            $p->SetFillColorArray($FILL_COLOR);

            $p->SetLeftData(EMPRESA, EMPRESA_NIT, "VICERRECTORIA DE INVESTIGACIÓN", "TITULO DE REPORTE");
            $p->SetRightData("TITULO 1", "TITULO 2", "TITULO 3", "TITULO 4");

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