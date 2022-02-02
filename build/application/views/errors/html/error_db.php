<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('error_helpers.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Error de Base de Datos</title>
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
				<a id="<?= (SKIN === 'pichincha') ? 'brand-id' : 'brand-app' ?>" rel="start">
				</a>
			</div>
		</header>
		<div id="wrapper">
			<div id="content">
				<h1><?php echo $heading; ?></h1>
				<?php echo $message; ?>
				<a class="button" href="#" id="history-back">Regresar</a>
			</div>
		</div>
		<?php if(SKIN !== 'pichincha'): ?>
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
		echo NOVO_insert_js_cdn('jquery-3.6.0.min.js');
		?>
		<script>
			$('#history-back').on('click', function(event) {
				event.preventDefault();

				window.history.back();
			});
		</script>
	</body>
</html>
