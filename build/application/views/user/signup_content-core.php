<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_SIGNUP'); ?></h1>
<hr class="separador-one mb-2">
<p>Para obtener tu usuario de <span class="semibold">Conexión Personas Online,</span> es necesario que ingreses los datos requeridos a continuación:
</p>
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
  <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="signUpForm" class="hide-out hide bg-color">
  <input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
  <h4 class="pb-2 h4 mt-3"><?= lang('USER_PERSONAL_DATA')?></h4>
  <div class="row">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="idType"><?= lang('USER_ID_TYPE')?></label>
      <input id="idType" class="form-control" type="text" name="idType" value="<?= $idType; ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="idNumber"><?= lang('USER_ID_NUMBER')?></label>
      <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idnumber; ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="firstName"><?= lang('USER_FIRSTNAME')?></label>
      <input id="firstName" class="form-control" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?> autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="lastName"><?= lang('USER_LASTNAME')?></label>
      <input id="lastName" class="form-control" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?> autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="middleName"><?= lang('USER_MIDDLENAME')?></label>
      <input id="middleName" class="form-control" type="text" name="middleName" value="<?= $middleName; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="surName"><?= lang('USER_SURNAME')?></label>
      <input id="surName" class="form-control" type="text" name="surName" value="<?= $surName; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="birthDate"><?= lang('USER_BIRTHDATE')?></label>
      <input id="birthDate" class="form-control date-picker" type="text" name="birthDate" value="<?= $birthDate; ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label class="block"><?= lang('USER_GENDER')?></label>
      <div class="custom-control custom-radio custom-control-inline">
        <input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off">
        <label class="custom-control-label" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off">
        <label class="custom-control-label" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
      </div>
      <div class="help-block"></div>
    </div>
  </div>
  <hr class="separador-one mt-2 mb-4">
  <h4 class="pb-2 h4"><?= lang('USER_CONTACT_DATA')?></h4>
  <div class="row">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="email"><?= lang('USER_EMAIL')?></label>
      <input id="email" class="form-control" type="email" name="email" value="<?= $email; ?>" placeholder="usuario@ejemplo.com" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="confirmEmail"><?= lang('USER_CONFIRM_EMAIL') ?></label>
      <input id="confirmEmail" class="form-control" type="email" name="confirmEmail" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
        autocomplete="off" onpaste="return false">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="landLine"><?= lang('USER_PHONE_LANDLINE')?></label>
      <input id="landLine" class="form-control" type="text" name="landLine" value="<?= $landLine ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="mobilePhone"><?= lang('USER_PHONE_MOBILE')?></label>
      <input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= $mobilePhone ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="col-6 col-lg-4 col-xl-3">
      <label for="otherPhoneNum"><?= lang('USER_PHONE_OTHER')?></label>
      <div class="form-row">
        <div class="form-group col-6">
          <select id="phoneType" class="custom-select form-control" name="phoneType">
            <?php foreach (lang('USER_OTHER_PHONE_LIST') AS $key => $value): ?>
            <option value="<?= $key; ?>"><?= $value; ?></option>
            <?php endforeach; ?>
          </select>
          <div class="help-block"></div>
        </div>
        <div class="form-group col-6">
          <input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value="" autocomplete="off">
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
					<div class="col-lg-6 pl-lg-0 pr-lg-2 pl-0 pr-0">
						<label for="nickName">Usuario</label>
						<div class="input-group">
							<input id="nickName" class="form-control pwd-input available" type="text" name="nickName">
						</div>
						<div class="help-block"></div>
					</div>
				</div>
				<div class="form-group col-12 col-lg-6">
					<label for="newPass">Contraseña</label>
					<div class="input-group">
						<input id="newPass" class="form-control pwd-input" type="password" name="newPass">
						<div class="input-group-append">
							<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>">
								<i class="icon-view mr-0"></i>
							</span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
				<div class="form-group col-12 col-lg-6">
					<label for="confirmPass">Confirmar Contraseña</label>
					<div class="input-group">
						<input id="confirmPass" class="form-control pwd-input" type="password" name="confirmPass">
						<div class="input-group-append">
							<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>">
								<i class="icon-view mr-0"></i>
							</span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
			</div>
		</div>
		<div class="cover-spin" id=""></div>
		<div class="col-6 flex justify-center">
			<div class="field-meter" id="password-strength-meter">
				<h4><?= lang('USER_INFO_TITLE'); ?></h4>
				<ul class="pwd-rules">
					<li id="length" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_1'); ?></li>
					<li id="letter" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_2'); ?></li>
					<li id="capital" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_3'); ?></li>
					<li id="number" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_4'); ?></li>
					<li id="special" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_5'); ?></li>
					<li id="consecutive" class="pwd-rules-item rule-invalid"><?= lang('USER_INFO_6'); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<?php if(lang('CONF_LOADING_DOC') == 'ON'):?>
	<hr class="separador-one mt-2 mb-4">
	<h4 class="pb-2 h4">Carga de documentos de identidad</h4>
	<div class="row justify-center">
		<div class="col-12 col-lg-7 my-auto">
			<div class="row mr-2">
				<?php if(lang('CONF_LOADING_DOC_PHOTO') == 'ON'):?>
				<div class="col-4 flex items-center justify-center">
					<div class="form-group bg-color px-1 mb-2">
						<div class="drop-zone drop-zone-selfie img-preview px-1 label-file flex flex-column">
							<img src="../../../assets/images/img_avatar.png" alt="Avatar" id="imagePreviewContainer">
							<div class="drop-zone-prompt mt-1 flex justify-between ">
								<span class="js-file-name h5 regular">Agregar foto</span>
								<i class="icon icon-upload ml-2"></i>
							</div>
							<input type="file" name="myFile" id="imageUpload" class="drop-zone-input" accept=".png, .jpg, .jpeg">
						</div>
					</div>
					<div class="help-block"></div>
				</div>
				<?php endif; ?>
				<div class="col-8 m-auto">
					<div class="row">
						<?php if(lang('CONF_LOADING_DOC_F_ID') == 'ON'):?>
						<div class="form-group col-6 col-lg-6 bg-color px-1 mb-2">
							<div class="drop-zone label-file p-1">
								<div class="drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold">Agregar parte frontal del INE</span>
								</div>
								<input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
							</div>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
						<?php if(lang('CONF_LOADING_DOC_B_ID') == 'ON'):?>
						<div class="form-group col-6 col-lg-6 bg-color px-1 mb-2">
							<div class="drop-zone label-file p-1">
								<div class="drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold drop-zone-prompt">Agregar parte trasera del INE</span>
								</div>
								<input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
							</div>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
						<?php if(lang('CONF_LOADING_DOC_F_PASS') == 'ON'):?>
						<div class="form-group col-6 col-lg-6 bg-color px-1 mb-2">
							<div class="drop-zone label-file p-1">
								<div class="drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold drop-zone-prompt">Agregar parte frontal del pasaporte</span>
								</div>
								<input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
							</div>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
						<?php if(lang('CONF_LOADING_DOC_B_PASS') == 'ON'):?>
						<div class="form-group col-6 col-lg-6 bg-color px-1 mb-2">
							<div class="drop-zone label-file p-1">
								<div class="drop-zone-prompt flex flex-column items-center">
									<i class="icon icon-upload h00"></i>
									<span class="js-file-name h6 regular bold drop-zone-prompt">Agregar parte trasera del pasaporte</span>
								</div>
								<input type="file" name="myFile" class="drop-zone-input" accept=".png, .jpg, .jpeg">
							</div>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-lg-4 flex justify-start">
			<div class="field-meter">
				<h4>Requisitos para el cargue de imagen:</h4>
				<ul class="pwd-rules">
					<div class="row">
						<div class="col-6 col-lg-12">
							<li class="pwd-rules-item">Sólo se permiten archivos en formato PNG o JPEG.</li>
							<li class="pwd-rules-item">Las imágenes deben ser en color, claras y legibles.</li>
							<li class="pwd-rules-item">Es posible que se le soliciten documentos adicionales.</li>
						</div>
						<div class="col-6 col-lg-12">
							<li class="pwd-rules-item">El tamaño máximo por archivo debe ser de 6Mb.</li>
							<li class="pwd-rules-item">Debe cargar el INE de manera obligatoria.</li>
							<li class="pwd-rules-item">Su documento de Identidad debe encontrarse en vigencia.</li>
						</div>
					</div>
				</ul>
			</div>
		</div>
	</div>
	<?php endif; ?>
  <hr class="separador-one mt-2 mb-4">
  <div class="flex items-center justify-end mb-5 mr-5">
    <a class="btn btn-small btn-link big-modal" href="<?= base_url('inicio') ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
    <button id="signUpBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
  </div>
</form>
