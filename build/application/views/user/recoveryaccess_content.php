<div id="registry" class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Recuperar Acceso</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Verificación de Datos</h2>
				<p>Para recuperar su usuario o restablecer su contraseña de acceso a <strong>Conexión Personas</strong>, debe seleccionar la opción correspondiente e ingresar los datos requeridos.</p>
				<hr class="separador-one">
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="formRecoveryAccess">
						<div class="form-group">
							<label class="mr-2">Necesito recuperar mi</label>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="recoveryUser" name="recovery" class="custom-control-input" value="M">
								<label class="custom-control-label" for="recoveryUser">Usuario</label>
							</div>
							<div class="custom-control custom-radio custom-control-inline">
								<input type="radio" id="recoveryPwd" name="recovery" class="custom-control-input" value="F">
								<label class="custom-control-label" for="recoveryPwd">Contraseña</label>
							</div>
							<div class="help-block"></div>
						</div>
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="email">Correo Electrónico</label>
								<input id="email" class="form-control" type="text" name="email"  placeholder="usuario@ejemplo.com">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-4">
								<label for="idNumber">Documento de Identidad</label>
								<input id="idNumber" class="form-control" type="text" name="idNumber">
								<div class="help-block"></div>
							</div>
						</div>
						<hr class="separador-one mt-3">
						<div class="flex items-center justify-end pt-3">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
