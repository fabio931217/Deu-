<script type="text/javascript">
 

                        
    function aceptar()
    {
        
confirmar("¿Desea cambiar la clave?",continuar);


}
function continuar() {
      $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                 alerta(r.msg);
                $("#error").html(r.msg);
                $("#existe").css({"display":"block","font-size":"200%"});
            } else
            {
               alerta(r.msg);
               cambiar_de_pagina(4000,"iniciar-sesion");
              
            }
        });
}

</script>

<div id="existe" class="alert-box error" style="display:none"><span>error: </span><p id="error"> </p></div>
<div id="existe2" class="alert-box success" style="display:none"><span>Exito: </span><p id="error2"> </p></div>

<div style="width:900px;height:160px; margin:auto;">

<div style="width:140px;float:left">
   <img src="img/iconos/restaurar.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Cambiar clave</th>
            </tr>
 

            <tr> 
                <td class="tdi">Clave Actual</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="clave1" id="clave1"  value="" title="Clave Actual" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Clave Nueva</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="clave2" id="clave2"  value="" title="Clave Nueva" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Repetir Clave</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="clave3" id="clave3"  value="" title="Repetir Clave" maxlength="30"/>
                </td>            
            </tr>


        </table>

       
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" />

        </div>

    </form>
</div>
</div>