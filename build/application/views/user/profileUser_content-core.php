<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="h3 semibold pl-2"><?= lang('USER_PROFILE_TITLE'); ?></h1>
<hr class="separador-one">
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
      <form id="profileUserForm" method="post" class="hide-out hide p-2">
        <input id="longProfile" type="hidden" name="longProfile" value="<?= $longProfile; ?>">
        <input id="generalAccount" type="hidden" name="generalAccount" value="<?= $generalAccount; ?>">
        <input id="addresInput" type="hidden" name="addresInput" value="<?= $addresInput; ?>">
        <div class="row">
          <!-- Datos personales -->
          <?php $index = array_search(lang('USER_PERSONAL_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> mb-0 active seen border-none" data-index=<?= $index ?>>
            <div class="col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="firstName"><?= lang('USER_FIRSTNAME') ?></label>
                    <input id="firstName" class="form-control <?= $updateUser; ?>" type="text" name="firstName" value="<?= $firstName; ?>"
                      <?= $updateName; ?> autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="middleName"><?= lang('USER_MIDDLENAME') ?></label>
                    <input id="middleName" class="form-control <?= $updateUser; ?>" type="text" name="middleName" value="<?= $middleName; ?>"
                      <?= $updateSecondName; ?> autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="lastName"><?= lang('USER_LASTNAME') ?></label>
                    <input id="lastName" class="form-control <?= $updateUser; ?>" type="text" name="lastName" value="<?= $lastName; ?>"
                      <?= $updateName; ?> autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="surName"><?= lang('USER_SURNAME') ?></label>
                    <input id="surName" class="form-control <?= $updateUser; ?>" type="text" name="surName" value="<?= $surName; ?>"
                      <?= $updateSecondName; ?> autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-xl-3 input-height">
                    <label for="idType"><?= lang('USER_ID_TYPE') ?></label>
                    <input id="idTypeText" class="form-control" type="text" name="idTypeText" value="<?= $idTypeText; ?>" readonly autocomplete="off">
                    <input id="idType" type="hidden" name="idType" value="<?= $idTypeCode; ?>">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-xl-3 input-height">
                    <label for="idNumber"><?= lang('USER_ID_NUMBER') ?></label>
                    <input id="idNumber" class="form-control" type="text" name="idNumber" value="<?= $idNumber ?>" readonly autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="birthDate"><?= lang('USER_BIRTHDATE') ?></label>
                    <input id="birthDate" class="form-control <?= $updateUser; ?>" type="text" name="birthDate" value="<?= $birthday; ?>" readonly
                      autocomplete="off" placeholder="<?= lang('GEN_DATEPICKER_DATELARGE'); ?>">
                    <div class="help-block"></div>
                  </div>
                  <?php if ($longProfile == 'S') : ?>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="nationality"><?= lang('USER_NATIONALITY') ?></label>
                    <input id="nationality" class="form-control <?= $updateUser; ?>" type="text" name="nationality" value="<?= $nationality; ?>"
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="birthPlace">
                      <?= lang('USER_PLACEBIRTH') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <input id="birthPlace" class="form-control <?= $updateUser; ?>" type="text" name="birthPlace" value="<?= $birthPlace; ?>">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="civilStatus">
                      <?= lang('USER_CIVILSTATUS') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <select id="civilStatus" class="custom-select form-control <?= $updateUser; ?>" name="civilStatus">
                      <?php foreach (lang('USER_CIVILSTATUS_LIST') as $key => $value) : ?>
                      <option value="<?= $key; ?>" <?= $civilStatus == $key ? 'selected' : ''; ?> <?= $key == '' ? 'selected disabled' : '';  ?>>
                        <?= $value; ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="verifierCode"><?= lang('USER_VERIFIERCODE') ?></label>
                    <input id="verifierCode" class="form-control <?= $updateUser; ?>" type="text" name="verifierCode" value="<?= $verifierCode; ?>"
                      maxlength="1" <?= $verifierCode != '' ? 'readonly' : ''; ?>>
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group col-6 col-lg-3">
                    <label class="block"><?= lang('USER_GENDER') ?></label>
                    <div class="flex">
                      <div class="custom-control custom-radio custom-control-inline">
                        <input id="genderMale" class="custom-control-input" type="radio" name="gender" value="M"
                          <?= $gender == 'M' ? 'checked' : ''; ?> <?= $disabled; ?>>
                        <label class="custom-control-label <?= $updateUser; ?>" for="genderMale"><?= lang('USER_GENDER_MALE'); ?></label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input id="genderFemale" class="custom-control-input" type="radio" name="gender" value="F"
                          <?= $gender == 'F' ? 'checked' : ''; ?> <?= $disabled; ?>>
                        <label class="custom-control-label <?= $updateUser; ?>" for="genderFemale"><?= lang('USER_GENDER_FEMALE'); ?></label>
                      </div>
                    </div>
                    <div class="help-block"></div>
                  </div>
                  <?php if ($longProfile == 'N'): ?>
                  <div class="form-group col-6 col-lg-3 input-height <?= $skipProfession; ?>">
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
          </fieldset>
          <!-- Datos de contacto -->
          <?php $index = array_search(lang('USER_CONTACT_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> mb-0 border-none col-12" data-index=<?= $index ?>>
            <div class="col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1 <?= $skipContacData; ?>">
                  <?php if (lang('SETT_INTERNATIONAL_ADDRESS') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="country"><?= lang('USER_COUNTRY') ?></label>
                    <select id="country" class="custom-select form-control" name="country">
                      <option value="" disabled selected><?= lang('GEN_SELECTION') ?></option>
                      <?php foreach (lang('USER_COUNTRIES') AS $countries): ?>
                      <?php if ($countries['status'] === '1'): ?>
                      <option value="<?= $countries['iso']; ?>" code="<?= $countries['code']; ?>"
                        <?= $countryIso == $countries['iso'] ? 'selected' : ''; ?>>
                        <?= $countries['name']; ?>
                      </option>
                      <?php endif; ?>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group col-6 col-lg-3 input-height">
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
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label class="truncate" for="postalCode">
                      <?= lang('USER_POSTAL_CODE') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <input id="postalCode" class="form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" type="text" name="postalCode"
                      value="<?= $postalCode; ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="state"><?= lang('USER_STATE') ?></label>
                    <select id="state" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="state">
                      <option value="<?= $stateCode ? '00000' : ''; ?>" selected><?= lang('GEN_SELECTION'); ?></option>
                    </select>
										<input type="hidden" id="stateInput" name="stateInput" class="form-control" value="<?= $state ?>" autocomplete="off"
											state-code="<?= $stateCode; ?>">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="city"><?= lang('USER_CITY') ?></label>
                    <select id="city" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="city">
                      <option value="<?= $cityCode ? '00000' : ''; ?>" selected><?= lang('GEN_SELECTION'); ?></option>
                    </select>
                    <input type="hidden" id="cityInput" name="cityInput" class="form-control" value="<?= $city ?>" autocomplete="off"
                      city-code="<?= $cityCode; ?>">
                    <div class="help-block"></div>
                  </div>
                  <?php if($longProfile == 'S' || lang('SETT_INTERNATIONAL_ADDRESS') == 'ON'): ?>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="district"><?= lang('USER_DISTRICT') ?></label>
                    <select id="district" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="district">
                      <option value="<?= $districtCode ? '00000' : ''; ?>" selected><?= lang('GEN_SELECTION'); ?></option>
                    </select>
                    <input type="hidden" id="districtInput" name="districtInput" class="form-control" value="<?= $district ?>" autocomplete="off"
                      district-code="<?= $districtCode ?>">
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>
                  <div class="form-group col-12">
                    <label for="address"><?= lang('USER_ADDRESS') ?></label>
                    <textarea id="address" class="form-control <?= $updateUser; ?> <?= $ignoreContacData; ?>" name="address" row="2"
                      onpaste="return false"><?= $address; ?></textarea>
                    <div class="help-block"></div>
                  </div>
                </div>
                <div class="row mx-1">
                  <div class="form-group col-6 col-lg-4 input-height">
                    <label for="email"><?= lang('USER_EMAIL') ?></label>
                    <input id="email" class="form-control <?= $updateUser; ?>" type="text" name="email" value="<?= $email; ?>" <?= $updateEmail; ?>
                      placeholder="usuario@ejemplo.com" autocomplete="off">
                    <input id="oldEmail" type="hidden" name="oldEmail" value="<?= $email; ?>">
                    <div class="help-block"></div>
                  </div>
                  <?php if (lang('SETT_UPDATE_USER') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-4 input-height <?= $skipConfirmEmail; ?>">
                    <label for="confirmEmail"><?= lang('USER_CONFIRM_EMAIL') ?></label>
                    <input id="confirmEmail" class="form-control" type="text" name="confirmEmail" value="<?= $email; ?>"
                      placeholder="usuario@ejemplo.com" autocomplete="off" onpaste="return false">
                    <div class="help-block"></div>
                  </div>
                  <?php endif; ?>

									<?php if (lang('SETT_INTERNATIONAL_ADDRESS') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-2 input-height">
                    <label for="internationalCode"><?= lang('USER_CODE_INTERNATIONAL') ?></label>
                    <div class="container-flags truncate col-4 p-0">
                      <input id="internationalCode" class="select-flags <?= $countryIso != 'off' ? 'country-' . $countryIso : ''; ?>" type="text"
                        name="internationalCode" placeholder="<?= lang('GEN_COUNTRY_CODE') ?>" iso="<?= $countryIso; ?>" value="<?= $countryCode; ?>"
                        readonly>
                      <ul class="codeOptions">
                        <?php foreach (lang('USER_COUNTRIES') AS $countries): ?>
                        <?php if ($countries['status'] === '1'): ?>
                        <li iso="<?= $countries['iso']; ?>">
                          <i class="country-<?= $countries['iso']; ?>"></i>
                          <?= $countries['name']; ?>
                          <span class="code-country text"> <?= $countries['code']; ?></span>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                    <div class="help-block"></div>
                  </div>
									<?php endif; ?>

                  <div class="form-group col-6 <?= $longMobile; ?> input-height">
                    <label for="mobilePhone"><?= lang('GEN_PHONE_MOBILE') ?></label>
                    <input id="mobilePhone" class="form-control <?= $updateUser; ?>" type="text" name="mobilePhone" value="<?= $mobilePhone; ?>"
                      <?= $updatePhoneMobile; ?> autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 col-lg-4 input-height <?= $skipLandLine; ?>">
                    <label class="truncate" for="landLine">
                      <?= lang('USER_PHONE_LANDLINE') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <input id="landLine" class="form-control <?= $updateUser; ?> <?= $ignoreLandLine ?>" type="text" name="landLine"
                      value="<?= $landLine; ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-12 col-lg-8  input-height <?= $skipOtherPhone; ?>">
                    <label for="otherPhoneNum">
                      <?= lang('USER_PHONE_OTHER') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <div class="form-row">
                      <div class="form-group col-6 input-height">
                        <select id="phoneType" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreOtherPhone; ?>" name="phoneType">
                          <?php foreach (lang('USER_OTHER_PHONE_LIST') as $key => $value) : ?>
                          <option value="<?= $key; ?>" <?= $otherType == $key ? 'selected' : ''; ?>><?= $value; ?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="help-block"></div>
                      </div>
                      <div class="form-group col-6 input-height">
                        <input id="otherPhoneNum" class="form-control <?= $updateUser; ?>" type="text" name="otherPhoneNum"
                          value="<?= $otherPhoneNum; ?>" <?= $otherPhoneNum == '' ? 'disabled' : '' ?> autocomplete="off">
                        <div class="help-block"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <?php if ($longProfile == 'S') : ?>
          <!-- Datos laborales -->
          <?php $index = array_search(lang('USER_LABOR_DATA'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> mb-0 border-none" data-index=<?= $index ?>>
            <div class="col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="fiscalId"><?= lang('USER_FISCAL_REGISTRY') ?></label>
                    <input id="fiscalId" class="form-control" type="text" name="fiscalId" autocomplete="off" value="<?= $fiscalId ?>" readonly>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="workplace"><?= lang('USER_WORK_CENTER') ?></label>
                    <input id="workplace" class="form-control" type="text" name="workplace" autocomplete="off" value="<?= $workplace; ?>">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="employed"><?= lang('USER_EMPLOYMENT_STATUS') ?></label>
                    <select id="employed" class="custom-select form-control" name="employed">
                      <?php foreach (lang('USER_EMPLOY_SITUATION_LIST') as $key => $value) : ?>
                      <option value="<?= $key; ?>" <?= $employed == $key ? 'selected' : ''; ?> <?= $key === '' ? 'selected disabled' : '';  ?>>
                        <?= $value; ?>
                      </option>
                      <?php endforeach; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="laborOld"><?= lang('USER_SENIORITY') ?></label>
                    <select id="laborOld" class="custom-select form-control" name="laborOld">
                      <?php if ($laborOld === ''): ?>
                      <option selected disabled><?= lang('GEN_SELECTION') ?></option>
                      <?php endif; ?>
                      <?php for ($index = 0; $index <= 50; $index++): ?>
                      <option value="<?= $index; ?>" <?= $index == $laborOld ? 'selected' : ''; ?>><?= $index; ?></option>
                      <?php endfor; ?>
                    </select>
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 input-height">
                    <label for="profession"><?= lang('USER_PROFESSION') ?></label>
                    <select id="profession" class="custom-select form-control <?= $updateUser; ?> <?= $ignoreProfession; ?>" name="profession">
                      <option value="<?= $professionType; ?>" selected><?= $profession; ?></option>
                    </select>
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="position">
                      <?= lang('USER_CHARGE') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <input id="position" class="form-control" type="text" name="position" value="<?= $position ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-6 col-lg-3 input-height">
                    <label for="averageIncome">
                      <?= lang('USER_AVERAGE_MONTHLY') ?>
                      <span class="regular"><?= lang('GEN_OPTIONAL_FIELD') ?></span>
                    </label>
                    <input id="averageIncome" class="form-control text-right" type="text" name="averageIncome" value="<?= $averageIncome ?>"
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>

                  <div class="form-group col-12 center">
                    <label class="block"><?= lang('USER_PUBLIC_OFFICE') ?></label>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="yesPublicOfficeOld" class="custom-control-input" type="radio" name="publicOfficeOld" value="yes"
                        <?= $publicOfficeOld == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="yesPublicOfficeOld"><?= lang('GEN_BTN_YES') ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="noPublicOfficeOld" class="custom-control-input" type="radio" name="publicOfficeOld" value="no"
                        <?= $publicOfficeOld == '0' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="noPublicOfficeOld"><?= lang('GEN_BTN_NO') ?></label>
                    </div>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 input-height">
                    <label for="publicOffice"><?= lang('USER_PUBLIC_POSITION') ?></label>
                    <input id="publicOffice" class="form-control" type="text" name="publicOffice" value="<?= $publicOffice; ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-6 input-height">
                    <label for="publicInst"><?= lang('USER_INSTITUTION') ?></label>
                    <input id="publicInst" class="form-control" type="text" name="publicInst" value="<?= $publicInst; ?>" autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-12 pt-2 center mb-2">
                    <label class="block"><?= lang('USER_ARTICLE_LAW') ?></label>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="yesTaxesObligated" class="custom-control-input" type="radio" name="taxesObligated" value="yes"
                        <?= $taxesObligated == '1' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="yesTaxesObligated"><?= lang('GEN_BTN_YES') ?></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                      <input id="noTaxesObligated" class="custom-control-input" type="radio" name="taxesObligated" value="no"
                        <?= $taxesObligated == '0' ? 'checked' : '' ?>>
                      <label class="custom-control-label" for="noTaxesObligated"><?= lang('GEN_BTN_NO') ?></label>
                    </div>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <!-- Datos de usuario -->
          <?php $index = array_search(lang('USER_DATA_USER'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> mb-0 border-none" data-index=<?= $index ?>>
            <div class="dataUser col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="form-group col-4">
                    <label for="nickNameProfile"><?= lang('USER_NICK_NAME') ?></label>
                    <input id="nickNameProfile" class="form-control available" type="text" name="nickNameProfile" value="<?= $nickNameProfile; ?>"
                      readonly autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-4">
                    <label for="creationDate"><?= lang('USER_REGISTRY_DATE') ?></label>
                    <input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $creationDate; ?>" readonly
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-4 <?= $skipBoth ?>">
                    <label class="block"><?= lang('USER_NOTIFICATIONS') ?></label>
                    <div class="custom-control custom-switch custom-control-inline <?= $skipEmail; ?>">
                      <input id="notEmail" class="custom-control-input" type="checkbox" name="notEmail" <?= $emailNot == '1' ? 'checked' : '' ?>
                        <?= $disabled; ?>>
                      <label class="custom-control-label <?= $updateUser; ?>" for="notEmail"><?= lang('USER_NOT_EMAIL') ?></label>
                    </div>
                    <div class="custom-control custom-switch custom-control-inline <?= $skipSms ?>">
                      <input id="notSms" class="custom-control-input" type="checkbox" name="notSms" <?= $smsNot == '1' ? 'checked' : '' ?>
                        <?= $disabled; ?>>
                      <label class="custom-control-label <?= $updateUser; ?>" for="notSms"><?= lang('USER_NOT_SMS') ?></label>
                    </div>
                  </div>
                </div>
                <div class="row mx-1">
                  <?php if (lang('SETT_OPER_KEY') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-4">
                    <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_OPER_PASS_CHANGE') ?></a>
                  </div>
                  <?php endif; ?>
                  <?php if (lang('SETT_SMS_KEY') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-4">
                    <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_SMS_PASSS_CHANGE') ?></a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </fieldset>
          <?php if (lang('SETT_LOAD_DOCS') == 'ON') : ?>
          <!-- Carga de documentos -->
          <?php $index = array_search(lang('USER_LOAD_DOCS_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> mb-0 border-none" data-index=<?= $index ?>>
            <?php if (lang('SETT_LOAD_DOCS') == 'ON') : ?>
            <div class="col-12">
              <div class="bg-secondary">
                <?php $this->load->view('user/loadDocuments_content-core') ?>
              </div>
            </div>
            <div class="multi-step-button flex items-center justify-center mb-5 mr-5">
              <button class="btn btn-small btn-link back" type="submit"><?= lang('GEN_BTN_TO_RETURN'); ?></button>
              <button class="btn btn-small btn-loading btn-primary next" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
            </div>
            <?php endif; ?>
          </fieldset>
          <?php endif; ?>
          <!-- Legales -->
          <?php $index = array_search(lang('USER_LEGAL_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group ms-step-<?= $index ?> mb-0 border-none w-100" data-index=<?= $index ?>>
            <div class="col-12">
              <div class="bg-secondary p-2">
                <div class="row mx-1">
                  <div class="form-group custom-control custom-switch col-12 col-lg-6 pt-1">
                    <input id="protection" class="custom-control-input" type="checkbox" name="protection"
                      <?= $contract == '1' ? 'checked disabled' : '' ?>>
                    <label class="custom-control-label" for="protection"><?= lang('USER_ACCEPT_PROTECTION'); ?></label>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group custom-control custom-switch col-12 col-lg-6 pt-1">
                    <input id="contract" class="custom-control-input" type="checkbox" name="contract"
                      <?= $protection == '1' ? 'checked disabled' : '' ?>>
                    <label class="custom-control-label" for="contract"><?= lang('USER_ACCEPT_CONTRACT'); ?></label>
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group custom-control custom-switch col-12 col-lg-6 pt-1">
                    <input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms"
                      <?= $terms == '1' ? 'checked disabled' : '' ?>>
                    <label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_TERMS'); ?></label>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <?php else : ?>
          <!-- Datos de usuario -->
          <?php $index = array_search(lang('USER_DATA_USER'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> mb-0 border-none" data-index=<?= $index ?>>
            <div class="dataUser col-12">
              <div class="bg-secondary h-100">
                <div class="row mx-1">
                  <div class="form-group col-4">
                    <label for="nickNameProfile"><?= lang('USER_NICK_NAME') ?></label>
                    <input id="nickNameProfile" class="form-control available" type="text" name="nickNameProfile" value="<?= $nickNameProfile; ?>"
                      readonly autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-4">
                    <label for="creationDate"><?= lang('USER_REGISTRY_DATE') ?></label>
                    <input id="creationDate" class="form-control" type="text" name="creationDate" value="<?= $creationDate; ?>" readonly
                      autocomplete="off">
                    <div class="help-block"></div>
                  </div>
                  <div class="form-group col-4 <?= $skipBoth ?>">
                    <label class="block"><?= lang('USER_NOTIFICATIONS') ?></label>
                    <div class="custom-control custom-switch custom-control-inline <?= $skipEmail; ?>">
                      <input id="notEmail" class="custom-control-input" type="checkbox" name="notEmail" <?= $emailNot == '1' ? 'checked' : '' ?>
                        <?= $disabled; ?>>
                      <label class="custom-control-label <?= $updateUser; ?>" for="notEmail"><?= lang('USER_NOT_EMAIL') ?></label>
                    </div>
                    <div class="custom-control custom-switch custom-control-inline <?= $skipSms ?>">
                      <input id="notSms" class="custom-control-input" type="checkbox" name="notSms" <?= $smsNot == '1' ? 'checked' : '' ?>
                        <?= $disabled; ?>>
                      <label class="custom-control-label <?= $updateUser; ?>" for="notSms"><?= lang('USER_NOT_SMS') ?></label>
                    </div>
                  </div>
                </div>
                <div class="row mx-1">
                  <?php if (lang('SETT_OPER_KEY') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-4">
                    <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_OPER_PASS_CHANGE') ?></a>
                  </div>
                  <?php endif; ?>
                  <?php if (lang('SETT_SMS_KEY') == 'ON') : ?>
                  <div class="form-group col-6 col-lg-4">
                    <a class="btn btn-small btn-link px-0 hyper-link" href=""><?= lang('USER_SMS_PASSS_CHANGE') ?></a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </fieldset>
          <?php if (lang('SETT_LOAD_DOCS') == 'ON') : ?>
          <!-- Carga de documentos -->
          <?php $index = array_search(lang('USER_LOAD_DOCS_STEP'), $stepTitles) + 1; ?>
          <fieldset class="form-group col-12 ms-step-<?= $index ?> mb-0 border-none" data-index=<?= $index ?>>
            <?php if (lang('SETT_LOAD_DOCS') == 'ON') : ?>
            <div class="col-12">
              <div class="bg-secondary">
                <?php $this->load->view('user/loadDocuments_content-core') ?>
              </div>
            </div>
            <?php endif; ?>
          </fieldset>
          <?php endif; ?>
          <!-- Terms -->
          <div class="form-group border-none w-100">
            <div class="col-12">
              <div class="bg-secondary px-2 pb-2">
                <div class="row mx-3">
                  <div class="form-group custom-control custom-switch col-12 col-lg-6 pt-1 mb-0">
                    <input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms"
                      <?= $terms == '1' ? 'checked disabled' : '' ?>>
                    <label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_TERMS'); ?></label>
                    <div class="help-block"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
        <div class="line-text mx-3"></div>
        <small class="mx-3 text"><?= lang('USER_SAVE_BTN_MSG'); ?> <?= count($stepTitles) ?></small>

        <?php if (lang('SETT_UPDATE_USER') == 'ON') : ?>
        <div class="flex items-center justify-center my-3">
          <a id="btn-cancel" class="btn btn-small btn-link big-modal" href="<?= $this->agent->referrer(); ?>"><?= lang('GEN_BTN_CANCEL') ?></a>
          <button id="profileUserBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_SAVE') ?></button>
        </div>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>
