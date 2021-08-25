<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="primary h3 semibold inline"><?= lang('GEN_MENU_TRANSFERS'); ?></h1>
<div class="row">
	<div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
		<div class="flex flex-wrap">
			<div class="w-100">
				<div class="widget-product">
					<div class="line-text w-100">
						<div id="productdetail" class="flex inline-flex col-12 px-xl-2">
							<div class="flex flex-column justify-center col-6 py-4">
								<div class="product-presentation relative w-100">
									<div class="item-network <?= $totalCards == 1 && lang('CONF_FRANCHISE_LOGO') === 'ON' ? $brand : 'hide'; ?>"></div>
									<?php if ($totalCards > 1) : ?>
										<div id="donor" class="product-search btn">
											<a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
											<input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
										</div>
									<?php else : ?>
										<small class="h6 icon-color">Cuenta origen</small>
										<img class="card-image" src="<?= $this->asset->insertFile($productImg, 'images/programs', $customerUri); ?>" alt="<?= $productName; ?>">
									<?php endif; ?>
								</div>
								<?php if ($totalCards == 1 && $isVirtual) : ?>
									<span class="warning semibold h6 mx-auto"><?= lang('GEN_VIRTUAL_CARD'); ?></span>
								<?php endif; ?>
							</div>
							<?php if ($totalCards > 1) : ?>
								<div id="accountSelect" class="flex flex-column items-start self-center col-6 py-5">
									<p class="mb-2"><?= lang('GEN_SELECT_ACCOUNT'); ?></p>
								</div>
							<?php else : ?>
								<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">
									<p class="semibold mb-0 h5 truncate"><?= $productName; ?></p>
									<p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
									<a id="other-product" class="btn hyper-link btn-small p-0 hide" href="<?= lang('GEN_NO_LINK'); ?>">
										<i aria-hidden="true" class="icon-find"></i>&nbsp;<?= lang('GEN_OTHER_PRODUCTS'); ?>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<div class="flex col-12 mt-2 center">
						<ul class="flex flex-auto justify-between px-2">
							<li class="list-inline-item"><?= lang('TRANSF_AVAILABLE_BALANCE'); ?>
								<span id="currentBalance" class="product-balance block">Bs.0</span>
							</li>
							<li class="list-inline-item"><?= lang('TRANSF_TO_DEBIT_BALANCE'); ?>
								<span id="availableBalance" class="product-balance block">Bs.0</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php if (true) : ?>
			<div class="flex optional mt-4 px-0">
				<nav class="nav-config w-100">
					<ul class="flex flex-wrap justify-center nav-config-box  <?= $activePointer ?>">
						<?php if (true) : ?>
							<li id="affiliate" class="list-inline-item nav-item-config mr-1">
								<a class="px-1" href="javascript:">
									<span class="icon-config icon-user-plus h0 icon-color"></span>
									<h5 class="center"><span class="status-text1"><?= lang('TRANSF_AFILIATE'); ?></span></h5>
									<div class="px-1 box up left regular">
										<span class="icon-user-plus h1 icon-color"></span>
										<h4 class="h5 center status-text1"><span class="status-text1"><?= lang('TRANSF_AFILIATE'); ?></span></h4>
									</div>
								</a>
							</li>
						<?php endif; ?>
						<?php if (true) : ?>
							<li id="manageAffiliations" class="list-inline-item nav-item-config">
								<a class="px-1" href="javascript:">
									<span class="icon-config icon-user-config h1 icon-color"></span>
									<h5 class="center"><span class="status-text1"><?= lang('TRANSF_MANAGE_AFFILIATIONS'); ?></span></h5>
									<div class="px-1 box up left regular">
										<span class="icon-user-config h1 icon-color"></span>
										<h4 class="h5 center status-text1"><span class="status-text1"><?= lang('TRANSF_MANAGE_AFFILIATIONS'); ?></span></h4>
									</div>
								</a>
							</li>
						<?php endif; ?>
						<?php if (true) : ?>
							<li id="moneyPayments" class="list-inline-item nav-item-config mr-1">
								<a class="px-1" href="javascript:">
									<span class="icon-config icon-money-payments h0 icon-color"></span>
									<h5 class="center"><span class="status-text1"><?= lang('TRANSF_PAYMENTS'); ?></span></h5>
									<div class="px-1 box up left regular">
										<span class="icon-money-payments h1 icon-color"></span>
										<h4 class="h5 center status-text1"><span class="status-text1"><?= lang('TRANSF_PAYMENTS'); ?></span></h4>
									</div>
								</a>
							</li>
						<?php endif; ?>
						<?php if (true) : ?>
							<li id="toTransfer" class="list-inline-item nav-item-config mr-1">
								<a class="px-1" href="javascript:">
									<span class="icon-config icon-user-transfer h0 icon-color"></span>
									<h5 class="center"><span class="status-text1"><?= lang('TRANSF_TO_TRANSFER'); ?></span></h5>
									<div class="px-1 box up left regular">
										<span class="icon-user-transfer h1 icon-color"></span>
										<h4 class="h5 center status-text1"><span class="status-text1"><?= lang('TRANSF_TO_TRANSFER'); ?></span></h4>
									</div>
								</a>
							</li>
						<?php endif; ?>
						<?php if (true) : ?>
							<li id="history" class="list-inline-item nav-item-config mr-1">
								<a class="px-1" href="javascript:">
									<span class="icon-config icon-history h0 icon-color"></span>
									<h5 class="center"><span class="status-text1"><?= lang('TRANSF_HISTORY'); ?></span></h5>
									<div class="px-1 box up left regular">
										<span class="icon-history h1 icon-color"></span>
										<h4 class="h5 center status-text1"><span class="status-text1"><?= lang('TRANSF_HISTORY'); ?></span></h4>
									</div>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			</div>
		<?php endif; ?>
	</div>
	<div id="activeServices" class="col-12 col-sm-12 col-lg-12 col-xl-8 pt-3">
		<!-- Afiliattions -->
		<div id="affiliateCardView" class="option-service" style="display:none">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_ACCOUNT_REG') ?></h4>
				<div class="w-100">
					<div class="services-both max-width-1 fit-lg mx-auto fade-in">
						<span><?= lang('TRANSF_ACCOUNT_REG_CREDIT_CARD_MSG') ?> </span>
						<div class="line-text my-2"></div>
						<form id="affiliateCardForm" name="affiliateCardForm">
							<div class="row">
								<div class="form-group col-lg-4">
									<label for="bank"><?= lang('TRANSF_BANK') ?></label>
									<select id="bank" class="custom-select form-control" name="bank">
										<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
										<option value="Bank">Bank</option>
									</select>
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="CreditCardNumber"><?= lang('TRANSF_CREDIT_CARD_NUMBER') ?></label>
									<input id="CreditCardNumber" class="form-control" type="password" name="CreditCardNumber" maxlength="4" autocomplete="off">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="beneficiary"><?= lang('TRANSF_BENEFICIARY') ?></label>
									<input id="beneficiary" class="form-control" type="password" name="beneficiary" maxlength="4" autocomplete="off">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="idDocument"><?= lang('TRANSF_ID_DOCUMENT') ?></label>
									<div class="form-row">
										<div class="form-group col-6 input-height">
											<select id="phoneType" class="custom-select form-control" name="phoneType">
												<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
												<option value="Cedula">Cedula</option>
											</select>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 input-height">
											<input id="idDocument" class="form-control" type="text" name="idDocument" value="" autocomplete="off">
											<div class="help-block"></div>
										</div>
									</div>
								</div>
								<div class="form-group col-lg-4">
									<label for="email"><?= lang('GEN_EMAIL'); ?></label>
									<input id="email" class="form-control" type="email" name="email">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="expDateCta"><?= lang('TRANSF_EXP_DATE_CTA') ?></label>
									<input id="expDateCta" name="expDateCta" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_PICKER_DATEMEDIUM'); ?>">
									<div class="help-block"></div>
								</div>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link big-modal" href=""><?= lang('GEN_BTN_CANCEL') ?></a>
								<button id="toTransferBtn" class="btn btn-small btn-loading btn-primary send"><?= lang('TRANSF_AFILIATE') ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div id="affiliateAccountView" class="option-service" style="display:none">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_ACCOUNT_REG') ?></h4>
				<div class="w-100">
					<div class="services-both max-width-1 fit-lg mx-auto fade-in">
						<span><?= lang('TRANSF_ACCOUNT_REG_ACCOUNT_MSG') ?> </span>
						<div class="line-text my-2"></div>
						<form id="affiliateAccountForm" name="affiliateAccountForm">
							<div class="row">
								<div class="form-group col-lg-4 none">
									<label for="beneficiary"><?= lang('TRANSF_BENEFICIARY') ?></label>
									<input id="beneficiary" class="form-control" type="password" name="beneficiary" maxlength="4" autocomplete="off">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4 none">
									<label for="idDocument"><?= lang('TRANSF_ID_DOCUMENT') ?></label>
									<div class="form-row">
										<div class="form-group col-6 input-height">
											<select id="phoneType" class="custom-select form-control" name="phoneType">
												<option value="" selected disabled><?= lang('GEN_SELECTION') ?></option>
												<option value="Cedula">Cedula</option>
											</select>
											<div class="help-block"></div>
										</div>
										<div class="form-group col-6 input-height">
											<input id="idDocument" class="form-control" type="text" name="idDocument" value="" autocomplete="off">
											<div class="help-block"></div>
										</div>
									</div>
								</div>
								<div class="form-group col-lg-4">
									<label for="destAccountNumber"><?= lang('TRANSF_DEST_ACCOUNT_NUMBER') ?></label>
									<input id="destAccountNumber" class="form-control" type="text" name="destAccountNumber" maxlength="20" autocomplete="off">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="email"><?= lang('GEN_EMAIL'); ?></label>
									<input id="email" class="form-control" type="email" name="email">
									<div class="help-block"></div>
								</div>
								<div class="form-group col-lg-4">
									<label for="expDateCta"><?= lang('TRANSF_EXP_DATE_CTA') ?></label>
									<input id="expDateCta" name="expDateCta" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_PICKER_DATEMEDIUM'); ?>">
									<div class="help-block"></div>
								</div>
							</div>
							<hr class="separador-one">
							<div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link big-modal" href=""><?= lang('GEN_BTN_CANCEL') ?></a>
								<button id="toTransferBtn" class="btn btn-small btn-loading btn-primary send"><?= lang('TRANSF_AFILIATE') ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Adm Afiliattions -->
		<div id="manageAffiliationsView" class="option-service" style="display:none">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_MANAGE_AFFILIATIONS') ?></h4>
				<div class="w-100">
					<div class="services-both max-width-1 fit-lg mx-auto fade-in">
						<form id="manageAffiForm" name="manageAffiForm">
							<div id="cardList" class="dashboard-items flex max-width-xl-6 mx-auto flex-wrap">
								<?php foreach ($cardsList as $cards) : ?>
									<div class="dashboard-item mx-1 mb-1 mr-2 get-detail big-modal">
										<img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, 'images/programs', $customerUri); ?>" alt="<?= $cards->productName ?>" />
										<div class="item-info <?= $cards->brand; ?> p-2 h5 bg-white">
											<a href="#" target="_blank" rel="noopener noreferrer">
												<span class="card-icon icon-edit icon-color h4 bg-white"></span>
											</a>
											<span class="card-icon icon-remove icon-color h4 bg-white"></span>
											<?php if (lang('CONF_BUSINESS_NAME') == 'ON') : ?>
												<small class="sb-disabled uppercase light truncate"><?= $cards->enterprise ?></small><br>
											<?php endif; ?>
											<p class="item-category semibold truncate" title="<?= $cards->productName ?>" data-toggle="tooltip"><?= $cards->productName ?>
												<span class="warning semibold h6 capitalize absolute ml-2 l-0"><br><?= $cards->virtualCard ?></span>
											</p>
											<p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
											<p class="item-balance mb-0 h6 light text">
												<?php if ($cards->status == '') : ?>
													<?= $cards->statusMessage ?>
												<?php else : ?>
													<span class="semibold danger"><?= $cards->statusMessage ?></span>
												<?php endif; ?>
											</p>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Transfer -->
		<div id="transferView" class="option-service" style="display:none">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text mb-2 semibold primary"><?= lang('TRANSF_TO_TRANSFER') ?></h4>
				<div class="w-100">
					<div class="services-both max-width-1 fit-lg mx-auto fade-in">
						<span><?= lang('TRANSF_INDICATIONS_TRANS_MSG') ?> </span>
						<div class="line-text my-2"></div>
						<div class="flex justify-center mb-5">
							<div class="dashboard-item p-1 mx-5 mb-1 get-detail big-modal">
								<img class="item-img" src="http://personas.novopayment.lc/assets/images/programs/bg/bg_default.svg?V20210421-1619018928" alt="PLATA NOMINA M">
								<div class="item-info maestro p-2 h5 bg-white">
									<a href="http://hola.com" target="_blank" rel="noopener noreferrer">
										<span class="card-icon icon-edit icon-color h4 bg-white"></span>
									</a>
									<span class="card-icon icon-remove icon-color h4 bg-white"></span>
									<small class="sb-disabled uppercase light truncate">SERVITEBCA</small><br>
									<p class="item-category semibold truncate" title="PLATA NOMINA M" data-toggle="tooltip">PLATA NOMINA M <span class="warning semibold h6 capitalize absolute ml-2 l-0"><br></span>
									</p>
									<p class="item-cardnumber mb-0">604842******8811</p>
									<p class="item-balance mb-0 h6 light text">
									</p>
								</div>
							</div>
							<div class="col-5 self-center">
								<form id="signInForm">
									<div class="form-group">
										<label for="concept"><?= lang('TRANSF_CONCEPT') ?></label>
										<input id="concept" name="concept" class="form-control" type="text" autocomplete="off">
										<div class="help-block"></div>
									</div>
									<div class="form-group">
										<label for="amount"><?= lang('TRANSF_AMOUNT') ?></label>
										<input id="amount" name="amount" class="form-control" type="text" autocomplete="off">
										<div class="help-block"></div>
									</div>
								</form>
							</div>
						</div>
						<div class="center">
							<button class="btn btn-small btn-link back pb-0" type="submit">
								<i class="icon-plus h6"></i> <?= lang('TRANSF_ADD_DEST_ACCOUNT'); ?>
							</button>
							<br>
							<small class="text">(<?= lang('TRANSF_MAX_SIMUL'); ?>)</small>
						</div>
						<div class="mt-3">
							<span class="text">(<?= lang('TRANSF_EXP_DATE'); ?>)</span>
							<div class="form-group col-lg-4 mt-3 pl-0">
								<input id="expDateCta" name="expDateCta" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_PICKER_DATEMEDIUM'); ?>">
								<div class="help-block"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- History -->
		<div id="historyView" class="option-service" style="display:none">
			<div class="flex mb-1 mx-4 flex-column">
				<h4 class="line-text semibold primary"><?= lang('TRANSF_HISTORY') ?></h4>
				<div class="w-100">
					<div class="services-both max-width-1 fit-lg mx-auto fade-in">
						<div class="row pl-2 mt-3">
							<label class="mt-1 regular" for="initDateFilter"><?= lang('TRANSF_SHOW'); ?></label>
							<div class="form-group col-4 px-1">
								<input id="filterInputYear" name="filterInputYear" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_PICKER_DATEMEDIUM'); ?>">
								<div id='error' class="help-block"></div>
							</div>
							<div class="flex items-center">
								<button id="search" class="btn btn-small btn-rounded-right btn-primary mb-3">
									<span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
								</button>
							</div>
						</div>
						<div class="line-text my-2"></div>
						<div id="results" class="mt-1 justify-center">
							<div id="pre-loader" class="hide">
								<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
							</div>
							<ul id="movementsList" class="feed fade-in mt-3 pl-0 easyPaginateList">
								<li class="feed-item feed-expense flex py-2 items-center">
									<div class="flex px-2 flex-column items-center feed-date">
										<span class="h5">10 Jul 2021</span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product">Yhoan alfonso sulbaran ccs noroeste ve</span>
										<span class="h6 feed-metadata">119112055118</span>
									</div>
									<span class="px-2 feed-amount items-center">- $ 32.000.000,00</span>
								</li>
								<li class="feed-item feed-income flex py-2 items-center">
									<div class="flex px-2 flex-column items-center feed-date">
										<span class="h5">09 Jul 2021</span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product">Beneficio de alimentacion</span>
										<span class="h6 feed-metadata">510181</span>
									</div>
									<span class="px-2 feed-amount items-center">+ $ 29.500.000,00</span>
								</li>
								<li class="feed-item feed-expense flex py-2 items-center">
									<div class="flex px-2 flex-column items-center feed-date">
										<span class="h5">19 Jun 2021</span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product">Inversiones zacamar c. ccs noroeste ve</span>
										<span class="h6 feed-metadata">117015007660</span>
									</div>
									<span class="px-2 feed-amount items-center">- $ 2.700.000,00</span>
								</li>
								<li class="feed-item feed-expense flex py-2 items-center">
									<div class="flex px-2 flex-column items-center feed-date">
										<span class="h5">19 Jun 2021</span>
									</div>
									<div class="flex px-2 flex-column mr-auto">
										<span class="h5 semibold feed-product">Yhoan alfonso sulbaran ccs noroeste ve</span>
										<span class="h6 feed-metadata">117012054741</span>
									</div>
									<span class="px-2 feed-amount items-center">- $ 23.670.000,00</span>
								</li>

							</ul>
							<div class="easyPaginateNav" style="width: 778.433px;"><a href="#Página:1" title="Primera página" rel="1" class="first">Primera</a><a href="" title="Anterior" rel="" class="prev">&lt;</a><a href="#Página:1" title="Página 1" rel="1" class="page current">1</a><a href="#Página:2" title="Página 2" rel="2" class="page">2</a><a href="" title="Siguiente" rel="" class="next">&gt;</a><a href="#Página:2" title="Última página" rel="2" class="last">Última</a></div>
							<div id="no-moves" class="hide">
								<div class="flex flex-column items-center justify-center pt-5">
									<h3 class="h4 regular mb-0">No se encontraron registros para tu consulta</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
