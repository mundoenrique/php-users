<div id="registry" class="registro-content h-100 bg-white">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="primary h0">Cambiar Clave</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Verificación de Datos</h2>
				<p><?= $reason; ?></p>
				<hr class="separador-one">
				<div class="pt-3">
					<form method="post" id="formChangePassword">
						<div class="row">
							<div class="col-6 col-lg-8 col-xl-6">
								<h3 class="tertiary h4">Datos de usuario</h3>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="currentPassword">Clave Actual</label>
										<div class="input-group">
											<input type="password" class="form-control" id="currentPassword" name="currentPassword">
											<div class="input-group-append">
												<span id="pwd-addon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
											</div>
										</div>
										<div class="help-block"></div>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-12 col-lg-6">
										<label for="newPassword">Contraseña</label>
										<div class="input-group">
											<input type="password" class="form-control" id="newPassword" name="newPassword">
											<div class="input-group-append">
												<span id="pwd-addon" class="input-group-text" title="Clic aquí para mostrar/ocultar contraseña"><i class="icon-view mr-0"></i></span>
											</div>
										</div>
										<div class="help-block"></div>
									</div>
									<div class="form-group col-12 col-lg-6">
										<label for="confirmPassword">Confirmar Contraseña</label>
										<input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
										<div class="help-block"></div>
									</div>
								</div>
							</div>

							<div class="col-6 col-lg-4 col-xl-6">
								<div class="field-meter" id="password-strength-meter">
									<h4>Requerimientos de contraseña:</h4>
									<ul class="pwd-rules">
										<li id="length" class="pwd-rules-item rule-invalid">De 8 a 15 <strong>Caracteres</strong></li>
										<li id="letter" class="pwd-rules-item rule-invalid">Al menos una <strong>letra minúscula</strong>
										</li>
										<li id="capital" class="pwd-rules-item rule-invalid">Al menos una <strong>letra mayúscula</strong>
										</li>
										<li id="number" class="pwd-rules-item rule-invalid">De 1 a 3 <strong>números</strong></li>
										<li id="especial" class="pwd-rules-item rule-invalid">Al menos un <strong>caracter especial</strong><br />(ej: ! @ ? + - . , #)</li>
										<li id="consecutivo" class="pwd-rules-item rule-invalid">No debe tener más de 2 <strong>caracteres</strong> iguales consecutivos</li>
									</ul>
								</div>
							</div>
						</div>

						<hr class="separador-one mt-2 mb-4">
						<div class="flex items-center justify-end">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnChangePassword" name="btnChangePassword" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<script>

</script>
