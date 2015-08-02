<script type="text/javascript" src="<?php echo WEB_ROOT ?>js/formulario_basico.js"></script> 
<script type="text/javascript">

    function cargarDepartamentos()
    {
        cargarCombo(page_root + "cargarDepartamentos", "formulario", "departamento", true);
        document.getElementById("municipio").options.length = 0; //Limpiar el combo municipio
    }

    function cargarMunicipios()
    {
        cargarCombo(page_root + "cargarMunicipios", "formulario", "municipio", true);
    }

</script>

<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-widget-header">
                <th colspan="3">EJEMPLO DE CARGA DE COMBO</th>
            </tr>

            <tr> 
                <td class="tdi">Pais</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="pais" name="pais" title="Pais" onChange="cargarDepartamentos()">
                        <?php
                        llenar_combo("SELECT id, nombre FROM pais ORDER BY nombre", true);
                        ?>
                    </select>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Departamento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="departamento" name="departamento" title="Departamento" onChange="cargarMunicipios()" >

                    </select>
                </td>            
            </tr> 

            <tr> 
                <td class="tdi">Municipio</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="municipio" name="municipio" title="Municipio">

                    </select>
                </td>            
            </tr>   
        </table>

        <div class="error"></div>
        <div class="dlg-acciones">
            <input type="button" id="btn_aceptar" value="Aceptar"/>
            <input type="button"  value="Cancelar"	onclick="$('#dialog').dialog('destroy')"/>
        </div>

    </form>
</div>
