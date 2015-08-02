<?php

function obtener_ruta_menu($menu, $accion) {
    global $db;
    $sql = "	SELECT 
				CONCAT_WS('/', m.ruta, a.archivo) as ruta, m.acceso
			FROM admin_accion a, admin_menu m
			WHERE a.menu=m.menu AND a.menu='$menu' AND a.accion='$accion'";

    if ($rw = $db->select_row($sql)) {

        if (in_array($rw['acceso'], $_SESSION['acceso_menu'])) {

            if ($rw['acceso'] == "7") {
                $sql = "SELECT 'S' FROM admin_permiso_menu p, admin_usuario u 
						WHERE u.rol=p.rol AND p.menu='$menu' AND p.rol='$_SESSION[usuario_rol]'";
                $p = $db->select_one($sql);
                if ($p != "S") {
                    return array("error" => true, "msg" => "Acceso denegado !!!!");
                }

                //Verificar si se tiene permiso para la acción
                $sql = "SELECT  a.requiere_permiso, pa.id AS permiso
						FROM admin_accion  a LEFT JOIN  admin_permiso_accion pa ON a.id=pa.accion
						WHERE  a.menu='$menu' AND a.accion='$accion'";
                $rw2 = $db->select_row($sql);
                if ($rw2['requiere_permiso'] != "N") {
                    if ($rw2['permiso'] == "") {
                        return array("error" => true, "msg" => "Acceso denegado !!!!");
                    }
                }
            }

            $r = str_replace("//", "/", $rw['ruta']);
            if (file_exists($r)) {  //Verificar que exista la ruta.
                return array("error" => false, "ruta" => $r);
            } else {
                return array("error" => true, "msg" => "Ruta no valida !!!");
            }
        } else {
            return array("error" => true, "msg" => "Acceso denegado !!!");
        }
    } else { //No se encontro la combinación en la base de datos
        return array("error" => true, "msg" => "Vinculo no valido !!!");
    }
}

function escape_string($v) {
    global $db;
    return $db->escape_string($v);
 
}

/*
  function clave($clave) {
  $salt1 = "A3TEIK%l.sl9";
  $salt2 = "ASFDS";
  $v = sha1($clave);
  return md5(sha1($v) . md5($salt2) . sha1($extra2));
  }
 */

function clave($clave, $extra1 = "6y", $extra2 = "6bvj6") {
    if (CRYPT_SHA512 == 1) {
        $salt1 = "{$extra1}bP5MrcqS7wsMXUPJ";
        $salt2 = "{$extra1}QvMQcHJXNhCtAmvy";
        $v = crypt($clave, '$6$rounds=6000$' . $salt1 . '$');
        return md5(sha1($v) . md5($salt2) . sha1($extra2));
    }
}

function llenar_combo($sql, $blanco = false, $predeterminado = "") {
    global $db;
    if ($blanco == true)
        echo '<option value=""></option>';
    $rs = @$db->query($sql);

    while ($rw = @$db->fetch_row($rs)) {
        $sel = (trim($rw[0]) == $predeterminado) ? "selected='selected'" : "";
        echo "<option $sel value='$rw[0]'>$rw[1]</option>";
    }
}

function llenar_combo2($sql, $blanco = false, $predeterminado = "") {
    global $db;
    if ($blanco == true)
        //echo '<option value=""></option>';
    $rs = @$db->query($sql);

    while ($rw = @$db->fetch_row($rs)) {
        $sel = (trim($rw[0]) == $predeterminado) ? "selected='selected'" : "";
        echo "<option $sel value='$rw[0]'>$rw[1]</option>";
    }
}

function alerta($msg) {
    ?>
    <div class="ui-widget">
        <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                <strong>Advertencia:</strong>  <?php echo $msg ?>
            </p>
        </div>
    </div>                     
    <?php
}

function tabla_dato($sql) {
    $db = $GLOBALS['db'];

    $totales = array();

    echo '<table style=" width:100%; ; border-collapse:collapse; border: 1px solid ' . BORDE_HTML . '" border="1">';
    echo '<tr style="font-weight:bold; background-color:' . FONDO_HTML_TITULO . '">';
    $rs = $db->query($sql);
    $i = 0;
    while ($f = $db->fetch_field($rs)) {
        if ($i == 0) {
            echo "<td style='text-align:left'>" . $f->name . "</td>";
        } else {
            echo "<td style='text-align:center'>" . $f->name . "</td>";
        }

        $i++;
    }
    echo "</tr>";


    while ($rw = $db->fetch_row($rs)) {
        $color = ($color == FONDO_HTML) ? "" : FONDO_HTML;
        echo "<tr style='background-color: $color'>";
        foreach ($rw as $i => $v) {

            if ($i == 0) {
                //echo "<td style='font-weight:bold'>".$rw[$i]."</td>";
                echo "<td>" . $rw[$i] . "</td>";
            } else {
                echo "<td style='text-align:center'>" . $rw[$i] . "</td>";
            }
            $totales[$i] += $rw[$i];
        }

        echo "</tr>";
    }


    //TOTALES
    echo '<tr style="font-weight:bold; background-color:' . FONDO_HTML_TITULO . '">';
    $rs = $db->query($sql);
    $i = 0;
    while ($f = $db->fetch_field($rs)) {
        if ($i == 0) {
            echo "<td style='text-align:lef; font-weight:bold' >TOTALES</td>";
        } else {
            echo "<td style='text-align:center'>" . $totales[$i] . "</td>";
        }

        $i++;
    }
    echo "</tr>";



    echo "</table>";
}
?>