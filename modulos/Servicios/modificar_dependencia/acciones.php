<?php
class Formulario extends Base {
    function validar() {
        $v = new Validation($_POST);
		$v->addRules('cbmtipo', 'Tipo evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmevento', 'Evento', array('required' => true, 'maxLength' => 30) );
		$v->addRules('cbmagenda', 'Agenda', array('required' => true, 'maxLength' => 30) );
		$v->addRules('txtdocumento', 'Documento', array('required' => true) );

        $result = $v->validate();

        if ($result['messages'] == "") {//No hay errores de validacion
            return true;
        } else { //Errores de validación
            $r['error'] = true;
            $r['msg'] = $result['messages'];
            $r['bad_fields'] = $result['bad_fields'];
            $r['errors'] = $result['errors'];
            echo json_encode($r);
            exit(0);
        }
        return true;
    }

function cargarEventos() {
        $db = $this->db;
        $sql = "SELECT id as codigo, nombre FROM acto WHERE tipo_id='$_POST[cbmtipo]' ORDER BY nombre";
        $datos = $db->select_all($sql);
        echo json_encode($datos);
    }
    function cargarAgendas() {
        $db = $this->db;

$s='SELECT CURDATE() AS fecha,CURTIME() as hora';
$rs=$db->query($s);
$rw=$db->fetch_assoc($rs);


$f=$rw['fecha'];



$s= "SELECT a.id as codigo,a.tema,a.h_inicia,a.h_termina,CONCAT_WS(' ',p.nombre,p.apellido1,p.apellido2) as nombre
FROM agenda a, general.persona p
WHERE a.acto_id='$_POST[cbmevento]' and p.id=a.exponente
GROUP BY codigo";
 
//$db = $this->db;
$combo="<option value='0'> TODAS LAS AGENDAS </option>";



$r = $db->query($s);

while ($rw=$db->fetch_assoc($r))
{

$r2=$db->query("SELECT * from horas");
$rw2=$db->fetch_assoc($r2);

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
//$combo.=" <option value='$rw[codigo]'>TEMA: $rw[tema] HORA: $inicia á $fin EXPONENTE : ( $rw[nombre] )</option>";
$combo.=" <option value='$rw[codigo]'>TEMA: $rw[tema] HORA: $inicia á $fin</option>";

}

        //$datos = $db->select_all($sql);
        echo json_encode($combo);
    }
function listarPersonas() {
        $q = str_replace(" ", "%", $_GET['q']);
        $q = strtoupper($q);

        $sql = "SELECT id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
        echo $this->db->select_json($sql);
    }
    function aceptar() {
        $this->validar();
        
        //PONER CODIGO AQUI
        
        $result=array();
        $result["error"] = false;
        $result["msg"] = "PONER AQUI."; 
        echo json_encode($result);
    }
function guardar_modificacion() {
          
          /*echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
 */
$db = $this->db;       
$cod_agenda = count($_POST['cod_agenda']);

if ($cod_agenda==0) {

        $result=array();
        $result["error"] = true;
        $result["msg"] = "Seleccione dependencia a modificar"; 
        echo json_encode($result);
        exit(0);
}

$funcion = count($_POST['cbmfuncion']);

for ($i=0; $i <$funcion ; $i++)
for ($i=0; $i <$cod_agenda ; $i++)
{ 

$agenda =explode("-", $_POST['cod_agenda'][$i]);

for ($x=0; $x <$funcion ; $x++) 
{ 
   

//echo $agenda[0]."-".$x."\n";

    if ($x==$agenda[0])
    {
 
  $funcion_n = $_POST['cbmfuncion'][$x];
  
        $sql="UPDATE asistencia SET
        dependencia_id='$funcion_n'
        WHERE id='$agenda[1]'";

        $db->query($sql);
        
    }
}

}

                $result=array();
        $result["error"] = false;
        $result["msg"] = "Actualizado con exito"; 
        echo json_encode($result);
    }

}
//$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
 
$accion = ACCION;
$f = new Formulario();
$f->$accion();
?>