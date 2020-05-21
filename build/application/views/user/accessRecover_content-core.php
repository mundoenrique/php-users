<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="pt-3 pb-5">
	<div class="logout-content max-width-4 mx-auto p-responsive py-4">
		<h1 class="primary h0"><?= lang('GEN_MENU_ACCESS_RECOVER'); ?></h1>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<p><?= novoLang(lang('RECOVER_USER_PASS'), lang('GEN_SYSTEM_NAME')); ?></p>
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form id="form-pass-recovery">
						<div class="row  mb-2">
							<div class="form-group col-4 col-lg-4 col-xl-4">
								<label class="block"><?= lang('RECOVER_NEED') ?></label>
								<div class="custom-option-c custom-radio custom-control-inline">
									<input type="radio" id="userName" name="recover" class="custom-option-input" value="userName">
									<label class="custom-option-label nowrap" for="userName"><?= lang('GEN_USER'); ?></label>
								</div>
								<div class="custom-option-c custom-radio custom-control-inline">
									<input type="radio" id="passWord" name="recover" class="custom-option-input" value="passWord">
									<label class="custom-option-label nowrap" for="passWprd"><?= lang('GEN_PASSWORD'); ?></label>
								</div>
							</div>
							<div class="form-group col-lg-auto">
								<label for="idUser"><?= lang('GEN_DNI'); ?></label>
								<input id="user-name" name="user-name" class="form-control" type="text" maxlength="17">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-4">
								<label for="email"><?= lang('GEN_EMAIL'); ?></label>
								<input id="email" name="email" class="form-control" type="text" maxlength="64" placeholder="<?= lang('GEN_PLACE_HOLDER_EMAIL') ?>">
								<div class="help-block"></div>
							</div>
						</div>
						<hr class="separador-one">
						<div class="flex items-center justify-end pt-3">
							<a class="btn btn-link btn-small big-modal" href="<?= base_url('inicio') ?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
							<button id="btn-pass-recover" class="btn btn-small btn-primary btn-loading" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
