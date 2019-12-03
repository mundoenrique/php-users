<form method="post">
	<input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<div id="service" class="service-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Atención al Cliente</h1>
		</header>
		<section>
			<div class="pt-3">
				<div class="service-group flex max-width-4 items-center justify-between mb-2">
					<div class="product-presentation relative mr-4">
						<div class="item-network <?= $data['marca']; ?>"></div>
						<img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg','img',$countryUri); ?>" alt="Tarjeta gris">
					</div>
					<div class="product-info mr-5">
						<p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
						<p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara'];?></p>
						<p class="product-metadata h6"><?= $data['nombre_producto'];?></p>
						<p class="product-metadata mb-0 h6"><?= strtoupper($data['nomEmp']);?></p>

					</div>
					<div class="product-scheme">
						<p class="field-tip">Selecciona la operación que deseas realizar</p>
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

				<div class="max-width-4 mx-auto pt-3 p-responsive py-4">
					<!-- Generacíon de PIN -->
					<div id="generateView" class="services-both none">
						<div id="msgGen" class="msg-prevent-pin">
							<h2 class="h4 regular tertiary">Generación de PIN</h2>
						</div>
						<form id="formGenerate" accept-charset="utf-8" method="post">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="newPin">Nuevo PIN</label>
									<input id="newPin" class="form-control" type="password" name="newPin">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="confirmPin">Confirmar PIN</label>
									<input id="confirmPin" class="form-control" type="password" name="confirmPin">
									<div class="help-block"></div>
								</div>
							</div>
							<div class="flex items-center justify-end pt-3 border-top">
								<a class="btn underline" href="">Cancelar</a>
								<button id="btnGenerate" name="btnGenerate" class="btn btn-primary" type="submit">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Cambio de PIN -->
					<div id="changeView" class="services-both max-width-1 fit-lg mx-auto pt-3 none">
						<div id="msgChange" class="msg-prevent">
							<h2 class="h4 regular tertiary">Cambio de PIN</h2>
						</div>
						<form id="formChange" accept-charset="utf-8" method="post">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="pinCurrent">PIN actual</label>
									<input id="pinCurrent" class="form-control" type="password" name="pinCurrent">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="newPin">Nuevo PIN</label>
									<input id="newPin" class="form-control" type="password" name="newPin">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="confirmPin">Confirmar PIN</label>
									<input id="confirmPin" class="form-control" type="password" name="confirmPin">
									<div class="help-block"></div>
								</div>
							</div>
							<div class="line mt-1"></div>
							<div class="flex items-center justify-end pt-3">
								<a class="btn underline" href="">Cancelar</a>
								<button id="btnChange" name="btnChange" class="btn btn-primary" type="submit">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Bloqueo de tarjeta -->
					<div id="lockView" class="services-both none">
						<div id="msgLock" class="msg-prevent">
							<h2 class="h4 regular tertiary">Bloquear cuenta</h2>
						</div>
						<div id="preventLock" class="msg-prevent">
							<h3 class="h4 regular">Si realmente deseas <span id="action">Bloquear </span> tu tarjeta, presiona continuar</h3>
						</div>
						<form id="formLock" accept-charset="utf-8" method="post" class="profile-1">
							<div class="flex items-center justify-end pt-3 border-top">
								<a class="btn underline" href="">Cancelar</a>
								<button id="btnLock" name="btnLock" class="btn btn-primary" type="submit">Continuar</button>
							</div>
						</form>
					</div>

					<!-- Solicitud de reposición de tarjeta -->
					<div id="replaceView" class="services-both none">
						<div id="msgReplacement" class="msg-prevent">
							<h2 class="h4 regular tertiary">Solicitud de reposición</h2>
						</div>
						<form id="formReplace" accept-charset="utf-8" method="post" class="profile-1">
							<div class="form-group col-lg-3">
								<label for="motSol">Motivo de la solicitud</label>
								<select id="motSol" class="custom-select form-control" name="motSol">
									<option value="">Selecciona</option>
									<option value="41">Tarjeta perdida</option>
									<option value="43">Tarjeta robada</option>
									<option value="TD">Tarjeta deteriorada</option>
									<option value="TR">Reemplazar tarjeta</option>
								</select>
								<div class="help-block"></div>
							</div>

							<div class="flex items-center justify-end pt-3 border-top">
								<a class="btn underline" href="">Cancelar</a>
								<button id="btnReplace" name="btnReplace" class="btn btn-primary" type="submit">Continuar</button>
							</div>
						</form>
					</div>

				</div>
			</div>
		</section>
	</div>
</div>

