<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$agenda_id = $_POST['agenda_id'];
$comentario = cleanString($_POST['comentario']);
$usuario_sistema = $_SESSION['colaborador_id'];

//CONSULTAR PACIENTES_ID DE LA ENTIDAD PACIENTES
$consultar = "SELECT CAST(fecha_cita AS DATE) AS 'fecha' , expediente, pacientes_id, colaborador_id, servicio_id 
    FROM agenda 
	WHERE agenda_id = '$agenda_id'";
$result = $mysqli->query($consultar);
$consultar2 = $result->fetch_assoc();

$pacientes_id = "";
$colaborador_id = "";
$servicio_id = "";
$expediente = "";
$fecha = "";

if($result->num_rows>0){
	$pacientes_id = $consultar2['pacientes_id'];
	$colaborador_id = $consultar2['colaborador_id'];
	$servicio_id = $consultar2['servicio_id'];
	$expediente = $consultar2['expediente'];
	$fecha = $consultar2['fecha'];	
}

$fecha_registro = date("Y-m-d H:i:s");
$fecha_sistema = date("Y-m-d");
$usuario_sistema = $_SESSION['colaborador_id'];

//CONSULTAMOS DATOS DEL PACIENTES
$consulta_paciente = "SELECT *
	FROM pacientes 
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($consulta_paciente);	
$consulta_paciente2 = $result->fetch_assoc();

$expediente = "";
$identidad = "";
$usuario = "";
$nombre = "";
$apellido = "";
$fecha_nacimiento = "";
$telefono1 = "";
$telefono2 = "";
$sexo = "";
$localidades = "";
$departamento = "";
$municipio = "";
$correo = "";
$consulta_paciente_status = "";

if($result->num_rows>0){
	$expediente = $consulta_paciente2['expediente'];
	$identidad = $consulta_paciente2['identidad'];
	$usuario = $consulta_paciente2['usuario'];
	$nombre = $consulta_paciente2['nombre'];
	$apellido = $consulta_paciente2['apellido'];
	$fecha_nacimiento = $consulta_paciente2['fecha_nacimiento'];
	$telefono1 = $consulta_paciente2['telefono1'];
	$telefono2 = $consulta_paciente2['telefono2'];
	$sexo = $consulta_paciente2['genero'];
	$localidades = $consulta_paciente2['localidad'];
	$departamento = $consulta_paciente2['departamento_id'];
	$municipio = $consulta_paciente2['municipio_id'];
	$correo = $consulta_paciente2['email'];
	$consulta_paciente_status = $consulta_paciente2['estado'];
}

//MARCAMOS LA ATENCION PARA EL PACIENTES
$update = "UPDATE agenda
	SET 
		status = '1'
	WHERE 
		agenda_id = '$agenda_id'";
$query = $mysqli->query($update) or die($mysqli->error);		

if($query){
	//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
	$historial_numero = historial();
	$estado = "Agregar";
	$observacion = "Se ha marcado la atención para el paciente: $nombre $apellido con el número de agenda $agenda_id. Comentario: $comentario";
	$modulo = "Agenda";
	$insert = "INSERT INTO historial 
		 VALUES('$historial_numero','$pacientes_id','$expediente','$modulo','$agenda_id','$usuario_sistema','$servicio_id','$fecha','$estado','$observacion','$usuario_sistema','$fecha_registro')";	 
	$mysqli->query($insert);
	/*****************************************************/
	$datos = array(
		 0 => 1,//REGISTRO PROCESADO CORRECTAMENTE 
		 1 => "AtencionMedica",
		 2 => $agenda_id
	);		
}else{
	$datos = array(
		 0 => 2,//ERROR AL ALMACENAR EL REGISTRO
		 1 => "",
		 2 => "",		 
	);	
}
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>