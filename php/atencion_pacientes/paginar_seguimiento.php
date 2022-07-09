<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$pacientes_id = $_POST['pacientes_id'];
$colaborador_id = $_POST['colaborador_id'];
$paginaActual = $_POST['partida'];
	
$where = "WHERE colaborador_id = '$colaborador_id' AND pacientes_id = '$pacientes_id'";

$query = "SELECT seguimiento_id, fecha_registro, motivo_consulta_seguimiento
	FROM seguimiento
	".$where."
	ORDER BY fecha_registro DESC";

$result = $mysqli->query($query) or die($mysqli->error);

$nroLotes = 10;
$nroProductos = $result->num_rows;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.(1).');void(0);">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual-1).');void(0);">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($paginaActual+1).');void(0);">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<liclass="page-item"><a class="page-link" href="javascript:paginationSeguimiento('.($nroPaginas).');void(0);">Ultima</a></li>';
}

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$registro = "SELECT seguimiento_id, fecha_registro, motivo_consulta_seguimiento, pacientes_id
	FROM seguimiento
	".$where."
	ORDER BY fecha_registro DESC
	LIMIT $limit, $nroLotes";
$result = $mysqli->query($registro) or die($mysqli->error);


$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
			<tr>
			<th width="1%">No.</th>
			<th width="25%">Fecha</th>				
			<th width="49%">Motivo Consulta</th>
			<th width="25%">Opciones</th>
			</tr>';
$i = 1;				
while($registro2 = $result->fetch_assoc()){  
	$tabla = $tabla.'<tr>
			<td>'.$i.'</td> 		
			<td>
				<a class="btn btn btn-secondary ml-2" href="javascript:modalConsultaSeguimiento('.$registro2['seguimiento_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fa-solid fa-eye"></i></a>			
				'.$registro2['fecha_registro'].'</td>            		
			<td>'.$registro2['motivo_consulta_seguimiento'].'</td>
			<td>
				<a class="btn btn btn-secondary ml-2" href="javascript:imprimirSeguimiento('.$registro2['seguimiento_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fa-solid fa-print fa-lg"></i> Imprimir</a>
				<a class="btn btn btn-secondary ml-2" href="javascript:editarSeguimiento('.$registro2['seguimiento_id'].','.$colaborador_id.','.$registro2['pacientes_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fa-solid fa-pen-to-square"></i></i> Editar</a> 
			</td>			
			</tr>';	
			$i++;				
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="4" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="4"><b><p ALIGN="center">Total de Registros Encontrados: '.$nroProductos.'</p></b>
   </tr>';		
}        

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN	
?>