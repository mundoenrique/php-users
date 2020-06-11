<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3">Perfil de usuario</h1>
<hr class="separador-one">
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="" method="post" class ="hide-out hide bg-color">
	<h4 class="mt-2 pb-2 h4">Datos personales</h4>
		<div class="row">
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="idType">Tipo de identificación</label>
				<input id="idType" class="form-control" type="text" name="idType"
					value="Cédula de Identidad" readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="idNumber">Número de identificación</label>
				<input id="idNumber" class="form-control" type="text" name="idNumber" value="12953451"
					readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="firstName">Primer nombre</label>
				<input id="firstName" class="form-control" type="text" name="firstName" value="Caldera"
					readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="middleName">Segundo nombre</label>
				<input id="middleName" class="form-control" type="text" name="middleName" value="Qwdw"
					readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="lastName">Primer apellido</label>
				<input id="lastName" class="form-control" type="text" name="lastName" value="Anny"
					readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="secondSurname">Segundo apellido</label>
				<input id="secondSurname" class="form-control" type="text" name="secondSurname"
					value="Loren" readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="birthDate">Fecha de nacimiento</label>
				<input id="birthDate" class="form-control hasDatepicker" type="text" name="birthDate"
					value="01/01/1982" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label class="block">Sexo</label>
				<div class="custom-control custom-radio custom-control-inline">
					<input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M"
							autocomplete="off">
					<label class="custom-control-label" for="genderMale">Masculino</label>
				</div>
				<div class="custom-control custom-radio custom-control-inline">
					<input id="genderFemale" class="custom-control-input" type="radio" name="gender"
							value="F" checked="" autocomplete="off">
					<label class="custom-control-label" for="genderFemale">Femenino</label>
				</div>
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="profession">Profesión</label>
				<select id="profession" class="custom-select form-control" name="profession">
					<option value="">Selecciona</option>
					<option value="1">Abogado</option>
					<option value="2">Actor</option>
					<option value="3" selected="">Agente</option>
					<option value="4">Arquitecto</option>
					<option value="5">Astronomo</option>
					<option value="6">Asesor</option>
					<option value="7">Autor</option>
					<option value="8">Barrendero</option>
					<option value="9">Bibliotecario</option>
					<option value="10">Bombero</option>
					<option value="11">Cartero</option>
					<option value="12">Carnicero</option>
					<option value="13">Carpintero</option>
					<option value="14">Cientifico</option>
					<option value="15">Cirujano</option>
					<option value="16">Conductor</option>
					<option value="17">Contador</option>
					<option value="18">Corredor</option>
					<option value="19">Chef</option>
					<option value="20">Dentista</option>
					<option value="21">Disenador</option>
					<option value="22">Doctor</option>
					<option value="23">Economista</option>
					<option value="24">Electricista</option>
					<option value="25">Enfermero</option>
					<option value="26">Estilista</option>
					<option value="27">Farmaceutico</option>
					<option value="28">Fontanero</option>
					<option value="29">Florista</option>
					<option value="30">Fotografo</option>
					<option value="31">Plomero</option>
					<option value="32">Granjero</option>
					<option value="33">Ingeniero</option>
					<option value="34">Jardinero</option>
					<option value="35">Juez</option>
					<option value="36">Mensajero</option>
					<option value="37">Locutor</option>
					<option value="38">Limpiador</option>
					<option value="39">Maestro de construccion</option>
					<option value="40">Mecanico</option>
					<option value="41">Mesero</option>
					<option value="42">Modelo</option>
					<option value="43">Oftalmologo</option>
					<option value="44">Panadero</option>
					<option value="45">Periodista</option>
					<option value="46">Pescador</option>
					<option value="47">Pintor</option>
					<option value="48">Piloto</option>
					<option value="49">Policia</option>
					<option value="50">Politico</option>
					<option value="51">Profesor</option>
					<option value="52">Psiquiatra</option>
					<option value="53">Recepcionista</option>
					<option value="54">Salvavidas</option>
					<option value="55">Sastre</option>
					<option value="56">Secretario</option>
					<option value="57">Soldado</option>
					<option value="58">Taxista</option>
					<option value="59">Trabajador</option>
					<option value="60">Traductor</option>
					<option value="61">Vendedor</option>
					<option value="62">Veterinario</option>
					<option value="63">Licenciado</option>
					<option value="64">Ingeniero</option>
				</select>
				<div class="help-block"></div>
			</div>
		</div>
		<hr class="separador-one mt-2 mb-4">
		<h4 class="pb-2 h4">Datos de contacto</h4>
		<div class="row">
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="addressType">Tipo de dirección</label>
				<select id="addressType" class="custom-select form-control" name="addressType">
						<option value="">Selecciona</option>
						<option value="1" selected="">Domicilio</option>
						<option value="2">Laboral</option>
						<option value="3">Comercial</option>
				</select>
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="postalCode">Código postal</label>
				<input id="postalCode" class="form-control" type="text" name="postalCode" value="102356"
						autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="department">Departamento</label>
				<select id="department" class="custom-select form-control" name="department">
					<option value="">Selecciona</option>
					<option value="100">Amazonas</option>
					<option value="200">Anzoategui</option>
					<option value="300">Apure</option>
					<option value="400">Aragua</option>
					<option value="500">Barinas</option>
					<option value="600">Bolivar</option>
					<option value="700">Carabobo</option>
					<option value="800">Cojedes</option>
					<option value="900">Delta Amacuro</option>
					<option value="1000" selected="">Distrito Capital</option>
					<option value="1100">Falcon</option>
					<option value="2300">Gran Caracas</option>
					<option value="1200">Guarico</option>
					<option value="1300">Lara</option>
					<option value="1400">Merida</option>
					<option value="1500">Miranda</option>
					<option value="1600">Monagas</option>
					<option value="3000">N/a</option>
					<option value="1700">Nueva Esparta</option>
					<option value="1800">Portuguesa</option>
					<option value="1900">Sucre</option>
					<option value="2000">Tachira</option>
					<option value="2100">Trujillo</option>
					<option value="2200">Vargas</option>
					<option value="2400">Yaracuy</option>
					<option value="2500">Zulia</option>
					</select>
					<div class="help-block"></div>
			</div>
			<div id="ctrlCity" class="form-group col-6 col-lg-4 col-xl-3">
				<label for="city">Ciudad</label>
				<select id="city" class="custom-select form-control" name="city">
					<option value="">Selecciona</option>
					<option value="1001" selected="">Caracas</option>
					<option value="1002">El Junquito</option>
				</select>
				<div class="help-block"></div>
			</div>
			<div class="form-group col-12 col-lg-8 col-xl-12">
				<label for="address">Dirección</label>
				<textarea id="address" class="form-control"
					name="address">CENTRO COMERCIAL SANTA FÉ Locales 3-138, 3-139 y 3-140; 3er Piso-Plaza Italia</textarea>
				<div class="help-block"></div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="landLine">Teléfono fijo</label>
				<input id="landLine" class="form-control" type="text" name="landLine" value="58426487874"
					autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="mobilePhone">Teléfono móvil</label>
				<input id="mobilePhone" class="form-control" type="text" name="mobilePhone"
					value="58426487878" readonly="readonly" autocomplete="off">
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
						<input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum"
								value="" autocomplete="off">
						<div class="help-block"></div>
					</div>
				</div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="email">Correo electrónico</label>
				<input id="email" class="form-control" type="email" name="email"
					value="grobles@novopayment.com" placeholder="usuario@ejemplo.com" readonly="readonly"
					autocomplete="off">
				<div class="help-block"></div>
			</div>
		</div>
		<hr class="separador-one mt-2 mb-4">
		<h4 class="pb-2 h4">Datos de usuario</h4>
		<div class="row">
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="username">Login</label>
				<input id="username" class="form-control" type="text" name="username" value="ANNY123"
					readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label for="creationDate">Fecha de creación</label>
				<input id="creationDate" class="form-control" type="text" name="creationDate"
					value="11/05/2017" readonly="readonly" autocomplete="off">
				<div class="help-block"></div>
			</div>
			<div class="form-group col-6 col-lg-4 col-xl-3">
				<label class="block">Notificaciones</label>
				<div class="custom-control custom-switch custom-control-inline">
					<input id="notificationsEmail" class="custom-control-input" type="checkbox"
						name="notificationsEmail" checked="">
					<label class="custom-control-label" for="notificationsEmail">Correo electrónico
					</label>
				</div>
				<div class="custom-control custom-switch custom-control-inline">
					<input id="notificationsSms" class="custom-control-input" type="checkbox"
						name="notificationsSms" checked="">
					<label class="custom-control-label" for="notificationsSms">SMS
					</label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-6 col-lg-4 col-xl-3">
					<a class="btn btn-small btn-link px-0 hyper-link"
					href="">Cambiar contraseña</a>
			</div>
			<div class="col-6 col-lg-4 col-xl-3">
				<a class="btn btn-small btn-link px-0 hyper-link"
					href="">Cambiar clave
					Operaciones</a>
			</div>
			<div class="col-6 col-lg-4 col-xl-3">
				<a class="btn btn-small btn-link px-0 hyper-link"
					href="">Cambiar clave SMS</a>
			</div>
		</div>
		<hr class="separador-one mt-2 mb-4">
		<div class="flex items-center justify-end">
			<a class="btn btn-small btn-link"
				href="">Cancelar</a>
			<button id="btnActualizar" class="btn btn-small btn-loading btn-primary" type="submit"
				name="btnActualizar">Continuar</button>
		</div>
</form>
