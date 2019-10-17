<div class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Verificación de Cuenta</h2>
				<p>Si usted aún no posee usuario para accesar al sistema <strong>Conexión Personas</strong>, a continuación debe
					proporcionar los siguientes datos relacionados con su cuenta:</p>
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="form-verify-account">
						<div class="row">
							<div class="form-group col-lg-auto">
								<label for="document-id">Documento de Identidad <abbr title="Número de identificación del tarjetahabiente"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="document-id" class="form-control" maxlength="16" name="document-id" type="text" value="" autocomplete="off">
							</div>
							<div class="form-group col-lg-auto">
								<label for="telephone-number">Número de teléfono <abbr title="Introduce la clave secreta o PIN de tu tarjeta"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="telephone-number" class="form-control" maxlength="15" name="telephone-number" type="text" value="" required autocomplete="off">
							</div>
						</div>
						<div class="form-group form-check mt-4 mb-3">
							<input id="accept-terms" class="form-check-input" type="checkbox" name="accept-terms" value="" required disabled>
							<label class="form-check-label" for="accept-terms">
								Acepto las <a class="" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
						</div>
						<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btn-validar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
