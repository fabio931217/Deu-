<script type="text/javascript">
 

                        
    function aceptar()
    {
       confirmar("¿Desea continuar?",continuar);
    }

    function continuar()
    {
      $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
            
           //alerta(data) para ver el prev

            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
               alerta(r.msg);
                 $("#error").html(r.msg);
                 $("#existe2").css({"display":"none"});
                 $("#existe").css({"display":"block"});

            } else
            {
                alerta(r.msg);
                $("#error2").html(r.msg);
                $("#existe").css({"display":"none"});
                $("#existe2").css({"display":"block"});

                recargar_pagina(3000);
            }
        });
    }


</script>

<div id="existe" class="alert-box error" style="display:none"><span>error: </span><p id="error"> </p></div>
<div id="existe2" class="alert-box success" style="display:none"><span>Exito: </span><p id="error2"> </p></div>

<!--
<div class="alert-box warning"><span>advertencia: </span>escribir mensaje.</div>
<div class="alert-box notice"><span>noticia: </span>escribir mensaje.</div>
-->

<div style="width:900px;min-height:160px; margin:auto; padding-top:10px">


<div style="width:140px;float:left">
   <img src="img/iconos/base.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">prueba</th>
            </tr>
 

            <tr> 
                <td class="tdi">ggg</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="p" name="p" title="ggg">
                        <?php
                        llenar_combo("PONER_SQL_AQUI", true); 
                        //true para dejar espacio inicial Ó false para no dejarlo
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">fff</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 <input type="text" name="p2" id="p2"  value="" title="fff" maxlength="30"/>
                </td>            
            </tr>


        </table>

        
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" class="accion-aceptar" />

        </div>

    </form>
</div>
</div>