<?php
include('../funtions.php');
session_start(); 
	
//CONEXION A DB
$mysqli = connect_mysqli();

date_default_timezone_set('America/Tegucigalpa');
$fechaactual = date('Y-m-d');
$nuevafecha = strtotime ('-1 year' , strtotime($fechaactual)); //Se resta un año menos
$año = date ('Y',$nuevafecha);

$type = $_SESSION['type'];

if ($type == 1 || $type == 2){
	$where = "WHERE YEAR(CAST(fecha_cita AS DATE)) = '$año'";
}else{
	$where = "WHERE colaborador_id = '$colaborador_id' AND YEAR(CAST(fecha_cita AS DATE)) = '$año'";
}

$query = "SELECT MONTHNAME(CAST(fecha_cita AS DATE)) as 'mes', COUNT(*) as 'total' 
	FROM seguimiento 
	".$where."
	GROUP BY MONTH(CAST(fecha_cita AS DATE))";
$result = $mysqli->query($query);

$arreglo = array();

while( $row = $result->fetch_assoc()){
	$arreglo[] = $row;  
}	

echo json_encode($arreglo);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>