<?php
session_start(); 
include "../php/funtions.php";

//CONEXION A DB
$mysqli = connect_mysqli();

if( isset($_SESSION['colaborador_id']) == false ){
   header('Location: login.php'); 
}    

$_SESSION['menu'] = "Agenda";

if(isset($_SESSION['colaborador_id'])){
 $colaborador_id = $_SESSION['colaborador_id'];  
}else{
   $colaborador_id = "";
}

$type = $_SESSION['type'];

$nombre_host = gethostbyaddr($_SERVER['REMOTE_ADDR']);//HOSTNAME	
$fecha = date("Y-m-d H:i:s"); 
$comentario = mb_convert_case("Ingreso al Modulo de Agenda", MB_CASE_TITLE, "UTF-8");   

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
    <title>Agenda :: <?php echo $empresa; ?></title>
	<?php include("script_css.php"); ?>		
</head>
<body>
   <!--Ventanas Modales-->
   <!-- Small modal -->
<!--INICIO VENTANA MODALES-->
<div class="modal fade" id="eliminar_cita">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Eliminar Cita</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">		
			<form class="FormularioAjax" id="form-eliminarcita" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">			
				<div class="form-row">
					<div class="col-md-12 mb-3">
					   <input type="hidden" id="agenda_id_cita" name="agenda_id_cita" class="form-control" id="id">	
					   <input type="hidden" id="pacientes_id" name="pacientes_id" class="form-control" id="id">	
					   <input type="hidden" name="expediente" id="expediente" class="form-control" id="expediente" placeholder="Expediente">	
						<div class="input-group mb-3">
							<input type="text" required readonly id="pro" name="pro" class="form-control"/>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square"></i></span>
							</div>
						</div>	 
					</div>							
				</div>
				<div class="form-row" id="grupo_expediente">
					<div class="col-md-12 mb-3">
					  <label for="expedoente">Nombre</label>
				     <input type="text" name="comentario" id="usuario" class="form-control" id="usuario" placeholder="Paciente" readonly="readonly">
					</div>			
				</div>									
				
				<div class="form-row">			  
					<div class="col-md-12 mb-3">
					  <label for="direccion">Comentario <span class="priority">*<span/></label>
					  <input type="text" name="comentario" id="comentario" class="form-control" id="contranaterior" placeholder="Comentario" required="required">
					</div>
				</div>						  
			</form>
        </div>
		<div class="modal-footer">
			<button class="btn btn-danger ml-2" type="submit" id="eliminar" form="form-eliminarcita"><div class="sb-nav-link-icon"></div><i class="fas fa-trash fa-lg"></i> Eliminar</button>			
		</div>		
      </div>
    </div>
</div>	

<div class="modal fade" id="registrar">
	<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Citas</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
        </div><div class="container"></div>
        <div class="modal-body">		
			<form class="FormularioAjax" id="formulario" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">			
				<div class="form-row">
					<div class="col-md-12 mb-3">
					   <input type="hidden" required="required" id="id-registro" name="id-registro"class="form-control"/>
					   <input type="hidden" required="required" id="agenda_id" name="agenda_id" class="form-control">              
					   <input type="hidden" required="required" id="pacientes_id_registro" name="pacientes_id_registro"class="form-control"/>
					   <input type="hidden" required="required" id="servicio_registro" name="servicio_registro" class="form-control"/>	
						<div class="input-group mb-3">
							<input type="text" required readonly id="pro" name="pro" class="form-control"/>
							<div class="input-group-append">				
								<span class="input-group-text"><div class="sb-nav-link-icon"></div><i class="fa fa-plus-square"></i></span>
							</div>
						</div>	 
					</div>							
				</div>
				<div class="form-row" id="grupo_expediente">
					<div class="col-md-4 mb-3">
					  <label for="expedoente">Expediente</label>
				      <input type="text" required="required" name="expediente" id="expediente"  readonly maxlength="100" class="form-control"/>
					</div>		
					<div class="col-md-8 mb-3">
					  <label for="expedoente">Nombre</label>
				      <input type="text" required="required" name="nombre" id="nombre"  readonly maxlength="100" class="form-control"/>
					</div>							
				</div>		
				<div class="form-row" id="grupo_expediente">
					<div class="col-md-4 mb-3">
					  <label for="expedoente">Fecha Anterior</label>
				      <input type="text" required="required" name="fecha_a" id="fecha_a"  readonly value="<?php echo date ("Y-m-d");?>" maxlength="100" class="form-control"/>
					</div>		
					<div class="col-md-4 mb-3">
					  <label for="expedoente">Nueva Fecha</label>
				      <input type="date" required="required" name="fecha_n" id="fecha_n" value="<?php echo date ("Y-m-d");?>" maxlength="100" class="form-control"/>
					</div>		
					<div class="col-md-4 mb-3">
					  <label for="expedoente">Hora</label>
				      <select id="hora_nueva" name="hora_nueva" class="form-control" data-toggle="tooltip" data-placement="top" ="Nueva Hora" required="required">
				      </select>
					</div>							
				</div>	
				<div class="form-row">
					<div class="col-md-4 mb-3">
					  <label for="expedoente">Estado <span class="priority">*<span/></label>
					  <select id="status_repro" name="status_repro" class="form-control" data-toggle="tooltip" data-placement="top" title="Estatus Reprogramación" required>
					  </select>	
					</div>									
				</div>	
				<div class="form-row" id="grupo_expediente">
					<div class="col-md-12 mb-3">
					  <label for="expedoente">Observacion</label>
					  <textarea name="observacion" id="observacion" class="form-control" required="required"></textarea>
					</div>									
				</div>					
				
				<div class="form-row">			  
					<div class="col-md-12 mb-3">
					  <label for="direccion">Comentario</label>
					  <textarea name="comentario" id="comentario" class="form-control"></textarea>
					</div>
				</div>

				<div class="form-check-inline">
				  <label for="fecha">Comentario</label>
				  <div class="col-md-6 mb-3">
					  <input class="form-check-input" type="checkbox" name="respuesta" id="checkeliminar" value="1">
					  <label class="form-check-label" for="exampleRadios1">Sí</label>				  
				  </div>				  
				</div>				  
			</form>
        </div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" type="submit" id="edi" form="formulario"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>	
			<button class="btn btn-success ml-2" type="submit" id="edi1" form="formulario"><div class="sb-nav-link-icon"></div><i class="fas fa-comments fa-lg"></i> Comentario</button>				
		</div>			
      </div>
    </div>
</div>
<!--FIN VENTANA MODALES-->

<?php include("templates/menu.php"); ?>
<?php include("templates/modals.php"); ?> 

<br><br><br>
<div class="container-fluid">
	<ol class="breadcrumb mt-2 mb-4">
		<li class="breadcrumb-item"><a class="breadcrumb-link" href="<?php echo SERVERURL; ?>vistas/inicio.php">Dashboard</a></li>
		<li class="breadcrumb-item active" id="acciones_factura"><span id="label_acciones_factura"></span>Agenda</li>
	</ol>

    <form class="form-inline" id="form_agenda_main">
      <div class="form-group mr-1">
		<div class="input-group">				
			<div class="input-group-append">				
				<span class="input-group-text"><div class="sb-nav-link-icon"></div>Estado</span>
			</div>
		    <select id="atencion" name="atencion" class="form-control" data-toggle="tooltip" data-placement="top" title="Atención"> 
		    </select> 
		</div>
      </div>	
	  <div class="form-group mr-1">
		<div class="input-group">				
			<div class="input-group-append">				
				<span class="input-group-text"><div class="sb-nav-link-icon"></div>Consultorio</span>
			</div>
		   <select id="servicio" name="servicio" class="form-control" style="width:160px;" data-toggle="tooltip" data-placement="top" title="Consultorio"> 				   
		   </select> 
		</div>	 	   
      </div>
	  <div class="form-group mr-1">
		<div class="input-group">				
			<div class="input-group-append">				
				<span class="input-group-text"><div class="sb-nav-link-icon"></div>Profesional</span>
			</div>
		   <select id="medico_general" name="medico_general" style="width:160px;" class="form-control" data-toggle="tooltip" data-placement="top" title="Profesional"> 
		   </select>  
		</div>  
      </div>	
	  <div class="form-group mr-1">
		<div class="input-group">				
			<div class="input-group-append">				
				<span class="input-group-text"><div class="sb-nav-link-icon"></div>Inicio</span>
			</div>
		   <input type="date" required="required" id="fecha" name="fecha" style="width:160px;" value="<?php echo date ("Y-m-d");?>" data-toggle="tooltip" data-placement="top" title="Fecha Inicial" class="form-control"/>  
		</div>  
      </div>	
	  <div class="form-group mr-1">
		<div class="input-group">				
			<div class="input-group-append">				
				<span class="input-group-text"><div class="sb-nav-link-icon"></div>Fin</span>
			</div>
			<input type="date" required="required" id="fechaf" name="fechaf" style="width:160px;" value="<?php echo date ("Y-m-d");?>" data-toggle="tooltip" data-placement="top" title="Fecha Inicial" class="form-control"/>  
		</div>
      </div>		  
      <div class="form-group mr-1">
         <input type="text" placeholder="Buscar Registros" id="bs-regis" data-toggle="tooltip" data-placement="top" title="Buscar por: Expediente, Nombre o Identidad" autofocus class="form-control" size="25"/>
      </div>	  
	  <div class="form-group">
		<div class="dropdown show" data-toggle="tooltip" data-placement="top" title="Exportar">
		  <a class="btn btn-success dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			 <i class="fas fa-download fa-lg"></i> Exportar
		  </a>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
			<a class="dropdown-item" href="#" id="send_sms">Enviar SMS</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#" id="reporte">Reporte</a>
			<a class="dropdown-item" href="#" id="Reporte_Agenda">Reporte Agenda</a>	
			<a class="dropdown-item" href="#" id="agenda_usuarios">Agenda</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#" id="limpiar">Limpiar</a>			
		  </div>
		</div>		  
	  </div>	 	   
    </form>	
	<hr/> 
	<div class="form-group">
	  <div class="col-md-12 mb-3 overflow-auto">
		 <div class="registros" id="agrega-registros"></div>
	  </div>		   
	</div>	
    <center>
		<nav aria-label="Page navigation example">
			<ul class="pagination justify-content-center" id="pagination"></ul>
		</nav>
    </center>
	<?php include("templates/footer.php"); ?>
</div>	  

    <!-- add javascripts -->
	<?php 
		include "script.php"; 
		
		include "../js/main.php"; 
		include "../js/myjava_agenda_pacientes.php"; 
		include "../js/sms.php"; 		
		include "../js/select.php"; 	
		include "../js/functions.php"; 
		include "../js/myjava_cambiar_pass.php"; 		
	?>
		
</body>
</html>