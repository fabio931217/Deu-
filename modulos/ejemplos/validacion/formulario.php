<script type="text/javascript">
    function validar()
    {
        $.post(page_root + "validar", $("#formulario").values(), function(data) {
            var r = jQuery.parseJSON(data);
            if (r.error == true)
            {
                for (ind in r.bad_fields)
                {
                    $("#" + r.bad_fields[ind]).addClass("error");
                }
                alert(r.validation_messages);
            } else
            {
                alert("No hay errores de validación");
            }
        });
    }

</script>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">EJEMPLO DE VALIDACIÓN REMOTA</th>
            </tr>

            <tr> 
                <td class="tdi">Pais</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="pais" name="pais" title="Pais">
                        <?php
                        llenar_combo("SELECT id, nombre FROM pais", true);
                        ?>
                    </select>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">entero</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="entero" id="entero"  value=""/>
                </td>            
            </tr> 

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="nombre" id="nombre"  value="" title="Nombre"/>
                </td>            
            </tr> 


            <tr> 
                <td class="tdi">Decimal</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="decimal" id="decimal"  value="" title="Decimal...."/>
                </td>            
            </tr> 


            <tr> 
                <td class="tdi">fecha</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="fecha" id="fecha"  value=""/>
                </td>            
            </tr> 


            <tr> 
                <td class="tdi">Correo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="correo" id="correo"  value=""/>
                </td>            
            </tr> 
        </table>

        <div class="error"></div>
        <div class="dlg-acciones">
            <input type="button" id="btn_aceptar" value="Aceptar" onClick="validar()"/>
            <input type="button"  value="Cancelar"/>
        </div>

    </form>
</div>
