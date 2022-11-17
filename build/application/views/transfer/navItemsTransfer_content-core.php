<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<li id=<?= $id ?> class="list-inline-item nav-item-config <?= $activeSection ?> <?= $activePointer ?>">
  <a class="px-1" href="javascript:">
    <span class="icon-config <?= $icon ?> icon-color"></span>
    <h5 class="center"><span class="status-text1"><?= $title ?></span></h5>
    <div class="px-1 box up left regular">
      <span class="<?= $icon ?> icon-color"></span>
      <h4 class="h5 center status-text1"><span class="status-text1"><?= $title ?></span></h4>
    </div>
  </a>
</li>
