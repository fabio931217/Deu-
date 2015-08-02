
function myFunction(x)
{
  
//alert("Row index is: " + x.rowIndex);
//alert(document.getElementById("datos").rows[x.rowIndex].cells[0].innerText);

var codigo = document.getElementById("cuerpo-detalles").rows[x.rowIndex].cells[0].innerText;
//$("#txtcodigo").val(document.getElementById("reporte").rows[x.rowIndex].cells[0].innerText);
$("#fecha_hora").val(document.getElementById("cuerpo-detalles").rows[x.rowIndex].cells[2].innerText);
$("#funcion_nombre").val(document.getElementById("cuerpo-detalles").rows[x.rowIndex].cells[3].innerText);
$("#acto_id").val(document.getElementById("cuerpo-detalles").rows[x.rowIndex].cells[1].innerText);

$("#dependencia_nombre").val(document.getElementById("cuerpo-detalles").rows[x.rowIndex].cells[4].innerText);

//alert(codigo);

reset();
      alertify.confirm("¿Desea Certificar?", function (e) {
        if (e) {
          //alertify.alert("Certificado con éxito");
          $("#certificar").submit();
        } else {
          alertify.alert("Certificado Cancelado");
        }
      });


}


$(function(){
    $("div.holder").jPages({
      containerID : "cuerpo-detalles",
      previous : "←",
      next : "→",
      perPage : 5,
      delay : 5
    });


  });


  function combos() 
 {

var combo = $("#combo_todo").val()
//var selected = combo.options[combo.selectedIndex].text; 
//alert(combo);

$('.combo > option[value="'+combo+'"]').attr('selected', 'selected');
//('#combo_todo > option[value="3"]').attr('selected', 'selected');

    
  }




 function checkbox() 
 {

//alert("ho");

if($("#check_todo").is(":checked")) 
{
   //$(".check").checked();
   $(".check").prop("checked", true);
}
else
{

$(".check").prop("checked", false);
}


}
