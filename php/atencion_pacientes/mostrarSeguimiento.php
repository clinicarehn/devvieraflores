<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$seguimiento_id = $_POST['seguimiento_id'];

//CONSULTAR DATOS DEL METODO DE PAGO
$query = "SELECT p.nombre AS 'nombre', p.apellido AS 'apellido', p.identidad AS 'identidad', s.*
	FROM seguimiento AS s
	INNER JOIN pacientes AS p
	ON s.pacientes_id = p.pacientes_id
	WHERE s.seguimiento_id = '$seguimiento_id'";	
$result = $mysqli->query($query) or die($mysqli->error);
     
$fecha_cita = "";
$motivo_consulta_seguimiento = "";
$hist_enfe_actual_seguimiento = "";
$diagnostico_seguimiento = "";
$manejo_seguimiento = "";
$receta_estudio_seguimiento = "";
$receta_medicamentos_seguimiento = "";
$nombre = "";
$apellido = ""; 
$identidad = ""; 
$datos_consulta = "";
$datos_archivos = "";
$informacion = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$consulta_registro = $result->fetch_assoc();   	
	$pacientes_id = $pacientes_id;
	$fecha_cita = $fecha_cita;
	$colaborador_id = $colaborador_id;	
	$fecha_cita = $consulta_registro['fecha_cita'];
	$motivo_consulta_seguimiento = $consulta_registro['motivo_consulta_seguimiento'];
	$hist_enfe_actual_seguimiento = $consulta_registro['hist_enfe_actual_seguimiento'];	
	$diagnostico_seguimiento = $consulta_registro['diagnostico_seguimiento'];
	$manejo_seguimiento = $consulta_registro['manejo_seguimiento'];	
	$receta_estudio_seguimiento = $consulta_registro['receta_estudio_seguimiento'];
	$receta_medicamentos_seguimiento = $consulta_registro['receta_medicamentos_seguimiento'];
	$nombre = $consulta_registro['nombre'];	
	$apellido = $consulta_registro['apellido'];	
	$identidad = $consulta_registro['identidad'];
	
	$datos_consulta = "
	<div class='form-row'>
		<div class='col-md-12 mb-6 sm-3'>
		  <p style='color: #077A2F;' align='center'><b>Datos Personales</b></p>
		</div>					
	</div>	
	<div class='form-row'>
		<div class='col-md-4 mb-3'>
		  <p><b>Paciente:</b> $nombre $apellido</p>
		</div>				
		<div class='col-md-4 mb-3'>
		  <p><b> Identidad:</b> $identidad</p>
		</div>	
		<div class='col-md-4 mb-3'>
		  <p><b> Fecha:</b> $fecha_cita</p>
		</div>								
	</div>	

	<div class='form-row'>
		<div class='col-md-12 mb-6 sm-3'>
		  <p style='color: #077A2F;' align='center'><b>Historia Clinica</b></p>
		</div>					
	</div>	
	<div class='form-row'>
		<div class='col-md-12 mb-3'>
		  <p><b>Motivo Consulta:</b> $motivo_consulta_seguimiento</p>
		</div>	
		<div class='col-md-12 mb-3'>
		  <p><b>Historia Enfermedad Actual:</b> $hist_enfe_actual_seguimiento</p>
		</div>	
		<div class='col-md-12 mb-3'>
		  <p><b>Diagnostico:</b> $diagnostico_seguimiento</p>
		</div>
		<div class='col-md-12 mb-3'>
		  <p><b>Manejo:</b> $manejo_seguimiento</p>
		</div>	
		<div class='col-md-12 mb-3'>
		  <p><b>Receta Estudio:</b> $receta_estudio_seguimiento</p>
		</div>	
		<div class='col-md-12 mb-3'>
		  <p><b>Receta Medicamentos:</b> $receta_medicamentos_seguimiento</p>
		</div>																
	</div>		
	";
	
	$informacion = $datos_consulta;

	//CONSULTAR ARCHIVOS
	$query_archivos = "SELECT file_name
		FROM seguimiento_detalles
		WHERE seguimiento_id = '$seguimiento_id'";
	$result_archivos = $mysqli->query($query_archivos) or die($mysqli->error);

	$datos_archivos = "
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
			<p style='color: #077A2F;' align='center'><b>Archivos</b></p>
			</div>					
		</div>
	";
	if($result_archivos->num_rows>0){
		while($consulta2 = $result_archivos->fetch_assoc()){
			$file_name = $consulta2['file_name'];
			$path = "../upload/".$file_name;
			
			$datos_archivos .= "
				<div class='alert alert-primary' role='alert'>
					<a target='_BLANK' href='".$path."' class='alert-link'>".$file_name."</a>
		 		 </div>
			";
		}
	}else{
		$datos_archivos = "
			<div class='form-row'>
				<div class='col-md-12 mb-6 sm-3'>
					<p style='color: #FF0000;' align='center'><b>No hay datos que mostrar</b></p>
				</div>			
			</div>			
		";
	}
}else{
	$datos_consulta = "
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #FF0000;' align='center'><b>No hay datos que mostrar</b></p>
			</div>			
		</div>			
	";	
	
	$informacion = $datos_consulta;
}
	
echo $informacion;
echo $datos_archivos;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>