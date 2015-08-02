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
						{display: 'CORREO', name: 'correo', width: 800, align: 'left'}
                    ]}
        );
        f = new formulario(true,650);
    });
</script>

<div>
    <div class="ui-state-active titulo-formulario">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>EMAIL</span> 
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
        <div style="width:60%; margin:auto">
            <table style="width:100%">
                <tr class="ui-widget-header">
                    <th colspan='3'>BUSQUEDA</th>
                </tr>

            <tr> 
                <td class="tdi">Correo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="bcorreo" name="correo" title="Correo" maxlength="100" value="" />
                </td>            
            </tr>
            </table>
            <div class="acciones"> 
                <input type="button" value="Buscar" class='boton-buscar' onclick="f.buscar()" />
                <input type="button" value="Limpiar" class='boton-limpiar' onclick="$('#form-busqueda')[0].reset(); f.buscar()" />
            </div>
        </div>
    </form>

    <div id="grid" class="grid"></div>  

    <div class="acciones">
        <input type="button" name="accion" value="Agregar" onclick="f.agregar()" />
        <input type="button" name="accion" value="Mostrar" onclick="f.mostrar()" />
        <input type="button" name="accion" value="Modificar" onclick="f.modificar()" />
        <input type="button" name="accion" value="Eliminar" onclick="f.eliminar()" />
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
                    <input type="text" id="id" name="id" title="Id" maxlength="20" value=""  class="no-modificable"/>
                     <input type="text" id="identifica" name="identifica" title="Identifica" maxlength="11" value="<?php echo $_SESSION['persona_id'] ?>"  class="no-modificable"/>
               
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Correo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="correo" name="correo" title="Correo" maxlength="100" value="" />
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
