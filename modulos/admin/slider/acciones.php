<?php
require_once("php/formulario_basico.php");
$accion=$_GET['_accion'];
unset($_GET['_accion']);
//$_POST=array_map("strtoupper", $_POST);

class formulario extends formulario_basico
{
 
	function subirArchivo()
	{
		if($_FILES[file][error]==0)
			{
 
				echo "<pre>";	
				$size = getimagesize($_FILES[file][tmp_name]);
				//print_r($size);
				echo "</pre>";
				
				if( is_array($size )==false)
				{
					$msg="El archivo seleccionado no es una imagen valida.";
				}
				else if($size[0] != 940 || $size[1] != 300)
				{
					$msg="La imagen debe tener un ancho 644 pixeles y un alto de 300 pixeles.";
				}
				else if($size[mime]!="image/jpeg")
				{
					$msg="La imagen debe ser de tipo JPG.";
				}
				else if( ($fs=filesize($_FILES[file][tmp_name]) ) >256000)
				{
					$msg="La imagen tiene un tamaño de " . $fs/1024 ."Kb y debe ser menor de 250 Kb.";
				}
				else
				{
					$file_name=uniqid().".jpg";
					$ruta="slider/images2/". $file_name;
				 
					move_uploaded_file($_FILES[file][tmp_name], $ruta);
					$row['ruta'] = $ruta;
					$row['posicion']= $_POST['posicion'];
					$row['descripcion']=$_POST['descripcion'];
					$this->db->insert("slider",$row);
					//echo $this->db->error();
					$error="N";		
					$msg="Imagen subida con exito.";		
				}
			
			}
			else
			{
				$msg="Error al subir el archivo.";
			}
	?>		
 		<script type="text/javascript">
		alert("<?php echo $msg ?>");
		if("<?php echo $error?>" == "N")
		{
			window.top.location.reload();
		}
	</script>
    <?php
	}
}

$sql="select * from slider";
$f=new formulario("slider","id",$sql,true);
$f->$accion();

?>