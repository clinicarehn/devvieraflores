<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

$consulta = "SELECT * FROM pais";
$result = $mysqli->query($consulta) or die($mysqli->error);

if($result->num_rows>0){
	echo '<option value="">Seleccione</option>';	
	while($consulta2 = $result->fetch_assoc()){
		echo '<option value="'.$consulta2['pais_id'].'">'.$consulta2['nombre'].'</option>';
	}
}

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>