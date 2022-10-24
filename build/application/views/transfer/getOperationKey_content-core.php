<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
  <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div class="logout-content max-width-4 mx-auto p-responsive py-4 hide-out hide">
  <h1 class="primary h0"><?= lang('GEN_MENU_PAYS_TRANSFER');?></h1>
  <hr class="separador-one">
  <div class="pt-3">
    <h4><?= lang('TRANSF_AUTH_REQUIRED');?></h4>
    <p><?= novoLang(lang('TRANSF_SET_OPER_KEY'), lang('GEN_SYSTEM_NAME'));?></p>
    <form id="getOperationKeyForm" class="mt-4">
      <div class="row">
        <div class="col-8">
          <div class="form-group col-12 col-lg-6 pl-0">
            <label for="currentPass"><?= lang('TRANSF_KEY_OPER');?></label>
            <div class="input-group">
              <input id="currentPass" class="form-control pwd-input" type="password" autocomplete="off" name="currentPass">
							<div class="input-group-append">
								<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
							</div>
            </div>
            <div class="help-block"></div>
          </div>
        </div>
        <div class="col-12">
          <p><?= lang('TRANSF_FORGOT_OPER_KEY'); ?></p>
        </div>
      </div>
      <hr class="separador-one mt-2 mb-4">
      <div class="flex items-center justify-end">
        <a class="btn btn-link btn-small big-modal" href="<?= base_url(uriRedirect()); ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
        <button id="getOperationKeyBtn" class="btn btn-small btn-loading btn-primary big-modal" type="submit">
          <?= lang('GEN_BTN_ACCEPT'); ?>
        </button>
      </div>
    </form>
  </div>
</div>
