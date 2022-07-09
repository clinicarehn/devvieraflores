<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$pacientes_id = $_POST['pacientes_id'];
$agenda_id = $_POST['agenda_id'];

//CONSULTAR LOS DATOS DEL PACIENTE
$sql = "SELECT p.identidad AS 'identidad', p.fecha_nacimiento 'fecha_nacimiento', CONCAT(p.nombre, ' ', p.apellido) AS 'paciente', p.localidad AS 'localidad', p.religion_id AS 'religion', p.profesion_id AS 'profesion', CAST(a.fecha_cita AS DATE) AS 'fecha', a.servicio_id AS 'servicio_id', p.estado_civil AS 'estado_civil', 
(CASE WHEN p.expediente = '0' THEN 'TEMP' ELSE p.expediente END) AS 'expediente', a.colaborador_id AS 'colaborador_id'
   FROM agenda AS a
   INNER JOIN pacientes AS p
   ON a.pacientes_id = p.pacientes_id
   WHERE a.agenda_id = '$agenda_id'";
$result = $mysqli->query($sql) or die($mysqli->error);  
     
$identidad = "";
$nombre = "";
$fecha_nacimiento = "";
$edad = "";
$profesion = "";
$religion = "";
$servicio_id = "";
$fecha_cita = "";
$palabra_anos = "";
$palabra_mes = "";
$palabra_dia = "";
$estado_civil = "";
$expediente = "";
$colaborador_id = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$consulta_registro = $result->fetch_assoc();
	
	$identidad = $consulta_registro['identidad'];
	$fecha_nacimiento = $consulta_registro['fecha_nacimiento'];	
	$paciente = $consulta_registro['paciente'];
	$localidad = $consulta_registro['localidad'];	
	$religion = $consulta_registro['religion'];
	$profesion = $consulta_registro['profesion'];
	$fecha_cita = $consulta_registro['fecha'];	
	$servicio_id = $consulta_registro['servicio_id'];
	$estado_civil = $consulta_registro['estado_civil'];
	$expediente = $consulta_registro['expediente'];	
	$colaborador_id = $consulta_registro['colaborador_id'];			
	
	//CONSULTA AÑO, MES y DIA DEL PACIENTE
	$valores_array = getEdad($fecha_nacimiento);
	$anos = $valores_array['anos'];
	$meses = $valores_array['meses'];	  
	$dias = $valores_array['dias'];	
	/*********************************************************************************/
	
	if ($anos>1 ){
	   $palabra_anos = "Años";
	}else{
	  $palabra_anos = "Año";
	}

	if ($meses>1 ){
	   $palabra_mes = "Meses";
	}else{
	  $palabra_mes = "Mes";
	}

	if($dias>1){
		$palabra_dia = "Días";
	}else{
		$palabra_dia = "Día";
	}		
}

$datos = array(
 	 0 => $paciente,	
	 1 => $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia,	
 	 2 => $expediente,
 	 3 => $fecha_cita,
 	 4 => $anos,
 	 5 => $colaborador_id,
 	 6 => $servicio_id	  	  
);	
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>