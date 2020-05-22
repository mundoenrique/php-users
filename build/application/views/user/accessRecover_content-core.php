<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div id="recovery" class="recovery-content h-content">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="text regular inline"><?= lang('GEN_MENU_ACCESS_RECOVER'); ?></h1>
			<div class="line mt-2 mb-3"></div>
		</header>
		<section>
			<div class="pt-3 regular">
				<h2 class="text h3 mb-2">Verificación de datos</h2>
				<p>Para recuperar tu usuario o restablecer tu contraseña de acceso a
					<span class="bold"><?= lang('GEN_SYSTEM_NAME'); ?></span>, debes seleccionar la opción correspondiente e
					ingresar los datos requeridos.</p>
				<div class="line my-4"></div>
				<div class="max-width-1 fit-lg mx-auto pt-4">
					<span>Los campos con  <span class="danger">*</span> son requeridos.</span>
					<form id="formRecoveryAccess" class="mt-2" method="post">
						<div class="form-group">
							<label class="mr-2">Necesito recuperar mi <span class="danger">*</span></label>
							<div class="custom-control custom-radio custom-control-inline">
								<input id="recoveryUser" class="custom-control-input" type="radio" name="recovery" value="U">
								<label class="custom-control-label" for="recoveryUser"><?= lang('GEN_USER'); ?></label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input id="recoveryPwd" class="custom-control-input" type="radio" name="recovery" value="C">
								<label class="custom-control-label" for="recoveryPwd"><?= lang('GEN_PASSWORD'); ?></label>
							</div>
							<div class="help-block"></div>
						</div>
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="email"><?= lang('GEN_EMAIL'); ?> <span class="danger">*</span></label>
								<input id="email" class="form-control" type="email" name="email">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-4">
								<label for="typeDocument">Tipo de documento <span class="danger">*</span></label>
								<select class="select-box custom-select flex h6 w-100">
									<option selected="" disabled="">Seleccionar</option>
									<option>Cédula de extranjería</option>
									<option>Option 2</option>
									<option>Option 3</option>
								</select>
							</div>
							<div class="form-group col-lg-4">
								<label for="idNumber"><?= lang('GEN_DNI'); ?> <span class="danger">*</span></label>
								<input id="idNumber" class="form-control" type="text" name="idNumber">
								<div class="help-block"></div>
							</div>
						</div>
						<div class="line my-2"></div>
						<div class="flex items-center justify-end pt-3">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>"><?= lang('GEN_BTN_CANCEL'); ?></a>
							<button id="btnContinuar" class="btn btn-small btn-loading btn-primary" type="submit"><?= lang('GEN_BTN_CONTINUE'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
