
  <script type="text/javascript" language="javascript" class="init">
//solo es este codigo y ya;
$(document).ready(function() {
  $('#tabla').dataTable();
} );

  </script>



<div id="existe" class="alert-box error" style="display:none"><span>error: </span><p id="error"> </p></div>
<div id="existe2" class="alert-box success" style="display:none"><span>Exito: </span><p id="error2"> </p></div>

<div style="width:900px;min-height:160px; margin:auto; padding-top:10px">


<div style="width:140px;float:left">
   <img src="img/iconos/base.png" alt=""  style="margin-top:3px;padding-right:26px;" />
</div>

<div  style="width:600px; margin:auto; margin-top:0px">
    <form id="formulario">

     <table style="width:100%">

            
      </table>

      <table id="tabla" class="display" cellspacing="0" width="100%">
       
        <thead>
        <tr>
                <th colspan="7">EJEMPLO DE PAGINAR TABLAS</th>
        </tr>
          <tr>
            <th>No.</th>
            <th>Nombre</th>
            <th>Posicion</th>
            <th>Oficion</th>
            <th>Edad</th>
            <th>fecha</th>
            <th>Salario</th>
          </tr>
        </thead>

        <tfoot>
          <tr>
            <th>No.</th>
            <th>Nombre</th>
            <th>Posicion</th>
            <th>Oficion</th>
            <th>Edad</th>
            <th>fecha</th>
            <th>Salario</th>
          </tr>
        </tfoot>

        <tbody>
          
          <?php
          $n=0;
          for ($i=0; $i <100 ; $i++) { 
            $n++;
            echo "<tr>
            <td>$n</td>
            <td>FABIO GARCIA ALVAREZ</td>
            <td>Regional Director</td>
            <td>Colombia</td>
            <td>21</td>
            <td>2011/03/21</td>
            <td>$3'056,250</td>
          </tr>
            ";
          }

          ?>
        
        </tbody>
      </table>


        
    

    </form>
</div>
</div>