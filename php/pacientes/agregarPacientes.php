<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$nombre = cleanStringStrtolower($_POST['name']);
$apellido = cleanStringStrtolower($_POST['lastname']);
$sexo = $_POST['sexo'];
$telefono1 = $_POST['telefono1'];
$telefono2 = $_POST['telefono2'];
$fecha_nacimiento = $_POST['fecha_nac'];
$identidad = $_POST['identidad'];
$correo = strtolower(cleanString($_POST['correo']));
$fecha = date("Y-m-d");

if(isset($_POST['departamento_id'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['departamento_id'] == ""){
		$departamento_id = 0;
	}else{
		$departamento_id = $_POST['departamento_id'];
	}
}else{
	$departamento_id = 0;
}

if(isset($_POST['municipio_id'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['municipio_id'] == ""){
		$departamento_id = 0;
	}else{
		$municipio_id = $_POST['municipio_id'];
	}
}else{
	$municipio_id = 0;
}

if(isset($_POST['pais_id'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['pais_id'] == ""){
		$pais_id = 0;
	}else{
		$pais_id = $_POST['pais_id'];
	}
}else{
	$pais_id = 0;
}

if(isset($_POST['profesion_pacientes'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['profesion_pacientes'] == ""){
		$profesion_pacientes = 0;
	}else{
		$profesion_pacientes = $_POST['profesion_pacientes'];
	}
}else{
	$profesion_pacientes = 0;
}

$responsable = $_POST['responsable'];

if(isset($_POST['responsable_id'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['responsable_id'] == ""){
		$responsable_id = 0;
	}else{
		$responsable_id = $_POST['responsable_id'];
	}
}else{
	$responsable_id = 0;
}

$localidad = cleanStringStrtolower($_POST['direccion']);
$religion_id = 0;
$estado_civil = 0;
$usuario = $_SESSION['colaborador_id'];

$responsable = $_POST['responsable'];

if(isset($_POST['asegurado_activo'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['asegurado_activo'] == ""){
		$asegurado_activo = 2;
	}else{
		$asegurado_activo = $_POST['asegurado_activo'];
	}
}else{
	$asegurado_activo = 2;
}

if(isset($_POST['seguros_pacientes'])){//COMPRUEBO SI LA VARIABLE ESTA DIFINIDA
	if($_POST['seguros_pacientes'] == ""){
		$seguros_pacientes = 0;
	}else{
		$seguros_pacientes = $_POST['seguros_pacientes'];
	}
}else{
	$seguros_pacientes = 0;
}

$estado = 1; //1. Activo 2. Inactivo
$fecha_registro = date("Y-m-d H:i:s");

//CONSULTAR IDENTIDAD DEL USUARIO
if($identidad == 0){
	$flag_identidad = true;
	while($flag_identidad){
	   $d=rand(1,99999999);
	   $query_identidadRand = "SELECT pacientes_id 
	       FROM pacientes 
		   WHERE identidad = '$d'";
	   $result_identidad = $mysqli->query($query_identidadRand);
	   if($result_identidad->num_rows==0){
		  $identidad = $d;
		  $flag_identidad = false;
	   }else{
		  $flag_identidad = true;
	   }		
	}
}

//EVALUAR SI EXISTE EL PACIENTE
$select = "SELECT pacientes_id
	FROM pacientes
	WHERE identidad = '$identidad' AND nombre = '$nombre' AND apellido = '$apellido' AND telefono1 = '$telefono1'";
$result = $mysqli->query($select) or die($mysqli->error);

if($result->num_rows==0){
	$pacientes_id = correlativo('pacientes_id ', 'pacientes');
	$expediente = correlativo('expediente ', 'pacientes');
	$insert = "INSERT INTO pacientes 
		VALUES ('$pacientes_id','$expediente','$identidad','$nombre','$apellido','$sexo','$telefono1','$telefono2','$fecha_nacimiento','$correo','$fecha','$pais_id','$departamento_id','$municipio_id','$localidad','$religion_id','$profesion_pacientes','$estado_civil','$responsable','$responsable_id','$usuario','$estado', '$asegurado_activo', '$seguros_pacientes', '$fecha_registro')";
	$query = $mysqli->query($insert);
	
	if($query){
		$datos = array(
			0 => "Almacenado", 
			1 => "Registro Almacenado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "formulario_pacientes",
			5 => "Registro",
			6 => "formPacientes",
			7 => "modal_pacientes",
		);
	}else{
		$datos = array(
			0 => "Error", 
			1 => "No se puedo almacenar este registro, los datos son incorrectos por favor corregir", 
			2 => "error",
			3 => "btn-danger",
			4 => "",
			5 => "",			
		);
	}
}else{
	$datos = array(
		0 => "Error", 
		1 => "Lo sentimos este registro ya existe no se puede almacenar", 
		2 => "error",
		3 => "btn-danger",
		4 => "",
		5 => "",		
	);
}

echo json_encode($datos);
?>