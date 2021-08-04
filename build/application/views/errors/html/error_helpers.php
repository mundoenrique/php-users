<?php
function NOVO_insert_js_cdn($filename = '') {

	$fileurl = ASSET_URL . 'js/' . $filename;
	$filepath = ASSET_PATH . 'js/' . $filename;
	$version = '';
	if (file_exists($filepath)) {
		$version = '?v=' . date('Ymd-B', filemtime($filepath));
	}

	$js = '<script src="' . $fileurl . $version . '" type="text/javascript"></script>' . "\n";
	return $js;
}

function NOVO_insert_css_cdn($filename = '', $media = 'screen') {
	$skin_folder = '';
	if (SKIN !== '') $skin_folder = SKIN . '/';

	$fileurl = ASSET_URL . 'css/' . $skin_folder .  $filename;
	$filepath = ASSET_PATH . 'css/' . $filename;
	$version = '';
	if (file_exists($filepath)) {
		$version = '?v=' . date('Ymd-B', filemtime($filepath));
	}

	$css = '<link href="' . $fileurl . $version .  '" media="' . $media . '" rel="stylesheet" type="text/css" />' . "\n";
	return $css;
}
?>
