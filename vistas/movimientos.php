<?php
session_start(); 
include "../php/funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

if( isset($_SESSION['colaborador_id']) == false ){
   header('Location: login.php'); 
}    

$_SESSION['menu'] = "Movimientos";

if(isset($_SESSION['colaborador_id'])){
 $colaborador_id = $_SESSION['colaborador_id'];  
}else{
   $colaborador_id = "";
}

$type = $_SESSION['type'];

$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);//HOSTNAME	
$fecha = date("Y-m-d H:i:s"); 
$comentario = mb_convert_case("Ingreso al Modulo de Movimientos de Productos", MB_CASE_TITLE, "UTF-8");   

if($colaborador_id != "" || $colaborador_id != null){
   historial_acceso($comentario, $nombre_host, $colaborador_id);  
}  

//OBTENER NOMBRE DE EMPRESA
$usuario = $_SESSION['colaborador_id'];

$query_empresa = "SELECT e.nombre AS 'nombre'
	FROM users AS u
	INNER JOIN empresa AS e
	ON u.empresa_id = e.empresa_id
	WHERE u.colaborador_id = '$usuario'";
$result = $mysqli->query($query_empresa) or die($mysqli->error);
$consulta_registro = $result->fetch_assoc();

$empresa = '';

if($result->num_rows>0){
  $empresa = $consulta_registro['nombre'];
}

$mysqli->close();//CERRAR CONEXIÓN     
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="author" content="Script Tutorials" />
    <meta name="description" content="Responsive Websites Orden Hospitalaria de San Juan de Dios">
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Movimientos :: <?php echo $empresa; ?></title>
	<?php include("script_css.php"); ?>	
</head>
<body>
   <!--Ventanas Modales-->
   <!-- Small modal -->  
  <?php include("templates/modals.php"); ?>    

<!--INICIO MODAL-->
   <?php include("modals/modals.php");?>
<!--FIN MODAL-->  	

   <!--Fin Ventanas Modales-->
	<!--MENU-->	  
       <?php include("templates/menu.php"); ?>
    <!--FIN MENU--> 
	
<br><br><br>
<div class="container-fluid">
	<ol class="breadcrumb mt-2 mb-4">
		<li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>vistas/inicio.php">Dashboard</a></li>
		<li class="breadcrumb-item active" id="acciones_factura"><span id="label_acciones_factura"></span>Movimientos</li>
	</ol>
	
    <form class="form-inline" id="form_main">
		  <div class="form-group mx-sm-3 mb-2">
			<label>Categoría</label>
			  <select id="categoria_id" name="categoria_id" class="custom-select ml-1" data-toggle="tooltip" data-placement="top" title="Categoría de Productos">
					<option value="">Seleccione</option>
			  </select>
		  </div>
		  <div class="form-group mx-sm-3 mb-2">
			<label>Fecha Inicio</label>
			<input type="date" required id="fechai" name="fechai" value="<?php echo date ("Y-m-d");?>" class="form-control ml-1" data-toggle="tooltip" data-placement="top" title="Fecha Inicio">
		  </div>	
		  <div class="form-group mx-sm-3 mb-2">
			<label>Fecha Fin</label>
			<input type="date" required id="fechaf" name="fechaf" value="<?php echo date ("Y-m-d");?>" class="form-control ml-1" data-toggle="tooltip" data-placement="top" title="Fecha Fin">
		  </div>
		  <button type="submit" class="btn btn-info mb-2 mr-1" data-toggle="tooltip" data-placement="top" title="Registrar Movimientos" id="registrar"><i class="fas fa-plus-circle fa-lg"></i> Crear</button>
		  <button type="submit" class="btn btn-primary mb-2 mr-1" data-toggle="tooltip" data-placement="top" title="Actualizar Movimientos" id="actualizar"><i class="fas fa-sync-alt fa-lg"></i> Actualizar</button>
		  <button type="submit" class="btn btn-success mb-2" data-toggle="tooltip" data-placement="top" title="Exportar" id="reporte"><i class="fas fa-download fa-lg"></i> Exportar</button>
	</form>
	<hr/> 
	<div class="table-responsive">
		<form id="formPrincipal">
			<div class="col-md-12 mb-3">
				<table id="dataTablaMovimientos" class="table table-striped table-condensed table-hover" style="width:100%">
					<thead>
						<tr>
							<th>Fecha</th>							
							<th>Producto</th>							
							<th>Concentración</th>
							<th>Medida</th>
							<th>Entrada</th>
							<th>Salida</th>
							<th>Saldo</th>							
						</tr>
					</thead>
				</table> 
			</div>
		<form>
	</div>
    <?php include("templates/footer.php"); ?> 	
</div>

    <!-- add javascripts -->
	<?php 
		include "script.php"; 
		
		include "../js/main.php"; 
		include "../js/myjava_movimientos.php"; 		
		include "../js/select.php"; 	
		include "../js/functions.php"; 
		include "../js/myjava_cambiar_pass.php"; 		
	?>	
 
</body>
</html>