<?php
require_once("php/clase_base.php");

class Combo extends clase_base {

    function cargarDepartamentos() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM departamento WHERE pais_id='$_POST[pais]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

    function cargarMunicipios() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM municipio WHERE departamento_id='$_POST[departamento]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

}

$f = new Combo();
$accion = ACCION;
$f->$accion();
?>