<?php

$web_root = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));
$path_root = __DIR__;
$p = substr($_SERVER['REQUEST_URI'], strlen($web_root));
$p = str_replace("?", "//?", $p);
$_PARAMS = explode("/", $p);

define("WEB_ROOT", $web_root);
define("PATH_ROOT", $path_root);

require_once("externos.php");

$_PARAMS[0] = $_PARAMS[0] == "" ? $cfg['menu_inicio'] : $_PARAMS[0]; //Tomar el menu inicial de la configuracion si no se establece

$sql_extra = $_PARAMS[1] == "" ? "  AND a.accion = m.accion" : " AND a.accion='$_PARAMS[1]' ";


$sql = "SELECT 
            tm.archivo, a.accion
            FROM
                admin_menu m,
                admin_accion a,
                admin_tipo_accion tm
            WHERE
                m.menu = a.menu
                    AND a.tipo_accion = tm.codigo
                    AND a.menu = '$_PARAMS[0]'
                   $sql_extra";


if ($rw = $db->select_row($sql)) {
    define("MENU", $_PARAMS[0]);
    define("PAGE_ROOT", WEB_ROOT . MENU . "/");
    define("ACCION", ($_PARAMS[1] == "") ? $rw['accion'] : $_PARAMS[1] );


    require_once($rw['archivo']);
} else { //Generar mensaje de vinculo no valido
    define("MENU", $_PARAMS[0]);
    define("PAGE_ROOT", WEB_ROOT . MENU . "/");
    define("ACCION", "");
    require_once("pagina.php");
}
?>