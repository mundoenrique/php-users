<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="manageAffiliateView">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text mb-2 semibold primary"><?= (TRUE) ? lang('TRANSF_NEW_AFFILIATE') : lang('TRANSF_EDIT_AFFILIATE') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
        <!-- cardToCard -->
        <span><?= (TRUE) ? lang('TRANSF_NEW_AFFILIATE_CARD_MSG') : lang('TRANSF_EDIT_AFFILIATE_MSG') ?></span>
        <!-- cardToBank -->
        <span><?= (TRUE) ? lang('TRANSF_NEW_AFFILIATE_BANK_MSG') : lang('TRANSF_EDIT_AFFILIATE_MSG') ?></span>
        <!-- mobilePayment -->
        <span><?= (TRUE) ? lang('TRANSF_NEW_AFFILIATE_PAY_MSG') : lang('TRANSF_EDIT_AFFILIATE_MSG') ?></span>
        <div class="line-text my-2"></div>
        <form id="manageAffiliate">
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
          </div>
          <div class="line my-2"></div>
          <div class="flex items-center justify-end pt-3">
            <a class="btn btn-small btn-link big-modal" href=""><?= lang('GEN_BTN_CANCEL') ?></a>
            <button id="manageAffiliateBtn"
              class="btn btn-small btn-loading btn-primary send"><?= (TRUE) ? lang('TRANSF_AN_AFFILIATE') : lang('GEN_BTN_SAVE') ?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
