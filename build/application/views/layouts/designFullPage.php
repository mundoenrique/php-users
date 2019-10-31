<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">

<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/vnd.microsoft.icon" href="<?= $this->asset->insertFile('favicon.ico','img',$countryUri); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>CPO - Banco Bogota</title>
	<?= $this->asset->insertCss(); ?>
</head>

<body>

	<?php
		if($module !== 'login'):
	?>
		<header class="main-head">
			<div class="flex">
				<img src="<?= $this->asset->insertFile('img-logo.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá"/>
			</div>
		</header>
	<?php
		endif;
	?>

	<main class="content">
		<?php
			foreach($viewPage as $views) {
				$this->load->view($views . '_content');
			}
		?>
  </main>

	<footer class="main-footer">
		<div class="flex pr-2 pr-lg-0">
			<img class="" src="<?= $this->asset->insertFile('img-mark.svg','img',$countryUri); ?>" alt="Logo Superintendencia">
		</div>
		<div class="flex flex-auto flex-wrap justify-around items-center">
			<img class="order-first" src="<?= $this->asset->insertFile('img-bogota_white.svg','img',$countryUri); ?>" alt="Logo Banco de Bogotá">
			<img class="order-1" src="<?= $this->asset->insertFile('img-pci_compliance.svg','img',$countryUri); ?>" alt="Logo PCI">
			<span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">© Todos los derechos reservados. Banco de Bogotá - 2019.</span>
		</div>
	</footer>

	<div id="system-info" class="none" name="system-info" cancel="<?= lang('BUTTON_CANCEL'); ?>" accept="<?= lang('BUTTON_ACCEPT'); ?>">
		<p><span id="system-msg" class="system-msg"><?= lang('MESSAGE_SYSTEM'); ?></span></p>
	</div>

	<script>
		var urlBase = '<?= base_url(); ?>';
		var urlAsset = '<?= assetUrl(); ?>';
		var titleNotiSystem = '<?= lang('GEN_SYSTEM_NAME'); ?>';
		var uriRedirecTarget = '<?= base_url('inicio'); ?>';
		var codeResp = '<?= lang('RESP_DEFAULT_CODE'); ?>';
		var textBtnNotiSystem = '<?= lang('BUTTON_ACCEPT'); ?>';
		var activatedCaptcha = '<?= $this->config->item('active_recaptcha'); ?>';

	</script>

	<?php
		if($module == 'login' && $activeRecaptcha) {
			echo 	$scriptCaptcha;
		}

		echo $this->asset->insertJs($countryUri);
	?>
</body>

</html>
