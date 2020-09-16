<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * NOVOPAYMENT toolset Helpers
 *
 * @subpackage	Helpers
 * @category		Helpers
 * @author			J. Enrique Peñaloza P
 * @date				Novembre 23th, 2019
 */
if (!function_exists('assetPath')) {
	function assetPath($route = '') {
		return get_instance()->config->item('asset_path').$route;
	}
}

if (!function_exists('assetUrl')) {
	function assetUrl($route = '') {
		return get_instance()->config->item('asset_url').$route;
	}
}

if (!function_exists('clientUrlValidate')) {
	function clientUrlValidate($client) {
		$allClients = ['default', 'pichincha'];
		$CI = &get_instance();
		$accessUrl = $CI->config->item('access_url');
		array_walk($accessUrl, 'arrayTrim');
		reset($accessUrl);

		if(!in_array($client, $accessUrl)) {
			$client = current($accessUrl);
			redirect(base_url($client.'/inicio'), 'location', 301);
		}

		if (in_array($client, $accessUrl)) {
			switch ($client) {
				case 'default':
					redirect(base_url(), 'location', 301);
				break;
				case 'pichincha':
					redirect(base_url('pichincha/home'), 'location', 301);
				break;
			}
		}

		$CI->config->load('config-'.$client);
	}
}

if (!function_exists('arrayTrim')) {
	function arrayTrim(&$value) {
		$value = trim($value);

		return $value;
	}
}

if (!function_exists('clearSessionVars')) {
	function clearSessionsVars() {
		$CI = &get_instance();

		foreach ($CI->session->all_userdata() AS $pos => $sessionVar) {
			if ($pos == '__ci_last_regenerate') {
				continue;
			}

			$CI->session->unset_userdata($pos);
		}
	}
}

if (!function_exists('accessLog')) {
	function accessLog($dataAccessLog) {
		$CI = &get_instance();

		return $accessLog = [
			"sessionId"=> $CI->session->userdata('sessionId') ?: '',
			"userName" => $CI->session->userdata('userName') ?: $dataAccessLog->userName,
			"canal" => $CI->config->item('channel'),
			"modulo"=> $dataAccessLog->modulo,
			"function"=> $dataAccessLog->function,
			"operacion"=> $dataAccessLog->operation,
			"RC"=> 0,
			"IP"=> $CI->input->ip_address(),
			"dttimesstamp"=> date('m/d/Y H:i'),
			"lenguaje"=> strtoupper(LANGUAGE)
		];
	}
}

if (!function_exists('maskString')) {
	function maskString($string, $start = 1, $end = 1, $type = NULL) {
		$type = $type ? $type : '';
		$length = strlen($string);

		return substr($string, 0, $start).str_repeat('*', 3).$type.str_repeat('*', 3).substr($string, $length - $end, $end);
	}
}

if (!function_exists('languageLoad')) {
	function languageLoad($call, $class) {
		$CI = &get_instance();
		$languagesFile = [];
		$loadLanguages = FALSE;
		$pathLang = APPPATH.'language'.DIRECTORY_SEPARATOR.$CI->config->item('language').DIRECTORY_SEPARATOR;
		$class = lcfirst(str_replace('Novo_', '', $class));
		log_message('INFO', 'NOVO Language '.$call.', HELPER: Language Load Initialized for class: '.$class);

		if ($call == 'specific') {
			if (file_exists($pathLang.'general_lang.php')) {
				array_push($languagesFile, 'general');
				$loadLanguages = TRUE;
			}

			if (file_exists($pathLang.'validate_lang.php')) {
				array_push($languagesFile, 'validate');
				$loadLanguages = TRUE;
			}

			if (file_exists($pathLang.'config-core_lang.php')) {
				array_push($languagesFile, 'config-core');
				$loadLanguages = TRUE;
			}
		}

		if (file_exists($pathLang.$class.'_lang.php')) {
			array_push($languagesFile, $class);
			$loadLanguages = TRUE;
		}

		if ($loadLanguages) {
			$CI->lang->load($languagesFile);
		}
	}
}

if (!function_exists('setCurrentPage')) {
	function setCurrentPage($currentClass, $menu) {
		$cssClass = '';
		switch ($currentClass) {
			case 'Novo_Business':
				if($menu == lang('GEN_MENU_CARDS_LIST')) {
					$cssClass = 'page-current';
				}
				break;
			case 'Novo_Payments':
				if($menu == lang('GEN_MENU_PAYS_TRANSFER')) {
					$cssClass = 'page-current';
				}
				break;
			case 'Novo_Reports':
				if($menu == lang('GEN_MENU_REPORTS')) {
					$cssClass = 'page-current';
				}
				break;
			case 'Novo_CustomerSupport':
				if($menu == lang('GEN_MENU_CUSTOMER_SUPPORT')) {
					$cssClass = 'page-current';
				}
				break;
		}

		return $cssClass;
	}
}


if (!function_exists('exportFile')) {
	function exportFile($file, $typeFile, $filename, $bytes = TRUE) {
		switch ($typeFile) {
			case 'pdf':
				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename='.$filename.'.pdf');
				header('Pragma: no-cache');
				header('Expires: 0');
				break;
			case 'xls':
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename='.$filename.'.xls');
				header('Pragma: no-cache');
				header('Expires: 0');
				break;
			case 'xlsx':
				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename='.$filename.'.xlsx');
				header('Pragma: no-cache');
				header('Expires: 0');
				break;
		}

		if ($bytes) {
			foreach ($file as $chr) {
				echo chr($chr);
			}
		} else {
			echo $file;
		}
	}
}

if (!function_exists('convertDate')) {
	function convertDate($date) {
		$date = explode('/', $date);
		$date = $date[2].'-'.$date[1].'-'.$date[0];

		return $date;
	}
}

if (!function_exists('convertDateMDY')) {
	function convertDateMDY($date) {
		$date = explode('/', $date);
		$date = $date[1].'/'.$date[0].'/'.$date[2];

		return $date;
	}
}

if (!function_exists('mainMenu'))
{
	function mainMenu() {
		return [
			'CARDS_LIST' => [],
			'PAYS_TRANSFER' => [
				'BETWEEN_CARDS' => [],
				'BANKS' => [],
				'CREDIT_CARDS' => [],
				'SERVICES' => [
					'TELEPHONY' => []
				]
			],
			'CUSTOMER_SUPPORT' => [],
			'REPORTS' => []
		];
	}
}

if (!function_exists('normalizeName')) {
	function normalizeName($name) {
		$pattern = [
			'/\s/',
			'/á/', '/à/', '/ä/', '/â/', '/ª/', '/Á/', '/À/', '/Â/', '/Ä/',
			'/é/', '/è/', '/ë/', '/ê/', '/É/', '/È/', '/Ê/', '/Ë/',
			'/í/', '/ì/', '/ï/', '/î/', '/Í/', '/Ì/', '/Ï/', '/Î/',
			'/ó/', '/ò/', '/ö/', '/ô/', '/Ó/', '/Ò/', '/Ö/', '/Ô/',
			'/ú/', '/ù/', '/ü/', '/û/', '/Ú/', '/Ù/', '/Û/', '/Ü/',
			'/ñ/', '/Ñ/', '/ç/', '/Ç/'
		];
		$replace = [
			'_',
			'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
			'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
			'i', 'i', 'i', 'i', 'i', 'i', 'i', 'i',
			'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
			'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
			'n', 'N', 'c', 'C'
		];
		return preg_replace($pattern, $replace, mb_strtolower(trim($name)));
	}
}

if (!function_exists('transformDate')) {
	function transformDate($date) {
		$date = explode('/', $date);
		$date = implode(' ', $date);
		$pattern = [
			'/ 01/',	'/ 02/', '/ 03/', '/ 04/', '/ 05/', '/ 06/', '/ 07/', '/ 08/', '/ 09/', '/ 10/',	'/ 11/', '/ 12/'
		];
		$replace = [
			' Ene', ' Feb', ' Mar', ' Abr', ' May', ' Jun', ' Jul', ' Ago', ' Sep', ' Oct', ' Nov', ' Dic'
		];

		return preg_replace($pattern, $replace, mb_strtolower(trim($date)));
	}
}
