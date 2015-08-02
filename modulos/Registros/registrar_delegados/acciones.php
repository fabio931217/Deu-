<?php

class Formulario extends Base {

    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmtipo', 'Tipo Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmevento', 'Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('txtdocumento', 'Documento', array('required' => true) );

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

function cargarEventos() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipo]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }

function listarPersonas() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT identifica as id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
    }

    function buscar() {
        $this->validar();
        
       $id = $_POST['cbmevento'];
                    $delegado= $_POST['persona_id'];
                    
                    $db=$this->db;
                    $s="SELECT * FROM delegados WHERE usuario='$delegado' and acto='$id'";
                    $r=$db->query($s);
                    
                    if ($db->num_rows($r))
                    {
                    
                    $result=array();
                    $result["error"] = true;
                    $result["msg"] ="Usuario ya tiene delegacion asignada"; 
                    echo json_encode($result);
                    exit(0);
                    }
                    
                    $sql="INSERT INTO delegados(
                    usuario,
                    acto
                    )
                    values(
                    '$delegado',
                    '$id'
                    )";
                    $db->query($sql);
                    
                    $error="Registrado con exito";
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
        
     
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>