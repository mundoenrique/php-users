<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<div id="service" class="service-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Atención al cliente</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="service-group flex max-width-5 flex-wrap items-start justify-between mb-2">
					<div class="product-presentation flex flex-column items-end mr-4">
						<div class="relative">
							<div class="item-network <?= $data['marca']; ?>"></div>
							<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg', 'img', $countryUri); ?>" alt="Tarjeta gris">
						</div>
						<?php
						if ($totalProducts > 1) {
						?>
							<a id="open-card-details" class="flex items-baseline btn btn-link btn-small" href="<?= base_url('listaproducto') ?>">
								<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto
							</a>
						<?php
						}
						?>
					</div>
					<div class="product-info mr-2">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<?php if ($data['bloqueo'] !== '') : ?>
							<p class="mb-1 semibold danger"><?= lang('GEN_TEXT_BLOCK_PRODUCT'); ?></p>
						<?php endif; ?>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara']; ?></p>
						<p class="product-metadata h6"><?= $data['nombre_producto']; ?></p>
						<p class="product-metadata mb-0 h6"><?= strtoupper($data['nomEmp']); ?></p>

					</div>
					<div class="product-scheme">
						<p class="field-tip"><?= $availableServices !== 0 ? lang('GEN_SERVICES_AVAILABLE') : lang('GEN_NOT_SERVICES_AVAILABLE'); ?></p>
						<ul class='services-content list-inline flex mx-auto justify-between'>
							<?php
							foreach ($menuOptionsProduct as $row) {
								echo $row;
							}
							?>
						</ul>
					</div>
				</div>
				<div class="line mt-1"></div>

				<div class="max-width-4 mx-auto pt-3 p-responsive">
					<!-- Generacíon de PIN -->
					<div id="generateView" class="services-both max-width-1 fit-lg mx-auto">
						<div id="msgGen" class="msg-prevent-pin my-2">
							<h2 class="h4 regular tertiary">Generación de PIN</h2>
							<span>Los campos con <span class="danger">*</span> son requeridos.</span>
						</div>
						<form id="formGenerate" accept-charset="utf-8" method="post">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="generateNewPin">Nuevo PIN <span class="danger">*</span></label>
									<input id="generateNewPin" class="form-control" type="password" name="generateNewPin">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="generateConfirmPin">Confirmar PIN <span class="danger">*</span></label>
									<input id="generateConfirmPin" class="form-control" type="password" name="generateConfirmPin">
									<div class="help-block"></div>
								</div>
							</div>
							<div id="generateVerificationOTP" class="none">
								<hr class="separador-one mb-3">
								<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
								<div class="row">
									<div class="form-group col-lg-4">
										<label for="generateCodeOTP">Código de verificación <span class="danger">*</span></label>
										<input id="generateCodeOTP" class="form-control" type="text" name="generateCodeOTP" disabled>
										<div id="generateTxtMsgErrorCodeOTP" class="help-block"></div>
									</div>
								</div>
								<p id="generateVerificationMsg" class="mb-1 h5"></p>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link" href="">Cancelar</a>
								<button id="btnGenerate" class="btn btn-small btn-loading btn-primary" type="submit" name="btnGenerate">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Cambio de PIN -->
					<div id="changeView" class="services-both max-width-1 fit-lg mx-auto">
						<div id="msgChange" class="msg-prevent my-2">
							<h2 class="h4 regular tertiary">Cambio de PIN</h2>
							<span>Los campos con <span class="danger">*</span> son requeridos.</span>
						</div>
						<form id="formChange" accept-charset="utf-8" method="post">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="changeCurrentPin">PIN actual <span class="danger">*</span></label>
									<input id="changeCurrentPin" class="form-control" type="password" name="changeCurrentPin">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="changeNewPin">Nuevo PIN <span class="danger">*</span></label>
									<input id="changeNewPin" class="form-control" type="password" name="changeNewPin">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="changeConfirmPin">Confirmar PIN <span class="danger">*</span></label>
									<input id="changeConfirmPin" class="form-control" type="password" name="changeConfirmPin">
									<div class="help-block"></div>
								</div>
							</div>
							<div id="changeVerificationOTP" class="none">
								<hr class="separador-one mb-3">
								<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
								<div class="row">
									<div class="form-group col-lg-4">
										<label for="changeCodeOTP">Código de verificación <span class="danger">*</span></label>
										<input id="changeCodeOTP" class="form-control" type="text" name="changeCodeOTP" disabled>
										<div id="changeTxtMsgErrorCodeOTP" class="help-block"></div>
									</div>
								</div>
								<p id="changeVerificationMsg" class="mb-1 h5"></p>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link" href="">Cancelar</a>
								<button id="btnChange" class="btn btn-small btn-loading btn-primary" type="submit" name="btnChange">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Bloqueo de tarjeta -->
					<div id="lockView" class="services-both">
						<div id="msgLock" class="msg-prevent">
							<?php
							if (in_array('111', $data['availableServices'])) {

								$title = 'Bloqueo de tarjeta';
								$textDescription = 'bloquear';
							} else {

								$title = 'Desbloqueo de tarjeta';
								$textDescription = 'desbloquear';
							}
							?>
							<h2 class="h4 regular tertiary"><?= $title; ?></h2>
						</div>
						<div id="preventLock" class="msg-prevent">
							<h3 class="h4 regular">Si realmente deseas <span id="action"><?= $textDescription; ?> </span> tu tarjeta, presiona continuar</h3>
						</div>

						<form id="formLock" accept-charset="utf-8" method="post" class="profile-1">
							<div id="lockVerificationOTP" class="none">
								<hr class="separador-one mb-3">
								<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
								<div class="row">
									<div class="form-group col-lg-4">
										<label for="lockCodeOTP">Código de verificación <span class="danger">*</span></label>
										<input id="lockCodeOTP" class="form-control" type="text" name="lockCodeOTP" disabled>
										<div id="lockTxtMsgErrorCodeOTP" class="help-block"></div>
									</div>
								</div>
								<p id="lockVerificationMsg" class="mb-1 h5"></p>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link" href="">Cancelar</a>
								<button id="btnLock" class="btn btn-small btn-loading btn-primary" type="submit" name="btnLock">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Solicitud de reposición de tarjeta -->
					<div id="replaceView" class="services-both max-width-1 fit-lg mx-auto">
						<div id="msgReplace" class="msg-prevent my-2">
							<h2 class="h4 regular tertiary">Solicitud de reposición</h2>
							<span>Los campos con <span class="danger">*</span> son requeridos.</span>
						</div>
						<form id="formReplace" class="profile-1" accept-charset="utf-8" method="post">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="replaceMotSol">Motivo de la solicitud <span class="danger">*</span></label>
									<select id="replaceMotSol" class="custom-select form-control" name="replaceMotSol">
										<option value="">Selecciona</option>
										<option value="41"><?= lang('GENE_BLOCKING_REASONS_CANCELLED'); ?></option>
										<option value="46"><?= lang('GENE_BLOCKING_REASONS_LOST'); ?></option>
										<option value="43"><?= lang('GENE_BLOCKING_REASONS_DETERIORATED'); ?></option>
										<option value="59"><?= lang('GENE_BLOCKING_REASONS_STOLE'); ?></option>
										<option value="17"><?= lang('GENE_BLOCKING_REASONS_FRAUD'); ?></option>
									</select>
									<div class="help-block"></div>
								</div>
							</div>
							<div id="replaceVerificationOTP" class="none">
								<hr class="separador-one mb-3">
								<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
								<div class="row">
									<div class="form-group col-lg-4">
										<label for="replaceCodeOTP">Código de verificación <span class="danger">*</span></label>
										<input id="replaceCodeOTP" class="form-control" type="text" name="replaceCodeOTP" disabled>
										<div id="replaceTxtMsgErrorCodeOTP" class="help-block"></div>
									</div>
								</div>
								<p id="replaceVerificationMsg" class="mb-1 h5"></p>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link" href="">Cancelar</a>
								<button id="btnReplace" class="btn btn-small btn-loading btn-primary" type="submit" name="btnReplace">Continuar</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</section>
	</div>
</div>
<?php
$dataForm = json_encode([
	'msgResendOTP' => "<a name='resendCode' class='primary regular' href='#'>" . lang('RESP_RESEEND_OTP') . "</a>",
	'availableServices' => $data['availableServices']
]);
?>
<script>
	var dataCustomerProduct = <?= $dataForm; ?>;
</script>