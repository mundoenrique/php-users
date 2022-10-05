<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * NOVOPAYMENT server Helpers
 *
 * @subpackage	Helpers
 * @category		Helpers
 * @author			J. Enrique Peñaloza P
 * @date				September 19th, 2022
 */

if (!function_exists('writeLog')) {
	function writeLog($level, $message) {
		$CI = get_instance();
		$appUserName = '';
		$customer = '';
		$ip = $CI->input->ip_address();
		$level = mb_strtoupper($level);

		if ($CI->session->has_userdata('userName')) {
			$appUserName = $CI->session->userName;
		} elseif ($CI->input->post('userName') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('userName'));
		} elseif ($CI->input->post('idNumber') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('idNumber'));
		} elseif ($CI->input->post('documentId') !== NULL)	{
			$appUserName = mb_strtoupper($CI->input->post('documentId'));
		}

		if ($CI->session->has_userdata('customerSess')) {
			$customer = $CI->session->customerSess;
		} elseif ($CI->config->item('customer') !== NULL) {
			$customer = $CI->config->item('customer');
		}

		if ($level === 'INFO') {
			$message = novoLang('NOVO %s', $message);
		} elseif ($customer === '') {
			$message = novoLang('NOVO [' . $appUserName . '] IP: %s, %s', [$ip, $message]);
		} else {
			$message = novoLang('NOVO [' . $appUserName . '] IP: %s, CUSTOMER: %s, %s', [$ip, $customer, $message]);
		}

		log_message($level, $message);
	}
}

// generar uuIdV4
if (! function_exists('uuIdV4Generate')) {
	function uuIdV4Generate() {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}
}

// Maneja respuesta del servicio
if (! function_exists('responseServer')) {
	function responseServer($responseServer) {
		$code = explode('.', $responseServer->code);

		switch ($responseServer->HttpCode) {
			case 200:
				$responseServer->rc = 0;
				break;

			case 502:
				$responseServer->rc = 502;
				break;

			case 504:
				$responseServer->rc = 504;
				break;

			default:
				$responseServer->rc = $code[2] ?? $code[0];
		}

		if ($responseServer->errorNo === 28) {
			$responseServer->rc = 504;
		}

		return $responseServer;
	}
}
