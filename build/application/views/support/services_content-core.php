<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_CUSTOMER_SUPPORT'); ?></h1>
<div class="pt-3 row">
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="flex flex-wrap">
      <div class="w-100">
        <div class="widget-product">
          <div id="productdetail" class="flex inline-flex col-12 px-xl-2">
            <div class="flex flex-colunm justify-center col-6 py-5">
              <div class="product-presentation relative">
                <div class="item-network <?= $brand; ?>"></div>
                <?php if ($cardsTotal > 1): ?>
                <div id="donor" class="product-search btn">
                  <a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
                  <input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
                </div>
                <?php else: ?>
                <img class="card-image" src="<?= $this->asset->insertFile($productImg, $productUrl); ?>" alt="<?= $productName; ?>">
                <?php endif; ?>
              </div>
            </div>
            <?php if ($cardsTotal > 1): ?>
            <div id="accountSelect" class="flex flex-column items-start self-center col-6 py-5">
              <p class="mb-2">Seleccione una cuenta</p>
            </div>
            <?php else: ?>
            <div class="flex flex-column items-start col-6 self-center pr-0 pl-1">
              <p class="semibold mb-0 h5 truncate"><?= $productName; ?></p>
              <p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
              <a id="other-product" class="btn hyper-link btn-small p-0 hide" href="<?= lang('GEN_NO_LINK'); ?>">
                <i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto
              </a>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php if (!$uniqueEvent): ?>
        <div class="flex col-12 optional mt-4 px-0">
          <nav class="nav-config w-100">
            <ul class="flex flex-wrap justify-center nav-config-box <?= $activeEvents ?>">
              <?php if (in_array('110', $serviceList)): ?>
              <li id="cardLock" class="list-inline-item nav-item-config mr-1">
                <a href="javascript:">
                  <span class="icon-config icon-lock h1 icon-color"></span>
                  <h5 class="center"><span class="status-text1"><?= $statustext ?></span><br>de tarjeta</h5>
                  <div class="box up left regular">
                    <span class="icon-lock h1 icon-color"></span>
                    <h4 class="h5 centers tatus-text1"><span class="status-text1"><?= $statustext ?></span><br>de tarjeta</h4>
                  </div>
                </a>
              </li>
              <?php endif; ?>
              <?php if (in_array('111', $serviceList)): ?>
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
              <?php endif; ?>
              <?php if (count(array_diff(['112', '117', '120'], $serviceList)) < 3): ?>
              <li id="pinManagement" class="list-inline-item nav-item-config mr-1">
                <a href="javascript:">
                  <span class="icon-config icon-key h1 icon-color"></span>
                  <h5 class="center">Gestión<br>de PIN</h5>
                  <div class="box up left regular">
                    <span class="icon-key h1 icon-color"></span>
                    <h4 class="h5 center">Gestión<br>de PIN</h4>
                  </div>
                </a>
              </li>
              <?php endif; ?>
              <?php if (in_array('130', $serviceList)): ?>
              <li id="twirlsCommercial" class="list-inline-item nav-item-config send" action="twirlsCommercial">
                <a href="javascript:">
                  <span class="icon-config icon icon icon-credit-card h1 icon-color"></span>
                  <h5 class="center">Giros<br>comerciales</h5>
                  <div class="box up left regular">
                    <span class="icon icon icon-credit-card h1 icon-color"></span>
                    <h4 class="h5 center">Giros<br>comerciales</h4>
                  </div>
                </a>
              </li>
              <?php endif; ?>
              <?php if (in_array('217', $serviceList)): ?>
              <li id="transactionalLimits" class="list-inline-item nav-item-config send" action="transactionalLimits">
                <a href="javascript:">
                  <span class="icon-config icon icon-transactions h1 icon-color"></span>
                  <h5 class="center">Limites<br>transaccionales</h5>
                  <div class="box up left regular">
                    <span class="icon icon-transactions h1 icon-color"></span>
                    <h4 class="h5 center">Limites<br>transaccionales</h4>
                  </div>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </nav>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div id="activeServices" class="col-12 col-sm-12 col-lg-12 col-xl-8 pt-3">
    <div id="cardLockView" class="option-service" <?= $uniqueEvent && in_array('110', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary">
          <span class="status-text1"><?= $statustext ?></span> tarjeta
        </h4>
        <p>
          Si realmente deseas <span class="status-text2"><?= mb_strtolower($statustext) ?></span> tu tarjeta, presiona continuar
        </p>
        <hr class="separador-one">
        <div class="flex items-center justify-end pt-3">
          <a class="btn btn-small btn-link big-modal" href="<?= lang('GEN_LINK_CARDS_LIST') ?>">Cancelar</a>
          <button class="btn btn-small btn-loading btn-primary send" action="TemporaryLock">Continuar</button>
        </div>
      </div>
    </div>
    <div id="replacementRequestView" class="option-service" <?= $uniqueEvent && in_array('111', $serviceList) ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary">Solicitud de reposición</h4>
        <p>Seleccione una motivo de la solicitud</p>
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
        <hr class="separador-one">
        <div class="flex items-center justify-end pt-3">
          <a class="btn btn-small btn-link" href="">Cancelar</a>
          <button class="btn btn-small btn-loading btn-primary send" action="replacement">Continuar</button>
        </div>
      </div>
    </div>
    <div id="pinManagementView" class="option-service"
      <?= $uniqueEvent && count(array_diff(['112', '117', '120'], $serviceList)) < 3 ? '' : 'style="display:none"'; ?>>
      <div class="flex mb-1 mx-4 flex-column">
        <h4 class="line-text mb-2 semibold primary">Gestión de PIN</h4>
        <div class="w-100">
          <div class="services-both max-width-1 fit-lg mx-auto fade-in">
            <?php if ($uniqueEvent && count(array_diff(['112', '117', '120'], $serviceList)) < 2): ?>
            <p>Seleccione los la operación que desea realizar:</p>
            <?php endif; ?>
            <form id="actionPinForm" name="actionPinForm">
              <div class="form-group">
                <label class="mr-2">Operación:</label>
                <?php if (in_array('112', $serviceList)): ?>
                <div class="custom-control custom-radio custom-control-inline">
                  <input id="changePin" class="custom-control-input" type="radio" name="recovery" value="change" autocomplete="off">
                  <label class="custom-control-label" for="changePin">Cambiar PIN</label>
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
                  <label class="custom-control-label" for="requestPin">Solicitud de PIN</label>
                </div>
                <?php endif; ?>
                <div class="help-block"></div>
              </div>
            </form>
            <form id="PinManagementForm" name="PinManagementForm">
              <div id="changePinInput" class="row hide">
                <div class="form-group col-lg-4">
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
                  <label for="confirmPin">Confirmar PIN</label>
                  <input id="confirmPin" class="form-control" type="password" name="confirmPin" autocomplete="off">
                  <div class="help-block"></div>
                </div>
              </div>
              <div id="generatePinInput" class="row hide">
                <div class="form-group col-lg-4">
                  <label for="generateNewPin">Nuevo PIN</label>
                  <input id="generateNewPin" class="form-control" type="password" name="generateNewPin" autocomplete="off">
                  <div class="help-block"></div>
                </div>
                <div class="form-group col-lg-4">
                  <label for="generateConfirmPin">Confirmar PIN</label>
                  <input id="generateConfirmPin" class="form-control" type="password" name="generateConfirmPin" autocomplete="off">
                  <div class="help-block"></div>
                </div>
              </div>
              <div id="requestPinInput" class="row hide">
                <hr class="separador-one mb-3">
                <p>Esta solicitud genera un Lote de reposición que es indispensable que tu empresa autorice en
                  Conexión Empresas Online, para poder
                  emitir el nuevo PIN.</p>
                <p>Si realmente deseas solicitar la reposición de tu PIN, presiona continuar. El PIN será enviado en
                  un máximo de 5 días hábiles en
                  un sobre de seguridad a la dirección de tu empresa.</p>
              </div>
              <hr class="separador-one">
              <div class="flex items-center justify-end pt-3">
                <a class="btn btn-small btn-link" href="<?= lang('GEN_NO_LINK'); ?>">Cancelar</a>
                <button id="PinManagementBtn" class="btn btn-small btn-loading btn-primary send">Continuar</button>
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
                    <span id="cardnumberT" class="light text"></span></p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_NAME'); ?>:
                    <span id="customerName" class="light text"></span></p>
                </div>
                <div class="form-group col-4 center">
                  <p class="h5 semibold tertiary"><?= lang('CUST_DNI'); ?>:
                    <span id="documentId" class="light text"></span></p>
                </div>
                <div class="form-group col-12 center flex justify-center items-end">
                  <span class="h6 bold mb-0 mt-2">
                    Nota:
                    <span class="light text">Si el check se encuentra en color</span>
                  </span>
                  <div class="custom-control custom-switch custom-control-inline p-0 pl-4 ml-1 mr-0">
                    <input class="custom-control-input" type="checkbox" disabled checked>
                    <label class="custom-control-label"></label>
                  </div>
                  <span class="h6 light text">la opción esta activa.</span>
                </div>
              </div>
            </div>
            <form id="twirlsCommercialForm" name="twirlsCommercialForm">
              <div class="row mx-xl-3">
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Agencia de viajes</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="travelAgency" class="custom-control-input" type="checkbox" name="travelAgency" disabled>
                    <label class="custom-control-label" for="travelAgency"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Aseguradoras</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="insurers" class="custom-control-input" type="checkbox" name="insurers" disabled>
                    <label class="custom-control-label" for="insurers"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Beneficiencia</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="charity" class="custom-control-input" type="checkbox" name="charity" disabled>
                    <label class="custom-control-label" for="charity"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Entretenimiento</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="entertainment" class="custom-control-input" type="checkbox" name="entertainment" disabled>
                    <label class="custom-control-label" for="entertainment"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Estacionamientos</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="parking" class="custom-control-input" type="checkbox" name="parking" disabled>
                    <label class="custom-control-label" for="parking"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Gasolineras</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="gaStations" class="custom-control-input" type="checkbox" name="gaStations" disabled>
                    <label class="custom-control-label" for="gaStations"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Gobiernos</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="governments" class="custom-control-input" type="checkbox" name="governments" disabled>
                    <label class="custom-control-label" for="governments"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Hospitales</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="hospitals" class="custom-control-input" type="checkbox" name="hospitals" disabled>
                    <label class="custom-control-label" for="hospitals"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Hoteles</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="hotels" class="custom-control-input" type="checkbox" name="hotels" disabled>
                    <label class="custom-control-label" for="hotels"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Peaje</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="debit" class="custom-control-input" type="checkbox" name="debit" disabled>
                    <label class="custom-control-label" for="debit"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Renta de autos</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="toll" class="custom-control-input" type="checkbox" name="toll" disabled>
                    <label class="custom-control-label" for="toll"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Restaurantes</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="restaurants" class="custom-control-input" type="checkbox" name="restaurants" disabled>
                    <label class="custom-control-label" for="restaurants"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Supermercados</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="supermarkets" class="custom-control-input" type="checkbox" name="supermarkets" disabled>
                    <label class="custom-control-label" for="supermarkets"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Telecomunicaciones</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="telecommunication" class="custom-control-input" type="checkbox" name="telecommunication" disabled>
                    <label class="custom-control-label" for="telecommunication"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Transporte aéreo</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="airTransport" class="custom-control-input" type="checkbox" name="airTransport" disabled>
                    <label class="custom-control-label" for="airTransport"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Colegios y universidades</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="collegesUniversities" class="custom-control-input" type="checkbox" name="collegesUniversities" disabled>
                    <label class="custom-control-label" for="collegesUniversities"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Ventas al detalle (retail)</label>
                  <div class="custom-control custom-switch custom-control-inline">
                    <input id="retailSales" class="custom-control-input" type="checkbox" name="retailSales" disabled>
                    <label class="custom-control-label" for="retailSales"></label>
                  </div>
                </div>
                <div id="checked-form" class="form-group col-4 col-lg-4 col-xl-3 pb-3">
                  <label class="block">Transporte terrestre de pasajeros</label>
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
                  <p class="h6 bold mb-0 mt-2">Nota: <span class="light text">Si el campo es igual a 0, se tomara
                      como limite el valor configurado para el producto.</span></p>
                </div>
              </div>
            </div>
            <form id="transactionalLimitsForm" name="transactionalLimitsForm">
              <div class="flex mb-5 flex-column">
                <span class="line-text slide-slow flex mb-2 h4 semibold primary">Con tarjeta presente
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 block mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="numberDayPurchasesCtp">Número de compras diarias</label>
                            <div class="input-group">
                              <input id="numberDayPurchasesCtp" class="money form-control pwd-input text-left" value="" type="text"
                                autocomplete="off" name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberWeeklyPurchasesCtp">Número de compras semanales</label>
                            <div class="input-group">
                              <input id="numberWeeklyPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberMonthlyPurchasesCtp">Número de compras mensuales</label>
                            <div class="input-group">
                              <input id="numberMonthlyPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyPurchaseamountCtp">Monto diario de compras</label>
                            <div class="input-group">
                              <input id="dailyPurchaseamountCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountPurchasesCtp">Monto semanal de compras</label>
                            <div class="input-group">
                              <input id="weeklyAmountPurchasesCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyPurchasesAmountCtp">Monto mensual de compras</label>
                            <div class="input-group">
                              <input id="monthlyPurchasesAmountCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="purchaseTransactionCtp">Monto por transacción de compras</label>
                            <div class="input-group">
                              <input id="purchaseTransactionCtp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
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
                <span class="line-text slide-slow flex mb-2 h4 semibold primary">Sin tarjeta presente
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="numberDayPurchasesStp">Número de compras diarias</label>
                            <div class="input-group">
                              <input id="numberDayPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberWeeklyPurchasesStp">Número de compras semanales</label>
                            <div class="input-group">
                              <input id="numberWeeklyPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="numberMonthlyPurchasesStp">Número de compras mensuales</label>
                            <div class="input-group">
                              <input id="numberMonthlyPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyPurchaseamountStp">Monto diario de compras</label>
                            <div class="input-group">
                              <input id="dailyPurchaseamountStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountPurchasesStp">Monto semanal de compras</label>
                            <div class="input-group">
                              <input id="weeklyAmountPurchasesStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyPurchasesAmountStp">Monto mensual de compras</label>
                            <div class="input-group">
                              <input id="monthlyPurchasesAmountStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="purchaseTransactionStp">Monto por transacción de compras</label>
                            <div class="input-group">
                              <input id="purchaseTransactionStp" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                name="" readonly>
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
                <span class="line-text slide-slow flex mb-2 h4 semibold primary">Retiros
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <form id="">
                    <div class="container">
                      <div class="row">
                        <div class="col-12 mx-auto">
                          <div class="row">
                            <div class="form-group col-12 col-lg-4">
                              <label class="pr-3" for="dailyNumberWithdraw">Número diario de retiros</label>
                              <div class="input-group">
                                <input id="dailyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="weeklyNumberWithdraw">Número semanal de retiros</label>
                              <div class="input-group">
                                <input id="weeklyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="monthlyNumberWithdraw">Número mensual de retiros</label>
                              <div class="input-group">
                                <input id="monthlyNumberWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label class="pr-3" for="dailyAmountWithdraw">Monto diario de retiros</label>
                              <div class="input-group">
                                <input id="dailyAmountWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                  readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="weeklyAmountWithdraw">Monto semanal de retiros</label>
                              <div clxs="input-group">
                                <input id="weeklyAmountWithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="monthlyAmountwithdraw">Monto mensual de retiros</label>
                              <div class="input-group">
                                <input id="monthlyAmountwithdraw" class="money form-control pwd-input text-left" type="text" autocomplete="off"
                                  name="" readonly>
                              </div>
                              <div class="help-block"></div>
                            </div>
                            <div class="form-group col-12 col-lg-4">
                              <label for="WithdrawTransaction">Monto por transacción de retiros</label>
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
                <span class="line-text slide-slow flex mb-2 h4 semibold primary">Abonos
                  <i class="flex mr-1 pl-2 icon icon-chevron-down flex-auto" aria-hidden="true"></i>
                </span>
                <div class="section my-2 px-2">
                  <div class="container">
                    <div class="row">
                      <div class="col-12 mx-auto">
                        <div class="row">
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyNumberCredit">Número diario de abonos</label>
                            <div class="input-group">
                              <input id="dailyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyNumberCredit">Número semanal de abonos</label>
                            <div class="input-group">
                              <input id="weeklyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyNumberCredit">Número mensual de abonos</label>
                            <div class="input-group">
                              <input id="monthlyNumberCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label class="pr-3" for="dailyAmountCredit">Monto diario de abonos</label>
                            <div class="input-group">
                              <input id="dailyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="weeklyAmountCredit">Monto semanal de abonos</label>
                            <div clxs="input-group">
                              <input id="weeklyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="monthlyAmountCredit">Monto mensual de abonos</label>
                            <div class="input-group">
                              <input id="monthlyAmountCredit" class="money form-control pwd-input text-left" type="text" autocomplete="off" name=""
                                readonly>
                            </div>
                            <div class="help-block"></div>
                          </div>
                          <div class="form-group col-12 col-lg-4">
                            <label for="CreditTransaction">Monto por transacción de abonos</label>
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
<form id="operation">
  <input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber; ?>">
  <input type="hidden" id="cardNumberMask" name="cardNumberMask" value="<?= $cardNumberMask; ?>">
  <input type="hidden" id="expireDate" name="expireDate" value="<?= $expireDate; ?>">
  <input type="hidden" id="prefix" name="prefix" value="<?= $prefix; ?>">
  <input type="hidden" id="status" name="status" value="<?= $status; ?>">
  <input type="hidden" id="action" name="action" value="">
</form>
<?php if ($cardsTotal > 1): ?>
<section id="cardList" class="hide">
  <h4 class="h4"><?= lang('GEN_ACCOUNT_SELECTION') ?></h4>
  <div id="cardsDetail" class="dashboard-items flex mt-3 mx-auto flex-wrap">
    <?php foreach ($cardsList AS $cards): ?>
    <div class="dashboard-item p-1 mx-1 mb-1">
      <img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, $cards->productUrl); ?>" alt="<?= $cards->productName ?>">
      <div class="item-info <?= $cards->brand; ?> p-2 h5 bg-white">
        <p class="item-category semibold"><?= $cards->productName ?></p>
        <p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
      </div>
      <form name="cardsListForm">
        <input type="hidden" name="cardNumber" class="hidden" value="<?= $cards->cardNumber; ?>">
        <input type="hidden" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask; ?>">
        <input type="hidden" name="expireDate" class="hidden" value="<?= $cards->expireDate; ?>">
        <input type="hidden" name="prefix" class="hidden" value="<?= $cards->prefix; ?>">
        <input type="hidden" name="status" class="hidden" value="<?= $cards->status; ?>">
        <input type="hidden" name="brand" class="hidden" value="<?= $cards->brand; ?>">
        <input type="hidden" name="services" class="hidden" value="<?= htmlspecialchars(json_encode($cards->services), ENT_QUOTES, 'UTF-8'); ?>">
      </form>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
