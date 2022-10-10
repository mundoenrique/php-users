<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="toTransferView" class="transfer-operation" style="display:none">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text mb-2 semibold primary"><?= (TRUE) ? lang('TRANSF_TO_TRANSFER') : lang('TRANSF_MAKE_PAYMENT') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
        <!-- cardToCard -->
        <span><?= lang('TRANSF_BETWEEN_CARDS_MSG') ?> </span>
        <!-- cardToBank -->
        <span><?= lang('TRANSF_BANK_ACCOUNTS_MSG') ?> </span>
        <!-- mobilePayment -->
        <span><?= lang('TRANSF_PAY_MOVIL_MSG') ?> </span>
        <div class="line-text my-2"></div>
        <form id="affiliations">
          <div class="row">
            <div class="form-group col-6 col-lg-4">
              <label for="directory"><?= lang('TRANSF_AFFILIATE_DIRECTORY'); ?></label>
              <div class="form-control select-by-search p-0">
								<input id="directory" type="hidden" name="directory" value="">
                <input class="custom-select select-search-input pl-1" placeholder='<?= lang('GEN_BTN_SEARCH') ?>' type="text" name="directory" autocomplete="off" value="">
                <ul class="select-search pl-0">
                  <li value="1">james cameron</li>
                  <li value="2">steven spielberg</li>
                  <li value="3">stanley kubrick</li>
                  <li value="4">ridley scott</li>
                  <li value="5">darren aronofsky</li>
                  <li value="6">john waters</li>
                  <li value="7">danny boyle</li>
                  <li value="8">woody allen</li>
                  <li value="9">david lynch</li>
                  <li value="10">wes anderson</li>
                </ul>
                <div class="close-selector"></div>
              </div>
              <div class="help-block"></div>
            </div>
          </div>
        </form>
        <div class="line-text mb-2"></div>
        <form id="transferForm">
          <div class="row">
            <div class="form-group col-6 col-lg-4">
              <label for="bank"><?= lang('TRANSF_BANK') ?></label>
              <select id="bank" class="custom-select form-control" name="bank">
                <option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
                <option value="Cedula">Bancaribe</option>
              </select>
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="beneficiary"><?= lang('TRANSF_BENEFICIARY') ?></label>
              <input id="beneficiary" class="form-control" type="text" name="beneficiary" autocomplete="off">
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="idNumber"><?= lang('GEN_DNI') ?></label>
              <div class="form-row">
                <div class="form-group col-6 mb-0">
                  <select id="typeDocument" class="custom-select form-control" name="typeDocument">
                    <option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
                    <option value="Cedula">V</option>
                  </select>
                  <div class="help-block"></div>
                </div>
                <div class="form-group col-6 mb-0">
                  <input id="idNumber" class="form-control" type="text" name="idNumber" value="" autocomplete="off">
                  <div class="help-block"></div>
                </div>
              </div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="destinationCard"><?= LANG('TRANSF_DESTINATION_CARD') ?></label>
              <input id="destinationCard" class="form-control" type="text" name="destinationCard" autocomplete="off">
              <div class="help-block"></div>
            </div>
						<div class="form-group col-6 col-lg-4">
              <label for="mobilePhone"><?= lang('GEN_PHONE_MOBILE') ?></label>
              <input id="mobilePhone" class="form-control" type="text" name="mobilePhone" autocomplete="off">
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="email"><?= lang('GEN_EMAIL') ?></label>
              <input id="email" class="form-control" type="text" name="email" autocomplete="off">
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="amount"><?= lang('TRANSF_AMOUNT') ?></label>
              <input id="amount" name="amount" class="form-control" type="text" autocomplete="off">
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="concept"><?= lang('TRANSF_CONCEPT') ?></label>
              <input id="concept" name="concept" class="form-control" type="text" autocomplete="off">
              <div class="help-block"></div>
            </div>
            <div class="form-group col-6 col-lg-4">
              <label for="expDateCta"><?= lang('TRANSF_EXP_DATE_CTA') ?></label>
              <input id="expDateCta" name="expDateCta" class="form-control" name="datepicker" type="text"
                placeholder="<?= lang('GEN_DATEPICKER_DATEMEDIUM'); ?>">
              <div class="help-block"></div>
            </div>
          </div>
          <div class="line my-2"></div>
          <div class="flex items-center justify-end pt-3">
            <button id="deleteBtn" class="btn btn-small btn-loading btn-primary mx-2" type="submit"><?= lang('TRANSF_ERASE') ?></button>
            <button id="transferBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
