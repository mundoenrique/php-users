<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CUSTOMER_SUPPORT'); ?></h1>
<div class="pt-3">
	<div class="row">
		<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
			<div class="flex flex-wrap widget-product">
				<div class="w-100">
					<!-- <div class="flex inline-flex col-12 px-xl-2">
						<div class="flex flex-colunm justify-center col-6 py-5">
							<div class="product-presentation relative">
								<div class="item-network"></div>
								<div id="donor" class="product-search btn">
									<a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
									<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
								</div>
							</div>
						</div>
						<div class="flex flex-column items-start self-center col-6 py-5">
							<p class="mb-2">Seleccione una cuenta</p>
						</div>
					</div> -->
					<div class="flex inline-flex col-12 px-xl-2">
						<div class="flex flex-colunm justify-center col-6 py-5">
							<div class="product-presentation relative">
								<div class="item-network <?= $brand; ?>"></div>
								<?php if ($cardsTotal == 1): ?>
								<img class="card-image" src="<?= $this->asset->insertFile($productImg, $productUrl); ?>" alt="<?= $productName; ?>">
								<?php endif; ?>
							</div>
						</div>
						<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">
							<!-- <?php if ($cardsTotal > 1): ?> -->
							<span>Seleccione una cuenta</span>
							<?php endif; ?>
							<p class="semibold mb-0 h5 truncate"><?= $productName; ?></p>
							<p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
							<!-- <?php if ($cardsTotal > 1): ?> -->
							<a id="other-product" class="btn hyper-link btn-small p-0" href="">
								<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto</a>
							<?php endif; ?>
						</div>
					</div>
					<?php if(TRUE): ?>
					<div class="flex col-12 optional mt-4 px-0">
						<nav class="nav-config w-100">
							<ul class="flex flex-wrap justify-center nav-config-box">
								<li id="pinManagement" class="list-inline-item nav-item-config mr-2">
									<a href="javascript:">
										<span class="icon-config icon-key h1 icon-color"></span>
										<h5 class="center">Gestión<br>de PIN</h5>
										<div class="box up left regular">
											<span class="icon-key h1 icon-color"></span>
											<h4 class="h5 center">Gestión<br>de PIN</h4>
										</div>
									</a>
								</li>
								<li id="cardLock" class="list-inline-item nav-item-config mr-2">
									<a href="javascript:">
										<span class="icon-config icon-lock h1 icon-color"></span>
										<h5 class="center"><?= $statustext ?><br>de tarjeta</h5>
										<div class="box up left regular">
											<span class="icon-lock h1 icon-color"></span>
											<h4 class="h5 center"><?= $statustext ?><br>de tarjeta</h4>
										</div>
									</a>
								</li>
								<li id="replacementRequest" class="list-inline-item nav-item-config">
									<a href="javascript:">
										<span class="icon-config icon-spinner h1 icon-color"></span>
										<h5 class="center">Solicitud<br>de reposición</h5>
										<div class="box up left regular">
											<span class="icon-spinner h1 icon-color"></span>
											<h4 class="h5 center">Solicitud<br>de reposición</h4>
										</div>
									</a>
								</li>
								<li id="transactionalLimits" class="list-inline-item nav-item-config">
									<a href="javascript:">
										<span class="icon-config icon novoglyphs icon-spinner h1 icon-color"></span>
										<h5 class="center">Limites<br>transaccionales</h5>
										<div class="box up left regular">
											<span class="icon novoglyphs icon-spinner h1 icon-color"></span>
											<h4 class="h5 center">Limites<br>transaccionales</h4>
										</div>
									</a>
								</li>
								<li id="twirlsCommercial" class="list-inline-item nav-item-config">
									<a href="javascript:">
										<span class="icon-config icon novoglyphs icon-credit-card h1 icon-color"></span>
										<h5 class="center">Giros<br>comerciales</h5>
										<div class="box up left regular">
											<span class="icon novoglyphs icon-credit-card h1 icon-color"></span>
											<h4 class="h5 center">Giros<br>comerciales</h4>
										</div>
									</a>
								</li>
							</ul>
						</nav>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="col-12 col-sm-12 col-lg-12 col-xl-8 pt-3">
			<div id="pinManagementView" style="display:none">
				<div class="flex mb-1 mx-4 flex-column">
					<h4 class="line-text mb-2 semibold primary">Gestión de PIN</h4>
					<div id="pre-loader" class="mt-2 mb-4 mx-auto flex justify-center">
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
									<div class="custom-control custom-radio custom-control-inline">
										<input id="pin-request" class="custom-control-input" type="radio" name="recovery" value="request" autocomplete="off">
										<label class="custom-control-label" for="pin-request">Solicitud de PIN</label>
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
								<div id="pinRequestOTP" class="none">
									<hr class="separador-one mb-3">
									<p>Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en Conexión Empresas Online, para poder
										emitir el nuevo PIN.</p>
									<p>Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en un máximo de 5 días hábiles en
										un sobre de seguridad a la dirección de tu empresa.</p>
								</div>
								<div id="changeVerificationOTP" class="none">
									<hr class="separador-one mb-3">
									<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
									<div class="row">
										<div class="form-group col-lg-4">
											<label for="changeCodeOTP">Código de verificación</label>
											<input id="changeCodeOTP" class="form-control" type="text" name="changeCodeOTP" disabled autocomplete="off">
											<div id="changeTxtMsgErrorCodeOTP" class="help-block"></div>
										</div>
									</div>
									<p id="changeVerificationMsg" class="mb-1 h5"></p>
								</div>
								<hr class="separador-one">
								<div class="flex items-center justify-end pt-3">
									<a class="btn btn-small btn-link" href="">Cancelar</a>
									<button id="" class="btn btn-small btn-loading btn-primary" type="submit" >Continuar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div id="cardLockView" style="display:none">
				<div class="flex mb-1 mx-4 flex-column">
					<h4 class="line-text mb-2 semibold primary"><span class="status-text1"><?= $statustext ?></span> tarjeta</h4>
					<p>Si realmente deseas <span class="status-text2"><?= mb_strtolower($statustext) ?></span> tu tarjeta, presiona continuar</p>
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= lang('GEN_LINK_CARDS_LIST') ?>">Cancelar</a>
						<button id="blockBtn" class="btn btn-small btn-loading btn-primary">Continuar</button>
					</div>
				</div>
			</div>

			<div id="replacementRequestView" style="display:none">
				<div class="flex mb-1 mx-4 flex-column">
					<h4 class="line-text mb-2 semibold primary">Solicitud de reposición</h4>
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
						<div id="replaceVerificationOTP" class="none">
							<hr class="separador-one mb-3">
							<p>Hemos enviado un código de verificación a tu teléfono móvil, por favor indícalo a continuación:</p>
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="replaceCodeOTP">Código de verificación</label>
									<input id="replaceCodeOTP" class="form-control" type="text" name="replaceCodeOTP" disabled autocomplete="off">
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

			<div id="transactionalLimitsView" style="display:none">
				<div class="flex mb-1 mx-4 flex-column">

					<div class="w-100 hide-out hide">
						<div class="flex flex-auto flex-column">
							<div class="search-criteria-order flex pb-3 flex-column w-100">
								<span class="line-text mb-2 h4 semibold primary"><?= lang('GEN_SEARCH_CRITERIA'); ?></span>
								<div class="flex my-2 px-5">
									<form method="post" class="w-100">
										<div class="row flex justify-between">
											<div class="form-group col-4 col-xl-4">
												<label for="idNumberP"><?= lang('GEN_TABLE_DNI'); ?></label>
												<input id="idNumberP" name="idNumberP" class="form-control h5 select-group" type="text" autocomplete="off" disabled>
												<div class="help-block"></div>
											</div>
											<div class="form-group col-4 col-xl-4">
												<label for="cardNumberP"><?= lang('GEN_CARD_NUMBER'); ?></label>
												<input id="cardNumberP" name="cardNumberP" class="form-control h5 select-group" type="text" autocomplete="off" disabled>
												<div class="help-block"></div>
											</div>
											<div class="flex items-center justify-end col-3">
												<button type="submit" id="card-holder-btn" class="btn btn-primary btn-small btn-loading">
													<?= lang('GEN_BTN_SEARCH'); ?>
												</button>
											</div>
										</div>
									</form>
								</div>
								<div class="line mb-2"></div>
							</div>
							<div class="flex pb-5 px-2 flex-column">
								<div class="flex flex-column">
									<div class="flex light items-center line-text mb-5">
										<div class="flex tertiary">
											<span class="inline h4 semibold primary">Resultados</span>
										</div>
										<div class="flex h6 flex-auto justify-end">
											<span>Fecha de actualización: 3/07/2020 5:36 PM</span>
										</div>
									</div>
									<div class="row flex justify-between my-3">
										<div class="form-group col-4 center">
											<p class="h5 semibold tertiary"><?= lang('GEN_CARD_NUMBER'); ?>: <span class="light text">**********270300</span></p>
										</div>
										<div class="form-group col-4 center">
											<p class="h5 semibold tertiary"><?= lang('GEN_TABLE_NAME'); ?>: <span class="light text">Jhonatan Ortiz</span></p>
										</div>
										<div class="form-group col-4 center">
											<p class="h5 semibold tertiary"><?= lang('GEN_TABLE_DNI'); ?>: <span class="light text">1803752318</span></p>
										</div>
									</div>
								</div>
								<div class="flex mb-5 flex-column">
									<span class="line-text slide-slow flex mb-2 h4 semibold primary">Con tarjeta presente
										<i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
									</span>
									<div class="section my-2 px-5">
										<form id="">
											<div class="container">
												<div class="row">
													<div class="col-10 bolck mx-auto">
														<div class="row">
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="numberDayPurchasesCtp">Número de compras diarias</label>
																<div class="input-group">
																	<input id="numberDayPurchasesCtp" class="money form-control pwd-input text-right" value="" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="numberWeeklyPurchasesCtp">Número de compras semanales</label>
																<div class="input-group">
																	<input id="numberWeeklyPurchasesCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="numberMonthlyPurchasesCtp">Número de compras mensuales</label>
																<div class="input-group">
																	<input id="numberMonthlyPurchasesCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="dailyPurchaseamountCtp">Monto diario de compras</label>
																<div class="input-group">
																	<input id="dailyPurchaseamountCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyAmountPurchasesCtp">Monto semanal de compras</label>
																<div class="input-group">
																	<input id="weeklyAmountPurchasesCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyPurchasesAmountCtp">Monto mensual de compras</label>
																<div class="input-group">
																	<input id="monthlyPurchasesAmountCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="purchaseTransactionCtp">Monto por transacción de compras</label>
																<div class="input-group">
																	<input id="purchaseTransactionCtp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="flex mb-5 flex-column">
									<span class="line-text slide-slow flex mb-2 h4 semibold primary">Sin tarjeta presente
										<i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
									</span>
									<div class="section my-2 px-5">
										<form id="">
											<div class="container">
												<div class="row">
													<div class="col-10 bolck mx-auto">
														<div class="row">
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="numberDayPurchasesStp">Número de compras diarias</label>
																<div class="input-group">
																	<input id="numberDayPurchasesStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="numberWeeklyPurchasesStp">Número de compras semanales</label>
																<div class="input-group">
																	<input id="numberWeeklyPurchasesStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="numberMonthlyPurchasesStp">Número de compras mensuales</label>
																<div class="input-group">
																	<input id="numberMonthlyPurchasesStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="dailyPurchaseamountStp">Monto diario de compras</label>
																<div class="input-group">
																	<input id="dailyPurchaseamountStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyAmountPurchasesStp">Monto semanal de compras</label>
																<div class="input-group">
																	<input id="weeklyAmountPurchasesStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyPurchasesAmountStp">Monto mensual de compras</label>
																<div class="input-group">
																	<input id="monthlyPurchasesAmountStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="purchaseTransactionStp">Monto por transacción de compras</label>
																<div class="input-group">
																	<input id="purchaseTransactionStp" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="flex mb-5 flex-column ">
									<span class="line-text slide-slow flex mb-2 h4 semibold primary">Retiros
										<i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
									</span>
									<div class="section my-2 px-5">
										<form id="">
											<div class="container">
												<div class="row">
													<div class="col-10 bolck mx-auto">
														<div class="row">
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="dailyNumberWithdraw">Número diario de retiros</label>
																<div class="input-group">
																	<input id="dailyNumberWithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyNumberWithdraw">Número semanal de retiros</label>
																<div class="input-group">
																	<input id="weeklyNumberWithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyNumberWithdraw">Número mensual de retiros</label>
																<div class="input-group">
																	<input id="monthlyNumberWithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label class ="pr-3" for="dailyAmountWithdraw">Monto diario de retiros</label>
																<div class="input-group">
																	<input id="dailyAmountWithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyAmountWithdraw">Monto semanal de retiros</label>
																<div clxs="input-group">
																	<input id="weeklyAmountWithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyAmountwithdraw">Monto mensual de retiros</label>
																<div class="input-group">
																	<input id="monthlyAmountwithdraw" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="WithdrawTransaction">Monto por transacción de retiros</label>
																<div class="input-group">
																	<input id="WithdrawTransaction" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="flex mb-5 flex-column ">
									<span class="line-text slide-slow flex mb-2 h4 semibold primary">Créditos
										<i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
									</span>
									<div class="section my-2 px-5">
										<form id="">
											<div class="container">
												<div class="row">
													<div class="col-10 bolck mx-auto">
														<div class="row">
															<div class="form-group col-12 col-lg-4">
																<label class="pr-3" for="dailyNumberCredit">Número diario de créditos</label>
																<div class="input-group">
																	<input id="dailyNumberCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyNumberCredit">Número semanal de créditos</label>
																<div class="input-group">
																	<input id="weeklyNumberCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyNumberCredit">Número mensual de créditos</label>
																<div class="input-group">
																	<input id="monthlyNumberCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label class="pr-3" for="dailyAmountCredit">Monto diario de créditos</label>
																<div class="input-group">
																	<input id="dailyAmountCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="weeklyAmountCredit">Monto semanal de créditos</label>
																<div clxs="input-group">
																	<input id="weeklyAmountCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="monthlyAmountCredit">Monto mensual de créditos</label>
																<div class="input-group">
																	<input id="monthlyAmountCredit" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
															<div class="form-group col-12 col-lg-4">
																<label for="CreditTransaction">Monto por transacción de créditos</label>
																<div class="input-group">
																	<input id="CreditTransaction" class="money form-control pwd-input text-right" type="text" autocomplete="off" name="" required disabled>
																</div>
																<div class="help-block"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
								<form id="" method="post">
									<div class="flex row mt-3 mb-2 mx-2 justify-end">
										<div class="col-5 col-lg-3 col-xl-3 form-group">
											<div class="input-group">
												<input id="password-sign" name="password" class="form-control pwd-input pr-0" type="password" autocomplete="off" placeholder="Contraseña">
												<div class="input-group-append">
													<span id="pwd_action" class="input-group-text pwd-action" title="Mostrar contraseña"><i class="icon-view mr-0"></i></span>
												</div>
											</div>
											<div class="help-block bulk-select text-left"></div>
										</div>
										<div class="col-auto">
											<button id="sign-bulk-btn" class="btn btn-primary btn-small btn-loading flex mx-auto">
												Actualizar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div id="twirlsCommercialView" style="display:none">
				<div class="flex mb-1 mx-4 flex-column">
					 aqui pegas las maqueta :)
				</div>
			</div>
		</div>
	</div>
</div>

<form id="operation">
	<input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber; ?>">
	<input type="hidden" id="cardNumberMask" name="cardNumberMask" value="<?= $cardNumberMask; ?>">
	<input type="hidden" id="expireDate" name="expireDate" value="<?= $expireDate; ?>">
	<input type="hidden" id="prefix" name="prefix" value="<?= $prefix; ?>">
	<input type="hidden" id="status" name="status" value="<?= $status; ?>">
	<input type="hidden" id="action" name="action" value="TemporaryLock">
</form>
