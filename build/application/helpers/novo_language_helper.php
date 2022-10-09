<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * NOVOPAYMENT Language Helpers
 *
 * @category	Helpers
 * @author		Enrique Peñaloza
 * @date			24/10/2019
 */

if (!function_exists('novoLang')) {
	function novoLang($line, $args = []) {
		log_message('INFO', 'NOVO Helper loaded: novoLang_helper');

		$line = vsprintf($line, (array) $args);

		return $line;
	}
}

if (!function_exists('languageLoad')) {
	function LoadLangFile($call, $fileLanguage, $customerUri = FALSE) {
		$CI = get_instance();
		$languagesFile = [];
		$loadLanguages = FALSE;
		$configLanguage = $CI->config->item('language');
		$pathLang = APPPATH.'language'.DIRECTORY_SEPARATOR.$configLanguage.DIRECTORY_SEPARATOR;

		$CI->config->set_item('language', 'global');

		log_message('INFO', 'NOVO Helper loaded: languageLoad_helper for ' . $call . ' files');

		switch ($call) {
			case 'generic':
				$CI->lang->load(['config-core', 'images']);
				break;
			case 'specific':
				$globalLan = APPPATH . 'language' . DIRECTORY_SEPARATOR . 'global' . DIRECTORY_SEPARATOR;
				//eliminar despues de la certificación
				$customerUri = checkTemporalTenant($customerUri);

				if(file_exists($globalLan.'config-core-'.$customerUri.'_lang.php')) {
					$CI->lang->load('config-core-'.$customerUri,);
				}

				if(file_exists($globalLan.'images_'.$customerUri.'_lang.php')) {
					$CI->lang->load('images_'.$customerUri);
				}
				break;
		}

		$CI->config->set_item('language', $configLanguage);

		if ($call === 'specific') {
			if (file_exists($pathLang.'general_lang.php')) {
				array_push($languagesFile, 'general');
				$loadLanguages = TRUE;
			}

			if (file_exists($pathLang.'validate_lang.php')) {
				array_push($languagesFile, 'validate');
				$loadLanguages = TRUE;
			}
		}

		if (file_exists($pathLang.$fileLanguage.'_lang.php')) {
			array_push($languagesFile, $fileLanguage);
			$loadLanguages = TRUE;
		}

		if ($loadLanguages) {
			$CI->lang->load($languagesFile);
		}
	}
}

if (!function_exists('languageCookie')) {
	function languageCookie($language) {
		log_message('INFO', 'Novo Helper loaded: languageCookie_helper');

		$baseLanguage = [
			'name' => 'baseLanguage',
			'value' => $language,
			'expire' => 0,
			'httponly' => TRUE
		];

		set_cookie($baseLanguage);
	}
}
