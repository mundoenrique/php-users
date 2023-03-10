<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="primary h3 semibold inline"><?= $titlePage; ?></h1>
<div class="row">
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="widget-product">
      <div class="line-text w-100">
        <div class="flex inline-flex col-12 px-xl-2">
          <div id="productdetail" class="flex flex-column justify-center col-auto <?= $isVirtual ? 'pb-2': 'pb-4' ?> pt-4 pr-0">
            <div class="product-presentation relative">
              <div class="item-network <?= lang('SETT_FRANCHISE_LOGO') === 'ON' ? $brand : '' ?>"></div>
              <img class="card-image" src="<?= $this->asset->insertFile($productImg, 'images/programs', $customerUri); ?>" alt="<?= $productName; ?>">
            </div>
            <?php if ($isVirtual): ?>
            <a id="virtual-details" class="btn hyper-link btn-small p-0" href="<?= lang('SETT_NO_LINK'); ?>">
              <i aria-hidden="true" class="icon-view"></i> &nbsp;<?= lang('BUSINESS_SEE_DETAILS'); ?>
            </a>
            <?php endif; ?>
          </div>
          <div class="flex flex-column items-start col-6 self-center px-0 ml-1">
						<?php if (lang('SETT_BUSINESS_NAME') == 'ON'): ?>
						<small class="sb-disabled uppercase light truncate"><?= $enterprise?></small>
						<?php endif; ?>
            <p class="semibold mb-0 h5 truncate" title="<?= $productName; ?>"><?= $productName; ?></p>
						<span class="semibold danger"><?= $statusMessage ?></span>
            <p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
            <?php if ($totalCards > 1): ?>
            <a class="btn hyper-link btn-small p-0 big-modal" href="<?= lang('SETT_LINK_CARD_LIST'); ?>">
              <i aria-hidden="true" class="icon-find"></i>
              &nbsp;<?= lang('GEN_OTHER_PRODUCTS'); ?>
            </a>
            <?php endif; ?>
          </div>
          <input type="hidden" name="brand" class="hidden" id="brand" value="<?= $brand; ?>">
          <input type="hidden" name="cardNumberMask" class="hidden" id="cardNumberMask" value="<?= $cardNumberMask; ?>">
          <input type="hidden" name="fullName" class="hidden" id="fullName" value="<?= $fullName; ?>">
          <input type="hidden" name="cardImage" class="hidden" id="cardImage" value="<?= $this->asset->insertFile($productImg, 'images/programs', $customerProgram); ?>">
					<input type="hidden" name="cardImageRev" class="hidden" id="cardImageRev" value="<?= $this->asset->insertFile($productImgRev, 'images/programs', $customerProgram); ?>">
        </div>
      </div>
      <div class="flex col-12 mt-2">
        <ul class="flex flex-auto justify-between px-2">
          <li class="list-inline-item"><?= lang('BUSINESS_CURRENT_BALANCE'); ?>
            <span id="currentBalance" class="product-balance block"><?= $balance->currentBalance; ?></span>
          </li>
          <li class="list-inline-item"><?= lang('BUSINESS_TRANSIT_BALANCE'); ?>
            <span id="inTransitBalance" class="product-balance block"><?= $balance->inTransitBalance; ?></span>
          </li>
          <li class="list-inline-item"><?= lang('BUSINESS_AVAILABLE_BALANCE'); ?>
            <span id="availableBalance" class="product-balance block"><?= $balance->availableBalance; ?></span>
          </li>
        </ul>
      </div>
    </div>
    <div class="flex optional widget-statistics mt-4">
      <h3 class="h4 regular py-3 pl-3"><?= lang('GEN_MOVEMENTS'); ?></h3>
      <div class="flex chart-container m-auto">
        <canvas class="block m-auto inline-block" id="chart"></canvas>
      </div>
    </div>
  </div>

  <div class="flex flex-column pt-3 pl-2 col-lg-12 col-xl-8">
    <h2 class="h4 regular tertiary"><?= lang('BUSINESS_MY_MOVEMENTS'); ?></h2>
    <nav id="filtersStack" class="navbar px-0">
      <form id="movements" method="post" class="col-12 col-lg-9">
        <div class="form-group">
          <input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber ?>">
          <input type="hidden" id="credit" name="credit" value="<?= $totalMoves->credit ?>">
          <input type="hidden" id="debit" name="debit" value="<?= $totalMoves->debit ?>">
					<input type="hidden" id="filterMonth" name="filterMonth" value="0">
					<input type="hidden" id="filterYear" name="filterYear" value="0">
          <label class="block"><?= lang('BUSINESS_RECENT'); ?></label>
          <div class="custom-control custom-radio custom-control-inline align-top">
            <input id="filterInputMonth" type="radio" name="filterInputMonth" class="custom-control-input" value="0">
            <label class="custom-control-label mr-1" for="filterInputMonth"><?= lang('BUSINESS_LAST_MOVEMENTS'); ?></label>
          </div>
          <div class="help-block"></div>
        </div>
        <label class="block"><?= lang('GEN_MONTHLY'); ?></label>
        <div class="row pl-2">
          <label class="mt-1 regular" for="initDateFilter"><?= lang('BUSINESS_SELECT'); ?></label>
          <div class="form-group col-4 px-1">
						<input id="filterInputYear" name="filterInputYear" class="form-control" name="datepicker" type="text" placeholder="<?= lang('GEN_DATEPICKER_DATEMEDIUM'); ?>" readonly autocomplete="off">
            <div id='error' class="help-block"></div>
          </div>
					<?php if (lang('SETT_TYPE_TRANSACTION') == 'ON') :  ?>
					<label class="mt-1 regular" for="transType"><?= lang('BUSINESS_TRANSACTIONS'); ?></label>
					<div class="form-group col-3 px-1">
						<select id="transType" class="custom-select form-control" name="transType">
							<?php foreach (lang('BUSINESS_TRANSACTIONS_LIST') as $key => $value) : ?>
							<option value="<?= $key; ?>">
								<?= $value; ?>
							</option>
							<?php endforeach; ?>
						</select>
						<div class="help-block"></div>
					</div>
					<?php endif; ?>
          <div class="flex items-center">
            <button id="search" class="btn btn-small btn-rounded-right btn-primary mb-3">
              <span aria-hidden="true" class="icon icon-find mr-0 h3"></span>
            </button>
          </div>
        </div>
      </form>
			<div class="hide-downloads self-end mb-4 pl-1">
        <ul id="downloadFiles" class="stack list-inline mb-0 flex items-center">
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadPDF" href="<?= lang('SETT_NO_LINK'); ?>" action="download">
              <span class="icon-file-pdf h5 mr-0" aria-hidden="true" title="<?= lang('GEN_DOWNLOAD_PDF'); ?>"></span>
            </a>
          </li>
          <?php if (lang('SETT_SEND_MOVEMENTS') == 'ON') :  ?>
          <li class="stack-item px-1 list-inline-item is-disabled">
            <a id="sendPDF" href="<?= lang('SETT_NO_LINK'); ?>" action="send">
              <span class="icon-email h5 mr-0" aria-hidden="true" title="<?= lang('GEN_SEND_PDF'); ?>"></span>
            </a>
          </li>
          <?php endif; ?>
          <li class="stack-item px-1 list-inline-item">
            <a id="downloadXLS" href="<?= lang('SETT_NO_LINK'); ?>" action="download">
              <span class="icon-file-excel h5 mr-0" aria-hidden="true" title="<?= lang('GEN_DOWNLOAD_XLS'); ?>"></span>
            </a>
          </li>
          <?php if (lang('SETT_SEND_MOVEMENTS') == 'ON') :  ?>
          <li class="stack-item px-1 list-inline-item is-disabled">
            <a id="sendXLS" href="<?= lang('SETT_NO_LINK'); ?>" action="send">
              <span class="icon-email h5 mr-0" aria-hidden="true" title="<?= lang('GEN_SEND_XLS'); ?>"></span>
            </a>
          </li>
          <?php endif; ?>
					<?php if (lang('SETT_DOWNLOAD_STATEMENT') == 'ON') :  ?>
          <li class="stack-item px-1 list-inline-item is-disabled">
            <a id="downloadExtract" href="#" rel="subsection">
              <span class="icon-down-statement h5 bold mr-0" aria-hidden="true" title="<?= lang('GEN_DOWNLOAD_STATEMENT'); ?>"></span>
            </a>
          </li>
          <?php endif; ?>
          <form id="downd-send">
            <input type="hidden" id="cardNumberDownd" name="cardNumberDownd" value="<?= $cardNumber ?>">
            <input type="hidden" id="month" name="filterMonth" value="0">
            <input type="hidden" id="year" name="filterYear" value="0">
          </form>
        </ul>
      </div>
			<?php if (lang('SETT_IN_TRANSIT') == 'ON'): ?>
      <div class="flex self-end mb-3">
        <button class="btn btn-outline btn-small btn-rounded-left bg-white" data-jplist-control="reset" data-group="group-filter-pagination"
          data-name="reset"><?= lang('GEN_MOVEMENTS'); ?></button>
        <button class="btn btn-outline btn-small btn-rounded-right nowrap is-disabled" data-jplist-control="reset"
          data-group="group-filter-pagination" data-name="reset"><?= lang('BUSINESS_TRANSIT_BALANCE'); ?></button>
      </div>
      <?php endif; ?>
    </nav>
    <div class="line mb-1"></div>
    <div id="results" class="mt-1 justify-center">
      <div id="pre-loader" class="mt-5 mx-auto flex justify-center">
        <span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
      </div>
      <ul id="movementsList" class="feed fade-in mt-3 pl-0 hide">
        <?php foreach ($movesList as $moves) : ?>
        <?php $classCss = $moves->sign == '-' ? 'feed-expense' : 'feed-income' ?>
        <li class="feed-item <?= $classCss; ?> flex py-2 items-center">
          <div class="flex px-2 flex-column items-center feed-date">
            <span class="h5"><?= $moves->date; ?></span>
          </div>
          <div class="flex px-2 flex-column mr-auto">
            <span class="h5 semibold feed-product"><?= $moves->desc; ?></span>
            <span class="h6 feed-metadata"><?= $moves->ref; ?></span>
          </div>
          <span class="px-2 feed-amount items-center"><?= $moves->sign . ' ' . $moves->amount; ?></span>
        </li>
        <?php endforeach; ?>
      </ul>
      <div id="no-moves" class="hide">
        <div class="flex flex-column items-center justify-center pt-5">
          <h3 class="h4 regular mb-0"><?= lang('GEN_DATATABLE_SEMPTYTABLE'); ?></h3>
        </div>
      </div>
    </div>
  </div>
</div>
