<?php
session_start();   
include "../funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli(); 

$colaborador_id = $_SESSION['colaborador_id'];
$paginaActual = $_POST['partida'];

$paginaActual = $_POST['partida'];
$desde = $_POST['desde'];
$hasta = $_POST['hasta'];
$dato = $_POST['dato'];	
$colaborador = $_POST['colaborador'];

$colaborador_where = "";
$dato_where = "";

if($colaborador != ""){
	$where = "WHERE am.fecha BETWEEN '$desde' AND '$hasta' AND c.colaborador_id = '$profesional' AND am.estado = 1";
}else if($dato != ""){
	$where = "WHERE CONCAT(p.nombre,' ',p.apellido) LIKE '%$dato%' OR p.apellido LIKE '$dato%' OR p.identidad LIKE '$dato%' AND am.estado = 1";
}else{
	$where = "WHERE am.fecha BETWEEN '$desde' AND '$hasta' AND am.estado = 1";
}

$query = "SELECT p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', tp.nombre AS 'test_vph', am.observaciones AS 'observaciones', zt.nombre AS 'evaluacion_general', zt.nombre AS 'zona_transformacion', h.nombre AS 'hallazgos', am.observaciones1 AS 'observaciones1', rb.nombre AS 'resultados_biopsia', am.colcoscopia_id AS 'colcoscopia_id',
am.fecha AS 'fecha', am.paciente AS 'paciente', am.edad AS 'edad',
(CASE WHEN p.genero = 'H' THEN 'X' ELSE '' END) AS 'h',
(CASE WHEN p.genero = 'M' THEN 'X' ELSE '' END) AS 'm',
(CASE WHEN am.paciente = 'N' THEN 'X' ELSE '' END) AS 'n',
(CASE WHEN am.paciente = 'S' THEN 'X' ELSE '' END) AS 's',
(CASE WHEN am.biopsia = 1 THEN 'Sí' ELSE 'No' END) AS 'biopsia',
(CASE WHEN am.ecc = 1 THEN 'Sí' ELSE 'No' END) AS 'ecc',
(CASE WHEN am.test_schiller = 1 THEN '+' ELSE '-' END) AS 'test_schiller'
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
	".$where."
    ORDER BY am.fecha DESC";	
$result = $mysqli->query($query);
$nroProductos = $result->num_rows;
  
$nroLotes = 15;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.(1).');">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual-1).');">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual+1).');">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($nroPaginas).');">Ultima</a></li>';
}	

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$registro = "SELECT p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero', tp.nombre AS 'test_vph', am.observaciones AS 'observaciones', zt.nombre AS 'evaluacion_general', zt.nombre AS 'zona_transformacion', h.nombre AS 'hallazgos', am.observaciones1 AS 'observaciones1', rb.nombre AS 'resultados_biopsia', am.colcoscopia_id AS 'colcoscopia_id',
am.fecha AS 'fecha', am.paciente AS 'paciente', am.edad AS 'edad',
(CASE WHEN p.genero = 'H' THEN 'X' ELSE '' END) AS 'h',
(CASE WHEN p.genero = 'M' THEN 'X' ELSE '' END) AS 'm',
(CASE WHEN am.paciente = 'N' THEN 'X' ELSE '' END) AS 'n',
(CASE WHEN am.paciente = 'S' THEN 'X' ELSE '' END) AS 's',
(CASE WHEN am.biopsia = 1 THEN 'Sí' ELSE 'No' END) AS 'biopsia',
(CASE WHEN am.ecc = 1 THEN 'Sí' ELSE 'No' END) AS 'ecc',
(CASE WHEN am.test_schiller = 1 THEN '+' ELSE '-' END) AS 'test_schiller'
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
	".$where."
    ORDER BY am.fecha DESC
	LIMIT $limit, $nroLotes";
$result = $mysqli->query($registro);

$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			<tr>
			<th width="8.25%">Fecha</th>
			<th width="28.25%">Paciente</th>
			<th width="6.25%">Identidad</th>
			<th width="6.25%">Genero</th>
			<th width="5.25%">Tipo Paciente</th>
			<th width="3.25%">Edad</th>
			<th width="4.25%">Test VPH</th>
			<th width="4.25%">Observaciones</th>
			<th width="4.25%">Evaluación General</th>
			<th width="4.25%">Zona de Transformación</th>
			<th width="4.25%">Hallazgos</th>
			<th width="4.25%">Biopsia</th>
			<th width="4.25%">ECC</th>
			<th width="4.25%">Test Schiller</th>
			<th width="4.25%">Observación 1</th>
			<th width="4.25%">Resultados Biopsia</th>					
			</tr>';			
			
while($registro2 = $result->fetch_assoc()){	
	$tabla = $tabla.'<tr>
	   <td><a style="text-decoration:none" title = "Información de Usuario" href="javascript:showData('.$registro2['colcoscopia_id'].');">'.$registro2['fecha'].'</a></td>
	   <td>'.$registro2['usuario'].'</td>		   
	   <td>'.$registro2['identidad'].'</td>	
       <td>'.$registro2['genero'].'</td>	
       <td>'.$registro2['paciente'].'</td>		   
	   <td>'.$registro2['edad'].'</td>
	   <td>'.$registro2['test_vph'].'</td>		   
	   <td>'.$registro2['observaciones'].'</td>
	   <td>'.$registro2['evaluacion_general'].'</td>
	   <td>'.$registro2['zona_transformacion'].'</td>		   
	   <td>'.$registro2['hallazgos'].'</td>	
       <td>'.$registro2['biopsia'].'</td>	
       <td>'.$registro2['ecc'].'</td>		   
	   <td>'.$registro2['test_schiller'].'</td>
	   <td>'.$registro2['observaciones1'].'</td>		   
	   <td>'.$registro2['resultados_biopsia'].'</td>   
	</tr>';	        
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="17" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="17"><b><p ALIGN="center">Total de Registros Encontrados '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>