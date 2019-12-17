<?php
	var_dump($data->registro);
?>
<div id="profile" class="profile-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Perfil de Usuario</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<div class="pt-3">
					<form method="post" id="formProfile">
						<h3 class="tertiary h4">Datos personales</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idType">Tipo de identificación</label>
								<input id="idType" class="form-control" name="idType" type="text" value="<?= $data->registro->user->descripcion_tipo_id_ext_per;?>" disabled>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="idNumber">Número de identificación</label>
								<input id="idNumber" class="form-control" name="idNumber" type="text" value="<?= $data->registro->user->id_ext_per;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="firstName">Primer nombre</label>
								<input id="firstName" class="form-control" name="firstName" type="text" value="<?= ucfirst(strtolower($data->registro->user->primerNombre));?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="middleName">Segundo nombre</label>
								<input id="middleName" class="form-control"  name="middleName" type="text" value="<?= ucfirst(strtolower($data->registro->user->segundoNombre));?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="lastName">Apellido paterno</label>
								<input id="lastName" class="form-control" name="lastName" type="text" value="<?= ucfirst(strtolower($data->registro->user->primerApellido));?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="secondSurname">Apellido materno</label>
								<input id="secondSurname" name="secondSurname" class="form-control" type="text" value="<?= ucfirst(strtolower($data->registro->user->segundoApellido));?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="birthDate">Fecha de Nacimiento</label>
								<input id="birthDate" class="form-control" type="text" name="birthDate" value="<?= $data->registro->user->fechaNacimiento;?>">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Sexo</label>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" <?= $data->registro->user->sexo === 'M'? 'checked':'';?> >
									<label class="custom-control-label" for="genderMale">Masculino</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" <?= $data->registro->user->sexo !== 'M'? 'checked':'';?>>
									<label class="custom-control-label" for="genderFemale">Femenino</label>
								</div>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="profession">Profesión</label>
									<?php
										if ( gettype($dataProfessions) === 'array' ) {
									?>
											<select id="profession" class="custom-select form-control" name="profession" placeholder="Seleccione">
											<option value="">Seleccione</option>
									<?php
												foreach ($dataProfessions as $row) {
									?>
													<option value="<?= $row->idProfesion;?>"><?= $row->tipoProfesion;?></option>
									<?php
												}
									?>
											</select>
									<?php
										}else{
									?>
										<input id="profession" name="profession" class="form-control" type="text" value="<?= $dataProfessions->descripcion;?>" disabled/>
									<?php
										}
									?>
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
								<input id="postalCode" class="form-control" type="text" name="postalCode" value="<?= $data->registro->afiliacion->cod_postal;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="department">Departamento</label>
								<?php
										if ( gettype($dataStates) === 'array' ) {
									?>
											<select id="department" class="custom-select form-control" name="department" placeholder="Seleccione">
											<option value="">Seleccione</option>
									<?php
												foreach ($dataStates as $row) {
									?>
													<option value="<?= $row->codEstado;?>"><?= ucfirst(strtolower($row->estados));?></option>
									<?php
												}
									?>
											</select>
									<?php
										}else{
									?>
										<input id="profession" name="profession" class="form-control" type="text" value="<?= $dataStates->descripcion;?>" disabled/>
									<?php
										}
									?>
								<div class="help-block"></div>
							</div>
							<div id='ctrlCity' class="form-group col-6 col-lg-4 col-xl-3 none">
								<label for="city">Ciudad</label>
								<select id="city" class="custom-select form-control" name="city" placeholder="Seleccione">
								</select>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-12 col-lg-8 col-xl-6">
								<label for="address">Dirección</label>
								<textarea id="address" name="address" class="form-control"><?= $data->registro->afiliacion->direccion;?></textarea>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="landLine">Teléfono fijo</label>
								<input id="landLine" class="form-control" type="text" name="landLine" value="<?= array_key_exists('HAB', $data->ownTelephones)? $data->ownTelephones['HAB']: '';?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="mobilePhone">Teléfono móvil</label>
								<input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= array_key_exists('CEL', $data->ownTelephones)? $data->ownTelephones['CEL']: '';?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="state">Otro Teléfono (Tipo)</label>
								<select id="phoneType" class="custom-select form-control" name="phoneType" placeholder="Seleccione">
									<option <?= array_key_exists('OFC', $data->ownTelephones)? 'selected': '';?> value="OFC">Laboral</option>
									<option <?= array_key_exists('FAX', $data->ownTelephones)? 'selected': '';?> value="FAX">Fax</option>
									<option <?= array_key_exists('OTRO', $data->ownTelephones)? 'selected': '';?> value="OTRO">Otro</option>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="otherPhoneNum">Otro Teléfono (Número)</label>
								<?php
									$nroOtherTelephone = '';
									foreach ($data->ownTelephones as $key => $value) {
										if ($key == 'CEL' || $key == 'HAB') {
											continue;
										}
										$nroOtherTelephone = $value;
								}
								?>
								<input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value="<?= $nroOtherTelephone;?>"/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="email">Correo Electrónico</label>
								<input id="email" class="form-control" type="email" name="email" value="<?= $data->registro->user->email;?>" placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<h3 class="tertiary h4">Datos de usuario</h3>
						<div class="row">
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="username">Login</label>
								<input id="username" class="form-control" type="text" name="username" value="<?= $data->registro->user->userName;?>" disabled>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label for="creationDate">Fecha de creación</label>
								<input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $data->registro->user->dtfechorcrea_usu;?>" disabled/>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6 col-lg-4 col-xl-3">
								<label class="block">Notificaciones</label>
								<div class="custom-control custom-switch custom-control-inline">
									<input id="notificationsEmail" class="custom-control-input" type="checkbox" name="notificationsEmail" <?= $data->registro->user->notEmail == 1? 'checked': '';?>>
									<label class="custom-control-label" for="notificationsEmail">Correo electrónico
									</label>
								</div>
								<div class="custom-control custom-switch custom-control-inline">
									<input id="notificationsSms" class="custom-control-input" type="checkbox" name="notificationsSms" <?= $data->registro->user->notSms == 1? 'checked': '';?>>
									<label class="custom-control-label" for="notificationsSms">SMS
									</label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6 col-lg-4 col-xl-3">
								<a class="btn btn-small btn-link px-0" href="<?= base_url('cambiarclaveprofile');?>">Cambiar contraseña</a>
							</div>
							<?php
								if ($this->session->userdata("aplicaTransferencia") === 'S') {
									$urlPasswordSMS = 'creaclavesms';
									$textPasswordSMS = 'Crear clave SMS';
									if ($data->registro->user->disponeClaveSMS === '0') {
										$urlPasswordSMS = 'cambiaclavesms';
										$textPasswordSMS = 'Cambiar clave SMS';
									}

									$urlPasswordOperation = 'creaclaveoperaciones';
									$textPasswordOperation = 'Crear clave Operaciones';
									if (!empty($this->session->userdata('passwordOperaciones'))) {
										$urlPasswordOperation = 'cambiarclaveoperaciones';
										$textPasswordOperation = 'Cambiar clave Operaciones';
									}
							?>
								<div class="col-6 col-lg-4 col-xl-3">
									<a class="btn btn-small btn-link px-0" href="<?= base_url($urlPasswordOperation);?>"><?= $textPasswordOperation;?></a>
								</div>
								<div class="col-6 col-lg-4 col-xl-3">
									<a class="btn btn-small btn-link px-0" href="<?= base_url($urlPasswordSMS);?>"><?= $textPasswordSMS;?></a>
								</div>
							<?php
								}
							?>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="flex items-center justify-end">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnActualizar" name="btnActualizar" class="btn btn-small btn-loading btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
</script>
