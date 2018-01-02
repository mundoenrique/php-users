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
	function np_Hoplite_Encryption($data, $keyId = 1)
	{
		$CI =& get_instance();

		$dataB = base64_encode($data);
		$iv = "\0\0\0\0\0\0\0\0";

		while( (strlen($dataB)%8) != 0) {
			$dataB .= " ";
		}

		if ($keyId == 1) {
			$cryptData = mcrypt_encrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $dataB, MCRYPT_MODE_CBC, $iv);
		} else {
			$cryptData = mcrypt_encrypt(MCRYPT_DES, $CI->config->item('keyNovo'), $dataB, MCRYPT_MODE_CBC, $iv);
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
	function np_Hoplite_Decrypt($cryptDataBase64, $keyId = 1)
	{
		$CI =& get_instance();

		$dataB = base64_decode($cryptDataBase64);
		$iv = "\0\0\0\0\0\0\0\0";

		if ($keyId == 1) {
			$decryptData = @mcrypt_decrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $dataB, MCRYPT_MODE_CBC, $iv);
		} else {
			$decryptData = @mcrypt_decrypt(MCRYPT_DES, $CI->config->item('keyNovo'), $dataB, MCRYPT_MODE_CBC, $iv);
		}

		return base64_decode(trim($decryptData));
	}
}
