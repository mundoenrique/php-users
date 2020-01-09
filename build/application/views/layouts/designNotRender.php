<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">

<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?= $this->asset->insertFile('favicon.ico','img',$countryUri); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $titlePage;?></title>
	<?= $this->asset->insertCss(); ?>
</head>

<body>
  <header class="main-head">
    <nav class="navbar">
      <a class="navbar-brand"><img src="<?= base_url($rootHome);?>"><img src="<?= $this->asset->insertFile('img-logo.svg','img',$countryUri); ?>" alt="Logo Brand"></a>
    </nav>
  </header>

	<?php
		foreach($viewPage as $views) {
			$this->load->view($views . '_content');
		}
	?>

	<footer class="main-footer">
    <div>
      <img src="<?= $this->asset->insertFile('img-mark.svg','img',$countryUri); ?>" alt="Logo Superintendencia">
    </div>
    <div>
      <img src="<?= $this->asset->insertFile('img-bogota_white.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
      <img src="<?= $this->asset->insertFile('img-pci_compliance.svg','img',$countryUri); ?>" alt="Logo PCI">
      <span>© Todos los derechos reservados. Banco de Bogotá - 2019.</span>
    </div>
  </footer>
</body>

</html>
