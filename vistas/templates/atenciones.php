<div id="perfil_paciente">
   <b>PERFIL PACIENTE</b>
   <br/>
   <b><span id="perfil_nombre"><span></b>
</div>

<!--INICIO MENU TAB CONTENT-->
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home_form2" role="tab" aria-controls="home_form1" aria-selected="false">Historia Clínica</a>
	</li>
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="datos_personales_tab" data-toggle="tab" href="#datos_personales" role="tab" aria-controls="transito_form1" aria-selected="false">Datos Personales</a>
	</li>
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="primera_consulta_tab" data-toggle="tab" href="#primera_consulta" role="tab" aria-controls="referencia_form1" aria-selected="false">Primera Consulta</a>
	</li>
	<li class="nav-item waves-effect waves-light">
		<a class="nav-link" id="seguimiento_tab" data-toggle="tab" href="#seguimiento" role="tab" aria-controls="referencia_form1" aria-selected="false">Seguimiento</a>
	</li>  
	<li class="nav-item waves-effect waves-light">
		<button class="btn btn-dark ml-2" type="submit" id="end_atencion"><div class="sb-nav-link-icon"></div><i class="fas fa-window-close"></i> Finalizar Atención</button>
	</li>	              
</ul>
<!--FIN MENU TAB CONTENT-->

<!-- INICIO TAB CONTENT-->
<div class="tab-content" id="myTabContent">
	<!-- INICIO TAB HOME-->
	<div class="tab-pane fade active show" id="home_form2" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<div class="form-group">
			  <div class="col-sm-12">
				<div class="registros overflow-auto" id="agrega_registros_historia_clinica"></div>
			   </div>		   
			</div>
			<nav aria-label="Page navigation example">
				<ul class="pagination justify-content-center" id="pagination_historia_clinica"></ul>
			</nav>
		</div>
		<div class="modal-footer">
		
		</div>
	</div>
	<!-- FIN TAB HOME-->

	<!-- INICIO DATOS PERSONALES-->
	<div class="tab-pane fade" id="datos_personales" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formulario_pacientes_atenciones" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="pacientes_id" class="form-control" id="pacientes_id">
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label for="expediente">Expediente</label>
						<input type="text" name="expediente" class="form-control" id="expediente" placeholder="Expediente o Identidad">
					</div>
					<div class="col-md-6 mb-3">
						<label for="edad">Edad</label>
						<input type="text" class="form-control" name="edad" id="edad" maxlength="100" readonly />
					</div>				
				</div>				
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label for="name">Nombre <span class="priority">*<span/></label>
						<input type="text" required id="name" name="name" placeholder="Nombre" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="lastname">Apellido <span class="priority">*<span/></label>
						<input type="text" required id="lastname" name="lastname" placeholder="Apellido" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="identidad">Identidad o RTN<span class="priority">*<span/></label>
						<input type="text" required id="identidad" name="identidad" maxlength="14" placeholder="Identidad o RTN" class="form-control"/>
					</div>
					<div class="col-md-3 mb-3">
						<label for="fecha_nac">Fecha de Nacimiento <span class="priority">*<span/></label>
						<input type="date" id="fecha_nac" name="fecha_nac" value="<?php echo date ("Y-m-d");?>" class="form-control"/>
					</div>							
				</div>	
				<div class="form-row">	
					<div class="col-md-3 mb-3">
						<label for="sexo">Sexo <span class="priority">*<span/></label>
						<select class="form-control" id="sexo" name="sexo" required data-toggle="tooltip" data-placement="top" title="Sexo">	
							<option value="">Seleccione</option>
						</select>
					</div>
					<div class="col-md-3 mb-3">
						<label for="telefono1">Teléfono 1 <span class="priority">*<span/></label>
						<input type="number" id="telefono1" name="telefono1" class="form-control" placeholder="Primer Teléfono" required maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
					</div>				
					<div class="col-md-3 mb-3">
						<label for="telefono2">Teléfono 2</label>
						<input type="number" id="telefono2" name="telefono2" class="form-control" placeholder="Segundo Teléfono" maxlength="8" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"/>
					</div>						
					<div class="col-md-3 mb-3">
						<label for="profesion_pacientes">Profesión <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="profesion_pacientes" name="profesion_pacientes" class="form-control" data-toggle="tooltip" data-placement="top" title="Profesión">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_profesion_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>					
				</div>					
						
				<div class="form-row">											
					<div class="col-md-4 mb-3">
						<label for="pais_id">País <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="pais_id" name="pais_id" class="form-control" data-toggle="tooltip" data-placement="top" title="País">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_pais_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>				
					<div class="col-md-4 mb-3">
						<label for="departamento_id">Departamentos <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="departamento_id" name="departamento_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Departamentos">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_departamento_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>
					<div class="col-md-4 mb-3">
						<label for="municipio_id">Municipios <span class="priority">*<span/></label>
						<div class="input-group mb-3">
							<select id="municipio_id" name="municipio_id" class="form-control" data-toggle="tooltip" data-placement="top" title="Municipios">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_municipio_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>											
				</div>
							
				<div class="form-row">			  
					<div class="col-md-12 mb-3">
						<label for="direccion">Dirección <span class="priority">*<span/></label>
						<input type="text" required="required" id="direccion" name="direccion" placeholder="Dirección Completa" placeholder="Dirección" class="form-control"/>
					</div>
				</div>	

				<div class="form-row">			  
					<div class="col-md-12 mb-3">
						<label for="correo">Correo</label>
						<input type="email" name="correo" id="correo" placeholder="alguien@algo.com" class="form-control" data-toggle="tooltip" data-placement="top" title="Este correo será utilizado para enviar las citas creadas y las reprogramaciones, como las notificaciones de las citas pendientes de los usuarios." maxlength="100"/><label id="validate"></label>
					</div>
				</div>	
				<div class="form-row">
					<div class="col-md-8 mb-3">
						<label for="responsable">Responsable </label>
						<input type="text" id="responsable" name="responsable" class="form-control" placeholder="Responsable" maxlength="70" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" />
					</div>
					<div class="col-md-4 mb-3">
						<label for="responsable_id">Parentesco </label>
						<select class="form-control" id="responsable_id" name="responsable_id" data-toggle="tooltip" data-placement="top" title="Parentesco">	
							<option value="">Seleccione</option>
						</select>
						</div>					
				</div>

				<div class="form-group custom-control custom-checkbox custom-control-inline">	
					<div class="col-md-12">	
						<label for="asegurado_activo">Asegurado </label>		
						<label class="switch">
							<input type="checkbox" id="asegurado_activo" name="asegurado_activo" value="1">
							<div class="slider round"></div>
						</label>
						<span class="question mb-2" id="label_asegurado_activo"></span>				
					</div>				  			  
				</div>	
						
				<div class="form-row" id="seguros" style="display:none;">
					<div class="col-md-4 mb-3">
						<label for="seguros_pacientes">Seguros</label>
						<div class="input-group mb-3">
							<select id="seguros_pacientes" name="seguros_pacientes" class="form-control" data-toggle="tooltip" data-placement="top" title="Seguros">
								<option value="">Seleccione</option>
							</select>
							<div class="input-group-append" id="buscar_seguros_pacientes">				
								<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
							</div>
						</div>						  
					</div>											
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" form="formulario_pacientes_atenciones" type="submit" id="regPacientes"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="btn btn-warning ml-2" form="formulario_pacientes_atenciones" type="submit" id="ediPacientes"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>			
		</div>				
	</div>
	<!-- FIN DATOS PERSONALES-->

	<!-- INICIO PRIMERA CONSULTA-->
	<div class="tab-pane fade" id="primera_consulta" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formulario_primera_consulta" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="agenda_id" id="agenda_id" class="form-control">
				<input type="hidden" name="pacientes_id" id="pacientes_id" class="form-control">
				<input type="hidden" name="fecha_cita" id="fecha_cita" class="form-control">
				<input type="hidden" name="colaborador_id" id="colaborador_id" class="form-control">
				<input type="hidden" name="historia_clinica_id" id="historia_clinica_id" class="form-control">
				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					HISTORIA GINECO OBSTETRA
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="gestas">Gestas</label>
							<input type="text" class="form-control" name="gestas" id="gestas" placeholder="Gestas" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="partos">Partos</label>
							<input type="text" class="form-control" name="partos" id="partos" maxlength="100" placeholder="Partos" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="cesareas">Cesáreas</label>
							<input type="text" class="form-control" name="cesareas" id="cesareas" placeholder="Cesáreas" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="hijos_vivos">Hijos Vivos</label>
							<input type="text" class="form-control" name="hijos_vivos" id="hijos_vivos" maxlength="100" placeholder="Hijos Vivos" maxlength="30"/>
						</div>						
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="hijos_muertos">Hijos Muertos</label>
							<input type="text" class="form-control" name="hijos_muertos" id="hijos_muertos" placeholder="Hijos Muertos" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="obitos">Obitos</label>
							<input type="text" class="form-control" name="obitos" id="obitos" maxlength="100" placeholder="Obitos" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="abortos">Abortos</label>
							<input type="text" class="form-control" name="abortos" id="abortos" placeholder="Abortos" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="fum">FUM</label>
							<input type="text" class="form-control" name="fum" id="fum" maxlength="100" placeholder="FUM" maxlength="30"/>
						</div>						
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="edad_gestacional">Edad Gestacional</label>
							<input type="text" class="form-control" name="edad_gestacional" id="edad_gestacional" placeholder="Edad Gestacional" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="tipo_rh">Tipo y RH</label>
							<input type="text" class="form-control" name="tipo_rh" id="tipo_rh" maxlength="100" placeholder="Tipo y RH" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="vih_vdrl">VIH/VDRL</label>
							<input type="text" class="form-control" name="vih_vdrl" id="vih_vdrl" placeholder="VIH/VDRL" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="citologia">Citología</label>
							<input type="text" class="form-control" name="citologia" id="citologia" maxlength="100" placeholder="Citología" maxlength="30"//>
						</div>						
					</div>
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="mpf">MPF</label>
							<input type="text" class="form-control" name="mpf" id="mpf" placeholder="MPF" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="menarquia">Menarquia</label>
							<input type="text" class="form-control" name="menarquia" id="menarquia" placeholder="Menarquia" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="inicio_vida_sexual">Inicio Vida Sexual</label>
							<input type="text" class="form-control" name="inicio_vida_sexual" id="inicio_vida_sexual" placeholder="Inicio Vida Sexual" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="vida_sexual">Vida Sexual</label>
							<input type="text" class="form-control" name="vida_sexual" id="vida_sexual" maxlength="100" placeholder="Visa Sexual" maxlength="30"/>
						</div>						
					</div>	
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="ciclos_menstruales">Ciclos Menstruales</label>
							<div class="input-group mb-3">
								<select id="ciclos_menstruales" name="ciclos_menstruales" class="form-control" data-toggle="tooltip" data-placement="top" title="Ciclos Menstruales">
									<option value="">Seleccione</option>
								</select>
								<div class="input-group-append" id="buscar_ciclos_menstruales" style="display: none;">				
									<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
								</div>
							</div>	
						</div>
						<div class="col-md-3 mb-3">
							<label for="duracion">Duración</label>
							<input type="text" class="form-control" name="duracion" id="duracion" maxlength="100" maxlength="30"/>						
						</div>	
						<div class="col-md-3 mb-3">
							<label for="cantidad">Cantidad</label>
							<input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="dismenorrea">Dismenorrea</label>
							<div class="input-group mb-3">
								<select id="dismenorrea" name="dismenorrea" class="form-control" data-toggle="tooltip" data-placement="top" title="Dismenorrea">
									<option value="">Seleccione</option>
								</select>
								<div class="input-group-append" id="buscar_ciclos_menstruales" style="display: none;">				
									<a data-toggle="modal" href="#" class="btn btn-outline-success"><div class="sb-nav-link-icon"></div><i class="fas fa-search fa-lg"></i></a>
								</div>
							</div>	
						</div>						
					</div>						
					
				  </div>
				</div>	

				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					ANTECEDENTES
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ante_perso_pato">Antecedentes Personales Patológicos</label>
							<div class="input-group">
							  <textarea id="ante_perso_pato" name="ante_perso_pato" placeholder="Antecedentes Personales Patologicos" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ante_perso_pato_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ante_perso_pato_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ante_perso_pato">2000 Caracteres</p>
						</div>					
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ante_fam_pato">Antecedentes Familiares Patológicos</label>
							<div class="input-group">
							  <textarea id="ante_fam_pato" name="ante_fam_pato" placeholder="Antecedentes Familiares Patologicos" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ante_fam_pato_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ante_fam_pato_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ante_fam_pato">2000 Caracteres</p>
						</div>					
					</div>
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ant_hosp_trauma_quirur">Antecedentes Hospitalarios, Traumáticos Quirúrgicos</label>
							<div class="input-group">
							  <textarea id="ant_hosp_trauma_quirur" name="ant_hosp_trauma_quirur" placeholder="Antecedentes Hospitalarios, Traumáticos Quirúrgicos" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ant_hosp_trauma_quirur_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ant_hosp_trauma_quirur_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ant_hosp_trauma_quirur">2000 Caracteres</p>
						</div>					
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ant_inmuno_aler">Antecedentes Inmunoalérgicos</label>
							<div class="input-group">
							  <textarea id="ant_inmuno_aler" name="ant_inmuno_aler" placeholder="Antecedentes Inmunoalérgicos" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ant_inmuno_aler_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ant_inmuno_aler_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ant_inmuno_aler">2000 Caracteres</p>
						</div>					
					</div>	

					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="hab_toxicos">Hábitos Tóxicos</label>
							<div class="input-group">
							  <textarea id="hab_toxicos" name="hab_toxicos" placeholder="Hábitos Tóxicos" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_hab_toxicos_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_hab_toxicos_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_hab_toxicos">2000 Caracteres</p>
						</div>					
					</div>						
					
				  </div>
				</div>	

				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					MOTIVO CONSULTA
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<input type="text" class="form-control" name="motivo_consulta" id="motivo_consulta" placeholder="Motivo consulta" maxlength="254"/>
						</div>					
					</div>	
					
				  </div>
				</div>

				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					HISTORIA ENFERMEDAD ACTUAL
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<div class="input-group">
							  <textarea id="hist_enfe_actual" name="hist_enfe_actual" placeholder="Historia Enfermedad Actual" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_hist_enfe_actual_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_hist_enfe_actual_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_hist_enfe_actual">2000 Caracteres</p>
						</div>					
					</div>	
					
				  </div>
				</div>

				<div class="card">
				  <div class="card-header text-white bg-info mb-3" align="center">
					EXAMEN FÍSICO
				  </div>
				  <div class="card-body">
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="pa_aten">PA</label>
							<input type="text" class="form-control" name="pa_aten" id="pa_aten" placeholder="Presión Arterial" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="fc_aten">FC/P</label>
							<input type="text" class="form-control" name="fc_aten" id="fc_aten" placeholder="Frecuencia Cardiaca" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="fr_aten">FR</label>
							<input type="text" class="form-control" name="fr_aten" id="fr_aten" placeholder="Frecuencia Respitaria" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="t_aten">T</label>
							<input type="text" class="form-control" name="t_aten" id="t_aten" maxlength="100" placeholder="Temperatura" maxlength="30"/>
						</div>						
					</div>	
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="peso_aten">Peso</label>
							<div class="input-group mb-3">								
								<input type="text" id="peso_aten" name="peso_aten" class="form-control" step="0.01"/>
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>KG</i></span>
								</div>
							</div>								
						</div>
						<div class="col-md-3 mb-3">
							<label for="talla_aten">Talla</label>
							<div class="input-group mb-3">								
								<input type="number" id="talla_aten" name="talla_aten" class="form-control" step="0.01"/>
								<div class="input-group-append">	
									<span class="input-group-text"><div class="sb-nav-link-icon"></div>m</i></span>
								</div>
							</div>								
						</div>	
						<div class="col-md-3 mb-3">
							<label for="imc_aten">IMC</label>
							<input type="text" class="form-control" name="imc_aten" id="imc_aten" placeholder="IMC" maxlength="30" readonly />
						</div>
						<div class="col-md-3 mb-3">
							<label for="orl_aten">ORL</label>
							<input type="text" class="form-control" name="orl_aten" id="orl_aten" maxlength="100" placeholder="ORL" maxlength="30"/>
						</div>						
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="mamas_aten">Mamas</label>
							<input type="text" class="form-control" name="mamas_aten" id="mamas_aten" placeholder="Mamas" maxlength="254"/>
						</div>					
					</div>						
					<div class="form-row">
						<div class="col-md-6 mb-3">
							<label for="pulmones">Pulmones</label>
							<input type="text" class="form-control" name="pulmones" id="pulmones" placeholder="Pulmones" maxlength="30"/>
						</div>
						<div class="col-md-6 mb-3">
							<label for="abdomen_aten">Abdódmen</label>
							<input type="text" class="form-control" name="abdomen_aten" id="abdomen_aten" placeholder="Abdómen" maxlength="30"/>
						</div>						
					</div>						
					<div class="form-row">
						<div class="col-md-3 mb-3">
							<label for="afu_aten">AFU</label>
							<input type="text" class="form-control" name="afu_aten" id="afu_aten" placeholder="AFU" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="fcf_aten">FCF</label>
							<input type="text" class="form-control" name="fcf_aten" id="fcf_aten" placeholder="FCF" maxlength="30"/>
						</div>	
						<div class="col-md-3 mb-3">
							<label for="au_aten">AU</label>
							<input type="text" class="form-control" name="au_aten" id="au_aten" placeholder="AU" maxlength="30"/>
						</div>
						<div class="col-md-3 mb-3">
							<label for="fm_aten">FM</label>
							<input type="text" class="form-control" name="fm_aten" id="fm_aten" maxlength="100" placeholder="FM" maxlength="30"/>
						</div>						
					</div>				
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="tbm_aten">Ginecologico</label>
							<div class="input-group">
							  <textarea id="ginecologico" name="ginecologico" placeholder="Ginecologico" class="form-control" maxlength="2000" rows="8"></textarea>	
							  <div class="input-group-prepend">						  
								<span class="input-group-text">
									<i class="btn btn-outline-success fas fa-microphone-alt" id="search_ginecologico_start"></i>
									<i class="btn btn-outline-success fas fa-microphone-slash" id="search_ginecologico_stop"></i>
								</span>
							  </div>								  
							</div>	
							<p id="charNum_ginecologico">1000 Caracteres</p>
						</div>						
					</div>						
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="extremidades">Extremidades</label>
							<input type="text" class="form-control" name="extremidades" id="extremidades" placeholder="Extremidades" maxlength="254"/>
						</div>					
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="ultrasonido">Ultrasonido</label>
							<input type="text" class="form-control" name="ultrasonido" id="ultrasonido" placeholder="Ultrasonido" maxlength="254"/>
						</div>					
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="diagnostico">Diagnóstico</label>
							<input type="text" class="form-control" name="diagnostico" id="diagnostico" placeholder="Diagnóstico" maxlength="254"/>
						</div>					
					</div>	
					<div class="form-row">
						<div class="col-md-12 mb-3">
							<label for="manejo">Tratamiento</label>
							<input type="text" class="form-control" name="tratamiento" id="tratamiento" placeholder="Tratamiento" maxlength="254"/>
						</div>					
					</div>	
				  </div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" form="formulario_primera_consulta" type="submit" id="regConsuta"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>	
			<button class="btn btn-warning ml-2" form="formulario_primera_consulta" type="submit" id="ediConsuta"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>	
		</div>	
	</div>
	<!-- FIN PRIMERA CONSULTA-->

	<!-- INICIO SEGUIMIENTO-->
	<div class="tab-pane fade" id="seguimiento" role="tabpanel" aria-labelledby="home-tab">
		<div class="modal-body">
			<form class="FormularioAjax" id="formulario_seguimiento" data-async data-target="#rating-modal" action="" method="POST" data-form="" autocomplete="off" enctype="multipart/form-data">		
					<button class="btn btn-warning ml-2" form="formulario_seguimiento" type="submit" id="nuevoSegimiento"><div class="sb-nav-link-icon"></div><i class="far fa-file"></i> Nuevo Registro</button>
					<br />
					<br />
					<input type="hidden" name="agenda_id" id="agenda_id" class="form-control">
					<input type="hidden" name="pacientes_id" id="pacientes_id" class="form-control">
					<input type="hidden" name="fecha_cita" id="fecha_cita" class="form-control">
					<input type="hidden" name="seguimiento_id" id="seguimiento_id" class="form-control">
					<div class="card">
					  <div class="card-header text-white bg-info mb-3" align="center">
						HOJA DE SEGUIMIENTO
					  </div>
					  <div class="card-body">
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="motivo_consulta_seguimiento">Motivo Consulta</label>
									<input type="text" class="form-control" name="motivo_consulta_seguimiento" id="motivo_consulta_seguimiento" placeholder="Motivo Consulta">
								</div>					
							</div>	
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="hist_enfe_actual">Historia Enfermedad Actual</label>
									<div class="input-group">
									  <textarea id="hist_enfe_actual_seguimiento" name="hist_enfe_actual_seguimiento" placeholder="Historia Enfermedad Actual" class="form-control" maxlength="2000" rows="8"></textarea>	
									  <div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_hist_enfe_actual_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_hist_enfe_actual_stop"></i>
										</span>
									  </div>								  
									</div>	
									<p id="charNum_hist_enfe_actual_seguimiento">2000 Caracteres</p>
								</div>						
							</div>	
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="diagnostico_seguimiento">Diagnóstico</label>
									<div class="input-group">
									  <textarea id="diagnostico_seguimiento" name="diagnostico_seguimiento" placeholder="Diagnóstico" class="form-control" maxlength="2000" rows="8"></textarea>	
									  <div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_diagnostico_seguimiento_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_diagnostico_seguimiento_stop"></i>
										</span>
									  </div>								  
									</div>	
									<p id="charNum_diagnostico_seguimiento">2000 Caracteres</p>
								</div>						
							</div>	
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="manejo_seguimiento">Manejo</label>
									<div class="input-group">
									  <textarea id="manejo_seguimiento" name="manejo_seguimiento" placeholder="Manejo" class="form-control" maxlength="2000" rows="8"></textarea>	
									  <div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_manejo_seguimiento_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_manejo_seguimiento_stop"></i>
										</span>
									  </div>								  
									</div>	
									<p id="charNum_manejo_seguimiento">2000 Caracteres</p>
								</div>						
							</div>	
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="receta_estudio_seguimiento">Receta de Estudio</label>
									<div class="input-group">
									  <textarea id="receta_estudio_seguimiento" name="receta_estudio_seguimiento" placeholder="Receta de Estudio" class="form-control" maxlength="2000" rows="8"></textarea>	
									  <div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_receta_estudio_seguimiento_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_receta_estudio_seguimiento_stop"></i>
										</span>
									  </div>								  
									</div>	
									<p id="charNum_receta_estudio_seguimiento">2000 Caracteres</p>
								</div>						
							</div>
							<div class="form-row">
								<div class="col-md-12 mb-3">
									<label for="receta_medicamentos_seguimiento">Receta de Medicamentos</label>
									<div class="input-group">
									  <textarea id="receta_medicamentos_seguimiento" name="receta_medicamentos_seguimiento" placeholder="Receta de Medicamentos" class="form-control" maxlength="2000" rows="8"></textarea>	
									  <div class="input-group-prepend">						  
										<span class="input-group-text">
											<i class="btn btn-outline-success fas fa-microphone-alt" id="search_receta_medicamentos_seguimiento_start"></i>
											<i class="btn btn-outline-success fas fa-microphone-slash" id="search_receta_medicamentos_seguimiento_stop"></i>
										</span>
									  </div>								  
									</div>	
									<p id="charNum_receta_medicamentos_seguimiento">2000 Caracteres</p>
								</div>						
							</div>					
								
					  </div>
					</div>

					<div class="card">
					  <div class="card-header text-white bg-info mb-3" align="center">
						ARCHIVOS
					  </div>
					  <div class="card-body">
						<div class="form-row">
							<div class="col-md-6 mb-3">
								<input type="file" class="form-control" id="files" name="files[]" multiple accept=".jpg, .png, .pdf"/>
							</div>				
					  </div>
					</div>	
					
				</div>				
			</form>
		</div>
		<div class="modal-footer">
			<button class="btn btn-primary ml-2" form="formulario_seguimiento" type="submit" id="regSeg"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Registrar</button>
			<button class="btn btn-warning ml-2" form="formulario_seguimiento" type="submit" id="ediSeg"><div class="sb-nav-link-icon"></div><i class="far fa-save fa-lg"></i> Editar</button>				
		</div>			
	</div>
	<!-- FIN SEGUIMIENTO-->        

</div>
<!-- FIN TAB CONTENT-->
<br>