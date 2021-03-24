<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CUSTOMER_SUPPORT'); ?></h1>
<div class="row">
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="flex flex-wrap">
      <div class="w-100">
        <div class="widget-product">
          <div id="productdetail" class="flex inline-flex col-12 px-xl-2">
            <div class="flex flex-column justify-center col-6 py-4">
              <div class="product-presentation relative w-100">
                <div class="item-network <?= $brand, $networkBrand ?>"></div>
                <?php if ($cardsTotal > 1): ?>
                <div id="donor" class="product-search btn">
                  <a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
                  <input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
                </div>
                <?php else: ?>
                <img class="card-image" src="<?= $this->asset->insertFile($productImg, $productUrl); ?>" alt="<?= $productName; ?>">
                <?php endif; ?>
              </div>
							<?php if ($cardsTotal == 1 && $isVirtual): ?>
              <span class="warning semibold h6 mx-auto"><?= lang('GEN_VIRTUAL_CARD'); ?></span>
							<?php endif; ?>
            </div>
            <?php if ($cardsTotal > 1): ?>
            <div id="accountSelect" class="flex flex-column items-start self-center col-6 py-5">
              <p class="mb-2"><?= lang('GEN_SELECT_ACCOUNT'); ?></p>
            </div>
            <?php else: ?>
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
      </div>
    </div>
    <?php if (!$uniqueEvent): ?>
    <div class="flex optional mt-4 px-0">
      <nav class="nav-config w-100">
        <ul class="flex flex-wrap justify-center nav-config-box <?= $activeEvents ?>">
          <?php if (in_array('110', $serviceList)): ?>
          <li id="cardLock" class="list-inline-item nav-item-config mr-1">
            <a href="javascript:">
              <span class="icon-config icon-lock h1 icon-color"></span>
              <h5 class="center"><span class="status-text1"><?= $statustext ?></span></h5>
              <div class="box up left regular">
                <span class="icon-lock h1 icon-color"></span>
                <h4 class="h5 center tatus-text1"><span class="status-text1"><?= $statustext ?></span></h4>
              </div>
            </a>
          </li>
          <?php endif; ?>
          <?php if (in_array('111', $serviceList)): ?>
          <li id="replacementRequest" class="list-inline-item nav-item-config">
            <a href="javascript:">
              <span class="icon-config icon-spinner h1 icon-color"></span>
              <h5 class="center"><?= novoLang(lang('CUST_REPLACE_REQUEST'), '<br>'); ?></h5>
              <div class="box up left regular">
                <span class="icon-spinner h1 icon-color"></span>
                <h4 class="h5 center"><?= novoLang(lang('CUST_REPLACE_REQUEST'), '<br>'); ?></h4>
              </div>
            </a>
          </li>
          <?php endif; ?>
          <?php if (count(array_diff(['112', '117', '120'], $serviceList)) < 3): ?>
          <li id="pinManagement" class="list-inline-item nav-item-config mr-1">
            <a href="javascript:">
              <span class="icon-config icon-key h1 icon-color"></span>
              <h5 class="center"><?= lang('CUST_PIN_MANAGEMENT'); ?></h5>
              <div class="box up left regular">
                <span class="icon-key h1 icon-color"></span>
                <h4 class="h5 center"><?= lang('CUST_PIN_MANAGEMENT'); ?></h4>
              </div>
            </a>
          </li>
          <?php endif; ?>
          <?php if (in_array('130', $serviceList)): ?>
          <li id="twirlsCommercial" class="list-inline-item nav-item-config send" action="twirlsCommercial">
            <a href="javascript:">
              <span class="icon-config icon icon icon-credit-card h1 icon-color"></span>
              <h5 class="center"><?= lang('CUST_TWIRLS_COMMERCIAL'); ?></h5>
              <div class="box up left regular">
                <span class="icon icon icon-credit-card h1 icon-color"></span>
                <h4 class="h5 center"><?= lang('CUST_TWIRLS_COMMERCIAL'); ?></h4>
              </div>
            </a>
          </li>
          <?php endif; ?>
          <?php if (in_array('217', $serviceList)): ?>
          <li id="transactionalLimits" class="list-inline-item nav-item-config send" action="transactionalLimits">
            <a href="javascript:">
              <span class="icon-config icon icon-transactions h1 icon-color"></span>
              <h5 class="center"><?= lang('CUST_TRANS_LIMITS'); ?></h5>
              <div class="box up left regular">
                <span class="icon icon-transactions h1 icon-color"></span>
                <h4 class="h5 center"><?= lang('CUST_TRANS_LIMITS'); ?></h4>
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
    <div id="cardLockView" class="option-service" <?= $uniqueEvent && in_array('110', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary">
          <span class="status-text1"><?= $statustext ?></span>
				</h4>
				<form id="temporaryLockForm" data-status="<?= $status ?>">
					<div id="selectTempLockReason" class="row none form-group col-lg-4">
						<label for="temporaryLockReason">Motivo de la solicitud</label>
						<select id="temporaryLockReason" class="custom-select form-control" name="temporaryLockReason">
						<option value="" selected disabled>Selecciona</option>
						<?php foreach (lang('CUST_TEMPORARY_LOCK_REASON') AS  $value): ?>
						<option value="<?= $value ?>"><?= $value ?></option>
						<?php endforeach; ?>
						</select>
						<div class="help-block"></div>
					</div>
					<div id="msgTemporaryLock" class="row mx-0">
						<p><?= novoLang(lang('CUST_ACTION_TAKE'), $statustextCard) ?></p>
					</div>
					<hr class="separador-one w-100">
					<div class="flex items-center justify-end pt-3">
						<a class="btn btn-small btn-link big-modal" href="<?= lang('GEN_LINK_CARDS_LIST') ?>">Cancelar</a>
						<button class="btn btn-small btn-loading btn-primary send" action="temporaryLock">Continuar</button>
					</div>
				</form>
      </div>
    </div>
    <div id="replacementRequestView" class="option-service" <?= $uniqueEvent && in_array('111', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary"><?= novoLang(lang('CUST_REPLACE_REQUEST'), ''); ?></h4>
        <form id="replacementForm">
          <div id="selectReplacementCard" class="row">
            <div class="form-group col-lg-4">
              <label for="replaceMotSol"><?= lang('CUST_REASON_REQUEST') ?></label>
              <select id="replaceMotSol" class="custom-select form-control" name="replaceMotSol">
                <option value="" selected disabled><?= lang('CUST_SELECTION') ?></option>
                <?php foreach (lang('CUST_REPLACE_REASON') AS $key => $value): ?>
                <option value="<?= $key ?>"><?= $value ?></option>
                <?php endforeach; ?>
              </select>
              <div class="help-block"></div>
            </div>
          </div>
					<div id="msgReplacementCard" class="row none mx-0">
						<p><?= lang ('CUST_REPLACE_CARD') ?></p>
					</div>
          <hr class="separador-one w-100">
          <div class="flex items-center justify-end pt-3">
            <a class="btn btn-small btn-link" href=""><?= lang('GEN_BTN_CANCEL') ?></a>
            <button class="btn btn-small btn-loading btn-primary send" action="replacement"><?= lang('GEN_BTN_CONTINUE') ?></button>
          </div>
        </form>
      </div>
    </div>
    <div id="pinManagementView" class="option-service"
      <?= $uniqueEvent && count(array_diff(['112', '117', '120'], $serviceList)) < 3 ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary"><?= lang('CUST_PIN_MANAGEMENT') ?></h4>
        <div class="w-100">
          <div class="services-both max-width-1 fit-lg mx-auto fade-in">
            <?php if ($uniqueEvent && count(array_diff(['112', '117', '120'], $serviceList)) < 2): ?>
            <p><?= lang('CUST_SELECTION_OPERATION') ?></p>
            <?php endif; ?>
            <form id="actionPinForm" name="actionPinForm">
              <div class="form-group">
                <label class="mr-2"><?= lang('CUST_OPERATIONS') ?></label>
                <?php if (in_array('112', $serviceList)): ?>
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="changePin" class="custom-control-input" type="radio" name="recovery" value="change" autocomplete="off">
                  <label class="custom-control-label" for="changePin"><?= lang('CUST_PIN_CHANGE') ?></label>
                </div>
                <?php endif; ?>
                <?php if (in_array('120', $serviceList)): ?>
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="generatePin" class="custom-control-input" type="radio" name="recovery" value="generate" autocomplete="off">
                  <label class="custom-control-label" for="generatePin"><?= $RecoverPinText ?></label>
                </div>
                <?php endif; ?>
                <?php if (in_array('117', $serviceList)): ?>
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="requestPin" class="custom-control-input" type="radio" name="recovery" value="request" autocomplete="off">
                  <label class="custom-control-label" for="requestPin"><?= lang('CUST_REQUEST_PIN') ?></label>
                </div>
                <?php endif; ?>
                <div class="help-block"></div>
              </div>
            </form>
            <form id="pinManagementForm" name="pinManagementForm">
              <div id="changePinInput" class="row hide">
                <div class="form-group col-lg-4">
                  <label for="currentPin"><?= lang('CUST_CURRENT_PIN') ?></label>
                  <input id="currentPin" class="form-control" type="password" name="currentPin" maxlength="4" autocomplete="off">
                  <div class="help-block"></div>
                </div>
                <div class="form-group col-lg-4">
                  <label for="newPin"><?= lang('CUST_NEW_PIN') ?></label>
                  <input id="newPin" class="form-control" type="password" name="newPin" maxlength="4" autocomplete="off">
                  <div class="help-block"></div>
                </div>
                <div class="form-group col-lg-4">
                  <label for="confirmPin"><?= lang('CUST_CONFIRM_PIN') ?></label>
                  <input id="confirmPin" class="form-control" type="password" name="confirmPin" maxlength="4" autocomplete="off">
                  <div class="help-block"></div>
                </div>
              </div>
              <div id="generatePinInput" class="row hide">
                <div class="form-group col-lg-4">
                  <label for="generateNewPin"><?= lang('CUST_NEW_PIN') ?></label>
                  <input id="generateNewPin" class="form-control" type="password" name="generateNewPin" maxlength="4" autocomplete="off">
                  <div class="help-block"></div>
                </div>
                <div class="form-group col-lg-4">
                  <label for="generateConfirmPin"><?= lang('CUST_CONFIRM_PIN') ?></label>
                  <input id="generateConfirmPin" class="form-control" type="password" name="generateConfirmPin" maxlength="4" autocomplete="off">
                  <div class="help-block"></div>
                </div>
              </div>
              <div id="requestPinInput" class="row hide ml-auto">
								<?= lang('CUST_REQUEST_PIN_INFO') ?>
              </div>
              <hr class="separador-one">
              <div class="flex items-center justify-end pt-3">
								<a class="btn btn-small btn-link big-modal" href=""><?= lang('GEN_BTN_CANCEL') ?></a>
                <button id="pinManagementBtn" class="btn btn-small btn-loading btn-primary send"><?= lang('GEN_BTN_CONTINUE') ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="twirlsCommercialView" class="option-service" <?= $uniqueEvent && in_array('130', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div id="pre-loader-twins" class="w-100 hide">
        <div class="mt-5 mb-4 pt-5 mx-auto flex justify-center block">
          <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
        </div>
      </div>
      <div class="w-100 hide-out hide">
        <div class="flex flex-auto flex-column">
          <div class="flex pb-5 px-2 flex-column">
            <div class="flex flex-column">
              <div class="flex light items-center line-text mb-5">
                <div class="flex tertiary">
                  <span class="inline h4 semibold primary"><?= lang('CUST_TWIRLS_COMMERCIAL'); ?></span>
                </div>
                <div class="flex h6 flex-auto justify-end">
                  <span id="updateDate"></span>
                </div>
              </div>
              <div class="row flex justify-between my-3">
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_CARD_NUMBER'); ?>:
                    <span id="cardnumberT" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_NAME'); ?>:
                    <span id="customerName" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_DNI'); ?>:
                    <span id="documentId" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-12 center flex justify-center items-end">
                  <span class="h6 bold mb-0 mt-2">
                    <?= lang('CUST_NOTE'); ?>:
                    <span class="light text"><?= lang('CUST_CHECK_COLOR'); ?></span>
                  </span>
                  <div class="custom-control custom-switch custom-control-inline p-0 pl-4 ml-1 mr-0">
                    <input class="custom-control-input" type="checkbox" disabled checked>
                    <label class="custom-control-label"></label>
                  </div>
                  <span class="h6 light text"><?= lang('CUST_PURCHASES_RESTRICTED'); ?></span>
                </div>
              </div>
            </div>
            <form id="twirlsCommercialForm" name="twirlsCommercialForm">
              <div class="row mx-xl-3">
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_TRAVEL_AGENCY'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="travelAgency" class="custom-control-input" type="checkbox" name="travelAgency" disabled>
                    <label class="custom-control-label" for="travelAgency"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_INSURERS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="insurers" class="custom-control-input" type="checkbox" name="insurers" disabled>
                    <label class="custom-control-label" for="insurers"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_CHARITY'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="charity" class="custom-control-input" type="checkbox" name="charity" disabled>
                    <label class="custom-control-label" for="charity"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_ENTERTAINMENT'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="entertainment" class="custom-control-input" type="checkbox" name="entertainment" disabled>
                    <label class="custom-control-label" for="entertainment"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_PARKING'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="parking" class="custom-control-input" type="checkbox" name="parking" disabled>
                    <label class="custom-control-label" for="parking"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_GASTATIONS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="gaStations" class="custom-control-input" type="checkbox" name="gaStations" disabled>
                    <label class="custom-control-label" for="gaStations"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_GOVERNMENTS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="governments" class="custom-control-input" type="checkbox" name="governments" disabled>
                    <label class="custom-control-label" for="governments"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_HOSPITALS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="hospitals" class="custom-control-input" type="checkbox" name="hospitals" disabled>
                    <label class="custom-control-label" for="hospitals"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_HOTELS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="hotels" class="custom-control-input" type="checkbox" name="hotels" disabled>
                    <label class="custom-control-label" for="hotels"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_DEBIT'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="debit" class="custom-control-input" type="checkbox" name="debit" disabled>
                    <label class="custom-control-label" for="debit"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_TOLL'); ?>s</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="toll" class="custom-control-input" type="checkbox" name="toll" disabled>
                    <label class="custom-control-label" for="toll"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_RESTAURANTS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="restaurants" class="custom-control-input" type="checkbox" name="restaurants" disabled>
                    <label class="custom-control-label" for="restaurants"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_SUPERMARKETS'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="supermarkets" class="custom-control-input" type="checkbox" name="supermarkets" disabled>
                    <label class="custom-control-label" for="supermarkets"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_TELECOMMUNICATION'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="telecommunication" class="custom-control-input" type="checkbox" name="telecommunication" disabled>
                    <label class="custom-control-label" for="telecommunication"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_AIR_TRANSPORT'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="airTransport" class="custom-control-input" type="checkbox" name="airTransport" disabled>
                    <label class="custom-control-label" for="airTransport"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_COLLEGES_UNIVERSITIES'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="collegesUniversities" class="custom-control-input" type="checkbox" name="collegesUniversities" disabled>
                    <label class="custom-control-label" for="collegesUniversities"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_RETAIL_SALES'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="retailSales" class="custom-control-input" type="checkbox" name="retailSales" disabled>
                    <label class="custom-control-label" for="retailSales"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block"><?= lang('CUST_PASSENGER_TRANSPORTATION'); ?></label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="passengerTransportation" class="custom-control-input" type="checkbox" name="passengerTransportation" disabled>
                    <label class="custom-control-label" for="passengerTransportation"></label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="transactionalLimitsView" class="option-service" <?= $uniqueEvent && in_array('217', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div id="pre-loader-limit" class="w-100 hide">
        <div class="mt-5 mb-4 pt-5 mx-auto flex justify-center">
          <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
        </div>
      </div>
      <div class="w-100 hide-out hide">
        <div class="flex flex-auto flex-column">
          <div class="flex pb-5 px-2 flex-column">
            <div class="flex flex-column">
              <div class="flex light items-center line-text mb-5">
                <div class="flex tertiary">
                  <span class="inline h4 semibold primary"><?= lang('CUST_TRANS_LIMITS'); ?></span>
                </div>
                <div class="flex h6 flex-auto justify-end">
                  <span id="updateDateL"></span>
                </div>
              </div>
              <div class="row flex justify-between my-3">
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_CARD_NUMBER'); ?>:
                    <span id="cardnumberL" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_NAME'); ?>:
                    <span id="customerNameL" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_DNI'); ?>:
                    <span id="documentIdL" class="light text"></span>
                  </p>
                </div>
                <div class="form-group col-12 center">
									<p class="h6 bold mb-0 mt-2"><?= lang('CUST_NOTE'); ?>:
										<span class="light text"><?= lang('CUST_CONFIG_PRODUCT_LIMIT'); ?></span>
									</p>
                </div>
              </div>
            </div>
            <form id="transactionalLimitsForm" name="transactionalLimitsForm">
              <div class="flex mb-5 flex-column">
                <span class="line-text slide-slow flex mb-2 h4 semibold primary"><?= lang('CUST_WITH_CARD_PRESENT'); ?>
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 block mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="numberDayPurchasesCtp"><?= lang('CUST_NUM_DAY_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberDayPurchasesCtp" class="money form-control pwd-input text-left" value="" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberWeeklyPurchasesCtp"><?= lang('CUST_NUM_WKLY_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberWeeklyPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberMonthlyPurchasesCtp"><?= lang('CUST_NUM_MON_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberMonthlyPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyPurchaseamountCtp"><?= lang('CUST_DAY_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="dailyPurchaseamountCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountPurchasesCtp"><?= lang('CUST_WKLY_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="weeklyAmountPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyPurchasesAmountCtp"><?= lang('CUST_MON_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="monthlyPurchasesAmountCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="purchaseTransactionCtp"><?= lang('CUST_SHOPPING_TXN_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="purchaseTransactionCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex mb-5 flex-column">
                <span class="line-text slide-slow flex mb-2 h4 semibold primary"><?= lang('CUST_NO_CARD_PRESENT'); ?>
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="numberDayPurchasesStp"><?= lang('CUST_NUM_DAY_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberDayPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberWeeklyPurchasesStp"><?= lang('CUST_NUM_WKLY_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberWeeklyPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberMonthlyPurchasesStp"><?= lang('CUST_NUM_MON_PURCHASES'); ?></label>
                            <div class="input-group">
                              <input id="numberMonthlyPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyPurchaseamountStp"><?= lang('CUST_DAY_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="dailyPurchaseamountStp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountPurchasesStp"><?= lang('CUST_WKLY_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="weeklyAmountPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyPurchasesAmountStp"><?= lang('CUST_MON_PURCHASE_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="monthlyPurchasesAmountStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="purchaseTransactionStp"><?= lang('CUST_SHOPPING_TXN_AMOUNT'); ?></label>
                            <div class="input-group">
                              <input id="purchaseTransactionStp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="flex mb-5 flex-column ">
                <span class="line-text slide-slow flex mb-2 h4 semibold primary"><?= lang('CUST_WITHDRAWAL'); ?>
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <form id="">
                    <div class="container">
                      <div class="row">
                        <div class="col-12 mx-auto">
                          <div class="row">
                            <div class="form-group col-12 col-lg-4">
                              <label class="pr-3" for="dailyNumberWithdraw"><?= lang('CUST_DAY_NUM_WITHDRAWAL'); ?></label>
                              <div class="input-group">
                                <input id="dailyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="weeklyNumberWithdraw"><?= lang('CUST_WKLY_NUM_WITHDRAWAL'); ?></label>
                              <div class="input-group">
                                <input id="weeklyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="monthlyNumberWithdraw"><?= lang('CUST_MON_NUM_WITHDRAWAL'); ?></label>
                              <div class="input-group">
                                <input id="monthlyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label class="pr-3" for="dailyAmountWithdraw"><?= lang('CUST_DAY_AMOUNT_WITHDRAWAL'); ?></label>
                              <div class="input-group">
                                <input id="dailyAmountWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="weeklyAmountWithdraw"><?= lang('CUST_WKLY_AMOUNT_WITHDRAWAL'); ?></label>
                              <div clxs="input-group">
                                <input id="weeklyAmountWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="monthlyAmountwithdraw"><?= lang('CUST_MON_AMOUNT_WITHDRAWAL'); ?></label>
                              <div class="input-group">
                                <input id="monthlyAmountwithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="WithdrawTransaction"><?= lang('CUST_AMOUNT_WITHDRAWAL_TXN'); ?></label>
                              <div class="input-group">
                                <input id="WithdrawTransaction" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
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
                <span class="line-text slide-slow flex mb-2 h4 semibold primary"><?= lang('CUST_CREDIT'); ?>
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyNumberCredit"><?= lang('CUST_DAY_NUM_CREDIT'); ?></label>
                            <div class="input-group">
                              <input id="dailyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyNumberCredit"><?= lang('CUST_WKLY_NUM_CREDIT'); ?></label>
                            <div class="input-group">
                              <input id="weeklyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyNumberCredit"><?= lang('CUST_MON_NUM_CREDIT'); ?></label>
                            <div class="input-group">
                              <input id="monthlyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyAmountCredit"><?= lang('CUST_DAY_AMOUNT_CREDIT'); ?></label>
                            <div class="input-group">
                              <input id="dailyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountCredit"><?= lang('CUST_WKLY_AMOUNT_CREDIT'); ?></label>
                            <div clxs="input-group">
                              <input id="weeklyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyAmountCredit"><?= lang('CUST_MON_AMOUNT_CREDIT'); ?></label>
                            <div class="input-group">
                              <input id="monthlyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="CreditTransaction"><?= lang('CUST_AMOUNT_CREDIT_TXN'); ?></label>
                            <div class="input-group">
                              <input id="CreditTransaction" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
