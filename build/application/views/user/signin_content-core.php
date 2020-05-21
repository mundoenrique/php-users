<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="login-content flex items-center justify-center bg-primary">
	<div class="flex flex-column items-center z1">
		<img class="logo-banco mb-2" src="<?= $this->asset->insertFile(lang('LOGIN_LOGO_WIDGET'), 'images', $countryUri); ?>"
			alt="<?= lang('GEN_ALTERNATIVE_TEXT'); ?>">
		<span class="mb-2 secondary center h3"><?= lang('LOGIN_WIDGET_TITLE') ?></span>
		<div id="widget-signin" class="widget rounded">
			<form id="signin-form">
				<div class="form-group">
					<label for="userName"><?= lang('GEN_USER'); ?></label>
					<input id="userName" name="userName" class="form-control" type="text" autocomplete="off" disabled>
					<div class="help-block"></div>
				</div>
				<div class="form-group">
					<label for="userPass"><?= lang('GEN_PASSWORD'); ?></label>
					<div class="input-group">
						<input id="userPass" name="userPass" class="form-control pwd-input" type="password" autocomplete="off" disabled>
						<div class="input-group-append">
							<span class="input-group-text pwd-action" title="<?= lang('GEN_SHOW_PASS') ?>"><i class="icon-view mr-0"></i></span>
						</div>
					</div>
					<div class="help-block"></div>
				</div>
				<button id="signin-btn" class="btn btn-loading-lg btn-primary w-100 mt-3 mb-5 login-btn">
					<span class="icon-lock mr-1 h3 bg-items" aria-hidden="true"></span>
					<?= lang('GEN_BTN_SIGNIN') ?>
				</button>
				<?php if(lang('CONIFG_SIGIN_RECOVER_PASS') == 'ON'): ?>
				<a class="block mb-1 h5 primary forgot-pass" href="<?= base_url('recuperar-acceso');?>"><?= lang('LOGIN_ACCESS_RECOVER'); ?></a>
				<p class="mb-0 h5"><?= lang('LOGIN_NO_USER') ?>
					<a class="primary forgot-pass" href="<?= base_url('identificacion') ?>"><?= lang('LOGIN_SINGN_UP') ?></a>
				</p>
				<?php endif; ?>
			</form>
		</div>
	</div>
	<?php if(lang('CONF_SIGNIN_IMG') == 'ON'): ?>
	<div class="flex pr-2 pr-lg-0 img-log">
		<img src="<?= $this->asset->insertFile(lang('LOGIN_IMAGE'), 'images', $countryUri); ?> " alt="<?= lang('GEN_ALTERNATIVE_TEXT') ?>">
	</div>
	<?php endif; ?>
</div>
