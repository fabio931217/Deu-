<?php
//require_once('externos.php');
class TCPDF_REPORTE extends TCPDF {

 public function Header()
	     {
			$this->setY(20);
			$this->SetFont("times",'B',12);
	 		$margin=$this->getMargins();
			$this->Image("img/logo_reporte.png",80, 25, 60);
			$this->Image("img/logo_calidad.png", 470, 25, 90,60);
			$this->Cell(0,10, utf8_decode('UNIVERSIDAD TECNOLOGICA DEL CHOCO'),0,0,'C',0);
			$this->Ln();
			$this->Cell(0,10,'"DIEGO LUIS CORDOBA"',0,0,'C',0);
			$this->SetFont("times",'',10);
			$this->Ln();
			$this->Cell(0,10,utf8_decode('NIT 891680088-4'),0,0,'C',0);
			$this->Ln();
			$this->Cell(0,10,utf8_decode('Quibdó - Chocó'),0,0,'C',0);
			$this->Ln();
			$this->Ln();
			$this->SetFont("times",'B',11);
			$this->Cell(0,10,'OFICINA DE TALENTO HUMANO',0,0,'C',0);
			$this->Ln();
		}
    
 
public function Footer() {
        $this->SetFont('times', '', 10);
        $fecha = strftime("%A %d de %B del %Y - %H:%M:%S");
        $fecha = strtoupper($fecha);
        $pagina_actual = $this->getGroupPageNo();
        $paginas_total = $this->getPageGroupAlias();
        if ($pagina_actual == '' && $paginas_total == '') {
            $pagina_actual = $this->getAliasNumPage();
            $paginas_total = $this->getAliasNbPages();
        }
        
        //$pagina_actual = trim($pagina_actual);
        //$paginas_total = trim($paginas_total);
        
        $this->SetDrawColor(0);
        $this->Cell(200, 0, $fecha, "T", 0, "L");
        $this->Cell(0, 0, "Pagina $pagina_actual de $paginas_total", "T", 0, "R");
    }

}





?>