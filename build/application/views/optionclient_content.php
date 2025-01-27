<form method="post">
  <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
</form>

<div id="detail" class="detail-content h-100 bg-content">
  <div class="py-4 px-5">
    <header class="">
      <h1 class="h3 semibold primary">Detalle de cuenta</h1>
    </header>
    <section>
      <div class="pt-3">
        <div class="flex items-center justify-between mb-2">
          <div class="product-presentation relative mr-4">
            <div class="item-network <?= $data['marca']; ?>"></div>
            <img class="card-image" src="<?= $this->asset->insertFile('img-card_gray.svg', 'img', 'bdb'); ?>" alt="Tarjeta gris">
          </div>
          <div class="product-info-full mr-4">
            <p class="product-cardholder mb-1 semibold h4 primary"><?= $data['nom_plastico']; ?></p>
            <p id="card" class="product-cardnumber mb-0 primary"><?= $data['noTarjetaConMascara']; ?></p>
            <p class="product-metadata mb-2 h6"><?= $data['nombre_producto']; ?></p>
            <ul class="product-balance-group flex justify-between mb-0 list-inline">
              <li class="list-inline-item">Actual
                <span id="actual" class="product-balance block primary">
                  <?= $data['actualBalance'] !== '--' ?
                    lang('GEN_COIN') . ' ' . strval(number_format($data['actualBalance'], 2, ',', '.')) :
                    $data['actualBalance']; ?>
                </span>
              </li>
              <li class="list-inline-item">En tránsito
                <span id="bloqueado" class="product-balance block primary">
                  <?= $data['ledgerBalance'] !== '--' ?
                    lang('GEN_COIN') . ' ' . strval(number_format($data['ledgerBalance'], 2, ',', '.')) : $data['ledgerBalance']; ?>
                </span>
              </li>
              <li class="list-inline-item">Disponible
                <span id="disponible" class="product-balance block primary">
                  <?= $data['availableBalance'] !== '--' ?
                    lang('GEN_COIN') . ' ' . strval(number_format($data['availableBalance'], 2, ',', '.')) : $data['ledgerBalance']; ?>
                </span>
              </li>
            </ul>
          </div>
          <div class="product-specifications">
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
          <div class="stack-form mr-auto flex items-center" id="period-form">
            <label class="my-1 mr-1 text" for="filterMonth">Mostrar:</label>
            <select id="filterMonth" class="custom-select form-control w-auto my-1 mr-1" name="filterMonth">
              <option selected="" value="0">Más recientes</option>
              <?php
              foreach ($months as $nroMonths => $txtMonths) {
              ?>
                <option value="<?= $nroMonths + 1; ?>"><?= $txtMonths; ?></option>
              <?php
              }
              ?>
            </select>
            <select id="filterYear" class="custom-select form-control w-auto my-1 mr-1" name="filterYear" disabled="">
              <option selected="" value="0">-</option>
              <option value="2019">2019</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
            </select>
            <button id="buscar" class="btn btn-small btn-primary"><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
          </div>
          <ul class="list-inline mx-2 mb-0 flex items-center">
            <li class="px-1 list-inline-item text border rounded">
              <a id="download" href="#download" rel="subsection"><span aria-hidden="true" title="Descargar PDF" class="icon-download h5 mr-0"></span></a>
            </li>
            <li class="px-1 list-inline-item text border rounded">
              <a id="downloadxls" href="#downloadxls" rel="subsection"><span aria-hidden="true" title="Descargar Excel" class="icon-file-excel h5 mr-0"></span></a>
            </li>
          </ul>
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn-small btn-options btn-outline btn-rounded-left active" id="movementsToogle">
              <input type="radio" name="movimientos" id="option1" checked> Movimientos
            </label>
            <label class="btn-small btn-options btn-outline btn-rounded-right is-disabled" id="transitToogle">
              <input type="radio" name="movimientos" id="option2" disabled> En tránsito
            </label>
          </div>
        </nav>

        <div class="group row mt-3" id="results">
          <div class="group-main-view col-8" id="transactions">
            <h3 class="h4 regular">Actividad <span id="period">reciente</span>
              <span id="transitTitle">transacciones pendientes</span>
            </h3>
            <div class="line mt-1"></div>
            <ul id="movementsList" class="feed list-style-none mt-3 pl-0">
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
                      <?= lang('GEN_COIN') . ' ' . ($row->signo == '+' ? '' : $row->signo) . strval(number_format($row->monto, 2, ',', '.')); ?>
                    </span>
                  </li>
                <?php
                }
              } else {
                ?>
                <div class="my-5 py-4 center">
                  <span class="h4">No se encontraron movimientos</span>
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
                    <span class="px-2 feed-amount items-center"><?= lang('GEN_COIN') . ' ' . ($row->signo == '+' ? '' : $row->signo) . strval(number_format($row->monto, 2, ',', '.')); ?></span>
                  </li>
                <?php } ?>
              </ul>
            <?php
            }
            ?>

          </div>

          <div id="stats" class="group-aside-view col-4">
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
$dataForm = new stdClass();
$dataForm->noTarjeta = $data['noTarjeta'];
$dataForm->totalIncomeMovements = $totalIncomeMovements;
$dataForm->totalExpenseMovements = $totalExpenseMovements;
$dataForm->totalIncomePendingTransactions = isset($totalIncomePendingTransactions) ? $totalIncomePendingTransactions : 0;
$dataForm->totalExpensePendingTransactions = isset($totalExpensePendingTransactions) ? $totalExpensePendingTransactions : 0;

?>
<script>
  var data = <?= json_encode((array)$dataForm); ?>
</script>