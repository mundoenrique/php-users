<form method="post" action=''>
  <input type='hidden' name='<?php echo $novoName ?>' value='<?php echo $novoCook ?>'>
  <input type='hidden' name='frmInitialDate' value=''>
  <input type='hidden' name='frmFinalDate' value=''>
  <input type='hidden' name='frmTypeFile' value=''>
  <input type='hidden' name='nroTarjeta' value=''>
</form>

<div id="report" class="report-content h-100 bg-content">
  <div class="py-4 px-5">
    <header class="">
      <h1 class="h3 semibold primary">Reportes</h1>
    </header>
    <section>
      <div class="pt-3">
        <div class="flex max-width-4 flex-wrap items-center mb-2">
          <div class="product-presentation flex flex-column items-end mr-4">
            <div class="relative">
              <div class="item-network <?php lang('SETT_FRANCHISE_LOGO') === 'ON' ? strtolower($data['marca']) : '' ?>"></div>
              <img class="card-image" src="<?= $this->asset->insertFile($data['nameImage'], 'images', 'bdb', 'programs'); ?>" alt="Tarjeta gris">
            </div>
            <?php if ($totalProducts > 1) : ?>
              <a id="other-product" class="flex items-baseline btn btn-link btn-small" href="<?= base_url('reporte') ?>">
                <i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto
              </a>
            <?php endif; ?>
          </div>
          <div class="product-info mr-5">
            <p class="product-cardholder mb-1 semibold h4 primary truncate"><?= $data['tarjetaHabiente']; ?></p>
            <?php if ($data['bloque'] === 'S') : ?>
              <p class="mb-1 semibold danger"><?= lang('GEN_TEXT_BLOCK_PRODUCT'); ?></p>
            <?php endif; ?>
            <p id="card" class="product-cardnumber mb-0 primary"><?= $data['nroTarjetaMascara']; ?></p>
            <p class="product-metadata h6"><?= $data['producto']; ?></p>
            <p class="product-metadata mb-0 h6"><?= strtoupper($data['nomEmp']); ?></p>
          </div>
        </div>

        <h2 class="h4 regular tertiary">Gastos por categoría</h2>
        <nav id="filtersStack" class="navbar detail-filters-nav p-1 px-lg-5 bg-widget">
          <div id="period-form" class="stack-form mr-auto flex items-center">
            <div class="form-inline">
              <label class="nowrap mb-0" for="fromDate">Mostrar desde</label>
              <input id="fromDate" class="form-control" type="text" name="fromDate">
              <label class="nowrap mb-0" for="toDate">Hasta</label>
              <input id="toDate" class="form-control" type="text" name="toDate">
              <button id="buscar" class="btn btn-small btn-primary"><span aria-hidden="true" class="icon-arrow-right mr-0"></span></button>
            </div>
          </div>
          <div class="field-options btn-group btn-group-toggle" data-toggle="buttons">
            <label id="detailToogle" class="btn-small btn-options btn-outline btn-rounded-left active">
              <input id="optionDetail" type="radio" name="reportes" checked> Detalle
            </label>
            <label id="statsToogle" class="btn-small btn-options btn-outline btn-rounded-right nowrap is-disabled">
              <input id="optionStats" type="radio" name="reportes" disabled> Gráfico
            </label>
          </div>
          <ul class="stack list-inline mb-0 flex items-center">
            <li class="stack-item list-inline-item rounded is-disabled">
              <a id="downloadPDF" class="block px-1" href="" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
            </li>
            <li class="stack-item list-inline-item rounded is-disabled">
              <a id="downloadXLS" class="block px-1" href="" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
            </li>
          </ul>
        </nav>

        <div class="group max-width-6 mt-3 mx-auto">

          <div id="results" class="">
            <div id="noRecords" class="my-5 pt-4 center none">
              <span class="block mb-1 h4">No se encontraron registros</span>
              <span>Selecciona un rango de fecha a consultar.</span>
            </div>

            <div id="reportAnnual" class="feed overflow-auto">
              <?php if (is_array($expenses->listaGrupo) && count($expenses->listaGrupo) > 0) : ?>
                <table class="feed-table">
                  <thead>
                    <tr>
                      <th class="feed-headline">Meses</th>
                      <th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
                      <th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
                      <th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
                      <th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
                      <th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
                      <th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
                      <th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
                      <th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
                      <th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
                      <th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
                      <th class="feed-headline text-right">Total <?php echo lang("GEN_COIN"); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($expenses->totalesAlMes as $key => $value) : ?>
                      <tr id="<?= strtolower($value->mes); ?>">
                        <td class="feed-headline"><?= ucfirst(strtolower($value->mes)); ?></td>
                        <?php foreach ($expenses->listaGrupo as $col) : ?>
                          <td class="feed-monetary"><?= $col->gastoMensual[$key]->monto; ?></td>
                        <?php endforeach; ?>
                        <td class="feed-total"><?= $value->monto; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr id="totales">
                      <td class="feed-headline">Total</td>
                      <?php foreach ($expenses->listaGrupo as $key => $value) : ?>
                        <td class="feed-monetary feed-category-<?= $key + 1; ?>x"><?= $value->totalCategoria; ?></td>
                      <?php endforeach; ?>
                      <td class="feed-total"><?= $expenses->totalGeneral; ?></td>
                    </tr>
                  </tfoot>
                </table>
              <?php endif; ?>
            </div>

            <div id="reportMonthly" class="feed overflow-auto">
              <table class="feed-table">
                <thead>
                  <tr>
                    <th class="feed-headline">Fecha</th>
                    <th class="feed-category feed-category-1x"><span aria-hidden="true" class="icon-car" title="Alquiler de vehículos"></span></th>
                    <th class="feed-category feed-category-2x"><span aria-hidden="true" class="icon-bag" title="Comercios y tiendas por departamento"></span></th>
                    <th class="feed-category feed-category-3x"><span aria-hidden="true" class="icon-food" title="Comida, despensa y restaurantes"></span></th>
                    <th class="feed-category feed-category-4x"><span aria-hidden="true" class="icon-film" title="Diversión y entretenimiento"></span></th>
                    <th class="feed-category feed-category-5x"><span aria-hidden="true" class="icon-lab" title="Farmacias"></span></th>
                    <th class="feed-category feed-category-6x"><span aria-hidden="true" class="icon-suitcase" title="Hoteles"></span></th>
                    <th class="feed-category feed-category-7x"><span aria-hidden="true" class="icon-plane" title="Líneas áereas y transporte"></span></th>
                    <th class="feed-category feed-category-8x"><span aria-hidden="true" class="icon-medkit" title="Servicios médicos"></span></th>
                    <th class="feed-category feed-category-9x"><span aria-hidden="true" class="icon-card" title="Cajeros automáticos"></span></th>
                    <th class="feed-category feed-category-10x"><span aria-hidden="true" class="icon-asterisk" title="Otros"></span></th>
                    <th class="feed-headline text-right">Total <?php echo lang("GEN_COIN"); ?></th>
                  </tr>
                </thead>
                <tbody id="tbodyMes">
                </tbody>
                <tfoot>
                  <tr id="totalesMes">
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

          <div id="chart" class="feed mx-auto"></div>

        </div>

      </div>
    </section>
  </div>
</div>

<?php
$data = json_encode([
  'detailProduct' => $data,
  'listExpenses' => $expenses
]);
?>

<script>
  var dataExpensesReport = <?= $data; ?>;
</script>