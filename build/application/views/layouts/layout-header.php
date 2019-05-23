<?php
$CI =& get_instance();
$pageClass = isset($bodyclass) ? 'class="' . $bodyclass . '"' : '';
$pageUrl = $CI->config->item('base_url');
$pageCdn = $CI->config->item('base_url_cdn');
$skin = $CI->input->cookie($CI->config->item('cookie_prefix') . 'skin');
$extension = $skin != "pichincha" ? ".png": ".ico";
?>
<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8" />
    <title>{titlePage}</title>
    <meta name="viewport" content="width=device-width" />
    <meta name="googlebot" content="none" />
		<meta name="robots" content="noindex, nofollow" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="icon" type="image/png"  href="<?php echo $pageCdn;?>img/favicon<?php echo $extension;?>" />
    <?php
			$cookie = $this->input->cookie($this->config->item('cookie_prefix').'skin');
			$sendBaseCss = true;
			switch($this->router->class) {
				case 'registro':
				case 'service':
					$sendBaseCss = false;
					break;
			}
			if($sendBaseCss && $cookie == 'pichincha') {
				echo insert_css_cdn('base.css', 'screen');
			}
			foreach ($styleSheets as $css) {
				echo insert_css_cdn($css['url'], $css['media']);
				echo "\n";
			}
			echo insert_js_cdn('html5.js');
		?>
</head>
<body <?php echo $pageClass;?> data-app-url="<?php echo $pageUrl;?>" data-app-cdn="<?php echo $pageCdn;?>" data-app-skin="<?php echo $skin;?>" data-country="<?php echo $this->session->userdata('pais') ?>">
<header id="head">

    <div id="head-wrapper">
        <a id="<?= ($skin === 'latodo' || $skin === 'pichincha') ? 'brand-id' : 'brand-app' ?>" rel="start">
        </a>
        <?php if($menuHeaderActive){?>
            {menuHeader}
        <?php };?>
		</div>
</header>
