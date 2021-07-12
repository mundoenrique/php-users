<?php
defined('BASEPATH') OR exit('No direct script access allowed');

define(ENVIRONMENT, $_SERVER['CI_ENV']);
define(BASE_URL, $_SERVER['BASE_URL']);
define(ASSET_URL, $_SERVER['ASSET_URL']);
define(ASSET_PATH, $_SERVER['ASSET_PATH']);
define('SKIN', isset($_COOKIE['cpo_skin']) && $_COOKIE['cpo_skin'] !== 'default' ? $_COOKIE['cpo_skin'] : '');

require_once('error_helpers.php');

$favicon_ext = (SKIN !== '') ? 'ico' : 'png';
$favicon = ASSET_URL . 'img/favicon.' . $favicon_ext;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Error General</title>
    <meta name="viewport" content="width=device-width">
    <meta name="googlebot" content="none">
		<meta name="robots" content="noindex, nofollow">
		<link href="http://gmpg.org/xfn/11" rel="profile">
		<link href="<?php echo $favicon; ?>" rel="icon" type="image/png">
		<?php
		echo NOVO_insert_css_cdn('errors.css');
		echo NOVO_insert_js_cdn('html5.js');
		?>
	</head>
	<body>
		<header id="head">
			<div id="head-wrapper">
				<a id="<?= (SKIN !== '') ? 'brand-id' : 'brand-app' ?>" rel="start">
				</a>
			</div>
		</header>
		<div id="wrapper">
			<div id="content">
				<h1>Error General</h1>
				<p>Ha ocurrido un problema técnico inesperado. Regrese a la página anterior e intente nuevamente.</p>
				<a class="button" href="#" id="history-back">Regresar</a>
			</div>
		</div>
		<?php if(SKIN == 'pichincha'): ?>
		<footer id="foot">
			<div id="foot-wrapper">
				<div class="foot-wrapper-top">
					<a id="app-engine" href="http://www.novopayment.com/" rel="me" target="_blank">NovoPayment, Inc.</a>
				</div>
				<div class="foot-wrapper-bottom">
					<p id="app-copyright">© <?php echo date('Y'); ?> NovoPayment Inc. All rights reserved.</p>
				</div>
			</div>
		</footer>
		<?php endif; ?>
		<?php
		echo novo_insert_js_cdn('jquery-3.6.0.min.js');
		?>
		<script>
			$('#history-back').on('click', function(event) {
				event.preventDefault();

				window.history.back();
			});
		</script>
	</body>
</html>
