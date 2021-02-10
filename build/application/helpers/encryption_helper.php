<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('np_hoplite_Encryption'))
{
	/**
	 * [np_Hoplite_Encryption description]
	 * @param  [type] $data
	 * @return [type]
	 */
	function np_Hoplite_Encryption($data, $keyId = 1, $service = FALSE)
	{
		$CI =& get_instance();
		if($service) {
			$userName = $CI->session->userdata('userName') ? $CI->session->userdata('userName') : 'NO USERNAME';
			log_message('DEBUG', '['. $userName .'] REQUEST ' . $service . ': ' . $data);
		}

		$dataB = base64_encode($data);
		$iv = "\0\0\0\0\0\0\0\0";

		while( (strlen($dataB)%8) != 0) {
			$dataB .= " ";
		}

		if ($keyId == 1) {
			$cryptData = @mcrypt_encrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $dataB, MCRYPT_MODE_CBC, $iv);
		} else {
			$cryptData = @mcrypt_encrypt(MCRYPT_DES, WS_KEY, $dataB, MCRYPT_MODE_CBC, $iv);
		}

		return base64_encode($cryptData);
	}
}

if ( ! function_exists('np_hoplite_Decrypt'))
{
	/**
	 * [np_Hoplite_Decrypt description]
	 * @param  [type] $cryptDataBase64
	 * @return [type]
	 */
	function np_Hoplite_Decrypt($cryptDataBase64, $keyId = 1, $service = FALSE)
	{
		$CI =& get_instance();
		$userName = $CI->session->userdata('userName') ? $CI->session->userdata('userName') : 'NO USERNAME';
		$dataB = base64_decode($cryptDataBase64);
		$iv = "\0\0\0\0\0\0\0\0";

		if ($keyId == 1) {
			$decryptData = @mcrypt_decrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $dataB, MCRYPT_MODE_CBC, $iv);
		} else {
			$decryptData = @mcrypt_decrypt(MCRYPT_DES, WS_KEY, $dataB, MCRYPT_MODE_CBC, $iv);
		}
		$decryptData = base64_decode(trim($decryptData));
		$response = json_decode($decryptData);
		if($service) {
			$rc = isset($response->rc) ? ' RC: '.$response->rc : '';
			$msg = isset($response->msg) ? ' MSG: '.$response->msg : '';
			$country = isset($response->pais) ? ' COUNTRY: '.$response->pais : '';
			$userName = $CI->session->userdata('userName') != '' ? $CI->session->userdata('userName') : 'NO USERNAME';

			log_message('DEBUG', '['.$userName.'] RESPONSE: '. $service . $rc . $msg . $country);
		}

		return $decryptData;
	}
}
