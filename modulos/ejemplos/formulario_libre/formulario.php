<script type="text/javascript">
 

                        
    function aceptar()
    {
       confirmar("¿Desea continuar?",continuar);
    }

    function continuar()
    {
      $.post(page_root + "aceptar", $("#formulario").values(), function(data) {
            
           alerta(data) //para ver el prev

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

<div style="width:900px;min-height:160px; margin:auto; padding-top:10px">


<div style="width:140px;float:left">
   <img src="img/iconos/base.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Formulario libre</th>
            </tr>
 

            <tr> 
                <td class="tdi">Dato</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 <input type="text" name="txt1" id="txt1"  value="" title="Dato" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Dato 2</td>
                <td class="tdc">:</td>
                <td class="tdd">
                 <input type="text" name="txt2" id="txt2"  value="" title="Dato 2" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Combo</td>
                <td class="tdc">:</td>
                <td class="tdd">

<select name="txt6" id="txt6" multiple="true">

  <option value="1">Volvo</option>
  <option value="2">Saab</option>
  <option value="3">Opel</option>
  <option value="4">Audi</option>

</select>
                </td>            
            </tr>                        
                            


        </table>

        
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" class="accion-aceptar" />

        </div>

    </form>
</div>
</div>