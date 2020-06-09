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

if (!function_exists('getFavicon')) {
	function getFavicon($countryUri) {
		$CI = &get_instance();
		$favicon = $CI->config->item('favicon');
		switch($countryUri) {
			case 'bnt':
				$ext = 'ico';
			break;
			case 'pb':
				$ext = 'ico';
			break;
			default:
				$ext = 'png';
		}

		$faviconLoader = new stdClass();
		$faviconLoader->favicon = $favicon;
		$faviconLoader->ext = $ext;

		return $faviconLoader;
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
	function languageLoad($call, $client = 'default_lang', $langFiles = FALSE) {
		$CI = &get_instance();
		$class = $CI->router->fetch_class();
		$langFiles = $langFiles ?: $CI->router->fetch_method();
		$languagesFile = [];
		$lanGeneral = ['bnt'];
		$langConfig = ['bnt'];
		$loadLanguages = FALSE;
		$client = !$client ? 'default_lang' : $client;
		log_message('INFO', 'NOVO Language '.$call.', HELPER: Language Load Initialized for controller: '.$class. ' and method: '.$langFiles);

		switch($client) {
			case 'bp':
				$languages = [
				];
				break;
			case 'bdb':
				$languages = [
				];
				break;
			case 'bnt':
				$languages = [
					'signin' => ['login'],
					'userIdentify' => ['terms'],
				];
				break;
			case 'co':
				$languages = [
				];
				break;
			case 'pe':
				$languages = [
				];
				break;
			case 'us':
				$languages = [
				];
				break;
			case 've':
				$languages = [
				];
				break;
			case 'pb':
				$languages = [
				];
				break;
			default:
				$languages = [
					'signin' => ['login'],
					'userIdentify' => ['terms'],
					'accessRecover' => ['recover'],
					'changePassword' => ['user'],
					'userCardsList' => ['cards'],
					'cardDetail' => ['business'],
				];
		}

		if (array_key_exists($langFiles, $languages)) {
			$languagesFile = $languages[$langFiles];
			$loadLanguages = TRUE;
		}

		if (in_array($client, $lanGeneral)) {
			array_unshift($languagesFile, 'general');
			$loadLanguages = TRUE;
		}

		if (in_array($client, $langConfig)) {
			array_unshift($languagesFile, 'config-core');
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

if (!function_exists('arrayTrim')) {
	function arrayTrim(&$value) {
		$value = trim($value);

		return $value;
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
			'REPORTS' => [],
			'CUSTOMER_SUPPORT' => []
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
