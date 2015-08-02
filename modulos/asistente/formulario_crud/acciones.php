<?php
require_once("php/clase_base.php");
require_once("php/validation.php");

$accion = ACCION;
$f = new Asistente();
$f->$accion();

class Asistente extends clase_base {

    function cargarInfoFormulario() {
        if ($_POST['tabla'] == "NULL") {
            return;
        }

        $db = $this->db;
        $sql = "SHOW COLUMNS FROM `$_POST[base_datos]`.`$_POST[tabla]`";
        $rs = $db->query($sql);
        echo "<br/><br/>";
        echo "<table style='width:100%; border-collapse: collapse'> ";
        echo "<tr class='ui-widget-header'>";
        echo "<th style='width:30px'></th>";
        echo "<th style='text-align:left'>CAMPO</th>";
        echo "<th style='text-align:left'>TITULO</th>";
        echo "<th style='text-align:center'>GRID</th>";
        echo "<th style='text-align:center'>FILTRO</th>";

        echo "</tr>";
        $x = 0;
        while ($rw = $db->fetch_assoc($rs)) {
            $titulo = $rw['Field'];
            if ($titulo[0] != "_") {
                $titulo[0] = strtoupper($titulo[0]);
                $titulo = str_replace("_", " ", $titulo);

                $ancho = (substr($rw['Type'], 0, 7) == "varchar") ? "200" : "";
                $grid = ( ++$x > 1 && $x <= 3) ? "checked='checked'" : "";
                echo "<tr>";
                echo "<td style='text-align:left'> <input type='checkbox' name='incluir[{$rw[Field]}]' value='S' checked='checked' /> </td>";
                echo "<td style='width:150px'> $rw[Field] </td>";
                echo "<td> <input type='text' name='titulo[{$rw[Field]}]' value='$titulo' style='width:300px'/> </td>";
                echo "<td style='text-align:center'> <input type='text' name='grid[{$rw[Field]}]' value='$ancho' style='width:40px' /> </td>";
                echo "<td style='text-align:center'> <input type='checkbox' name='filtro[{$rw[Field]}]' value='S' $grid /> </td>";
                echo "</tr>";
            }
        }

        echo "</table>";
    }

    function verificar() {
        if ($_POST['tabla'] == "NULL") {
            return;
        }
        $ruta = $_POST['ruta'];
        $menu = $_POST['menu'];

        if (file_exists($ruta)) {
            ?>

            <div class="ui-widget">
                <div class="ui-state-highlight ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                        La ruta <strong><?php echo $ruta ?></strong> ya existe. 
                        Si se continua se sobreescribiran los datos</p>
                </div>
            </div>
            <?php
        }

        $id = $this->db->select_one("SELECT id FROM admin_menu WHERE menu='$menu'");
        if ($id != "") {
            ?>

            <div class="ui-widget">
                <div class="ui-state-highlight ui-corner-all" style="margin-top: 5px; padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
                        El menu <strong><?php echo $menu ?></strong> ya existe. 
                        Si se continua se sobreescribiran los datos</p>
                </div>
            </div>
            <?php
        }
    }

    function generar() {
        ob_start();

        $v = new Validation($_POST);
        $v->addRules('base_datos', 'Base de datos', array('required' => true));
        $v->addRules('tabla', 'Tabla', array('required' => true));
        $v->addRules('titulo_formulario', 'Titulo formulario', array('required' => true));
        $v->addRules('menu_principal', 'Menu principal', array('required' => true));
        $v->addRules('menu', 'Menu', array('required' => true));
        $v->addRules('titulo_menu', 'Titulo menu', array('required' => true));
        $v->addRules('tipo_acceso', 'Tipo de acceso', array('required' => true));
        $v->addRules('ruta', 'Ruta', array('required' => true));
        $result = $v->validate();

        if ($result['messages'] != "") {//Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            echo json_encode($r);
            exit(0);
        }

        $db = $this->db;
        $base_data = $_POST[base_datos];
        $tabla = $_POST['tabla'];

        $t1 = file_get_contents("modulos/asistente/formulario_crud/acciones.txt");
        $t2 = file_get_contents("modulos/asistente/formulario_crud/formulario.txt");

        //Nombre de la clase basadado en el nombre de la tabla
        $clase = $tabla;
        $clase[0] = strtoupper($clase[0]);
        $t1 = str_replace("{CLASE}", $clase, $t1);

        //Nombre de la tabla
        $t1 = str_replace("{TABLA}", $tabla, $t1);

        //Titulo
        $t2 = str_replace("{TITULO}", $_POST['titulo_formulario'], $t2);

        //Clave primaria y validaciones
        $validaciones = "";
        $formulario = "";
        $filtros = "";
        $codigo_filtro = "";
        $grid = "";
        $auditoria = "";

        $sql = "SHOW COLUMNS FROM `$base_data`.`$tabla`";
        $rs = $db->query($sql);
        while ($rw = $db->fetch_assoc($rs)) {
            $campo = $rw['Field'];
            $titulo = $_POST['titulo'][$campo];

            //Ej: cambiar char(10) por char(10( para separar informacion
            $tipo = str_replace(")", "(", $rw['Type']);
            $tipo_info = explode("(", $tipo);

            $tipo_dato = $tipo_info[0];
            $longitud = (intval($tipo_info[1]) > 0) ? intval($tipo_info[1]) : 10;

            if ($rw['Key'] == "PRI") {
                $t1 = str_replace("{CLAVE_PRIMARIA}", $campo, $t1);
                $t2 = str_replace("{CLAVE_PRIMARIA}", $campo, $t2);
                $t1 = str_replace("{AUTO_INCREMENTAR}", ($rw['Extra'] == "auto_increment") ? "true" : "false", $t1);
            }



            if ($rw['Field'] == "_usuario") {
                $auditoria.="\$_POST['_usuario'] = \$_SESSION['usuario'];\n";
            }

            if ($rw['Field'] == "_fecha") {
                $auditoria.="\$_POST['_fecha'] = date('Y-m-d H:i:s');\n";
            }

            $sql = "SELECT * 
                    FROM information_schema.KEY_COLUMN_USAGE
                    WHERE
                    TABLE_SCHEMA='$base_data'  AND
                    TABLE_NAME ='$tabla' AND 
                    COLUMN_NAME='$campo' AND  
                    REFERENCED_TABLE_NAME IS NOT NULL
                    ";
            $fk = $db->select_row($sql);


            if ($fk != NULL) { //Llave foranea. Generar un objeto Select               
                $sql = "SHOW COLUMNS FROM `$fk[REFERENCED_TABLE_SCHEMA]`.`$fk[REFERENCED_TABLE_NAME]`";
                $rs2 = $db->query($sql);
                $rw2 = $db->fetch_assoc($rs2); // Pprimer camppo
                $rw2 = $db->fetch_assoc($rs2); // Segundo campo

                $campo1 = "$fk[REFERENCED_COLUMN_NAME]";
                $campo2 = $rw2['Field'];
                $tabla2 = ($fk['REFERENCED_TABLE_SCHEMA'] == $fk['TABLE_SCHEMA']) ?
                        $fk[REFERENCED_TABLE_NAME] :
                        "{$fk[REFERENCED_TABLE_SCHEMA]}.{$fk[REFERENCED_TABLE_NAME]}";

                $sql = "SELECT $campo1, $campo2 FROM $tabla2 ORDER BY $campo2";
                $obj = sprintf(' 
            <tr>
                <td class="tdi">%s</td>
                <td class="tdc">:</td>
                <td class="tdd">
                	<select id="%s" name="%s" title="%s">
                    	<?php llenar_combo("%s",true); ?>
                    </select>                
                </td>
            </tr>', $titulo, $campo, $campo, $titulo, $sql);
            } else { //Generar objeto input
                $oculto = ($rw['Extra'] == "auto_increment") ? ' style="display:none"' : '';
                $modificalble = ($rw['Key'] == "PRI") ? ' class="no-modificable"' : '';

                $obj = sprintf('
            <tr%4$s> 
                <td class="tdi">%1$s</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" id="%2$s" name="%2$s" title="%1$s" maxlength="%3$s" value="" %5$s/>
                </td>            
            </tr>', $titulo, $campo, $longitud, $oculto, $modificalble);
            }


            if ($_POST['incluir'][$campo]) {
                $formulario .= $obj;
            }
            /*             * **************************************************************** */
            if ($_POST['filtro'][$campo]) {
                if ($fk != NULL) { //Llave foranea. Generar un objeto Select  
                    $codigo_filtro .= sprintf('
        if ($_GET["%1$s"] != "" && $_GET["%1$s"] != "NULL") { 
            $s.= " AND %s = \'$_GET[%1$s]\'";
        }', $campo);
                } else {
                    switch ($tipo_dato) {
                        case "int":
                        case "decimal":
                        case "double":
                        case "date":
                            $type = ($tipo_dato == "date") ? "date" : "text";
                            $obj = sprintf('
            <tr> 
                <td class="tdi">%1$s</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="%3$s" id="%2$s" name="desde_%2$s" maxlength="10" style="width:120px" placeholder="Desde"/> - 
                    <input type="%3$s" id="%2$s" name="hasta_%2$s" maxlength="10" style="width:120px" placeholder="Hasta"/>
                </td>            
            </tr>', $titulo, $campo, $type);
                            $codigo_filtro .= sprintf('
        if ($_GET["desde_%1$s"] != "" && $_GET["desde_%1$s"] != "NULL") { 
            $s.= " AND %s >= \'$_GET[desde_%1$s]\' ";
        }', $campo);

                            $codigo_filtro .= sprintf('
        if ($_GET["hasta_%1$s"] != "" && $_GET["hasta_%1$s"] != "NULL") { 
            $s.= " AND %s <= \'$_GET[hasta_%1$s]\' ";
        }', $campo);

                            break;
                        default:
                            $codigo_filtro .= sprintf('
        if ($_GET["%1$s"] != "" && $_GET["%1$s"] != "NULL") { 
            $s.= " AND %s LIKE \'%%" . str_replace(" ","%%",$_GET[\'%1$s\']) ."%%\' ";
        }', $campo);

                            break;
                    }
                } // if ($fk != NULL)
                $filtros .= $obj;
            } // if ($_POST['filtro'][$campo]) {

            $v = "";
            if ($rw['Null'] == "NO" && $rw['Extra'] != "auto_increment") {
                $v .= "'required' => true, ";
            }

            if ($fk == NULL && $rw['Key'] != "PRI") {

                switch ($tipo_dato) {
                    case "int":
                        $v .= "'integer' => true, ";
                        break;
                    case "decimal":
                    case "double":
                        $v .= "'decimal' => true, ";
                        break;
                    case "date":
                        $v .= "'date' => true, ";
                        break;
                }

                //Longitud maxima, $tipo_info[1] es la longitud original
                if (intval($tipo_info[1]) > 0) {
                    $v .= "'maxLength' => $longitud, ";
                }
            }
            $v = trim($v, ", ");
            if ($v != "" && $_POST['incluir'][$campo]=="S") {
                $validaciones .= sprintf("\t\t\$v->addRules('%s', '%s', array(%s) );\n", $campo, $titulo, $v);
            }

            /* GRID */
            $ancho = intval($_POST['grid'][$campo]);
            if ($ancho > 0) {
                $grid .= sprintf("\t\t\t\t\t\t{display: '%s', name: '%s', width: %s, align: 'left'}, \n", strtoupper($titulo), $campo, $ancho);
            }
            /*  */
        } //While
        //Cambiar los ids del formulario de busqueda para que no sean iguales al formulario general
        $filtros = str_replace('id="', 'id="b', $filtros);

        $t1 = str_replace("{VALIDACION}", $validaciones, $t1);
        $t1 = str_replace("{FILTROS_ACCIONES}", $codigo_filtro, $t1);
        $t1 = str_replace("{AUDITORIA}", $auditoria, $t1);

        $t2 = str_replace("{FORMULARIO}", $formulario, $t2);
        $t2 = str_replace("{FILTROS_FORMULARIO}", $filtros, $t2);
        $t2 = str_replace("{GRID}", trim($grid, "\n, "), $t2);

        $ruta = $_POST['ruta'];
        @mkdir($ruta, 0777, true);
        @chmod($ruta, 0777);

        $file1 = "$ruta/acciones.php";
        $file1 = str_replace("//", "/", $file1);
        file_put_contents($file1, $t1);
        chmod($file1, 0777);

        $file2 = "$ruta/formulario.php";
        $file2 = str_replace("//", "/", $file2);
        file_put_contents($file2, $t2);
        chmod($file2, 0777);

        $menu = $_POST['menu'];
        $db->query("DELETE FROM admin_accion WHERE menu='$menu'");
        $db->query("DELETE FROM admin_menu WHERE menu='$menu'");

        $db->query("INSERT INTO admin_menu (`menu`, `padre`, `nombre`, `ruta`, `accion`, `orden`, `visible`,acceso) 
            VALUES ('$menu', '$_POST[menu_principal]', '$_POST[titulo_menu]', '$ruta', 'ver', '1', 'S','$_POST[tipo_acceso]') ");

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'agregar', 'json', 'acciones.php','S') ");
        //echo $db->error(). "\n"; 

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'modificar', 'json', 'acciones.php','S') ");

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'eliminar', 'json', 'acciones.php','S') ");

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'listar', 'json', 'acciones.php','N') ");

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'asignar', 'json', 'acciones.php','N') ");

        $db->query("INSERT INTO `admin_accion` (`menu`, `accion`, `tipo_accion`, `archivo`,`requiere_permiso`) 
                    VALUES ('$menu', 'ver', 'pagina', 'formulario.php','S') ");
        //Agregar permisos         
        if (is_array($_POST['rol']) && $_POST['tipo_acceso'] == '7') {
            foreach ($_POST['rol'] as $rol => $v) {
                if ($v == "S") {
                    $db->query("INSERT IGNORE INTO admin_permiso_menu (rol,menu)"
                            . "VALUES('$rol','$menu')");
                    $db->query("INSERT IGNORE INTO admin_permiso_accion (rol,accion) "
                            . "(SELECT '$rol',id FROM admin_accion WHERE menu='$menu')");
                }
            }
        }
        $t = ob_get_contents();
        ob_clean();

        if ($t == "") {
            $r['error'] = false;
            $r['msg'] = 'Formulario generado con exito.';
            echo json_encode($r);
        } else {
            $r['error'] = true;
            $r['msg'] = "Formulario generado con errores. \n\n$t";
            echo json_encode($r);
        }
    }

}
