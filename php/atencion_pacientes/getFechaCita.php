<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

$agenda_id = $_POST['agenda_id'];

//CONSULTAR NOMBRE PROFESIONAL
$query = "SELECT CAST(fecha_cita AS DATE) AS 'fecha_cita'
FROM agenda
WHERE agenda_id = '$agenda_id'"; 
$result = $mysqli->query($query) or die($mysqli->error);

$estado = 0;

if($result->num_rows>0){
	$consulta2 = $result->fetch_assoc();
	$estado = $consulta2['fecha_cita'];
}	
	
echo $estado;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>