<div id="preRegistry" class="registro-content h-100 bg-white">
	<div class="max-width-4 mx-auto p-responsive py-4">
		<header class="">
			<h1 class="primary h0">Registro</h1>
		</header>
		<section>
			<hr class="separador-one">
			<div class="pt-3">
				<h2 class="tertiary h3">Verificación de Cuenta</h2>
				<p>Si aún no posees usuario para acceder al sistema <strong><?= $nameAplication;?></strong>, a continuación debes
				proporcionar los siguientes datos relacionados con tu cuenta:</p>
				<hr class="separador-one">
				<div class="max-width-1 fit-lg mx-auto pt-3">
					<form method="post" id="formVerifyAccount">
						<div class="row">
							<div class="form-group col-lg-3">
								<label for="typeDocument">Tipo de Documento</label><br>
								<select id="typeDocument" class="custom-select form-control" name="typeDocument">
									<option selected="" value="0">Seleccione</option>
									<?php foreach ($typeDocument as $row) {?>
									<option value="<?= $row['cod'];?>"><?= $row['text'];?></option>
									<?php }?>
								</select>
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-3">
								<label for="idNumber">Documento de Identidad</label>
								<input id="idNumber" class="form-control" type="text" name="idNumber">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-3">
								<label for="nitBussines">Nit de la Empresa</label>
								<input id="nitBussines" class="form-control" type="text" name="nitBussines">
								<div class="help-block"></div>
							</div>
							<div class="form-group col-lg-3">
								<label for="telephoneNumber">Número de teléfono</label>
								<input id="telephoneNumber" class="form-control" type="text" name="telephoneNumber">
								<div class="help-block"></div>
							</div>
						</div>
						<div class="form-group custom-control custom-switch my-3">
							<input id="acceptTerms" class="custom-control-input" type="checkbox" name="acceptTerms">
							<label class="custom-control-label" for="acceptTerms">
								Acepto las <a class="primary" href="#" rel="section">condiciones de uso</a> de este sistema
							</label>
							<div class="help-block"></div>
						</div>
						<div id="verification" class="none">
							<hr class="separador-one mb-3">
							<p>Se ha envíado un código de verificación a su correo electrónico, por favor introduzca el código a continuación:</p>
							<div class="row form-group col-lg-3">
								<label for="codeOTP">Codigo de Validación</label>
								<input id="codeOTP" class="form-control ignore" type="text" name="codeOTP" disabled>
								<div class="help-block"></div>
							</div>
							<p id="verificationMsg" class="mb-3 h5"></p>
						</div>
						<hr class="separador-one">
						<div class="flex items-center justify-end pt-3">
							<a class="btn btn-small btn-link" href="<?= base_url('inicio');?>">Cancelar</a>
							<button id="btnValidar" class="btn btn-small btn-loading btn-primary" type="submit">Continuar</button>
							<button id="btnVerifyOTP" class="btn btn-small btn-loading btn-primary none" type="submit">Continuar</button>
						</div>


					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
	var setTimerOTP = <?= $setTimerOTP;?>;
</script>

