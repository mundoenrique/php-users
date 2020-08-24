<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3 pl-2"><?= lang('USER_PROFILE_TITLE'); ?></h1>
<hr class="separador-one">
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
  <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="profileUserForm" method="post" class="hide-out hide bg-color p-2">
  <input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
  <h4 class="mt-2 pb-2 h4"><?= lang('USER_PERSONAL_DATA')?></h4>
  <div class="row">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="idType"><?= lang('USER_ID_TYPE')?></label>
      <input id="idTypeText" class="form-control" type="text" name="idTypeText" value="<?= $idTypeText; ?>" readonly autocomplete="off">
      <input id="idTypeCode" type="hidden" name="idTypeCode" value="<?= $idTypeCode; ?>">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="idNumber"><?= lang('USER_ID_NUMBER')?></label>
      <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idNumber ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="firstName"><?= lang('USER_FIRSTNAME')?></label>
      <input id="firstName" class="form-control <?= $updateUser; ?>" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?>
        autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="lastName"><?= lang('USER_LASTNAME')?></label>
      <input id="lastName" class="form-control <?= $updateUser; ?>" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?>
        autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="middleName"><?= lang('USER_MIDDLENAME')?></label>
      <input id="middleName" class="form-control <?= $updateUser; ?>" type="text" name="middleName" value="<?= $middleName; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="surName"><?= lang('USER_SURNAME')?></label>
      <input id="surName" class="form-control <?= $updateUser; ?>" type="text" name="surName" value="<?= $surName; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="birthDate"><?= lang('USER_BIRTHDATE')?></label>
      <input id="birthDate" class="form-control <?= $updateUser; ?>" type="text" name="birthDate" value="<?= $birthday; ?>" readonly
        autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label class="block"><?= lang('USER_GENDER')?></label>
      <div class="custom-control custom-radio custom-control-inline">
        <input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off"
          <?= $gender == 'M' ? 'checked' :''; ?>  <?= $disabled; ?>>
        <label class="custom-control-label <?= $updateUser; ?>" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
      </div>
      <div class="custom-control custom-radio custom-control-inline">
        <input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off"
          <?= $gender == 'F' ? 'checked' :''; ?>  <?= $disabled; ?>>
        <label class="custom-control-label <?= $updateUser; ?>" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
      </div>
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3 <?= $skipProfession; ?>">
      <label for="profession"><?= lang('USER_PROFESSION')?></label>
      <select id="profession" class="custom-select form-control <?= $updateUser; ?>" name="profession">
        <option value="<?= $professionType; ?>" selected><?= $profession; ?></option>
      </select>
      <div class="help-block"></div>
    </div>
  </div>
  <hr class="separador-one mt-2 mb-4">
  <h4 class="pb-2 h4"><?= lang('USER_CONTACT_DATA')?></h4>
  <div class="row <?= $skipContacData; ?>">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="addressType"><?= lang('USER_ADDRESS_TYPE')?></label>
      <select id="addressType" class="custom-select form-control <?= $updateUser; ?>" name="addressType">
        <?php foreach (lang('USER_ADDRESS_TYPE_LIST') AS $key => $value): ?>
        <option value="<?= $key; ?>" <?= $addressType == $key ? 'selected' : ''; ?>><?= $value; ?></option>
        <?php endforeach; ?>
      </select>
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="postalCode"><?= lang('USER_POSTAL_CODE')?></label>
      <input id="postalCode" class="form-control <?= $updateUser; ?>" type="text" name="postalCode" value="<?= $postalCode; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="department"><?= lang('USER_STATE')?></label>
      <select id="department" class="custom-select form-control <?= $updateUser; ?>" name="department">
        <option value="<?= $departmentCod; ?>"><?= $department; ?></option>
      </select>
      <div class="help-block"></div>
    </div>
    <div id="ctrlCity" class="form-group col-6 col-lg-4 col-xl-3">
      <label for="city"><?= lang('USER_CITY')?></label>
      <select id="city" class="custom-select form-control <?= $updateUser; ?>" name="city">
        <option value="<?= $cityCod; ?>"><?= $city; ?></option>
      </select>
      <div class="help-block"></div>
    </div>
    <div class="form-group col-12 col-lg-8 col-xl-12">
      <label for="address"><?= lang('USER_ADDRESS')?></label>
      <textarea id="address" class="form-control <?= $updateUser; ?>" name="address"><?= $address; ?></textarea>
      <div class="help-block"></div>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="email"><?= lang('USER_EMAIL')?></label>
      <input id="email" class="form-control <?= $updateUser; ?>" type="email" name="email" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
        autocomplete="off">
      <div class="help-block"></div>
    </div>
    <?php if (lang('CONF_UPDATE_USER') == 'ON'): ?>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="email"><?= lang('USER_CONFIRM_EMAIL') ?></label>
      <input id="confirmEmail" class="form-control" type="email" name="confirmEmail" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
        autocomplete="off" onpaste="return false">
      <div class="help-block"></div>
    </div>
    <?php endif; ?>
    <div class="form-group col-6 col-lg-4 col-xl-3 <?= $skipLandLine; ?>">
      <label for="landLine"><?= lang('USER_PHONE_LANDLINE')?></label>
      <input id="landLine" class="form-control <?= $updateUser; ?>" type="text" name="landLine" value="<?= $landLine; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="mobilePhone"><?= lang('USER_PHONE_MOBILE')?></label>
      <input id="mobilePhone" class="form-control <?= $updateUser; ?>" type="text" name="mobilePhone" value="<?= $mobilePhone; ?>" autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="col-6 col-lg-4 col-xl-3 <?= $skipOtherPhone; ?>">
      <label for="otherPhoneNum"><?= lang('USER_PHONE_OTHER')?></label>
      <div class="form-row">
        <div class="form-group col-6">
          <select id="phoneType" class="custom-select form-control <?= $updateUser; ?>" name="phoneType">
            <?php foreach (lang('USER_OTHER_PHONE_LIST') AS $key => $value): ?>
            <option value="<?= $key; ?>" <?= $otherType == $key ? 'selected' : ''; ?>><?= $value; ?></option>
            <?php endforeach; ?>
          </select>
          <div class="help-block"></div>
        </div>
        <div class="form-group col-6">
          <input id="otherPhoneNum" class="form-control <?= $updateUser; ?>" type="text" name="otherPhoneNum" value="<?= $otherPhoneNum; ?>"
            <?= $otherPhoneNum == '' ? 'disabled' : '' ?> autocomplete="off">
          <div class="help-block"></div>
        </div>
      </div>
    </div>
  </div>
  <hr class="separador-one mt-2 mb-4">
  <h4 class="pb-2 h4"><?= lang('USER_PROFILE_DATA_USER')?></h4>
  <div class="row">
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="nickName"><?= lang('USER_NICK_NAME')?></label>
      <input id="nickName" class="form-control available" type="text" name="nickName" value="<?= $nickName; ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3">
      <label for="creationDate"><?= lang('USER_REGISTRY_DATE')?></label>
      <input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $creationDate; ?>" readonly autocomplete="off">
      <div class="help-block"></div>
    </div>
    <div class="form-group col-6 col-lg-4 col-xl-3 <?= $skipBoth; ?>">
      <label class="block"><?= lang('USER_NOTIFICATIONS')?></label>
      <div class="custom-control custom-switch custom-control-inline <?= $skipEmail; ?>">
        <input id="notEmail" class="custom-control-input" type="checkbox" name="notEmail" <?= $emailNot == '1' ? 'checked' : '' ?> <?= $disabled; ?>>
        <label class="custom-control-label <?= $updateUser; ?>" for="notEmail"><?= lang('USER_NOT_EMAIL')?></label>
      </div>
      <div class="custom-control custom-switch custom-control-inline <?= $skipSms ?>">
        <input id="notSms" class="custom-control-input" type="checkbox" name="notSms" <?= $smsNot == '1' ? 'checked' : '' ?> <?= $disabled; ?>>
        <label class="custom-control-label <?= $updateUser; ?>" for="notSms"><?= lang('USER_NOT_SMS')?></label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-6 col-lg-4 col-xl-3">
      <a class="btn btn-small btn-link px-0 hyper-link big-modal"
        href="<?= base_url(lang('GEN_LINK_CHANGE_PASS')); ?>"><?= lang('USER_PASSWORD_CHANGE')?></a>
    </div>
    <?php if (lang('CONF_OPER_KEY') == 'ON'): ?>
    <div class="col-6 col-lg-4 col-xl-3">
      <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_OPER_PASS_CHANGE')?></a>
    </div>
    <?php endif; ?>
    <?php if (lang('CONF_CHECK_NOTI_SMS') == 'ON'): ?>
    <div class="col-6 col-lg-4 col-xl-3">
      <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_SMS_PASSS_CHANGE')?></a>
    </div>
    <?php endif; ?>
  </div>
  <hr class="separador-one mt-2 mb-4">
  <?php if (lang('CONF_UPDATE_USER') == 'ON'): ?>
  <div class="flex items-center justify-end">
    <a class="btn btn-small btn-link big-modal" href="<?= base_url('perfil-usuario') ?>"><?= lang('GEN_BTN_CANCEL')?></a>
    <button id="profileUserBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE')?></button>
  </div>
  <?php endif; ?>
</form>
