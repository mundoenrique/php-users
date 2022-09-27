<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="recovery" class="recovery-content h-content hide-out">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="h3 text regular inline"><?= lang('GEN_MENU_MFA'); ?></h1>
		<div class="line mt-2 mb-3"></div>
		<div class="pt-3 regular">
		<form id="channelForm">
			<input type="hidden" id="channel" name="channel" class="hidden" value="<?= $channel ?>">
		</form>
			<?php if($channel === lang('CONF_MFA_CHANNEL_APP')): ?>
				<div>
					<p><?= lang('MFA_TWO_FACTOR_CODE_APP'); ?>
					<?php foreach (lang('CONF_LINK_MFA_APPS') as $key => $value) : ?>
						<a href="<?= lang('CONF_LINK_MFA_APPS')[$key]; ?>" class="btn-link " target="_blank">
							<?= $key; ?>,
						</a>
					<?php endforeach; ?>
					etc.
					</p>
					<p><?= lang('MFA_TWO_FACTOR_IMG') ?></p>
					<div class="row pb-2">
						<div class="col-auto qr-code-img" id="qrCodeImg"></div>
						<div class="col-auto flex justify-center flex-column">
							<p><?= lang('MFA_TWO_FACTOR_QR_TEXT') ?></p>
							<p class="bold secret-token" id="secretToken"></p>
						</div>
					</div>
					<p><?= lang('MFA_TWO_FACTOR_SCAN') ?></p>
				</div>
				<?php else: ?>
				<div>
					<p class=" pb-1"><?= novoLang(lang('MFA_TWO_FACTOR_EMAIL_TEXT'), $this->session->maskMail); ?></p>
					<p><?= lang('GEN_TWO_FACTOR_SEND_CODE') ?>
					<a id="resendCode" href=<?= lang('CONF_NO_LINK') ?> class="btn btn-small btn-link p-0 big-modal" ><?= lang('GEN_BTN_RESEND_CODE'); ?></a>
				</p>
				</div>
			<?php endif; ?>

			<div class="max-width-1 fit-lg mx-auto">
				<form id="mfaConfirmForm" class="mt-2" method="POST">
					<div class="form-group col-lg-4 pl-0">
						<label for="authenticationCode"><?= lang('GEN_AUTHENTICATION_CODE'); ?></label>
						<input id="authenticationCode" name="authenticationCode" class="form-control" type="text" placeholder="<?= lang('GEN_PLACE_HOLDER_AUTH_CODE') ?>" disabled>
						<div class="help-block"></div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= base_url(lang('CONF_LINK_MFA_ENABLE')); ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="mfaConfirmBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_VERIFY'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
