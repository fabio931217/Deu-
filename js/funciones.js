function prueba(x) {
    
    //alert("Row index is: " + x.rowIndex);

$('#idagenda').val(document.getElementById("reporte").rows[x.rowIndex+1].cells[1].innerText);
}