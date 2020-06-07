<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg none" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="text regular h3 inline"><?= lang('GEN_MENU_USER_IDENTIFY'); ?></h1>
		<div class="line-text mt-2"></div>
		<div class="pt-3 regular">
			<h4 class="text">Verificación de cuenta</h4>
			<p>Si aún no posees usuario para acceder al sistema <strong><?= lang('GEN_SYSTEM_NAME'); ?></strong>, a continuación debes proporcionar los siguientes datos relacionados con tu cuenta:</p>

			<div class="max-width-1 fit-lg mx-auto pt-1">
				<form id="recoverAccessForm" method="POST">
					<div class="row">
						<div class="form-group col-lg-4">
								<label for="cardNumber" class="regular">Número de tarjeta</label>
								<input id="cardNumber" class="form-control" type="text" name="cardNumber">
								<div class="help-block"></div>
						</div>
						<div class="form-group col-lg-4">
							<label for="curp" class="regular"><?= lang('GEN_DNI'); ?></label>
							<input id="curp" class="form-control" type="text" name="curp">
							<div class="help-block"></div>
						</div>
						<div class="form-group col-lg-4">
							<label for="secretPassword" class="regular">Clave secreta (PIN)</label>
							<input id="secretPassword" class="form-control" type="password" name="secretPassword" maxlength="15" value="">
							<div class="help-block"></div>
						</div>
					</div>
					<div class="form-group custom-control custom-switch my-3">
						<input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms">
						<label class="custom-control-label" for="acceptTerms">
							Acepto las <a id="termsConditions" class="hyper-link" href="#" rel="section">condiciones de uso</a> de este sistema.
						</label>
						<div class="help-block"></div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= base_url('inicio');?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="userIdenBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
