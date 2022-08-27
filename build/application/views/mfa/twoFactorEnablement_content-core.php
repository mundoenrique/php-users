<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="h3 text regular inline"><?= lang('GEN_MENU_TWO_FACTOR_ENABLEMENT'); ?></h1>
		<div class="line mt-2 mb-3"></div>
		<div class="pt-3 regular">
			<h2 class="text h4 mb-2"><?= lang('MFA_ACCOUNT_VERIFICATION'); ?></h2>
			<?= lang("MFA_TWO_FACTOR_ENABLEMENT_CONTENT") ?>
			<div class="max-width-1 fit-lg mx-auto">
				<form id="twoFactorEnablementForm" class="mt-2" method="POST">
					<div class="form-group">
						<label class="mr-2"><?= lang('MFA_ACTIVATION_TYPE') ?></label>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="twoFactorApp" name="twoFactorEnablement" class="custom-control-input" type="radio" value="<?= lang('MFA_TWO_FACTOR_APP') ?>" disabled>
							<label class="custom-control-label" for="twoFactorApp"><?= lang('MFA_USING_AN_APP'); ?></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="twoFactorEmail" name="twoFactorEnablement" class="custom-control-input" type="radio" value="<?= lang('MFA_TWO_FACTOR_EMAIL') ?>" disabled>
							<label class="custom-control-label" for="twoFactorEmail"><?= lang('GEN_VIA_EMAIL'); ?></label>
						</div>
						<div class="help-block"></div>
						<p class="visible" id="verifyMsg" ><?= lang('MFA_VERIFY_MSG_EMAIL'); ?></p>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<button id="twoFactorEnablementBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
