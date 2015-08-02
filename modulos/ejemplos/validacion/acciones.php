<?php

require_once("php/clase_base.php");
require_once("php/validation.php");

class Validacion extends clase_base {

    function validar() {
        $v = new Validation($_POST);
        $v->addRule("pais", "required", true, "Pais");
        $v->addRule("nombre", "required", true, "Nombre xxx");
        $v->addRule("correo", "mail", true, "Correo electronico"); /* Incluir el titulo del formulario */
        $v->addRule("entero", "integer", true);
        $v->addRule("decimal", "decimal", true);
        $v->addRule("decimal", "integer", true);

        //Agregar multples validaciones a un objeto
        $v->addRules("fecha", "Fecha de nacimiento", array("required" => true, "date" => true));

        //Equivalente a la linea anterior
        /*
          $v->addRule("fecha","date",true,"Fecha de nacimiento");
          $v->addRule("fecha","required",true,"Fecha de nacimiento");
         */


        $result = $v->validate();
        $errors = $result['errors'];
        $messages = $result['messages'];
        $bad_fields = $result['bad_fields'];


        $result = array();
        if (count($errors) > 0) {
            $result['error'] = true;
            $result['errors'] = $errors;
            $result['validation_messages'] = $messages;
            $result['bad_fields'] = $bad_fields;
        } else {
            $result['error'] = false;
        }
        echo json_encode($result);
    }

}

$accion = ACCION;
$f = new Validacion();
$f->$accion();
?>