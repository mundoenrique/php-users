<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="h3 pl-2"><?= lang('USER_PROFILE_TITLE'); ?></h1>
<hr class="separador-one">
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="profileUserForm" method="post" class="hide-out hide bg-color p-2">
	<input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
	<div class="row">

		<div class="col-12 col-lg-6 pb-3">
			<div class="bg-secondary p-2 h-100">
				<h4 class="mt-1 pb-2 h4"><?= lang('USER_PERSONAL_DATA') ?></h4>
				<div class="row mx-1">
					<div class="form-group col-3 col-lg-6">
						<label for="idType"><?= lang('USER_ID_TYPE') ?></label>
						<input id="idTypeText" class="form-control" type="text" name="idTypeText" value="<?= $idTypeText; ?>" readonly autocomplete="off">
						<input id="idTypeCode" type="hidden" name="idTypeCode" value="<?= $idTypeCode; ?>">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="idNumber"><?= lang('USER_ID_NUMBER') ?></label>
						<input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idNumber ?>" readonly autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="firstName"><?= lang('USER_FIRSTNAME') ?></label>
						<input id="firstName" class="form-control <?= $updateUser; ?>" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?> autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="lastName"><?= lang('USER_LASTNAME') ?></label>
						<input id="lastName" class="form-control <?= $updateUser; ?>" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?> autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="middleName"><?= lang('USER_MIDDLENAME') ?></label>
						<input id="middleName" class="form-control <?= $updateUser; ?>" type="text" name="middleName" value="<?= $middleName; ?>" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="surName"><?= lang('USER_SURNAME') ?></label>
						<input id="surName" class="form-control <?= $updateUser; ?>" type="text" name="surName" value="<?= $surName; ?>" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="birthDate"><?= lang('USER_BIRTHDATE') ?></label>
						<input id="birthDate" class="form-control <?= $updateUser; ?>" type="text" name="birthDate" value="<?= $birthday; ?>" readonly autocomplete="off">
						<div class="help-block"></div>
					</div>
					<?php if($longProfile == 'S'):?>
					<div class="form-group col-3 col-lg-6">
						<label for="nationality"><?= lang('USER_NATIONALITY') ?></label>
						<input id="nationality" class="form-control <?= $updateUser; ?>" type="text" name="nationality" value="">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="placeBirth"><?= lang('USER_PLACEBIRTH') ?></label>
						<input id="placeBirth" class="form-control <?= $updateUser; ?>" type="text" name="placeBirth" value="">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="civilStatus"><?= lang('USER_CIVILSTATUS') ?></label>
						<select id="civilStatus" class="custom-select form-control <?= $updateUser; ?>" name="civilStatus">
							<?php foreach (lang('USER_CIVILSTATUS_LIST') as $key => $value) : ?>
								<option value="<?= $key; ?>"><?= $value; ?></option>
							<?php endforeach; ?>
						</select>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="verifierCode"><?= lang('USER_VERIFIERCODE') ?></label>
						<input id="verifierCode" class="form-control <?= $updateUser; ?>" type="text" name="verifierCode" value="">
						<div class="help-block"></div>
					</div>
					<?php endif; ?>
					<div class="form-group col-3 col-lg-6">
						<label class="block"><?= lang('USER_GENDER') ?></label>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off" <?= $gender == 'M' ? 'checked' : ''; ?> <?= $disabled; ?>>
							<label class="custom-control-label <?= $updateUser; ?>" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off" <?= $gender == 'F' ? 'checked' : ''; ?> <?= $disabled; ?>>
							<label class="custom-control-label <?= $updateUser; ?>" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
						</div>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6 <?= $skipProfession; ?>">
						<label for="profession"><?= lang('USER_PROFESSION') ?></label>
						<select id="profession" class="custom-select form-control <?= $updateUser; ?>" name="profession">
							<option value="<?= $professionType; ?>" selected><?= $profession; ?></option>
						</select>
						<div class="help-block"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-lg-6 pb-3">
			<div class="bg-secondary p-2 h-100">
				<h4 class="mt-1 pb-2 h4"><?= lang('USER_CONTACT_DATA') ?></h4>
				<div class="row mx-1 <?= $skipContacData; ?>">
					<div class="form-group col-3 col-lg-6">
						<label for="addressType"><?= lang('USER_ADDRESS_TYPE') ?></label>
						<select id="addressType" class="custom-select form-control <?= $updateUser; ?>" name="addressType">
							<?php foreach (lang('USER_ADDRESS_TYPE_LIST') as $key => $value) : ?>
								<option value="<?= $key; ?>" <?= $addressType == $key ? 'selected' : ''; ?>><?= $value; ?></option>
							<?php endforeach; ?>
						</select>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="postalCode"><?= lang('USER_POSTAL_CODE') ?></label>
						<input id="postalCode" class="form-control <?= $updateUser; ?>" type="text" name="postalCode" value="<?= $postalCode; ?>" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-3 col-lg-6">
						<label for="department"><?= lang('USER_STATE') ?></label>
						<select id="department" class="custom-select form-control <?= $updateUser; ?>" name="department">
							<option value="<?= $departmentCod; ?>"><?= $department; ?></option>
						</select>
						<div class="help-block"></div>
					</div>
					<div id="ctrlCity" class="form-group col-3 col-lg-6">
						<label for="city"><?= lang('USER_CITY') ?></label>
						<select id="city" class="custom-select form-control <?= $updateUser; ?>" name="city">
							<option value="<?= $cityCod; ?>"><?= $city; ?></option>
						</select>
						<div class="help-block"></div>
					</div>
					<?php if($longProfile == 'S'):?>
					<div class="form-group col-3 col-lg-6">
						<label for="district"><?= lang('USER_DISTRICT') ?></label>
						<select id="district" class="custom-select form-control <?= $updateUser; ?>" name="district">
							<option value=""></option>
						</select>
						<div class="help-block"></div>
					</div>
					<?php endif; ?>
					<div class="form-group col-12 col-lg-8 col-xl-12">
						<label for="address"><?= lang('USER_ADDRESS') ?></label>
						<textarea id="address" class="form-control <?= $updateUser; ?>" name="address"><?= $address; ?></textarea>
						<div class="help-block"></div>
					</div>
				</div>
				<div class="row mx-1">
					<div class="form-group col-6">
						<label for="email"><?= lang('USER_EMAIL') ?></label>
						<input id="email" class="form-control <?= $updateUser; ?>" type="email" name="email" value="<?= $email; ?>" placeholder="usuario@ejemplo.com" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<?php if (lang('CONF_UPDATE_USER') == 'ON') : ?>
						<div class="form-group col-6">
							<label for="email"><?= lang('USER_CONFIRM_EMAIL') ?></label>
							<input id="confirmEmail" class="form-control" type="email" name="confirmEmail" value="<?= $email; ?>" placeholder="usuario@ejemplo.com" autocomplete="off" onpaste="return false">
							<div class="help-block"></div>
						</div>
					<?php endif; ?>
					<div class="form-group col-6 <?= $skipLandLine; ?>">
						<label for="landLine"><?= lang('USER_PHONE_LANDLINE') ?></label>
						<input id="landLine" class="form-control <?= $updateUser; ?>" type="text" name="landLine" value="<?= $landLine; ?>" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-6">
						<label for="mobilePhone"><?= lang('USER_PHONE_MOBILE') ?></label>
						<input id="mobilePhone" class="form-control <?= $updateUser; ?>" type="text" name="mobilePhone" value="<?= $mobilePhone; ?>" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="col-6 <?= $skipOtherPhone; ?>">
						<label for="otherPhoneNum"><?= lang('USER_PHONE_OTHER') ?></label>
						<div class="form-row">
							<div class="form-group col-6">
								<select id="phoneType" class="custom-select form-control <?= $updateUser; ?>" name="phoneType">
									<?php foreach (lang('USER_OTHER_PHONE_LIST') as $key => $value) : ?>
										<option value="<?= $key; ?>" <?= $otherType == $key ? 'selected' : ''; ?>><?= $value; ?></option>
									<?php endforeach; ?>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-6">
								<input id="otherPhoneNum" class="form-control <?= $updateUser; ?>" type="text" name="otherPhoneNum" value="<?= $otherPhoneNum; ?>" <?= $otherPhoneNum == '' ? 'disabled' : '' ?> autocomplete="off">
								<div class="help-block"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if($longProfile == 'S'):?>
		<div class="col-12 pb-3 col-lg-6">
			<div class="bg-secondary p-2 h-100">
				<h4 class="mt-1 pb-2 h4"><?= lang('USER_LABOR_DATA') ?></h4>
				<div class="row mx-1">
					<div class="form-group col-4 col-lg-6">
						<label for="idRUC"><?= lang('GEN_FISCAL_REGISTRY') ?></label>
						<input id="idRUCText" class="form-control" type="text" name="idRUCText" value="20000002" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-4 col-lg-6">
						<label for="idWorkplace"><?= lang('USER_WORK_CENTER') ?></label>
						<input id="idWorkplace" class="form-control" type="text" name="idWorkplace" value="" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-4 col-lg-6">
						<label for="employmentStatus"><?= lang('USER_EMPLOYMENT_STATUS') ?></label>
						<select id="employmentStatus" class="custom-select form-control" name="employmentStatus">
							<option selected disabled>Seleccionar</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
						</select>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-6">
						<label for="Seniority"><?= lang('USER_SENIORITY') ?></label>
						<select id="Seniority" class="custom-select form-control" name="Seniority">
							<option selected disabled>Seleccionar</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
						</select>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-6 col-lg-12 col-xl-6">
						<label for="occupation"><?= lang('USER_OCCUPATION') ?></label>
						<select id="occupation" class="custom-select form-control" name="occupation">
							<option selected disabled>Seleccionar</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
						</select>
						<div class="help-block"></div>
					</div>

					<div class="form-group col-6 col-lg-12 col-xl-6">
						<label for="charge"><?= lang('USER_CHARGE') ?></label>
						<input id="chargeText" class="form-control" type="text" name="chargeText" value="" autocomplete="off">
						<div class="help-block"></div>
					</div>

					<div class="form-group col-6">
						<label for="averageMonthly"><?= lang('USER_AVERAGE_MONTHLY') ?></label>
						<input id="averageMonthlyText" class="form-control" type="text" name="averageMonthlyText" value="" autocomplete="off">
						<div class="help-block"></div>
					</div>

					<div class="form-group col-12 center">
						<label class="block"><?= lang('USER_PUBLIC_OFFICE') ?></label>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="yesPublicOffice" class="custom-control-input" type="radio" name="PublicOffice" value="Si" autocomplete="off">
							<label class="custom-control-label" for="yesPublicOffice">Si</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="noPublicOffice" class="custom-control-input" type="radio" name="PublicOffice" value="No" checked autocomplete="off">
							<label class="custom-control-label" for="noPublicOffice">No</label>
						</div>
						<div class="help-block"></div>
					</div>
					<div class="form-group col-6">
						<label for="publicPosition"><?= lang('USER_PUBLIC_POSITION') ?></label>
						<input id="publicPosition" class="form-control" disabled type="text" name="publicPosition" value="" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-6">
						<label for="institution"><?= lang('USER_INSTITUTION') ?></label>
						<input id="institution" class="form-control" disabled type="text" name="institution" value="" autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group col-12 pt-2 center">
						<label class="block"><?= lang('USER_ARTICLE_LAW') ?></label>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="yesArticleLaw" class="custom-control-input" type="radio" name="ArticleLaw" value="Si" autocomplete="off">
							<label class="custom-control-label" for="yesArticleLaw">Si</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="noArticleLaw" class="custom-control-input" type="radio" name="ArticleLaw" value="No" checked autocomplete="off">
							<label class="custom-control-label" for="noArticleLaw">No</label>
						</div>
						<div class="help-block"></div>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div class="dataUser col-12 <?= $dataUser; ?> pb-3">
			<div class="bg-secondary p-2 h-100">
				<h4 class="mt-1 pb-2 h4"><?= lang('USER_DATA_USER') ?></h4>
				<div class="row mx-1">
					<div class="form-group <?= $dataUserOptions; ?>">
						<label for="nickName"><?= lang('USER_NICK_NAME') ?></label>
						<input id="nickName" class="form-control available" type="text" name="nickName" value="<?= $nickName; ?>" readonly autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group <?= $dataUserOptions; ?>">
						<label for="creationDate"><?= lang('USER_REGISTRY_DATE') ?></label>
						<input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $creationDate; ?>" readonly autocomplete="off">
						<div class="help-block"></div>
					</div>
					<div class="form-group <?= $dataUserOptions; ?> <?= $skipBoth ?>">
						<label class="block"><?= lang('USER_NOTIFICATIONS') ?></label>
						<div class="custom-control custom-switch custom-control-inline <?= $skipEmail; ?>">
							<input id="notEmail" class="custom-control-input" type="checkbox" name="notEmail" <?= $emailNot == '1' ? 'checked' : '' ?> <?= $disabled; ?>>
							<label class="custom-control-label <?= $updateUser; ?>" for="notEmail"><?= lang('USER_NOT_EMAIL') ?></label>
						</div>
						<div class="custom-control custom-switch custom-control-inline <?= $skipSms ?>">
							<input id="notSms" class="custom-control-input" type="checkbox" name="notSms" <?= $smsNot == '1' ? 'checked' : '' ?> <?= $disabled; ?>>
							<label class="custom-control-label <?= $updateUser; ?>" for="notSms"><?= lang('USER_NOT_SMS') ?></label>
						</div>
					</div>
				</div>
				<div class="row mx-1">
					<div class="form-group col-6 col-lg-4">
						<a class="btn btn-small btn-link px-0 hyper-link big-modal" href="<?= base_url(lang('GEN_LINK_CHANGE_PASS')); ?>"><?= lang('USER_PASSWORD_CHANGE') ?></a>
					</div>
					<?php if (lang('CONF_OPER_KEY') == 'ON') : ?>
						<div class="form-group col-6 col-lg-4">
							<a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_OPER_PASS_CHANGE') ?></a>
						</div>
					<?php endif; ?>
					<?php if (lang('CONF_CHECK_NOTI_SMS') == 'ON') : ?>
						<div class="form-group col-6 col-lg-4">
							<a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_SMS_PASSS_CHANGE') ?></a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
			<div class="col-12 pb-3">
				<div class="bg-secondary p-2">
					<?php $this->load->view('user/loadDocuments_content-core') ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="col-12 pb-3">
			<div class="bg-secondary p-2">
				<div class="row mx-1">
					<div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
						<input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms" <?= $terms == '1' ? 'checked disabled' : '' ?>>
						<label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_TERMS'); ?></label>
						<div class="help-block"></div>
					</div>
					<?php if($longProfile == 'S'):?>
					<div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
						<input id="acceptTermsProtection" class="custom-control-input" type="checkbox" name="acceptTerms" <?= $terms == '1' ? 'checked disabled' : '' ?>>
						<label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_PROTECTION'); ?></label>
						<div class="help-block"></div>
					</div>
					<div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
						<input id="acceptTermsContract" class="custom-control-input" type="checkbox" name="acceptTerms" <?= $terms == '1' ? 'checked disabled' : '' ?>>
						<label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_CONTRACT'); ?></label>
						<div class="help-block"></div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>

	<?php if (lang('CONF_UPDATE_USER') == 'ON') : ?>
		<div class="flex items-center justify-end">
			<a class="btn btn-small btn-link big-modal" href="<?= base_url('perfil-usuario') ?>"><?= lang('GEN_BTN_CANCEL') ?></a>
			<button id="profileUserBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE') ?></button>
		</div>
	<?php endif; ?>
</form>
