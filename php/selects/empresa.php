<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$consulta = "SELECT empresa_id, nombre 
    FROM empresa ORDER BY nombre"; 
$result = $mysqli->query($consulta);
  
if($result->num_rows>0){
	echo '<option value="">Seleccione</option>';
	while($consulta2 = $result->fetch_assoc()){
	     echo '<option value="'.$consulta2['empresa_id'].'">'.$consulta2['nombre'].'</option>';
	}
}

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>