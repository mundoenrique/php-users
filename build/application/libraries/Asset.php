<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para la inccorporación y versionamiento de los archivos css, js e imágenes
 * @author J. Enrique Peñaloza Piñero
 *
 */
class Asset {
	private $cssFiles;
	private $jsFiles;
	private $CI;

	public function __construct()
	{
		writeLog('INFO', 'Assets Library Class Initialized');

		$this->cssFiles = [];
		$this->jsFiles = [];
		$this->CI = &get_instance();
		$_SERVER['REMOTE_ADDR'] = $this->CI->input->ip_address();
	}
	/**
	 * @info Método para inicializar los atributos de la librería
	 * @author: J. Enrique Peñaloza Piñero.
	 */
	public function initialize($params = [])
	{
		writeLog('INFO', 'Asset: initialize method initialized');
		foreach($params as $arrayFiles => $file) {
			isset($this->$arrayFiles) ? $this->$arrayFiles = $file : '';
		}
	}
	/**
	 * @info Método para insertar archivos css en el documento
	 * @author: J. Enrique Peñaloza Piñero.
	 */
	public function insertCss()
	{
		writeLog('INFO', 'Asset: insertCss method initialized');
		$file_url = NULL;
		foreach($this->cssFiles as $fileName) {
			$file = assetPath('css/'.$fileName.'.css');

			if(!file_exists($file)) {
				$customerUri = $this->CI->config->item('customer-uri').'/';
				$rootCss = 't-'.$this->CI->config->item('customer-uri');
				$baseCss = $this->CI->config->item('customer-uri').'-';
				$search = [$customerUri, $rootCss, $baseCss];
				$replace = ['default/', 't-default', 'default-'];
				$file = str_replace($search, $replace, $file);
				$fileName = str_replace($search, $replace, $fileName);
			}

			$file = $this->versionFiles($file, $fileName, '.css');
			$file_url .= '<link rel="stylesheet" href="'.assetUrl('css/'.$file).'" media="all">'.PHP_EOL;
		}

		return $file_url;
	}
	/**
	 * @info Método para insertar archivos js en el documento
	 * @author J. Enrique Peñaloza Piñero.
	 */
	public function insertJs()
	{
		writeLog('INFO', 'Asset: insertJs method initialized');
		$file_url = NULL;

		foreach($this->jsFiles as $fileName) {
			$file = assetPath('js/'.$fileName.'.js');
			$file = $this->versionFiles($file, $fileName, '.js');
			$file_url .= '<script defer src="'.assetUrl('js/'.$file).'"></script>'.PHP_EOL;
		}

		return $file_url;
	}
	/**
	 * @info Método para insertar imagenes, json, etc
	 * @author J. Enrique Peñaloza Piñero.
	 */
	public function insertFile($fileName, $folder = 'images', $customerUri = FALSE)
	{
		writeLog('INFO', 'Asset: insertFile method initialized');

		$customerUri = $customerUri ? $customerUri.'/' : '';
		//eliminar despues de la certificación
		$customerUri = checkTemporalTenant($customerUri);
		$file = assetPath($folder.'/'.$customerUri.$fileName);

		if (!file_exists($file)) {
			$file = assetPath($folder.'/default'.'/'.$fileName);
			$customerUri = 'default/';
		}

		$version = '?V'.date('Ymd-U', filemtime($file));

		return assetUrl($folder.'/'.$customerUri.$fileName.$version);
	}
	/**
	 * @info Método para versionar archivos
	 * @author J. Enrique Peñaloza Piñero.
	 */
	private function versionFiles($file, $fileName, $ext)
	{
		$version = '';
		$thirdParty = strpos($fileName, 'third_party');

		if($thirdParty === FALSE && file_exists($file)) {
			$version = '?V'.date('Ymd-U', filemtime($file));
		} else {
			$ext = '.min'.$ext;
		}

		return $fileName.$ext.$version;
	}
}
