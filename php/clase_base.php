<?php

class Base {

    protected $db;
    protected $usuario_activo;

    public function __construct() {
        $this->db = $GLOBALS['db'];
    }

}

//Para compactibilidad con formularios antiguos
class clase_base extends Base { 
    
}

?>