<div id="preRegistry" class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<hr class="separador-one">
		<section>
			<div class="pt-3">
				<h2 class="tertiary h3">Verificación de Cuenta</h2>
				<p>Si usted aún no posee usuario para accesar al sistema <strong>Conexión Personas</strong>, a continuación debe
					proporcionar los siguientes datos relacionados con su cuenta:</p>
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="formVerifyAccount">
						<div class="row">
							<div class="form-group col-lg-auto">
								<label for="idNumber">Documento de Identidad</label>
								<input id="idNumber" class="form-control" type="text" placeholder="12345678" name="idNumber">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-auto">
								<label for="telephoneNumber">Número de teléfono</label>
								<input id="telephoneNumber" class="form-control" type="text"  placeholder="04161112233" name="telephoneNumber">
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group form-check my-3">
							<input id="acceptTerms" class="form-check-input" type="checkbox" name="acceptTerms">
							<label class="form-check-label" for="acceptTerms">
								Acepto las <a class="" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
							<div class="help-block"></div>
						</div>
						<hr class="separador-one">
						<div class="flex items-center justify-end pt-3">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnValidar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>

