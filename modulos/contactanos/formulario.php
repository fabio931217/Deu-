<script type="text/javascript">
 

                        
    function aceptar()
    {
      
confirmar("¿Desea guardar los datos?",continuar);
    }


function continuar() 
{
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

<div style="width:900px;min-height:160px; margin:auto;">



<div style="width:140px;float:left">
   <img src="img/iconos/contactar.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>
<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Cotactanos</th>
            </tr>
 

            <tr> 
                <td class="tdi">Dirigido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="txtdirigido" name="txtdirigido" title="Dirigido" class="chosen-select">
                       <?php
                        llenar_combo("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre", true);
                        ?>
                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Asunto</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtasunto" id="txtasunto"  value="" title="Asunto" maxlength="40"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtnombre" id="txtnombre"  value="" title="Nombre" maxlength="40"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Correo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtcorreo" id="txtcorreo"  value="" title="Correo" maxlength="100"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Descripcion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtdescripcion" id="txtdescripcion"  value="" title="Descripcion" maxlength="400" style="height:200px" />
                </td>            
            </tr>


        </table>

        
        <div class="acciones">
		<input type="button" name="accion" value="Aceptar" onclick="aceptar()" />

        </div>

    </form>
</div>
</div>