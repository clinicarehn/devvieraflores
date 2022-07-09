<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

$agenda_id = $_POST['agenda_id'];
$pacientes_id = $_POST['pacientes_id'];
$servicio_id = 1;
$fecha_cita = $_POST['fecha_cita'];
$historia_clinica_id = $_POST['historia_clinica_id'];
$gestas = cleanString($_POST['gestas']);
$partos = cleanString($_POST['partos']);
$cesareas = cleanString($_POST['cesareas']);
$hijos_vivos = cleanString($_POST['hijos_vivos']);
$hijos_muertos = cleanString($_POST['hijos_muertos']);
$obitos = cleanString($_POST['obitos']);
$abortos = cleanString($_POST['abortos']);
$fum = cleanString($_POST['fum']);
$edad_gestacional = cleanString($_POST['edad_gestacional']);
$tipo_rh = cleanString($_POST['tipo_rh']);
$vih_vdrl = cleanString($_POST['vih_vdrl']);
$citologia = cleanString($_POST['citologia']);
$mpf = cleanString($_POST['mpf']);
$menarquia = cleanString($_POST['menarquia']);
$inicio_vida_sexual = cleanString($_POST['inicio_vida_sexual']);
$vida_sexual = cleanString($_POST['vida_sexual']);
$ciclos_menstruales = cleanString($_POST['ciclos_menstruales']);
$duracion = cleanString($_POST['duracion']);
$cantidad = cleanString($_POST['cantidad']);
$dismenorrea = cleanString($_POST['dismenorrea']);
$ante_perso_pato = cleanString($_POST['ante_perso_pato']);
$ante_fam_pato = cleanString($_POST['ante_fam_pato']);
$ant_hosp_trauma_quirur = cleanString($_POST['ant_hosp_trauma_quirur']);
$ant_inmuno_aler = cleanString($_POST['ant_inmuno_aler']);
$hab_toxicos = cleanString($_POST['hab_toxicos']);
$motivo_consulta = cleanString($_POST['motivo_consulta']);
$hist_enfe_actual = cleanString($_POST['hist_enfe_actual']);
$pa_aten = cleanString($_POST['pa_aten']);
$fc_aten = cleanString($_POST['fc_aten']);
$fr_aten = cleanString($_POST['fr_aten']);
$t_aten = cleanString($_POST['t_aten']);
$peso_aten = cleanString($_POST['peso_aten']);
$talla_aten = cleanString($_POST['talla_aten']);
$imc_aten = cleanString($_POST['imc_aten']);
$orl_aten = cleanString($_POST['orl_aten']);
$mamas_aten = cleanString($_POST['mamas_aten']);
$pulmones = cleanString($_POST['pulmones']);
$abdomen_aten = cleanString($_POST['abdomen_aten']);
$afu_aten = cleanString($_POST['afu_aten']);
$fcf_aten = cleanString($_POST['fcf_aten']);
$au_aten = cleanString($_POST['au_aten']);
$fm_aten = cleanString($_POST['fm_aten']);
$presentacion_aten = cleanString($_POST['presentacion_aten']);
$inspe_visual = cleanString($_POST['inspe_visual']);
$espesculoscopia = cleanString($_POST['espesculoscopia']);
$tbm_aten = cleanString($_POST['tbm_aten']);
$extremidades = cleanString($_POST['extremidades']);
$ultrasonido = cleanString($_POST['ultrasonido']);
$diagnostico = cleanString($_POST['diagnostico']);
$manejo = cleanString($_POST['manejo']);
$receta = cleanString($_POST['receta']);
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
$consultar_atencion = "SELECT historia_clinica_id 
	FROM historia_clinica
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id' AND servicio_id = '$servicio_id'";
$result_atencion = $mysqli->query($consultar_atencion) or die($mysqli->error);

if($result_atencion->num_rows>0){//NO EXISTE LA ATENCION PROCEDEMOS A GUARDARLA
	//MODIFICAMOS LOS DATOS EN LA ENTIDAD historia_clinica
	$update = "UPDATE historia_clinica 
		SET 
			gestas = '$gestas',
			partos = '$partos',
			cesareas = '$cesareas',
			hijos_vivos = '$hijos_vivos',
			hijos_muertos = '$hijos_muertos',
			obitos = '$obitos',
			abortos = '$abortos',
			fum = '$fum',
			edad_gestacional = '$edad_gestacional',
			tipo_rh = '$tipo_rh',
			vih_vdrl = '$vih_vdrl',
			citologia = '$citologia',
			mpf = '$mpf',
			menarquia = '$menarquia',
			inicio_vida_sexual = '$inicio_vida_sexual',
			vida_sexual = '$vida_sexual',
			ciclos_menstruales = '$ciclos_menstruales',
			duracion = '$duracion',
			cantidad = '$cantidad',
			dismenorrea = '$dismenorrea',
			ante_perso_pato = '$ante_perso_pato',
			ante_fam_pato = '$ante_fam_pato',
			ant_hosp_trauma_quirur = '$ant_hosp_trauma_quirur',
			ant_inmuno_aler = '$ant_inmuno_aler',
			hab_toxicos = '$hab_toxicos',
			motivo_consulta = '$motivo_consulta',
			hist_enfe_actual = '$hist_enfe_actual',
			pa_aten = '$pa_aten',
			fc_aten = '$fc_aten',
			fr_aten = '$fr_aten',
			t_aten = '$t_aten',
			peso_aten = '$peso_aten',
			talla_aten = '$talla_aten',
			imc_aten = '$imc_aten',
			orl_aten = '$orl_aten',
			mamas_aten = '$mamas_aten',
			pulmones = '$pulmones',
			abdomen_aten = '$abdomen_aten',
			afu_aten = '$afu_aten',
			fcf_aten = '$fcf_aten',
			au_aten = '$au_aten',
			fm_aten = '$fm_aten',
			presentacion_aten = '$presentacion_aten',
			inspe_visual = '$inspe_visual',
			espesculoscopia = '$espesculoscopia',
			tbm_aten = '$tbm_aten',
			extremidades = '$extremidades',
			ultrasonido = '$ultrasonido',
			diagnostico = '$diagnostico',
			manejo = '$manejo',
			receta = '$receta'
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
			6 => "AtencionMedica",//FUNCION DE LA TABLA QUE LLAMAREMOS PARA QUE ACTUALICE (DATATABLE BOOSTRAP)
			7 => "", //Modals Para Cierre Automatico
			8 => $historia_clinica_id,
			9 => "",
		);

		//INGRESAR REGISTROS EN LA ENTIDAD HISTORIAL
		$historial_numero = historial();
		$estado_historial = "Agregar";
		$observacion_historial = "Se ha agregado una nueva atención para este paciente: $paciente con identidad n° $identidad";
		$modulo = "Historia Clinica";
		$insert = "INSERT INTO historial 
			VALUES('$historial_numero','$pacientes_id','$expediente','$modulo','$historia_clinica_id','$colaborador_id','$servicio_id','$fecha_cita','$estado_historial','$observacion_historial','$colaborador_id','$fecha_registro')";	 
		$mysqli->query($insert) or die($mysqli->error);
		/********************************************/			
	}else{
		$datos = array(
			0 => "Error", 
			1 => "No se puedo modificar este registro, los datos son incorrectos por favor corregir", 
			2 => "error",
			3 => "btn-danger",
			4 => "",
			5 => "",			
		);
	}
}else{//YA EXISTE UNA ATENCION NO SE PUEDE GUARDAR
	$datos = array(
		0 => "Error", 
		1 => "Lo sentimos este registro no existe no se puede almacenar", 
		2 => "error",
		3 => "btn-danger",
		4 => "",
		5 => "",		
	);
}

echo json_encode($datos);

$mysqli->close();//CERRAR CONEXIÓN
?>