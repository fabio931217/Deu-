$(document).ready(function(){

 
          $("#dialogo1").hide();
          $("#dialogo2").hide();
        
            
            $("#btntelefono").click(function(){

          $("#dialogo1").dialog({
            width: 610,
            //height: 510,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
      
            });

          $("#btncorreo").click(function(){

          $("#dialogo2").dialog({
            width: 610,
            //height: 510,
            show: "scale",
            hide: "scale",
            resizable: "false",
            position: "center",
            modal: "true"
          });
      
            });
        });


$(function(){

  
    
 $('#frmregistro').validate({
           rules: {

           'cbmsexo': 'required',
          
           

           'txtdocumento': { required: true, number: true },
           
           'txtapellido1': 'required',
           'txtapellido2': 'required',
           'txtnombre': 'required',
           'txtapellidos': 'required',
           'txtnombre': 'required',
           'txtdireccion': 'required',

                   
          
           },
       messages: {
            'cbmsexo': 'Seleccione sexo',
           //'cbmtipotelefono1': 'Seleccione tipo de telefono',
           //'cbmtipotelefono2': 'required',
            'cbmtipodocumento': 'Seleccione tipo de documento',
           
           

          'txtdocumento': { required: 'Debe ingresar el documento de identidad', number: 'Debe ingresar un número' },
        

           'txtapellido1': 'Debe ingresar su primer apellido',
           'txtapellido2': 'Debe ingresar su segundo apellido',
           'txtnombre': 'Debe ingresar su nombre(s)',                  
           'txtdireccion': 'Debe ingresar la dirección de residencia',
          

       },
       debug: true,
       
       submitHandler: function(form){
           enviar_variables1();
       }
    });

//##############################################################################################
$('#frmclaves').validate({
           rules: {
           'txtclave1': 'required',
          'txtclave2': { required: true , minlength: 6},
          'txtclave3': { required: true, equalTo: '#txtclave2' ,minlength: 6}
   
           },
       messages: {
          
           
      'txtclave1': 'Debe ingresar su contraseña',
       'txtclave2': { required: 'Debe ingresar su nueva contraseña'},
       'txtclave3': { required: 'Debe repetir su nueva contraseña', equalTo: 'Las contraseñas deben ser iguales'},
         
       },
       debug: true,
       
       submitHandler: function(form){
           enviar_variables4();
       }
    });

 $('#frmT').validate({
           rules: {

           'txtnumerotel': { required: true, number: true },
           'cbmtipotel': 'required',
                    
          
           },
       messages: {
          'cbmtipotel': 'Seleccione tipo de telefono',
          'txtnumerotel': { required: 'Debe ingresar un numero de telefono', number: 'Debe ingresar un número' },
        
       },
       debug: true,
       
       submitHandler: function(form){
           enviar_variables2()
       }
    });


 $('#frmC').validate({
           rules: {

           

          

           'txtcorreo1': { required: true, email: true },

          
           },
       messages: {
           
         'txtcorreo1': { required: 'Debe ingresar un correo electrónico', email: 'Ejemplo: xxxx@hotmail.com' },

                     

       },
       debug: true,
       
       submitHandler: function(form){
          enviar_variables3()
       }
    });

});


 function enviar_variables1()

{
   reset();
  alertify.set({ buttonReverse: true });
  alertify.confirm("¿Realmente se desea modificar?", function (e) {
        if (e) {

$.post("perfil.php",{

opc:1,
tipodocumento :$('#cbmtipodocumento').val(),
documento :$('#txtdocumento').val(),
nombre :$('#txtnombre').val(),
apellido1 :$('#txtapellido1').val(),
apellido2 :$('#txtapellido2').val(),
sexo :$('#cbmsexo').val(),
fechaexp:$('#fechaexp').val(),
fechanacimiento :$('#fechanacimiento').val(),
municipio_exp:$('#cbmmunicipioexp').val(),
municipio_nacimiento:$('#cbmmunicipionaci').val(),
municipio_residencia :$('#cbmmunicipiores').val(),
direccion :$('#txtdireccion').val()

},

   function(respuesta){
    alertify.alert(respuesta);
    if(respuesta=="Modificado con exito")
    {
    setTimeout ("redireccionar()", 1000);
}
  }
);

        } else {
          alertify.alert("Cancelado");
          setTimeout ("redireccionar()", 1000);
        }
      });
}


function enviar_variables2()

{
   reset();
  alertify.set({ buttonReverse: true });
  alertify.confirm("¿Realmente se desea agregar?", function (e) {
        if (e) {

$.post("perfil.php",{

opc:3,
tipo_tel:$('#cbmtipotel').val(),
telefono:$('#txtnumerotel').val()

},

   function(respuesta){
    alertify.alert(respuesta);
    if(respuesta=="Agregado con exito")
    {
setTimeout ("redireccionar()", 1000);
}
  }
);

        } else {
          alertify.alert("Cancelado");
         setTimeout ("redireccionar()", 1000);
        }
      });
}

function enviar_variables3()

{
   reset();
  alertify.set({ buttonReverse: true });
  alertify.confirm("¿Realmente se desea agregar?", function (e) {
        if (e) {

$.post("perfil.php",{

opc:5,
correo:$('#txtcorreo1').val()

},

   function(respuesta){
    alertify.alert(respuesta);
    if (respuesta=="Agregado con exito" || respuesta=="Email ya se encuentra registrado en la base de datos")
    {
    setTimeout ("redireccionar()", 1000);
}
  }
);

        } else {
          alertify.alert("Cancelado");
          setTimeout ("redireccionar()", 1000);
        }
      });
}


function redireccionar() 
{
location.href="mi_perfil";
} 


function enviar_variables4()

{
   reset();
  alertify.set({ buttonReverse: true });
  alertify.confirm("¿Realmente se desea Modificar su contraseña?", function (e) {
        if (e) {

$.post("perfil.php",{

opc:6,
clave1:$('#txtclave1').val(),
clave2:$('#txtclave3').val(),
},

   function(respuesta){
    alertify.alert(respuesta);
    if (respuesta=="Contraseña cambiada con exito")
    {
    setTimeout ("redireccionar()", 1000);
}
  }
);

        } else {
          alertify.alert("Cancelado");
setTimeout ("redireccionar()", 1000);
        }
      });
}


function redireccionar() 
{
location.href="mi_perfil";
} 


