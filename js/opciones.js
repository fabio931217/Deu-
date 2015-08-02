function myFunction(x)
{
  
//alert("Row index is: " + x.rowIndex);
//alert(document.getElementById("datos").rows[x.rowIndex].cells[0].innerText);

$('#codigo_es').val(document.getElementById("datos").rows[x.rowIndex].cells[0].innerText);
$('#nombre_es').val(document.getElementById("datos").rows[x.rowIndex].cells[2].innerText);
$('#ubicacion_es').val(document.getElementById("datos").rows[x.rowIndex].cells[3].innerText);


$("#cbmestadoescenario option").each(function(){
   

   if ($(this).text()==document.getElementById("datos").rows[x.rowIndex].cells[4].innerText)
 {
   // alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
    $(this).attr("selected",true);  
 }

});

$("tr").css({
        'color':'#000',
        'border':'1px solid #fff',
        'border-top':'1px solid #ddd',
        'background':'#fff',
        

    
  })
//$('#cbmestadoescenario').val(document.getElementById("datos").rows[x.rowIndex].cells[4].innerText);

 document.getElementById("datos").rows[x.rowIndex].style.color="#fff";
 document.getElementById("datos").rows[x.rowIndex].style.background="#004000";
 
 


}

function myFunction2(x)
{
  
//alert("Row index is: " + x.rowIndex);
//alert(document.getElementById("datos").rows[x.rowIndex].cells[0].innerText);

$('#codigo_dependencia').val(document.getElementById("datos2").rows[x.rowIndex].cells[0].innerText);
$('#nombre_dependencia').val(document.getElementById("datos2").rows[x.rowIndex].cells[2].innerText);
//$('#dependencia_institucion').val(document.getElementById("datos2").rows[x.rowIndex].cells[3].innerText);


$("#cbminstitucion option").each(function(){
   

   if ($(this).text()==document.getElementById("datos2").rows[x.rowIndex].cells[3].innerText)
 {
   // alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'));
    $(this).attr("selected",true);  
 }

});

$("tr").css({
        'color':'#000',
        'border':'1px solid #fff',
        'border-top':'1px solid #ddd',
        'background':'#fff',
        

    
  })
//$('#cbmestadoescenario').val(document.getElementById("datos").rows[x.rowIndex].cells[4].innerText);

 document.getElementById("datos2").rows[x.rowIndex].style.color="#fff";
 document.getElementById("datos2").rows[x.rowIndex].style.background="#004000";
 
 


}