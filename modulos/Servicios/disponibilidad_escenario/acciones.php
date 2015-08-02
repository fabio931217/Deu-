<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('txtfechainicio', 'Fecha Inicio', array('required' => true) );
		//$v->addRules('txtfechafin', 'Fecha Fin', array('required' => true) );
		$v->addRules('txtfhorainicio', 'Hora inicio', array('required' => true) );
		$v->addRules('txthorafin', 'Hora fin', array('required' => true) );
		$v->addRules('cbmescenario', 'Escenario', array('required' => true, 'maxLength' => 30) );

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


    function consultar() {
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