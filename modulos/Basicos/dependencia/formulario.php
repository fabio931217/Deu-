<script type="text/javascript">
    var grid;
    var f;

    $(document).ready(function(e) {
        grid = $.addGrid("#grid",
                {
                    url: page_root + 'listar',
                    height: 320,
                    dataType: 'json',
                    selectionMode: "single",
                    rowHeaderWidth: 1,
                    idName: "_id",
                    idField: "id",
                    recordPage: 50,
                    cols: [
                        {display: 'NO.', name: '_NUM_', width: 40, align: 'left'},
						{display: 'NOMBRE', name: 'nombre', width: 200, align: 'left'}, 
						{display: 'ALIAS', name: 'alias', width: 200, align: 'left'},
                         {display: 'INSTITUCION', name: 'institucion', width: 200, align: 'left'}
                    ]}
        );
        f = new formulario(true,650);
    });
</script>

<div>
    <div class="ui-state-active titulo-formulario">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>DEPENDENCIA</span> 
            <!-- Boton de busqueda -->
            <div style="float:right">
                <div class="ui-widget-header boton-busqueda">
                    <span class="ui-icon ui-icon-search"></span>
                </div>
            </div>
            <!-- Fin boton de busqueda -->
        </div>
        <div style="clear:both"></div>
    </div>

    <form class="div-form-busqueda ui-dialog-content ui-widget-content" id="form-busqueda">
        <div style="width:100%; margin:auto">
            <table style="width:100%">
                <tr class="ui-widget-header">
                    <th colspan='3'>BUSQUEDA</th>
                </tr>

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="bnombre" name="nombre" title="Nombre" maxlength="100" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Institucion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="binstitucion_id" name="institucion_id" title="Institucion">
                    	<?php llenar_combo("SELECT codigo, nombre FROM institucion ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>
            </table>
            <div class="acciones"> 
                <input type="button" value="Buscar"  onclick="f.buscar()" />
            </div>
        </div>
    </form>

    <div id="grid" class="grid"></div>  

    <div class="acciones">
        <input type="button" name="accion" value="Agregar" onclick="f.agregar()" class="accion-agregar"/>
        <input type="button" name="accion" value="Mostrar" onclick="f.mostrar()" class="accion-mostrar"/>
        <input type="button" name="accion" value="Modificar" onclick="f.modificar()" class="accion-modificar"/>
        <input type="button" name="accion" value="Eliminar" onclick="f.eliminar()" class="accion-eliminar"/>
    </div>
</div>



<!-- FORMULARIO -->

<div id="dialog" style="display:none; max-width:">
    <form id="formulario">
        <table style="width:100%">
 

            <tr style="display:none"> 
                <td class="tdi">Id</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="id" name="id" title="Id" maxlength="11" value=""  class="no-modificable"/>
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre" name="nombre" title="Nombre" maxlength="100" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Alias</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="alias" name="alias" title="Alias" maxlength="20" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Institucion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="institucion_id" name="institucion_id" title="Institucion">
                    	<?php llenar_combo("SELECT codigo, nombre FROM institucion ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>

        </table>

        <div class="error"></div>
        <div class="dlg-acciones">
            <input type="button" id="btn_aceptar" value="Aceptar"/>
            <input type="button" id="btn_cancelar" value="Cancelar"/>
        </div>

    </form>
</div>
