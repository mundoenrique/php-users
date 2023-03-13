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
		$this->CI =& get_instance();
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
		$fileUrl = NULL;
		$fileExt = '.css';

		foreach($this->cssFiles as $fileName) {
			$file = assetPath('css/' . $fileName . $fileExt);
			$file = $this->versionFiles($file, $fileName, $fileExt);
			$fileUrl .= '<link rel="stylesheet" href="'. assetUrl('css/' . $file) . '" media="all">' . PHP_EOL;
		}

		return $fileUrl;
	}
	/**
	 * @info Método para insertar archivos js en el documento
	 * @author J. Enrique Peñaloza Piñero.
	 */
	public function insertJs()
	{
		writeLog('INFO', 'Asset: insertJs method initialized');
		$fileUrl = NULL;
		$fileExt = '.js';

		foreach($this->jsFiles as $fileName) {
			$file = assetPath('js/' . $fileName . $fileExt);
			$file = $this->versionFiles($file, $fileName, $fileExt);
			$fileUrl .= '<script defer src="' . assetUrl('js/'. $file) . '"></script>' . PHP_EOL;
		}

		return $fileUrl;
	}
	/**
	 * @info Método para insertar imagenes, json, etc
	 * @author J. Enrique Peñaloza Piñero.
	 */
	public function insertFile($fileName, $folder = 'images', $customerUri = FALSE)
	{
		writeLog('INFO', 'Asset: insertFile method initialized');

		$customerUri = $customerUri ? $customerUri.'/' : '';
		$customerUri = tenantSameSettings($customerUri);
		$file = assetPath($folder . '/' . $customerUri.$fileName);

		if (!file_exists($file)) {
			$file = assetPath($folder . '/default' . '/' . $fileName);
			$customerUri = 'default/';
		}

		$version = '?V'.date('Ymd-U', filemtime($file));

		return assetUrl($folder . '/' . $customerUri . $fileName . $version);
	}
	/**
	 * @info Método para versionar archivos
	 * @author J. Enrique Peñaloza Piñero.
	 */
	private function versionFiles($file, $fileName, $fileExt)
	{
		$version = '';
		$thirdParty = strpos($fileName, 'third_party');
		$fileExists = TRUE;

		if(!file_exists($file)) {
			writeLog('ERROR', 'Archivo requerido ' . $fileName . $fileExt);
			$fileExists = FALSE;
		}

		if($thirdParty === FALSE && $fileExists) {
			$version = '?V' . date('Ymd-U', filemtime($file));
		} elseif ($fileExists) {
			$fileExt = '.min' . $fileExt;
		}

		return $fileName . $fileExt . $version;
	}
}
