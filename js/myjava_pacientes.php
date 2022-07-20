<script>
$(document).ready(function(){
	getSexo();
	pagination(1);
	getStatus();
	getDepartamentos();
	getPais();
	getResponsable();
	getProfesion();
	getAseguradoras();
	getCiclosMenstruales();
	getDismenorrea();	
	
	$('#form_main #nuevo-registro').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){
			$('#formulario_pacientes #reg').show();
			$('#formulario_pacientes #edi').hide();
			cleanPacientes();
			$('#formulario_pacientes #grupo_expediente').hide();
			$('#formulario_pacientes')[0].reset();	
			$('#formulario_pacientes #pro').val('Registro');
			$("#formulario_pacientes #fecha").attr('readonly', false);
			$("#formulario_pacientes #pais_id").val(1);
			$('#formulario_pacientes #validate').removeClass('bien_email');
			$('#formulario_pacientes #validate').removeClass('error_email');
			$("#formulario_pacientes #correo").css("border-color", "none");
			$('#formulario_pacientes #validate').html('');	
			$('#formulario_pacientes #identidad').attr('readonly', false);		
			$('#formulario_pacientes').attr({ 'data-form': 'save' }); 
			$('#formulario_pacientes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregarPacientes.php' });	
			$('#modal_pacientes').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			return false;
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});					 
		}	
	});	

	$('#form_main #profesion').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){
			$('#formulario_profesiones #reg').show();
			$('#formulario_profesiones #edi').hide();		 	 
			$('#formulario_profesiones')[0].reset();	
			$('#formulario_profesiones #proceso').val('Registro');
			paginationPorfesionales(1);
			$('#formulario_profesiones').attr({ 'data-form': 'save' }); 
			$('#formulario_profesiones').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/agregar_profesional.php' });				
			 $('#modal_profesiones').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			return false;
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});					 
		}	
	});	

	$('#form_main #bs_regis').on('keyup',function(){
	  pagination(1);
	});
	
	$('#formulario_profesiones #profesionales_buscar').on('keyup',function(){
	  paginationPorfesionales(1);
	});	

	$('#form_main #estado').on('change',function(){
	  pagination(1);
	});
	
	$('#formulario_agregar_expediente_manual #identidad_ususario_manual').on('keyup',function(){
		busquedaUsuarioManualIdentidad();
    });	

	$('#formulario_agregar_expediente_manual #expediente_usuario_manual').on('keyup',function(){
		busquedaUsuarioManualExpediente();
    });		
});

$('#formulario_pacientes .switch').change(function(){    
	if($('input[name=asegurado_activo]').is(':checked')){
		$('#formulario_pacientes #seguros').show();			
		return true;
	}
	else{
		$('#formulario_pacientes #seguros').hide();
		return false;
	}
});	

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#modal_pacientes").on('shown.bs.modal', function(){
        $(this).find('#formulario_pacientes #name').focus();
    });
});

$(document).ready(function(){
    $("#modal_profesiones").on('shown.bs.modal', function(){
        $(this).find('#formulario_profesiones #profesionales_buscar').focus();
    });
});

$(document).ready(function(){
    $("#agregar_expediente_manual").on('shown.bs.modal', function(){
        $(this).find('#formulario_agregar_expediente_manual #identidad_ususario_manual').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_profesion").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_profesion #buscar').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_departamentos").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_departamentos #buscar').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_pais").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_pais #buscar').focus();
    });
});

$(document).ready(function(){
    $("#modal_busqueda_municipios").on('shown.bs.modal', function(){
        $(this).find('#formulario_busqueda_municipios #buscar').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

$('#reg_manual').on('click', function(e){ // delete event clicked // We don't want this to act as a link so cancel the link action
   e.preventDefault();
   if ($('#formulario_agregar_expediente_manual #expediente_usuario_manual').val()!="" || $('#formulario_agregar_expediente_manual #identidad_ususario_manual').val() !=""){		 
	  registrarExpedienteManual();	   	  	   
   }else{
		swal({
			title: "Error", 
			text: "Hay registros en blanco, por favor corregir",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});			   
	   return false;
   }	   
});

$('#convertir_manual').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	 e.preventDefault();
	 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){
	     convertirExpedientetoTemporal(); 
	 }else{
		  swal({
				title: 'Acceso Denegado', 
				text: 'No tiene permisos para ejecutar esta acción',
				type: 'error', 
				confirmButtonClass: 'btn-danger'
		  });		 
	}
});

$('#form_main #reporte').on('click', function(e){
    e.preventDefault();
    reporteEXCEL()();
});

function reporteEXCEL(){
 if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){	
	var estado = "";
	var dato = $('#form_main #bs_regis').val();
	
	if ($('#estado').val() == ""){
		estado = 1;
	}else{
		estado = $('#estado').val();
	}
	
	var url = '<?php echo SERVERURL; ?>php/pacientes/reportePacientes.php?dato='+dato+'&estado='+estado;
    window.open(url);
}else{
	swal({
		title: "Acceso Denegado", 
		text: "No tiene permisos para ejecutar esta acción",
		type: "error", 
		confirmButtonClass: 'btn-danger'
	});						
	return false;	  
  }	
}

function getStatus(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getStatus.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#form_main #estado').html("");
			$('#form_main #estado').html(data);
		}			
     });		
}

function showExpediente(pacientes_id){
	var url = '<?php echo SERVERURL; ?>php/pacientes/getExpediente.php';

	$.ajax({
		type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		success:function(data){
			if(data == 1){	
				swal({
					title: "Error", 
					text: "Por favor intentelo de nuevo más tarde",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});				   
			}else{				
  	           $('#mensaje_show').modal({
				show:true,
				keyboard: false,
				backdrop:'static'  
     	       });	
               $('#mensaje_mensaje_show').html(data);
	           $('#bad').hide();
	           $('#okay').show();				
			}
		}
	});	
}

function modal_eliminarProfesional(profesional_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2){
		swal({
		  title: "¿Estas seguro?",
		  text: "¿Desea eliminar este registro?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-warning",
		  confirmButtonText: "¡Sí, eliminar el registro!",
		  cancelButtonText: "Cancelar",	  
		  closeOnConfirm: false
		},
		function(){
			eliminarProfesional(profesional_id);
		});		
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});				 
	}	
}

function modal_eliminar(pacientes_id){
  if (consultarExpediente(pacientes_id) != 0 && (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6)){
    var nombre_usuario = consultarNombre(pacientes_id);
    var expediente_usuario = consultarExpediente(pacientes_id);
    var dato;

    if(expediente_usuario == 0){
		dato = nombre_usuario;
	}else{
		dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
	}
	
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea eliminar este registro: " + dato + "?",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-warning",
	  confirmButtonText: "¡Sí, eliminar el registro!",
	  cancelButtonText: "Cancelar",
	  closeOnConfirm: false
	},
	function(){
		eliminarRegistro(pacientes_id);
	});
  }else if (consultarExpediente(pacientes_id) == 0 && (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6)){
    var nombre_usuario = consultarNombre(pacientes_id);
    var expediente_usuario = consultarExpediente(pacientes_id);
    var dato;

    if(expediente_usuario == 0){
		dato = nombre_usuario;
	}else{
		dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
	}
	
	swal({
	  title: "¿Estas seguro?",
	  text: "¿Desea eliminar este registro: " + dato + "?",
	  type: "warning",
	  showCancelButton: true,
	  confirmButtonClass: "btn-warning",
	  confirmButtonText: "¡Sí, eliminar el registro!",
	  cancelButtonText: "Cancelar",	  
	  closeOnConfirm: false
	},
	function(){
		eliminarRegistro(pacientes_id);
	});
  }else{
	  swal({
			title: 'Acceso Denegado', 
			text: 'No tiene permisos para ejecutar esta acción',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
	  });				
	 return false;	  
  }
}

function cleanPacientes(){
	$('#formulario_pacientes #validate').removeClass('bien_email');	
	$('#formulario_pacientes #validate').removeClass('error_email');
	$('#formulario_pacientes #validate').html('');	
	$("#formulario #correo").css("border-color", "none");	
}

function editarRegistro(pacientes_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){
		var url = '<?php echo SERVERURL; ?>php/pacientes/editar.php';
		   $.ajax({
			   type:'POST',
			   url:url,
			   data:'pacientes_id='+pacientes_id,
			   success: function(valores){
					var datos = eval(valores);
					$('#formulario_pacientes #reg').hide();
					$('#formulario_pacientes #edi').show();	
					$('#formulario_pacientes #pro').val('Edición');
					$('#formulario_pacientes #grupo_expediente').show();
					$('#formulario_pacientes #pacientes_id').val(pacientes_id);					
					$('#formulario_pacientes #name').val(datos[0]);				
					$('#formulario_pacientes #lastname').val(datos[1]);	
					$('#formulario_pacientes #telefono1').val(datos[2]);	
					$('#formulario_pacientes #telefono2').val(datos[3]);
					$('#formulario_pacientes #sexo').val(datos[4]);					
					$('#formulario_pacientes #correo').val(datos[5]);
					$('#formulario_pacientes #edad').val(datos[6]);	
					$('#formulario_pacientes #expediente').val(datos[7]);
					$('#formulario_pacientes #direccion').val(datos[8]);					
					$('#formulario_pacientes #fecha_nac').val(datos[9]);
					$('#formulario_pacientes #departamento_id').val(datos[10]);
					getMunicipioEditar(datos[10], datos[11]);
					$('#formulario_pacientes #pais_id').val(datos[12]);
					$('#formulario_pacientes #responsable').val(datos[13]);
					$('#formulario_pacientes #responsable_id').val(datos[14]);
					$('#formulario_pacientes #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes #identidad').val(datos[16]);
					$('#formulario_pacientes #identidad').attr('readonly', true);
					$("#formulario_pacientes #fecha").attr('readonly', true);
					$("#formulario_pacientes #expediente").attr('readonly', true);
					$('#formulario_pacientes #validate').removeClass('bien_email');
					$('#formulario_pacientes #validate').removeClass('error_email');
					$("#formulario_pacientes #correo").css("border-color", "none");
					$('#formulario_pacientes #validate').html('');
					
					cleanPacientes();
					$('#formulario_pacientes').attr({ 'data-form': 'update' }); 
					$('#formulario_pacientes').attr({ 'action': '<?php echo SERVERURL; ?>php/pacientes/editarPacientes.php' });						
					$('#modal_pacientes').modal({
						show:true,
						keyboard: false,
						backdrop:'static'
					});
			   return false;
			}
		});	
	}else{
		swal({
			title: 'Acceso Denegado', 
			text: 'No tiene permisos para ejecutar esta acción',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
		});				
		return false;			
	}
}

function eliminarProfesional(id){	
	var url = '<?php echo SERVERURL; ?>php/pacientes/eliminar_profesional.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(registro){
			if(registro == 1){
				swal({
					title: "Success", 
					text: "Registro eliminado correctamente",
					type: "success",
					timer: 3000, //timeOut for auto-clos
				});	
				paginationPorfesionales(1);
				$('#modal_profesiones').modal('hide');
			   return false;				
			}else if(registro == 2){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		
	           return false;				
			}else if(registro == 3){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro, cuenta con información almacenada",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		
	           return false;				
			}else{
				swal({
					title: "Error", 
					text: "Error al completar el registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});				   
	           return false;				
			}
  		}
	}); 
	return false;
}

function eliminarRegistro(pacientes_id){	
	var url = '<?php echo SERVERURL; ?>php/pacientes/eliminar.php';
	$.ajax({
		type:'POST',
		url:url,
		data:'id='+pacientes_id,
		success: function(registro){
			if(registro == 1){
				swal({
					title: "Success", 
					text: "Registro eliminado correctamente",
					type: "success",
					timer: 3000, //timeOut for auto-clos
				});	
				pagination(1);
			   return false;				
			}else if(registro == 2){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		
	           return false;				
			}else if(registro == 3){	
				swal({
					title: "Error", 
					text: "No se puede eliminar este registro, cuenta con información almacenada",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		
	           return false;				
			}else{
				swal({
					title: "Error", 
					text: "Error al completar el registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});				   
	           return false;				
			}
  		}
	}); 
	return false;
}

function convertirExpedientetoTemporal(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/convertirExpedienteTemporal.php';		
    var pacientes_id = $('#formulario_agregar_expediente_manual #pacientes_id').val();	
	
	$.ajax({
        type: "POST",
        url: url,
	    data:'pacientes_id='+pacientes_id,		
	    async: true,
        success: function(data){	
            if(data == 1){
				swal({
					title: "Usuario convertido", 
					text: "El usuario se ha convertido a temporal",
					type: "success", 
					timer: 3000, //timeOut for auto-close
				});	
				$('#agregar_expediente_manual').modal('hide');
			    $('#formulario_agregar_expediente_manual #expediente_manual').val('TEMP');
			    $('#formulario_agregar_expediente_manual #temporal').hide();
			    $('#convertir_manual').hide();
			    $('#reg_manual').show();
                pagination(1);			   
	            return false;				
			}else{
				swal({
					title: "Error", 
					text: "No se puede procesar su solicitud",
					type: "error", 
					confirmButtonClass: "btn-danger"
				});
                return false;			   
			}
		}			
     });	
}

function registrarExpedienteManual(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/agregarExpedienteManual.php';

	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_agregar_expediente_manual').serialize(),
		success: function(registro){
		   if(registro==1){
			   $('#formulario_agregar_expediente_manual #pro_manual').val('Registro');
				swal({
					title: "Success", 
					text: "Registro completado correctamente",
					type: "success",
					timer: 3000, //timeOut for auto-clos
				});	
				$('#agregar_expediente_manual').modal('hide');
				pagination(1);
		   }else if(registro==2){
				swal({
					title: "Error", 
					text: "No se pudo guardar el registro, por favor verifique la información",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});
		   }else if(registro==3){
				swal({
					title: "Error", 
					text: "Error al ejecutar esta acción",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		   
		   }else if(registro==4){
				swal({
					title: "Error", 
					text: "Error en los datos",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});		   
		   }else{
				swal({
					title: "Error", 
					text: "Error al guardar el registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});			   
		   }
		}
	   });
	  return false;	
}

function busquedaUsuarioManualIdentidad(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarIdentidad.php';
       		
	var identidad = $('#formulario_agregar_expediente_manual #identidad_ususario_manual').val();
	
   $.ajax({
	  type:'POST',
	  url:url,
	  data:'identidad='+identidad,
	  success:function(data){
		 if(data == 1){	
			swal({
				title: "Error", 
				text: "Este numero de Identidad ya existe, por favor corriga el numero e intente nuevamente",
				type: "error", 
				confirmButtonClass: "btn-danger"
			});					 
			 $("#formulario_agregar_expediente_manual #reg").attr('disabled', true);
			 return false;
		 }else{		  
			 $("#formulario_agregar_expediente_manual #reg").attr('disabled', false); 
		}	  
	}
   });			
}

function busquedaUsuarioManualExpediente(){
	var url = '<?php echo SERVERURL; ?>php/pacientes/consultarExpediente.php';
       		
	var expediente = $('#formulario_agregar_expediente_manual #expediente_usuario_manual').val();
	
   $.ajax({
	  type:'POST',
	  url:url,
	  data:'expediente='+expediente,
	  success:function(data){
		 if(data == 1){
			swal({
				title: "Error", 
				text: "Este numero de Expediente ya existe, por favor corriga el numero e intente nuevamente",
				type: "error", 
				confirmButtonClass: "btn-danger"
			});				  
			$("#formulario_agregar_expediente_manual #reg").attr('disabled', true);
			return false;
		 }else{ 			  
			$("#formulario_agregar_expediente_manual #reg").attr('disabled', false); 
		}	  
	  }
   });		
}

function consultarExpediente(pacientes_id){	
    var url = '<?php echo SERVERURL; ?>php/pacientes/getExpedienteInformacion.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp;		
}

function consultarNombre(pacientes_id){	
    var url = '<?php echo SERVERURL; ?>php/pacientes/getNombre.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp;	
}

function modal_agregar_expediente_manual(id, expediente){
   if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 5 || getUsuarioSistema() == 6){	
	  $('#formulario_agregar_expediente_manual')[0].reset();
	  var url = '<?php echo SERVERURL; ?>php/pacientes/buscarUsuario.php';
		$.ajax({
		type:'POST',
		url:url,
		data:'id='+id,
		success: function(valores){
			var datos = eval(valores);
			if(expediente == 0){
				$("#formulario_agregar_expediente_manual #temporal").hide();
			}else{
				$("#formulario_agregar_expediente_manual #temporal").show();						
			}
			$("#formulario_agregar_expediente_manual #pacientes_id").val(id);
			$("#formulario_agregar_expediente_manual #expediente").val(expediente);
			$("#formulario_agregar_expediente_manual #name_manual").val(datos[0]);
			$("#formulario_agregar_expediente_manual #identidad_manual").val(datos[1]);
			$('#formulario_agregar_expediente_manual #sexo_manual').val(datos[2]);
			$("#formulario_agregar_expediente_manual #fecha_manual").val(datos[3]);
			$("#formulario_agregar_expediente_manual #edad_manual").val(datos[6]);
			$("#formulario_agregar_expediente_manual #expediente_manual").val(datos[5]);
			$("#formulario_agregar_expediente_manual #edad_manual").show();
			$('#formulario_agregar_expediente_manual #pro').val('Registrar');
			$("#reg_manual").show();
			$("#convertir_manual").hide();
			$('#agregar_expediente_manual').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			return false;
		}
		});
	return false;
	}else{	 
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});	
	}
 }

function paginationPorfesionales(partida){
	var url = '<?php echo SERVERURL; ?>php/pacientes/paginarProfesionales.php';
	var profesional = $('#formulario_profesiones #profesionales_buscar').val();
		
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&profesional='+profesional,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_profesionales').html(array[0]);
			$('#pagination_profesionales').html(array[1]);
		}
	});
	return false;
}

function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/pacientes/paginar.php';
	var estado = "";
	var paciente = "";
	var dato = $('#form_main #bs_regis').val();
	
	if ($('#form_main #estado').val() == "" || $('#form_main #estado').val() == null){
		estado = 1;
	}else{
		estado = $('#form_main #estado').val();
	}
	
	if ($('#form_main #tipo').val() == "" || $('#form_main #tipo').val() == null){
		paciente = 1;
	}else{
		paciente = $('#form_main #tipo').val();
	}	
	
	$.ajax({
		type:'POST',
		url:url,
		data:'partida='+partida+'&estado='+estado+'&dato='+dato+'&paciente='+paciente,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}

function getSexo(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getSexo.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #sexo').html("");
			$('#formulario_pacientes #sexo').html(data);

		    $('#formulario_agregar_expediente_manual #sexo_manual').html("");
			$('#formulario_agregar_expediente_manual #sexo_manual').html(data);	

		    $('#formulario_pacientes_atenciones #sexo').html("");
			$('#formulario_pacientes_atenciones #sexo').html(data);				
		}			
     });		
}

/*INICIO AUTO COMPLETAR*/
/*INICIO SUGGESTION NOMBRE*/
$(document).ready(function() {
   $('#formulario #name').on('keyup', function() {
	   if($('#formulario #name').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_name').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #name').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_name').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_name').fadeIn(1000).html("");
		   $('#formulario #suggestions_name').fadeOut(1000);
	   }
     });		
});

//OCULTAR EL SUGGESTION
$(document).ready(function() {
   $('#formulario #name').on('blur', function() {
	   $('#formulario #suggestions_name').fadeOut(1000);
   });		
});  

$(document).ready(function() {
   $('#formulario #name').on('click', function() {
	   if($('#formulario #name').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_name').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #name').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_name').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_name').fadeIn(1000).html("");
		   $('#formulario #suggestions_name').fadeOut(1000);
	   }
     });		
}); 
/*FIN SUGGESTION NOMBRE*/

/*INICIO SUGGESTION APELLIDO*/
$(document).ready(function() {
   $('#formulario #lastname').on('keyup', function() {
	   if($('#formulario #lastname').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_apellido').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #lastname').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_apellido').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_apellido').fadeIn(1000).html("");
		   $('#formulario #suggestions_apellido').fadeOut(1000);
	   }
     });		
});

//OCULTAR EL SUGGESTION
$(document).ready(function() {
   $('#formulario #lastname').on('blur', function() {
	   $('#formulario #suggestions_apellido').fadeOut(1000);
   });		
});  

$(document).ready(function() {
   $('#formulario #lastname').on('cli', function() {
	   if($('#formulario #lastname').val() != ""){
		     var key = $(this).val();		
             var dataString = 'key='+key;
		     var url = '<?php echo SERVERURL; ?>php/pacientes/autocompletarNombre.php';
	
	        $.ajax({
               type: "POST",
               url: url,
               data: dataString,
               success: function(data) {
                  //Escribimos las sugerencias que nos manda la consulta
                  $('#formulario #suggestions_apellido').fadeIn(1000).html(data);
                  //Al hacer click en algua de las sugerencias
                  $('.suggest-element').on('click', function(){
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('#formulario #lastname').val($('#'+id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#formulario #suggestions_apellido').fadeOut(1000);
                        return false;
                 });
              }
           });   
	   }else{
		   $('#formulario#suggestions_apellido').fadeIn(1000).html("");
		   $('#formulario #suggestions_apellido').fadeOut(1000);
	   }
     });		
});
/*FIN SUGGESTION APELLIDO*/
/*FIN AUTO COMPLETAR*/

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

//SÍ
$(document).ready(function() {
	$('#formulario_agregar_expediente_manual #respuestasi').on('click', function(){
        $("#convertir_manual").show();
		$("#reg_manual").hide();
    });					
});

//NO
$(document).ready(function() {
	$('#formulario_agregar_expediente_manual #respuestano').on('click', function(){
		$("#convertir_manual").hide();
		$("#reg_manual").show();		
    });					
});

$('#form_main #limpiar').on('click', function(e){
    e.preventDefault();
	$('#form_main #bs_regis').val("");
	$('#form_main #bs_regis').focus();	
	getSexo();
	pagination(1);
	getStatus();
});

function getResponsable(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getResponsable.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #responsable_id').html("");
			$('#formulario_pacientes #responsable_id').html(data);
			
		    $('#formulario_pacientes_atenciones #responsable_id').html("");
			$('#formulario_pacientes_atenciones #responsable_id').html(data);			
		}			
     });		
}

function getDepartamentos(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getDepartamentos.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #departamento_id').html("");
			$('#formulario_pacientes #departamento_id').html(data);
			
		    $('#formulario_pacientes_atenciones #departamento_id').html("");
			$('#formulario_pacientes_atenciones #departamento_id').html(data);			
		}			
     });		
}

function getMunicipio(){
	var url = '../php/pacientes/getMunicipio.php';
		
	var departamento_id = $('#formulario_pacientes #departamento_id').val();
	
	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamento_id='+departamento_id,
	   success:function(data){
		  $('#formulario_pacientes #municipio_id').html("");
		  $('#formulario_pacientes #municipio_id').html(data);

		  $('#formulario_pacientes_atenciones #municipio_id').html("");
		  $('#formulario_pacientes_atenciones #municipio_id').html(data);		  
	  }
  });	
}

$(document).ready(function() {
	$('#formulario_pacientes #departamento_id').on('change', function(){
		var url = '../php/pacientes/getMunicipio.php';
       		
		var departamento_id = $('#formulario_pacientes #departamento_id').val();
		
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamento_id='+departamento_id,
		   success:function(data){
		      $('#formulario_pacientes #municipio_id').html("");
			  $('#formulario_pacientes #municipio_id').html(data);		  
		  }
	  });
	  return false;			 				
    });					
});

$(document).ready(function() {
	$('#formulario_pacientes_atenciones #departamento_id').on('change', function(){
		var url = '../php/pacientes/getMunicipio.php';
       		
		var departamento_id = $('#formulario_pacientes_atenciones #departamento_id').val();
		
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'departamento_id='+departamento_id,
		   success:function(data){
		      $('#formulario_pacientes_atenciones #municipio_id').html("");
			  $('#formulario_pacientes_atenciones #municipio_id').html(data);		  
		  }
	  });
	  return false;			 				
    });					
});

function getMunicipioEditar(departamento_id, municipio_id){
	var url = '../php/pacientes/getMunicipio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   data:'departamento_id='+departamento_id,
	   success:function(data){
	      $('#formulario_pacientes #municipio_id').html("");
		  $('#formulario_pacientes #municipio_id').html(data);
		  $('#formulario_pacientes #municipio_id').val(municipio_id);		  
		  
	      $('#formulario_pacientes_atenciones #municipio_id').html("");
		  $('#formulario_pacientes_atenciones #municipio_id').html(data);
		  $('#formulario_pacientes_atenciones #municipio_id').val(municipio_id);		  
	  }
	});
	return false;		
}

function getPais(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getPais.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes #pais_id').html("");
			$('#formulario_pacientes #pais_id').html(data);
			
		    $('#formulario_pacientes_atenciones #pais_id').html("");
			$('#formulario_pacientes_atenciones #pais_id').html(data);			
		}			
     });		
}

$('#formulario_pacientes #buscar_pais_pacientes').on('click', function(e){
	listar_pais_buscar(); 
	$('#modal_busqueda_pais').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes #buscar_departamento_pacientes').on('click', function(e){
	listar_departamentos_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes #buscar_municipio_pacientes').on('click', function(e){
	if($('#formulario_pacientes #departamento_id').val() == "" || $('#formulario_pacientes #departamento_id').val() == null){
		swal({
			title: "Error", 
			text: "Lo sentimos el departamento no debe estar vacío, antes de seleccionar esta opción por favor seleccione un departamento, por favor corregir",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});			
	}else{
		listar_municipios_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_pais_buscar = function(){
	var table_pais_buscar = $("#dataTablePais").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getPaisTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pais_buscar.search('').draw();
	$('#buscar').focus();
	
	view_pais_busqueda_dataTable("#dataTablePais tbody", table_pais_buscar);
}

var view_pais_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #pais_id').val(data.pais_id);
		$('#modal_busqueda_pais').modal('hide');
	});
}

var listar_departamentos_buscar = function(){
	var table_departamentos_buscar = $("#dataTableDepartamentos").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getDepartamentosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_departamentos_buscar.search('').draw();
	$('#buscar').focus();
	
	view_departamentos_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #departamento_id').val(data.departamento_id);
		getMunicipio();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}

var listar_municipios_buscar = function(){
	var departamento = $('#formulario_pacientes #departamento_id').val();
	var table_municipios_buscar = $("#dataTableMunicipios").DataTable({
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getMunicipiosTabla.php",
			"data":{ 'departamento' : departamento },
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"municipio"},
			{"data":"departamento"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_municipios_buscar.search('').draw();
	$('#buscar').focus();
	
	view_municipios_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}

function getProfesion(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getProfesion.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){

		    $('#formulario_pacientes #profesion_pacientes').html("");
			$('#formulario_pacientes #profesion_pacientes').html(data);	
			
		    $('#formulario_pacientes_atenciones #profesion_pacientes').html("");
			$('#formulario_pacientes_atenciones #profesion_pacientes').html(data);			
        }
     });	
}

function getAseguradoras(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getAseguradoras.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){

		    $('#formulario_pacientes #seguros_pacientes').html("");
			$('#formulario_pacientes #seguros_pacientes').html(data);	
        }
     });	
}

$('#formulario_pacientes #buscar_profesion_pacientes').on('click', function(e){
	listar_profesion_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_buscar = function(){
	var table_profeision_buscar = $("#dataTableProfesiones").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/pacientes/getProfesionTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_profeision_buscar.search('').draw();
	$('#buscar').focus();
	
	view_profesion_busqueda_dataTable("#dataTableProfesiones tbody", table_profeision_buscar);
}

var view_profesion_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}

	
//INICIO BOTONES DE ESTADO
$('#formulario_pacientes #label_asegurado_activo').html("No");

$('#formulario_pacientes .switch').change(function(){    
	if($('input[name=asegurado_activo]').is(':checked')){
		$('#formulario_pacientes #label_asegurado_activo').html("Sí");
		return true;
	}
	else{
		$('#formulario_pacientes #label_asegurado_activo').html("No");
		return false;
	}
});
//FIN BOTONES DE ESTADO	

$('#formulario_pacientes #buscar_seguros_pacientes').on('click', function(e){
	listar_aseguradoras_buscar();
		$('#modal_busqueda_aseguradoras').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		
});

var listar_aseguradoras_buscar = function(){
	var table_aseguradoras_buscar = $("#dataTableAseguradoras").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/pacientes/getAseguradorasTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_aseguradoras_buscar.search('').draw();
	$('#buscar').focus();
	
	view_aseguradoras_busqueda_dataTable("#dataTableAseguradoras tbody", table_aseguradoras_buscar);
}

var view_aseguradoras_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes #seguros_pacientes').val(data.aseguradoras_id);
		$('#modal_busqueda_aseguradoras').modal('hide');
	});
}

//INICIO ATENCIONES Medicas
function setAtencion(pacientes_id, agenda_id){
	$('#main_facturacion').hide();
	$('#main_atencion').show();
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){
		var url = '<?php echo SERVERURL; ?>php/pacientes/editar.php';
		   $.ajax({
			   type:'POST',
			   url:url,
			   data:'pacientes_id='+pacientes_id,
			   success: function(valores){
					var datos = eval(valores);
					$('#regPacientes').hide();
					$('#ediPacientes').show();	
					$('#formulario_pacientes_atenciones #pro').val('Edición');
					$('#formulario_pacientes_atenciones #grupo_expediente').show();
					$('#formulario_primera_consulta #pacientes_id').val(pacientes_id);
					$('#formulario_seguimiento #pacientes_id').val(pacientes_id);
					$('#formulario_pacientes_atenciones #pacientes_id').val(pacientes_id);
					$('#formulario_primera_consulta #fecha_cita').val(getFechaCita(agenda_id));
					$('#formulario_seguimiento #fecha_cita').val(getFechaCita(agenda_id));										
					$('#formulario_primera_consulta #agenda_id').val(agenda_id);
					$('#formulario_seguimiento #agenda_id').val(agenda_id);					
					$('#formulario_pacientes_atenciones #name').val(datos[0]);				
					$('#formulario_pacientes_atenciones #lastname').val(datos[1]);	
					$('#formulario_pacientes_atenciones #telefono1').val(datos[2]);	
					$('#formulario_pacientes_atenciones #telefono2').val(datos[3]);
					$('#formulario_pacientes_atenciones #sexo').val(datos[4]);					
					$('#formulario_pacientes_atenciones #correo').val(datos[5]);
					$('#formulario_pacientes_atenciones #edad').val(datos[6]);	
					$('#formulario_pacientes_atenciones #expediente').val(datos[7]);
					$('#formulario_pacientes_atenciones #direccion').val(datos[8]);					
					$('#formulario_pacientes_atenciones #fecha_nac').val(datos[9]);
					$('#formulario_pacientes_atenciones #departamento_id').val(datos[10]);
					getMunicipioEditar(datos[10], datos[11]);
					$('#formulario_pacientes_atenciones #pais_id').val(datos[12]);
					$('#formulario_pacientes_atenciones #responsable').val(datos[13]);
					$('#formulario_pacientes_atenciones #responsable_id').val(datos[14]);
					$('#formulario_pacientes_atenciones #profesion_pacientes').val(datos[15]);
					$('#formulario_pacientes_atenciones #identidad').val(datos[16]);
					$('#perfil_nombre').html(datos[17]);
					$("#formulario_pacientes_atenciones #fecha").attr('readonly', true);
					$("#formulario_pacientes_atenciones #expediente").attr('readonly', true);
					$("#formulario_pacientes_atenciones #identidad").attr('readonly', true);
					$('#formulario_pacientes_atenciones #validate').removeClass('bien_email');
					$('#formulario_pacientes_atenciones #validate').removeClass('error_email');
					$("#formulario_pacientes_atenciones #correo").css("border-color", "none");
					$('#formulario_pacientes_atenciones #validate').html('');
					
					$('#formulario_pacientes_atenciones').attr({ 'data-form': 'update' }); 
					$('#formulario_pacientes_atenciones').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/editarPacientes.php' });	
						
					paginationSeguimiento(1, pacientes_id, getColaborador_id());

					if(consultaHistoriaClinica(pacientes_id, getColaborador_id()) == 1){
						$('#regConsuta').hide();
						$('#ediConsuta').show();
						setHistoriaClinica(pacientes_id,  getColaborador_id(), agenda_id);							
					}else{
						$('#regConsuta').show();
						$('#ediConsuta').hide();

						 $('#formulario_facturacion').attr({ 'data-form': 'save' }); 
						 $('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/agregarHistoriaClinica.php' });						
					}
					
					$('#regSeg').show();
					$('#ediSeg').hide();					
					return false;
			}
		});	
	}else{
		swal({
			title: 'Acceso Denegado', 
			text: 'No tiene permisos para ejecutar esta acción',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
		});				
		return false;			
	}	
}

function consultaHistoriaClinica(pacientes_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/consultaHistoriaClinica.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id,
		async: false,
		success:function(data){	
			var datos = eval(data);
         	 resp = datos[0];			  		  		  			  
		}
	});
	return resp;	
}

function getHistoriaClinica(pacientes_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/consultaHistoriaClinica.php';
	var resp;
		
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id,
		async: false,
		success:function(data){	
			var datos = eval(data);
         	 resp = datos[1];			  		  		  			  
		}
	});
	return resp;	
}

function setHistoriaClinica(pacientes_id, colaborador_id, agenda_id){
   var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/editarHistoriaClinica.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id+'&agenda_id='+agenda_id,
	   success: function(valores){
			var datos = eval(valores);
			$('#regPacientes').hide();
			$('#ediPacientes').show();	
			$('#formulario_primera_consulta #pro').val('Edición');
			$('#formulario_primera_consulta #grupo_expediente').show();			
			$('#formulario_primera_consulta #historia_clinica_id').val(getHistoriaClinica(pacientes_id, colaborador_id));	
			$('#formulario_primera_consulta #agenda_id').val(datos[0]);				
			$('#formulario_primera_consulta #pacientes_id').val(datos[1]);	
			$('#formulario_primera_consulta #fecha_cita').val(datos[2]);
			$('#formulario_primera_consulta #colaborador_id').val(datos[3]);	
			$('#formulario_primera_consulta #gestas').val(datos[4]);
			$('#formulario_primera_consulta #partos').val(datos[5]);					
			$('#formulario_primera_consulta #cesareas').val(datos[6]);
			$('#formulario_primera_consulta #hijos_vivos').val(datos[7]);	
			$('#formulario_primera_consulta #hijos_muertos').val(datos[8]);
			$('#formulario_primera_consulta #obitos').val(datos[9]);					
			$('#formulario_primera_consulta #abortos').val(datos[10]);
			$('#formulario_primera_consulta #fum').val(datos[11]);
			$('#formulario_primera_consulta #edad_gestacional').val(datos[12]);
			$('#formulario_primera_consulta #tipo_rh').val(datos[13]);
			$('#formulario_primera_consulta #vih_vdrl').val(datos[14]);
			$('#formulario_primera_consulta #citologia').val(datos[15]);
			$('#formulario_primera_consulta #mpf').val(datos[16]);
			$('#formulario_primera_consulta #menarquia').val(datos[17]);				
			$('#formulario_primera_consulta #inicio_vida_sexual').val(datos[18]);	
			$('#formulario_primera_consulta #vida_sexual').val(datos[19]);	
			$('#formulario_primera_consulta #ciclos_menstruales').val(datos[20]);
			$('#formulario_primera_consulta #duracion').val(datos[21]);					
			$('#formulario_primera_consulta #cantidad').val(datos[22]);
			$('#formulario_primera_consulta #dismenorrea').val(datos[23]);	
			$('#formulario_primera_consulta #ante_perso_pato').val(datos[24]);
			$('#formulario_primera_consulta #ante_fam_pato').val(datos[25]);					
			$('#formulario_primera_consulta #ant_hosp_trauma_quirur').val(datos[26]);
			$('#formulario_primera_consulta #ant_inmuno_aler').val(datos[27]);
			$('#formulario_primera_consulta #hab_toxicos').val(datos[28]);
			$('#formulario_primera_consulta #motivo_consulta').val(datos[29]);
			$('#formulario_primera_consulta #hist_enfe_actual').val(datos[30]);
			$('#formulario_primera_consulta #pa_aten').val(datos[31]);
			$('#formulario_primera_consulta #fc_aten').val(datos[32]);
			$('#formulario_primera_consulta #fr_aten').val(datos[33]);				
			$('#formulario_primera_consulta #t_aten').val(datos[34]);	
			$('#formulario_primera_consulta #peso_aten').val(datos[35]);	
			$('#formulario_primera_consulta #talla_aten').val(datos[36]);
			$('#formulario_primera_consulta #imc_aten').val(datos[37]);					
			$('#formulario_primera_consulta #orl_aten').val(datos[38]);
			$('#formulario_primera_consulta #mamas_aten').val(datos[39]);	
			$('#formulario_primera_consulta #pulmones').val(datos[40]);
			$('#formulario_primera_consulta #abdomen_aten').val(datos[41]);					
			$('#formulario_primera_consulta #afu_aten').val(datos[42]);
			$('#formulario_primera_consulta #fcf_aten').val(datos[43]);
			$('#formulario_primera_consulta #au_aten').val(datos[44]);
			$('#formulario_primera_consulta #fm_aten').val(datos[45]);
			$('#formulario_primera_consulta #presentacion_aten').val(datos[46]);
			$('#formulario_primera_consulta #inspe_visual').val(datos[47]);
			$('#formulario_primera_consulta #espesculoscopia').val(datos[48]);	
			$('#formulario_primera_consulta #tbm_aten').val(datos[49]);					
			$('#formulario_primera_consulta #extremidades').val(datos[50]);
			$('#formulario_primera_consulta #ultrasonido').val(datos[51]);
			$('#formulario_primera_consulta #diagnostico').val(datos[52]);
			$('#formulario_primera_consulta #manejo').val(datos[53]);
			$('#formulario_primera_consulta #receta').val(datos[54]);

			caracteresAntecedentesPatologicos();
			caracteresAntecedentesFamiliaresPatologicos();
			caracteresAntecedentesHospitalariosQuirurgicos();
			caracteresAntecedentesHospitalariosTraumaticos();
			caracteresAntecedentesInmunoAlergicos();
			caracteresHabitosToxicos();
			caracteresHistoriaEnfermedadActual();

			$('#formulario_primera_consulta').attr({ 'data-form': 'update' }); 
			$('#formulario_primera_consulta').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/modificarHistoriaClinica.php' });
			return false;
		}	
	});	
}

function perfilNombre(nombre){
	$('#perfil_nombre').html(nombre);
}

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 $('#main_facturacion').show();
	 $('#main_atencion').hide();
});

function getFechaCita(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getFechaCita.php';
	var fecha_cita;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  fecha_cita = data;			  		  		  			  
		}
	});
	return fecha_cita;
}

function getCiclosMenstruales(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getCiclosMenstruales.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_primera_consulta #ciclos_menstruales').html("");
			$('#formulario_primera_consulta #ciclos_menstruales').html(data);	
        }
     });	
}

function getDismenorrea(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getDismenorrea.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_primera_consulta #dismenorrea').html("");
			$('#formulario_primera_consulta #dismenorrea').html(data);	
        }
     });	
}

function paginationSeguimiento(partida, pacientes_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/paginar_seguimiento.php';
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id,
		success:function(data){
			var array = eval(data);
			$('#agrega_registros_historia_clinica').html(array[0]);
			$('#pagination_historia_clinica').html(array[1]);
		}
	});
	return false;
}

function getColaborador_id(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getColaborador.php';
	var colaborador_id;
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){	
          colaborador_id = data;			  		  		  			  
		}
	});
	return colaborador_id;	
}

//INICIO CONTADOR DE CARACTERES
$('#formulario_primera_consulta #ante_perso_pato').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ante_perso_pato').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesPatologicos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #ante_perso_pato').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ante_perso_pato').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #ante_fam_pato').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ante_fam_pato').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesFamiliaresPatologicos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #ante_fam_pato').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ante_fam_pato').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #ant_hosp_trauma_quirur').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ant_hosp_trauma_quirur').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesHospitalariosQuirurgicos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #ant_hosp_trauma_quirur').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ant_hosp_trauma_quirur').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #ant_hosp_trauma_quirur').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ant_hosp_trauma_quirur').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesHospitalariosTraumaticos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #ant_hosp_trauma_quirur').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ant_hosp_trauma_quirur').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #ant_inmuno_aler').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ant_inmuno_aler').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresAntecedentesInmunoAlergicos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #ant_inmuno_aler').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ant_inmuno_aler').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #hab_toxicos').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_hab_toxicos').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresHabitosToxicos(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #hab_toxicos').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_hab_toxicos').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_primera_consulta #hist_enfe_actual').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_hist_enfe_actual').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresHistoriaEnfermedadActual(){
	var max_chars = 2000;
	var chars = $('#formulario_primera_consulta #hist_enfe_actual').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_hist_enfe_actual').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

//FORMULARIO SEGUMIENTO
$('#formulario_seguimiento #hist_enfe_actual_seguimiento').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_seguimiento #charNum_hist_enfe_actual_seguimiento').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresHistoriaEnfermedadActualSegumiento(){
	var max_chars = 2000;
	var chars = $('#formulario_seguimiento #hist_enfe_actual_seguimiento').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_seguimiento #charNum_hist_enfe_actual_seguimiento').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

//FORMULARIO SEGUIMIENTO
$('#formulario_seguimiento #diagnostico_seguimiento').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_seguimiento #charNum_diagnostico_seguimiento').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresDiagnosticoSegumiento(){
	var max_chars = 2000;
	var chars = $('#formulario_seguimiento #diagnostico_seguimiento').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_seguimiento #charNum_diagnostico_seguimiento').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_seguimiento #manejo_seguimiento').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_seguimiento #charNum_manejo_seguimiento').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresManejoSegumiento(){
	var max_chars = 2000;
	var chars = $('#formulario_seguimiento #manejo_seguimiento').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_seguimiento #charNum_manejo_seguimiento').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_seguimiento #receta_estudio_seguimiento').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_seguimiento #charNum_receta_estudio_seguimiento').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresRecetaEstudioSegumiento(){
	var max_chars = 2000;
	var chars = $('#formulario_seguimiento #receta_estudio_seguimiento').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_seguimiento #charNum_receta_estudio_seguimiento').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

$('#formulario_seguimiento #receta_medicamentos_seguimiento').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_seguimiento #charNum_receta_medicamentos_seguimiento').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresRecetaMedicamentosSegumiento(){
	var max_chars = 2000;
	var chars = $('#formulario_seguimiento #receta_medicamentos_seguimiento').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_seguimiento #charNum_receta_medicamentos_seguimiento').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}
//FIN CONTADOR DE CARACTERES

//INICIO CONTROL POR VOS
$(document).ready(function() {
	$('#formulario_primera_consulta #search_ante_perso_pato_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_ante_perso_pato_start').on('click',function(event){
		$('#formulario_primera_consulta #search_ante_perso_pato_start').hide();
		$('#formulario_primera_consulta #search_ante_perso_pato_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #ante_perso_pato').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #ante_perso_pato').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesPatologicos();
					}else{
						$('#formulario_primera_consulta #ante_perso_pato').val(finalResult);
						caracteresAntecedentesPatologicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_ante_perso_pato_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_ante_perso_pato_start').show();
		$('#formulario_primera_consulta #search_ante_perso_pato_stop').hide();
		recognition.stop();
	});
	
	/*###############################################################################################################################*/
	$('#formulario_primera_consulta #search_ante_fam_pato_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_ante_fam_pato_start').on('click',function(event){
		$('#formulario_primera_consulta #search_ante_fam_pato_start').hide();
		$('#formulario_primera_consulta #search_ante_fam_pato_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #ante_fam_pato').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #ante_fam_pato').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesFamiliaresPatologicos();
					}else{
						$('#formulario_primera_consulta #ante_fam_pato').val(finalResult);
						caracteresAntecedentesFamiliaresPatologicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_ante_fam_pato_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_ante_fam_pato_start').show();
		$('#formulario_primera_consulta #search_ante_fam_pato_stop').hide();
		recognition.stop();
	});	
	
	/*###############################################################################################################################*/
	$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_start').on('click',function(event){
		$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_start').hide();
		$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #ant_hosp_trauma_quirur').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #ant_hosp_trauma_quirur').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesHospitalariosQuirurgicos();
					}else{
						$('#formulario_primera_consulta #ant_hosp_trauma_quirur').val(finalResult);
						caracteresAntecedentesHospitalariosQuirurgicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_start').show();
		$('#formulario_primera_consulta #search_ant_hosp_trauma_quirur_stop').hide();
		recognition.stop();
	});
	
	/*###############################################################################################################################*/
	$('#formulario_primera_consulta #search_ant_inmuno_aler_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_ant_inmuno_aler_start').on('click',function(event){
		$('#formulario_primera_consulta #search_ant_inmuno_aler_start').hide();
		$('#formulario_primera_consulta #search_ant_inmuno_aler_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #ant_inmuno_aler').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #ant_inmuno_aler').val(valor_anterior + ' ' + finalResult);
						caracteresAntecedentesInmunoAlergicos();
					}else{
						$('#formulario_primera_consulta #ant_inmuno_aler').val(finalResult);
						caracteresAntecedentesInmunoAlergicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_ant_inmuno_aler_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_ant_inmuno_aler_start').show();
		$('#formulario_primera_consulta #search_ant_inmuno_aler_stop').hide();
		recognition.stop();
	});	
	
	/*###############################################################################################################################*/
	$('#formulario_primera_consulta #search_hab_toxicos_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_hab_toxicos_start').on('click',function(event){
		$('#formulario_primera_consulta #search_hab_toxicos_start').hide();
		$('#formulario_primera_consulta #search_hab_toxicos_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #hab_toxicos').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #hab_toxicos').val(valor_anterior + ' ' + finalResult);
						caracteresHabitosToxicos();
					}else{
						$('#formulario_primera_consulta #hab_toxicos').val(finalResult);
						caracteresHabitosToxicos();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_hab_toxicos_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_hab_toxicos_start').show();
		$('#formulario_primera_consulta #search_hab_toxicos_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_primera_consulta #search_hist_enfe_actual_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_hist_enfe_actual_start').on('click',function(event){
		$('#formulario_primera_consulta #search_hist_enfe_actual_start').hide();
		$('#formulario_primera_consulta #search_hist_enfe_actual_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #hist_enfe_actual').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #hist_enfe_actual').val(valor_anterior + ' ' + finalResult);
						caracteresHistoriaEnfermedadActual();
					}else{
						$('#formulario_primera_consulta #hist_enfe_actual').val(finalResult);
						caracteresHistoriaEnfermedadActual();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_hist_enfe_actual_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_hist_enfe_actual_start').show();
		$('#formulario_primera_consulta #search_hist_enfe_actual_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_seguimiento #search_hist_enfe_actual_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_seguimiento #search_hist_enfe_actual_start').on('click',function(event){
		$('#formulario_seguimiento #search_hist_enfe_actual_start').hide();
		$('#formulario_seguimiento #search_hist_enfe_actual_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_seguimiento #hist_enfe_actual_seguimiento').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_seguimiento #hist_enfe_actual_seguimiento').val(valor_anterior + ' ' + finalResult);
						caracteresHistoriaEnfermedadActualSegumiento();
					}else{
						$('#formulario_seguimiento #hist_enfe_actual_seguimiento').val(finalResult);
						caracteresHistoriaEnfermedadActualSegumiento();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_seguimiento #search_hist_enfe_actual_stop').on("click", function(event){
		$('#formulario_seguimiento #search_hist_enfe_actual_start').show();
		$('#formulario_seguimiento #search_hist_enfe_actual_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_seguimiento #search_diagnostico_seguimiento_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_seguimiento #search_diagnostico_seguimiento_start').on('click',function(event){
		$('#formulario_seguimiento #search_diagnostico_seguimiento_start').hide();
		$('#formulario_seguimiento #search_diagnostico_seguimiento_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_seguimiento #diagnostico_seguimiento').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_seguimiento #diagnostico_seguimiento').val(valor_anterior + ' ' + finalResult);
						caracteresDiagnosticoSegumiento();
					}else{
						$('#formulario_seguimiento #diagnostico_seguimiento').val(finalResult);
						caracteresDiagnosticoSegumiento();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_seguimiento #search_diagnostico_seguimiento_stop').on("click", function(event){
		$('#formulario_seguimiento #search_diagnostico_seguimiento_start').show();
		$('#formulario_seguimiento #search_diagnostico_seguimiento_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_seguimiento #search_manejo_seguimiento_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_seguimiento #search_manejo_seguimiento_start').on('click',function(event){
		$('#formulario_seguimiento #search_manejo_seguimiento_start').hide();
		$('#formulario_seguimiento #search_manejo_seguimiento_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_seguimiento #manejo_seguimiento').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_seguimiento #manejo_seguimiento').val(valor_anterior + ' ' + finalResult);
						caracteresManejoSegumiento();
					}else{
						$('#formulario_seguimiento #manejo_seguimiento').val(finalResult);
						caracteresManejoSegumiento();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_seguimiento #search_manejo_seguimiento_stop').on("click", function(event){
		$('#formulario_seguimiento #search_manejo_seguimiento_start').show();
		$('#formulario_seguimiento #search_manejo_seguimiento_stop').hide();
		recognition.stop();
	});	

	/*###############################################################################################################################*/
	$('#formulario_seguimiento #search_receta_estudio_seguimiento_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_seguimiento #search_receta_estudio_seguimiento_start').on('click',function(event){
		$('#formulario_seguimiento #search_receta_estudio_seguimiento_start').hide();
		$('#formulario_seguimiento #search_receta_estudio_seguimiento_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_seguimiento #receta_estudio_seguimiento').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_seguimiento #receta_estudio_seguimiento').val(valor_anterior + ' ' + finalResult);
						caracteresRecetaEstudioSegumiento();
					}else{
						$('#formulario_seguimiento #receta_estudio_seguimiento').val(finalResult);
						caracteresRecetaEstudioSegumiento();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_seguimiento #search_receta_estudio_seguimiento_stop').on("click", function(event){
		$('#formulario_seguimiento #search_receta_estudio_seguimiento_start').show();
		$('#formulario_seguimiento #search_receta_estudio_seguimiento_stop').hide();
		recognition.stop();
	});	

		/*###############################################################################################################################*/
	$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_seguimiento #search_receta_medicamentos_seguimiento_start').on('click',function(event){
		$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_start').hide();
		$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_seguimiento #receta_medicamentos_seguimiento').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_seguimiento #receta_medicamentos_seguimiento').val(valor_anterior + ' ' + finalResult);
						caracteresRecetaMedicamentosSegumiento();
					}else{
						$('#formulario_seguimiento #receta_medicamentos_seguimiento').val(finalResult);
						caracteresRecetaMedicamentosSegumiento();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_stop').on("click", function(event){
		$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_start').show();
		$('#formulario_seguimiento #search_receta_medicamentos_seguimiento_stop').hide();
		recognition.stop();
	});	
});		
//FIN CONTROL POR VOS

//SUBMIT HISTORIA CLINICA
$('#regConsuta').on('click', function(e){
	$('#formulario_primera_consulta').attr({ 'data-form': 'save' });
	$('#formulario_primera_consulta').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/agregarHistoriaClinica.php' });
	$("#formulario_primera_consulta").submit();
});

$('#formulario_pacientes_atenciones #buscar_pais_pacientes').on('click', function(e){
	listar_pais_buscar(); 
	$('#modal_busqueda_pais').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes_atenciones #buscar_departamento_pacientes').on('click', function(e){
	listar_departamentos_buscar(); 
	$('#modal_busqueda_departamentos').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});			
});

$('#formulario_pacientes_atenciones #buscar_municipio_pacientes').on('click', function(e){
	if($('#formulario_pacientes_atenciones #departamento_id').val() == "" || $('#formulario_pacientes_atenciones #departamento_id').val() == null){
		swal({
			title: "Error", 
			text: "Lo sentimos el departamento no debe estar vacío, antes de seleccionar esta opción por favor seleccione un departamento, por favor corregir",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});			
	}else{
		listar_municipios_buscar();
		 $('#modal_busqueda_municipios').modal({
			show:true,
			keyboard: false,
			backdrop:'static'
		});		
	}	
});

var listar_pais_buscar = function(){
	var table_pais_buscar = $("#dataTablePais").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getPaisTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pais_buscar.search('').draw();
	$('#buscar').focus();
	
	view_pais_busqueda_dataTable("#dataTablePais tbody", table_pais_buscar);
}

var view_pais_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #pais_id').val(data.pais_id);
		$('#modal_busqueda_pais').modal('hide');
	});
}

var listar_departamentos_buscar = function(){
	var table_departamentos_buscar = $("#dataTableDepartamentos").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getDepartamentosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_departamentos_buscar.search('').draw();
	$('#buscar').focus();
	
	view_departamentos_busqueda_dataTable("#dataTableDepartamentos tbody", table_departamentos_buscar);
}

var view_departamentos_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #departamento_id').val(data.departamento_id);
		getMunicipio();
		$('#modal_busqueda_departamentos').modal('hide');
	});
}

var listar_municipios_buscar = function(){
	var departamento = $('#formulario_pacientes_atenciones #departamento_id').val();
	var table_municipios_buscar = $("#dataTableMunicipios").DataTable({
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"../php/pacientes/getMunicipiosTabla.php",
			"data":{ 'departamento' : departamento },
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"municipio"},
			{"data":"departamento"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_municipios_buscar.search('').draw();
	$('#buscar').focus();
	
	view_municipios_busqueda_dataTable("#dataTableMunicipios tbody", table_municipios_buscar);
}

var view_municipios_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #municipio_id').val(data.municipio_id);
		$('#modal_busqueda_municipios').modal('hide');
	});
}

$('#formulario_pacientes_atenciones #buscar_profesion_pacientes').on('click', function(e){
	listar_profesion_buscar();
	 $('#modal_busqueda_profesion').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});	 
});

var listar_profesion_buscar = function(){
	var table_profeision_buscar = $("#dataTableProfesiones").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/pacientes/getProfesionTable.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"}		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_profeision_buscar.search('').draw();
	$('#buscar').focus();
	
	view_profesion_busqueda_dataTable("#dataTableProfesiones tbody", table_profeision_buscar);
}

var view_profesion_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_pacientes_atenciones #profesion_pacientes').val(data.profesion_id);
		$('#modal_busqueda_profesion').modal('hide');
	});
}

//SUBMIT SEGUMIENTO
$('#regSeg').on('click', function(e){
	$('#formulario_seguimiento').attr({ 'data-form': 'save' });
	$('#formulario_seguimiento').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/agregarSeguimiento.php' });
	$("#formulario_seguimiento").submit();
});

$('#ediSeg').on('click', function(e){
	$('#formulario_seguimiento').attr({ 'data-form': 'update' }); 
	$('#formulario_seguimiento').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/modificarSeguimiento.php' });
	$("#formulario_seguimiento").submit();
});

$('#seguimiento_tab').on('click', function(e){
	$('#regSeg').show();
	$('#ediSeg').hide();
});

function editarSeguimiento(seguimiento_id, colaborador_id, pacientes_id){
	$('.nav-tabs li:eq(3) a').tab('show')
	
   var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/editarSeguimiento.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id+'&seguimiento_id='+seguimiento_id,
	   success: function(valores){
			var datos = eval(valores);
			$('#regSeg').hide();
			$('#ediSeg').show();
			$('#formulario_seguimiento #pro').val('Edición');
			$('#formulario_seguimiento #grupo_expediente').show();			
			$('#formulario_seguimiento #seguimiento_id').val(seguimiento_id);	
			$('#formulario_seguimiento #agenda_id').val(datos[0]);				
			$('#formulario_seguimiento #pacientes_id').val(datos[1]);	
			$('#formulario_seguimiento #fecha_cita').val(datos[2]);
			$('#formulario_seguimiento #colaborador_id').val(datos[3]);	
			$('#formulario_seguimiento #motivo_consulta_seguimiento').val(datos[4]);
			$('#formulario_seguimiento #hist_enfe_actual_seguimiento').val(datos[5]);					
			$('#formulario_seguimiento #diagnostico_seguimiento').val(datos[6]);
			$('#formulario_seguimiento #manejo_seguimiento').val(datos[7]);	
			$('#formulario_seguimiento #receta_estudio_seguimiento').val(datos[8]);
			$('#formulario_seguimiento #receta_medicamentos_seguimiento').val(datos[9]);

			caracteresHistoriaEnfermedadActualSegumiento();
			caracteresDiagnosticoSegumiento();
			caracteresManejoSegumiento();
			caracteresRecetaEstudioSegumiento();
			caracteresRecetaMedicamentosSegumiento();

			return false;
		}	
	});
}

function modalConsultaSeguimiento(seguimiento_id, colaborador_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/mostrarSeguimiento.php';
   
   $.ajax({
	   type:'POST',
	   url:url,
	   data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id+'&seguimiento_id='+seguimiento_id,
	   success: function(valores){
			$('#mostrar_datos').html(valores);

			$('#modal_historia_clinica').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});			
			return false;
		}	
	});	
}
</script>