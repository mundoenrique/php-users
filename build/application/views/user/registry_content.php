<div id="registry" class="registro-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
<!-- 			<pre>
				<?php //var_dump($data->dataUser->logAccesoObject->userName); ?>
			</pre> -->
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Afiliación de Datos</h2>
				<p>Para obtener su usuario de <strong>Conexión Personas</strong>, es necesario ingrese los datos requeridos a continuación:</p>
				<div class="border-top pt-4">
					<form method="post" id="formRegistry">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" name="idType" type="text" readonly="readonly"  value="<?= $data->dataUser->user->tipo_id_ext_per;?>">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" name="idNumber" type="text" readonly="readonly"  value="<?= $data->dataUser->user->id_ext_per;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" name="firstName" type="text" placeholder="Primer nombre" class="form-control" value="<?= $data->dataUser->user->primerNombre;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control" name="middleName" type="text" value="<?= $data->dataUser->user->segundoNombre;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" name="lastName" type="text" placeholder="Apellido paterno" class="form-control"  value="<?= $data->dataUser->user->primerApellido;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" name="secondSurname" type="text" class="form-control"  value="<?= $data->dataUser->user->segundoApellido;?>"/>
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

						<h3 class="tertiary h4">Datos de contacto</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo Electrónico</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com" value="<?= $data->dataUser->afiliacion->correo?>">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="confirmEmail">Confirmar Correo Electrónico</label>
								<input type="email" class="form-control" id="confirmEmail" name="confirmEmail" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" name="landLine" type="text" class="form-control" value="<?= $data->dataUser->afiliacion->telefono1?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" name="mobilePhone" type="text" value="<?= $data->dataUser->afiliacion->telefono2?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhone">Otro Teléfono (Tipo)</label>
								<select class="bg-secondary custom-select" placeholder="Seleccione" name="phoneType" id="phoneType">
									<option value="OFC">Laboral</option>
									<option value="FAX">Fax</option>
									<option value="OTRO">Otro</option>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhoneNum">Otro Teléfono (Número)</label>
								<input id="otherPhoneNum" name="otherPhoneNum" type="text" class="form-control"/>
								<div class="help-block"></div>
							</div>
						</div>

						<h3 class="tertiary h4">Datos de usuario</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="username">Usuario</label>
								<input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="userpwd">Contraseña</label>
								<input type="password" class="form-control" id="userpwd" name="userpwd" placeholder="Contraseña">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="confirmUserpwd">Confirmar Contraseña</label>
								<input type="password" class="form-control" id="confirmUserpwd" name="confirmUserpwd" placeholder="Confirmar Contraseña">
								<div class="help-block"></div>
							</div>
						</div>

						<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnRegistrar" name="btnRegistrar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
