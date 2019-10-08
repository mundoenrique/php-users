<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CEO - Banco Bogota</title>
	<?= $this->asset->insertCss(); ?>
</head>

<body>

	<?php
		if($module !== 'login'):
	?>
		<header class="main-head">
			<div class="flex">
				<img src="<?= $this->asset->insertFile('img-logo.svg','img',$countryUri); ?>" alt="" />
			</div>
		</header>
	<?php
		endif;
	?>

	<article class="main">
		<?php
			foreach($viewPage as $views) {
				$this->load->view($views . '_content');
			}
		?>
  </article>

	<footer class="main-footer">
		<div class="flex mr-4">
			<img class="" src="<?= $this->asset->insertFile('img-mark.svg','img',$countryUri); ?>" alt="Logo Superintendencia">
		</div>
    <div class="flex flex-auto flex-wrap justify-between items-center">
			<img class="order-first" src="<?= $this->asset->insertFile('img-bogota_white.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
			<img class="order-1" src="<?= $this->asset->insertFile('img-pci_compliance.svg','img',$countryUri); ?>" alt="Logo PCI">
			<img class="order-1" src="<?= $this->asset->insertFile('img-engine.svg','img',$countryUri); ?>assets/images/img-engine.svg" alt="Logo NovoPayment">

      <span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">© Todos los derechos reservados. Banco de Bogotá - 2019.</span>
    </div>
	</footer>

	<?php
		if($module == 'login') {
			echo 	$scriptCaptcha;
		}
		echo $this->asset->insertJs($countryUri);
	?>
	<script>
		var urlBase = '<?= base_url(); ?>';
		var urlAsset = '<?= assetUrl(); ?>';
	</script>
</body>

</html>
