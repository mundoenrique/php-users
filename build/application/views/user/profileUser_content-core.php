<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3 pl-2"><?= lang('GEN_PROFILE_TITLE')?></h1>
<hr class="separador-one">
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="profileUser" method="post" class="hide-out hide bg-color p-2">
	<h4 class="mt-2 pb-2 h4"><?= lang('GEN_PROFILE_DATA_PERSONAL')?></h4>
	<div class="row">
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="idType"><?= lang('GEN_PROFILE_ID_TYPE')?></label>
			<input id="idType" class="form-control" type="text" name="idType" value="<?= $idTypeCodeText; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="idNumber"><?= lang('GEN_PROFILE_ID_NUMBER')?></label>
			<input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idNumber ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="firstName"><?= lang('GEN_PROFILE_FIRSTNAME')?></label>
			<input id="firstName" class="form-control" type="text" name="firstName" value="<?= $firstName; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="middleName"><?= lang('GEN_PROFILE_MIDDLENAME')?></label>
			<input id="middleName" class="form-control" type="text" name="middleName" value="<?= $middleName; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="lastName"><?= lang('GEN_PROFILE_LASTNAME')?></label>
			<input id="lastName" class="form-control" type="text" name="lastName" value="<?= $lastName; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="secondSurname"><?= lang('GEN_PROFILE_SURNAME')?></label>
			<input id="secondSurname" class="form-control" type="text" name="secondSurname" value="<?= $secondSurname; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="birthDate"><?= lang('GEN_PROFILE_BIRTHDATE')?></label>
			<input id="birthDate" class="form-control" type="text" name="birthDate" value="<?= $birthday; ?>" readonly autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label class="block"><?= lang('GEN_PROFILE_SEX')?></label>
			<div class="custom-control custom-radio custom-control-inline">
				<input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off" <?= $gender == 'M' ? 'checked' :''; ?> disabled>
				<label class="custom-control-label" for="genderMale">Masculino</label>
			</div>
			<div class="custom-control custom-radio custom-control-inline">
				<input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off" <?= $gender == 'F' ? 'checked' :''; ?> disabled>
				<label class="custom-control-label" for="genderFemale">Femenino</label>
			</div>
			<div class="help-block"></div>
		</div>
		<?php if (lang('CONF_PROFESSION') == 'ON'):  ?>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="profession"><?= lang('GEN_PROFILE_PROFESSION')?></label>
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
		<?php endif; ?>
	</div>
	<hr class="separador-one mt-2 mb-4">
	<h4 class="pb-2 h4"><?= lang('GEN_PROFILE_DATA_CONTACT')?></h4>
	<?php if(lang('CONF_CONTAC') == 'ON'): ?>
	<div class="row">
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="addressType"><?= lang('GEN_PROFILE_ADDRESS_TYPE')?></label>
			<select id="addressType" class="custom-select form-control" name="addressType">
				<option value="">Selecciona</option>
				<option value="1" selected="">Domicilio</option>
				<option value="2">Laboral</option>
				<option value="3">Comercial</option>
			</select>
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="postalCode"><?= lang('GEN_PROFILE_POSTAL_CODE')?></label>
			<input id="postalCode" class="form-control" type="text" name="postalCode" value="102356" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="department"><?= lang('GEN_PROFILE_STATE')?></label>
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
			<label for="city"><?= lang('GEN_PROFILE_CITY')?></label>
			<select id="city" class="custom-select form-control" name="city">
				<option value="">Selecciona</option>
				<option value="1001" selected="">Caracas</option>
				<option value="1002">El Junquito</option>
			</select>
			<div class="help-block"></div>
		</div>
		<div class="form-group col-12 col-lg-8 col-xl-12">
			<label for="address"><?= lang('GEN_PROFILE_ADDRESS')?></label>
			<textarea id="address" class="form-control"
				name="address">CENTRO COMERCIAL SANTA FÉ Locales 3-138, 3-139 y 3-140; 3er Piso-Plaza Italia</textarea>
			<div class="help-block"></div>
		</div>
	</div>
	<?php endif; ?>
	<div class="row">
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="landLine"><?= lang('GEN_PROFILE_PHONE_LANDLINE')?></label>
			<input id="landLine" class="form-control" type="text" name="landLine" value="<?= $landLine; ?>" readonly autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="mobilePhone"><?= lang('GEN_PROFILE_PHONE_MOBILE')?></label>
			<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= $mobilePhone; ?>" readonly autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="col-6 col-lg-4 col-xl-3">
			<label for="otherPhoneNum"><?= lang('GEN_PROFILE_PHONE_OTHER')?></label>
			<div class="form-row">
				<?php if (lang('CONF_SELECT_OTHER_PHONE') == 'ON'): ?>
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
					<input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value="<?= $otherPhoneNum; ?>" autocomplete="off">
					<div class="help-block"></div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="email"><?= lang('GEN_PROFILE_EMAIL')?></label>
			<input id="email" class="form-control" type="email" name="email" value="<?= $email; ?>" placeholder="usuario@ejemplo.com" readonly
				autocomplete="off">
			<div class="help-block"></div>
		</div>
	</div>
	<hr class="separador-one mt-2 mb-4">
	<h4 class="pb-2 h4"><?= lang('GEN_PROFILE_DATA_USER')?></h4>
	<div class="row">
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="username"><?= lang('GEN_PROFILE_USERNAME')?></label>
			<input id="username" class="form-control" type="text" name="username" value="<?= $nickName; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="creationDate"><?= lang('GEN_PROFILE_DATE_REGISTRY')?></label>
			<input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $creationDate; ?>" readonly="readonly" autocomplete="off">
			<div class="help-block"></div>
		</div>

		<?php if (lang('CONF_SELECT_NOTIFICATIONS') == 'ON'): ?>	
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label class="block"><?= lang('GEN_PROFILE_NOTIFICATIONS')?></label>

			<?php if (lang('CONF_SELECT_NOTIFICATIONS_EMAIL') == 'ON'): ?>
			<div class="custom-control custom-switch custom-control-inline">
				<input id="notificationsEmail" class="custom-control-input" type="checkbox" name="notificationsEmail" checked="">
				<label class="custom-control-label" for="notificationsEmail"><?= lang('GEN_PROFILE_NOTIFICATIONS_EMAIL')?></label>
			</div>
			<?php endif; ?>

			<?php if (lang('CONF_SELECT_NOTIFICATIONS_SMS') == 'ON'): ?>
			<div class="custom-control custom-switch custom-control-inline">
				<input id="notificationsSms" class="custom-control-input" type="checkbox" name="notificationsSms" checked="">
				<label class="custom-control-label" for="notificationsSms"><?= lang('GEN_PROFILE_NOTIFICATIONS_SMS')?></label>
			</div>
			<?php endif; ?>

		</div>
		<?php endif; ?>
		
	</div>
	<div class="row">
		<div class="col-6 col-lg-4 col-xl-3">
			<a class="btn btn-small btn-link px-0 hyper-link big-modal" href="<?= base_url(lang('GEN_LINK_CHANGE_PASS')); ?>"><?= lang('GEN_PROFILE_CHANGE_PASSWORD')?></a>
		</div>
		<?php if (lang('CONF_OPER_KEY') == 'ON'): ?>
		<div class="col-6 col-lg-4 col-xl-3">
			<a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('GEN_PROFILE_CHANGE_PASSWORD_OPERATIONS')?></a>
		</div>
		<?php endif; ?>
		<?php if (lang('CONF_SMS_KEY') == 'ON'): ?>
		<div class="col-6 col-lg-4 col-xl-3">
			<a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('GEN_PROFILE_CHANGE_PASSWORD_SMS')?></a>
		</div>
		<?php endif; ?>
	</div>
	<hr class="separador-one mt-2 mb-4">
	<?php if (lang('CONF_UPDATE_USER') == 'ON'): ?>
	<div class="flex items-center justify-end">
		<a class="btn btn-small btn-link" href=""><?= lang('GEN_BTN_CANCEL')?></a>
		<button id="btnActualizar" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE')?></button>
	</div>
	<?php endif; ?>
</form>
