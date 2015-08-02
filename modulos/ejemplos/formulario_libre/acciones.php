<?php
require_once("php/Encryptar.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('txt1', 'Dato', array('required' => true) );
		$v->addRules('txt2', 'Dato 2', array('required' => true) );
		//$v->addRules('txt3', 'Combo', array('required' => true, 'maxLength' => 30) );

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


    function aceptar() {
        $this->validar();
       
       //Un prev por si se necesita.
       
                   echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
        //exit(0); 
       

        //PONER CODIGO AQUI  :D  ATT: FABIO

        $sql="";
        
        //$db = $this->db; // Declaro la variable de base de datos
        //$db->query($sql);  // Ejecuto
         
       /* Asi se encrypta y desencrypta
        
        $variable_que_recibe =Encrypter::decrypt($_POST["varible_a_desencryptar"]);
        $variable_que_recibe =Encrypter::encrypt($_POST["varible_a_encryptar"]);
       

       $rs=$db->query($sql);

       if ($db->num_rows($rs)>0) //contador
       {}
    

       while ($row=$db->fetch_assoc($rs)) // fetch_assoc
        {}

       */


        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI MENSAJE A MOSTRAR AL USUARIO."; 
        echo json_encode($result);
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>