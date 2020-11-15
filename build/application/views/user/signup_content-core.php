<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3 pl-2"><?= lang('GEN_MENU_SIGNUP'); ?></h1>
<hr class="separador-one mb-2">
<p><?= novoLang(lang('USER_SIGNUP_MSG'), lang('GEN_SYSTEM_NAME')) ?></p>
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
  <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<form id="signUpForm" class="hide-out hide bg-color p-2">
  <input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
  <div class="row">

    <div class="col-12 col-lg-6 pb-3">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_PERSONAL_DATA')?></h4>
        <div class="row mx-1">
          <div class="form-group col-3 col-lg-6">
            <label for="idType"><?= lang('USER_ID_TYPE')?></label>
            <input id="idType" class="form-control" type="text" name="idType" value="<?= $idType; ?>" readonly autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="idNumber"><?= lang('USER_ID_NUMBER')?></label>
            <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idnumber; ?>" readonly autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="firstName"><?= lang('USER_FIRSTNAME')?></label>
            <input id="firstName" class="form-control" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?> autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="lastName"><?= lang('USER_LASTNAME')?></label>
            <input id="lastName" class="form-control" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?> autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="middleName"><?= lang('USER_MIDDLENAME')?></label>
            <input id="middleName" class="form-control" type="text" name="middleName" value="<?= $middleName; ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="surName"><?= lang('USER_SURNAME')?></label>
            <input id="surName" class="form-control" type="text" name="surName" value="<?= $surName; ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="birthDate"><?= lang('USER_BIRTHDATE')?></label>
            <input id="birthDate" class="form-control date-picker" type="text" name="birthDate" value="<?= $birthDate; ?>" readonly
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <?php if($longProfile == 'S'):?>
          <div class="form-group col-3 col-lg-6">
            <label for="nationality"><?= lang('USER_NATIONALITY') ?></label>
            <input id="nationality" class="form-control" type="text" name="nationality" value="">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="placeBirth"><?= lang('USER_PLACEBIRTH') ?></label>
            <input id="placeBirth" class="form-control" type="text" name="placeBirth" value="">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="civilStatus"><?= lang('USER_CIVILSTATUS') ?></label>
            <select id="civilStatus" class="custom-select form-control" name="civilStatus">
              <?php foreach (lang('USER_CIVILSTATUS_LIST') as $key => $value) : ?>
              <option value="<?= $key; ?>" <?= $key == '' ? 'selected disabled' : '';  ?>><?= $value; ?></option>
              <?php endforeach; ?>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="verifierCode"><?= lang('USER_VERIFIERCODE') ?></label>
            <input id="verifierCode" class="form-control" type="text" name="verifierCode">
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <div class="form-group col-3 col-lg-6">
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
      </div>
    </div>

    <div class="col-12 col-lg-6 pb-3">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_CONTACT_DATA')?></h4>
        <div class="row mx-1">
          <?php if($longProfile == 'S'):?>
          <div class="form-group col-3 col-lg-6">
            <label for="addressType"><?= lang('USER_ADDRESS_TYPE') ?></label>
            <select id="addressType" class="custom-select form-control" name="addressType">
              <option value=""></option>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="postalCode"><?= lang('USER_POSTAL_CODE') ?></label>
            <input id="postalCode" class="form-control" type="text" name="postalCode" value="" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="department"><?= lang('USER_STATE') ?></label>
            <select id="department" class="custom-select form-control" name="department">
              <option value=""></option>
            </select>
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="city"><?= lang('USER_CITY') ?></label>
            <select id="city" class="custom-select form-control" name="city">
              <option value=""></option>
            </select>
            <div class="help-block"></div>
          </div>
					<?php if($longProfile == 'S'):?>
          <div class="form-group col-3 col-lg-6">
            <label for="district"><?= lang('USER_DISTRICT') ?></label>
            <select id="district" class="custom-select form-control" name="district">
              <option value=""></option>
            </select>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
          <div class="form-group col-12 col-lg-8 col-xl-12">
            <label for="address"><?= lang('USER_ADDRESS') ?></label>
            <textarea id="address" class="form-control" name="address"></textarea>
            <div class="help-block"></div>
          </div>
          <?php endif; ?>
        </div>
        <div class="row mx-1">
          <div class="form-group col-3 col-lg-6">
            <label for="email"><?= lang('USER_EMAIL')?></label>
            <input id="email" class="form-control" type="email" name="email" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
              autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="confirmEmail"><?= lang('USER_CONFIRM_EMAIL') ?></label>
            <input id="confirmEmail" class="form-control" type="email" name="confirmEmail" value="<?= $email; ?>" placeholder="usuario@ejemplo.com"
              autocomplete="off" onpaste="return false">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6 <?= $skipLandLine ?>">
            <label for="landLine"><?= lang('USER_PHONE_LANDLINE')?></label>
            <input id="landLine" class="form-control" type="text" name="landLine" value="<?= $landLine ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-3 col-lg-6">
            <label for="mobilePhone"><?= lang('USER_PHONE_MOBILE')?></label>
            <input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= $mobilePhone ?>" autocomplete="off">
            <div class="help-block"></div>
          </div>
          <div class="form-group col-12 <?= $skipOtherPhone ?>">
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
      </div>
    </div>
    <?php if($longProfile == 'S'):?>
    <div class="col-12 pb-3 col-lg-6">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_LABOR_DATA') ?></h4>
        <div class="row mx-1">
          <div class="form-group col-4 col-lg-6">
            <label for="idRUC"><?= lang('GEN_FISCAL_REGISTRY') ?></label>
            <input id="idRUCText" class="form-control" type="text" name="idRUCText" autocomplete="off" readonly>
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
              <?php foreach (lang('USER_EMPLOYMENT_STATUS_LIST') as $key => $value) : ?>
              <option value="<?= $key; ?>" <?= $key == '' ? 'selected disabled' : '';  ?>><?= $value; ?></option>
              <?php endforeach; ?>
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
    <div class="dataUser col-12 pb-3 <?= $dataUser; ?>">
      <div class="bg-secondary p-2 h-100">
        <h4 class="mt-1 pb-2 h4"><?= lang('USER_DATA_USER') ?></h4>
        <div class="row mx-1">
          <div class="col-12 <?= $dataPass; ?>">
            <div class="row">
              <div class="form-group col-12 col-lg-12">
                <div class="col-lg-6 pl-lg-0 pr-lg-2 pl-0 pr-0">
                  <label for="nickName"><?= lang('GEN_USER'); ?></label>
                  <div class="input-group">
                    <input id="nickName" class="form-control pwd-input available" type="text" name="nickName">
                  </div>
                  <div class="help-block"></div>
                </div>
              </div>
              <div class="form-group col-12 col-lg-6">
                <label for="newPass"><?= lang('GEN_PASSWORD'); ?></label>
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
                <label for="confirmPass"><?= lang('GEN_PASSWORD_CONFIRM'); ?></label>
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
      </div>
    </div>

    <?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
    <div class="col-12 pb-3">
      <div class="bg-secondary p-2">
        <?php $this->load->view('user/loadDocuments_content-core') ?>
      </div>
    </div>
    <?php endif; ?>
    <?php if($longProfile == 'S'):?>
    <div class="col-12 pb-3">
      <div class="bg-secondary p-2">
        <div class="row mx-1">
          <div class="form-group custom-control custom-switch col-12 col-lg-4 pt-1 mb-0">
            <input id="TermsProtectionRegistry" class="custom-control-input" type="checkbox" name="TermsProtectionRegistry">
            <label class="custom-control-label" for="TermsProtectionRegistry"><?= lang('USER_ACCEPT_PROTECTION'); ?></label>
            <div class="help-block"></div>
          </div>
          <div class="form-group custom-control custom-switch col-12 col-lg-8 pt-1 mb-0">
            <input id="TermsContractRegistry" class="custom-control-input" type="checkbox" name="TermsContractRegistry">
            <label class="custom-control-label" for="TermsContractRegistry"><?= lang('USER_ACCEPT_CONTRACT'); ?></label>
            <div class="help-block"></div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <hr class="separador-one mt-2 mb-4">
  <div class="flex items-center justify-end mb-5 mr-5">
    <a class="btn btn-small btn-link big-modal" href="<?= base_url('inicio') ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
    <button id="signUpBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
  </div>
</form>
