<script>
$(document).ready(function() {
	setInterval('pagination(1)',22000); 	
	setInterval('pagination(1)',22000);	
	getDepartamentos();
	getPais();
	getSexo();
	getResponsable();
	getProfesion();
	getConsultorio();
	getCiclosMenstruales();
	getDismenorrea();
});

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

function getProfesion(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getProfesion.php';		

	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_pacientes_atenciones #profesion_pacientes').html("");
			$('#formulario_pacientes_atenciones #profesion_pacientes').html(data);	
        }
     });	
}

function getResponsable(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getResponsable.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes_atenciones #responsable_id').html("");
			$('#formulario_pacientes_atenciones #responsable_id').html(data);
		}			
     });		
}

function getSexo(){
    var url = '<?php echo SERVERURL; ?>php/pacientes/getSexo.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){	
		    $('#formulario_pacientes_atenciones #sexo').html("");
			$('#formulario_pacientes_atenciones #sexo').html(data);	
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
		    $('#formulario_pacientes_atenciones #departamento_id').html("");
			$('#formulario_pacientes_atenciones #departamento_id').html(data);
		}			
     });		
}

function getMunicipio(){
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
}

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
		    $('#formulario_pacientes_atenciones #pais_id').html("");
			$('#formulario_pacientes_atenciones #pais_id').html(data);
		}			
     });		
}

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

/*INICIO DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/
$(document).ready(function(){
    $("#registro_transito_eviada").on('shown.bs.modal', function(){
        $(this).find('#formulario_transito_enviada #expediente').focus();
    });
});

$(document).ready(function(){
    $("#registro_transito_recibida").on('shown.bs.modal', function(){
        $(this).find('#formulario_transito_recibida #expediente').focus();
    });
});
/*FIN DE FUNCIONES PARA ESTABLECER EL FOCUS PARA LAS VENTANAS MODALES*/

/****************************************************************************************************************************************************************/
//INICIO CONTROLES DE ACCION
$(document).ready(function() {
	//LLAMADA A LAS FUNCIONES
	funcionesFormPacientes();
	
	//INICIO ABRIR VENTANA MODAL TRANSITO ENVIADA
	$('#form_main #transito_enviada').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){	
		     $('#formulario_transito_enviada #pro').val("Registro");
			 $('#registro_transito_eviada').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			limpiarTE();
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
	//FIN ABRIR VENTANA MODAL TRANSITO ENVIADA
	
	//INICIO ABRIR VENTANA MODAL TRANSITO RECIBIDA
	$('#form_main #transito_recibida').on('click',function(){
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){
		     $('#formulario_transito_recibida #pro').val("Registro");			
			 $('#registro_transito_recibida').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			});
			limpiarTR();
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
	//FIN ABRIR VENTANA MODAL TRANSITO RECIBIDA
	
	//INICIO CONSULTRAR USUARIOS ATENDIDOS
	$('#form_main #historial').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
		if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){
			e.preventDefault();
             paginationBusqueda(1);
			 $('#formulario_buscarAtencion #pro').val("Búsqueda de Atenciones");
			 $('#formulario_buscarAtencion #paciente_consulta').html("");
			 $('#formulario_buscarAtencion #agrega_registros_busqueda_').html('<td colspan="3" style="color:#C7030D">No se encontraron resultados, seleccione un paciente para visualizar sus datos</td>');
			 $('#buscar_atencion').modal({
				show:true,
				keyboard: false,
				backdrop:'static'
			 });  
		}else{
			swal({
				title: "Acceso Denegado", 
				text: "No tiene permisos para ejecutar esta acción",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});	 
		}	 
	});	
	//FIN CONSULTRAR USUARIOS ATENDIDOS

    //INICIO PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
	$('#form_main #bs_regis').on('keyup',function(){
	  pagination(1);
	});

	$('#form_main #fecha_b').on('change',function(){
	  pagination(1);
	});

	$('#form_main #fecha_f').on('change',function(){
	  pagination(1);
	});	  

	$('#form_main #estado').on('change',function(){
	  pagination(1);
	});
	
	$('#formulario_buscarAtencion #busqueda').on('keyup',function(){
	  paginationBusqueda(1);
      $('#formulario_buscarAtencion #paciente_consulta').html('');
	  $('#formulario_buscarAtencion #agrega_registros_busqueda_').html('<td colspan="12" style="color:#C7030D">No se encontraron resultados</td>');
	  $('#formulario_buscarAtencion #pagination_busqueda_').html('');	  
	});	
	//FIN PAGINATION (PARA LAS BUSQUEDAS SEGUN SELECCIONES)
	  
});
//FIN CONTROLES DE ACCION
/****************************************************************************************************************************************************************/

//INICIO FUNCION PARA OBTENER LOS COLABORADORES
function getColaborador(){
    var url = '<?php echo SERVERURL; ?>php/citas/getMedico.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#registro_transito_eviada #enviada').html("");
			$('#registro_transito_eviada #enviada').html(data);

		    $('#formulario_transito_recibida #recibida').html("");
			$('#formulario_transito_recibida #recibida').html(data);		
        }
     });		
}

//INICIO ATENCIONES Medicas
function setAtencion(pacientes_id, agenda_id){
	if($('#form_main #estado').val() == 0){
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
							
						paginationSeguimiento(1);

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
	}else{
		swal({
				title: "Error", 
				text: "Error al ejecutar esta acción, el usuario debe estar en estatus pendiente",
				type: "error", 
				confirmButtonClass: 'btn-danger'
		});	
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
			$('#formulario_primera_consulta #ginecologico').val(datos[46]);					
			$('#formulario_primera_consulta #extremidades').val(datos[47]);
			$('#formulario_primera_consulta #ultrasonido').val(datos[48]);
			$('#formulario_primera_consulta #diagnostico').val(datos[49]);
			$('#formulario_primera_consulta #tratamiento').val(datos[50]);

			caracteresAntecedentesPatologicos();
			caracteresAntecedentesFamiliaresPatologicos();
			caracteresAntecedentesHospitalariosQuirurgicos();
			caracteresAntecedentesHospitalariosTraumaticos();
			caracteresAntecedentesInmunoAlergicos();
			caracteresHabitosToxicos();
			caracteresHistoriaEnfermedadActual();
			caracteresGinecologico();

			$('#formulario_primera_consulta').attr({ 'data-form': 'update' }); 
			$('#formulario_primera_consulta').attr({ 'action': '<?php echo SERVERURL; ?>php/atencion_pacientes/modificarHistoriaClinica.php' });
			return false;
		}	
	});	
}

function perfilNombre(nombre){
	$('#perfil_nombre').html(nombre);
}
//FIN ATENCIONES Medicas

//INICIO FUNCION AUSENCIA DE USUARIOS
function nosePresentoRegistro(pacientes_id, agenda_id){
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){		
		if($('#form_main #estado').val() == 0){ 			  
			  var nombre_usuario = consultarNombre(pacientes_id);
			  var expediente_usuario = consultarExpediente(pacientes_id);
			  var dato;

			  if(expediente_usuario == 0){
				  dato = nombre_usuario;
			  }else{
				  dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
			  }

			swal({
			  title: "¿Esta seguro?",
			  text: "¿Desea remover este usuario: " + dato + " que no se presento a su cita?",
			  type: "input",
			  showCancelButton: true,
			  closeOnConfirm: false,
			  inputPlaceholder: "Comentario",
			  cancelButtonText: "Cancelar",	
			  confirmButtonText: "¡Sí, remover el usuario!",
			  confirmButtonClass: "btn-warning",	  
			}, function (inputValue) {
			  if (inputValue === false) return false;
			  if (inputValue === "") {
				swal.showInputError("¡Necesita escribir algo!");
				return false
			  }
				eliminarRegistro(agenda_id, inputValue);
			});		
	   }else{	
			swal({
				title: "Error", 
				text: "Error al ejecutar esta acción, el usuario debe estar en estatus pendiente",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});			  
	   }
	 }else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});					 
	  }	
}

function eliminarRegistro(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/usuario_no_presento.php';
	
    $.ajax({
	  type:'POST',
	  url:url,
	  data:'agenda_id='+agenda_id+'&fecha='+fecha+'&comentario='+comentario,
	  success: function(registro){
		  if(registro == 1){
			swal({
				title: "Success", 
				text: "Ausencia almacenada correctamente",
				type: "success",
				timer: 3000, //timeOut for auto-close
			});
			pagination(1);
			return false; 
		  }else if(registro == 2){	
				swal({
					title: "Error", 
					text: "Error al remover este registro",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});
				return false; 
		  }else if(registro == 3){	
				swal({
					title: "Error", 
					text: "Este registro ya tiene almacenada una ausencia",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});
				return false; 
		  }else{		
				swal({
					title: "Error", 
					text: "Error al ejecutar esta acción",
					type: "error", 
					confirmButtonClass: 'btn-danger'
				});					 
		  }
	  }
   });
   return false;		
}
//FIN FUNCION AUSENCIA DE USUARIOS

//TANSITO ENVIADA
$('#formulario_transito_enviada #motivo').keyup(function() {
	var max_chars = 255;
	var chars = $(this).val().length;
	var diff = max_chars - chars;
	
	$('#formulario_transito_enviada #charNumMotivoTE').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
});

//TRANSITO RECIBIDA
$('#formulario_transito_recibida #motivo').keyup(function() {
	var max_chars = 255;
	var chars = $(this).val().length;
	var diff = max_chars - chars;
	
	$('#formulario_transito_recibida #charNumMotivoTR').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
});

//INICIO TRANSITO USUARIO
$(document).ready(function(e) {
    $('#formulario_transito_enviada #paciente_te').on('change', function(){
	 if($('#formulario_transito_enviada #paciente_te').val()!=""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formulario_transito_enviada #paciente_te').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_enviada #identidad').val(array[0]);	  			  
		  }
	  });
	  return false;		
	 }else{
		$('#formulario_transito_enviada')[0].reset();
        $('#formulario_transito_enviada #pro').val("Registro");		
        $("#reg_transitoe").attr('disabled', true);			
	 }
	});
});

$(document).ready(function(e) {
    $('#formulario_transito_recibida #paciente_tr').on('change', function(){
	 if($('#formulario_transito_recibida #paciente_tr').val()!=""){
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
        var pacientes_id = $('#formulario_transito_recibida #paciente_tr').val();
	    $.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_recibida #identidad').val(array[0]);	  			  
		  }
	  });
	  return false;		
	 }else{
		$('#formulario_transito_recibida')[0].reset();	
		$('#formulario_transito_recibida #pro').val("Registro");
        $("#reg_transitor").attr('disabled', true);		
	 }
	});
});

$('#reg_transitoe').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){
		 if ($('#formulario_transito_enviada #expediente').val() == "" && $('#formulario_transito_enviada #motivo').val() == "" && $('#formulario_agregar_referencias_recibidas #enviadaa').val() == ""){
			 $('#formulario_transito_enviada')[0].reset();						   
			swal({
				title: 'Error', 
				text: 'No se pueden enviar los datos, los campos estan vacíos',
				type: 'error', 
				confirmButtonClass: 'btn-danger'
			});			
			return false;
		 }else{
			e.preventDefault();
			agregarTransitoEnviadas();		
		 } 		
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});		   
	} 
});

$('#reg_transitor').on('click', function(e){ // add event submit We don't want this to act as a link so cancel the link action
	if (getUsuarioSistema() == 1 || getUsuarioSistema() == 2 || getUsuarioSistema() == 3 || getUsuarioSistema() == 5){
		 if ($('#formulario_transito_recibida #expediente').val() == "" && $('#formulario_transito_recibida #motivo').val() == "" && $('#formulario_agregar_referencias_recibidas #enviadaa').val() == ""){
			$('#formulario_transito_recibida')[0].reset();							   
			swal({
				title: 'Error', 
				text: 'No se pueden enviar los datos, los campos estan vacíos',
				type: 'error', 
				confirmButtonClass: 'btn-danger'
			});				
			return false;
		 }else{
			e.preventDefault();
			agregarTransitoRecibidas();		
		 }  		
	}else{
		swal({
			title: "Acceso Denegado", 
			text: "No tiene permisos para ejecutar esta acción",
			type: "error", 
			confirmButtonClass: 'btn-danger'
		});		   
	} 
});
//FIN TRANSITO USUARIOS

//INICIO PAGINACION DE REGISTROS
function pagination(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/paginar.php';
    var fechai = $('#form_main #fecha_b').val();
	var fechaf = $('#form_main #fecha_f').val();
	var dato = '';
	var estado = '';
	
    if($('#form_main #estado').val() == "" || $('#form_main #estado').val() == null){
		estado = 0;
	}else{
		estado = $('#form_main #estado').val();
	}
	
	if($('#form_main #bs_regis').val() == "" || $('#form_main #bs_regis').val() == null){
		dato = '';
	}else{
		dato = $('#form_main #bs_regis').val();
	}

	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&fechai='+fechai+'&fechaf='+fechaf+'&dato='+dato+'&estado='+estado,
		success:function(data){
			var array = eval(data);
			$('#agrega-registros').html(array[0]);
			$('#pagination').html(array[1]);
		}
	});
	return false;
}

function paginationSeguimiento(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/paginar_seguimiento.php';
	var pacientes_id = $('#formulario_seguimiento #pacientes_id').val();
	var colaborador_id = getColaborador_id();
    /*var fechai = $('#form_main #fecha_b').val();
	var fechaf = $('#form_main #fecha_f').val();
	var dato = '';
	
	if($('#form_main #bs_regis').val() == "" || $('#form_main #bs_regis').val() == null){
		dato = '';
	}else{
		dato = $('#form_main #bs_regis').val();
	}*/

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
//FIN PAGINACION DE REGISTROS

//INICIO PAGINACION DE HISTORIAL DE ATENCIONES
function paginationBusqueda(partida){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/paginar_buscar.php';

	if($('#formulario_buscarAtencion #busqueda').val() == "" || $('#formulario_buscarAtencion #busqueda').val() == null){
		dato = '';
	}else{
		dato = $('#formulario_buscarAtencion #busqueda').val();
	}
	
	$.ajax({
		type:'POST',
		url:url,
		async: true,
		data:'partida='+partida+'&dato='+dato,
		success:function(data){
			var array = eval(data);
			$('#formulario_buscarAtencion #agrega_registros_busqueda').html(array[0]);
			$('#formulario_buscarAtencion #pagination_busqueda').html(array[1]);
		}
	});
	return false;
}
//FIN PAGINACION DE HISTORIAL DE ATENCIONES

//INICIO TRANSITO DE PACIENTES
function agregarTransitoEnviadas(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/agregarTransitoEnviadas.php';
	
   	var fecha = $('#formulario_transito_enviada #fecha').val();	
    var hoy = new Date();
    fecha_actual = convertDate(hoy);
	
   if(getMes(fecha)==2){
	swal({
		title: 'Error', 
		text: 'No se puede agregar/modificar registros fuera de este periodo',
		type: 'error', 
		confirmButtonClass: 'btn-danger'
	});		
	return false;	
   }else{	
    if ( fecha <= fecha_actual){
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_transito_enviada').serialize(),
		success: function(registro){
			if (registro == 1){
			    $('#formulario_transito_enviada')[0].reset();
			    $('#formulario_transito_enviada #pro').val('Registro');		   
				swal({
					title: 'Almacenado', 
					text: 'Registro almacenado correctamente',
					type: 'success', 
					timer: 3000,
				});	
				limpiarTE();
				$('#registro_transito_eviada').modal('hide');
			    return false;
			}else if(registro == 2){							   				   			   
				swal({
					title: 'Error', 
					text: 'Error al intentar almacenar este registro',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});				   		   
			   return false;
			}else if(registro == 3){							   				   			   
				swal({
					title: "Error", 
					text: "Este registro no cuenta con atencion almacenada",
					type: "error", 
					confirmButtonClass: "btn-danger"
				});				   		   
			   return false;
			}else if(registro == 4){							   				   			   
				swal({
					title: "Error", 
					text: "Este registro ya existe",
					type: "error", 
					confirmButtonClass: "btn-danger"
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
   }else{
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de esta fecha',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
		});				
		return false;	   
   }
  }
}

function agregarTransitoRecibidas(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/agregarTransitoRecibidas.php';
	
   	var fecha = $('#formulario_transito_recibida #fecha').val();	
    var hoy = new Date();
    fecha_actual = convertDate(hoy);
	
   if(getMes(fecha)==2){
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de este periodo',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
		});				
		return false;	
   }else{	
    if ( fecha <= fecha_actual){    
	$.ajax({
		type:'POST',
		url:url,
		data:$('#formulario_transito_recibida').serialize(),
		success: function(registro){
			if (registro == 1){
			    $('#formulario_transito_recibida')[0].reset();
			    $('#pro').val('Registro');
				swal({
					title: 'Almacenado', 
					text: 'Registro almacenado correctamente',
					type: 'success',
					timer: 3000,					
				});
				$('#registro_transito_recibida').modal('hide');
				limpiarTR();
			    return false;
			}else if(registro == 2){							   					   			   
				swal({
					title: 'Error', 
					text: 'Error al intentar almacenar este registro',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});				   				   
			    return false;
			}else if(registro == 3){							   					   			   
				swal({
					title: 'Error', 
					text: 'Este registro no cuenta con atencion almacenada',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});				   				   
			    return false;
			}else if(registro == 4){							   					   			   
				swal({
					title: 'Error', 
					text: 'Este registro ya existe',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});				   				   
			    return false;
			}else{				   			   
				swal({
					title: 'Error', 
					text: 'Error al completar el registro',
					type: 'error', 
					confirmButtonClass: 'btn-danger'
				});			    
			    return false;
			}
		}
	});	
   }else{
		swal({
			title: 'Error', 
			text: 'No se puede agregar/modificar registros fuera de esta fecha',
			type: 'error', 
			confirmButtonClass: 'btn-danger'
		});
	    return false;	 
   }
  }
}
//FIN TRANSITO DE PACIENTES

//INICIO AGRUPAR FUNCIONES DE PACIENTES
function funcionesFormPacientes(){
	getServicioTransito();
	getServicioAtencion();
	getEstado();
	getPacientes();
	getConsultorio();
	pagination(1);
}
//FIN AGRUPAR FUNCIONES DE PACIENTES

//INICIO AGRUPAR FUNCIONES DE METODOS DE PAGO
function funcionesMetodoPago(){
	getTipoPago();
	getTipoTarifa();
}
//FIN AGRUPAR FUNCIONES DE METODOS DE PAGO

//INICIO OBTENER EL NOMBRE DEL PACIENTE
function getNombrePaciente(pacientes_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getNombrePaciente.php';
	var paciente;
	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id,
		async: false,
		success:function(data){	
          paciente = data;			  		  		  			  
		}
	});
	return paciente;	
}
//FIN OBTENER EL NOMBRE DEL PACIENTE

//INICIO PARA OBTENER EL COLABORADOR_ID
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
//FIN PARA OBTENER EL COLABORADOR_ID

//INICIO PARA OBTENER EL SERVICIO DEL TRANSITO DE USUARIOS	
function getServicioTransito(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/servicios_transito.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){
		    $('#formulario_transito_enviada #servicio').html("");
			$('#formulario_transito_enviada #servicio').html(data);
			
		    $('#formulario_transito_recibida #servicio').html("");
			$('#formulario_transito_recibida #servicio').html(data);			
        }
     });		
}
//FIN PARA OBTENER EL SERVICIO DEL TRANSITO DE USUARIOS

//INICIO FUNCION LIMPIAR TRANSITO
function limpiarTE(){
	getPacientes();
	getColaborador();
	$('#formulario_transito_enviada #pro').val("Registro");
	$('#formulario_transito_enviada #motivo').val("");
	$("#reg_transitoe").attr('disabled', false);
}

function limpiarTR(){
	getPacientes();
	getColaborador();
	$('#formulario_transito_recibida #pro').val("Registro");	
	$('#formulario_transito_recibida #motivo').val("");
	$("#reg_transitor").attr('disabled', false);	
}
//FIN FUNCION LIMPIAR TRANSITO

//INICIO FUNCION PARA OBTENER LOS PACIENTES
function getPacientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getPacientes.php';		
		
	$.ajax({
        type: "POST",
        url: url,
	    async: true,
        success: function(data){									
		    $('#formulario_transito_enviada #paciente_te').html("");
			$('#formulario_transito_enviada #paciente_te').html(data);

		    $('#formulario_transito_recibida #paciente_tr').html("");
			$('#formulario_transito_recibida #paciente_tr').html(data);				
        }
     });	
}
//FIN FUNCION PARA OBTENER LOS PACIENTES

//INICIO FUNCION PARA OBTENER LA PROFESION

//INICIO PARA OBTENER EL SERVICIO DEL FORMULARIO DE PACIENTES
function getServicioAtencion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/servicios.php';
	
	var servicio_id;
	$.ajax({
	    type:'POST',
		data:'agenda_id='+agenda_id,
		url:url,
		async: false,
		success:function(data){	
          servicio_id = data;			  		  		  			  
		}
	});
	return servicio_id;		
}
//FIN PARA OBTENER EL SERVICIO DEL FORMULARIO DE PACIENTES

//INICIO PARA OBTENER EL ESTADO DE LOS PACIENTES (ATENDIDOS, AUSENTES)
function getEstado(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getEstado.php';		
		
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
//FIN PARA OBTENER EL ESTADO DE LOS PACIENTES (ATENDIDOS, AUSENTES)

//INICIO PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL
function evaluarRegistrosPendientes(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/evaluarPendientes.php';
	var string = '';
	
	$.ajax({
	    type:'POST',
		data:'fecha='+fecha,
		url:url,
		success: function(valores){	
		   var datos = eval(valores);
		   if(datos[0]>0){			   
			  if(datos[0] == 1 || datos[0] == 0){
				  string = 'Registro pendiente';
			  }else{
				  string = 'Registros pendientes';
			  }
			  			  
			  swal({
					title: 'Advertencia', 
					text: "Se le recuerda que tiene " + datos[0] + " " + string + " de subir en las Atenciones Medicas en este mes de " + datos[1] + ". Debe revisar sus registros pendientes.", 
					type: 'warning', 
					confirmButtonClass: 'btn-warning'
			  });			  
		   }
           		  		  		  			  
		}
	});	
}
//FIN PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL

//INICIO PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL Y ENVIARLOS POR CORREO ELECTRONICO COMO RECORDATORIO
function evaluarRegistrosPendientesEmail(){
    var url = '<?php echo SERVERURL; ?>php/mail/evaluarPendientes_atencionesMedicas.php';
	
	$.ajax({
	    type:'POST',
		url:url,
		success: function(valores){	
           		  		  		  			  
		}
	});	
}
//FIN PARA EVALUAR SI HAY REGISTROS PENDIENTES PARA EL PROFESIONAL Y ENVIARLOS POR CORREO ELECTRONICO COMO RECORDATORIO

function convertDate(inputFormat) {
	function pad(s) { return (s < 10) ? '0' + s : s; }
	var d = new Date(inputFormat);
	return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
}

function getMes(fecha){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getMes.php';
	var resp;
	
	$.ajax({
	    type:'POST',
		data:'fecha='+fecha,
		url:url,
		async: false,
		success:function(data){	
          resp = data;			  		  		  			  
		}
	});
	return resp	;	
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

$('#formulario_transito_enviada #buscar_colaboradores_te').on('click', function(e){
	listar_colaboradores_buscar_te();
	$('#modal_busqueda_colaboradores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

var listar_colaboradores_buscar_te = function(){
	var table_colaboradores_buscar_te = $("#dataTableColaboradores").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getColaboradoresTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"colaborador"},
			{"data":"identidad"},
			{"data":"puesto"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_colaboradores_buscar_te.search('').draw();
	$('#buscar').focus();
	
	view_colaboradores_busqueda_te_dataTable("#dataTableColaboradores tbody", table_colaboradores_buscar_te);
}

var view_colaboradores_busqueda_te_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  		
		$('#formulario_transito_enviada #colaborador_id').val(data.colaborador_id);
		$('#formulario_transito_enviada #enviada').val(data.colaborador_id);		
		$('#modal_busqueda_colaboradores').modal('hide');
	});
}

$('#formulario_transito_recibida #buscar_pacientes_tr').on('click', function(e){
	listar_pacientes_buscar_tr();
	$('#modal_busqueda_pacientes').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

var listar_pacientes_buscar_tr = function(){
	var table_pacientes_buscar_tr = $("#dataTablePacientes").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getPacientesTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"paciente"},
			{"data":"identidad"},
			{"data":"expediente"},
			{"data":"email"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_pacientes_buscar_tr.search('').draw();
	$('#buscar').focus();
	
	view_pacientes_busqueda_tr_dataTable("#dataTablePacientes tbody", table_pacientes_buscar_tr);
}

var view_pacientes_busqueda_tr_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		
		$('#formulario_transito_recibida #pacientes_id').val(data.pacientes_id);
		$('#formulario_transito_recibida #paciente_tr').val(data.pacientes_id);
		
		var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/buscar_expediente.php';
		var pacientes_id = $('#formulario_transito_recibida #paciente_tr').val();
		
		$.ajax({
		   type:'POST',
		   url:url,
		   data:'pacientes_id='+pacientes_id,
		   success:function(data){
			  var array = eval(data);
			  $('#formulario_transito_recibida #identidad').val(array[0]);	  			  
		  }
		});	
		
		$('#modal_busqueda_pacientes').modal('hide');
	});
}

$('#formulario_transito_recibida #buscar_colaboradores_tr').on('click', function(e){
	listar_colaboradores_buscar_tr();
	$('#modal_busqueda_colaboradores').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

var listar_colaboradores_buscar_tr = function(){
	var table_colaboradores_buscar_tr = $("#dataTableColaboradores").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/facturacion/getColaboradoresTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"colaborador"},
			{"data":"identidad"},
			{"data":"puesto"}			
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_colaboradores_buscar_tr.search('').draw();
	$('#buscar').focus();
	
	view_colaboradores_busqueda_tr_dataTable("#dataTableColaboradores tbody", table_colaboradores_buscar_tr);
}

var view_colaboradores_busqueda_tr_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();		  
		$('#formulario_transito_recibida #colaborador_id').val(data.colaborador_id);
		$('#formulario_transito_recibida #recibida').val(data.colaborador_id);
		$('#modal_busqueda_colaboradores').modal('hide');
	});
}
//FIN FORMULARIO DE BUSQUEDA

$('#form_main #nueva_factura').on('click', function(e){
	e.preventDefault();
	formFactura();
});

function formFactura(){
	 $('#formulario_facturacion')[0].reset();
	 $('#main_facturacion').hide();	
	 $('#facturacion').show();	
	 $('#label_acciones_volver').html("Volver");
	 $('#acciones_atras').removeClass("active");
	 $('#acciones_factura').addClass("active");
	 $('#label_acciones_factura').html("Factura");
	 $('#formulario_facturacion #fecha').attr('readonly', true);
	 $('#formulario_facturacion #colaborador_id').val(getColaborador_id());
	 $('#formulario_facturacion #colaborador_nombre').val(getProfesional());
	 $('#formulario_facturacion #grupo_buscar_colaboradores').hide();
	 $('#formulario_facturacion #grupo_buscar_colaboradores').show();
	 $('#formulario_facturacion').attr({ 'data-form': 'save' }); 
	 $('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/facturacion/addPreFactura.php' }); 	 
	 limpiarTabla();
	 $('.footer').hide();
	 $('.footer1').show();	 
	 $('#formulario_facturacion #validar').hide();
	 $('#formulario_facturacion #guardar1').hide();
}

$('#acciones_atras').on('click', function(e){
	 e.preventDefault();
	 if($('#formulario_facturacion #cliente_nombre').val() != "" || $('#formulario_facturacion #colaborador_nombre').val() != ""){
		swal({
		  title: "Tiene datos en la factura",
		  text: "¿Esta seguro que desea volver, recuerde que tiene información en la factura la perderá?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-warning",
		  confirmButtonText: "¡Si, deseo volver!",
		  closeOnConfirm: false
		},
		function(){
			$('#main_facturacion').show();
			$('#main_atencion').hide();
			$('#label_acciones_factura').html("");
			$('#facturacion').hide();
			$('#acciones_atras').addClass("breadcrumb-item active");
			$('#acciones_factura').removeClass("active");
			$('#formulario_facturacion')[0].reset();
			swal.close();
			$('.footer').show();
			$('.footer1').hide();			
		});		 			 	
	 }else{	 
		 $('#main_facturacion').show();
		 $('#main_atencion').hide();
		 $('#label_acciones_factura').html("");
		 $('#facturacion').hide();
		 $('#acciones_atras').addClass("breadcrumb-item active");
		 $('#acciones_factura').removeClass("active");
		 $('.footer').show();
		 $('.footer1').hide();		  
	 }
});

$(document).ready(function(){
	listar_pacientes_buscar();
	listar_servicios_factura_buscar();
	listar_productos_facturas_buscar();
});

function getProfesional(){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getProfesional.php';
	var profesional
	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){	
          profesional = data;			  		  		  			  
		}
	});
	return profesional;	
}

function showFactura(agenda_id){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/editarFactura.php';
	
	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		success:function(data){	
		    var datos = eval(data);
	        $('#formulario_facturacion')[0].reset();
	        $('#formulario_facturacion #pro').val("Registro");
			$('#formulario_facturacion #pacientes_id').val(datos[0]);
            $('#formulario_facturacion #cliente_nombre').val(datos[1]);
            $('#formulario_facturacion #fecha').val(getFechaActual());
            $('#formulario_facturacion #colaborador_id').val(datos[3]);
			$('#formulario_facturacion #colaborador_nombre').val(datos[4]);
			$('#formulario_facturacion #servicio_id').val(datos[5]);
			$('#formulario_facturacion #grupo_buscar_colaboradores').hide();
			$('#label_acciones_volver').html("ATA");
			$('#label_acciones_receta').html("Receta");
			
			$('#formulario_facturacion #fecha').attr("readonly", true);
			$('#formulario_facturacion #validar').attr("disabled", false);
			$('#formulario_facturacion #addRows').attr("disabled", false);
			$('#formulario_facturacion #removeRows').attr("disabled", false);
		    $('#formulario_facturacion #validar').show();
		    $('#formulario_facturacion #editar').hide();
		    $('#formulario_facturacion #eliminar').hide();
			limpiarTabla();				
			
			$('#main_atencion').hide();	
			$('#facturacion').show();
			
			$('#formulario_facturacion').attr({ 'data-form': 'save' }); 
			$('#formulario_facturacion').attr({ 'action': '<?php echo SERVERURL; ?>php/facturacion/addPreFactura.php' }); 

			$('#formulario_facturacion #validar').hide();
			$('#formulario_facturacion #guardar1').hide();
			
			$('.footer').hide();
			$('.footer1').show();	
			
			cleanFooterValueBill();
		}
	});
}

$(document).ready(function() {
	$('#formulario_atenciones #fecha_nac').on('change', function(){
		var fecha_nac = $('#formulario_atenciones #fecha_nac').val();
		var url = '<?php echo SERVERURL; ?>php/pacientes/getEdad.php';		
			
		$.ajax({
			type: "POST",
			url: url,
			async: true,
			data:'fecha_nac='+fecha_nac,
			success: function(data){
				var array = eval(data);	
				$('#formulario_atenciones #edad').val(array[3]);
			}
		 });
	});		 
});

function volver(){
	$('#main_facturacion').show();
	$('#main_atencion').hide();
	$('#label_acciones_factura').html("");
	$('#facturacion').hide();
	$('#acciones_atras').addClass("breadcrumb-item active");
	$('#acciones_factura').removeClass("active");
	$('.footer').show();
	$('.footer1').hide();			
}

function getFechaActual(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getFechaActual.php';
	var fecha_actual;

	$.ajax({
	    type:'POST',
		url:url,
		async: false,
		success:function(data){
          fecha_actual = data;
		}
	});
	return fecha_actual;	
}

//INICIO BUSQUEDA SERVICIOS
$('#formulario_facturacion #buscar_servicios').on('click', function(e){
	e.preventDefault();
	listar_servicios_factura_buscar();
	$('#modal_busqueda_servicios').modal({
		show:true,
		keyboard: false,
		backdrop:'static'
	});		 
});

var listar_servicios_factura_buscar = function(){
	var table_servicios_factura_buscar = $("#dataTableServicios").DataTable({		
		"destroy":true,	
		"ajax":{
			"method":"POST",
			"url":"<?php echo SERVERURL; ?>php/atencion_pacientes/getServiciosTabla.php"
		},
		"columns":[
			{"defaultContent":"<button class='view btn btn-primary'><span class='fas fa-copy'></span></button>"},
			{"data":"nombre"},		
		],
		"pageLength" : 5,
        "lengthMenu": lengthMenu,
		"stateSave": true,
		"bDestroy": true,
		"language": idioma_español,	
	});	 
	table_servicios_factura_buscar.search('').draw();
	$('#buscar').focus();
	
	view_servicios_factura_busqueda_dataTable("#dataTableServicios tbody", table_servicios_factura_buscar);
}

var view_servicios_factura_busqueda_dataTable = function(tbody, table){
	$(tbody).off("click", "button.view");		
	$(tbody).on("click", "button.view", function(e){
		e.preventDefault();
		var data = table.row( $(this).parents("tr") ).data();
		$('#formulario_facturacion #servicio_id').val(data.servicio_id);
		$('#modal_busqueda_servicios').modal('hide');
	});
}
//FIN BUSQUEDA SERVICIOS

function getConsultorio(){
	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getServicio.php';
		
	$.ajax({
	   type:'POST',
	   url:url,
	   success:function(data){ 
		  $('#formulario_facturacion #servicio_id').html("");
		  $('#formulario_facturacion #servicio_id').html(data);		  		  		  	  
	  }
	});
	return false;	
}
//FIN CONTROL DE AUDIO

//FUNCION PARA VALIDAR SI SE HA ALMACENADO LA ATENCION PARA EL PACIENTE
function getAtencionPaciente(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionPaciente.php';
	var atencion;
	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
			atencion = data;			  		  		  			  
		}
	});
	return atencion;	
}

function getAtencion(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencion.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
}

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

function getAtencionEmbarazo(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionEmbarazo.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
}

function getAtencionEcografiaGinecologica(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionEcoGinecologia.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
}

function getAtencionEcografiaObstetrica(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionObstetrica.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
}

function getAtencionColposcopia(agenda_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getAtencionColposcopia.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'agenda_id='+agenda_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
}

//CONSULTAMOS SI EL PACIENTE ES SUBISGUIENTE PARA EL TIPO DE ATENCION
function getPacienteGinecologia(pacientes_id, colaborador_id){
    var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/getPacienteGinecologia.php';
	var atencion;

	$.ajax({
	    type:'POST',
		url:url,
		data:'pacientes_id='+pacientes_id+'&colaborador_id='+colaborador_id+'&servicio_id='+servicio_id,
		async: false,
		success:function(data){	
		  atencion = data;			  		  		  			  
		}
	});
	return atencion;
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

$('#formulario_primera_consulta #ginecologico').keyup(function() {
	    var max_chars = 2000;
        var chars = $(this).val().length;
        var diff = max_chars - chars;
		
		$('#formulario_primera_consulta #charNum_ginecologico').html(diff + ' Caracteres'); 
		
		if(diff == 0){
			return false;
		}
});

function caracteresGinecologico(){
	var max_chars = 1000;
	var chars = $('#formulario_primera_consulta #ginecologico').val().length;
	var diff = max_chars - chars;
	
	$('#formulario_primera_consulta #charNum_ginecologico').html(diff + ' Caracteres'); 
	
	if(diff == 0){
		return false;
	}
}

//FORMULARIO SEGUMIENTO
$('#formulario_seguimiento #hist_enfe_actual_seguimiento').keyup(function() {
	    var max_chars = 1000;
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
	$('#formulario_primera_consulta #search_ginecologico_stop').hide();
	
    var recognition = new webkitSpeechRecognition();
    recognition.continuous = true;
    recognition.lang = "es";
	
    $('#formulario_primera_consulta #search_ginecologico_start').on('click',function(event){
		$('#formulario_primera_consulta #search_hist_enfe_actual_start').hide();
		$('#formulario_primera_consulta #search_ginecologico_stop').show();
		recognition.start();
		
		recognition.onresult = function (event) {
			finalResult = '';
			var valor_anterior  = $('#formulario_primera_consulta #ginecologico').val();
			for (var i = event.resultIndex; i < event.results.length; ++i) {
				if (event.results[i].isFinal) {
					finalResult = event.results[i][0].transcript;
					if(valor_anterior != ""){
						$('#formulario_primera_consulta #ginecologico').val(valor_anterior + ' ' + finalResult);
						caracteresGinecologico();
					}else{
						$('#formulario_primera_consulta #ginecologico').val(finalResult);
						caracteresGinecologico();
					}				
				}
			}
		};		
		return false;
    });	
	
	$('#formulario_primera_consulta #search_ginecologico_stop').on("click", function(event){
		$('#formulario_primera_consulta #search_ginecologico_start').show();
		$('#formulario_primera_consulta #search_ginecologico_stop').hide();
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

function calculoIMC(){
	var kg = 0.00;
	var talla = 0.00;

	if($("#formulario_primera_consulta #peso_aten").val() == "" || $("#formulario_primera_consulta #peso_aten").val() == null){
		kg = 0.00;			
	}else{
		kg = parseFloat($("#formulario_primera_consulta #peso_aten").val());
	}

	if($("#formulario_primera_consulta #talla_aten").val() == "" || $("#formulario_primera_consulta #talla_aten").val() == null){
		talla = 0.00;			
	}else{
		talla = parseFloat($("#formulario_primera_consulta #talla_aten").val());
	}		
	
	var imc = 0.00;

	kg = parseFloat(kg).toFixed(2);

	if(talla == 0){
		imc = 0;
	}else{
		imc = kg / (talla * talla);
		imc = parseFloat(imc).toFixed(2);
	}

	if(kg == null || kg == ""){
		kg = 0.0;
	}

	if(imc == null || imc == ""){
		imc = 0.0;
	}		

	$("#formulario_primera_consulta #peso_kg").val(kg);
	$("#formulario_primera_consulta #imc_aten").val(imc);
}

$("#formulario_primera_consulta #peso_aten").on("keyup", function(e){
	calculoIMC();
});	

$("#formulario_primera_consulta #talla_aten").on("keyup", function(e){
	calculoIMC();
});	

$("#nuevoSegimiento").on("click", function(e){
	e.preventDefault();
	$('#formulario_seguimiento')[0].reset();
	$("#formulario_seguimiento #motivo_consulta_seguimiento").focus();
	$('#ediSeg').hide();
	$('#regSeg').show();
});	

//FINALIZAR ATENCION
$('#end_atencion').on('click', function(e){
	e.preventDefault();	
	var nombre_usuario = consultarNombre(pacientes_id);
	var expediente_usuario = consultarExpediente(pacientes_id);
	var dato;

	if(expediente_usuario == 0){
		dato = nombre_usuario;
	}else{
		dato = nombre_usuario + " (Expediente: " + expediente_usuario + ")";
	}

	swal({
		title: "¿Esta seguro?",
		text: "¿Desea marcar la atención para el paciente: " + dato + " Atención culminada",
		type: "input",
		showCancelButton: true,
		closeOnConfirm: false,
		inputPlaceholder: "Comentario",
		cancelButtonText: "Cancelar",	
		confirmButtonText: "¡Sí, marcar la atención!",
		confirmButtonClass: "btn-warning",	  
	}, function (inputValue) {
		if (inputValue === false) return false;
		if (inputValue === "") {
		swal.showInputError("¡Necesita escribir algo!");
		return false
		}
		marcarAtencion($('#primera_consulta #agenda_id').val(), inputValue);
	});	
});

function marcarAtencion(agenda_id, comentario, fecha){
	var hoy = new Date();
	fecha_actual = convertDate(hoy);

	var url = '<?php echo SERVERURL; ?>php/atencion_pacientes/marcarAtencion.php';
	
    $.ajax({
	  type:'POST',
	  url:url,
	  data:'agenda_id='+agenda_id+'&fecha='+fecha+'&comentario='+comentario,
	  success: function(registro){
		var datos = eval(registro);
		
		if (datos[1] == "AtencionMedica"){
			showFactura(datos[2]);//LLAMAMOS LA FACTURA .-Función se encuenta en myjava_atencioN_medica.js
		}
		
		if(datos[0] == 1){
			swal({
				title: "Success", 
				text: "Atencion marcada correctamente",
				type: "success",
				timer: 1000, //timeOut for auto-close
			});
		}else if(datos[0] == 2){
			swal({
				title: "Error", 
				text: "Error al marcar la atención",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});
			return false;		 
		}else{
			swal({
				title: "Error", 
				text: "Error al ejecutar esta acción",
				type: "error", 
				confirmButtonClass: 'btn-danger'
			});				
		}
	  }
   });
   return false;		
}
</script>