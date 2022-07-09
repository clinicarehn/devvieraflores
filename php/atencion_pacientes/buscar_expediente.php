<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli(); 

$pacientes_id = $_POST['pacientes_id'];

//CONSULTAR LOS DATOS DEL PACIENTE
$sql = "SELECT identidad AS 'identidad', fecha_nacimiento 'fecha_nacimiento', CONCAT(nombre, ' ', apellido) AS 'paciente', profesion_id AS 'profesion', 
   localidad AS 'localidad', religion_id AS 'religion'
   FROM pacientes
   WHERE pacientes_id = '$pacientes_id'";
   
$result = $mysqli->query($sql) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();   
     
$identidad = "";
$nombre = "";
$fecha_nacimiento = "";
$edad = "";
$profesion = "";
$religion = "";
$servicio_id = "";
$fecha_cita = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$identidad = $consulta_registro['identidad'];
	$fecha_nacimiento = $consulta_registro['fecha_nacimiento'];	
	$paciente = $consulta_registro['paciente'];
	$localidad = $consulta_registro['localidad'];	
	$religion = $consulta_registro['religion'];
	$profesion = $consulta_registro['profesion'];	
	
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
	 0 => $identidad, 
 	 1 => $paciente,	
	 2 => $anos." ".$palabra_anos.", ".$meses." ".$palabra_mes." y ".$dias." ".$palabra_dia,
	 3 => $anos	 
);	
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>