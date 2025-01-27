<div class="notrender-content flex items-center justify-center">
  <div class="flex items-center">
    <h1><?= $reasonTitle; ?></h1>
    <?php if ($reason === 'b') : ?>
      <h2><?= $reasonMessage; ?></h2>
      <ul class="list-inline w-list flex justify-between">
        <li class="list-inline-item">
          <img class="browser-img" src="<?= $this->asset->insertFile('icon-chrome.svg', 'img', 'bdb'); ?>" alt="Icono chrome">
          <span class="browser-name">Google Chrome</span>
          <span class="browser-version">Version 48+</span>
        </li>
        <li class="list-inline-item">
          <img class="browser-img" src="<?= $this->asset->insertFile('icon-firefox.svg', 'img', 'bdb'); ?>" alt="Icono firefox">
          <span class="browser-name">Mozilla Firefox</span>
          <span class="browser-version">Version 30+</span>
        </li>
        <li class="list-inline-item">
          <img class="browser-img" src="<?= $this->asset->insertFile('icon-safari.svg', 'img', 'bdb'); ?>" alt="Icono safari">
          <span class="browser-name">Apple Safari</span>
          <span class="browser-version">Version 10+</span>
        </li>
        <li class="list-inline-item">
          <img class="browser-img" src="<?= $this->asset->insertFile('icon-edge.svg', 'img', 'bdb'); ?>" alt="Icono safari">
          <span class="browser-name">Microsoft Edge</span>
          <span class="browser-version">Version 14+</span>
        </li>
      </ul>
    <?php else : ?>
      <h2 class="msg"><?= $reasonMessage; ?></h2>
      <div class="flex items-center justify-center">
        <li class="list-inline-item">
          <?php if ($reason === 'iOS') : ?>

            <img src="<?= $this->asset->insertFile('badge-appstore.png', 'img', 'bdb'); ?>" alt="Insignia App Store">
          <?php else : ?>

            <img class="mobile-img" src="<?= $this->asset->insertFile('badge-googleplay.png', 'img', 'bdb'); ?>" alt="Insignia Play Store">
          <? endif; ?>
      </div>
    <? endif; ?>
  </div>
</div>