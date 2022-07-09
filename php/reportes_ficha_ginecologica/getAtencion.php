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
FROM atenciones_medicas AS am
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
	$vsa_aten = $registro2['vsa_aten'];		   
	$fum_aten = $registro2['fum_aten']; 
	$mpf_aten = $registro2['mpf_aten'];
	$menarquia = $registro2['menarquia'];
	$ultima_citologia = $registro2['ultima_citologia'];
	$ciclos_menstruales_aten = $registro2['ciclos_menstruales_aten'];		   
	$ultimo_usg_aten = $registro2['ultimo_usg_aten'];
	$antec_personales_aten = $registro2['antec_personales_aten'];
	$ante_familiares_anten = $registro2['ante_familiares_anten'];
	$ante_alergicos_anten = $registro2['ante_alergicos_anten'];
	$ante_quirurgicos_anten = $registro2['ante_quirurgicos_anten'];		   
	$vacunas_aten = $registro2['vacunas_aten'];	
	$vph_anten = $registro2['vph_anten'];	
	$otros_anten = $registro2['otros_anten'];		   
	$hea = $registro2['hea'];
	$pa = $registro2['pa'];
	$peso = $registro2['peso'];
	$talla = $registro2['talla'];		   
	$go = $registro2['go'];	
	$especuloscopia = $registro2['especuloscopia'];	
	$tacto_bimanual = $registro2['tacto_bimanual'];		   
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
				<p><b>VSA:</b> $vsa_aten</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>FUM:</b> $fum_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>MPF:</b> $mpf_aten</p>
			</div>							
		</div>
		
		<div class='form-row'>
			<div class='col-md-3 mb-3'>
				<p><b>Menarquía:</b> $menarquia</p>
			</div>
			<div class='col-md-3 mb-3'>
				<p><b>Última Citología:</b> $ultima_citologia</p>
			</div>					
			<div class='col-md-3 mb-3'>
				<p><b>Ciclos Mensturales:</b> $ciclos_menstruales_aten</p>
			</div>					
			<div class='col-md-3 mb-3 sm-3'>
				<p><b>Último USG:</b> $ultimo_usg_aten</p>
			</div>							
		</div>				
		
		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Antecedentes</b></p>
			</div>					
		</div>		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Patológicos Personales:</b> $antec_personales_aten</p>
			</div>														
		</div>

		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Patológicos Familiares:</b> $ante_familiares_anten</p>
			</div>														
		</div>
		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Inmuno-alergicos:</b> $ante_alergicos_anten</p>
			</div>														
		</div>
		
		<div class='form-row'>					
			<div class='col-md-12 mb-3'>
				<p><b>Antecedentes Quirurgicos:</b> $ante_quirurgicos_anten</p>
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
			<div class='col-md-12 mb-3 sm-3'>
				<p><b>HEA:</b> $hea</p>
			</div>														
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Examen Físico</b></p>
			</div>					
		</div>			
		
		<div class='form-row'>					
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>P/A:</b> $pa</p>
			</div>
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Peso:</b> $peso</p>
			</div>
			<div class='col-md-4 mb-3 sm-3'>
				<p><b>Talla:</b> $talla</p>
			</div>																				
		</div>

		<div class='form-row'>
			<div class='col-md-12 mb-6 sm-3'>
				<p style='color: #077A2F;' align='center'><b>Otros</b></p>
			</div>					
		</div>	
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Go:</b> $go</p>
			</div>														
		</div>
		
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Especuloscopia:</b> $especuloscopia</p>
			</div>														
		</div>	
		
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Tacto Bimanual:</b> $tacto_bimanual</p>
			</div>													
		</div>
		
		<div class='form-row'>
			<div class='col-md-12 mb-3'>
				<p><b>Ultrasonido:</b> $ultrasonido</p>
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