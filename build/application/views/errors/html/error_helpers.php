<?php

$skins = ['default', 'pichincha'];
$currentSkin = 'tebca';
$CI =& get_instance();

if (isset($_COOKIE['cpo_skin']) && in_array($_COOKIE['cpo_skin'], $skins)) {
	$currentSkin = $_COOKIE['cpo_skin'] !== 'default'
		? $_COOKIE['cpo_skin'] : $currentSkin;
} else {
	setcookie('cpo_skin', 'default', 0, '/', $_SERVER['SERVER_NAME'], TRUE, TRUE);
}

define('SKIN', $currentSkin);

$favicon_ext = (SKIN === 'pichincha') ? 'ico' : 'png';
$favicon = ASSET_URL . 'img/favicon.' . $favicon_ext;

function NOVO_insert_js_cdn($filename = '') {

	$fileurl = ASSET_URL . 'js/default/' . $filename;
	$filepath = ASSET_PATH . 'js/default/' . $filename;
	$version = '';

	if (file_exists($filepath)) {
		$version = '?v=' . date('Ymd-B', filemtime($filepath));
	}

	$js = '<script src="' . $fileurl . $version . '" type="text/javascript"></script>' . "\n";

	return $js;
}

function NOVO_insert_css_cdn($filename = '', $media = 'screen') {
	$skin_folder  = SKIN . '/';
	$fileurl = ASSET_URL . 'css/' . $skin_folder .  $filename;
	$filepath = ASSET_PATH . 'css/' . $skin_folder .  $filename;
	$version = '';

	if (file_exists($filepath)) {
		$version = '?v=' . date('Ymd-B', filemtime($filepath));
	}

	$css = '<link href="' . $fileurl . $version .  '" media="' . $media . '" rel="stylesheet" type="text/css" />' . "\n";

	return $css;
}

