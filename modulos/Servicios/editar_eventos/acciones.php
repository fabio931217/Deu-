                    <?php
                    class Formulario extends Base {
        
function listarEventos() {
                    $q = str_replace(" ", "%", $_GET['q']);
                    $q = strtoupper($q);
                    
                    /* $sql="SELECT a.id , CONCAT_WS('',a.nombre,' : ',ag.fecha, ' [',t.nombre,']') as text
                    FROM acto a,tipo t,agenda ag 
                    WHERE a.tipo_id=t.codigo and a.id=ag.acto_id
                    AND CONCAT_WS('',a.nombre,' : ',ag.fecha, ' [',t.nombre,']') LIKE '%$q%'
                    /*GROUP BY t.nombre 
                    LIMIT 100"; */
                    
                    $sql="SELECT a.id , CONCAT_WS(' ',a.nombre,' : ',' [',t.nombre,']') as text
                    FROM acto a,tipo t
                    WHERE a.tipo_id=t.codigo
                    AND CONCAT_WS('',a.nombre,' : ',' [',t.nombre,']') LIKE '%$q%'
                    GROUP BY t.nombre 
                    LIMIT 100";
                    echo $this->db->select_json($sql);
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
function listarPersonas2() {
                    $q = str_replace(" ", "%", $_GET['q']);
                    $q = strtoupper($q);
                    
                    $sql = "SELECT identifica as id, CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') as text 
                    FROM general.persona
                    WHERE  CONCAT_WS('',nombre,' ',apellido1,' ',apellido2, ' [',identifica,']') LIKE '%$q%'
                    ORDER BY nombre
                    LIMIT 100";
                    echo $this->db->select_json($sql);
                    }
                    
function eliminar_evento()
                    {
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    
                    $db=$this->db;     
                    $s="DELETE  FROM acto WHERE id='$id'";
                    //$db->query($s);
                    $error=$s;
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = $error; 
                    echo json_encode($result);
                    }

function eliminar_galeria()
                    {
                    $error="";
                    $id = $_POST['id'];
                    if (empty($id) or $id=='undefined') {
                    $error="<br/> Seleccione foto";
                    }
                   else
                    { 
                    
                    $db=$this->db;     
                    $s="DELETE  FROM galeria WHERE id='$id'";
                    $db->query($s);
                     $error=1;
                    } 
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = $error; 
                    echo json_encode($result);

                    }
function eliminar_organizador()
                    {
                    
                    /*echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);*/
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $cod_organizador=$_POST['id'];
                    
                    if (empty($cod_organizador) or $cod_organizador=='undefined') {
                    $error="<br/> Seleccione organizador";
                    }
                    else
                    {
                    $db=$this->db;     
                    $s="DELETE  FROM organizador WHERE id='$cod_organizador' and acto_id='$id'";
                    $db->query($s);
                    $error=1;
                    }
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = $error; 
                    echo json_encode($result);
                    }
function eliminar_delegado()
                    {
                    /*
                    echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);
                    */
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $cod_delegado=$_POST['id'];
                    
                    if (empty($cod_delegado) or $cod_delegado=='undefined') {
                    $error="<br/> Seleccione delegado";
                    }
                    else
                    {
                    $db=$this->db;
                    $s="DELETE  FROM delegados WHERE codigo='$cod_delegado' and acto='$id'";
                    $db->query($s);
                    $error=1;
                    }
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = $error; 
                    echo json_encode($result);
                    }
function eliminar_agenda()
                    {
                    /*
                    echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);
                    */
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $cod_agenda=$_POST['id'];
                    
                    if (empty($cod_agenda) or $cod_agenda=='undefined') {
                    $error="<br/> Seleccione agenda";
                    }
                    else
                    {
                    $db=$this->db;     
                    $s="DELETE  FROM agenda WHERE id='$cod_agenda' and acto_id='$id'";
                    $db->query($s);
                    $error=1;
                    }
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = $error; 
                    echo json_encode($result);
                    }
                    
function agregar_delegado()
                    {
                    /*  echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);*/
                    
                    $v = new Validation($_POST);
                    $v->addRules('txtdelegado', 'Delegado', array('required' => true, 'maxLength' => 200) );
                    
                    
                    $result = $v->validate();
                    
                    if ($result['messages'] == "") {//No hay errores de validacion
                    //return true;
                    } else { //Errores de validación
                    $r['error'] = true;
                    $r['msg'] = $result['messages'].'<br/>';
                    $r['bad_fields'] = $result['bad_fields'];
                    $r['errors'] = $result['errors'];
                    echo json_encode($r);
                    exit(0);
                    }
                    
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $delegado= $_POST['txtdelegadoid'];
                    
                    $db=$this->db;
                    $s="SELECT * FROM delegados WHERE usuario='$delegado' and acto='$id'";
                    $r=$db->query($s);
                    
                    if ($db->num_rows($r))
                    {
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] ="Usuario ya tiene delegacion asignada"; 
                    echo json_encode($result);
                    exit(0);
                    }
                    
                    $sql="INSERT INTO delegados(
                    usuario,
                    acto
                    )
                    values(
                    '$delegado',
                    '$id'
                    )";
                    $db->query($sql);
                    
                    $error=1;
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
                    }
function agregar_organizador()
                    {
                    /*
                    echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0);
                    */
                    $v = new Validation($_POST);
                    $v->addRules('cbmdependencia', 'Dependencia', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txtorganizadores', 'Organizador', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('cbmfunciones', 'Funcion', array('required' => true, 'maxLength' => 200) );
                    
                    
                    $result = $v->validate();
                    
                    if ($result['messages'] == "") {//No hay errores de validacion
                    //return true;
                    } else { //Errores de validación
                    $r['error'] = true;
                    $r['msg'] = $result['messages'].'<br/>';
                    $r['bad_fields'] = $result['bad_fields'];
                    $r['errors'] = $result['errors'];
                    echo json_encode($r);
                    exit(0);
                    }
                    
                    
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $organizador= $_POST['txtorganizadoresid'];
                    $dependencia=$_POST['cbmdependencia'];
                    $funcion =$_POST['cbmfunciones'];
                    
                    
                    $db=$this->db;
                    $r=$db->query("SELECT * FROM organizador WHERE acto_id='$id' and dependencia_id='$dependencia' and persona_id='$organizador' and funcion_id='$funcion'");
                    
                    if ($db->num_rows($r)>0)
                    {
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] ="Organizador ya se encuentra registrado con los mismos criterios"; 
                    echo json_encode($result);
                    exit(0);
                    }
                    
                    $s="INSERT INTO organizador(
                    acto_id,
                    dependencia_id,
                    persona_id,
                    funcion_id
                    )
                    values(
                    '$id',
                    '$dependencia',
                    '$organizador',
                    '$funcion'
                    )";
                    $db->query($s);
                    $error=1;
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
                    }
function guardar_agenda()
                    {
                    
                   /*  echo "<pre>";
                    print_r($_POST);
                    echo "</pre>"; 
                    exit(0); */

                    $v = new Validation($_POST);
                    $v->addRules('txtfecha', 'Fecha', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('hora_inicio', 'Hora inicia', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('hora_termina', 'Hora termina', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txtexponente', 'Exponente', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txttema', 'Tema', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txtcupos', 'Cupos', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('cbmescenario', 'Escenario', array('required' => true, 'maxLength' => 200) );
                    
                    
                    $result = $v->validate();
                    
                    if ($result['messages'] == "") {//No hay errores de validacion
                    //return true;
                    } else { //Errores de validación
                    $r['error'] = true;
                    $r['msg'] = $result['messages'];
                    $r['bad_fields'] = $result['bad_fields'];
                    $r['errors'] = $result['errors'];
                    echo json_encode($r);
                    exit(0);
                    }
                    
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    
                    $fecha =$_POST['txtfecha'];
                    $cupos= $_POST['txtcupos'];
                    $tema =  $_POST['txttema'];
                    $hora_inicia= $_POST['hora_inicio'];
                    $hora_fin =$_POST['hora_termina'];
                    $escenario= $_POST['cbmescenario'];
                    $exponente =$_POST['txtexponenteId'];

$e="";
$db=$this->db;                 

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and '$hora_inicia'<=h_inicia and '$hora_fin'>=h_termina";

//$e.=$s.'<br/>';
$r= $db->query($s);

if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA y HORA FIN , estan tomando horas de otro acto <br/>";}


$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and h_inicia='$hora_inicia' and h_termina='$hora_fin'";


//$e.=$s.'<br/>';
$r= $db->query($s);

if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA y HORA FIN , estan ocupadas por otro acto <br/>";}

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and '$hora_inicia'>=h_inicia and '$hora_inicia'< h_termina";
//$e.=$s.'<br/>';

$r= $db->query($s);

 if($db->num_rows($r)>0)
 {$e.="-) HORA INICIA, Interfiere con otro acto <br/>";}

$s="SELECT * FROM agenda
 WHERE escenario_id='$escenario' and fecha='$fecha'and h_inicia<'$hora_fin' and '$hora_fin'<=h_termina";
//$e.=$s.'<br/>';
$r= $db->query($s);

 if($db->num_rows($r)>0)
 {$e.="-) HORA FIN, Interfiere con otro acto <br/>";}

if ($e!="") {
    $result=array();
        $result["error"] = false;
        $result["msg"] = $e; 
        echo json_encode($result); 
        exit(0);
}

if ($hora_fin<=$hora_inicia) {
    
   $error="-) Hora fin menor ó igual a hora inicia en </br>\n\n";
        $result=array();
        $result["error"] = false;
        $result["msg"] = $error; 
        echo json_encode($result); 
        exit(0);
}

 $s="INSERT INTO agenda(
    acto_id,
    fecha,
    h_inicia,
    h_termina,
    exponente,
    tema,
    cupos,
    escenario_id
    )
     values(
        '$id',
        '$fecha',
        '$hora_inicia',
        '$hora_fin',
        '$exponente',
        '$tema',
        '$cupos',
        '$escenario'
        )";

      $db->query($s);              
                    $error=1;
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
                    }
                    
function modificar_conclusion()
                    {
                    
                    $v = new Validation($_POST);
                    $v->addRules('txtconclusion', 'Conclusion', array('required' => true, 'maxLength' => 500) );
                    
                    
                    $result = $v->validate();
                    
                    if ($result['messages'] == "") {//No hay errores de validacion
                    //return true;
                    } else { //Errores de validación
                    $r['error'] = true;
                    $r['msg'] = $result['messages'].'<br/>';
                    $r['bad_fields'] = $result['bad_fields'];
                    $r['errors'] = $result['errors'];
                    echo json_encode($r);
                    exit(0);
                    }
                    
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $conclusion= $_POST['txtconclusion'];
                    
                    $db=$this->db;
                    $s="UPDATE conclusion SET contenido = '$conclusion' WHERE acto_id='$id'";
                    $db->query($s);
                    $error=1;
                    
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
                    }
                    
function modificar_evento()
                    {
                    
                    $v = new Validation($_POST);
                    $v->addRules('txtnombreevento', 'Nombre evento', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txtdescrip', 'Descripcion evento', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('txtobjetivo', 'Objetivos evento', array('required' => true, 'maxLength' => 200) );
                    $v->addRules('cbmtipo_acto', 'Tipo acto', array('required' => true, 'maxLength' => 30) );
                    
                    
                    $result = $v->validate();
                    
                    if ($result['messages'] == "") {//No hay errores de validacion
                    //return true;
                    } else { //Errores de validación
                    $r['error'] = true;
                    $r['msg'] = $result['messages'].'<br/>';
                    $r['bad_fields'] = $result['bad_fields'];
                    $r['errors'] = $result['errors'];
                    echo json_encode($r);
                    exit(0);
                    }
                    // return true;
                    
                    $error="";
                    $id = $_SESSION['acto_numero'];
                    $nombre_evento=$_POST['txtnombreevento'];
                    $descripciones=$_POST['txtdescrip'];
                    $objetivos=$_POST['txtobjetivo'];
                    $tipo=$_POST['cbmtipo_acto'];
                    
                    $s="UPDATE acto SET
                    nombre='$nombre_evento',
                    descripcion='$descripciones',
                    objetivo='$objetivos',
                    tipo_id='$tipo'
                    
                    WHERE id='$id'";
                    $db=$this->db;
                    $db->query($s);
                    $error=1;
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] =$error; 
                    echo json_encode($result);
                    }
                    
                    function buscar() {
                    $this->validar();
                    
                    //PONER CODIGO AQUI
                    
                    $result=array();
                    $result["error"] = false;
                    $result["msg"] = "PONER AQUI."; 
                    echo json_encode($result);
                    }
                    
                    }
                    //$_POST = array_map("strtoupper", $_POST); //CONVERTIR TODO EN MAYUSCULA
                    
                    $accion = ACCION;
                    $f = new Formulario();
                    $f->$accion();
                    ?>