<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli(); 

$agenda_id = $_POST['agenda_id'];

//CONSULTAMOS SI EXITE LA ATENCION PARA EL REGISTRO
$consulta = "SELECT atencion_id
	FROM atenciones_medicas";
$result = $mysqli->query($consulta) or die($mysqli->error);

$data = 0;

if($result->num_rows>0){
	$data = 1;
}

echo $data;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>