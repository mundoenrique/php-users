<div id="profile" class="profile-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Perfil de usuario</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<div class="pt-3">
						<form id="formProfile" method="post">
							<h3 class="tertiary h4">Datos personales</h3>
								<?php
									if ($data === '--') {
								?>
										<h2 class="h4 center">No posee datos regitrados.</h2>
								<?php
									}else{

										$id_ext_per = $data->registro->user->id_ext_per;
										if (strpos($id_ext_per, '_') !== false) {
											$id_ext_per = explode('_', $id_ext_per)[1];
										}
								?>

									<div class="row">
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="idType">Tipo de identificación</label>
											<input id="idType" class="form-control" type="text" name="idType" value="<?= $data->registro->user->descripcion_tipo_id_ext_per;?>" disabled>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="idNumber">Número de identificación</label>
											<input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $data->registro->user->id_ext_per;?>" disabled/>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="firstName">Primer nombre</label>
											<input id="firstName" class="form-control" type="text" name="firstName" value="<?= ucfirst(strtolower($data->registro->user->primerNombre));?>" disabled/>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="middleName">Segundo nombre</label>
											<input id="middleName" class="form-control" type="text"  name="middleName" value="<?= ucfirst(strtolower($data->registro->user->segundoNombre));?>" disabled/>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="lastName">Primer apellido</label>
											<input id="lastName" class="form-control" type="text" name="lastName" value="<?= ucfirst(strtolower($data->registro->user->primerApellido));?>" disabled/>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="secondSurname">Segundo apellido</label>
											<input id="secondSurname" class="form-control" type="text" name="secondSurname" value="<?= ucfirst(strtolower($data->registro->user->segundoApellido));?>" disabled/>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="birthDate">Fecha de nacimiento</label>
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
																<option value="<?= $row->idProfesion;?>" <?= $data->registro->user->tipo_profesion === $row->idProfesion? 'selected': '' ;?>> <?= $row->tipoProfesion;?></option>
												<?php
															}
												?>
														</select>
												<?php
													}else{
												?>
													<input id="profession" class="form-control" type="text" name="profession" value="<?= $dataProfessions->descripcion;?>" disabled/>
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
												<option value="1" <?= $data->direccion->acTipo == '1'? 'selected': '' ;?>>Domicilio</option>
												<option value="2" <?= $data->direccion->acTipo == '2'? 'selected': '' ;?>>Laboral</option>
												<option value="3" <?= $data->direccion->acTipo == '3'? 'selected': '' ;?>>Comercial</option>
											</select>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="postalCode">Código postal</label>
											<input id="postalCode" class="form-control" type="text" name="postalCode" value="<?= $data->direccion->acZonaPostal;?>"/>
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
																<option value="<?= $row->codEstado;?>" <?= $data->direccion->acCodEstado === $row->codEstado? 'selected': '';?>><?= mb_convert_case($row->estados, MB_CASE_TITLE, "UTF-8");?></option>
												<?php
															}
												?>
														</select>

												<?php
													}else{
												?>
													<input id="department" class="form-control" type="text" name="department" value="<?= $dataStates->descripcion;?>" disabled/>
												<?php
													}
												?>
											<div class="help-block"></div>
										</div>
										<div id='ctrlCity' class="form-group col-6 col-lg-4 col-xl-3">
											<label for="city">Ciudad</label>
											<?php
												if (!empty($dataCitys) and gettype($dataCitys) === 'array') {
											?>
														<select id="city" class="custom-select form-control" name="city" placeholder="Seleccione">
															<option value="">Seleccione</option>
												<?php
															foreach ($dataCitys as $row) {
												?>
																<option value="<?= $row->codCiudad;?>" <?= $data->direccion->acCodCiudad === $row->codCiudad? 'selected': '';?>><?=mb_convert_case($row->ciudad, MB_CASE_TITLE, "UTF-8");?></option>
												<?php
															}
												?>
														</select>
												<?php
													}elseif($dataCitys === '--') {
												?>
													<input id="city" class="form-control" type="text" name="city" value="<?= $dataCitys->descripcion;?>" disabled/>
												<?php
												}else{
												?>
													<select id="city" class="custom-select form-control" name="city" placeholder="Seleccione">
														<option value="">Seleccione</option>
													</select>
											<?php
												}
											?>

										</div>
									</div>
									<div class="row">
										<div class="form-group col-12 col-lg-8 col-xl-6">
											<label for="address">Dirección</label>
											<textarea id="address" class="form-control" name="address"><?= $data->direccion->acDir;?></textarea>
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
											<label for="state">Otro teléfono (tipo)</label>
											<select id="phoneType" class="custom-select form-control" name="phoneType" placeholder="Seleccione">
												<option <?= array_key_exists('OFC', $data->ownTelephones)? 'selected': '';?> value="OFC">Laboral</option>
												<option <?= array_key_exists('FAX', $data->ownTelephones)? 'selected': '';?> value="FAX">Fax</option>
												<option <?= array_key_exists('OTRO', $data->ownTelephones)? 'selected': '';?> value="OTRO">Otro</option>
											</select>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 col-lg-4 col-xl-3">
											<label for="otherPhoneNum">Otro teléfono (número)</label>
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
											<label for="email">Correo electrónico</label>
											<input id="email" class="form-control" type="email" name="email" value="<?= $data->registro->user->email;?>" placeholder="usuario@ejemplo.com" disabled>
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

								<?php
									}
								?>
							<hr class="separador-one mt-2 mb-4">
							<div class="flex items-center justify-end">
								<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
								<button id="btnActualizar" class="btn btn-small btn-loading btn-primary" type="submit" name="btnActualizar" <?php $data === '--'? 'disabled': '';?>>Continuar</button>
							</div>

						</form>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
</script>
