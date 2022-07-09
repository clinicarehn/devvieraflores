<?php  
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];

//CONSULTA LOS DATOS DE LA ENTIDAD CORPORACION
$consulta = "SELECT historia_clinica_id
	FROM historia_clinica
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id'";
$result = $mysqli->query($consulta); 

$historia_clinica_id = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$consulta_registro = $result->fetch_assoc();  
	$historia_clinica_id = $consulta_registro['historia_clinica_id'];		

	$datos = array(
		0 => "1", 
		1 => $historia_clinica_id 	 
	);		
}else{
	$datos = array(
		0 => "2", 
		1 => "" 	 
	);	
}
   
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>