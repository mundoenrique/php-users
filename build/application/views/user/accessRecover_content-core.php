<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
	<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
</div>
<div id="recovery" class="recovery-content h-content hide-out hide">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<h1 class="text regular inline"><?= lang('GEN_MENU_ACCESS_RECOVER'); ?></h1>
		<div class="line mt-2 mb-3"></div>
		<div class="pt-3 regular">
			<h2 class="text h3 mb-2"><?= lang('USER_RECOVER_VERIFY_DATA'); ?></h2>
			<p><?= novoLang(lang('USER_RECOVER_PASS'), lang('GEN_SYSTEM_NAME')); ?></p>
			<div class="line my-4"></div>
			<div class="max-width-1 fit-lg mx-auto pt-4">
				<form id="recoverAccessForm" class="mt-2" method="POST">
					<div class="form-group">
						<label class="mr-2"><?= lang('USER_RECOVER_NEED') ?></label>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="recoveryUser" name="recoveryAccess" class="custom-control-input" type="radio" value="U" disabled>
							<label class="custom-control-label" for="recoveryUser"><?= lang('GEN_USER'); ?></label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input id="recoveryPwd" name="recoveryAccess" class="custom-control-input" type="radio" value="C" disabled>
							<label class="custom-control-label" for="recoveryPwd"><?= lang('GEN_PASSWORD'); ?></label>
						</div>
						<div class="help-block"></div>
					</div>
					<div class="row">
						<div class="form-group col-lg-4">
							<label for="email"><?= lang('GEN_EMAIL'); ?></label>
							<input id="email" name="email" class="form-control" type="email" placeholder="<?= lang('GEN_PLACE_HOLDER_EMAIL') ?>" disabled>
							<div class="help-block"></div>
						</div>
						<?php if(lang('CONF_RECOVER_ID_TYPE') == 'ON'): ?>
						<div class="form-group col-lg-4">
							<label for="typeDocument">Tipo de documento</label>
							<select class="select-box custom-select flex h6 w-100" disabled>
								<option selected="" disabled="">Seleccionar</option>
								<option>Cédula de extranjería</option>
								<option>Option 2</option>
								<option>Option 3</option>
							</select>
						</div>
						<?php endif; ?>
						<div class="form-group col-lg-4">
							<label for="idNumber"><?= lang('GEN_DNI'); ?></label>
							<input id="idNumber" name="idNumber" class="form-control" type="text" disabled>
							<div class="help-block"></div>
						</div>
					</div>
					<div class="line my-2"></div>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= base_url('inicio');?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
						<button id="recoverAccessBtn" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
