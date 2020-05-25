<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-8 mx-auto">
		<h1 class="primary h3 regular"><?= lang('GEN_MENU_CHANGE_PASS'); ?></h1>
		<div class="line my-2"></div>
		<div class="pt-3">
			<div id="pre-loader" class="mt-2 mx-auto flex justify-center">
				<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
			</div>
			<p>Por favor complete la información requerida a continuación para generar una nueva contraseña</p>
			<form id="formChangePassword" class="mt-2" method="post">
				<div class="row">
					<div class="col-6 col-lg-8 col-xl-6">
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="currentPassword"> <strong> Contraseña actual</strong></label>
								<div class="input-group">
									<input id="currentPassword" class="form-control" type="password" name="currentPassword">
									<div class="input-group-append">
										<span id="pwdAddon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i
												class="icon-view mr-0"></i></span>
									</div>
								</div>
								<div class="help-block"></div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-12 col-lg-6">
								<label for="newPassword"> <strong>Nueva contraseña</strong></label>
								<div class="input-group">
									<input id="newPassword" class="form-control" type="password" name="newPassword">
									<div class="input-group-append">
										<span id="pwdAddon2" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i
												class="icon-view mr-0"></i></span>
									</div>
								</div>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-12 col-lg-6">
								<label for="confirmPassword"> <strong>Confirmar contraseña</strong></label>
								<div class="input-group">
									<input id="confirmPassword" class="form-control" type="password" name="confirmPassword">
									<div class="input-group-append">
										<span id="pwdAddon3" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i
												class="icon-view mr-0"></i></span>
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
								<li id="length" class="pwd-rules-item rule-invalid">De 8 a 15 <strong>caracteres</strong> </li>
								<li id="letter" class="pwd-rules-item rule-invalid">Al menos una <strong>letra minúscula</strong></li>
								<li id="capital" class="pwd-rules-item rule-invalid">Al menos una <strong>letra mayuscula</strong> </li>
								<li id="number" class="pwd-rules-item rule-invalid">De 1 a 3 <strong>números</strong></li>
								<li id="especial" class="pwd-rules-item rule-invalid">Al menos un<strong> caracter especial</strong> (eje:!@*?¡¿+/.,_#)</li>
								<li id="consecutivo" class="pwd-rules-item rule-invalid">No debe tener más de 2 <strong>carateres</strong> iguales consecutivos</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="line mt-2 mb-4"></div>
				<div class="flex items-center justify-end">
					<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
					<button id="btnChangePassword" class="btn btn-small btn-loading btn-primary" type="submit" name="btnChangePassword">Continuar</button>
				</div>
			</form>
		</div>
	</div>
</div>
