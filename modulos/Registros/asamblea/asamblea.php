<?php

$sql="SELECT identifica, CONCAT_WS('',nombre,apellido1,apellido2) as nombre FROM general.persona limit 10";

$rs = $db->query($sql);

      
       while ($rw  = $db->fetch_assoc($rs) /* paso los datos de $r a $rt (rtable) */)
        {

$nombre= $rw['nombre'];
$id=$rw['identifica'];

            @$funcion.="'$id - $nombre',";
           
        }

       // echo $funcion;

?>

<link href="css/smart_wizard_vertical.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.smartWizard-2.0.min.js"></script>
<script type="text/javascript" src="js/validarregistrar_asamblea.js"></script>

<script>
$(function() {  
auto();
});

function auto(){
   $(".usuario").autocomplete({
    source: "auto_usuarios.php",
    minLength: 3
  });   
}
</script>

<script type="text/javascript">

function comboFuncion()
    {
       $.get(page_root + "comboFuncion", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmfuncion").html(r);
         });
    }
    function comboDependencia()
    {
        $.get(page_root + "comboDependencia", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmdependencia").html(r);
         });
    }
     function comboEscenario()
    {
        $.get(page_root + "comboEscenario", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
            $(".cbmescenario").html(r);
         });
    }
     function comboHoras()
    {
        $.get(page_root + "comboHoras", "id=" + 1, function(data) {
            var r = jQuery.parseJSON(data);
           $(".cbmhora").html(r);
         });
    }


    $(document).ready(function(){
        //  Wizard 1    
     $('#wizard1').smartWizard({transitionEffect:'fade',onFinish:onFinishCallback});
        //  Wizard 2
     
      function onFinishCallback(){
        validar();
        }     
        });
</script>
<form id="frmasamblea">

<table align="center" border="0" cellpadding="0" cellspacing="0" >
<tr>
<td>

        <div id="wizard1" class="swMain">
            <ul>
                <li><a href="#step-1">
                <span class="stepNumber">1</span>
                <span class="stepDesc">
                   Registrar asamblea<br />
                   <small></small>
                </span>
            </a></li>
                <li><a href="#step-2">
                <span class="stepNumber">2</span>
                <span class="stepDesc">
                   Registrar organizadores<br />
                   <small></small>
                </span>
            </a></li>
                <li><a href="#step-3">
                <span class="stepNumber">3</span>
                <span class="stepDesc">
                   Programar agenda<br />
                   <small></small>
                </span>                   
             </a></li>
                <li><a href="#step-4">
                <span class="stepNumber">4</span>
                <span class="stepDesc">
                   Enviar citacion<br />
                   <small></small>
                </span>                   
            </a></li>
           
            <li><a href="#step-5">
                <span class="stepNumber">5</span>
                <span class="stepDesc">
                   Conclusiones<br />
                   <small></small>
                </span>                   
            </a></li>
            </ul>

         <div id="step-1">   
            <h2 class="StepTitle">Registrar asamblea</h2>


            <table width="80%" style="margin:auto;margin-top:100px">
              
               <tr>
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd" style="padding:0;">
                    <input type="text"  name="txtnombre" id="txtnombre" maxlength="200" style="width:100%" /> 
               
                </td>
            </tr>   
            
            <tr>
                <td class="tdi" style="width:145px">Descripcion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <textarea id="descripcion" name="descripcion" style="height:70px;width:100%;border-radius:4px"></textarea>
                   
                </td>
            </tr>
            
             <tr>
                <td class="tdi" style="width:145px">Objetivos</td>
                <td class="tdc">:</td>
                <td class="tdd">
                <textarea id="objetivos" name="objetivos" style="height:70px;width:100%;border-radius:4px"></textarea>
                  
                </td>
            </tr>
        

              
            </table>
                            
        </div>
        <div id="step-2">
            <h2 class="StepTitle">Registrar Organizadores</h2>  



  
      <table align="center" width="98%" style="margin-top:50px" border="0">
       
        <thead>
          <tr>
            <th width="150px">Dependencia</th>
            <th >Usuario</th>
            <th width="150px">Funcion</th>
            <th width="22">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td ><select id="cbmdependencia" name="cbmdependencia[]" class="chosen-select" onChange="comboFuncion()" >
              <?php 
              llenar_combo2("SELECT d.id as codigo,CONCAT_WS(' ',i.nombre,' : ',d.nombre) as nombre FROM dependencia d, institucion i WHERE i.codigo=d.institucion_id ORDER BY nombre",true)
              ?>
            </select></td>
            <td><input type="text" name="usuario[]" id="usuario" class="usuario"></td>
            <td ><select id="cbmfuncion" name="cbmfuncion[]" class="chosen-select">
              <?php
              llenar_combo2("SELECT * FROM Funcion",true);
              ?>
            </select></td>
           
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" align="right">
                <button type="button" class="clsAgregarFila"  style="width:100%;padding-bottom:8px">Agregar una fila</button>
              
            </td>
          </tr>
        </tfoot>
      </table>
    
 




                 
        </div>                      
        <div id="step-3">
            <h2 class="StepTitle">Programar agenda</h2> 


            <table align="center" width="95%" style="margin-top:50px">
       
        
        <tbody>
 
          <tr>
          <td>   

           <div colspan="3" style="text-align:center;padding:4px;margin-bottom:4px" class="ui-state-active">Agregar agenda</div>
         

          <div class="label"> Fecha <input type="date" class="clsAnchoTotal" name="txtfecha[]" id="txtfecha" style="width:50%;float:right"></div>
            
        

           <div class="label"> Hora inicio <select name="txthorainicia[]" id="txthorainicia" style="width:50%;float:right"> 
           <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?>
            </select> </div>
            
            <div class="label"> Hora termina <select  name="txthorafin[]" id="txthorafin" style="width:50%;float:right">
             <?php
              llenar_combo2("SELECT id as codigo,conversion as nombre FROM horas",true);
              ?>
            </select></div>
            
             <div class="label"> Exponente <input type="text"  name="txtexponente[]" id="txtexponente" style="width:50%;float:right" class="usuario"></div>
            

            <div class="label"> Tema <input type="text"  name="txttema[]" id="txttema" style="width:50%;float:right"></div>
            

          <div class="label"> Cupos <input type="number" placeholder=" 0  es tener usuarios ilimitados" class="numeros"  name="txtcupos[]" id="txtcupos" style="width:50%;float:right"></div>
            
           <div class="label"> Escenario <select style="width:50%;float:right" name="cbmescenario[]" id="cbmescenario" class="cbmescenario">
              <?php
              llenar_combo2("SELECT id as codigo, nombre FROM escenario WHERE estado_id='1'",true);
              ?>
           </select>  </div>
            
           </td>
 
          </tr>

        </tbody>
        <tfoot>
          <tr >
            <td colspan="4" align="right" >
              
              <button type="button" class="clsAgregarFila2" style="width:100%;padding-bottom:8px">Agregar una fila</button>
            
            </td>
          </tr>
        </tfoot>
      </table>  
               


        </div>
        <div id="step-4">
            <h2 class="StepTitle">Enviar citacion</h2> 
            <br/> <br/> <br/>
            <center>
            <h1 style="width:50%">Modulo en elaboracion</h1>
                <img src="img/educacion.gif">  
            </center>  

        </div>
       
         <div id="step-5">
            <h2 class="StepTitle">Conclusiones</h2> 

            
             <table width="90%" style="margin:auto;margin-top:30px">
              
              
            
             <tr>
               
                <td class="tdd">
                <div style="border-radius:6px;box-shadow:0px 0px 8px red inset;height:20px;padding:5px;text-align:center">Ingrese conclusiones si hay, en caso contrario ingresar NO HAY</div>
       
                <textarea id="conclusiones" name="conclusiones" class="jqte-test" style="height:270px;width:100%;border-radius:4px"></textarea>
                  
                </td>
            </tr>
        
          

              
            </table>
             
                             
        </div>
       
</td>
</tr>
</table> 
</form>

  
 <script type="text/javascript" src="js/manipulacion.js"></script> 

