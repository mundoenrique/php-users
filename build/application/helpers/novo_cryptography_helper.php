<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * NOVOPAYMENT cryptography Helpers
 *
 * @subpackage	Helpers
 * @category		Helpers
 * @author			J. Enrique Peñaloza P
 * @date				October 1st, 2022
 */
if (!function_exists('decryptData')) {
	function decryptData($requestData) {
		$CI = get_instance();

		if (ACTIVE_SAFETY) {
			$req = json_decode(base64_decode($requestData));
			$requestData = $CI->cryptography->decrypt(base64_decode($req->plot), utf8_encode($req->data));
		} else {
			$requestData = utf8_encode($requestData);
		}

		return $CI->security->xss_clean(strip_tags($requestData));
	}
}

if (!function_exists('encryptData')) {
	function encryptData($responseData) {
		$CI = get_instance();

		$responseData = [
			'response' => $responseData,
			'traslate' => ACTIVE_SAFETY,
		];

		if (ACTIVE_SAFETY) {
			$responseData['response'] = base64_encode(
				json_encode($CI->cryptography->encrypt($responseData['response']), JSON_UNESCAPED_UNICODE)
			);
		}

		return json_encode($responseData, JSON_UNESCAPED_UNICODE);
	}
}
