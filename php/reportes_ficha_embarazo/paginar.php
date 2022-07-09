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

$query = "SELECT am.*, p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero'
	FROM embarazo AS am
	INNER JOIN pacientes AS p
	ON am.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON am.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON am.servicio_id = s.servicio_id
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

$registro = "SELECT am.*, p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio', (CASE WHEN p.genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero'
	FROM embarazo AS am
	INNER JOIN pacientes AS p
	ON am.pacientes_id = p.pacientes_id
	INNER JOIN colaboradores AS c
	ON am.colaborador_id = c.colaborador_id
	INNER JOIN servicios AS s
	ON am.servicio_id = s.servicio_id
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
			<th width="4.25%">HGO</th>
			<th width="4.25%">G</th>
			<th width="4.25%">P</th>
			<th width="4.25%">C</th>
			<th width="4.25%">A</th>
			<th width="4.25%">OB</th>
			<th width="4.25%">HV</th>
			<th width="4.25%">HM</th>
			<th width="4.25%">FUP</th>
			<th width="4.25%">VSA</th>					
			</tr>';			
			
while($registro2 = $result->fetch_assoc()){	
	$tabla = $tabla.'<tr>
	   <td><a style="text-decoration:none" title = "Información de Usuario" href="javascript:showData('.$registro2['atencion_id'].');">'.$registro2['fecha'].'</a></td>
	   <td>'.$registro2['usuario'].'</td>		   
	   <td>'.$registro2['identidad'].'</td>	
       <td>'.$registro2['genero'].'</td>	
       <td>'.$registro2['paciente'].'</td>		   
	   <td>'.$registro2['edad'].'</td>
	   <td>'.$registro2['hgo_aten'].'</td>		   
	   <td>'.$registro2['g_aten'].'</td>
	   <td>'.$registro2['p_aten'].'</td>
	   <td>'.$registro2['c_aten'].'</td>		   
	   <td>'.$registro2['a_aten'].'</td>	
       <td>'.$registro2['ob_aten'].'</td>	
       <td>'.$registro2['hv_aten'].'</td>		   
	   <td>'.$registro2['hm_aten'].'</td>
	   <td>'.$registro2['fup_aten'].'</td>		   
	   <td>'.$registro2['complicaciones'].'</td>   
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