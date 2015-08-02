
<div  style="width:600px; margin:auto; margin-top:20px">
    <form id="formulario">
        <table style="width:100%">

            <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">DOCUMENTO</th>
            </tr>
 

            <tr> 
                <td class="tdi">Tipo Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmidentificacion" name="cbmidentificacion" title="Tipo identificación" class="chosen-select" disabled="disabled">
                       
                       

                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Identificacion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtidentificacion" id="txtidentificacion"  value="" title="Identificacion" maxlength="30" disabled="disabled"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Fecha Expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fecha_exp" id="fecha_exp"  value="" title="Fecha Expedicion" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Municipio Expedicion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                       <select id="muni_exp" name="muni_exp" title="Municipio Expedicion" class="chosen-select">
                      
                    </select>
                </td>            
            </tr>                        

   <tr  class="ui-state-active" style="height:24px">
                <th colspan="3">INFORMACION PERSONAL</th>
    </tr>                

            <tr> 
                <td class="tdi">Nombre</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtnombre" id="txtnombre"  value="" title="Nombre" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Prime Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp1" id="txtp1"  value="" title="Prime Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Segundo Apellido</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtp2" id="txtp2"  value="" title="Segundo Apellido" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Fecha de Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="date" name="fecha_nac" id="fecha_nac"  value="" title="Fecha de Nacimiento" maxlength="30"/>
                </td>            
            </tr>

            <tr> 
                <td class="tdi">Sexo</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <select id="cbmsexo" name="cbmsexo" title="Sexo" class="chosen-select">
                       

                    </select>
                </td>            
            </tr>                        
                            

            <tr> 
                <td class="tdi">Municipio Nacimiento</td>
                <td class="tdc">:</td>
                <td class="tdd">
                          
               <select id="muni_naci" name="muni_naci" title="Municipio Nacimiento" class="chosen-select">
                        
                    </select>
                </td>            
            </tr>                        
             <tr> 
                <td class="tdi">Municipio Residencia</td>
                <td class="tdc">:</td>
                <td class="tdd">
                   
               <select id="muni_res" name="muni_res" title="Municipio Residencia" class="chosen-select">
                         
                    </select>

                </td>            
            </tr>
             <tr> 
                <td class="tdi">Direccion</td>
                <td class="tdc">:</td>
                <td class="tdd">
                    <input type="text" name="txtdireccion" id="txtdireccion"  value="" title="Direccion" maxlength="30"/>
                </td>            
            </tr>               


        </table>

        <div class="error"></div>
        <div class="acciones">
		<input type="button" name="accion" value="Actualizar" onclick="actualizar()" />

        </div>

    </form>
</div>
