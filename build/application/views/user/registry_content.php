<div id="registry" class="registro-content h-content bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Afiliación de datos</h2>
				<p>Para obtener tu usuario de <strong><?= lang('GEN_SYSTEM_NAME'); ?></strong>, es necesario que ingreses los datos requeridos a continuación:</p>
				<hr class="separador-one">
				<div class="pt-3">
					<span>Los campos con  <span class="danger">*</span> son requeridos.</span>
					<form id="formRegistry" class="mt-2" method="post">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" type="text" name="idType" value="<?= $data->user->descripcion_tipo_id_ext_per;?>" disabled>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $data->user->id_ext_per;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" class="form-control" type="text" name="firstName" value="<?= $data->user->primerNombre;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control" type="text" name="middleName" value="<?= $data->user->segundoNombre;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" class="form-control" type="text" name="lastName" value="<?= $data->user->primerApellido;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" class="form-control" type="text" name="secondSurname" value="<?= $data->user->segundoApellido;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="birthDate">Fecha de nacimiento <span class="danger">*</span></label>
								<input id="birthDate" class="form-control" name="birthDate" type="text">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Sexo <span class="danger">*</span></label>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M">
									<label class="custom-control-label" for="genderMale">Masculino</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F">
									<label class="custom-control-label" for="genderFemale">Femenino</label>
								</div>
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<h3 class="tertiary h4">Datos de contacto</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo electrónico <span class="danger">*</span></label>
								<input id="email" class="form-control" type="email" name="email" value="<?= $data->afiliacion->correo?>" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="confirmEmail">Confirmar correo electrónico <span class="danger">*</span></label>
								<input id="confirmEmail" class="form-control" type="email" name="confirmEmail" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" class="form-control" type="text" name="landLine" value="<?= $data->afiliacion->telefono1?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= $data->user->telefono?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="col-6 col-lg-4 col-xl-3">
								<label for="otherPhoneNum">Otro teléfono</label>
								<div class="form-row">
									<div class="form-group col-6">
										<select id="phoneType" class="custom-select form-control" name="phoneType">
											<option value="">Selecciona</option>
											<option value="OFC">Laboral</option>
											<option value="FAX">Fax</option>
											<option value="OTRO">Otro</option>
										</select>
										<div class="help-block"></div>
									</div>
									<div class="form-group col-6">
										<input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value="<?= $data->afiliacion->telefono3?>"/>
										<div class="help-block"></div>
									</div>
								</div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="row">
							<div class="col-6 col-lg-8 col-xl-6">
								<h3 class="tertiary h4">Datos de usuario</h3>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="username">Usuario <span class="danger">*</span></label>
										<input id="username" class="form-control" type="text" name="username">
										<div class="help-block"></div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="userpwd">Contraseña <span class="danger">*</span></label>
										<div class="input-group">
											<input id="userpwd" class="form-control" type="password" name="userpwd">
											<div class="input-group-append">
												<span id="pwdAddon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
											</div>
										</div>
										<div class="help-block"></div>
									</div>
									<div class="form-group col-12 col-lg-6">
										<label for="confirmUserpwd">Confirmar contraseña <span class="danger">*</span></label>
										<div class="input-group">
											<input id="confirmUserpwd" class="form-control" type="password" name="confirmUserpwd">
											<div class="input-group-append">
												<span id="pwdAddon2" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
											</div>
										</div>
										<div class="help-block"></div>
									</div>
								</div>
							</div>

							<div class="col-6 col-lg-4 col-xl-6">
								<div id="password-strength-meter" class="field-meter">
									<h4>Requerimientos de contraseña:</h4>
									<ul class="pwd-rules">
										<li id="length" class="pwd-rules-item rule-invalid">De 8 a 15 <strong>caracteres.</strong></li>
										<li id="letter" class="pwd-rules-item rule-invalid">Al menos una <strong>letra minúscula.</strong>
										</li>
										<li id="capital" class="pwd-rules-item rule-invalid">Al menos una <strong>letra mayúscula.</strong>
										</li>
										<li id="number" class="pwd-rules-item rule-invalid">De 1 a 3 <strong>números.</strong></li>
										<li id="especial" class="pwd-rules-item rule-invalid">Al menos un <strong>carácter especial </strong>(ej: ! @ ? + - . , #).</li>
										<li id="consecutivo" class="pwd-rules-item rule-invalid">No debe tener más de 2 <strong>caracteres</strong> iguales consecutivos.</li>
									</ul>
								</div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="flex items-center justify-end">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnRegistrar" class="btn btn-small btn-loading btn-primary" type="submit" name="btnRegistrar">Continuar</button>
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
		'paisUser' => $data->pais,
		'acceptTerms' => $data->user->tyc,
		'acCodCia' => $data->user->acCodCia,
	]);
?>
<script>
	var dataRegistryFrm = <?= $data ?>;
</script>
