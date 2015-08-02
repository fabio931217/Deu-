     
        <div class="holder2"></div>
                <table align="center" width="90%">


<tbody id="agenda-detalles">

<?php


if (isset($_POST['txtbuscar']) and isset($_POST['eventoId']) ) 
{
  
  /*echo "<pre>";
  print_r($_POST);
  echo "</pre>"; 
  //exit();
*/
@$id =$_POST['eventoId'];

$s="SELECT 
a.id as codigo,
a.fecha,
a.tema,
a.cupos,
a.h_inicia,
a.h_termina,

p.nombre,
p.apellido1,
p.apellido2,

e.nombre as escenario,
e.ubicacion as ubicacion


FROM .agenda a, general.persona p, escenario e

WHERE 
a.acto_id='$id'
and p.id=a.exponente
and a.escenario_id=e.id
ORDER BY codigo ASC";
 
//$db = $this->db;
$r = $db->query($s);       
//echo $s;

while ($rw=$db->fetch_assoc($r) /* paso los datos de $r a $rt (rtable) */)

{


$Fecha=$rw['fecha'];

$r2=$db->query("SELECT * from horas");

while ($rw2=$db->fetch_assoc($r2) /* paso los datos de $r a $rt (rtable) */)
{

if ($rw2['id']==$rw['h_inicia'])
{
  $inicia=$rw2['conversion'];
}
if ($rw2['id']==$rw['h_termina'])
{
  $fin=$rw2['conversion'];
}

}

$escenario=$rw['escenario'];
$ubicacion =$rw['ubicacion'];
$cupos =$rw['cupos'];
if($cupos==0)
{
  $cupos="ILimitados";
}

$nom2=$rw['nombre']." ".$rw['apellido1']." ".$rw['apellido2'];
$nombre2= strtoupper($nom2);
$tema=$rw['tema'];


        echo "
 <tr>
                    <td>Fecha</td><td>:</td> <td>$Fecha</td>                     
                  </tr>
                   <tr>
                    <td>Hora inicio</td><td>:</td> <td>$inicia</td>                     
                  </tr>
                   <tr>
                    <td>Hora termina</td><td>:</td> <td>$fin</td>                     
                  </tr>
                   <tr>
                    <td>Exponente</td><td>:</td> <td>$nombre2</td>                     
                  </tr>
                   <tr>
                    <td>Tema</td><td>:</td> <td>$tema</td>                     
                  </tr>
                   <tr>
                    <td>Cupos</td><td>:</td> <td>$cupos</td>                     
                  </tr>
                   <tr>
                    <td>Escenario</td><td>:</td> <td>$escenario</td>                     
                  </tr>
                   <tr>
                    <td>Ubicacion(direccion)</td><td>:</td> <td>$ubicacion</td>                     
                  </tr>";

}
}
?>
                  

                  

</tbody>

                </table>    
    <!--
     <div style="text-align:center; padding-top:5px; text-align:right; border-top:1px solid silver">
        <input type="submit"  value="Imprimir agenda completa" style="font-size:14px; font-weight:bold; text-align:center; padding:3px; background-color:#E4F0E9; color:#067338;"/>
     </div>
-->
      