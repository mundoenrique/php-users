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
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="none" />
		<link rel="icon" type="image/png"  href="<?php echo $pageCdn;?>img/favicon<?php echo $extension;?>" />
    <?php
			$cookie = $this->input->cookie($this->config->item('cookie_prefix').'skin');
			if($this->router->class != 'service' && $cookie == 'pichincha') {
				echo insert_css_cdn('base.css', 'screen');
			}
			foreach ($styleSheets as $css) {
					echo insert_css_cdn($css['url'], $css['media']);
					echo "\n";
			}
			echo insert_js_cdn('html5.js');
		?>
</head>
<body <?php echo $pageClass;?> data-app-url="<?php echo $pageUrl;?>" data-app-cdn="<?php echo $pageCdn;?>" data-country="<?php echo $this->session->userdata('pais') ?>">
<header id="head">

    <div id="head-wrapper">
        <a id="<?= ($skin === 'latodo' || $skin === 'pichincha') ? 'brand-id' : 'brand-app' ?>" rel="start">
        </a>
        <?php if($menuHeaderActive){?>
            {menuHeader}
        <?php };?>
		</div>
</header>
