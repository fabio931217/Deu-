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
						{display: 'IDENTIFICA', name: 'identifica', width: 200, align: 'left'}, 
						{display: 'APELLIDO1', name: 'apellido1', width: 200, align: 'left'}, 
						{display: 'APELLIDO2', name: 'apellido2', width: 200, align: 'left'}, 
						{display: 'NOMBRE', name: 'nombre', width: 200, align: 'left'}, 
						{display: 'NOMBRE1', name: 'nombre1', width: 200, align: 'left'}, 
						{display: 'NOMBRE2', name: 'nombre2', width: 200, align: 'left'}, 
						{display: 'DIRECCION', name: 'direccion', width: 200, align: 'left'}, 
						{display: 'CLAVE', name: 'clave', width: 200, align: 'left'}, 
						{display: 'TAG', name: 'tag', width: 200, align: 'left'}, 
						{display: 'HASH', name: 'hash', width: 200, align: 'left'}, 
						{display: 'FOTO', name: 'foto', width: 200, align: 'left'}
                    ]}
        );
        f = new formulario(true,650);
    });
</script>

<div>
    <div class="ui-state-active titulo-formulario">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>PERSONA</span> 
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
                <td class="tdi">Identifica</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="bidentifica" name="identifica" title="Identifica" maxlength="15" value="" />
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
                <td class="tdi">Identifica</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="identifica" name="identifica" title="Identifica" maxlength="15" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Fechaexp</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="fechaexp" name="fechaexp" title="Fechaexp" maxlength="10" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Tipoide</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="tipoide" name="tipoide" title="Tipoide" maxlength="2" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Municipioexp</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="municipioexp" name="municipioexp" title="Municipioexp">
                    	<?php llenar_combo("SELECT codigo, nombre FROM municipios ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>
            <tr> 
                <td class="tdi">Apellido1</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="apellido1" name="apellido1" title="Apellido1" maxlength="80" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Apellido2</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="apellido2" name="apellido2" title="Apellido2" maxlength="80" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre" name="nombre" title="Nombre" maxlength="80" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Nombre1</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre1" name="nombre1" title="Nombre1" maxlength="80" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Nombre2</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="nombre2" name="nombre2" title="Nombre2" maxlength="80" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Fechanaci</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="fechanaci" name="fechanaci" title="Fechanaci" maxlength="10" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Sexo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="sexo" name="sexo" title="Sexo">
                    	<?php llenar_combo("SELECT codigo, nombre FROM sexo ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr> 
            <tr>
                <td class="tdi">Municipionaci</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="municipionaci" name="municipionaci" title="Municipionaci">
                    	<?php llenar_combo("SELECT codigo, nombre FROM municipios ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>
            <tr> 
                <td class="tdi">Direccion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="direccion" name="direccion" title="Direccion" maxlength="80" value="" />
                </td>            
            </tr> 
            <tr>
                <td class="tdi">Municipiores</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="municipiores" name="municipiores" title="Municipiores">
                    	<?php llenar_combo("SELECT codigo, nombre FROM municipios ORDER BY nombre",true); ?>
                    </select>                
                </td>
            </tr>
            <tr> 
                <td class="tdi">Clave</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="clave" name="clave" title="Clave" maxlength="40" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Tag</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="tag" name="tag" title="Tag" maxlength="1" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Fecha</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="fecha" name="fecha" title="Fecha" maxlength="10" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Hash</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="hash" name="hash" title="Hash" maxlength="40" value="" />
                </td>            
            </tr>
            <tr> 
                <td class="tdi">Foto</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="foto" name="foto" title="Foto" maxlength="100" value="" />
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
