<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="login-content flex items-center justify-center bg-primary">
  <div class="row justify-center">
    <div class="col-auto px-0">
      <div class="flex flex-column items-center z1 h-100">
        <img class="logo-banco mb-2" src="<?= $this->asset->insertFile(lang('IMG_SIGNIN_LOGO_WIDGET'), 'images', $customerUri); ?>"
          alt="<?= lang('GEN_ALTERNATIVE_TEXT'); ?>">
        <span class="mb-2 secondary center h3"><?= novoLang(lang('USER_SIGNIN_TITLE'), lang('GEN_SYSTEM_NAME')) ?></span>
        <div id="widget-signin" class="widget rounded h-100">
          <form id="signInForm">
            <div class="form-group">
              <label for="userName"><?= lang('GEN_USER'); ?></label>
              <input id="userName" name="userName" class="form-control" type="text" autocomplete="off" disabled>
              <div class="help-block"></div>
            </div>
            <div class="form-group">
              <label for="userPass"><?= lang('GEN_PASSWORD'); ?></label>
              <div class="input-group">
                <input id="userPass" name="userPass" class="form-control pwd-input" type="text" autocomplete="off" disabled>
                <div class="input-group-append">
                  <span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
                </div>
              </div>
              <div class="help-block"></div>
            </div>
            <button id="signInBtn" class="btn btn-loading-lg btn-primary w-100 mt-3 mb-5 login-btn">
              <span class="icon-lock mr-1 h3 bg-items" aria-hidden="true"></span>
              <?= lang('GEN_BTN_SIGNIN') ?>
            </button>
            <?php if (lang('CONF_SIGIN_RECOVER_PASS') == 'ON') : ?>
            <a class="block mb-1 h5 primary hyper-link big-modal" href="<?= base_url(LANG('CONF_LINK_RECOVER_ACCESS')); ?>">
							<?= lang('USER_SIGNIN_ACCESS_RECOVER'); ?>
						</a>
            <?php endif; ?>
            <?php if (lang('CONF_SIGIN') == 'ON') : ?>
            <p class="mb-0 h5 center"><?= lang('USER_SIGNIN_NO_USER') ?>
              <a class="hyper-link big-modal" href="<?= base_url(lang('CONF_LINK_USER_IDENTIFY')) ?>"><?= lang('USER_SIGNIN_SINGN_UP') ?></a>
            </p>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </div>
    <?php if (lang('CONF_SIGNIN_IMG') == 'ON') : ?>
    <div class="col-auto px-0">
      <div class="h-100">
        <div class="flex pr-2 pr-lg-0 img-log h-100">
          <img src="<?= $this->asset->insertFile(lang('IMG_SIGNIN_IMAGE'), 'images', $customerUri); ?> " alt="<?= lang('GEN_ALTERNATIVE_TEXT') ?>">
        </div>
      </div>
    </div>
    <?php endif; ?>
		<?php if (lang('CONF_SIGNIN_WELCOME_MSG') == 'ON') : ?>
			<div class="col-12 mt-2 center h6">
				<p><?= lang('USER_WELCOME_MSG') ?></p>
			</div>
    <?php endif; ?>
  </div>
</div>
