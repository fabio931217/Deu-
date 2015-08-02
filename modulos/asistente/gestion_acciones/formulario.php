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
                        {display: 'MENU', name: 'nombre', width: 200, align: 'left'},
                        {display: 'ACCION', name: 'accion', width: 200, align: 'left'},
                        {display: 'TIPO', name: 'tipo_accion', width: 100, align: 'left'},
                        {display: 'ARCHIVO', name: 'archivo', width: 200, align: 'left'},
                        {display: 'R. PERMISO', name: 'requiere_permiso', width: 100, align: 'left'}
                    ]}
        );
        f = new formulario(true, 650);
        f.agregar2 = f.agregar;
        f.agregar = function() {

            this.agregar2();
            $("#menu").val($("#bmenu").val());
            $("#menu").attr("disabled", true);
        };
        $(".div-form-busqueda").toggle();
 
    });
</script>

<div style="padding:10px">
    <div class="ui-state-active titulo-formulario">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>GESTIÓN DE ACCIONES</span> 
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

            <div style=" text-align:center"> 
                <label  for="txt-busqueda">Menu:</label>

                <select id="bmenu" name="menu" title="Menu" style="width:400px" >
                    <?php llenar_combo("SELECT menu, nombre FROM admin_menu WHERE ruta IS NOT NULL ORDER BY menu", true); ?>
                </select>                     
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
                    <input type="text" id="id" name="id" title="Id" maxlength="10" value=""  class="no-modificable"/>
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Menu</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="menu" name="menu" title="Menu" class="no-modificable">
                        <?php llenar_combo("SELECT menu, nombre FROM admin_menu ORDER BY nombre", true); ?>
                    </select>                
                </td>
            </tr>
            <tr> 
                <td class="tdi">Accion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="accion" name="accion" title="Accion" maxlength="60" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Tipo acción</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="tipo_accion" name="tipo_accion" title="Tipo acción">
                        <?php llenar_combo("SELECT codigo, codigo FROM admin_tipo_accion ORDER BY codigo", true); ?>
                    </select>                
                </td>
            </tr>
            <tr> 
                <td class="tdi">Archivo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="archivo" name="archivo" title="Archivo" maxlength="100" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Requiere permiso</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="requiere_permiso" name="requiere_permiso" title="Requiere permiso">
                        <option></option>
                        <option value="S">Si</option>
                        <option value="N">No</option>
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
