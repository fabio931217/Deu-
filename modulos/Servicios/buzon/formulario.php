<?php

//$db=$this->db;

    $s="SELECT * FROM contactar LIMIT 500";

        $r=$db->query($s); //tomo la informacion de la base de datos
        $total = $db->num_rows($r);

  
        //###############################################################################

    $s="SELECT * FROM contactar WHERE estado='1'";

        $r=$db->query($s); //tomo la informacion de la base de datos
        $no_respondidos = $db->num_rows($r);

        //###############################################################################

    $s="SELECT * FROM contactar WHERE estado='2'";

        $r=$db->query($s); //tomo la informacion de la base de datos
        $respondidos = $db->num_rows($r);


       //###############################################################################

/*
echo "<pre>";
                    print_r($_POST);
                    echo "</pre>";
*/
 if (isset($_POST['buscarpornombre']) and !empty($_POST['buscar_por_nombre']))
            {
             $s="SELECT * FROM contactar WHERE nombre LIKE '%$_POST[buscar_por_nombre]%' ORDER BY id desc LIMIT 500 ";
              $msj="Actualmente estos son  los mensajes que contiente el  <b>Nombre: $_POST[buscar_por_nombre] </b>";
             }
             elseif (isset($_POST['buscarporfechas']) and (!empty($_POST['fechainicio']) or !empty($_POST['fechafin'])) )
             {
               $s="SELECT * FROM contactar WHERE fecha LIKE '%$_POST[fechainicio]%' or fecha LIKE '%$_POST[fechafin]%'  ORDER BY id desc LIMIT 500 ";
              $msj="Actualmente estos son  los mensajes del: <b> $_POST[fechainicio] </b>  hasta: <b> $_POST[fechafin] </b>";
             }
              elseif (isset($_POST['buscarporasunto']) and !empty($_POST['buscar_por_asunto']))
              {
             $s="SELECT * FROM contactar  WHERE asunto LIKE '%$_POST[buscar_por_asunto]%' ORDER BY id desc LIMIT 500";
                 $msj="Actualmente estos son  los mensajes que contiente el <b>Asunto: $_POST[buscar_por_asunto] </b>";
             }
             elseif (isset($_POST['buscar_por_respondidos']))
             {
               $s="SELECT * FROM contactar  WHERE estado='2' ORDER BY id desc LIMIT 500 ";
                 $msj="Actualmente estos son  los mensajes <b> Respondidos </b>";
             }
             elseif (isset($_POST['buscar_sin_responder'])) {
                $s="SELECT * FROM contactar  WHERE estado='1' ORDER BY id desc LIMIT 500 ";
                 $msj="Actualmente estos son  los mensajes <b>Sin Responder </b>";
             }
             elseif (isset($_POST['todos'])) {
                $s="SELECT * FROM contactar ORDER BY id desc LIMIT 500 ";
                $msj="Actualmente estos son <b> Todos  los mensajes </b>";
             }
              else {
                $s="SELECT * FROM contactar ORDER BY id desc LIMIT 500 ";
                $msj="Actualmente estos son <b> Todos  los mensajes </b>";
             }
            

$_POST = array(); //limpio las variables despues de ejecutar
?>


<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="POST">
        
<table style="width:100%" class="ocultar_fecha">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Buzon de Sugerencias</th>
            </tr>
 

            <tr > 
                <td class="tdi">Fecha Inicio</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fechainicio" id="fechainicio"  value="" title="Fecha Inicio" maxlength="30"/>
                </td>            
            </tr>

            <tr > 
                <td class="tdi">Fecha Fin</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fechafin" id="fechafin"  value="" title="Fecha Fin" maxlength="30"/>
                </td>            
            </tr>
</table>

<table style="width:100%" class="ocultar_nombre">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Buzon de Sugerencias</th>
            </tr>

            <tr > 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 
                    <input type="text" name="buscar_por_nombre" id="buscar_por_nombre"  value="" title="Nombre" maxlength="30"/>
                </td>            
            </tr>
</table>

<table style="width:100%" class="ocultar_asunto">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Buzon de Sugerencias</th>
            </tr>
            <tr > 
                <td class="tdi">Asunto</td>
                <td class="tdc">:</td>
                <td class="tdd">
            
                    <input type="text" name="buscar_por_asunto" id="buscar_por_asunto"  value="" title="Asunto" maxlength="30"/>
                </td>            
            </tr>


</table>


        <div class="error"></div>
        <div class="acciones" >
		<button type="submit" name="buscarporasunto" value="buscarporasunto" class="ocultar_asunto">Buscar Asunto </button> 
    <button type="submit" name="buscarporfechas" value="buscarporfechas"  class="ocultar_fecha">Buscar Fecha </button> 
    <button type="submit" name="buscarpornombre" value="buscarpornombre" class="ocultar_nombre">Buscar Nombre</button> 
		<button type="submit" name="accion" value="Cancelar" onclick="ocultar()" class="ocultar_cancelar">Cancelar </button> 

        </div>

    </form>
</div>

<div class='ui-widget'>
  <div class='ui-state-highlight ui-corner-all' style='margin-top:0px; padding:0.1em;'>
    <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
    <strong>Informacion</strong> <?php echo $msj; ?></p>
  </div>
</div>
<br/>
<link rel="stylesheet" href="css/jPages.css">
<script src="js/jPages.js"></script>
<script src="js/funciones.js"></script>

<script type="text/javascript">
  
 $(function(){
    $("div.holder").jPages({
      containerID : "cuerpo-detalles",
      previous : "←",
      next : "→",
      perPage : 8,
      delay : 8
    });
  });


</script>

<script type="text/javascript">
    $(function() {
         
ocultar();

    });

function ocultar()
         {
            $(".acciones,.ocultar_cancelar,.ocultar,.ocultar_fecha,.ocultar_nombre,.ocultar_asunto").hide();
         }
function ocultar_nombre()
         {
             $(".acciones,.ocultar_nombre,.ocultar_cancelar").show();
            $(".ocultar_fecha,.ocultar_asunto").hide();
           
         }
function ocultar_asunto()
         {
            $(".acciones,.ocultar_asunto,.ocultar_cancelar").show();
            $(".ocultar_fecha,.ocultar_nombre").hide();
          
         }
function ocultar_fecha()
         {
            $(".acciones,.ocultar_fecha,.ocultar_cancelar").show();
            $(".ocultar_nombre,.ocultar_asunto").hide();
           
         }
</script>

<link rel="stylesheet" href="css/accordionmenu.css" type="text/css" media="screen" />


<style type="text/css">  
        
        #reporte { border-collapse:collapse;}
        #reporte th { 
          background-color:#004000;
          color:#fff; padding:7px 15px;
          text-align:left;
         padding: 9px;
          box-shadow: 0px 0px 8px;


        }

        #reporte td { 
          background:#fff none repeat-x scroll center left;
          color:#000; 
          padding:7px 15px;
           }
        #reporte tr{cursor:pointer; 
          border-top: 1px solid #ddd;
          }
        #reporte div.arrow { background:transparent url(img/enviar.png) no-repeat scroll ;
         width:36px; height:34px; display:block;

       }
       
#wrapper-200a a
{
  text-align: left;
  background-color:transparent; 
  /*color:#067338;*/
  border: none;
  width: 80%;
  height: 100%;
  color:#000;
  cursor: pointer;

}
#wrapper-200a a:hover
{
  text-align:center; 
  background-color:#004000; 
  /*color:#067338;*/
  border: none;
  color:#fff;
  cursor: pointer;
}

 #wrapper-200a{
            width:226px;
            float:left;
           
            
        }
  button
  {
    


  }      
    </style>

<div style="border:none;width:100%;min-height:500px;padding-top:0px">

    <div id="wrapper-200a" style="padding-top:0px;background-color:#eee;height:500px">


<form id="formulario" name="formulario" method="POST">
        <ul class="accordion">
            
            <li id="one" class="files">

            <a><input type="submit" name="todos" value="Todos" style="border: none;background-color: transparent;cursor: pointer;text-align:left;font-weight: bold"> <span><?php echo $total ?></span></a>

            </li>
            
            <li id="two" class="mail">

                <a><input type="submit" name="buscar_por_respondidos" value="Respondidos" style="border: none;background-color: transparent;cursor: pointer;text-align:left;font-weight: bold">  <span><?php echo $respondidos ?></span></a>

            </li>
            
            <li id="three" class="cloud">

                <a><input type="submit" name="buscar_sin_responder" value="Sin responder" style="border: none;background-color: transparent;cursor: pointer;text-align:left;font-weight: bold"> <span><?php echo $no_respondidos ?> </span></a>

            </li>
            
            <li id="four" class="sign">

                <a onclick="ocultar_fecha()">Buscar Por Fechas</a>
            </li>

             <li id="four" class="sign">

                <a onclick="ocultar_asunto()">Buscar Por Asunto</a>

            </li>

            <li id="four" class="sign">

                <a onclick="ocultar_nombre()">Buscar Por Nombre</a>

            </li>
        </ul>
   </form>

 <div style="height:80px;width:100%;margin-top:40px;padding-left:20px">
  <img src="img/iconos/buzon.png" alt=""  style="" />
</div>

    </div>



<div style="border-left:double #004000;height:480px;width:730px;float:right;">
    
 <?php

  //echo $s;

        $r=$db->query($s); //tomo la informacion de la base de datos
        $total = $db->num_rows($r);

        while ($rw=$db->fetch_assoc($r))
        {
            $asunto= $rw['asunto'] ;
            $mensaje=$rw['mensaje'];

            $id=$rw['id'];
            $nombre=$rw['nombre'];
            $correo=$rw['correo'];

          @$tabla.="<tr onclick='myFunction3(this)'>
      
        <td width='200px'>$id</td>
      <td width='480px' class='ocultar'>$nombre</td>
       <td width='480px' class='ocultar'>$correo</td>

      <td width='200px'>$asunto</td>
      <td width='480px'>$mensaje</td>
      <td width='10px'><div class='arrow'></div></td>

    </tr>";
          

                     
        } 


  require_once("modulos/Servicios/buzon/todos.php");
?>

<div class="holder" style="float:right;"></div>

<div style="clear:both"></div>
</div>

</div>




<script type="text/javascript">
  

$(document).ready(function(){

 
          $("#dialogo1").hide();
          $("#dialogo2").hide();

         
                    
            $(".arrow").click(function(){


var name = "Responder buzon";

 

          $("#dialogo1").dialog({
            width: 650,
            //height: 380,
            title:name,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
      
            });
//--------------------------------------------------
 $("input").removeClass();


        });


</script>
<div id="dialogo1" title="" style="margin:auto;color:#000;line-height:28px;font-size:15px;text-align:justify;">
 
 <?php require_once("modulos/Servicios/buzon/responder.php") ?>

 </div>