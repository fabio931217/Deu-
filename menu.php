<?php
//$t1= microtime(true);	
$menu = NULL;


$acceso = "'" . implode("','", $_SESSION['acceso_menu']) . "'";

$sql = "
        SELECT 
                m.*,

                (SELECT count(*) FROM admin_menu where padre=m.codigo) as hijos,
                (SELECT 'S' FROM admin_menu_rol mr, admin_usuario u 
                        WHERE u.rol=mr.rol AND mr.menu=m.codigo AND u.persona_id='$_SESSION[persona_id]') as disponible
        FROM
                admin_menu m
        WHERE
                m.estado = '1'
                        AND m.visibilidad IN ($visibilidad)
        ORDER BY orden, codigo
	";


$sql = "SELECT 
                m.*,
                (SELECT COUNT(*) FROM admin_menu WHERE padre=m.menu) as hijos,
                (SELECT 'S' FROM admin_permiso_menu p, admin_usuario u 
                        WHERE u.rol=p.rol AND p.menu=m.menu AND u.persona_id='$_SESSION[persona_id]') as disponible
        FROM admin_menu m
        WHERE m.visible='S' AND m.acceso IN ($acceso)
        ORDER BY m.orden";
$menu = $db->select_all($sql);
?>


<ul >
    <?php
    generarMenu("");
    ?>
</ul>


<?php

function generarMenu($padre) {
    global $menu;
    if ($padre != "")
        echo "<ul>";
    foreach ($menu as $rw) {
        if ($rw['padre'] == $padre) {
            if ($rw['hijos'] == 0) {
                $href = WEB_ROOT . $rw['menu'];
            } else {
                $href = "javascript:;";
            }


            if ($rw['acceso'] == "7" && $rw['disponible'] != "S") {
                $class = "no-disponible";
            } else {
                $class = "disponible";
            }

            echo "<li class='menu-$rw[menu]'> <a class='$class' href='$href'>$rw[nombre]</a>";

            /** INICO SIGUIENTE NIVEL * */
            if ($rw['hijos'] > 0) {
                generarMenu($rw['menu']);
            }
            /** FIN SIGUIENTE NIVEL * */
            echo "</li>";
        }
    }
    if ($padre != "")
        echo "</ul>";
}
?>