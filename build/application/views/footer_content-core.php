<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if (lang('CONF_FOOTER_INFO') == 'ON') : ?>
	<footer class="main-footer">
		<?php if(lang('CONF_FOOTER_MARK') == 'ON'): ?>
		<div class="flex pr-2 pr-lg-0">
			<img src="<?= $this->asset->insertFile(lang('IMG_FOTTER_MARK'), 'images', $customerLang); ?> " alt="Superintendencia de Bancos">
		</div>
		<?php endif; ?>
		<div class="flex flex-auto flex-wrap justify-around items-center">
			<?php if(lang('CONF_FOOTER_NETWORKS') == 'ON'): ?>
			<div class="order-first networks">
				<?php foreach(lang('IMG_FOTTER_NETWORKS_IMG') AS $key => $value): ?>
				<a href="<?= lang('CONF_FOTTER_NETWORKS_LINK')[$key]; ?>" target="_blank">
					<img src="<?= $this->asset->insertFile($value, 'images/networks'); ?>" alt="<?= $key; ?>">
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<?php if(lang('CONF_FOOTER_LOGO') == 'ON'):?>
			<img class="order-first" src="<?= $this->asset->insertFile(lang('IMG_FOTTER_IMAGE_L'), 'images', $customerLang); ?>"
				alt="<?= lang('GEN_ALTERNATIVE_TEXT'); ?>">
			<?php endif; ?>
			<img class="order-1" src="<?= $this->asset->insertFile(lang('IMG_PCI'), 'images'); ?>" alt="Logo PCI">
			<span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">
				<?= lang('GEN_FOTTER_RIGHTS'); ?><?= ' - '.date("Y") ?>
				<?php if (lang('CONF_FOTTER_PRIVACY_NOTICE') == 'ON') : ?>
					<br>
					<a class="block mb-1 h5 tertiary underline" href="<?= lang('CONF_PRIVACY_NOTICE_LINK'); ?>" target="_blank">
						<?= lang('GEN_PRIVACY_NOTICE'); ?>
					</a>
				<?php endif; ?>
			</span>
		</div>
	</footer>
<?php endif; ?>

<?php if (lang('CONF_SIGNIN_WIDGET_CONTACT') == 'ON') : ?>
  <?php $this->load->view('widget/widget_contacts_content-core') ?>
<?php endif; ?>

<?php if (lang('CONF_BTN_LANG') == 'ON') : ?>
  <div class="btn-lang">
    <div class="btn-lang-img">
			<a id="change-lang" class="big-modal" href="<?= lang('CONF_NO_LINK') ?>">
				<img src="<?= $this->asset->insertFile(lang('GEN_LANG_IMG'), 'images/lang'); ?>">
				<span class="text"><?= lang('GEN_AFTER_COD_LANG'); ?></span>
			</a>
    </div>
  </div>
<?php endif; ?>

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
      <button type="button" id="cancel" class="<?= lang('CONF_MODAL_BTN_CLASS')['cancel']; ?>">
				<?= lang('GEN_BTN_CANCEL'); ?>
			</button>
      <button type="button" id="accept" class="<?= lang('CONF_MODAL_BTN_CLASS')['accept']; ?>">
				<?= lang('GEN_BTN_ACCEPT'); ?>
		</button>
    </div>
  </div>
</div>
<div class="cover-spin"></div>
<?php if (isset($operations)): ?>
<form id="operation">
  <input type="hidden" id="cardNumber" name="cardNumber" value="<?= $cardNumber ?? ''; ?>">
  <input type="hidden" id="cardNumberMask" name="cardNumberMask" value="<?= $cardNumberMask ?? ''; ?>">
  <input type="hidden" id="expireDate" name="expireDate" value="<?= $expireDate ?? ''; ?>">
  <input type="hidden" id="prefix" name="prefix" value="<?= $prefix ?? ''; ?>">
	<input type="hidden" id="status" name="status" value="<?= $status ?? ''; ?>">
	<input type="hidden" id="virtual" name="virtual" value="<?= $isVirtual ?? ''; ?>">
  <input type="hidden" id="action" name="action" value="">
</form>
<?php if ($totalCards > 1): ?>
<section id="cardListModal" class="hide">
  <h4 class="h4"><?= lang('GEN_ACCOUNT_SELECTION') ?></h4>
  <div id="cardsDetail" class="dashboard-items flex mt-3 mx-auto flex-wrap">
    <?php foreach ($cardsList AS $cards): ?>
    <div class="dashboard-item p-1 mx-1 mb-1 <?= $cards->statusClasses ?? '' ?>">
      <img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, 'images/programs', $customerProgram); ?>"
				alt="<?= $cards->productName ?>">
      <div class="item-info <?= lang('CONF_FRANCHISE_LOGO') === 'ON' ? $cards->brand: ''?> p-2 h5 bg-white">
        <p class="item-category semibold"><?= $cards->productName ?>
					<span class="warning semibold h6 capitalize"><br><?= $cards->virtualCard?></span>
				</p>
				<p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
				<?php if (isset($cards->module) && $cards->statusMessage != ''): ?>
				<span class="h6 semibold danger"><?= $cards->statusMessage ?></span>
				<?php endif; ?>
      </div>
      <form name="cardsListForm">
        <input type="hidden" name="productName" class="hidden" value="<?= $cards->productName ?? ''; ?>">
        <input type="hidden" name="cardNumber" class="hidden" value="<?= $cards->cardNumber ?? ''; ?>">
        <input type="hidden" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask ?? ''; ?>">
        <input type="hidden" name="prefix" class="hidden" value="<?= $cards->prefix; ?>">
        <input type="hidden" name="expireDate" class="hidden" value="<?= $cards->expireDate ?? ''; ?>">
        <input type="hidden" name="status" class="hidden" value="<?= $cards->status ?? ''; ?>">
        <input type="hidden" name="brand" class="hidden" value="<?= $cards->brand ?? ''; ?>">
				<input type="hidden" name="isVirtual" class="hidden" value="<?= $cards->isVirtual ?? '' ;?>">
				<input type="hidden" name="tittleVirtual" class="hidden" value="<?= $cards->tittleVirtual ?? ''; ?>">
        <?php if (isset($cards->services)): ?>
        <input type="hidden" name="services" class="hidden" value="<?= htmlspecialchars(json_encode($cards->services), ENT_QUOTES, 'UTF-8'); ?>">
				<?php endif; ?>
				<input type="hidden" name="module" class="hidden" value="<?= $cards->module ?? ''; ?>">
      </form>
    </div>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
<?php endif; ?>
<form id="requestForm" method="post">
	<input type="hidden" id="traslate" name="traslate" value="<?= ACTIVE_SAFETY ?>">
</form>
