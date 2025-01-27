<form method="post">
  <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<form method="post" action='<?= base_url('detalle/download'); ?>'>
  <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
  <input type='hidden' name='frmMonth' value=''>
  <input type='hidden' name='frmYear' value=''>
  <input type='hidden' name='frmTypeFile' value=''>
  <input type='hidden' name='frmNoTarjeta' value=''>
  <input type='hidden' name='frmTotalProducts' value=''>
</form>

<div id="detail" class="detail-content h-100 bg-content">
  <div class="py-4 px-5">
    <header class="">
      <h1 class="h3 semibold primary">Detalle de cuenta</h1>
    </header>
    <section>
      <div class="pt-3">
        <div class="flex max-width-4 flex-wrap items-start justify-between mb-2">
          <div class="product-presentation flex flex-column items-end mr-4">
            <div class="relative">
              <div class="item-network <?php lang('SETT_FRANCHISE_LOGO') === 'ON' ? strtolower($data['marca']) : '' ?>"></div>
              <img class="card-image" src="<?= $this->asset->insertFile($data['nameImage'], 'images', 'bdb', 'programs'); ?>" alt="Tarjeta gris">
            </div>
            <div class="flex">
              <?php if ($data['totalProducts'] > 1) : ?>
                <a id="other-product" class="flex items-baseline btn btn-link btn-small p-0 mr-1" href="<?= base_url('vistaconsolidada') ?>">
                  <i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto
                </a>
                <?= ($data['vc']) ? '<span class="primary mr-1">|</span>' : ''; ?>
              <?php endif; ?>
              <?php if ($data['vc']) : ?>
                <button id="open-card-details" class="flex items-baseline btn btn-link btn-small p-0">
                  <i aria-hidden="true" class="icon-view"></i>
                  &nbsp;Ver detalles
                </button>
              <?php endif; ?>
            </div>
          </div>
          <div class="product-info-full mr-5">
            <p class="product-cardholder mb-1 semibold h4 primary truncate"><?= $data['nom_plastico']; ?></p>
            <?php if ($data['bloqueo'] !== '') : ?>
              <p class="mb-1 semibold danger"><?= lang('GEN_TEXT_BLOCK_PRODUCT'); ?></p>
            <?php endif; ?>
            <p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara']; ?></p>
            <p class="product-metadata mb-2 h6"><?= $data['nombre_producto']; ?></p>
            <ul class="product-balance-group flex justify-between mb-0 list-inline">
              <li class="list-inline-item">Actual
                <span id="actual" class="product-balance block primary">
                  <?= lang('GEN_COIN') . ' '; ?>
                  <?= $data['actualBalance'] !== '--' ?
                    strval(number_format($data['actualBalance'], 2, ',', '.')) : '---'; ?>
                </span>
              </li>
              <li class="list-inline-item">En tránsito
                <span id="bloqueado" class="product-balance block primary">
                  <?= lang('GEN_COIN') . ' '; ?>
                  <?= $data['ledgerBalance'] !== '--' ?
                    strval(number_format($data['ledgerBalance'], 2, ',', '.')) : '---'; ?>
                </span>
              </li>
              <li class="list-inline-item">Disponible
                <span id="disponible" class="product-balance block primary">
                  <?= lang('GEN_COIN') . ' '; ?>
                  <?= $data['availableBalance'] !== '--' ?
                    strval(number_format($data['availableBalance'], 2, ',', '.')) : '---'; ?>
                </span>
              </li>
            </ul>
          </div>
          <div class="product-specifications none">
            <h3 class="h4 regular tertiary">Especificaciones</h3>
            <ul class="vinieta">
              <li>Aliquam tincidunt mauris eu risus.</li>
              <li>Vestibulum auctor dapibus neque.</li>
              <li>Nunc dignissim risus id metus.</li>
              <li>Cras ornare tristique elit.</li>
              <li>Ut aliquam sollicitudin leo.</li>
              <li>Cras iaculis ultricies nulla.</li>
            </ul>
          </div>
        </div>

        <h2 class="h4 regular tertiary">Mis movimientos</h2>
        <nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
          <div id="month-period-form" class="stack-form mr-auto flex items-center">
            <input type="hidden" id="filterMonth" name="filterMonth" value="0">
            <input type="hidden" id="filterYear" name="filterYear" value="0">
            <div class="form-group">
              <label class="block">Recientes</label>
              <div class="custom-control custom-radio custom-control-inline align-top">
                <input id="filterInputMonth" type="radio" name="filterInputMonth" class="custom-control-input" value="0">
                <label class="custom-control-label mr-1" for="filterInputMonth">Últimos 20</label>
              </div>
            </div>
            <div class="form-group ml-5">
              <label class="block">Mensual</label>
              <div class="row pl-2">
                <div id="period-form" class="stack-form mr-auto flex items-center">
                  <div class="form-inline">
                    <label class="nowrap mb-0 text regular" for="filterInputYear">Seleccionar</label>
                    <input id="filterInputYear" class="form-control" type="text" name="filterInputYear" placeholder="MM/AAAA">
                    <button id="search" class="btn btn-small btn-primary">
                      <span aria-hidden="true" class="icon-arrow-right mr-0"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
            <label id="movementsToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
              <input id="optionMovements" type="radio" name="movimientos" checked> Movimientos
            </label>
            <label id="transitToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled">
              <input id="optionTransit" type="radio" name="movimientos" disabled> En tránsito
            </label>
          </div>
          <ul class="stack list-inline mb-0 flex items-stretch">
            <li class="stack-item list-inline-item rounded">
              <a id="downloadPDF" class="block px-1" href="#" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
            </li>
            <li class="stack-item list-inline-item rounded">
              <a id="downloadXLS" class="block px-1" href="#" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
            </li>
            <li class="stack-item stack-item-primary list-inline-item rounded">
              <a id="downloadExtract" class="block px-1" href="#" title="Descarga tu extracto" rel="subsection">Descarga tu extracto</a>
            </li>
          </ul>
        </nav>

        <div id="results" class="group row mt-3">
          <div id="transactions" class="group-main-view col-lg-8">
            <h3 class="h4 regular">Actividad <span id="period">reciente</span>
              <span id="transitTitle" class="none">transacciones pendientes</span>
            </h3>
            <div class="line mt-1"></div>
            <ul id="movementsList" class="feed list-style-none fade-in mt-3 pl-0">
              <?php
              $totalIncomeMovements = $data['totalInMovements']["totalIncome"];
              $totalExpenseMovements = $data['totalInMovements']["totalExpense"];

              if ($data['movements'] !== '--') {
                foreach ($data['movements'] as $row) {
                  $separedDate = explode('/', $row->fecha);
                  $spanishMonth = substr($months[intval($separedDate[1]) - 1], 0, 3);
              ?>
                  <li class="feed-item <?= $row->signo == '+' ? 'feed-income' : 'feed-expense'; ?> flex py-1 items-center">
                    <div class="flex px-2 flex-column items-center feed-date">
                      <span class="h5 feed-date-day"><?= $separedDate[0]; ?></span>
                      <span class="h6 feed-date-month"><?= $spanishMonth; ?></span>
                      <span class="h6 feed-date-year"><?= $separedDate[2]; ?></span>
                    </div>
                    <div class="flex px-2 flex-column mr-auto">
                      <span class="h5 semibold feed-product"><?= $row->concepto; ?></span>
                      <span class="h6 feed-metadata"><?= $row->referencia; ?></span>
                    </div>
                    <span class="px-2 feed-amount items-center">
                      <?= ($row->signo == '+' ? '' : $row->signo) . ' ' . lang('GEN_COIN') . ' ' . $row->monto; ?>
                    </span>
                  </li>
                <?php
                }
              } else {
                ?>
                <div class="my-5 py-4 center">
                  <span class="h4"><?= lang('RESP_EMPTY_TRANSACTIONHISTORY_PRODUCTS'); ?></span>
                </div>
              <?php
              }
              ?>
            </ul>
            <?php
            if (array_key_exists('pendingTransactions', $data)) {
              $totalIncomePendingTransactions = $data['totalInPendingTransactions']["totalIncome"];
              $totalExpensePendingTransactions = $data['totalInPendingTransactions']["totalExpense"];
            ?>
              <ul id="transitList" class="feed list-style-none mt-3 pl-0">
                <?php
                foreach ($data['pendingTransactions'] as $row) {
                  $separedDate = explode('/', $row->fecha);
                  $spanishMonth = substr($months[intval($separedDate[1]) - 1], 0, 3);
                ?>
                  <li class="feed-item <?= $row->signo == '+' ? 'feed-income' : 'feed-expense'; ?> flex py-1 items-center">
                    <div class="flex px-2 flex-column items-center feed-date">
                      <span class="h5 feed-date-day"><?= $separedDate[0]; ?></span>
                      <span class="h6 feed-date-month"><?= $spanishMonth; ?></span>
                      <span class="h6 feed-date-year"><?= $separedDate[2]; ?></span>
                    </div>
                    <div class="flex px-2 flex-column mr-auto">
                      <span class="h5 semibold feed-product"><?= $row->concepto; ?></span>
                      <span class="h6 feed-metadata"><?= $row->referencia; ?></span>
                    </div>
                    <span class="px-2 feed-amount items-center"><?= lang('GEN_COIN') . ' ' . ($row->signo == '+' ? '' : $row->signo) . $row->monto; ?></span>
                  </li>
                <?php } ?>
              </ul>
            <?php
            }
            ?>

          </div>

          <div id="stats" class="group-aside-view col-lg-4">
            <h3 class="h4 regular">Estadísticas</h3>
            <div class="line mt-1"></div>
            <div id="movementsStats" class="detail-stats"></div>
            <div id="transitStats" class="detail-stats"></div>
          </div>
        </div>

      </div>
    </section>
  </div>
</div>
<?php
$dataForm = json_encode([
  "noTarjeta" => $data['noTarjeta'],
  "id_ext_per" => $data['id_ext_per'],
  "totalIncomeMovements" => $totalIncomeMovements,
  "totalExpenseMovements" => $totalExpenseMovements,
  "totalIncomePendingTransactions" => isset($totalIncomePendingTransactions) ? $totalIncomePendingTransactions : 0,
  "totalExpensePendingTransactions" => isset($totalExpensePendingTransactions) ? $totalExpensePendingTransactions : 0,
  "currency" => lang('GEN_COIN')
])
?>
<script>
  var data = <?= $dataForm; ?>
</script>