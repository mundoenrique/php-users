<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3 semibold primary"><?= $greeting.' '.$fullName ?></h1>
<div class="pt-3">
	<div class="flex mt-3 light items-center">
		<div class="flex col-3">
			<h2 class="h4 regular tertiary mb-0"><?= lang('CARDS_MY_PRODUCTS') ?></h2>
			<form id="cardListForm" action="<?= base_url(lang('GEN_LINK_CARDS_LIST')) ?>" method="post" card-list="<?= $getList; ?>">
				<input type="hidden" name="cardList" value="getCardList">
			</form>
		</div>
		<div class="flex h6 flex-auto justify-end">
			<div class="flex h6 flex-auto justify-end">
				<span><?= lang('GEN_LAST_ACCESS') ?>: <?= $lastSession ?></span>
			</div>
		</div>
	</div>
	<div class="line mt-1"></div>
	<div id="pre-loader" class="mt-5 mx-auto flex justify-center">
		<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>
	</div>
	<div class="hide-out hide">
		<div id="cardList" class="dashboard-items flex max-width-xl-6 mt-3 mx-auto flex-wrap justify-center">
			<?php foreach ($cardsList AS $cards): ?>
				<!-- big-modal -->
			<div class="dashboard-item p-1 mx-1 mb-1 get-detail">
				<img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, $cards->productUrl); ?>" alt="<?= $cards->productName ?>" />
				<div class="item-info <?= $cards->brand; ?> p-2 h5 bg-white">
					<p class="item-category semibold"><?= $cards->productName ?></p>
					<p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
					<p class="item-balance mb-0 h6 light text"><?= lang('GEN_WAIT_BALANCE') ?></p>
				</div>
				<form action="<?= base_url(lang('GEN_LINK_CARD_DETAIL')); ?>"  method="POST">
					<input type="text" id="userIdNumber" name="userIdNumber" class="hidden" value="<?= $cards->userIdNumber ?>">
					<input type="text" id="cardNumber" name="cardNumber" class="hidden" value="<?= $cards->cardNumber ?>">
				</form>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div id="no-products" class="hide">
		<div class="flex flex-column items-center justify-center pt-5">
			<h3 class="h4 regular mb-0"><?= lang('CARDS_NO_LIST'); ?></h3>
		</div>
	</div>
</div>
