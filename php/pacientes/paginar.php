<?php
session_start();   
include "../funtions.php";

header("Content-Type: text/html;charset=utf-8");

//CONEXION A DB
$mysqli = connect_mysqli();

$paginaActual = $_POST['partida'];
$estado = $_POST['estado'];
$paciente = $_POST['paciente'];
$dato = $_POST['dato'];
$type = $_SESSION['type'];
$colaborador_id = $_SESSION['colaborador_id'];

$query_row = "SELECT pacientes_id, CONCAT(nombre,' ',apellido) AS 'paciente', identidad, telefono1, telefono2, fecha_nacimiento, expediente AS 'expediente_', localidad,
(CASE WHEN estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado',
(CASE WHEN genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero',
(CASE WHEN expediente = '0' THEN 'TEMP' ELSE expediente END) AS 'expediente', email
FROM pacientes
WHERE estado = '$estado' AND (expediente LIKE '$dato%' OR nombre LIKE '$dato%' OR apellido LIKE '$dato%' OR CONCAT(apellido,' ',nombre) LIKE '%$dato%' OR CONCAT(nombre,' ',apellido) LIKE '%$dato%' OR telefono1 LIKE '$dato%' OR identidad LIKE '$dato%')
ORDER BY expediente";	

$result = $mysqli->query($query_row);     

$nroProductos=$result->num_rows; 
$nroLotes = 15;
$nroPaginas = ceil($nroProductos/$nroLotes);
$lista = '';
$tabla = '';

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.(1).');void(0);">Inicio</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual-1).');void(0);">Anterior '.($paginaActual-1).'</a></li>';
}

if($paginaActual < $nroPaginas){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($paginaActual+1).');void(0);">Siguiente '.($paginaActual+1).' de '.$nroPaginas.'</a></li>';
}

if($paginaActual > 1){
	$lista = $lista.'<li class="page-item"><a class="page-link" href="javascript:pagination('.($nroPaginas).');void(0);">Ultima</a></li>';
}

if($paginaActual <= 1){
	$limit = 0;
}else{
	$limit = $nroLotes*($paginaActual-1);
}

$query = "SELECT pacientes_id, CONCAT(nombre,' ',apellido) AS 'paciente', identidad, telefono1, telefono2, fecha, expediente AS 'expediente_', localidad,
(CASE WHEN estado = '1' THEN 'Activo' ELSE 'Inactivo' END) AS 'estado',
(CASE WHEN genero = 'H' THEN 'Hombre' ELSE 'Mujer' END) AS 'genero',
(CASE WHEN expediente = '0' THEN 'TEMP' ELSE expediente END) AS 'expediente', email
FROM pacientes
WHERE estado = '$estado' AND (expediente LIKE '$dato%' OR nombre LIKE '$dato%' OR apellido LIKE '$dato%' OR CONCAT(apellido,' ',nombre) LIKE '%$dato%' OR CONCAT(nombre,' ',apellido) LIKE '%$dato%' OR telefono1 LIKE '$dato%' OR identidad LIKE '$dato%')
ORDER BY expediente LIMIT $limit, $nroLotes
";
$result = $mysqli->query($query);    
  
$tabla = $tabla.'<table class="table table-striped table-condensed table-hover">
	<tr>
		<th width="1.11%">N°</th>
		<th width="7.11%">Identidad</th>
		<th width="18.11%">Paciente</th>
		<th width="4.11%">Genero</th>					   
		<th width="8.11%">Telefono1</th>
		<th width="8.11%">Telefono2</th>	
		<th width="11.11%">Correo</th>
		<th width="4.11%">Estado</th>						   
		<th width="38.11%">Opciones</th>
	</tr>';

$i=1;						
while($registro2 = $result->fetch_assoc()){
	if($type == 1 || $type == 2 || $type == 3 || $type == 5){
		$atencion = '<a class="btn btn btn-secondary ml-2" href="javascript:setAtencion('.$registro2['pacientes_id'].','.$colaborador_id.');void(0);"><div class="sb-nav-link-icon"></div><i class="fas fa-book-medical fa-lg"></i> Atención</a>';
	}else{
		$atencion = '';
	}


	$tabla = $tabla.'<tr>
	   <td>'.$i.'</td>
	   <td><a style="text-decoration:none" title = "Información de Usuario" href="javascript:showExpediente('.$registro2['pacientes_id'].');">'.$registro2['identidad'].'</a></td>
	   <td>'.$registro2['paciente'].'</td>
	   <td>'.$registro2['genero'].'</td>
	   <td>'.$registro2['telefono1'].'</td>
	   <td>'.$registro2['telefono2'].'</td>
	   <td>'.$registro2['email'].'</td>	   
	   <td>'.$registro2['estado'].'</td>   		   
	   <td>
	   		'.$atencion.'
	   		<a class="btn btn btn-secondary ml-2" href="javascript:modal_agregar_expediente_manual('.$registro2['pacientes_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fas fa-edit fa-lg"></i> Editar</a>
	   		<a class="btn btn btn-secondary ml-2" href="javascript:editarRegistro('.$registro2['pacientes_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fas fa-user-edit fa-lg"></i> Editar</a>	
	   		<a class="btn btn btn-secondary ml-2" href="javascript:modal_eliminar('.$registro2['pacientes_id'].');void(0);"><div class="sb-nav-link-icon"></div><i class="fas fa-trash fa-lg"></i> Eliminar</a>
	   </td>		              		  
	</tr>';
	$i++;
}

if($nroProductos == 0){
	$tabla = $tabla.'<tr>
	   <td colspan="11" style="color:#C7030D">No se encontraron resultados</td>
	</tr>';		
}else{
   $tabla = $tabla.'<tr>
	  <td colspan="11"><b><p ALIGN="center">Total de Registros Encontrados '.number_format($nroProductos).'</p></b>
   </tr>';		
}   

$tabla = $tabla.'</table>';

$array = array(0 => $tabla,
			   1 => $lista);

echo json_encode($array);
?>