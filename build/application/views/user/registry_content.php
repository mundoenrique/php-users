
<div id="registry" class="registro-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Afiliación de Datos</h2>
				<p>Para obtener tu usuario de <strong>Conexión Personas</strong>, es necesario que ingreses los datos requeridos a continuación:</p>
				<hr class="separador-one">
				<div class="pt-3">
					<form method="post" id="formRegistry">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" name="idType" type="text"  disabled value="<?= $data->user->tipo_id_ext_per;?>">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" name="idNumber" type="text"  disabled value="<?= $data->user->id_ext_per;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" name="firstName" type="text"  disabled class="form-control" value="<?= $data->user->primerNombre;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control"  disabled name="middleName" type="text" value="<?= $data->user->segundoNombre;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" name="lastName"  disabled type="text" class="form-control" value="<?= $data->user->primerApellido;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" name="secondSurname"  disabled type="text" class="form-control" value="<?= $data->user->segundoApellido;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="birthDate">Fecha de Nacimiento</label>
								<input type="text" id="birthDate" name="birthDate" class="form-control">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Sexo</label>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="genderMale" name="gender" class="custom-control-input" value="M">
									<label class="custom-control-label" for="genderMale">Masculino</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="genderFemale" name="gender" class="custom-control-input" value="F">
									<label class="custom-control-label" for="genderFemale">Femenino</label>
								</div>
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<h3 class="tertiary h4">Datos de contacto</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo Electrónico</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" value="<?= $data->afiliacion->correo?>">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="confirmEmail">Confirmar Correo Electrónico</label>
								<input type="email" class="form-control" id="confirmEmail" name="confirmEmail" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" name="landLine" type="text" class="form-control" value="<?= $data->afiliacion->telefono1?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" name="mobilePhone" type="text" value="<?= $data->user->telefono?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhone">Otro Teléfono (Tipo)</label>
								<select class="custom-select form-control" placeholder="Seleccione" name="phoneType" id="phoneType">
									<option value="OFC">Laboral</option>
									<option value="FAX">Fax</option>
									<option value="OTRO">Otro</option>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhoneNum">Otro Teléfono (Número)</label>
								<input id="otherPhoneNum" name="otherPhoneNum" type="text" class="form-control" value="<?= $data->afiliacion->telefono3?>"/>
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="row">
							<div class="col-6 col-lg-8 col-xl-6">
								<h3 class="tertiary h4">Datos de usuario</h3>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="username">Usuario</label>
										<input type="text" class="form-control" id="username" name="username">
										<div class="help-block"></div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="userpwd">Contraseña</label>
										<div class="input-group">
											<input id="userpwd" class="form-control" type="password" name="userpwd">
											<div class="input-group-append">
												<span id="pwdAddon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
											</div>
										</div>
										<div class="help-block"></div>
									</div>
									<div class="form-group col-12 col-lg-6">
										<label for="confirmUserpwd">Confirmar Contraseña</label>
										<input type="password" class="form-control" id="confirmUserpwd" name="confirmUserpwd">
										<div class="help-block"></div>
									</div>
								</div>
							</div>

							<div class="col-6 col-lg-4 col-xl-6">
								<div class="field-meter" id="password-strength-meter">
									<h4>Requerimientos de contraseña:</h4>
									<ul class="pwd-rules">
										<li id="length" class="pwd-rules-item rule-invalid">De 8 a 15 <strong>Caracteres</strong></li>
										<li id="letter" class="pwd-rules-item rule-invalid">Al menos una <strong>letra minúscula</strong>
										</li>
										<li id="capital" class="pwd-rules-item rule-invalid">Al menos una <strong>letra mayúscula</strong>
										</li>
										<li id="number" class="pwd-rules-item rule-invalid">De 1 a 3 <strong>números</strong></li>
										<li id="especial" class="pwd-rules-item rule-invalid">Al menos un <strong>caracter especial</strong><br />(ej: ! @ ? + - . , #)</li>
										<li id="consecutivo" class="pwd-rules-item rule-invalid">No debe tener más de 2 <strong>caracteres</strong> iguales consecutivos</li>
									</ul>
								</div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="flex items-center justify-end">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnRegistrar" name="btnRegistrar" class="btn btn-small btn-loading btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<?php
	$data =json_encode([
		'code_tipo_id_ext_per' => $data->user->tipo_id_ext_per,
		'tipo_id_ext_per' => $data->user->tipo_id_ext_per,
		'paisUser' => $data->pais
	]);
?>
<script>
	var data = <?= $data ?>;
</script>
