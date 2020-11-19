<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<footer class="main-footer">
  <? if ($countryUri == 'bdb'): ?>
  <div class="flex pr-2 pr-lg-0">
    <img src="<?= $this->asset->insertFile(lang('GEN_FOTTER_MARK'), 'images', $countryUri); ?> " alt="Logo Superintendencia">
  </div>
  <? endif; ?>
  <div class="flex flex-auto flex-wrap justify-around items-center">
    <?php if(lang('CONF_FOOTER_NETWORKS') == 'ON'): ?>
    <div class="order-first networks">
      <?php foreach(lang('GEN_FOTTER_NETWORKS_IMG') AS $key => $value): ?>
      <a href="<?= lang('GEN_FOTTER_NETWORKS_LINK')[$key]; ?>" target="_blank">
        <img src="<?= $this->asset->insertFile($value, 'images/networks'); ?>" alt="<?= $key; ?>">
      </a>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if(lang('CONF_FOOTER_LOGO') == 'ON'):?>
    <img class="order-first" src="<?= $this->asset->insertFile(lang('GEN_FOTTER_IMAGE_L'), 'images', $countryUri); ?>"
      alt="<?= lang('GEN_ALTERNATIVE_TEXT'); ?>">
    <?php endif; ?>
    <img class="order-1" src="<?= $this->asset->insertFile(lang('GEN_FOTTER_PCI'), 'images'); ?>" alt="Logo PCI">
    <span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">
      <?= lang('GEN_FOTTER_RIGHTS'); ?><?= ' - '.date("Y") ?>
    </span>
  </div>
</footer>

<div id="loader" class="none">
  <span class="spinner-border secondary" role="status" aria-hidden="true"></span>
</div>

<div id="system-info" class="hide" name="system-info">
  <p class="mb-0">
    <span class="dialog-icon">
      <i id="system-icon"></i>
    </span>
    <span id="system-msg" class="system-msg"><?= lang('GEN_SYSTEM_MESSAGE'); ?></span>
  </p>
  <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix mb-1">
    <div class="ui-dialog-buttonset novo-dialog-buttonset flex">
      <button type="button" id="cancel" class="btn-modal btn btn-small btn-link"><?= lang('GEN_BTN_CANCEL'); ?></button>
      <button type="button" id="accept" class="btn-modal btn btn-small btn-loading btn-primary"><?= lang('GEN_BTN_ACCEPT'); ?></button>
    </div>
  </div>
</div>
<div class="cover-spin"></div>
<?php if (isset($operations)): ?>
<form id="operation">
  <input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber; ?>">
  <input type="hidden" id="cardNumberMask" name="cardNumberMask" value="<?= $cardNumberMask; ?>">
  <?php if (isset($expireDate)): ?>
  <input type="hidden" id="expireDate" name="expireDate" value="<?= $expireDate; ?>">
  <?php endif; ?>
  <input type="hidden" id="prefix" name="prefix" value="<?= $prefix; ?>">
	<input type="hidden" id="status" name="status" value="<?= $status; ?>">
	<input type="hidden" id="virtual" name="virtual" value="<?= $isVirtual; ?>">
  <input type="hidden" id="action" name="action" value="">
</form>
<?php if ($cardsTotal > 1): ?>
<section id="cardList" class="hide">
  <h4 class="h4"><?= lang('GEN_ACCOUNT_SELECTION') ?></h4>
  <div id="cardsDetail" class="dashboard-items flex mt-3 mx-auto flex-wrap">
    <?php foreach ($cardsList AS $cards): ?>
    <div class="dashboard-item p-1 mx-1 mb-1 <?= $cards->statusClasses ?? '' ?>">
      <img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, $cards->productUrl); ?>" alt="<?= $cards->productName ?>">
      <div class="item-info <?= $cards->brand; ?> p-2 h5 bg-white">
        <p class="item-category semibold"><?= $cards->productName ?>
					<span class="warning semibold h6 capitalize"><br><?= $cards->virtualCard?></span>
				</p>
				<p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
				<?php if (isset($cards->module) && $cards->statusMessage != ''): ?>
				<span class="h6 semibold danger"><?= $cards->statusMessage ?></span>
				<?php endif; ?>
      </div>
      <form name="cardsListForm">
        <input type="hidden" name="cardNumber" class="hidden" value="<?= $cards->cardNumber; ?>">
        <input type="hidden" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask; ?>">
        <input type="hidden" name="prefix" class="hidden" value="<?= $cards->prefix; ?>">
        <?php if (isset($expireDate)): ?>
        <input type="hidden" name="expireDate" class="hidden" value="<?= $cards->expireDate; ?>">
        <?php endif; ?>
        <input type="hidden" name="status" class="hidden" value="<?= $cards->status; ?>">
        <input type="hidden" name="brand" class="hidden" value="<?= $cards->brand; ?>">
				<input type="hidden" name="isVirtual" class="hidden" value="<?= $cards->isVirtual ?>">
				<input type="hidden" name="tittleVirtual" class="hidden" value="<?= $cards->tittleVirtual ?>">
        <?php if (isset($cards->services)): ?>
        <input type="hidden" name="services" class="hidden" value="<?= htmlspecialchars(json_encode($cards->services), ENT_QUOTES, 'UTF-8'); ?>">
				<?php endif; ?>
				<input type="hidden" name="module" class="hidden" value="<?= isset($cards->module)?$cards->module:'' ?>">
      </form>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
<?php endif; ?>
