<div id="registry" class="registro-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Perfil de Usuario</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<div class="pt-3">
					<form method="post" id="formRegistry">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" name="idType" type="text" value="" disabled>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" name="idNumber" type="text" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" class="form-control" name="firstName" type="text" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control"  name="middleName" type="text" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" class="form-control" name="lastName" type="text" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" name="secondSurname" class="form-control" type="text" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="birthDate">Fecha de Nacimiento</label>
								<input id="birthDate" class="form-control" type="text" name="birthDate">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Sexo</label>
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
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" class="form-control" type="text" name="landLine" value=""/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhone">Otro Teléfono (Tipo)</label>
								<select id="phoneType" class="custom-select form-control" name="phoneType" placeholder="Seleccione">
									<option value="OFC">Laboral</option>
									<option value="FAX">Fax</option>
									<option value="OTRO">Otro</option>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhoneNum">Otro Teléfono (Número)</label>
								<input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value=""/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo Electrónico</label>
								<input id="email" class="form-control" type="email" name="email" value="" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<h3 class="tertiary h4">Datos de usuario</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="username">Login</label>
								<input id="username" class="form-control" type="text" name="username" value="" disabled>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="creationDate">Fecha de creación</label>
								<input id="creationDate" class="form-control" type="text" name="creationDate" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Notificaciones</label>
								<div class="custom-control custom-switch custom-control-inline">
									<input id="notificationsEmail" class="custom-control-input" type="checkbox" name="notificationsEmail">
									<label class="custom-control-label" for="notificationsEmail">Correo electrónico
									</label>
								</div>
								<div class="custom-control custom-switch custom-control-inline">
									<input id="notificationsSms" class="custom-control-input" type="checkbox" name="notificationsSms">
									<label class="custom-control-label" for="notificationsSms">SMS
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label>Contraseña</label>
								<p class="primary"><a href="<?= base_url('cambiarclave');?>">Ir a la configuración </a></p>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label>Clave de Operaciones</label>
								<p class="primary"><a href="<?= base_url('cambiarclave');?>">Ir a la configuración </a></p>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label>Clave SMS</label>
								<p class="primary"><a href="<?= base_url('cambiarclave');?>">Ir a la configuración </a></p>
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
<script>
</script>
