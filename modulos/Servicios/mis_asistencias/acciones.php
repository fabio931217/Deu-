<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmasistencia', 'Buscar Asistencia', array('required' => true) );

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
function listarAsistencias() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
    }

    function buscar() {
        $this->validar();
        
        //PONER CODIGO AQUI
        $r=array();
        $r['tabla']= ' <tr>
        <td>1 2</td>        
        <td>17/01/2014 14:56  2</td>
        <td>Ponente 2</td>
        <td>Utch 2</td>
      
    </tr>    ';
        echo json_encode($r);

        /*
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);*/
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>