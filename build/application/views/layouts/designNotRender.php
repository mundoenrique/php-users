<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/vnd.microsoft.icon" href="<?= $this->asset->insertFile('favicon.ico', 'img', 'bdb'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= $titlePage; ?></title>
  <?= $this->asset->insertCss(); ?>
</head>

<body>
  <header class="main-head">
    <nav class="navbar">
      <a class="navbar-brand"><img src="<?= $this->asset->insertFile('img-logo.svg', 'img', 'bdb'); ?>" alt="Logo Brand"></a>
    </nav>
  </header>

  <?php
  foreach ($viewPage as $views) {
    $this->load->view($views . '_content');
  }
  ?>

  <footer class="main-footer">
    <div class="flex">
      <img src="<?= $this->asset->insertFile('img-mark.svg', 'img', 'bdb'); ?>" alt="Logo Superintendencia">
    </div>
    <div class="flex flex-auto flex-wrap justify-around items-center">
      <img class="order-first" src="<?= $this->asset->insertFile('img-bogota_white.svg', 'img', 'bdb'); ?>" alt="Logo Banco de Bogotá">
      <img class="order-1" src="<?= $this->asset->insertFile('img-pci_compliance.svg', 'img', 'bdb'); ?>" alt="Logo PCI">
      <span class="copyright-footer flex-auto order-1">© Todos los derechos reservados. Banco de Bogotá - 2019.</span>
    </div>
  </footer>
</body>

</html>