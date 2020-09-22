<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="text regular h3 inline"><?= lang('GEN_MENU_USER_IDENTIFY'); ?></h1>
		<div class="line-text mt-2"></div>
		<div class="pt-3 regular">
			<h4 class="text">Verificación de cuenta</h4>
			<p>Si aún no posees usuario para acceder al sistema <strong><?= lang('GEN_SYSTEM_NAME'); ?></strong>, a continuación debes proporcionar los
				siguientes datos relacionados con tu cuenta:</p>

			<div class="max-width-1 fit-lg mx-auto pt-1">
				<form id="identityForm">
					<div class="row">
						<div class="form-group col-12">
							<label class="mr-2 regular">Tipo de tarjeta</label>
							<div class="custom-control custom-radio custom-control-inline">
								<input id="physicalCard" class="custom-control-input" type="radio" name="cardType" value="physical" checked>
								<label class="custom-control-label" for="physicalCard">Física</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline mr-0">
								<input id="virtualCard" class="custom-control-input" type="radio" name="cardType" value="virtual">
								<label class="custom-control-label" for="virtualCard">Virtual</label>
							</div>
							<div class="help-block"></div>
						</div>
						<div class="form-group col-lg-4">
							<label for="numberCard" class="regular">Número de tarjeta</label>
							<input id="numberCard" class="form-control" type="text" name="numberCard" maxlength="16">
							<div class="help-block"></div>
						</div>
						<div class="form-group col-lg-4">
							<label for="docmentId" class="regular"><?= lang('GEN_DNI'); ?></label>
							<input id="docmentId" class="form-control" type="text" name="docmentId" maxlength="25">
							<div class="help-block"></div>
						</div>
						<?php if (lang('CONF_SECRET_KEY') == 'ON') : ?>
							<div class="form-group col-lg-4" id="physicalCardPIN">
								<label for="cardPIN" class="regular">Clave secreta (PIN)</label>
								<input id="cardPIN" class="form-control" type="password" name="cardPIN" maxlength="15">
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
						<a class="btn btn-small btn-link big-modal" href="<?= base_url('inicio'); ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="identityBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<form id="signupForm" action="<?= base_url(lang('GEN_LINK_USER_SIGNUP')); ?>" method="POST"></form>
