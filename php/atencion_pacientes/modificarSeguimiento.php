<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$pacientes_id = $_POST['pacientes_id'];
$servicio_id = 1;
$fecha_cita = $_POST['fecha_cita'];
$seguimiento_id = $_POST['seguimiento_id'];
$motivo_consulta_seguimiento = cleanString($_POST['motivo_consulta_seguimiento']);
$hist_enfe_actual_seguimiento = cleanString($_POST['hist_enfe_actual_seguimiento']);
$diagnostico_seguimiento = cleanString($_POST['diagnostico_seguimiento']);
$manejo_seguimiento = cleanString($_POST['manejo_seguimiento']);
$receta_estudio_seguimiento = cleanString($_POST['receta_estudio_seguimiento']);
$receta_medicamentos_seguimiento = cleanString($_POST['receta_medicamentos_seguimiento']);
$fecha_registro = date("Y-m-d H:i:s");
$estado_atencion = 1;
$estado_agenda = 1;
$colaborador_id = $_SESSION['colaborador_id'];

//CONSULTAR DATOS DEL PACIENTE
$query_paciente = "SELECT expediente, CONCAT(nombre, ' ', apellido) AS 'paciente', identidad
    FROM pacientes
	WHERE pacientes_id = '$pacientes_id'";
$result = $mysqli->query($query_paciente) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$expediente = '';
$paciente = '';
$identidad = '';

if($result->num_rows>0){
	$expediente = $consulta_registro['expediente'];
	$paciente = $consulta_registro['paciente'];
	$identidad = $consulta_registro['identidad'];	
}	 

//CONSULTAMOS SI EXISTE LA ATENCION DEL PACIENTE
$consultar_atencion = "SELECT seguimiento_id 
	FROM seguimiento
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
$result_atencion = $mysqli->query($consultar_atencion) or die($mysqli->error);

if($result_atencion->num_rows>0){//NO EXISTE LA ATENCION PROCEDEMOS A GUARDARLA
	//INSERTAMOS LOS DATOS EN LA ENTIDAD historia_clinica
	$update = "UPDATE seguimiento 
		SET
			motivo_consulta_seguimiento = '$motivo_consulta_seguimiento',
			hist_enfe_actual_seguimiento = '$hist_enfe_actual_seguimiento',
			diagnostico_seguimiento = '$diagnostico_seguimiento',
			manejo_seguimiento = '$manejo_seguimiento',
			receta_estudio_seguimiento = '$receta_estudio_seguimiento',
			receta_medicamentos_seguimiento = '$receta_medicamentos_seguimiento'
		WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id'";
	$query = $mysqli->query($update);

	if($query){
		$datos = array(
			0 => "Modificado", 
			1 => "Registro Modificado Correctamente", 
			2 => "success",
			3 => "btn-primary",
			4 => "",
			5 => "Registro",
			6 => "AtencionMedicaSeguimiento",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $seguimiento_id,
			9 => "",
		);

		//AGREGAMOS LOS ARCHIVOS CARGADOS EN LA ENTIDAD seguimiento_detalles	
		// Count total uploaded files
		$totalfiles = count($_FILES['files']['name']);

		//RECORREMOS EL FILE INPUT
		for($i=0;$i<$totalfiles;$i++){
			$seguimiento_detalles_id = correlativo('seguimiento_detalles_id', 'seguimiento_detalles');	
			$filename = $_FILES['files']['name'][$i];
			 
			//ESTABLECEMOS EL PATH DONDE SE GUARDARA EL DOCUMENTO
			$path = $_SERVER["DOCUMENT_ROOT"].PRODUCT_PATH.$filename;
			if (file_exists($path)){
				$file_exist = 1;
			}else{
				move_uploaded_file($_FILES["files"]["tmp_name"][$i],$path);			 			
				$insert = "INSERT INTO seguimiento_detalles VALUES('$seguimiento_detalles_id','$seguimiento_id','$filename')";
				$mysqli->query($insert);
			}
		}

		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado una nueva atención para este paciente: $paciente con identidad n° $identidad";
		$modulo = "Historia Clinica";
		$insert = "INSERT INTO historial 
			VALUES('$historial_numero','$pacientes_id','$expediente','$modulo','$seguimiento_id','$colaborador_id','$servicio_id','$fecha_cita','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
		$mysqli->query($insert) or die($mysqli->error);
		/********************************************/			
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
}else{//YA EXISTE UNA ATENCION NO SE PUEDE GUARDAR
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

$mysqli->close();//CERRAR CONEXIÓN
?>