<script type="text/javascript">
    $(document).ready(function()  {
        
        $("#formulario").submit(function() {
            $.ajaxSetup({async: false});
            $.post(page_root + "validar", $("#formulario").values(), function(data) {
                var r = jQuery.parseJSON(data);
                if (r.error == true)
                {
                    for (ind in r.bad_fields)
                    {
                        $("#" + r.bad_fields[ind]).addClass("error");
                    }
                    alert(r.msg);
                } else {
                    return true;
                }
            });

            return false;
        });
        
    });
</script>


<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario" method="post"  target="_blank" 
        action="<?php echo PAGE_ROOT . "mostrar" ?>">
        <table style="width:100%">
            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">Titulo Reporte libre</th>
            </tr>

            <tr> 
                <td class="tdi">Municipio</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="municipio" id="municipio"  value="" title="Municipio" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Formato</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="formato" name="formato">
                        <option value="PDF">Documento PDF</option>
                        <option value="XLS">Documento de Excel</option>
                        <option value="DOC">Documento de Word</option>
                        <option value="HTML">Visualizar en el navegador Web</option>
                    </select>
                </td>            
            </tr>
        </table>

        <div class="acciones">
            <input type="submit" value="Mostrar" class="accion-mostrar-reporte"/>
        </div>
    </form>
</div>
