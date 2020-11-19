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
          <div class="form-group col-6 input-height">
            <label for="idType"><?= lang('USER_ID_TYPE') ?></label>
            <input id="idTypeText" class="form-control" type="text" name="idTypeText" value="<?= $idTypeText; ?>" readonly autocomplete="off">
            <input id="idType" type="hidden" name="idType" value="<?= $idTypeCode; ?>">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="idNumber"><?= lang('USER_ID_NUMBER') ?></label>
            <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idNumber ?>" readonly autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="firstName"><?= lang('USER_FIRSTNAME') ?></label>
            <input id="firstName" class="form-control <?= $updateUser; ?>" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?>
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="lastName"><?= lang('USER_LASTNAME') ?></label>
            <input id="lastName" class="form-control <?= $updateUser; ?>" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?>
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="middleName"><?= lang('USER_MIDDLENAME') ?></label>
            <input id="middleName" class="form-control <?= $updateUser; ?>" type="text" name="middleName" value="<?= $middleName; ?>"
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="surName"><?= lang('USER_SURNAME') ?></label>
            <input id="surName" class="form-control <?= $updateUser; ?>" type="text" name="surName" value="<?= $surName; ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="birthDate"><?= lang('USER_BIRTHDATE') ?></label>
            <input id="birthDate" class="form-control <?= $updateUser; ?>" type="text" name="birthDate" value="<?= $birthday; ?>" readonly
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <?php if($longProfile == 'S'):?>
          <div class="form-group col-6 input-height">
            <label for="nationality"><?= lang('USER_NATIONALITY') ?></label>
            <input id="nationality" class="form-control <?= $updateUser; ?>" type="text" name="nationality" value="<?= $nationality; ?>"
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="birthPlace"><?= lang('USER_PLACEBIRTH') ?></label>
            <input id="birthPlace" class="form-control <?= $updateUser; ?>" type="text" name="birthPlace" avlue="<?= $birthPlace; ?>">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="civilStatus"><?= lang('USER_CIVILSTATUS') ?></label>
            <select id="civilStatus" class="custom-select form-control <?= $updateUser; ?>" name="civilStatus">
              <?php foreach (lang('USER_CIVILSTATUS_LIST') as $key => $value) : ?>
              <option value="<?= $key; ?>" <?= $civilStatus == $key ? 'selected' : ''; ?> <?= $key == '' ? 'selected disabled' : '';  ?>>
                <?= $value; ?>
              </option>
              <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="verifierCode"><?= lang('USER_VERIFIERCODE') ?></label>
            <input id="verifierCode" class="form-control <?= $updateUser; ?>" type="text" name="verifierCode" value="<?= $verifierCode; ?>"
              maxlength="1" <?= $verifierCode != '' ? 'readonly' : ''; ?>>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <div class="form-group col-6 input-height">
            <label class="block"><?= lang('USER_GENDER') ?></label>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off"
                <?= $gender == 'M' ? 'checked' : ''; ?> <?= $disabled; ?>>
              <label class="custom-control-label <?= $updateUser; ?>" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off"
                <?= $gender == 'F' ? 'checked' : ''; ?> <?= $disabled; ?>>
              <label class="custom-control-label <?= $updateUser; ?>" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
            </div>
            <div class="help-block"></div>
          </div>
          <?php if ($longProfile == 'N'): ?>
          <div class="form-group col-6 input-height <?= $skipProfession; ?>">
            <label for="profession"><?= lang('USER_PROFESSION') ?></label>
            <select id="profession" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreProfession; ?>" name="profession">
              <option value="<?= $professionType; ?>" selected><?= $profession; ?></option>
            </select>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6 pb-3">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_CONTACT_DATA') ?></h4>
        <div class="row mx-1 <?= $skipContacData; ?>">
          <div class="form-group col-6">
            <label for="addressType"><?= lang('USER_ADDRESS_TYPE') ?></label>
            <select id="addressType" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="addressType">
              <?php foreach (lang('USER_ADDRESS_TYPE_LIST') as $key => $value) : ?>
              <option value="<?= $key; ?>" <?= $addressType == $key ? 'selected' : ''; ?> <?= $key == '' ? 'disabled' : '';  ?>>
                <?= $value; ?>
              </option>
              <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6">
            <label for="postalCode"><?= lang('USER_POSTAL_CODE') ?></label>
            <input id="postalCode" class="form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" type="text" name="postalCode"
              value="<?= $postalCode; ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6">
            <label for="state"><?= lang('USER_STATE') ?></label>
            <select id="state" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="state">
              <option value="<?= $stateCode; ?>"><?= $state; ?></option>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6">
            <label for="city"><?= lang('USER_CITY') ?></label>
            <select id="city" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="city" disabled>
              <option value="<?= $cityCod; ?>"><?= $city; ?></option>
            </select>
            <div class="help-block"></div>
          </div>
          <?php if($longProfile == 'S'): ?>
          <div class="form-group col-6">
            <label for="district"><?= lang('USER_DISTRICT') ?></label>
            <select id="district" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="district" disabled>
              <option value="<?= $districtCod ?>"><?= $district ?></option>
            </select>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <div class="form-group col-12 mb-2">
            <label for="address"><?= lang('USER_ADDRESS') ?></label>
            <textarea id="address" class="form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="address" row="2"><?= $address; ?></textarea>
            <div class="help-block"></div>
          </div>
        </div>
        <div class="row mx-1">
          <div class="form-group col-6 input-height">
            <label for="email"><?= lang('USER_EMAIL') ?></label>
            <input id="email" class="form-control <?= $updateUser; ?>" type="text" name="email" value="<?= $email; ?>"
              placeholder="usuario@ejemplo.com" autocomplete="off">
            <input id="oldEmail" type="hidden" name="oldEmail" value="<?= $email; ?>">
            <div class="help-block"></div>
          </div>
          <?php if (lang('CONF_UPDATE_USER') == 'ON') : ?>
          <div class="form-group col-6 input-height">
            <label for="email"><?= lang('USER_CONFIRM_EMAIL') ?></label>
            <input id="confirmEmail" class="form-control" type="text" name="confirmEmail" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
              autocomplete="off" onpaste="return false">
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <div class="form-group col-6 input-height <?= $skipLandLine; ?>">
            <label for="landLine"><?= lang('USER_PHONE_LANDLINE') ?></label>
            <input id="landLine" class="form-control <?= $updateUser; ?> <?= $ignoreLandLine ?>" type="text" name="landLine" value="<?= $landLine; ?>"
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="mobilePhone"><?= lang('USER_PHONE_MOBILE') ?></label>
            <input id="mobilePhone" class="form-control <?= $updateUser; ?>" type="text" name="mobilePhone" value="<?= $mobilePhone; ?>"
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="col-6 input-height <?= $skipOtherPhone; ?>">
            <label for="otherPhoneNum"><?= lang('USER_PHONE_OTHER') ?></label>
            <div class="form-row">
              <div class="form-group col-6">
                <select id="phoneType" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreOtherPhone; ?>" name="phoneType">
                  <?php foreach (lang('USER_OTHER_PHONE_LIST') as $key => $value) : ?>
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
      </div>
    </div>
    <?php if($longProfile == 'S'):?>
    <div class="col-12 pb-3 col-lg-6">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_LABOR_DATA') ?></h4>
        <div class="row mx-1">
          <div class="form-group col-6 input-height">
            <label for="fiscalId"><?= lang('GEN_FISCAL_REGISTRY') ?></label>
            <input id="fiscalId" class="form-control" type="text" name="fiscalId" autocomplete="off" value="<?= $fiscalId ?>" readonly>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="workplace"><?= lang('USER_WORK_CENTER') ?></label>
            <input id="workplace" class="form-control" type="text" name="workplace" autocomplete="off" value="<?= $workplace; ?>">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="employed"><?= lang('USER_EMPLOYMENT_STATUS') ?></label>
            <select id="employed" class="custom-select form-control" name="employed">
              <?php foreach (lang('USER_EMPLOY_SITUATION_LIST') as $key => $value) : ?>
              <option value="<?= $key; ?>" <?= $employed === $key ? 'selected' : ''; ?> <?= $key === '' ? 'selected disabled' : '';  ?>>
                <?= $value; ?>
              </option>
              <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 input-height">
            <label for="laborOld"><?= lang('USER_SENIORITY') ?></label>
            <select id="laborOld" class="custom-select form-control" name="laborOld">
              <?php if ($laborOld == ''): ?>
              <option selected disabled>Selecciona</option>
              <?php endif; ?>
              <?php for ($index = 0; $index <= 50; $index++): ?>
              <option value="<?= $index; ?>" <?= $index == $laborOld ? 'selected' : ''; ?>><?= $index; ?></option>
              <?php endfor; ?>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6 col-lg-12 col-xl-6 input-height">
            <label for="profession"><?= lang('USER_PROFESSION') ?></label>
            <select id="profession" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreProfession; ?>" name="profession">
              <option value="<?= $professionType; ?>" selected><?= $profession; ?></option>
            </select>
            <div class="help-block"></div>
          </div>

          <div class="form-group col-6 col-lg-12 col-xl-6 input-height">
            <label for="charge"><?= lang('USER_CHARGE') ?></label>
            <input id="chargeText" class="form-control" type="text" name="chargeText" autocomplete="off">
            <div class="help-block"></div>
          </div>

          <div class="form-group col-6 input-height">
            <label for="averageMonthly"><?= lang('USER_AVERAGE_MONTHLY') ?></label>
            <input id="averageMonthlyText" class="form-control" type="text" name="averageMonthlyText" autocomplete="off">
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
            <input id="publicPosition" class="form-control" disabled type="text" name="publicPosition" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-6">
            <label for="institution"><?= lang('USER_INSTITUTION') ?></label>
            <input id="institution" class="form-control" disabled type="text" name="institution" autocomplete="off">
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
              <input id="notEmail" class="custom-control-input" type="checkbox" name="notEmail" <?= $emailNot == '1' ? 'checked' : '' ?>
                <?= $disabled; ?>>
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
            <a class="btn btn-small btn-link px-0 hyper-link big-modal"
              href="<?= base_url(lang('GEN_LINK_CHANGE_PASS')); ?>"><?= lang('USER_PASSWORD_CHANGE') ?></a>
          </div>
          <?php if (lang('CONF_OPER_KEY') == 'ON') : ?>
          <div class="form-group col-6 col-lg-4">
            <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_OPER_PASS_CHANGE') ?></a>
          </div>
          <?php endif; ?>
          <?php if (lang('CONF_SMS_KEY') == 'ON') : ?>
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
          <?php if($longProfile == 'S'): ?>
          <div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
            <input id="acceptTermsProtection" class="custom-control-input" type="checkbox" name="acceptTerms"
              <?= $terms == '1' ? 'checked disabled' : '' ?>>
            <label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_PROTECTION'); ?></label>
            <div class="help-block"></div>
          </div>
          <div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
            <input id="acceptTermsContract" class="custom-control-input" type="checkbox" name="acceptTerms"
              <?= $terms == '1' ? 'checked disabled' : '' ?>>
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
