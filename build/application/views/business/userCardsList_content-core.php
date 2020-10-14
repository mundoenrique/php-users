<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<h1 class="h3 semibold primary"><?= $greeting.' '.$fullName ?></h1>
<div class="pt-3">
  <div class="flex mt-3 light items-center">
    <div class="flex col-3">
      <h2 class="h4 regular tertiary mb-0"><?= lang('BUSINESS_MY_PRODUCTS') ?></h2>
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
      <div class="dashboard-item p-1 mx-1 mb-1 get-detail big-modal">
        <img class="item-img" src="<?= $this->asset->insertFile($cards->productImg, $cards->productUrl); ?>" alt="<?= $cards->productName ?>" />
        <div class="item-info <?= $cards->brand; ?> p-2 h5 bg-white">
          <p class="item-category semibold truncate" title="<?= $cards->productName ?>" data-toggle="tooltip"><?= $cards->productName ?>
            <span class="warning semibold h6 capitalize"><br><?= $cards->virtualCard?></span>
          </p>
          <p class="item-cardnumber mb-0"><?= $cards->cardNumberMask ?></p>
          <p class="item-balance mb-0 h6 light text"><?= lang('GEN_WAIT_BALANCE') ?></p>
        </div>
        <form action="<?= base_url(lang('GEN_LINK_CARD_DETAIL')); ?>" method="POST">
          <input type="hidden" id="userIdNumber" name="userIdNumber" class="hidden" value="<?= $cards->userIdNumber ?>">
          <input type="hidden" id="cardNumber" name="cardNumber" class="hidden" value="<?= $cards->cardNumber ?>">
          <input type="hidden" id="cardNumberMask" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask ?>">
          <input type="hidden" id="productName" name="productName" class="hidden" value="<?= $cards->productName ?>">
          <input type="hidden" id="brand" name="brand" class="hidden" value="<?= $cards->brand ?>">
          <input type="hidden" id="productImg" name="productImg" class="hidden" value="<?= $cards->productImg ?>">
          <input type="hidden" id="productUrl" name="productUrl" class="hidden" value="<?= $cards->productUrl ?>">
          <input type="hidden" id="isVirtual" name="isVirtual" class="hidden" value="<?= $cards->isVirtual ?>">
          <input type="hidden" id="cardsTotal" name="cardsTotal" class="hidden" value="<?= $cardsTotal ?>">
        </form>
      </div>
      <?php endforeach; ?>
      <div class="dashboard-item mx-1"></div>
      <div class="dashboard-item mx-1"></div>
      <div class="dashboard-item mx-1"></div>
    </div>
  </div>
  <div id="no-products" class="hide">
    <div class="flex flex-column items-center justify-center pt-5">
      <h3 class="h4 regular mb-0"><?= lang('BUSINESS_NO_CARDS_LIST'); ?></h3>
    </div>
  </div>
</div>
