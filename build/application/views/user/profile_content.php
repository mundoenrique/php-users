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
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="profesion">Profesión</label>
								<select id="profesion" class="custom-select form-control" name="profesion" placeholder="Seleccione">
								<option selected="" value="63">Licenciado</option><option value="3"> Agente
									</option><option value="1"> Abogado
									</option><option value="2"> Actor
									</option><option value="4"> Arquitecto </option><option value="5"> Astronomo </option><option value="6"> Asesor </option><option value="7"> Autor </option><option value="8"> Barrendero </option><option value="9"> Bibliotecario </option><option value="10"> Bombero </option><option value="11"> Cartero </option><option value="12"> Carnicero </option><option value="13"> Carpintero </option><option value="14"> Cientifico </option><option value="15"> Cirujano </option><option value="16"> Conductor </option><option value="17"> Contador </option><option value="18"> Corredor </option><option value="19"> Chef </option><option value="20"> Dentista  </option><option value="21"> Disenador </option><option value="22"> Doctor </option><option value="23"> Economista </option><option value="24"> Electricista  </option><option value="25"> Enfermero </option><option value="26"> Estilista  </option><option value="27"> Farmaceutico </option><option value="28"> Fontanero </option><option value="29"> Florista  </option><option value="30"> Fotografo </option><option value="31"> Plomero </option><option value="32"> Granjero </option><option value="33"> Ingeniero </option><option value="34"> Jardinero </option><option value="35"> Juez </option><option value="36"> Mensajero </option><option value="37"> Locutor </option><option value="38"> Limpiador </option><option value="39"> Maestro de construccion  </option><option value="40"> Mecanico </option><option value="41"> Mesero </option><option value="42"> Modelo </option><option value="43"> Oftalmologo  </option><option value="44"> Panadero </option><option value="45"> Periodista  </option><option value="46"> Pescador </option><option value="47"> Pintor </option><option value="48"> Piloto  </option><option value="49"> Policia  </option><option value="50"> Politico  </option><option value="51"> Profesor </option><option value="52"> Psiquiatra  </option><option value="53"> Recepcionista  </option><option value="54"> Salvavidas  </option><option value="55"> Sastre  </option><option value="56"> Secretario </option><option value="57"> Soldado  </option><option value="58"> Taxista  </option><option value="59"> Trabajador </option><option value="60"> Traductor </option><option value="61"> Vendedor </option><option value="62"> Veterinario </option><option value="64"> Ingeniero </option>
								</select>
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<h3 class="tertiary h4">Datos de contacto</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="addressType">Tipo de dirección</label>
								<select id="addressType" class="custom-select form-control" name="addressType" placeholder="Seleccione">
									<option value="">Seleccione</option>
                  <option value="1">Domicilio</option>
                  <option value="2">Laboral</option>
									<option value="3">Comercial</option>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="postalCode">Código postal</label>
								<input id="postalCode" class="form-control" type="text" name="postalCode" value=""/>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="country">País</label>
								<input id="country" class="form-control" type="text" name="country" value="" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="department">Departamento</label>
								<select id="department" class="custom-select form-control" name="department" placeholder="Seleccione">
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="city">Ciudad</label>
								<select id="city" class="custom-select form-control" name="city" placeholder="Seleccione">
								</select>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-12 col-lg-8 col-xl-6">
								<label for="address">Dirección</label>
								<textarea id="address" class="form-control"></textarea>
								<div class="help-block"></div>
							</div>
						</div>
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
								<label for="state">Otro Teléfono (Tipo)</label>
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
