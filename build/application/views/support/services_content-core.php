<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CUSTOMER_SUPPORT'); ?></h1>
<div class="pt-3">
	<div class="row">
		<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
			<div class="flex flex-wrap">
				<div class="w-100">
					<div class="flex inline-flex col-12 px-xl-2 widget-product">
						<div class="flex flex-colunm justify-center col-6 py-5">
							<div class="product-presentation relative">
								<div class="item-network maestro"></div>
								<div class="product-search">
									<a class="dialog button product-button btn"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
									<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
								</div>
								<img class="card-image" src="../../../assets/images/default/bnt_default.svg" alt="Tarjeta Banorte">
							</div>
						</div>
						<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">
							<span>Seleccione una cuenta</span>
							<p class="semibold mb-0 h5">PLATA VIÁTICOS</p>
							<p id="card" class="mb-2">604842******4714</p>
							<a id="other-product" class="btn hyper-link btn-small p-0" href="">
							<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto</a>
						</div>
					</div>
					<div class="flex col-12 optional mt-4 px-0">
						<nav class="nav-config">
							<ul class="flex flex-wrap justify-between nav-config-box">
								<li id="PinManagement" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-key h1 icon-color"></span>
									<h5 class="center">Gestión<br>de PIN</h5>
									<div class="box up left regular">
										<span class="icon-key h1 icon-color"></span>
										<h4 class="h5 center">Gestión<br>de PIN</h4>
									</div>
									</a>
								</li>
								<li id="CardLock" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-lock h1 icon-color"></span>
									<h5 class="center">Bloqueo<br>de tarjeta</h5>
									<div class="box up left regular">
										<span class="icon-lock h1 icon-color"></span>
										<h4 class="h5 center">Bloqueo<br>de tarjeta</h4>
									</div>
									</a>
								</li>
								<li id="replacementRequest" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-spinner h1 icon-color"></span>
									<h5 class="center">Solicitud<br>de reposición</h5>
									<div class="box up left regular">
										<span class="icon-spinner h1 icon-color"></span>
										<h4 class="h5 center">Solicitud<br>de reposición</h4>
									</div>
									</a>
								</li>
								<li id="" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-spinner h1 icon-color"></span>
									<h5 class="center">Solicitud<br>de reposición</h5>
									<div class="box up left regular">
										<span class="icon-spinner h1 icon-color"></span>
										<h4 class="h5 center">Solicitud<br>de reposición</h4>
									</div>
									</a>
								</li>
								<li id="" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-spinner h1 icon-color"></span>
									<h5 class="center">Solicitud<br>de reposición</h5>
									<div class="box up left regular">
										<span class="icon-spinner h1 icon-color"></span>
										<h4 class="h5 center">Solicitud<br>de reposición</h4>
									</div>
									</a>
								</li>
								<li id="" class="list-inline-item nav-item-config mr-0 px-1">
									<a href="javascript:">
									<span class="icon-config icon-spinner h1 icon-color"></span>
									<h5 class="center">Solicitud<br>de reposición</h5>
									<div class="box up left regular">
										<span class="icon-spinner h1 icon-color"></span>
										<h4 class="h5 center">Solicitud<br>de reposición</h4>
									</div>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-12 col-lg-6 col-xl-8">
			<div id="pinManagementView">
				<div class="flex mb-1 mx-4 flex-column">
					<h4 class="line-text mb-2 semibold primary">Gestión de PIN</h4>
					<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
						<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
					</div>
					<div class="hide-out hide">
						<div id="changeView" class="services-both max-width-1 fit-lg mx-auto fade-in">
							<p>Seleccione los la operación que desea realizar:</p>
							<form id="formChange" accept-charset="utf-8" method="post">
								<div class="form-group">
									<label class="mr-2">Operación:</label>
									<div class="custom-control custom-radio custom-control-inline">
										<input id="change-pin" class="custom-control-input" type="radio" name="recovery" value="change" checked="" autocomplete="off">
										<label class="custom-control-label" for="change-pin">Cambiar PIN</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input id="generate-pin" class="custom-control-input" type="radio" name="recovery" value="generate" autocomplete="off">
										<label class="custom-control-label" for="generate-pin">Recuperar PIN</label>
									</div>
									<div class="help-block"></div>
								</div>
								<div class="row">
									<div id="current-pin-field" class="form-group col-lg-4">
										<label for="changeCurrentPin">PIN actual</label>
										<input id="changeCurrentPin" class="form-control" type="password" name="changeCurrentPin" autocomplete="off">
										<div class="help-block"></div>
									</div>
									<div class="form-group col-lg-4">
										<label for="changeNewPin">Nuevo PIN</label>
										<input id="changeNewPin" class="form-control" type="password" name="changeNewPin" autocomplete="off">
										<div class="help-block"></div>
									</div>
									<div class="form-group col-lg-4">
										<label for="changeConfirmPin">Confirmar PIN</label>
										<input id="changeConfirmPin" class="form-control" type="password" name="changeConfirmPin" autocomplete="off">
										<div class="help-block"></div>
									</div>
								</div>
								<div id="changeVerificationOTP">
									<hr class="separador-one mb-3">
									<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
									<div class="row">
										<div class="form-group col-lg-4">
											<label for="changeCodeOTP">Código de verificación</label>
											<input id="changeCodeOTP" class="form-control" type="text" name="changeCodeOTP" disabled="" autocomplete="off">
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
					</div>
				</div>
			</div>

			<div id="cardLockView">
				<div class="flex mb-1 mx-4 flex-column">
					<h4 class="line-text mb-2 semibold primary">Bloqueo de tarjeta</h4>
					<p>Si realmente deseas bloqueas tu tarjeta, presiona continuar</p>
						<div class="flex items-center justify-end pt-3">
							<a class="btn btn-small btn-link" href="">Cancelar</a>
							<button id="btnChange" class="btn btn-small btn-loading btn-primary" type="submit" name="btnChange">Continuar</button>
						</div>
					</div>
				</div>
			</div>

		<div id="replacementRequestView">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text mb-2 semibold primary">Bloqueo de tarjeta</h4>
				<p>Seleccione una motivo de la solicitud</p>
				<form id="formReplace" class="profile-1" method="post">
					<div class="row">
						<div class="form-group col-lg-4">
							<label for="replaceMotSol">Motivo de la solicitud</label>
							<select id="replaceMotSol" class="custom-select form-control" name="replaceMotSol">
								<option value="">Selecciona</option>
								<option value="59">Tarjeta robada</option>
								<option value="17">Sospecha de fraude</option>
								<option value="41">Tarjeta cancelada</option>
							</select>
							<div class="help-block"></div>
						</div>
					</div>
					<div id="replaceVerificationOTP">
						<hr class="separador-one mb-3">
						<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
						<div class="row">
							<div class="form-group col-lg-4">
								<label for="replaceCodeOTP">Código de verificación</label>
								<input id="replaceCodeOTP" class="form-control" type="text" name="replaceCodeOTP" disabled="" autocomplete="off">
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
	</div>
</div>


