<div id="service" class="service-content h-100 bg-content">
	<div class="py-4 px-5">
		<header class="">
			<h1 class="h3 semibold primary">Atención al cliente</h1>
		</header>
		<section>
			<div class="product-scheme pt-3">
				<div class="form-group">
					<label for="otherPhone">Selecciona una cuenta</label>
					<select class="custom-select form-control" placeholder="Seleccione" name="phoneType" id="phoneType">
						<option value="OFC">604842******8712</option>
						<option value="FAX">604841******4423</option>
					</select>
				</div>
				<p class="field-tip mt-3">Selecciona la operación que deseas realizar</p>
				<ul class='services-content list-inline flex mx-auto justify-between'>
					<li id="lock" class="list-inline-item services-item center"><i class="icon-lock block"></i>Bloqueo <br>de cuenta</li>
					<li id="replace" class="list-inline-item services-item center"><i class="icon-spinner block"></i>Solicitud <br>de reposición</li>
					<li id="key" class="list-inline-item services-item center"><i class="icon-key block"></i>Cambio <br>de PIN</li>
					<li id="recover" class="list-inline-item services-item center"><i class="icon-key block"></i>Solicitud <br>de PIN</li>
				</ul>
			</div>
			<div class="line mt-1"></div>

			<div class="max-width-4 mx-auto pt-3 p-responsive py-4">
				<!-- Bloqueo de tarjeta -->
				<div id="lockAcount" class="services-both none">
					<div id="msgBlock" class="msg-prevent">
						<h2 class="h4 regular tertiary"></h2>
						<h3></h3>
						<div id="result-block"></div>
					</div>
					<div id="preventBloq" class="msg-prevent none">
						<h3 class="h4 regular">Si realmente deseas <span id="action">Bloquear </span> tu tarjeta, presiona continuar</h3>
					</div>
					<form id="bloqueo-cuenta" accept-charset="utf-8" method="post" class="profile-1">
						<input type="hidden" id="fechaExpBloq" name="fechaExpBloq">
						<input type="hidden" id="cardBloq" name="cardBloq">
						<input type="hidden" id="status" name="status">
						<input type="hidden" id="lockType" name="lockType">
						<input type="hidden" id="prefixBloq" name="prefixBloq">
						<input type="hidden" id="montoComisionTransaccion" name="montoComisionTransaccion" value="0">
						<div id="reasonRep" class="none">
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
							<input type="hidden" id="motSolNow" name="motSolNow">
						</div>

						<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="cpo_login.php">Cancelar</a>
							<button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>

					<div id="msg1" style="clear:both;"></div>
				</div>
				<!-- Cambio de PIN -->
				<div id="changeKey" class="services-both max-width-1 fit-lg mx-auto pt-3 none">

					<div id="msg-change" class="msg-prevent">
						<h2 class="h4 regular tertiary">Cambio de PIN</h2>
						<h3></h3>
						<div id="result-change"></div>
					</div>

					<form id="cambioPin" accept-charset="utf-8" method="post" class="profile-1">
						<input id="fechaExpCambio" type="hidden" name="fechaExpCambio">
						<input id="cardCambio" type="hidden" name="cardCambio">
						<input id="prefixCambio" type="hidden" name="prefixCambio">
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
							<a class="btn underline" href="cpo_login.php">Cancelar</a>
							<button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
					</form>

					<div id="msg2" style="clear:both;"></div>
				</div>
				<!-- Reposición de PIN -->
				<div id="recKey" class="services-both none">
					<div id="msg-rec" class="msg-prevent-pin">
						<h2 class="h4 regular tertiary">Solicitud de reposición de PIN</h2>
						<h3></h3>
						<div id="result-rec"></div>
					</div>
					<div id="rec-clave" class="msg-prevent" style="">
						<p class="msg-pin">Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en Conexión Empresas Online, para poder emitir el nuevo PIN.</p>
						<p class="msg-pin">Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en un máximo de 5 días hábiles en un sobre de seguridad a la dirección de tu empresa.</p>
					</div>
					<form id="recover-key" accept-charset="utf-8" method="post" class="profile-1">
						<input type="hidden" id="fecha-exp-rec" name="fecha-exp-rec">
						<input type="hidden" id="card-rec" name="card-rec">
						<input type="hidden" id="prefix-rec" name="prefix-rec">
					</form>
					<div class="flex items-center justify-end pt-3 border-top">
							<a class="btn underline" href="cpo_login.php">Cancelar</a>
							<button id="btnContinuar" name="btnContinuar" class="btn btn-primary" type="submit">Continuar</button>
						</div>
				</div>
			</div>
		</section>



	</div>
</div>
