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

	<div id="system-info" class="none" name="system-info">
		<p>
			<span class="dialog-icon"><i id="system-icon" class="ui-icon mt-0"></i></span>
			<span id="system-msg" class="system-msg"><?= lang('RESP_MESSAGE_SYSTEM'); ?></span>
		</p>
		<hr class="separador-one m-0">
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
      <div class="ui-dialog-buttonset novo-dialog-buttonset">
				<button type="button" id="cancel" class="btn btn-small underline"></button>
				<button type="button" id="accept" class="btn btn-small btn-primary"></button>
      </div>
    </div>
	</div>

	<script>
		var urlBase = '<?= base_url(); ?>';
		var urlAsset = '<?= assetUrl(); ?>';
		var uriRedirecTarget = '<?= base_url('inicio'); ?>';
		var codeResp = '<?= lang('RESP_DEFAULT_CODE'); ?>';
		var activatedCaptcha = '<?= $this->config->item('active_recaptcha'); ?>';
		var titleNotiSystem = '<?= lang('GEN_SYSTEM_NAME'); ?>';
		var txtBtnCancelNotiSystem = "<?= lang('GEN_BTN_CANCEL'); ?>"
		var txtBtnAcceptNotiSystem = "<?= lang('GEN_BTN_ACCEPT'); ?>"

	</script>

	<?php
		if($module == 'login' && $activeRecaptcha) {
			echo 	$scriptCaptcha;
		}

		echo $this->asset->insertJs($countryUri);
	?>
</body>

</html>
