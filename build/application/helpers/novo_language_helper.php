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
		$line = vsprintf($line, (array) $args);

		return $line;
	}
}

if (!function_exists('languageLoad')) {
	function LoadLangFile($call, $fileLanguage, $customerLang) {
		writeLog('INFO', 'Helper loaded: LanguageLoad_helper for ' . $call . ' files');

		$CI =& get_instance();
		$languagesFile = [];
		$loadLanguages = FALSE;
		$configLanguage = $CI->config->item('language');
		$customerLang = tenantSameSettings($customerLang);
		$pathLang = APPPATH . 'language' . DIRECTORY_SEPARATOR . $configLanguage . DIRECTORY_SEPARATOR;

		switch ($call) {
			case 'generic':
				if(file_exists($pathLang . 'settings_' . $customerLang . '_lang.php')) {
					$CI->lang->load('settings_' . $customerLang);
				}

				if(file_exists($pathLang . 'images_' . $customerLang . '_lang.php')) {
					$CI->lang->load('images_' . $customerLang);
				}

				if(file_exists($pathLang . 'regexp_' . $customerLang . '_lang.php')) {
					$CI->lang->load('regexp_' . $customerLang);
				}

				$CI->config->set_item('language', BASE_LANGUAGE . '-base');
				array_push($languagesFile, 'general', 'validate');
				$loadLanguages = TRUE;
				$pathLang = APPPATH . 'language' . DIRECTORY_SEPARATOR . BASE_LANGUAGE . '-base' . DIRECTORY_SEPARATOR;
				break;

				case 'specific':
					if (file_exists($pathLang . 'general_lang.php')) {
						array_push($languagesFile, 'general');
						$loadLanguages = TRUE;
					}

					if (file_exists($pathLang . 'validate_lang.php')) {
						array_push($languagesFile, 'validate');
						$loadLanguages = TRUE;
					}
					break;
		}

		if (file_exists($pathLang . $fileLanguage . '_lang.php')) {
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
		$baseLanguage = [
			'name' => 'baseLanguage',
			'value' => $language,
			'expire' => 0,
			'httponly' => TRUE
		];

		set_cookie($baseLanguage);
	}
}
