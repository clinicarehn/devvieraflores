<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 
 
$agenda_id = $_POST['agenda_id'];

//CONSULTAR DATOS DEL METODO DE PAGO
$query = "SELECT p.pacientes_id AS pacientes_id, CONCAT(p.nombre, ' ', p.apellido) AS 'paciente', a.servicio_id AS 'servicio_id', a.colaborador_id AS 'colaborador_id', CONCAT(c.nombre, ' ', c.apellido) AS 'profesional', CAST(a.fecha_cita AS DATE) AS 'fecha'
	FROM agenda AS a
	INNER JOIN pacientes AS p
	ON a.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON a.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON a.servicio_id = s.servicio_id
	WHERE a.agenda_id = '$agenda_id'";	
$result = $mysqli->query($query) or die($mysqli->error); 
     
$pacientes_id = "";
$paciente = "";
$fecha = "";
$servicio_id = "";
$profesional = "";
$colaborador_id = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$consulta_registro = $result->fetch_assoc();  
	$pacientes_id = $consulta_registro['pacientes_id'];
	$paciente = $consulta_registro['paciente'];
	$fecha = $consulta_registro['fecha'];	
	$profesional = $consulta_registro['profesional'];
	$colaborador_id = $consulta_registro['colaborador_id'];	
	$servicio_id = $consulta_registro['servicio_id'];		
}
	
$datos = array(
	 0 => $pacientes_id, 
	 1 => $paciente, 
	 2 => $fecha,	 
	 3 => $colaborador_id, 	 
	 4 => $profesional, 
	 5 => $servicio_id, 	 
);	
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>