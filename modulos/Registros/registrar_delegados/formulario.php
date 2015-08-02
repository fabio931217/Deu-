<script type="text/javascript" src="js/autocompletar.js"></script>

<script type="text/javascript">
 
$(document).ready(function(e) {
               
        $("#txtdocumento").autocompletar2(page_root + "listarPersonas", {
            form: "formulario",
            inputId: "persona_id",
            minLength: 3});        
    });

 function autocomplete()
 {


/*$("#cbmevento").addClass("chosen-select");
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
 $("#cbmevento").removeClass("chosen-select"); */
 }

function cargarEventos()
 {

       
        cargarCombo(page_root + "cargarEventos", "formulario", "cbmevento", true);

        //setTimeout (" autocomplete()", 1000);

  
 }

    function buscar()
    {

        bootbox.confirm("¿Desea guardar los datos?", function(result) {

if (result==true) 
{

        $.post(page_root + "buscar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                bootbox.alert(r.msg);
                 $("#error").html(r.msg);
                $("#existe").css({"display":"block","font-size":"200%"});
            } else
            {
                bootbox.alert(r.msg);
                recargar_pagina(3000);
            }
        });

}

});
    }


</script>

<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;display:none" id="existe" >
            <p ><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  <p id="error"> </p>  </p>
</div>

<div style="width:900px;height:150px; margin:auto;">

<div style="width:140px;float:left">
   <img src="img/iconos/delegados.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; padding-top:40px;">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Registrar Delegados</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmtipo" name="cbmtipo" title="Tipo Evento" onChange="cargarEventos()">
                        <?php
                        llenar_combo("SELECT * FROM tipo", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Evento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmevento" name="cbmevento" title="Evento" >
                       
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Documento</td>
                <td class="tdc">:</td>
                <td class="tdd">

               
                  <input type="hidden" name="persona_id" id="persona_id" 
                           class="no-modificable" title="Persona">

                    <input type="text" name="txtdocumento" id="txtdocumento" 
                           class="no-modificable" title="Persona">

       <!--        <input type="hidden" id="id" name="id" title="Documento" class="no_modificable" disabled="disable" readonly />
                <input type="text" class="search" id="searchid" name="txtdocumento" title="Documento" placeholder="Buscar usuario" style='text-transform:uppercase;' />
<div id="result"> -->


               </td>            
            </tr>


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Guardar" onclick="buscar()" class="accion-buscar" />

        </div>

    </form>
</div>
</div>