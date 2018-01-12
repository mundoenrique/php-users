<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="utf-8" />
    <title>{titlePage}</title>
    <meta name="viewport" content="width=device-width" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="googlebot" content="none" />
    <?php
    foreach ($styleSheets as $css) {
        echo insert_css_cdn($css['url'], $css['media']);
        echo "\n";
    }
    echo insert_js_cdn('html5.js');	?>
</head>
<?php
$CI =& get_instance();
$pageClass = isset($bodyclass) ? 'class="' . $bodyclass . '"' : '';
$pageUrl = $CI->config->item('base_url');
$pageCdn = $CI->config->item('base_url_cdn');
$skin = $CI->input->cookie($CI->config->item('cookie_prefix') . '_skin');
?>
<body <?php echo $pageClass;?> data-app-url="<?php echo $pageUrl;?>" data-app-cdn="<?php echo $pageCdn;?>">
<header id="head">
    <div id="head-wrapper">
        <a id="<?= ($skin === 'latodo') ? 'brand-id' : 'brand-app' ?>" rel="start">
        </a>
        <?php if($menuHeaderActive){?>
            {menuHeader}
        <?php };?>
    </div>
</header>
