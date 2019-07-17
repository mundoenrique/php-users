<?php
function NOVO_insert_js_cdn($filename = '') {
	if (preg_match('/(testing|production)$/i', ENVIRONMENT) === 1 && strpos($filename, '.min.js') === false) {
		$filename = str_replace('.js', '.min.js', $filename);
	}

	$fileurl = BASE_CDN_URL . 'js/' . $filename;
	$filepath = BASE_CDN_PATH . 'js/' . $filename;
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
	if (preg_match('/(testing|production)$/i', ENVIRONMENT) === 1 && strpos($filename, '.min.css') === false) {
		$filename = str_replace('.css', '.min.css', $filename);
	}

	$fileurl = BASE_CDN_URL . 'css/' . $skin_folder .  $filename;
	$filepath = BASE_CDN_PATH . 'css/' . $filename;
	$version = '';
	if (file_exists($filepath)) {
		$version = '?v=' . date('Ymd-B', filemtime($filepath));
	}

	$css = '<link href="' . $fileurl . $version .  '" media="' . $media . '" rel="stylesheet" type="text/css" />' . "\n";
	return $css;
}
?>
