<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$eco_ginecologica_id = $_POST['eco_ginecologica_id'];

$query = "SELECT am.eco_ginecologica_id AS 'eco_ginecologica_id', p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', 
(CASE WHEN am.anteverso = 1 THEN 'Sí' ELSE 'No' END) AS 'anteverso',
(CASE WHEN am.retroverso = 1 THEN 'Sí' ELSE 'No' END) AS 'retroverso',
(CASE WHEN am.regular = 1 THEN 'Sí' ELSE 'No' END) AS 'regular',
(CASE WHEN am.irregular = 1 THEN 'Sí' ELSE 'No' END) AS 'irregular',
(CASE WHEN am.homogeneo = 1 THEN 'Sí' ELSE 'No' END) AS 'homogeneo',
(CASE WHEN am.heterogeneo = 1 THEN 'Sí' ELSE 'No' END) AS 'heterogeneo',
am.medidas_utero AS 'medidas_utero', am.vo_utero AS 'vo_utero', am.otros_utero AS 'otros_utero', am.medidas_derecho AS 'medidas_derecho', 
(CASE WHEN am.masas_ovaricas_derecho = 1 THEN 'Sí' ELSE 'No' END) AS 'masas_ovaricas_derecho',
am.descripcion_derecho AS 'descripcion_derecho', am.medidas_izquierdo AS 'medidas_izquierdo', am.vol_izquierdo AS 'vol_izquierdo',
(CASE WHEN am.masas_ovaricas_izquierdo = 1 THEN 'Sí' ELSE 'No' END) AS 'masas_ovaricas_izquierdo',
am.descripcion_izquierdo AS 'descripcion_izquierdo',
(CASE WHEN am.liquido_libre = 1 THEN 'Sí' ELSE 'No' END) AS 'liquido_libre', am.cantidad AS 'cantidad', am.observacion AS 'observacion', am.conclusion AS 'conclusion',
am.fecha AS 'fecha', am.paciente AS 'paciente', am.edad AS 'edad',
(CASE WHEN p.genero = 'H' THEN 'X' ELSE '' END) AS 'h',
(CASE WHEN p.genero = 'M' THEN 'X' ELSE '' END) AS 'm',
(CASE WHEN am.paciente = 'N' THEN 'X' ELSE '' END) AS 'n',
(CASE WHEN am.paciente = 'S' THEN 'X' ELSE '' END) AS 's', d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad', am.vol_derecho AS 'vol_derecho', am.colaborador_id AS 'colaborador_id', am.servicio_id AS 'servicio_id', am.pacientes_id AS 'pacientes_id', am.endometrio AS 'endometrio'
	FROM eco_ginecologica AS am
	INNER JOIN pacientes AS p
	ON am.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON am.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON am.servicio_id = s.servicio_id
  	INNER JOIN departamentos AS d
  	ON p.departamento_id = d.departamento_id
  	INNER JOIN municipios AS m
  	ON p.municipio_id = m.municipio_id	
	WHERE am.eco_ginecologica_id = '$eco_ginecologica_id'";

$result = $mysqli->query($query);

if($result->num_rows>0){
	$registro2=$result->fetch_assoc();
	$usuario = $registro2['usuario'];
	$identidad = $registro2['identidad'];
	$genero = $registro2['genero'];
	$paciente = $registro2['paciente'];		   
	$edad = $registro2['edad'];
	$anteverso = $registro2['anteverso'];
	$retroverso = $registro2['retroverso'];
	$regular = $registro2['regular'];
	$irregular = $registro2['irregular'];		   
	$homogeneo = $registro2['homogeneo'];	
	$heterogeneo = $registro2['heterogeneo'];	
	$medidas_utero = $registro2['medidas_utero'];		   
	$vo_utero = $registro2['vo_utero'];
	$endometrio = $registro2['endometrio'];	
	$otros_utero = $registro2['otros_utero'];		   
	$medidas_derecho = $registro2['medidas_derecho']; 
	$vol_derecho = $registro2['vol_derecho'];
	$masas_ovaricas_derecho = $registro2['masas_ovaricas_derecho'];
	$descripcion_derecho = $registro2['descripcion_derecho'];
	$medidas_izquierdo = $registro2['medidas_izquierdo'];		   
	$vol_izquierdo = $registro2['vol_izquierdo'];
	$masas_ovaricas_izquierdo = $registro2['masas_ovaricas_izquierdo'];
	$descripcion_izquierdo = $registro2['descripcion_izquierdo'];
	$liquido_libre = $registro2['liquido_libre'];
	$cantidad = $registro2['cantidad'];		   
	$observacion = $registro2['observacion'];	
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
				<p style='color: #077A2F;' align='center'><b>Ecografía Ginecológica</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Posición Anteverso:</b> $anteverso</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Retroverso:</b> $retroverso</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Contorno Regular:</b> $regular</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Irregular:</b> $irregular</p>
			</div>							
		</div>	

		<div class='form-row'>		
			<div class='col-md-4 mb-3'>
				<p><b>Eco Estructura Homogéneo:</b> $homogeneo</p>
			</div>			
			<div class='col-md-4 mb-3'>
				<p><b>Heteregéneo:</b> $heterogeneo</p>
			</div>					
		</div>	
		
		<div class='form-row'>		
			<div class='col-md-4 mb-3'>
				<p><b>Medidas:</b> $medidas_utero</p>
			</div>			
			<div class='col-md-4 mb-3'>
				<p><b>Volumen:</b> $vo_utero</p>
			</div>
			<div class='col-md-4 mb-3'>
				<p><b>Endometrio:</b> $endometrio</p>
			</div>								
		</div>	
		
		<div class='form-row'>
			<div class='col-md-4 mb-3'>
				<p><b>Otro:</b> $otros_utero</p>
			</div>								
		</div>			
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Anexo Derecho</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-4 mb-3'>
				<p><b>Medidas:</b> $medidas_derecho</p>
			</div>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Volumen:</b> $vol_derecho</p>
			</div>	
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Masas Ováricas:</b> $masas_ovaricas_derecho</p>
			</div>																
		</div>

		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Descripción:</b> $descripcion_derecho</p>
			</div>															
		</div>		

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Anexo Izquierdo</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-4 mb-3'>
				<p><b>Medidas:</b> $medidas_izquierdo</p>
			</div>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Volumen:</b> $vol_izquierdo</p>
			</div>	
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Masas Ovaricas:</b> $masas_ovaricas_izquierdo</p>
			</div>																
		</div>	
		<div class='form-row'>	
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Descripción:</b> $descripcion_izquierdo</p>
			</div>																
		</div>				
		
		<div class='form-row'>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Líquido Libre:</b> $liquido_libre</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Cantidad:</b> $cantidad</p>
			</div>															
		</div>
			
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Observación:</b> $observacion</p>
			</div>
			<div class='col-md-12 mb-3'>
				<p><b>Conclusión:</b> $conclusion</p>
			</div>													
		</div>		
	";
}

echo $datos;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>