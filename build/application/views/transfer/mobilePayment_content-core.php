<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<h1 class="primary h3 semibold inline"><?= lang('GEN_MENU_MOBILE_PAYMENT'); ?></h1>
<div id='transferView' class="row" operation-type='PMV'>
  <div class="flex flex-column pt-3 col-xl-4 px-xl-2 mx-auto">
    <div class="flex flex-wrap">
      <div class="w-100">
        <div class="widget-product m-auto">
          <div class="line-text w-100">
            <div id="productdetail" class="flex inline-flex col-12 px-xl-2">
              <div class="flex flex-column justify-center col-auto pb-4 pt-4 pr-0"">
								<div class=" product-presentation relative">
                <div class="item-network <?= $totalCards == 1 && lang('CONF_FRANCHISE_LOGO') === 'ON' ? $brand : 'hide'; ?>"></div>
                <?php if ($totalCards > 1 || $totalCards == 0) : ?>
                <div id="donor" class="product-search btn">
                  <a class="dialog button product-button"><span aria-hidden="true" class="icon-find h1 icon-color"></span></a>
                  <input id="donor-cardnumber" name="donor-cardnumber" type="hidden" value="">
                </div>
                <?php else : ?>
                <img class="card-image" src="" alt="">
                <?php endif; ?>
              </div>
              <?php if ($totalCards == 1 && $isVirtual) : ?>
              <span class="warning semibold h6 mx-auto"><?= lang('GEN_VIRTUAL_CARD'); ?></span>
              <?php endif; ?>
            </div>
            <?php if ($totalCards > 1 || $totalCards == 0) : ?>
            <div id="accountSelect" class="flex flex-column items-start self-center col-6 py-5">
              <p class="mb-0"><?= lang('GEN_SELECT_ACCOUNT'); ?></p>
            </div>
            <?php else : ?>
            <div class="flex flex-column items-start col-6 self-center px-0 ml-1">
              <p class="semibold mb-0 h5 truncate"><?= $productName; ?></p>
              <p id="card" class="mb-2"><?= $cardNumberMask; ?></p>
              <a id="other-product" class="btn hyper-link btn-small p-0 hide" href="<?= lang('CONF_NO_LINK'); ?>">
                <i aria-hidden="true" class="icon-find"></i>&nbsp;<?= lang('GEN_OTHER_PRODUCTS'); ?>
              </a>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="flex col-12 mt-2 center info-contained">
          <ul class="flex flex-auto justify-between px-4 px-xl-5">
						<li id="avaibleBalance" class="list-inline-item">
							<? $totalCards === 1 ? lang('TRANSF_AVAILABLE_BALANCE') : '' ?>
						</li>
            <li id="currentBalance" class="list-inline-item">
							<? $totalCards === 1 ? lang('GEN_WAIT_BALANCE') : '' ?>
						</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="flex optional mt-4 px-0">
    <nav class="nav-config w-100">
      <ul class="flex flex-wrap justify-center nav-config-box">
			<?php foreach($navItemsConfig as $key => $value) : ?>
				<?php $this->load->view('/transfer/navItemsTransfer_content-core', $value); ?>
			<?php endforeach; ?>
      </ul>
    </nav>
  </div>
</div>

<div id="activeMobilePayment" class="col-12 col-sm-12 col-lg-12 col-xl-8 pt-3">
  <?php $this->load->view('/transfer/transfer_content-core') ?>
  <?php $this->load->view('/transfer/affiliate/affiliations_content-core') ?>
  <?php $this->load->view('/transfer/historyTransfer_content-core') ?>
</div>
