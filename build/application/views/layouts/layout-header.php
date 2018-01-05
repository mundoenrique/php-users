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
<body <?php if(isset($bodyclass)){echo 'class="'.$bodyclass.'"'; }?> >
<header id="head">
    <div id="head-wrapper">
        <?php
        $CI =& get_instance();
        $skin = $CI->input->cookie('cpo_skin');
        ?>
        <a id="<?= ($skin === 'latodo') ? 'brand-id' : 'brand-app' ?>" rel="start">
        </a>
        <?php if($menuHeaderActive){?>
            {menuHeader}
        <?php };?>
    </div>
</header>
