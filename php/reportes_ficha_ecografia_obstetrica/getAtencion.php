<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$eco_obstetrica_id = $_POST['eco_obstetrica_id'];

$query = "SELECT am.*, p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero',
(CASE WHEN am.unico = 1 THEN 'Sí' ELSE 'No' END) AS 'unico',
(CASE WHEN am.multiple = 1 THEN 'Sí' ELSE 'No' END) AS 'multiple',
(CASE WHEN am.longitudinal = 1 THEN 'Sí' ELSE 'No' END) AS 'longitudinal',
(CASE WHEN am.transverso = 1 THEN 'Sí' ELSE 'No' END) AS 'transverso',
(CASE WHEN am.cefalica = 1 THEN 'Sí' ELSE 'No' END) AS 'cefalica',
(CASE WHEN am.podalica = 1 THEN 'Sí' ELSE 'No' END) AS 'podalica',
(CASE WHEN am.izquierda = 1 THEN 'Sí' ELSE 'No' END) AS 'izquierda',
(CASE WHEN am.derecha = 1 THEN 'Sí' ELSE 'No' END) AS 'derecha',
(CASE WHEN am.posterior = 1 THEN 'Sí' ELSE 'No' END) AS 'posterior',
(CASE WHEN am.anterior = 1 THEN 'Sí' ELSE 'No' END) AS 'anterior',
am.sg AS 'sg', am.cc AS 'cc', am.lcn AS 'lcn', am.ca AS 'ca', am.dbp AS 'dbp', am.lf AS 'lf', am.ponderado_fetal AS 'ponderado_fetal', am.fcf AS 'fcf',
(CASE WHEN am.placenta_anterior = 1 THEN 'Sí' ELSE 'No' END) AS 'placenta_anterior',
(CASE WHEN am.placenta_posterior = 1 THEN 'Sí' ELSE 'No' END) AS 'placenta_posterior',
(CASE WHEN am.placenta_fundica = 1 THEN 'Sí' ELSE 'No' END) AS 'placenta_fundica',
(CASE WHEN am.placenta_previa = 1 THEN 'Sí' ELSE 'No' END) AS 'placenta_previa',
(CASE WHEN am.gradoi = 1 THEN 'Sí' ELSE 'No' END) AS 'gradoi',
(CASE WHEN am.gradoii = 1 THEN 'Sí' ELSE 'No' END) AS 'gradoii',
(CASE WHEN am.gradoiii = 1 THEN 'Sí' ELSE 'No' END) AS 'gradoiii',
(CASE WHEN am.circular = 1 THEN 'Sí' ELSE 'No' END) AS 'circular',
am.liquido_amniotico AS 'liquido_amniotico', am.fecha_parto AS 'fecha_parto',
(CASE WHEN am.malformacion = 1 THEN 'Sí' ELSE 'No' END) AS 'malformacion',
(CASE WHEN am.sexo = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'sexo',
am.conclusion AS 'conclusion'
	FROM eco_obstetrica AS am
	INNER JOIN pacientes AS p
	ON am.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON am.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON am.servicio_id = s.servicio_id	
	WHERE am.eco_obstetrica_id = '$eco_obstetrica_id'";

$result = $mysqli->query($query);

if($result->num_rows>0){
	$registro2=$result->fetch_assoc();
	$usuario = $registro2['usuario'];
	$identidad = $registro2['identidad'];
	$genero = $registro2['genero'];
	$paciente = $registro2['paciente'];		   
	$edad = $registro2['edad'];

	$unico = $registro2['unico'];
	$multiple = $registro2['multiple'];
	$longitudinal = $registro2['longitudinal'];
	$transverso = $registro2['transverso'];		   
	$cefalica = $registro2['cefalica'];	
	$podalica = $registro2['podalica'];	
	$izquierda = $registro2['izquierda'];		   
	$derecha = $registro2['derecha'];
	$posterior = $registro2['posterior'];	
	$anterior = $registro2['anterior'];		   
	$sg = $registro2['sg']; 
	$cc = $registro2['cc'];
	$lcn = $registro2['lcn'];
	$ca = $registro2['ca'];
	$dbp = $registro2['dbp'];		   
	$lf = $registro2['lf'];
	$ponderado_fetal = $registro2['ponderado_fetal'];
	$fcf = $registro2['fcf'];
	$placenta_anterior = $registro2['placenta_anterior'];
	$placenta_posterior = $registro2['placenta_posterior'];		   
	$placenta_fundica = $registro2['placenta_fundica'];	
	$placenta_previa = $registro2['placenta_previa'];	
	$gradoi = $registro2['gradoi'];		   
	$gradoii = $registro2['gradoii'];
	$gradoiii = $registro2['gradoiii'];
	$circular = $registro2['circular'];
	$liquido_amniotico = $registro2['liquido_amniotico'];		   
	$fecha_parto = $registro2['fecha_parto'];	
	$malformacion = $registro2['malformacion'];	
	$sexo = $registro2['sexo'];		   
	$conclusion = $registro2['conclusion'];	

	$datos = "
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Información Paciente</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-4 mb-3'>
				<p><b>Paciente:</b> $usuario</p>
			</div>
			<div class='col-md-4 mb-3'>
				<p><b>Identidad:</b> $identidad</p>
			</div>					
			<div class='col-md-4 mb-3'>
				<p><b> Edad:</b> $edad</p>
			</div>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Genero:</b> $genero</p>
			</div>					
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Ecografía Obstétrica</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Feto Único:</b> $unico</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Multiple:</b> $multiple</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Situación Longitudinal:</b> $longitudinal</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Transverso:</b> $transverso</p>
			</div>							
		</div>	

		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Presentación Cefálica:</b> $cefalica</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Podálica:</b> $podalica</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Posición Izquierda:</b> $izquierda</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Derecha:</b> $derecha</p>
			</div>							
		</div>	
		
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Dorso Posterior:</b> $posterior</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Podálica:</b> $podalica</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Anterior:</b> $anterior</p>
			</div>						
		</div>			
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Biometría</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-3 mb-3'>
				<p><b>SG:</b> $sg</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>CC:</b> $cc</p>
			</div>	
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>LCN:</b> $lcn</p>
			</div>	
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>CA:</b> $ca</p>
			</div>																			
		</div>

		<div class='form-row'>					
			<div class='col-md-3 mb-3'>
				<p><b>DBP:</b> $dbp</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>LF:</b> $lf</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Ponderado Fetal:</b> $ponderado_fetal</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>FCF:</b> $fcf</p>
			</div>																								
		</div>
		
		<div class='form-row'>					
			<div class='col-md-3 mb-3'>
				<p><b>Placenta Anterior:</b> $placenta_anterior</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Posterior:</b> $placenta_posterior</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Fúndida:</b> $placenta_fundica</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Previa:</b> $placenta_previa</p>
			</div>																								
		</div>	
		
		<div class='form-row'>					
			<div class='col-md-3 mb-3'>
				<p><b>Grado I:</b> $gradoi</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Grado II:</b> $gradoii</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Grado III:</b> $gradoiii</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Circular:</b> $circular</p>
			</div>																								
		</div>			

		<div class='form-row'>					
			<div class='col-md-6 mb-3'>
				<p><b>Líquido Amniótico:</b> $liquido_amniotico</p>
			</div>					
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Fecha Probable de Parto:</b> $fecha_parto</p>
			</div>																						
		</div>
		
		<div class='form-row'>
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Malformación:</b> $malformacion</p>
			</div>
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Sexo:</b> $sexo</p>
			</div>																								
		</div>		

		<div class='form-row'>					
			<div class='col-md-3 mb-3'>
				<p><b>Conclusiones:</b> $conclusion</p>
			</div>																								
		</div>		
	";
}

echo $datos;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>