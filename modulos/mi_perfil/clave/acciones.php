<?php
require_once("php/Encryptar.php");
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('clave1', 'Clave Actual', array('required' => true) );
		$v->addRules('clave2', 'Clave Nueva', array('required' => true, 'length' => array(5, 16) ));
		$v->addRules('clave3', 'Repetir Clave', array('required' => true, 'length' => array(5, 16)));

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
        
       $db = $this->db;
        
        $r=array();
        $clave_actual = $db->select_one("SELECT hash FROM  persona WHERE identifica='$_SESSION[usuario]'");
       
        $clave =Encrypter::encrypt($_POST['clave1']);
        $clave2 =Encrypter::encrypt($_POST['clave2']);
        $clave3 =Encrypter::encrypt($_POST['clave3']);

        if( $clave_actual !=$clave)
        {
            $r['error']=true;
            $r['msg']="La contraseña escrita no coinciden con la actual.";
        }
        else if ( $clave ==  $clave2  )
        {
            $r['error']=true;
            $r['msg']="La clave antigua y la nueva no pueden ser iguales.";     
        }
        else if( trim($_POST['clave2'])=="" )
        {
            $r['error']=true;
            $r['msg']="La nueva contraseña no puede estar en blanco.";
        }
        else if( $clave2 != $clave3 )
        {
            $r['error']=true;
            $r['msg']="Debe escribir dos veces la nueva contraseña";
        }
        else
        {
            $nueva_clave=Encrypter::encrypt($_POST['clave2']);
            $sql="UPDATE persona SET clave='$nueva_clave',hash='$nueva_clave'  WHERE identifica='$_SESSION[usuario]'";
            $db->query($sql);
            $r['error']=false;
            $r['msg']="La clave ha sido cambiada con éxito,<br/> se cerrara la sesión automáticamente para que vuelva a ingresar con su nueva clave";
            session_destroy();      
        }
        
        echo json_encode($r);
 
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>