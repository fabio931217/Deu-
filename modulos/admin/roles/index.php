<script type="text/javascript">
    var grid;

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
                    recordPage: 40,
                    cols: [
                        {display: 'ID', name: 'id', width: 80, align: 'left'},
                        {display: 'NOMBRE', name: 'nombre', width: 600, align: 'left'}
                    ]}
        );
        f = new formulario(true,650);
    });
</script>

<div>
    <div class="ui-state-active titulo-formulario"   >
        <div> 
            <span>ROLES</span> 
            <!-- Boton de busqueda -->
            <div style="float:right">
                <div class="ui-state-active boton-busqueda">
                    <span class="ui-icon ui-icon-search"></span>
                </div>
            </div>
            <!-- Fin boton de busqueda -->
        </div>
        <div style="clear:both"></div>
    </div>

    <form class="div-form-busqueda ui-dialog-content ui-widget-content" id="form-busqueda">
        <div style=" text-align:center"> 
            <label  for="txt-busqueda">Nombre:</label>
            <input type="text" id="txt-busqueda" name="nombre" style="width:400px" /> 
            <input type="button" value="Buscar"  onclick="f.buscar()" />
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
                    <input type="text" id="id" name="id" title="id" value="" class="no-modificable"/>
                </td>            
            </tr> 

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre" name="nombre" title="Nombre" maxlength="45" value=""/>
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
