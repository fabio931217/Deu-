<script type="text/javascript">


       

    var grid;
    var f;

    $(document).ready(function(e) {
alerta("H");
           grid = $.addGrid("#grid",
                {
                    url: page_root + 'listar',
                    height: 320,
                    dataType: 'json',
                    selectionMode: "single",
                    rowHeaderWidth: 1,
                    idName: "_id",
                    idField: "id",
                    recordPage: 100,
                    cols: [
                        {display: 'NO.', name: '_NUM_', width: 40, align: 'left'},
                        {display: 'NOMBRE', name: 'nombre', width: 260, align: 'left'},
                        {display: 'MENU', name: 'menu', width: 260, align: 'left'},
                        {display: 'PADRE', name: 'padre', width: 200, align: 'left'},
                        {display: 'ORDEN', name: 'orden', width: 70, align: 'left'}
                    ]}
        );
        f = new formulario(true, 650);
    });
</script>

<div style="padding:10px">
    <div class="ui-state-active titulo-formulario">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>GESTIÓN DE MENU</span> 
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

                <tr > 
                    <td class="tdi">Menu</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <input type="text" id="bmenu" name="menu" title="Menu" maxlength="100" value="" />
                    </td>            
                </tr> 
                <tr>
                    <td class="tdi">Padre</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="bpadre" name="padre" title="Padre">
                            <?php llenar_combo("SELECT menu, nombre FROM admin_menu WHERE ruta IS NULL ORDER BY nombre", true); ?>
                        </select>                
                    </td>
                </tr>

                <tr>
                    <td class="tdi">Acceso</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="bacceso" name="acceso" title="Acceso">
                            <?php llenar_combo("SELECT codigo, descripcion FROM admin_acceso ORDER BY descripcion", true); ?>
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
                    <input type="text" id="id" name="id" title="Id" maxlength="11" value="" class="no-modificable"/>
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Menu</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="menu" name="menu" title="Menu" maxlength="100" value="" />
                </td>            
            </tr> 

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre" name="nombre" title="Nombre" maxlength="50" value="" />
                </td>            
            </tr>            

            <tr>
                <td class="tdi">Padre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="padre" name="padre" title="Padre">
                        <?php llenar_combo("SELECT menu, menu FROM admin_menu ORDER BY menu", true); ?>
                    </select>                
                </td>
            </tr>

            <tr > 
                <td class="tdi">Ruta</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="ruta" name="ruta" title="Ruta" maxlength="100" value="" />
                </td>            
            </tr>
            <tr > 
                <td class="tdi">Accion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="accion" name="accion" title="Accion" maxlength="60" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Orden</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="orden" name="orden" title="Orden" maxlength="6" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Visible</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="visible" name="visible" title="Visible">
                        <option></option>
                        <option value="S">Si</option>
                        <option value="N">No</option>
                    </select>
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Acceso</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="acceso" name="acceso" title="Acceso">
                        <?php llenar_combo("SELECT codigo, descripcion FROM admin_acceso ORDER BY descripcion", true); ?>
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
