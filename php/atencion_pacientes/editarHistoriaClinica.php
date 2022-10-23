<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$agenda_id = $_POST['agenda_id'];

//CONSULTAMOS LA FECHA DE CITA DE LA agenda
$consulta_fecha = "SELECT CAST(fecha_cita AS DATE) AS 'fecha_cita'
	FROM agenda
	WHERE agenda_id = '$agenda_id'";
$result_consulta_fecha = $mysqli->query($consulta_fecha) or die($mysqli->error);

$fecha_cita = "";

if($result_consulta_fecha->num_rows>0){
	$consulta_registro_fecha = $result_consulta_fecha->fetch_assoc(); 
	$fecha_cita = $consulta_registro_fecha['fecha_cita'];
}

//CONSULTAR DATOS DEL METODO DE PAGO
$query = "SELECT *
	FROM historia_clinica
	WHERE pacientes_id = '$pacientes_id' AND colaborador_id = '$colaborador_id'";	
$result = $mysqli->query($query) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();   
     
$gestas = "";
$partos = "";
$cesareas = "";
$hijos_vivos = "";
$hijos_muertos = "";
$obitos = "";
$abortos = "";
$fum = "";
$edad_gestacional = "";
$tipo_rh = "";
$vih_vdrl = "";
$citologia = "";
$mpf = "";
$menarquia = "";
$inicio_vida_sexual = "";
$vida_sexual = "";
$ciclos_menstruales = "";
$duracion = "";
$cantidad = "";
$dismenorrea = "";
$ante_perso_pato = "";
$ante_fam_pato = "";
$ant_hosp_trauma_quirur = "";
$ant_inmuno_aler = "";
$hab_toxicos = "";
$motivo_consulta = "";
$hist_enfe_actual = "";
$pa_aten = "";
$fc_aten = "";
$fr_aten = "";
$t_aten = "";
$peso_aten = "";
$talla_aten = "";
$imc_aten = "";
$orl_aten = "";
$ante_fam_pato = "";
$mamas_aten = "";
$pulmones = "";
$abdomen_aten = "";
$afu_aten = "";
$fcf_aten = "";
$au_aten = "";
$fm_aten = "";
$ginecologico = "";
$extremidades = "";
$ultrasonido = "";
$diagnostico = "";
$tratamiento = "";

//OBTENEMOS LOS VALORES DEL REGISTRO
if($result->num_rows>0){
	$agenda_id = $agenda_id;
	$pacientes_id = $pacientes_id;
	$fecha_cita = $fecha_cita;
	$colaborador_id = $colaborador_id;	
	$gestas = $consulta_registro['gestas'];
	$partos = $consulta_registro['partos'];	
	$cesareas = $consulta_registro['cesareas'];
	$hijos_vivos = $consulta_registro['hijos_vivos'];	
	$hijos_muertos = $consulta_registro['hijos_muertos'];
	$obitos = $consulta_registro['obitos'];	
	$abortos = $consulta_registro['abortos'];
	$fum = $consulta_registro['fum'];
	$edad_gestacional = $consulta_registro['edad_gestacional'];	
	$tipo_rh = $consulta_registro['tipo_rh'];
	$vih_vdrl = $consulta_registro['vih_vdrl'];	
	$citologia = $consulta_registro['citologia'];
	$mpf = $consulta_registro['mpf'];	
	$menarquia = $consulta_registro['menarquia'];
	$inicio_vida_sexual = $consulta_registro['inicio_vida_sexual'];
	$vida_sexual = $consulta_registro['vida_sexual'];	
	$ciclos_menstruales = $consulta_registro['ciclos_menstruales'];
	$duracion = $consulta_registro['duracion'];	
	$cantidad = $consulta_registro['cantidad'];
	$dismenorrea = $consulta_registro['dismenorrea'];	
	$ante_perso_pato = $consulta_registro['ante_perso_pato'];
	$ante_fam_pato = $consulta_registro['ante_fam_pato'];
	$ant_hosp_trauma_quirur = $consulta_registro['ant_hosp_trauma_quirur'];	
	$ant_inmuno_aler = $consulta_registro['ant_inmuno_aler'];
	$hab_toxicos = $consulta_registro['hab_toxicos'];	
	$motivo_consulta = $consulta_registro['motivo_consulta'];
	$hist_enfe_actual = $consulta_registro['hist_enfe_actual'];	
	$pa_aten = $consulta_registro['pa_aten'];	
	$fc_aten = $consulta_registro['fc_aten'];
	$fr_aten = $consulta_registro['fr_aten'];	
	$t_aten = $consulta_registro['t_aten'];
	$peso_aten = $consulta_registro['peso_aten'];	
	$talla_aten = $consulta_registro['talla_aten'];
	$imc_aten = $consulta_registro['imc_aten'];	
	$orl_aten = $consulta_registro['orl_aten'];
	$ante_fam_pato = $consulta_registro['ante_fam_pato'];
	$mamas_aten = $consulta_registro['mamas_aten'];	
	$pulmones = $consulta_registro['pulmones'];
	$abdomen_aten = $consulta_registro['abdomen_aten'];
	$afu_aten = $consulta_registro['afu_aten'];	
	$fcf_aten = $consulta_registro['fcf_aten'];
	$au_aten = $consulta_registro['au_aten'];	
	$fm_aten = $consulta_registro['fm_aten'];
	$ginecologico = $consulta_registro['ginecologico'];	
	$extremidades = $consulta_registro['extremidades'];
	$ultrasonido = $consulta_registro['ultrasonido'];	
	$diagnostico = $consulta_registro['diagnostico'];
	$tratamiento = $consulta_registro['tratamiento'];	
}

$datos = array(
	 0 => $agenda_id, 
	 1 => $pacientes_id, 
	 2 => $fecha_cita,	 
	 3 => $colaborador_id, 	 
	 4 => $gestas, 
	 5 => $partos, 	 
	 6 => $cesareas, 	 
	 7 => $hijos_vivos, 
	 8 => $hijos_muertos, 	 
	 9 => $obitos, 
	 10 => $abortos, 
	 11 => $fum,	 
	 12 => $edad_gestacional, 	 
	 13 => $tipo_rh, 
	 14 => $vih_vdrl, 	 
	 15 => $citologia, 	 
	 16 => $mpf, 
	 17 => $menarquia, 	 
	 18 => $inicio_vida_sexual, 
	 19 => $vida_sexual, 
	 20 => $ciclos_menstruales,	 
	 21 => $duracion, 	 
	 22 => $cantidad, 
	 23 => $dismenorrea, 	 
	 24 => $ante_perso_pato, 	 
	 25 => $ante_fam_pato, 
	 26 => $ant_hosp_trauma_quirur, 	
	 27 => $ant_inmuno_aler, 
	 28 => $hab_toxicos, 
	 29 => $motivo_consulta,	 
	 30 => $hist_enfe_actual, 	 
	 31 => $pa_aten, 
	 32 => $fc_aten, 	 
	 33 => $fr_aten, 	 
	 34 => $t_aten, 
	 35 => $peso_aten, 
	 36 => $talla_aten, 	 
	 37 => $imc_aten, 
	 38 => $orl_aten, 	 
	 39 => $mamas_aten, 
	 40 => $pulmones, 
	 41 => $abdomen_aten,	 
	 42 => $afu_aten, 	 
	 43 => $fcf_aten, 
	 44 => $au_aten, 	 
	 45 => $fm_aten, 	 
	 46 => $ginecologico, 
	 47 => $extremidades,	 
	 48 => $ultrasonido, 	 
	 49 => $diagnostico, 
	 50 => $tratamiento,	 
);	
	
echo json_encode($datos);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>