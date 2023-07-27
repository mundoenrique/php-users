<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="text regular h3 inline"><?= lang('GEN_MENU_USER_IDENTIFY'); ?></h1>
		<div class="line-text mt-2"></div>
		<div class="pt-3 regular">
			<h4 class="text"><?= lang ('USER_ACCOUNT_VERIFICATION') ?></h4>
			<?= novoLang(lang('USER_MSG_ACCESS_ACCOUNT'),lang('GEN_SYSTEM_NAME')) ?>
			<div class="max-width-1 fit-lg mx-auto pt-1">
				<form id="identityForm">
					<div class="row">
						<?php if (lang('SETT_CHANGE_VIRTUAL') === 'ON'): ?>
						<div class="form-group col-12">
							<label class="mr-2 regular"><?= lang('GEN_CARD_TYPE'); ?></label>
							<div class="custom-control custom-radio custom-control-inline">
								<input id="physicalCard" class="custom-control-input" type="radio" name="cardType" value="physical" checked>
								<label class="custom-control-label" for="physicalCard"><?= lang('GEN_PHYSICAL_CARD'); ?></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline mr-0">
								<input id="virtualCard" class="custom-control-input" type="radio" name="cardType" value="virtual">
								<label class="custom-control-label" for="virtualCard"><?= lang('GEN_VIRTUAL_CARD'); ?></label>
							</div>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
						<div class="form-group col-lg-4" id="divNumberCard">
							<label for="numberCard"><?= lang('GEN_NUMBER_CARD'); ?></label>
							<input id="numberCard" class="form-control" type="text" name="numberCard" maxlength="16" autocomplete="off" disabled>
							<div class="help-block"></div>
						</div>
						<?php if(lang('SETT_DOC_TYPE') === 'ON'): ?>
						<div class="form-group col-lg-4">
							<label for="typeDocument"><?= lang('GEN_TYPE_DOCUMENT') ?></label>
							<select id="typeDocument" name="typeDocument" class="form-control select-box custom-select flex h6 w-100" disabled autocomplete="off">
								<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
								<?php foreach ($documentType AS $key => $value): ?>
									<option value="<?= $key ?>"><?= $value ?></option>
								<?php endforeach; ?>
							</select>
							<div class="help-block"></div>
						</div>
						<?php endif; ?>
						<div class="form-group col-lg-4">
							<label for="documentId"><?= lang('GEN_DNI'); ?></label>
							<input id="documentId" class="form-control" type="text" name="documentId" maxlength="<?= lang('REGEX_MAXLENGTH_DOC_ID')?>" autocomplete="off" disabled>
							<div class="help-block"></div>
						</div>
						<?php if (lang('SETT_SECRET_KEY') == 'ON') : ?>
							<div class="form-group col-lg-4" id="physicalCardPIN">
								<label for="cardPIN"><?= lang('GEN_SECRET_PASS_PIN'); ?></label>
								<input id="cardPIN" class="form-control" type="password" name="cardPIN" maxlength="4" autocomplete="off" disabled>
								<div class="help-block"></div>
							</div>
						<?php endif; ?>
					</div>
					<div class="form-group custom-control custom-switch my-3">
						<input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms">
						<label class="custom-control-label" for="acceptTerms"><?= lang('USER_ACCEPT_TERMS'); ?></label>
						<div class="help-block"></div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= base_url(lang('SETT_LINK_SIGNIN')); ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="identityBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
