<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('nombre_usuario', 'Nombre usuario', array('required' => true) );
		$v->addRules('cbmpregunta', 'Pregunta', array('required' => true, 'maxLength' => 30) );
		$v->addRules('respuesta', 'Respuesta', array('required' => true) );

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
        $s="SELECT * FROM  persona WHERE identifica='$_POST[nombre_usuario]' and cod_pregunta='$_POST[cbmpregunta]' and respuesta='$_POST[respuesta]'";
        $r=$db->query($s);
$m="";
if ($db->num_rows($r)>0) 
{
            $nueva_clave=clave('123456');
            $sql="UPDATE  persona SET clave='$nueva_clave',hash='$nueva_clave'  WHERE identifica='$_POST[nombre_usuario]'";
            $db->query($sql);

            $m="Su nueva clave es 123456 por favor ingresar y cambiar de clave";
}
else
{
$m="Datos incorrectos";
}
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = $m; 
        echo json_encode($result);
    }

}
$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>