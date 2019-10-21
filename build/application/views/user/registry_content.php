<!-- FORMULARIO REGISTRO FASE II -->
<div id="preRegistry" class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Verificación de Cuenta</h2>
				<p>Si usted aún no posee usuario para accesar al sistema <strong>Conexión Personas</strong>, a continuación debe
					proporcionar los siguientes datos relacionados con su cuenta:</p>
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="formVerifyAccount">
						<div class="row">
							<div class="form-group col-lg-auto">
								<label for="documentID">Documento de Identidad <abbr title="Número de identificación del tarjetahabiente"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="documentID" class="form-control" name="documentID" type="text">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-auto">
								<label for="telephoneNumber">Número de teléfono <abbr title="Introduce la clave secreta o PIN de tu tarjeta"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="telephoneNumber" class="form-control" name="telephoneNumber" type="text">
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group form-check mt-4 mb-3">
							<input id="acceptTerms" class="form-check-input" type="checkbox" name="acceptTerms">
							<label class="form-check-label" for="acceptTerms">
								Acepto las <a class="" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
							<div class="help-block"></div>
						</div>
						<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnValidar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- FORMULARIO REGISTRO FASE II -->
<div id="postRegistry" class="registro-content h-100 bg-white none">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Afiliación de Datos</h2>
				<p>Para obtener su usuario de <strong>Conexión Personas</strong>, es necesario ingrese los datos requeridos a continuación:</p>
				<div class="border-top pt-4">
					<form method="post" id="form-validar">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" name="idType" type="text" readonly="readonly">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" name="idNumber" type="text" readonly="readonly"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" name="firstName" type="text" placeholder="Primer nombre" class="form-control"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control" name="middleName" type="text"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" name="lastName" type="text" placeholder="Apellido paterno" class="form-control"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" name="secondSurname" type="text" class="form-control"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label>Fecha de Nacimiento</label>
								<div class="form-row align-items-center">
									<div class="col-3">
										<input maxlength="2" id="day" class="form-control" name="day" type="text" placeholder="Dia">
									</div>
										<div class="col-6">
											<select class="bg-secondary custom-select" placeholder="Mes" name="month" id="month">
												<option value="01">Enero</option>
												<option value="02">Febrero</option>
												<option value="03">Marzo</option>
												<option value="04">Abril</option>
												<option value="05">Mayo</option>
												<option value="06">Junio</option>
												<option value="07">Julio</option>
												<option value="08">Agosto</option>
												<option value="09">Septiembre</option>
												<option value="10">Octubre</option>
												<option value="11">Noviembre</option>
												<option value="12">Diciembre</option>
											</select>
										</div>
										<div class="col-3">
											<input maxlength="4" id="year" name="year" type="text" placeholder="Año" class="form-control">
										</div>
								</div>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
                <label class="block">Sexo</label>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="genderMale" name="gender" class="custom-control-input">
									<label class="custom-control-label" for="genderMale">Masculino</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="genderFemale" name="gender" class="custom-control-input">
									<label class="custom-control-label" for="genderFemale">Femenino</label>
								</div>
								<div class="help-block"></div>
							</div>
						</div>

						<h3 class="tertiary h4">Datos de contacto</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo Electrónico</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="confirmEmail">Confirmar Correo Electrónico</label>
								<input type="email" class="form-control" id="confirmEmail" name="confirmEmail" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" name="landLine" type="text" placeholder="Primer nombre" class="form-control"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" name="mobilePhone" type="text"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhone">Otro Teléfono (Tipo)</label>
								<select class="bg-secondary custom-select" placeholder="Seleccione" name="otherPhone" id="otherPhone">
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
							<button id="validar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
