<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="<?= LANGUAGE ?>">

<head>
  <meta charset="UTF-8">
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

	<!-- <div id="system-info" class="hidden">
		<p>
			<span id="system-msg" class="system-msg"><?= lang('MESSAGE_SYSTEM'); ?></span>
		</p>
		<div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
			<div class="ui-dialog-buttonset novo-dialog-buttonset">
				<button type="button" id="cancel" class="cancel-button novo-btn-secondary-modal dialog-buttons"><?= lang('BUTTON_CANCEL'); ?></button>
				<button type="button" id="accept" class="novo-btn-primary-modal dialog-buttons"><?= lang('BUTTON_ACCEPT'); ?></button>
			</div>
		</div>
	</div> -->

	<!-- Modal -->
	<div id="system-info" class="modal modal-warning">
      <div class="modal-dialog">
        <!--Content-->
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">CPO - Banco Bogotá</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <p>
              <span id="system-msg" class="system-msg"><?= lang('MESSAGE_SYSTEM'); ?></span>
            </p>
          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button id="cancel" type="button" class="btn underline" data-dismiss="modal"><?= lang('BUTTON_CANCEL'); ?></button>
            <button id="accept" type="button" class="btn btn-primary"><?= lang('BUTTON_ACCEPT'); ?></button>
          </div>
        </div>
        <!--/.Content-->
      </div>
    </div>

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
