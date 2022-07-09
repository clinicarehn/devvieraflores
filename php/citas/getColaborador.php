<?php  
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$servicio = $_POST['servicio'];

//CONSULTA LOS DATOS DE LA ENTIDAD CORPORACION
$consulta = "SELECT c.colaborador_id AS 'colaborador_id', CONCAT(c.nombre, ' ', c.apellido) AS 'profesional'
	FROM servicios_colaboradores AS sc
	INNER JOIN colaboradores AS c
	ON sc.colaborador_id = c.colaborador_id
	WHERE sc.servicio_id = '$servicio'"; 
$result = $mysqli->query($consulta); 

if($result->num_rows>0){
	echo '<option value="">Seleccione</option>';	
	while($consulta2 = $result->fetch_assoc()){
		echo '<option value="'.$consulta2['colaborador_id'].'">'.$consulta2['profesional'].'</option>';
	}
}else{
	echo '<option value="">Seleccione</option>';
}

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>