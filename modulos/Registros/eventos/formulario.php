
<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe" >
            <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  <p id="error"> </p>  </p>
</div>

<div  style="width:900px; margin:auto; margin-top:20px">
    
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Eventos</th>
            </tr>
 

           

        </table>

</div>

<link type="text/css" rel="stylesheet" href="jquery-te-1.4.0.css">
<link type="text/css" rel="stylesheet" href="css/registros.css">
<script type="text/javascript" src="jquery-te-1.4.0.min.js" charset="utf-8"></script>



  <?php

  require_once("modulos/Registros/eventos/evento.php");

  ?>

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
$(document).ready(function(e) {
    

$( "#dialog" ).dialog({
            autoOpen: false,
            width: 700,
            buttons: [
                {
                    text: "Aceptar",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                },
                {
                    text: "Cancelar",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });

      
});

</script>


  <div id="dialog" title="Tenga en cuenta los siguientes datos">
    
 
    <div >
        <center>
        <img src="img/iconos/validar.png" alt="" height="120px"/>
        </center>
    </div>

    <div style="border:none;padding:8px; border-radius:8px;box-shadow:0px 0px 12px;margin-top:8px; width:96%;height:100%">
        
        <div class="titulo"><B id="msj1"></B></div>
        <div id="msj1mensaje"></div>

        <div class="titulo"><B id="msj2"></B></div>
        <div id="msj2mensaje"></div>

        <div class="titulo"><B id="msj3"></B></div>
        <div id="msj3mensaje"></div>

        <div class="titulo"><B id="msj4"></B></div>
        <div id="msj4mensaje"></div>

    </div>

</div>
