
<div id="changepassword" class="changepassword-content h-content bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0"><?= $reason?:'Cambiar contraseña'; ?></h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<p><?= lang('DESCRIPTION_MSG'); ?></p>
				<span>Los campos con  <span class="danger">*</span> son requeridos.</span>
				<form id="formChangePassword" class="mt-2" method="post">
					<div class="row">
						<div class="col-6 col-lg-8 col-xl-6">
							<div class="row">
								<div class="form-group col-12 col-lg-6">
									<label for="currentPassword"><?= lang('CURRENT_PASSWORD'); ?></label>
									<div class="input-group">
										<input id="currentPassword" class="form-control" type="password" name="currentPassword">
										<div class="input-group-append">
											<span id="pwdAddon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
										</div>
									</div>
									<div class="help-block"></div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-12 col-lg-6">
									<label for="newPassword"><?= lang('NEW_PASSWORD'); ?></label>
									<div class="input-group">
										<input id="newPassword" class="form-control" type="password" name="newPassword">
										<div class="input-group-append">
											<span id="pwdAddon2" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
										</div>
									</div>
									<div class="help-block"></div>
								</div>
								<div class="form-group col-12 col-lg-6">
									<label for="confirmPassword"><?= lang('CONFIRM_PASSWORD'); ?></label>
									<div class="input-group">
										<input id="confirmPassword" class="form-control" type="password" name="confirmPassword">
										<div class="input-group-append">
											<span id="pwdAddon3" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
										</div>
									</div>
									<div class="help-block"></div>
								</div>
							</div>
						</div>

						<div class="col-6 col-lg-4 col-xl-6">
							<div class="field-meter" id="password-strength-meter">
								<h4><?= lang('PASSWORD_INFO_TITLE'); ?></h4>
								<ul class="pwd-rules">
									<li id="length" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_1'); ?></li>
									<li id="letter" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_2'); ?></li>
									<li id="capital" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_3'); ?></li>
									<li id="number" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_4'); ?></li>
									<li id="special" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_5'); ?></li>
									<li id="consecutive" class="pwd-rules-item rule-invalid"><?= lang('PASSWORD_INFO_6'); ?></li>
								</ul>
							</div>
						</div>
					</div>

					<hr class="separador-one mt-2 mb-4">
					<div class="flex items-center justify-end">
						<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
						<button id="btnChangePassword" class="btn btn-small btn-loading btn-primary" type="submit" name="btnChangePassword">Continuar</button>
					</div>
				</form>
			</div>
		</section>
	</div>
</div>
<script>

</script>
