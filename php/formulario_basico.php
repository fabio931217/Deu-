<?php

require_once("validation.php");

class formulario_basico {

    protected $tabla, $clave_primaria, $secuencia, $auto_incremental;
    protected $sql, $sql_fila, $campo_ordenar;
    protected $db;

    public function __construct($tabla, $clave_primaria, $auto_incremental = true, $campo_ordenar = "") {
        $this->tabla = $tabla;
        $this->clave_primaria = $clave_primaria;
        $this->db = $GLOBALS['db'];
        $this->secuencia = $tabla . "_" . $clave_primaria . "_seq";
        $this->auto_incremental = $auto_incremental;
        $this->campo_ordenar = $campo_ordenar;
    }

    function setSQLFila($sql) {
        $this->sql_fila = $sql;
    }

    protected function getSQL() {
        return "SELECT * FROM " . $this->tabla;
    }

    protected function fila($agregar = false) {
        $this->sql = $this->getSQL();
        if ($this->sql_fila != "") {
            $sql = $this->sql_fila;
        } else {
            $sql = "SELECT * FROM ($this->sql) AS t WHERE $this->clave_primaria='%s' ";
        }

        $id = "";
        if (($agregar == true && $this->auto_incremental == false) || $agregar == false) {
            $id = $_POST[$this->clave_primaria];
        } else {
            $id = $this->db->last_insert_id($this->secuencia);
        }

        $sql = sprintf($sql, $id);
        return $this->db->select_row($sql);
    }

    function validar() {
        //True: Indica que SI se superó la validación
        return true;
    }

    function listar() {
        $sql = $this->getSQL();

        $result['total'] = $this->db->count_rows($sql);

        $offset = ($_GET['page'] - 1) * $_GET['recordpage'];
        $limit = $_GET['recordpage'];

        $rs = $this->db->select_limit($sql, $limit, $offset);
        $result['rows'] = array();
        $num = $offset + 1;
        while ($rw = $this->db->fetch_assoc($rs)) {
            $rw['_NUM_'] = $num++;
            $result['rows'][] = $rw;
        }
        //$result['rows'] = $this->db->fetch_all($rs);
        echo json_encode($result);
    }

    function agregar() {
        if ($this->validar() == false)
            exit(0); //No seguir si no se supera la validación

        if ($this->auto_incremental == true)
            unset($_POST[$this->clave_primaria]);

        $sql = $this->db->make_insert($this->tabla, $_POST);
        @$this->db->query($sql);

        $r = array();
        if ($this->db->error()) {
            $r['error'] = true;
            $r['msg'] = $this->db->error();
        } else {
            $r['error'] = false;
            $r['msg'] = "Registro agregado con éxito";
            $r['row'] = $this->fila(true);
        }
        echo json_encode($r);
    }

    function asignar() {
        $pk = $this->clave_primaria;
        $sql = "select * from $this->tabla where $pk='$_GET[id]'";
        $rw = $this->db->select_row($sql);
        echo json_encode($rw);
    }

    function modificar() {
        if ($this->validar() == false)
            exit(0); //No seguir si no se supera la validación

        $pk = $this->clave_primaria;
        $sql = $this->db->make_update($this->tabla, $_POST) . " where $pk='$_POST[$pk]'";
        @$this->db->query($sql);

        $r = array();
        if ($this->db->error()) {
            $r['error'] = true;
            $r['msg'] = $this->db->error();
        } else {
            $r['error'] = false;
            $r['msg'] = "Registro modificado con éxito.";

            $r['row'] = $this->fila(false);
            //$r['row']=$this->db->select_row("select * from general.persona where identifica='$_POST[identifica]'");	
        }
        echo json_encode($r);
    }

    function eliminar() {
        $pk = $this->clave_primaria;
        $sql = "delete from $this->tabla where $pk='$_POST[$pk]'";
        $query = $this->db->query($sql);

        $r = array();
        if ($this->db->error()) {
            $r['error'] = true;
            $r['msg'] = $this->db->error();
        } else {
            $r['error'] = false;
            $r['msg'] = "Registro eliminado con éxito.";
        }
        echo json_encode($r);
    }

}


?>