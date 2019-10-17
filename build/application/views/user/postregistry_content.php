<div class="postregistro-content h-100 bg-white">
	<div class="py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<div class="border-top pt-3">
				<h2 class="tertiary h3">Afiliación de Datos</h2>
				<p>Para obtener su usuario de <strong>Conexión Personas</strong>, es necesario ingrese los datos requeridos a continuación:</p>
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="form-validar">
						<div class="row">
							<div class="form-group col-lg-auto">
								<label for="card-number">Número de Tarjeta</label>
								<input id="card-number" class="form-control" maxlength="16" name="card-number" type="text" value="" autocomplete="off">
							</div>
							<div class="form-group col-lg-auto">
								<label for="card-holder-id">Documento de Identidad <abbr title="Número de identificación del tarjetahabiente"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="card-holder-id" class="form-control" maxlength="16" name="card-holder-id" type="text" value="" autocomplete="off">
							</div>
							<div class="form-group col-lg-auto">
								<label for="card-holder-pin">Clave Secreta (PIN) <abbr title="Introduce la clave secreta o PIN de tu tarjeta"><span aria-hidden="true" class="icon-question-sign"></span></abbr></label>
								<input id="card-holder-pin" class="form-control" maxlength="15" name="card-holder-pin" type="password" value="" autocomplete="off">
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
							<button id="validar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
