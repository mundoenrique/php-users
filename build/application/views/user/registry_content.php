<div class="registro-content max-width-4 mx-auto p-responsive py-4">
	<header class="">
		<h1 class="primary h0">Registro</h1>
	</header>
	<section>
		<div class="border-top pt-3">
			<h2 class="tertiary h3">Verificación de Cuenta</h2>
			<p>Si usted aún no posee usuario para accesar al sistema <strong>Conexión Personas</strong>, a continuación debe
				proporcionar los siguientes datos relacionados con su cuenta:</p>
			<div class="pt-3 pb-2 border-bottom">
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
					<div class="form-group my-4">
						<div class="form-check">
							<input id="accept-terms" class="form-check-input" type="checkbox" name="accept-terms" value="" required disabled>
							<label class="form-check-label" for="accept-terms">
								Acepto las <a class="" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
						</div>
					</div>
				</form>
			</div>
			<div class="mt-2 flex justify-end">
				<div class="lds-spinner inline-block absolute mb-5 pb-5">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
				<a href="<?= base_url('inicio');?>"><input class="btn underline" type="reset" value="Cancelar"></a>
				<button id="validar" class="btn btn-primary" type="submit">Continuar</button>
			</div>
		</div>
	</section>
</div>
