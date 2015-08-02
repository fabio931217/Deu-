<div id="dialogo" title="Agenda" style="margin:auto;color:#000;line-height:28px;font-size:15px;text-align:justify;">
       <?php require_once("modulos/Servicios/editar_eventos/agregar_agenda.php"); ?>
</div>

  <script src="js/jquery.easytabs.min.js" type="text/javascript"></script>



  <style>
    /* Example Styles for Demo */
    .etabs {width: 98%; margin: 0; padding: 0; }
    .tab { width: 100px; display: inline-block; zoom:1; *display:inline; background: #004000; border: solid 1px #fff; border-bottom: none; -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; }
    .tab a { font-size: 14px; line-height: 2em; display: block; padding: 0 10px; outline: none;cursor: pointer;color:#fff; }

    .tab.active { width: 120px; background: #fff; padding-top: 6px; position: relative; top: 1px; border-color: #000; }
    .tab a.active { font-weight: bold; color:#004000;}
    .tab-container .panel-container { background: #fff; border: solid #666 1px; padding: 10px; -moz-border-radius: 0 4px 4px 4px; -webkit-border-radius: 0 4px 4px 4px; }
    .panel-container { margin-bottom: 10px; }
   
  </style>



  <script type="text/javascript">
    $(document).ready( function() {
      $('#tab-container').easytabs();
    });
  </script>

<div id="tab-container" class='tab-container'>
 <ul class='etabs'>
   <li class='tab'><a href="#Acto">Acto</a></li>
   <li class='tab'><a href="#Agenda">Agenda</a></li>
   <li class='tab'><a href="#Organizadores">Organizadores</a></li>
   <li class='tab'><a href="#Delegados">Delegados</a></li>
   <li class='tab'><a href="#Conclusiones">Conclusiones</a></li>
   <li class='tab'><a href="#Galeria">Galeria</a></li>
   <li class='tab'><a href="#Reportes">Reportes</a></li>
 </ul>
 <div class='panel-container'>
  <div id="Acto">
  

 <?php require_once("modulos/Servicios/editar_eventos/acto.php"); ?>
   
  </div>
   <div id="Agenda">
  

<div style="min-height:300px">
    <?php require_once("modulos/Servicios/editar_eventos/agenda.php"); ?>
</div>


  </div>
  <div id="Organizadores">
  
<div style="min-height:300px">
  <?php require_once("modulos/Servicios/editar_eventos/organizadores.php"); ?>
</div>
    
  </div>
  <div id="Delegados">

<div style="min-height:300px">
<?php require_once("modulos/Servicios/editar_eventos/delegados.php"); ?>
</div>


  </div>
    <div id="Conclusiones" >
<br/><div class="ui-widget">
 <div class="ui-state-error ui-corner-all" style="padding: 0.3em;display:none" id="existe_conclusion" >
                    <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Error:</strong>  <p id="error_conclusion"> </p>  </p>
 </div>
</div>'
  
   <form id="frm_conclusion" method="post"  target="respuesta">
   <input type="hidden" name="cod_id"  value=''/>
   <center>
<textarea name='txtconclusion' id='txtconclusion' style="min-height:400px;width:90%; overflow: scroll;" class="jqte-test">

<?php

$sc="SELECT contenido as conclusion from conclusion WHERE acto_id='$id[0]'";
$rc=$db->query($sc);

if ($db->num_rows($rc)>0)
{
  $rc2=$db->fetch_assoc($rc);
  $conclusion_EVENTO=$rc2['conclusion'];
echo($conclusion_EVENTO);
}
?>
</textarea>
 <button  type="button" id="modificar_acto" onclick="modificar_conclusion()">Guardar modificacion</button>
</center>

</form>



  </div>

   <div id="Galeria">
  

<div style="min-height:300px">
    <?php require_once("modulos/Servicios/editar_eventos/galeria.php"); ?>
</div>


  </div>

    <div id="Reportes">

<?php require_once("modulos/Servicios/editar_eventos/reportes.php"); ?>

  </div>
 </div>
</div>
<link type="text/css" rel="stylesheet" href="jquery-te-1.4.0.css">
<script type="text/javascript" src="jquery-te-1.4.0.min.js" charset="utf-8"></script>
<script>
  $('.jqte-test').jqte();
  
  // settings of status
  var jqteStatus = true;
  $(".status").click(function()
  {
    jqteStatus = jqteStatus ? false : true;
    $('.jqte-test').jqte({"status" : jqteStatus})
  });
</script>

                  


<script type="text/javascript">

     function modificar_conclusion()
                    {
                   
                bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{
                    $.post(page_root + "modificar_conclusion", $("#frm_conclusion").values(), function(data) {
                    var r = jQuery.parseJSON(data);
                    
                     if (r.msg==1) 
                        {
                            bootbox.alert("Actualizado con exito");
                            recargar_pagina(3000);
                        }
                        else
                        {
                    bootbox.alert(r.msg);
                     $("#error_conclusion").html(r.msg);
                     $("#existe_conclusion").css({"display":"block","font-size":"200%"});
                       }
                    });
  }

});
                    }


  $(function() {
     

$(".ocultar").hide();
    
    });


</script>
    
