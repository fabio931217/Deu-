<?php
//session_destroy();
ob_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
	
	<title>Plantilla Mobil</title>


   
<link rel="stylesheet" href="css/chosen.css">

   <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/jquery/jquery-1.10.2.js"></script> 
   
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootbox.min.js"></script>    
 <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/jquery/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/jquery/validation.js"></script> 

    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/general.js"></script>

    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/grid.js"></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/jquery.extra.js?t=1"></script>
    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/pagina.js" ></script>
    
    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/select2/select2.min.js"></script> 
    <script type="text/javascript" src="<?php echo WEB_ROOT ?>js/select2/select2_locale_es.js"></script> 
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>js/select2/select2.css" />     

    <script type="text/javascript" src="<?php page_root ?>js/formulario_basico.js"></script> 
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/grid/grid.css"/> 
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/custom-theme/jquery-ui-1.10.4.custom.min.css" /> 
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/jquery-ui-extra.css" /> 
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/general.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/validacion.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo WEB_ROOT ?>css/tablas.css" /> 
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css">
    <script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>


<link type="text/css" href="<?php echo WEB_ROOT ?>css/menu_nuevo3.css" rel="stylesheet" />


<link rel="stylesheet" href="css/mensajes.efectos.css" />
<link rel="stylesheet" href="css/mensajes.diseño.css" id="botonesCSS" />
<script src="js/alertify.min.js"></script>
  <!-- This is what you need -->
<script src="js/sweet-alert.js"></script>
<link rel="stylesheet" href="css/sweet-alert.css">

<script src="js/mensajes1.js"></script>    
  

		<link type="text/css" rel="stylesheet" href="css/demo.css" />
		<link type="text/css" rel="stylesheet" href="css/jquery.mmenu.all.css" />
	
		<script type="text/javascript" src="js/jquery.mmenu.min.all.js"></script>
	
		<script type="text/javascript">
			$(function() {
				$('nav#menu').mmenu({
					extensions	: [ 'effect-slide-menu', 'pageshadow' ],
					searchfield	: true,
					counters	: true,
					navbar 		: {
						title		: 'Menu'
					},
					navbars		: [
						{
							position	: 'top',
							content		: [ 'searchfield' ]
						}, {
							position	: 'top',
							content		: [
								'prev',
								'title',
								'close'
							]
						}, {
							position	: 'bottom',
							content		: [
								'<a href="#">Creado Por:</a>',
								'<a href=#">Fabio Garcia</a>'
							]
						}
					]
				});
			});
		</script>



		<script type="text/javascript" >

        const menu = "<?php echo MENU ?>";
                const web_root = "<?php echo WEB_ROOT ?>";
                const page_root = "<?php echo PAGE_ROOT ?>";
                $(document).ready(function(e) {

<?php
//Ocultar botones a los que no se tiene permiso
$sql = "SELECT 
                        a.accion, a.requiere_permiso, pa.id AS permiso
                FROM
                        admin_accion a
                                LEFT JOIN
                        admin_permiso_accion pa ON a.id = pa.accion and pa.rol='$_SESSION[usuario_rol]'
                WHERE
                        a.menu = '" . MENU . "' AND a.requiere_permiso='S'";
$rs = $db->query($sql);
while ($rw = $db->fetch_assoc($rs)) {
    if ($rw['permiso'] == "")
    {
        echo '$(".accion-' . $rw['accion'] . '").hide();';
    }
}
?>

            //Manejar ruta de menú  y menú activo
<?php
$rw = $db->select_row("SELECT * FROM admin_menu WHERE menu='" . MENU . "'");
$ruta = $rw['nombre'];
if ($rw['padre'] != "") {
    $rw = $db->select_row("SELECT * FROM admin_menu WHERE menu='$rw[padre]'");
    $ruta = $rw['nombre'] . " <b>/</b> " . $ruta;
    echo '$(".menu-' . $rw['menu'] . '").addClass("active");';
}
?>
            $(".menu-" + menu).addClass("active");
            document.getElementById("menu_ruta").innerHTML = "<b>Usted esta en:</b> <?php echo $ruta ?>";

        });


    </script>

	</head>
	<body>
		<div  data-role="page" id="page">
			<div class="header">
				<a href="#menu"></a>
				<?php
                    if (isset($_SESSION['nombre_usuario'])) {
                        echo "Hola: ".ucwords(strtolower($_SESSION['nombre_usuario']));
                    }
                    ?>
			</div>
			<div class="content">
				
                <div style="width:80%; min-height:400px;border-radius:8px;box-shadow:8px;padding:10px;margin:auto;margin-top:-100px;background-color:#fff">
                    <?php
                    $r = obtener_ruta_menu(MENU, ACCION);
                    if ($r['error'] == false) {
                        require_once($r['ruta']);
                    } else {
                        alerta($r['msg']);
                    }
                    ?> 
                </div> 


			</div>
			<nav id="menu">
				 <?php
                require_once("menu.php");
                ?>
			</nav>
		</div>
        
	     
	
        
        
        <script src="js/chosen.jquery.js" type="text/javascript"></script>
  
  <script type="text/javascript">

 
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }

  // $("select").addClass("chosen-select");



    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
        
        
	</body>
</html>