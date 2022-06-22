<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="h3 text regular inline"><?= lang('GEN_MENU_TWO_FACTOR_ENABLEMENT'); ?></h1>
		<div class="line mt-2 mb-3"></div>
		<div class="pt-3 regular">
			<p><?= lang('USER_TWO_FACTOR_CODE_APP'); ?>
				<?php foreach (lang('CONF_TWO_FACTOR_LINK') as $key => $value) : ?>
					<a href="<?= lang('CONF_TWO_FACTOR_LINK')[$key]; ?>" class="btn-link " target="_blank">
						<?= $key; ?>,
					</a>
				<?php endforeach; ?>
				etc.
			</p>
			<p><?= lang('USER_TWO_FACTOR_IMG') ?></p>
			<div class="row pb-2">
				<div class="col-auto">
					<img src="http://api.qrserver.com/v1/create-qr-code/?color=000000&bgcolor=FFFFFF&data=prueba&qzone=1&margin=0&size=400x400&ecc=L" alt="code-qr" width="200" height="200">
				</div>
				<div class="col-auto flex justify-center flex-column">
					<p><?= lang('USER_TWO_FACTOR_QR_TEXT') ?></p>
					<p class="bold">4C7S 7L21 K9PH ERCSZ C3BL OGKA SPER SKY7</p>
				</div>
			</div>
			<p><?= lang('USER_TWO_FACTOR_SCAN') ?></p>
		 	<!-- <p class=" pb-1"><?= lang('USER_TWO_FACTOR_EMAIL_TEXT') ?></p>
			<p><?= lang('USER_TWO_FACTOR_SEND_CODE') ?> <a class="btn btn-small btn-link big-modal p-0" href="javascript:history.back()"><?= lang('GEN_BTN_SEND_CODE'); ?></a></p> -->
			<div class="max-width-1 fit-lg mx-auto">
				<form id="twoFactorEnablementForm" class="mt-2" method="POST">
					<div class="form-group col-lg-4 pl-0">
						<label for="authenticationCode"><?= lang('GEN_AUTHENTICATION_CODE'); ?></label>
						<input id="authenticationCode" name="authenticationCode" class="form-control" type="text" placeholder="<?= lang('GEN_PLACE_HOLDER_AUTH_CODE') ?>" disabled>
						<div class="help-block"></div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="javascript:history.back()"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="twoFactorEnablementBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_VERIFY'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
