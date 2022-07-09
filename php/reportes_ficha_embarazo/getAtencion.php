<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$atencion_id = $_POST['atencion_id'];

$query = "SELECT am.*, p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio',
d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad', 
(CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', 
am.paciente AS 'paciente'
FROM embarazo AS am
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
WHERE am.atencion_id = '$atencion_id'";

$result = $mysqli->query($query);

if($result->num_rows>0){
	$registro2=$result->fetch_assoc();
	$usuario = $registro2['usuario'];
	$identidad = $registro2['identidad'];
	$genero = $registro2['genero'];
	$paciente = $registro2['paciente'];		   
	$edad = $registro2['edad'];

	$hgo_aten = $registro2['hgo_aten'];
	$g_aten = $registro2['g_aten'];
	$p_aten = $registro2['p_aten'];
	$c_aten = $registro2['c_aten'];		   
	$a_aten = $registro2['a_aten'];	
	$ob_aten = $registro2['ob_aten'];	
	$hv_aten = $registro2['hv_aten'];		   
	$hm_aten = $registro2['hm_aten'];
	$fup_aten = $registro2['fup_aten'];	
	$complicaciones = $registro2['complicaciones'];		   
	$fum_aten = $registro2['fum_aten']; 
	$eg_fum = $registro2['eg_fum'];
	$fpp = $registro2['fpp'];
	$eg_usg = $registro2['eg_usg'];
	$ultrasonido_aten = $registro2['ultrasonido_aten'];		   
	$ultima_citologia_aten = $registro2['ultima_citologia_aten'];
	$tipo_rh = $registro2['tipo_rh'];
	$vdrl = $registro2['vdrl'];
	$ante_patologicos_person = $registro2['ante_patologicos_person'];
	$ante_pato_fami = $registro2['ante_pato_fami'];		   
	$ante_inmuno_alergicos = $registro2['ante_inmuno_alergicos'];	
	$ante_quirurgicos = $registro2['ante_quirurgicos'];	
	$vacunas_aten = $registro2['vacunas_aten'];		   
	$vph_anten = $registro2['vph_anten'];
	$otros_anten = $registro2['otros_anten'];
	$hea_aten = $registro2['hea_aten'];		   
	$pa_aten = $registro2['pa_aten'];
	$peso_anten = $registro2['peso_anten'];
	$talla_anten = $registro2['talla_anten'];
	$afu = $registro2['afu'];
	$fcf = $registro2['fcf'];		   
	$mf = $registro2['mf'];	
	$presentacion = $registro2['presentacion'];	
	$go_aten = $registro2['go_aten'];		   
	$ultrasonido = $registro2['ultrasonido'];	
	$dx = $registro2['dx'];	
	$tx = $registro2['tx'];

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
				<p style='color: #077A2F;' align='center'><b>Historia Ginecobstetrica</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>HGO:</b> $hgo_aten</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>G:</b> $g_aten</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>P:</b> $p_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>C:</b> $c_aten</p>
			</div>							
		</div>	

		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>A:</b> $a_aten</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>OB:</b> $ob_aten</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>HV:</b> $hv_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>HM:</b> $hm_aten</p>
			</div>							
		</div>
		
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>FUP:</b> $fup_aten</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Complicaciones:</b> $complicaciones</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>FUM:</b> $fum_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>EG por FUM:</b> $eg_fum</p>
			</div>							
		</div>	
		
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>FPP:</b> $fpp</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>EG por USG:</b> $eg_usg</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Ultrasonido:</b> $ultrasonido_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Última Citología:</b> $ultima_citologia_aten</p>
			</div>							
		</div>			
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Antecedentes</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-4 mb-3'>
				<p><b>Tipo y RH:</b> $tipo_rh</p>
			</div>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>VDRL:</b> $vdrl</p>
			</div>																
		</div>

		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Patológicos Personales:</b> $ante_patologicos_person</p>
			</div>															
		</div>	
		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Patológicos Familiares:</b> $ante_pato_fami</p>
			</div>															
		</div>
		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Inmuno-alergicos:</b> $ante_inmuno_alergicos</p>
			</div>															
		</div>	
		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Quirurgicos:</b> $ante_quirurgicos</p>
			</div>															
		</div>			

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Vacunas</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-4 mb-3'>
				<p><b>Vacunas:</b> $vacunas_aten</p>
			</div>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>VPH:</b> $vph_anten</p>
			</div>	
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Otros:</b> $otros_anten</p>
			</div>																
		</div>		
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Historia de la enfermedad actual</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>HEA:</b> $hea_aten</p>
			</div>													
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Examen Físico</b></p>
			</div>					
		</div>			
		
		<div class='form-row'>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>P/A:</b> $pa_aten</p>
			</div>
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Peso:</b> $peso_anten</p>
			</div>
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Talla:</b> $talla_anten</p>
			</div>																				
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Abdomen</b></p>
			</div>					
		</div>			
		
		<div class='form-row'>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>AFU:</b> $afu</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>FCF:</b> $fcf</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>MF:</b> $mf</p>
			</div>
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Presentación:</b> $presentacion</p>
			</div>																							
		</div>		

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Otros</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>GO:</b> $go_aten</p>
			</div>																						
		</div>	

		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>ultrasonido:</b> $ultrasonido</p>
			</div>																						
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>DX:</b> $dx</p>
			</div>																						
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>TX:</b> $tx</p>
			</div>																						
		</div>			
	";
}

echo $datos;

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>