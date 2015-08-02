function validar() {

var e1=0;
var e2=0;
var e3=0;
var e4=0;



var msj11="";
var msj22="";
var msj33="";
var msj44="";

var msj1="En registrar reunion:";
var msj2="En registrar organizadores:";
var msj3="En programar agenda:";
var msj4="En registrar Conclusion:";



if ($("#txtnombre").val()=="") {e1+=1;msj11+="Ingrese nombre"+'<br/>';}
if ($("#descripcion").val()=="") {e1+=1;msj11+="Ingrese descripcion"+'<br/>';}
if ($("#objetivos").val()=="") {e1+=1;msj11+="Ingrese objetivos"+'<br/>';}



if ($("#cbmdependencia").val()=="") {e2+=1;msj22+="Ingrese dependencia"+'<br/>';};
if ($("#usuario").val()=="") {e2+=1;msj22+="Ingrese usuario"+'<br/>';};
if ($("#cbmfuncion").val()=="") {e2+=1;msj22+="Ingrese funcion"+'<br/>';};

if ($("#txtfecha").val()=="") {e3+=1;msj33+="Ingrese fecha"+'<br/>';};
if ($("#txtexponente").val()=="") {e3+=1;msj33+="Ingrese exponente"+'<br/>';};
if ($("#txttema").val()=="") {e3+=1;msj33+="Ingrese tema"+'<br/>';};
if ($("#txtcupos").val()=="") {e3+=1;msj33+="Ingrese cupos solo numeros"+'<br/>';};

if ($("#conclusiones").val()=="") {e4+=1;msj44+="Ingrese conclusion"+'<br/>';};


if (e1>0)
{
   
  $("#msj1").html(msj1);
  $("#msj1mensaje").html(msj11);
}else
{
  $("#msj1").html("");
  $("#msj1mensaje").html("");
}

if (e2>0)
{
  
  $("#msj2").html(msj2);
  $("#msj2mensaje").html(msj22);
  
}else
{
  $("#msj2").html("");
  $("#msj2mensaje").html("");
}
if (e3>0)
{
  
  $("#msj3").html(msj3);
  $("#msj3mensaje").html(msj33);
  
}else
{
  $("#msj3").html("");
  $("#msj3mensaje").html("");
}
if (e4>0)
{
  
  $("#msj4").html(msj4);
  $("#msj4mensaje").html(msj44);
  
}else
{
  $("#msj4").html("");
  $("#msj4mensaje").html("");
}

if (e1>0 || e2>0 || e3>0 || e4>0)
 { 
  $( "#dialog" ).dialog( "open" );
           
}else
{
  

     
bootbox.confirm("¿Desea registrar Reunion?<br/> Nota: los datos mal ingresados no seran regitrados.", function(result) {

if (result==true) 
{



     $.post(page_root + "buscar", $("#frmreuniones").values(), function(data) {
            var r = jQuery.parseJSON(data);
            
           if (r.msg==1) { bootbox.alert("Acto registrado con exito"); recargar_pagina(4000);}
           else{
             bootbox.alert(r.msg); $("#error").html(r.msg);
               $("#existe").css({"display":"block","font-size":"200%"});
           }
                          
        });
 
 
 




}
});


}     






}

