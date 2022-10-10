<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="historyView" class="transfer-operation" style="display:none">
  <div class="flex mb-1 mx-4 flex-column">
    <h4 class="line-text semibold primary"><?= lang('TRANSF_HISTORY') ?></h4>
    <div class="w-100">
      <div class="mx-auto">
        <div class="row pl-2 mt-3">
          <label class="mt-1 regular" for="initDateFilter"><?= lang('TRANSF_SHOW'); ?></label>
          <div class="form-group col-3 px-1">
            <input id="filterInputYear" name="filterInputYear" class="form-control" name="datepicker" type="text"
              placeholder="<?= lang('GEN_DATEPICKER_DATEMEDIUM'); ?>">
            <div id='error' class="help-block"></div>
          </div>
          <div class="flex items-center">
            <button id="historySearch" class="btn btn-small btn-rounded-right btn-primary mb-3">
              <span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
            </button>
          </div>
        </div>
        <div class="line-text my-2"></div>
        <div id="results" class="mt-1 justify-center">
          <div id="pre-loader" class="hide">
            <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
          </div>
          <ul id="movementsList" class="feed fade-in mt-3 pl-0 easyPaginateList">
            <li class="feed-item feed-expense flex py-2 items-center">
              <div class="flex px-2 flex-column items-center feed-date">
                <span class="h5">10 Jul 2021</span>
              </div>
              <div class="flex px-2 flex-column mr-auto">
                <span class="h5 semibold feed-product">Yhoan alfonso sulbaran ccs noroeste ve</span>
                <span class="h6 feed-metadata">119112055118</span>
              </div>
              <span class="px-2 feed-amount items-center">- $ 32.000.000,00</span>
            </li>
            <li class="feed-item feed-income flex py-2 items-center">
              <div class="flex px-2 flex-column items-center feed-date">
                <span class="h5">09 Jul 2021</span>
              </div>
              <div class="flex px-2 flex-column mr-auto">
                <span class="h5 semibold feed-product">Beneficio de alimentacion</span>
                <span class="h6 feed-metadata">510181</span>
              </div>
              <span class="px-2 feed-amount items-center">+ $ 29.500.000,00</span>
            </li>
            <li class="feed-item feed-expense flex py-2 items-center">
              <div class="flex px-2 flex-column items-center feed-date">
                <span class="h5">19 Jun 2021</span>
              </div>
              <div class="flex px-2 flex-column mr-auto">
                <span class="h5 semibold feed-product">Inversiones zacamar c. ccs noroeste ve</span>
                <span class="h6 feed-metadata">117015007660</span>
              </div>
              <span class="px-2 feed-amount items-center">- $ 2.700.000,00</span>
            </li>
            <li class="feed-item feed-expense flex py-2 items-center">
              <div class="flex px-2 flex-column items-center feed-date">
                <span class="h5">19 Jun 2021</span>
              </div>
              <div class="flex px-2 flex-column mr-auto">
                <span class="h5 semibold feed-product">Yhoan alfonso sulbaran ccs noroeste ve</span>
                <span class="h6 feed-metadata">117012054741</span>
              </div>
              <span class="px-2 feed-amount items-center">- $ 23.670.000,00</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
