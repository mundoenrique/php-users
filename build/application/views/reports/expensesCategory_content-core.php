<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="primary h3 regular inline"><?= lang('GEN_MENU_REPORTS'); ?></h1>
<div class="row">
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="flex flex-wrap">
      <div class="w-100">
        <div class="widget-product">
          <div id="productdetail" class="flex inline-flex col-12 px-xl-2" call-moves="<?= $callMoves; ?>">
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
    <div class="flex optional widget-statistics mt-4">
      <h3 class="h4 regular py-3 pl-3"><?= lang('REPORTS_STATISTICS'); ?></h3>
      <div class="flex flex-column items-center">
        <div class="flex flex-wrap items-center h-100 justify-center">
          <div id="stats" class="group-aside-view w-100 h-100">
            <div id="movementsStats" class="hide w-100 h-100"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="flex flex-column pt-3 col-lg-12 col-xl-8">
    <h2 class="h4 regular tertiary"><?= lang('REPORTS_EXPENSES_CATEGORY'); ?></h2>
    <nav id="filtersStack" class="navbar px-0">

      <form id="annualMovesForm" method="post" class="col-12">
        <div class="form-group">
          <label class="block"><?= lang('REPORTS_YEARLY'); ?></label>
          <?php for ($years; $years <= $maxYear; $years++): ?>
          <div class="custom-control custom-radio custom-control-inline">
            <input id="<?= $years; ?>" class="custom-control-input" type="radio" name="year" value="<?= $years; ?>" autocomplete="off"
              <?= $years == $maxYear ? 'checked' : ''; ?> disabled>
            <label class="custom-control-label" for="<?= $years; ?>"><?= $years; ?></label>
          </div>
          <?php endfor; ?>
          <div class="help-block"></div>
        </div>
      </form>

      <form id="monthtlyMovesForm" method="post" class="col-12 col-lg-9">
        <label class="block"><?= lang('REPORTS_MONTHLY'); ?></label>
        <div class="row pl-2">
          <label class="mt-1 regular" for="initDate"><?= lang('REPORTS_FROM'); ?></label>
          <div class="form-group col-4 px-1">
            <input id="initDate" name="initDate" class="form-control date-picker" type="text" placeholder="DD/MM/AAA" autocomplete="off" disabled>
            <div class="help-block"></div>
          </div>
          <label class="mt-1 regular" for="finalDate"><?= lang('REPORTS_TO'); ?></label>
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

      <div id="downloads" class="hide-downloads hide pl-1">
        <ul id="downloadFiles" class="stack list-inline mb-0 flex items-center">
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadPDF" href="<?= lang('GEN_NO_LINK'); ?>" action="download">
              <span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="Descargar PDF"></span>
            </a>
          </li>
          <?php if(lang('CONF_SEND_MOVEMENTS') == 'ON'):  ?>
          <li class="stack-item px-1 list-inline-item is-disabled">
            <a id="sendPDF" href="<?= lang('GEN_NO_LINK'); ?>" action="send">
              <span class="icon-email h5 mr-0" aria-hidden="true" title="Enviar PDF"></span>
            </a>
          </li>
          <?php endif; ?>
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadXLS" href="<?= lang('GEN_NO_LINK'); ?>" action="download">
              <span class="icon-file-excel h5 mr-0" aria-hidden="true" title="Descargar Excel"></span>
            </a>
          </li>
          <?php if(lang('CONF_SEND_MOVEMENTS') == 'ON'):  ?>
          <li class="stack-item px-1 list-inline-item is-disabled">
            <a id="sendXLS" href="<?= lang('GEN_NO_LINK'); ?>" action="send">
              <span class="icon-email h5 mr-0" aria-hidden="true" title="Enviar Excel"></span>
            </a>
          </li>
          <?php endif; ?>
          <form id="downd-send">
            <input type="hidden" id="dType" name="Dtype">
            <input type="hidden" id="dInitDate" name="DinitDate">
            <input type="hidden" id="dFinalDate" name="DfinalDate">
          </form>
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
          <h2 class="h3 regular mb-1"><?= lang('GEN_TABLE_SEMPTYTABLE'); ?></h2>
          <span class="h6 regular mb-0"><?= lang('REPORTS_DATE_RANGE'); ?></span>
        </div>
      </div>
    </div>
  </div>
</div>
