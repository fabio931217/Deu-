<?php
class Formulario extends Base {
    function validar_fecha() {
        $v = new Validation($_POST);
		$v->addRules('fechainicio', 'Fecha Inicio', array('required' => true) );
		$v->addRules('fechafin', 'Fecha Fin', array('required' => true) );
		
        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        return true;
    }
function validar_nombre() {
        $v = new Validation($_POST);
        
        $v->addRules('txtnombre', 'Nombre', array('required' => true) );
       

        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        return true;
    }
    function validar_asunto() {
        $v = new Validation($_POST);
        
        $v->addRules('txtasunto', 'Asunto', array('required' => true) );

        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        return true;
    }
function listarAsunto()
{
    $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
}
function listarNombre()
{
    $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
}
    function buscar_asunto() {
        $this->validar_asunto();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }

    function buscar_fecha() {
        $this->validar_fecha();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }

    function buscar_nombre() {
        $this->validar_nombre();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }

    function buscar_respondidos() {
        $this->validar();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }

    function buscar_sin_responder() {
        $this->validar();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }
    function buscar_todos() {
        $this->validar();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>