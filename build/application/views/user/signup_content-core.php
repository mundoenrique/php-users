<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="h3 semibold pl-2"><?= lang('GEN_MENU_SIGNUP'); ?></h1>
<hr class="separador-one mb-2">
<p><?= novoLang(lang('USER_SIGNUP_MSG'), lang('GEN_SYSTEM_NAME')) ?></p>
<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
  <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>

<div class="row mx-auto hide-out hide">
  <div class="multi-step-form col-10 mt-2 mx-auto bg-white px-0">
    <div class="progress-container row <?= $dataStep; ?> mt-5 mb-3 mx-auto pb-5 px-5 center">
      <?php foreach ($stepTitles as $key => $value) : ?>
      <?php if ($key + 1 < count($stepTitles)) : ?>
      <div class="progress col p-0">
        <div class="progress-bar" data-index=<?= $key + 1; ?> role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
          <?php endif; ?>
          <div data-index=<?= $key + 1; ?> class="progress-icon<?= $key == 0 ? ' active' : '' ?>">
            <span class="material-icons h3"> <?= $key + 1; ?> </span>
            <span class="text progress-text px-4 h5"><?= $value; ?></span>
          </div>
          <?php if ($key + 2 != count($stepTitles)) : ?>
        </div>
      </div>
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <div class="line-text mt-1"></div>
    <div class="form-container mt-1 shadow">
      <form id="signUpForm" class="hide-out hide p-2">
        <input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
        <input id="generalAccount" type="hidden" name="generalAccount" value="<?= $generalAccount; ?>">
        <input id="CurrentVerifierCode" type="hidden" name="CurrentVerifierCode" value="<?= $CurrentVerifierCode; ?>">
        <div class="row">
          <!-- Datos personales -->
          <?php $index = array_search(lang('USER_PERSONAL_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> active seen border-none" data-index=<?= $index ?>>
            <div class="col-12 pb-3">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
									<div class="form-group col-6 col-lg-3 input-height">
                    <label for="firstName"><?= lang('USER_FIRSTNAME')?></label>
                    <input id="firstName" class="form-control" type="text" name="firstName" value="<?= $firstName; ?>" <?= $updateName; ?>
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
									<div class="form-group col-6 col-lg-3 input-height">
                    <label for="middleName"><?= lang('USER_MIDDLENAME')?></label>
                    <input id="middleName" class="form-control" type="text" name="middleName" value="<?= $middleName; ?>" <?= $updateLastName; ?>
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="lastName"><?= lang('USER_LASTNAME') ?></label>
                    <input id="lastName" class="form-control" type="text" name="lastName" value="<?= $lastName; ?>" <?= $updateName; ?>
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="surName"><?= lang('USER_SURNAME')?></label>
                    <input id="surName" class="form-control" type="text" name="surName" value="<?= $surName; ?>" <?= $updateLastName; ?>
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-xl-3 input-height">
                    <label for="idType"><?= lang('USER_ID_TYPE')?></label>
                    <input id="idType" class="form-control" type="text" name="idType" value="<?= $idType; ?>" readonly autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-xl-3 input-height">
                    <label for="idNumber"><?= lang('USER_ID_NUMBER')?></label>
                    <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idnumber; ?>" readonly autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="birthDate"><?= lang('USER_BIRTHDATE')?></label>
                    <input id="birthDate" class="form-control date-picker" type="text" name="birthDate" value="<?= $birthDate; ?>" readonly
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <?php if ($longProfile == 'S') : ?>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="nationality"><?= lang('USER_NATIONALITY') ?></label>
                    <input id="nationality" class="form-control" type="text" name="nationality" value="">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="birthPlace">
											<?= lang('USER_PLACEBIRTH') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <input id="birthPlace" class="form-control" type="text" name="birthPlace" value="">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="civilStatus">
											<?= lang('USER_CIVILSTATUS') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <select id="civilStatus" class="custom-select form-control" name="civilStatus">
                      <?php foreach (lang('USER_CIVILSTATUS_LIST') as $key => $value) : ?>
                      <option value="<?= $key; ?>" <?= $key == '' ? 'selected disabled' : '';  ?>><?= $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="verifierCode"><?= lang('USER_VERIFIERCODE') ?></label>
                    <input id="verifierCode" class="form-control" type="text" name="verifierCode">
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group col-6 col-lg-3">
                    <label class="block"><?= lang('USER_GENDER') ?></label>
                    <div class="flex">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M" autocomplete="off">
                        <label class="custom-control-label" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F" autocomplete="off">
                        <label class="custom-control-label" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
                      </div>
                    </div>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button mb-5">
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
              </div>
            </div>
          </fieldset>
          <!-- Datos de contacto -->
          <?php $index = array_search(lang('USER_CONTACT_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> border-none col-12" data-index=<?= $index ?>>
            <div class="col-12 pb-3">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <?php if ($longProfile == 'S') : ?>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="addressType"><?= lang('USER_ADDRESS_TYPE') ?></label>
                    <select id="addressType" class="custom-select form-control" name="addressType">
                      <?php foreach (lang('USER_ADDRESS_TYPE_LIST') as $key => $value) : ?>
                      <option value="<?= $key; ?>" <?= $key == '' ? 'selected disabled' : '';  ?>>
                        <?= $value; ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label class="truncate" for="postalCode">
											<?= lang('USER_POSTAL_CODE') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span></label>
                    <input id="postalCode" class="form-control" type="text" name="postalCode" value="" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="state"><?= lang('USER_STATE') ?></label>
                    <select id="state" class="custom-select form-control" name="state">
                      <option value=""><?= lang('GEN_SELECTION') ?></option>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="city"><?= lang('USER_CITY') ?></label>
                    <select id="city" class="custom-select form-control" name="city" disabled>
                      <option value=""><?= lang('GEN_SELECTION') ?></option>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <?php if ($longProfile == 'S'): ?>
                  <div class="form-group col-6 input-height">
                    <label for="district"><?= lang('USER_DISTRICT') ?></label>
                    <select id="district" class="custom-select form-control" name="district" disabled>
                      <option value=""><?= lang('GEN_SELECTION') ?></option>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group col-12">
                    <label for="address"><?= lang('USER_ADDRESS') ?></label>
                    <textarea id="address" class="form-control" name="address" row="2" onpaste="return false"></textarea>
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="row mx-1">
                  <div class="form-group col-6 col-lg-4 input-height">
                    <label for="email"><?= lang('USER_EMAIL') ?></label>
                    <input id="email" class="form-control" type="email" name="email" value="<?= $email; ?>" <?= $updateEmail; ?>
                      placeholder="usuario@ejemplo.com" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-4 input-height  <?= $skipConfirmEmail; ?>">
                    <label for="confirmEmail"><?= lang('USER_CONFIRM_EMAIL') ?></label>
                    <input id="confirmEmail" class="form-control" type="text" name="confirmEmail" value="<?= $email; ?>"
                      placeholder="usuario@ejemplo.com" <?= $updateEmail; ?> autocomplete="off" onpaste="return false">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-4 input-height <?= $skipLandLine ?>">
                    <label class="truncate" for="landLine">
											<?= lang('USER_PHONE_LANDLINE')?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <input id="landLine" class="form-control" type="text" name="landLine" value="<?= $landLine ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-4 input-height">
                    <label for="mobilePhone"><?= lang('USER_PHONE_MOBILE') ?></label>
                    <input id="mobilePhone" class="form-control" type="text" name="mobilePhone" value="<?= $mobilePhone ?>" <?= $updatePhone; ?>
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-12 col-lg-8 <?= $skipOtherPhone ?>">
                    <label for="otherPhoneNum">
											<?= lang('USER_PHONE_OTHER') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <div class="form-row">
                      <div class="form-group col-6 input-height">
                        <select id="phoneType" class="custom-select form-control" name="phoneType">
                          <?php foreach (lang('USER_OTHER_PHONE_LIST') as $key => $value) : ?>
                          <option value="<?= $key; ?>"><?= $value; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="help-block"></div>
                      </div>
                      <div class="form-group col-6 input-height">
                        <input id="otherPhoneNum" class="form-control" type="text" name="otherPhoneNum" value="" autocomplete="off">
                        <div class="help-block"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
              </div>
            </div>
          </fieldset>
          <?php if ($longProfile == 'S') : ?>
          <!-- Datos laborales -->
          <?php $index = array_search(lang('USER_LABOR_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> border-none" data-index=<?= $index ?>>
            <div class="col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="fiscalId"><?= lang('USER_FISCAL_REGISTRY') ?></label>
                    <input id="fiscalId" class="form-control" type="text" name="fiscalId" value="<?= $fiscalId ?>" autocomplete="off" readonly>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="workplace"><?= lang('USER_WORK_CENTER') ?></label>
                    <input id="workplace" class="form-control" type="text" name="workplace" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="employed"><?= lang('USER_EMPLOYMENT_STATUS') ?></label>
                    <select id="employed" class="custom-select form-control" name="employed">
                      <?php foreach (lang('USER_EMPLOYMENT_STATUS_LIST') as $key => $value) : ?>
                      <option value="<?= $key; ?>" <?= $key === '' ? 'selected disabled' : '';  ?>><?= $value; ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="laborOld"><?= lang('USER_SENIORITY') ?></label>
                    <select id="laborOld" class="custom-select form-control" name="laborOld">
                      <option selected disabled><?= lang('GEN_SELECTION') ?></option>
                      <?php for ($index = 0; $index <= 50; $index++): ?>
                      <option value="<?= $index; ?>"><?= $index; ?></option>
                      <?php endfor; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 input-height">
                    <label for="profession"><?= lang('USER_PROFESSION') ?></label>
                    <select id="profession" class="custom-select form-control" name="profession" disabled>
                      <option value=""><?= lang('GEN_SELECTION') ?></option>
                    </select>
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="position">
											<?= lang('USER_CHARGE') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <input id="position" class="form-control" type="text" name="position" value="" autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="averageIncome">
											<?= lang('USER_AVERAGE_MONTHLY') ?>
											<span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
										</label>
                    <input id="averageIncome" class="form-control text-right" type="text" name="averageIncome" value="" autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-12 center">
                    <label class="block"><?= lang('USER_PUBLIC_OFFICE') ?></label>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="yesPublicOfficeOld" class="custom-control-input" type="radio" name="publicOfficeOld" value="yes" autocomplete="off">
                      <label class="custom-control-label" for="yesPublicOfficeOld"><?= lang('GEN_BTN_YES') ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="noPublicOfficeOld" class="custom-control-input" type="radio" name="publicOfficeOld" value="no" autocomplete="off">
                      <label class="custom-control-label" for="noPublicOfficeOld"><?= lang('GEN_BTN_NO') ?></label>
                    </div>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 input-height">
                    <label for="publicOffice"><?= lang('USER_PUBLIC_POSITION') ?></label>
                    <input id="publicOffice" class="form-control ignore" type="text" name="publicOffice" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 input-height">
                    <label for="publicInst"><?= lang('USER_INSTITUTION') ?></label>
                    <input id="publicInst" class="form-control ignore" type="text" name="publicInst" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-12 pt-2 center mb-2">
                    <label class="block"><?= lang('USER_ARTICLE_LAW') ?></label>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="yesTaxesObligated" class="custom-control-input" type="radio" name="taxesObligated" value="yes">
                      <label class="custom-control-label" for="yesTaxesObligated"><?= lang('GEN_BTN_YES') ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="noTaxesObligated" class="custom-control-input" type="radio" name="taxesObligated" value="no">
                      <label class="custom-control-label" for="noTaxesObligated"><?= lang('GEN_BTN_NO') ?></label>
                    </div>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
              </div>
            </div>
          </fieldset>
          <!-- Datos de usuario -->
          <?php $index = array_search(lang('USER_DATA_USER'), $stepTitles) + 1; ?>
          <fieldset class="col-12 form-group ms-step-<?= $index ?> border-none" data-index=<?= $index ?>>
            <div class="dataUser col-12 pb-3">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="col-6">
                    <div class="row">
                      <div class="form-group col-12">
                        <div class="col-lg-6 pl-lg-0 pl-0 pr-0 input-height">
                          <label for="nickName"><?= lang('GEN_USER'); ?></label>
                          <div class="input-group">
                            <input id="nickName" class="form-control pwd-input available" type="text" name="nickName">
                          </div>
                          <div class="help-block"></div>
                        </div>
                      </div>
                      <div class="form-group col-12 col-lg-6 input-height">
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
                      <div class="form-group col-12 col-lg-6 input-height">
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
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
              </div>
            </div>
          </fieldset>
          <?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
          <!-- Carga de documentos -->
          <?php $index = array_search(lang('USER_LOAD_DOCS_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> border-none" data-index=<?= $index ?>>
            <?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
            <div class="col-12 pb-3">
              <div class="bg-secondary">
                <?php $this->load->view('user/loadDocuments_content-core') ?>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
              </div>
            </div>
            <?php endif; ?>
          </fieldset>
          <?php endif; ?>
          <!-- Legales -->
          <?php $index = array_search(lang('USER_LEGAL_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> border-none w-100" data-index=<?= $index ?>>
            <div class="col-12 pb-3">
              <div class="bg-secondary p-2">
                <div class="row mx-1">
                  <div class="form-group custom-control custom-switch col-6 pt-1 mb-0">
                    <input id="protection" class="custom-control-input" type="checkbox" name="protection" value="1">
                    <label class="custom-control-label" for="protection"><?= lang('USER_ACCEPT_PROTECTION'); ?></label>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group custom-control custom-switch col-6 pt-1 mb-0">
                    <input id="contract" class="custom-control-input" type="checkbox" name="contract" value="1">
                    <label class="custom-control-label" for="contract"><?= lang('USER_ACCEPT_CONTRACT'); ?></label>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button flex items-center justify-end mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button id="signUpBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONFIRM'); ?></button>
              </div>
            </div>
          </fieldset>
          <?php else : ?>
          <!-- Datos de usuario -->
          <?php $index = array_search(lang('USER_DATA_USER'), $stepTitles) + 1; ?>
          <fieldset class="col-12 form-group ms-step-<?= $index ?> border-none" data-index=<?= $index ?>>
            <div class="dataUser col-12 pb-3">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="col-6">
                    <div class="row">
                      <div class="form-group col-12">
                        <div class="col-lg-12 pl-lg-0 pl-0 pr-0 input-height">
                          <label for="nickName"><?= lang('GEN_USER'); ?></label>
                          <div class="input-group">
                            <input id="nickName" class="form-control pwd-input available" type="text" name="nickName">
                          </div>
                          <div class="help-block"></div>
                        </div>
                      </div>
                      <div class="form-group col-12 col-lg-6 input-height">
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
                      <div class="form-group col-12 col-lg-6 input-height">
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
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button flex items-center justify-end mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <?php if ($index == count($stepTitles)) : ?>
                <button id="signUpBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONFIRM'); ?></button>
                <?php else : ?>
                <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
                <?php endif; ?>
              </div>
            </div>
          </fieldset>
          <?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
          <!-- Carga de documentos -->
          <?php $index = array_search(lang('USER_LOAD_DOCS_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> border-none" data-index=<?= $index ?>>
            <?php if (lang('CONF_LOAD_DOCS') == 'ON') : ?>
            <div class="col-12 pb-3">
              <div class="bg-secondary">
                <?php $this->load->view('user/loadDocuments_content-core') ?>
              </div>
            </div>
            <div class="flex justify-between mx-5">
              <div>
								<a class="btn btn-small hyper-link p-0" href="<?= base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START')) ?>">
									<i class="icon icon-cancel" aria-hidden="true"> &nbsp;</i><?= lang('GEN_BTN_EXIT'); ?>
								</a>
              </div>
              <div class="multi-step-button flex items-center justify-end mb-5">
                <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
                <button id="signUpBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONFIRM'); ?></button>
              </div>
            </div>
            <?php endif; ?>
          </fieldset>
          <?php endif; ?>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </div>
</div>
