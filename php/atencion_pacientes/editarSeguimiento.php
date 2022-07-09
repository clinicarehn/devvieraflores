<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$seguimiento_id = $_POST['seguimiento_id'];

//CONSULTAR DATOS DEL METODO DE PAGO
$query = "SELECT p.nombre AS 'nombre', p.apellido AS 'apellido', p.identidad AS 'identidad', s.*
	FROM seguimiento AS s
	INNER JOIN pacientes AS p
	ON s.pacientes_id = p.pacientes_id
	WHERE s.seguimiento_id = '$seguimiento_id'";	
$result = $mysqli->query($query) or die($mysqli->error);   
     
$fecha_cita = "";
$motivo_consulta_seguimiento = "";
$hist_enfe_actual_seguimiento = "";
$diagnostico_seguimiento = "";
$manejo_seguimiento = "";
$receta_estudio_seguimiento = "";
$receta_medicamentos_seguimiento = "";
$nombre = "";
$apellido = ""; 
$identidad = ""; 

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$consulta_registro = $result->fetch_assoc();
	$pacientes_id = $pacientes_id;
	$fecha_cita = $fecha_cita;
	$colaborador_id = $colaborador_id;	
	$fecha_cita = $consulta_registro['fecha_cita'];
	$motivo_consulta_seguimiento = $consulta_registro['motivo_consulta_seguimiento'];
	$hist_enfe_actual_seguimiento = $consulta_registro['hist_enfe_actual_seguimiento'];	
	$diagnostico_seguimiento = $consulta_registro['diagnostico_seguimiento'];
	$manejo_seguimiento = $consulta_registro['manejo_seguimiento'];	
	$receta_estudio_seguimiento = $consulta_registro['receta_estudio_seguimiento'];
	$receta_medicamentos_seguimiento = $consulta_registro['receta_medicamentos_seguimiento'];
	$nombre = $consulta_registro['nombre'];	
	$apellido = $consulta_registro['apellido'];	
	$identidad = $consulta_registro['identidad'];			
}

$datos = array(
	 0 => "", 
	 1 => $pacientes_id, 
	 2 => $fecha_cita,	 
	 3 => $colaborador_id, 	 
	 4 => $motivo_consulta_seguimiento, 
	 5 => $hist_enfe_actual_seguimiento, 	 
	 6 => $diagnostico_seguimiento, 	 
	 7 => $manejo_seguimiento, 
	 8 => $receta_estudio_seguimiento, 	 
	 9 => $receta_medicamentos_seguimiento, 
	 10 => $nombre, 	 
	 11 => $apellido, 
	 12 => $identidad, 	 
);	
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>