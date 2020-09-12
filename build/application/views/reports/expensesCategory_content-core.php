<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_REPORTS'); ?></h1>
<div class="flex justify-between row">
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="flex flex-wrap widget-product">
      <div class="w-100">
        <div class="widget-product">
          <div id="productdetail" class="flex inline-flex col-12 px-xl-2" call-moves="<?= $callMoves; ?>">
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
              <p class="mb-2">Selecciona una cuenta</p>
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
      </div>
    </div>
    <div class="flex optional widget-statistics p-3 mt-4">
      <h3 class="h4 regular">Estadísticas</h3>
      <div class="flex flex-column items-center">
        <div class="flex flex-wrap items-center">
          <div id="stats" class="group-aside-view">
            <div id="movementsStats" class="detail-stats"></div>
            <div id="transitStats" class="detail-stats"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex flex-column pt-3 col-lg-12 col-xl-8">
    <h2 class="h4 regular tertiary">Gastos por categoria</h2>
    <nav id="filtersStack" class="navbar px-0">

      <form id="monthtlyMovesForm" method="post" class="col-12 col-lg-9">
        <div class="row pl-2">
          <label class="mt-1" for="initDate">Mostrar desde</label>
          <div class="form-group col-4 px-1">
            <input id="initDate" name="initDate" class="form-control date-picker" type="text" placeholder="DD/MM/AAA" autocomplete="off" disabled>
            <div class="help-block"></div>
          </div>
          <label class="mt-1" for="finalDate">Hasta</label>
          <div class="form-group col-4 px-1">
            <input id="finalDate" name="finalDate" class="form-control date-picker" type="text" placeholder="DD/MM/AAA" autocomplete="off" disabled>
            <div class="help-block "></div>
          </div>
          <div class="flex items-center">
            <button id="monthtlyMovesBtn" class="btn btn-small btn-rounded-right btn-primary mb-3" disabled>
              <span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
            </button>
          </div>
        </div>
      </form>

      <div id="downloads" class="hide">
        <ul class="stack list-inline mb-0 flex items-center mb-3">
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadPDF" href="#" rel="subsection"><span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span></a>
          </li>
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadXLS" href="#" rel="subsection"><span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span></a>
          </li>
        </ul>
      </div>
    </nav>
    <div class="line mb-1"></div>
    <div id="results" class="mt-3">
      <div id="pre-loader" class="w-100 hide">
        <div class="mt-5 mb-4 pt-5 mx-auto flex justify-center block">
          <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
        </div>
      </div>

      <table id="movements" class="cell-border h6 display responsive w-100 dataTable no-footer dtr-inline hide">
        <thead class="bg-primary secondary regular"></thead>
        <tbody></tbody>
      </table>
      <div id="no-result" class="hide">
        <div class="flex flex-column items-center justify-center pt-5">
          <h2 class="h3 regular mb-1">No se encontraron registros.</h2>
          <span class="h6 regular mb-0">Seleccione un rango de fecha a consultar.</span>
        </div>
      </div>
    </div>
  </div>
</div>
