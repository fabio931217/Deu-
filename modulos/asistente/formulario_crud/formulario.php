<script type="text/javascript">

    $(document).ready(function() {
        //$("#tabla").val("persona");
        //seleccionar_tabla();


    });

    function seleccionar_tabla()
    {
        var tabla = $("#tabla").val();
        $("#titulo").val(tabla.toUpperCase().replace("_"," "));
        $("#ruta").val("modulos/" + tabla);
        $("#menu").val(tabla.replace("_","-"));
        tabla = tabla.substring(0, 1).toUpperCase() + tabla.substring(1);
        $("#titulo_menu").val(tabla.replace("_"," "));
        $.post(page_root + "cargarInfoFormulario", $("#f").values(), function(data) {
            $("#f2").html(data);
            verificar();
        });
    }

    function generar() {
        $.post(page_root + "generar", $("#f").values(), function(data) {
            try {
                var r = jQuery.parseJSON(data);
                alerta(r.msg);
                if (r.error == false) {
                    //document.getElementById("f").reset();
                    //seleccionar_tabla();
                }
            } catch (ex) {
                alerta(data);
            }
        });
    }

    function verificar() {
        $.post(page_root + "verificar", $("#f").values(), function(data) {
            $("#div-verificar").html(data);
        });
    }

    function seleccionar_tipo_acceso(v) {
        if (v == 7) {
            $("#div-roles").show();
        } else {
            $("#div-roles").hide();
        }

    }
</script>


<div style="width: 800px; margin: auto;padding:10px">
    <div class="ui-state-active" style="height:26px; line-height:26px; border-top-left-radius:10px; border-top-right-radius:10px; border-bottom:none">
        <div style="text-align:center; font-weight:bold; font-size:12pt"> 
            <span>ASISTENTE DE CREACIÓN DE FORMULARIO BÁSICO</span> 

        </div>

    </div>

    <form id="f" class="ui-dialog-content ui-widget-content" style="padding: 10px">

        <div id="f1">
            <table style="width: 100%"> 

                <tr class='ui-widget-header'>
                    <th colspan="3">CONFIGURACIÓN</th>
                </tr>
                <tr>
                    <td class="tdi">Base de datos</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="base_datos" name="base_datos" disabled="disabled">
                            <?php
                            llenar_combo("SELECT SCHEMA_NAME, SCHEMA_NAME FROM information_schema.SCHEMATA", false, $cfg['db_database_name']);
                            ?>
                        </select>
                    </td>  
                </tr>


                <tr>
                    <td class="tdi">Tabla</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="tabla" name="tabla" onchange="seleccionar_tabla()">
                            <?php
                            llenar_combo("SELECT TABLE_NAME, TABLE_NAME  FROM information_schema.TABLES "
                                    . "WHERE TABLE_SCHEMA='$cfg[db_database_name]'", true);
                            ?>
                        </select>
                    </td>  
                </tr>

                <tr>
                    <td class="tdi">Titulo formulario</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <input type="text" name="titulo_formulario" id="titulo" />
                    </td>  
                </tr>

                <tr>
                    <td class="tdi">Menú principal</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="menu_principal" name="menu_principal">
                            <?php
                            llenar_combo("SELECT menu, nombre FROM admin_menu WHERE ruta IS NULL ORDER BY nombre", true);
                            ?>
                        </select>
                    </td>  
                </tr>



                <tr>
                    <td class="tdi">Menú</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <input type="text" name="menu" id="menu" onblur="verificar()"/>
                    </td>  
                </tr>    


                <tr>
                    <td class="tdi">Titulo menu</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <input type="text" name="titulo_menu" id="titulo_menu"/>
                    </td>  
                </tr>    


                <tr>
                    <td class="tdi">Tipo de acceso</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <select id="tipo_acceso" name="tipo_acceso" onchange="seleccionar_tipo_acceso(this.value);">
                            <?php
                            llenar_combo("SELECT codigo, descripcion FROM admin_acceso ", false, '7');
                            ?>
                        </select>
                    </td>  
                </tr>

                <tr>
                    <td class="tdi">Ruta</td>
                    <td class="tdc">:</td>
                    <td class="tdd">
                        <input type="text" name="ruta" id="ruta" onblur="verificar()"/>
                    </td>  
                </tr>


            </table>
        </div>

        <div id="div-verificar">

        </div>

        <div id="div-roles" >
            <table style="width: 100%"> 

                <tr class='ui-widget-header'>
                    <th colspan="2">AGREGAR PERMISOS PARA LOS SIGUIENTES ROLES</th>
                </tr>
            </table>
            <div style="overflow: auto; max-height: 120px">
                <table style="width: 100%"> 
                    <?php
                    $sql = "SELECT * FROM admin_rol ORDER BY nombre";
                    $rs = $db->query($sql);
                    while ($rw = $db->fetch_assoc($rs)) {
                        echo "<tr>";
                        echo "<td style='width:20px'>";
                        echo "<input type='checkbox' name='rol[{$rw[id]}]' id='rol_{$rw[id]}' checked='checked' value='S' />";
                        echo "</td>";
                        echo "<td>";
                        echo "<label for='rol_{$rw[id]}'>$rw[nombre]</label>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>
        </div>
        <div id="f2">

        </div>
    </form>

    <div class="acciones">
        <input type="button" name="accion" value="Generar" onclick="generar()" />
    </div>
</div>