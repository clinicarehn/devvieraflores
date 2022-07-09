<?php 
include('../funtions.php');
session_start(); 
	
//CONEXION A DB
$mysqli = connect_mysqli();

$colaborador_id = $_SESSION['colaborador_id'];
$type = $_SESSION['type'];

if ($type == 1 || $type == 2){
	$where = "";
}else{
	$where = "WHERE colaborador_id = '$colaborador_id'";
}

$query = "SELECT COUNT(seguimiento_id) AS 'total'
FROM seguimiento
".$where;
$result = $mysqli->query($query);

$total = 0;

if($result->num_rows>0){
	$consulta2=$result->fetch_assoc();
	$total = $consulta2['total']; 	
}	 

echo number_format($total);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>