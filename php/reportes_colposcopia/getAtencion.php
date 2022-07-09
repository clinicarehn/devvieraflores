<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$atencion_id = $_POST['atencion_id'];

$query = "SELECT p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', tp.nombre AS 'test_vph',
am.fecha AS 'fecha', am.paciente AS 'paciente', am.edad AS 'edad',
(CASE WHEN p.genero = 'H' THEN 'X' ELSE '' END) AS 'h',
(CASE WHEN p.genero = 'M' THEN 'X' ELSE '' END) AS 'm',
(CASE WHEN am.paciente = 'N' THEN 'X' ELSE '' END) AS 'n',
(CASE WHEN am.paciente = 'S' THEN 'X' ELSE '' END) AS 's', d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad', am.observaciones AS 'observaciones', rc.nombre AS 'resultado_citologia', eg.nombre AS 'evaluacion_general', zt.nombre AS 'zona_transformacion', h.nombre AS 'hallazgos',
(CASE WHEN am.biopsia = 1 THEN 'Sí' ELSE 'No' END) AS 'biopsia',
(CASE WHEN am.ecc = 1 THEN 'Sí' ELSE 'No' END) AS 'ecc',
(CASE WHEN am.test_schiller = 1 THEN '+' ELSE '-' END) AS 'test_schiller',
am.observaciones1 AS 'observaciones1', am.tratamiento AS 'tratamiento', am.seguimiento AS 'seguimiento', rb.nombre AS 'resultados_biopsia', e.nombre AS 'empresa', e.ubicacion AS 'ubicacion'
	FROM colcoscopia AS am
	INNER JOIN pacientes AS p
	ON am.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON am.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON am.servicio_id = s.servicio_id
	INNER JOIN test_vph AS tp
	ON am.test_vph_id = tp.test_vph_id
	INNER JOIN resultado_citologia AS rc
	ON am.resultado_citologia_id = rc.resultado_citologia_id
	INNER JOIN evaluacion_general AS eg
	ON am.evaluacion_general_id = eg.evaluacion_general_id 
	INNER JOIN zona_transformacion AS zt
	ON am.zona_transformacion_id = zt.zona_transformacion_id
	INNER JOIN hallazgos AS h
	ON am.hallazgos_id = h.hallazgos_id
	INNER JOIN resultados_biopsia AS rb
	ON am.resultados_biopsia_id = rb.resultados_biopsia_id
	INNER JOIN departamentos AS d
  	ON p.departamento_id = d.departamento_id
  	INNER JOIN municipios AS m
  	ON p.municipio_id = m.municipio_id	
	INNER JOIN empresa AS e
	ON c.empresa_id = e.empresa_id
	WHERE am.colcoscopia_id = '$atencion_id'";

$result = $mysqli->query($query);

if($result->num_rows>0){
	$registro2=$result->fetch_assoc();
	$usuario = $registro2['usuario'];
	$identidad = $registro2['identidad'];
	$genero = $registro2['genero'];
	$paciente = $registro2['paciente'];		   
	$edad = $registro2['edad'];

	$profesional = $registro2['profesional'];
	$empresa = $registro2['empresa'];
	$ubicacion = $registro2['ubicacion'];			

	$test_vph = $registro2['test_vph'];
	$resultado_citologia = $registro2['resultado_citologia'];
	$observaciones = $registro2['observaciones'];
	$evaluacion_general = $registro2['evaluacion_general'];		   
	$zona_transformacion = $registro2['zona_transformacion'];	
	$hallazgos = $registro2['hallazgos'];	
	$biopsia = $registro2['biopsia'];		   
	$ecc = $registro2['ecc'];
	$test_schiller = $registro2['test_schiller'];		   
	$observaciones1 = $registro2['observaciones1']; 
	$resultados_biopsia = $registro2['resultados_biopsia'];
	$tratamiento = $registro2['tratamiento'];
	$seguimiento = $registro2['seguimiento'];

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
				<p style='color: #077A2F;' align='center'><b>Responsable del Examen Colposcópico Ginecostetrica</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Nombre:</b> $profesional</p>
			</div>				
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Nombre del Establecimiento:</b> $empresa</p>
			</div>									
		</div>	
		<div class='form-row'>				
			<div class='col-md-12 mb-3'>
				<p><b>Localidad del Establecimiento:</b> $ubicacion</p>
			</div>				
		</div>					
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Información Complementaria</b></p>
			</div>					
		</div>			
		<div class='form-row'>					
			<div class='col-md-6 mb-3'>
				<p><b>Resultados Test VPH:</b> $test_vph</p>
			</div>					
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Resultados de la Citología:</b> $resultado_citologia</p>
			</div>															
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Observaciones</b></p>
			</div>					
		</div>			
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Observaciones</b> $observaciones</p>
			</div>														
		</div>		
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Colposcopía</b></p>
			</div>					
		</div>			
		<div class='form-row'>					
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Evaluación General:</b> $evaluacion_general</p>
			</div>					
			<div class='col-md-6 mb-3 sm-3'>
				<p><b>Zona de Transformación:</b> $zona_transformacion</p>
			</div>													
		</div>
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Hallazgos Colposcópicos (IFCPC 2011)*</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-6 mb-3'>
				<p><b>Hallazgos:</b> $hallazgos</p>
			</div>														
		</div>	
		
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Biopsia:</b> $biopsia</p>
			</div>	
			<div class='col-md-3 mb-3'>
				<p><b>ECC:</b> $ecc</p>
			</div>	
			<div class='col-md-3 mb-3'>
				<p><b>Test de Schiller:</b> $test_schiller</p>
			</div>																				
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Observaciones</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Observaciones:</b> $observaciones1</p>
			</div>																						
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Resultados de Biopsia</b></p>
			</div>					
		</div>			
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Resultados:</b> $resultados_biopsia</p>
			</div>																								
		</div>
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Tratamiento</b></p>
			</div>					
		</div>		
		<div class='form-row'>	
			<div class='col-md-12 mb-3'>
				<p><b>Tratamiento:</b> $tratamiento</p>
			</div>																												
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Seguimiento</b></p>
			</div>					
		</div>		
		<div class='form-row'>	
			<div class='col-md-12 mb-3'>
				<p><b>Seguimiento:</b> $seguimiento</p>
			</div>																												
		</div>	
	";
}

echo $datos;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>