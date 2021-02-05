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

	<?php
		if($module !== 'login'){
	?>

		<header class="main-head">
			<nav class="navbar navbar-expand-lg flex-auto bg-primary">
				<a class="navbar-brand" href="<?= base_url($rootHome);?>"><img src="<?= $this->asset->insertFile('img-logo.svg','img',$countryUri); ?>" alt="Logo Brand"></a>

				<?php
					if ($logged){
				?>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div id="navbarNav" class="collapse navbar-collapse bg-primary">
							<ul class="navbar-nav ml-auto">
								<li id='listProduct' class="nav-item"><a class="nav-link" href="<?= base_url('vistaconsolidada');?>">Vista consolidada</a></li>
								<li id='reports' class="nav-item"><a class="nav-link" href="<?= base_url('reporte') ?>">Reportes</a></li>
								<li id='customerSupport' class="nav-item"><a class="nav-link" href="<?= base_url('listaproducto') ?>">Atención al cliente</a></li>
								<li id='profile' class="nav-item"><a class="nav-link" href="<?= base_url('perfil') ?>">Mi perfil</a></li>
								<li id='closeSession' class="nav-item"><a class="nav-link" href="<?= base_url('cerrarsesion') ?>">Cerrar sesión</a></li>
							</ul>
						</div>
				<?php
					}
				?>
			</nav>
		</header>
	<?php
		}
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
			<img class="order-1 mx-5" src="<?= $this->asset->insertFile('img-pci_compliance.svg','img',$countryUri); ?>" alt="Logo PCI">
			<span class="copyright-footer mt-1 nowrap flex-auto lg-flex-none order-1 order-lg-0 center h6">© Todos los derechos reservados. Banco de Bogotá - <?= date("Y") ?>.</span>
		</div>
	</footer>

	<div id="system-info" class="none" name="system-info" oncopy="return false">
		<p>
			<span class="dialog-icon"><i id="system-icon" class="ui-icon mt-0"></i></span>
			<span id="system-msg" class="system-msg"><?= lang('GEN_SYSTEM_MESSAGE'); ?></span>
		</p>
		<div id="footerSistemInfo" class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix mb-1">
			<div class="ui-dialog-buttonset novo-dialog-buttonset flex modal-buttonset">
				<button type="button" id="cancel" class="btn btn-small btn-link"></button>
				<button type="button" id="accept" class="btn btn-small btn-loading btn-primary"></button>
      </div>
    </div>
	</div>

	<div class="cover-spin" id=""></div>

<script>

		var urlBase = '<?= base_url(); ?>';
		var urlAsset = '<?= assetUrl(); ?>';
		var uriRedirecTarget = '<?= base_url('inicio'); ?>';
		var activatedCaptcha = '<?= ACTIVE_RECAPTCHA; ?>';
		var idleSession = '<?= $this->config->item('timeIdleSession'); ?>';
		var coinSimbol = '<?= lang("GEN_COIN"); ?>';
		var codeResp = '<?= lang('RESP_DEFAULT_CODE'); ?>';
		var titleNotiSystem = '<?= lang('GEN_SYSTEM_NAME'); ?>';
		var txtBtnCloseNotiSystem = "<?= lang('GEN_BTN_CLOSE'); ?>";
		var txtBtnCancelNotiSystem = "<?= lang('GEN_BTN_CANCEL'); ?>";
		var txtBtnAcceptNotiSystem = "<?= lang('GEN_BTN_ACCEPT'); ?>";
		var isLoadNotiSystem = "<?= $loadAlert?: FALSE; ?>";
		var txtMessageNotiSystem = "<?= $msgAlert?:''; ?>";
		var redirectNotiSystem = "<?= $redirectAlert?:''; ?>";

		var msgResendOTP = "<a name='resendCode' class='primary regular' href='#'>"+"<?= lang('RESP_RESEEND_OTP') ?>"+"</a>"

		var txtCloseIdleSession = "<?= lang('RESP_EXPIRED_SESSION'); ?>"
	</script>

	<?php
		if($module == 'login' && $activeRecaptcha) {
			echo 	$scriptCaptcha;
		}

		echo $this->asset->insertJs($countryUri);
	?>
</body>

</html>
