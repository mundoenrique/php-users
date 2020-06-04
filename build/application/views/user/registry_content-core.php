<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3">Afiliación de datos</h1>
<hr class="separador-one mb-2">
<p>para obtener tu usuario de <span class="semibold">Conexión Personas Online,</span> es necesario que ingreses los datos requeridos a continuación:</p>
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="" method="post" class ="hide-out hide bg-color">
	<h4 class="pb-2 h4 mt-3">Datos personales</h4>
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
	</div>
	<hr class="separador-one mt-2 mb-4">
	<h4 class="pb-2 h4">Datos de contacto</h4>
	<div class="row">
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="email">Correo electrónico</label>
			<input id="email" class="form-control" type="email" name="email"
				value="grobles@novopayment.com" placeholder="usuario@ejemplo.com"
				autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="email">Confirmar correo electrónico</label>
			<input id="email" class="form-control" type="email" name="email"
				value="grobles@novopayment.com" placeholder="usuario@ejemplo.com"
				autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="landLine">Teléfono fijo</label>
			<input id="landLine" class="form-control" type="text" name="landLine" value="58426487874"
				autocomplete="off">
			<div class="help-block"></div>
		</div>
		<div class="form-group col-6 col-lg-4 col-xl-3">
			<label for="mobilePhone">Teléfono móvil</label>
			<input id="mobilePhone" class="form-control" type="text" name="mobilePhone"
				value="58426487878" autocomplete="off">
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
	</div>
	<hr class="separador-one mt-2 mb-4">
	<h4 class="pb-2 h4">Datos de usuario</h4>
	<div class="row">
		<div class="col-6">
			<div class="row">
			<div class="form-group col-12 col-lg-12">
				<div class="col-12 col-lg-6 pl-0">
					<label for="currentPass">Usuario</label>
					<div class="input-group">
						<input id="currentPass" class="form-control pwd-input" type="password" name="current-pass" required>
						<div class="input-group-append">
							<span id="pwd-addon" class="input-group-text pwd-action" title="Clic aquí para mostrar/ocultar contraseña"><i
									class="icon-view mr-0"></i></span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
			</div>
				<div class="form-group col-12 col-lg-6">
					<label for="newPass">Contraseña</label>
					<div class="input-group">
						<input id="newPass" class="form-control pwd-input" type="password" name="new-pass" required>
						<div class="input-group-append">
							<span id="pwd-addon" class="input-group-text pwd-action" title="Clic aquí para mostrar/ocultar contraseña"><i
									class="icon-view mr-0"></i></span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
				<div class="form-group col-12 col-lg-6">
					<label for="confirmPass">Confirmar Contraseña</label>
					<div class="input-group">
						<input id="confirmPass" class="form-control pwd-input" type="password" name="confirm-pass" required>
						<div class="input-group-append">
							<span id="pwd-addon" class="input-group-text pwd-action" title="Clic aquí para mostrar/ocultar contraseña"><i
									class="icon-view mr-0"></i></span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
			</div>
		</div>
		<div class="cover-spin" id=""></div>
		<div class="col-6 flex justify-center">
			<div class="field-meter" id="password-strength-meter">
				<h4>Requerimientos de contraseña:</h4>
				<ul class="pwd-rules">
					<li id="length" class="pwd-rules-item rule-invalid">De 8 a 15 <strong>Caracteres</strong>
					</li>
					<li id="letter" class="pwd-rules-item rule-invalid">Al menos una <strong>letra
							minúscula</strong>
					</li>
					<li id="capital" class="pwd-rules-item rule-invalid">Al menos una <strong>letra
							mayúscula</strong>
					</li>
					<li id="number" class="pwd-rules-item rule-invalid">De 1 a 3 <strong>números</strong></li>
					<li id="special" class="pwd-rules-item rule-invalid">Al menos un <strong>caracter
							especial</strong><br>(ej: ! @ ? + - . , #)</li>
					<li id="consecutive" class="pwd-rules-item rule-invalid">No debe tener más de 2
						<strong>caracteres</strong> iguales consecutivos</li>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<hr class="separador-one mt-2 mb-4">
	<div class="flex items-center justify-end mb-5 mr-5">
		<a class="btn btn-small btn-link"
			href="">Cancelar</a>
		<button id="btnActualizar" class="btn btn-small btn-loading btn-primary" type="submit"
			name="btnActualizar">Continuar</button>
	</div>
</form>
