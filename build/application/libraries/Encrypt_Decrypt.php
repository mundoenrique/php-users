<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para la comunicación con los servicios y APIs
 * @author J. Enrique Peñaloza Piñero
 */
class Encrypt_Decrypt
{
	private $CI;
	private $iv;
	private $keyAES256;
	private $ivAES256;

	public function __construct()
	{
		writeLog('INFO', 'Encrypt_Decrypt Library Class Initialized');

		$this->CI =& get_instance();
		$this->iv = "\0\0\0\0\0\0\0\0";
		$this->keyAES256 = base64_decode(KEY_AES256);
		$this->ivAES256 = base64_decode(IV_AES256);
	}

	public function encryptWebServices($request) {
		writeLog('INFO', 'Encrypt_Decrypt: encode Method Initialized');

		$dataB = base64_encode($request);

		while ((strlen($dataB) % 8) !== 0) {
			$dataB .= " ";
		}

		$keyNovo = $this->CI->session->has_userdata('userId')
			?  base64_decode($this->CI->session->encryptKey)
			: WS_KEY;

		$cryptData = mcrypt_encrypt(
			MCRYPT_DES,
			$keyNovo,
			$dataB,
			MCRYPT_MODE_CBC,
			$this->iv
		);

		return base64_encode($cryptData);
	}

	public function decryptWebServices($response) {
		writeLog('INFO', 'Encrypt_Connect: decryptWebServices Method Initialized');

		if ($response->data !== NULL) {
			$data = base64_decode($response->data);
			$this->keyNovo = $this->CI->session->has_userdata('userId')
				?  base64_decode($this->CI->session->encryptKey)
				: WS_KEY;

			$descryptData = mcrypt_decrypt(
				MCRYPT_DES,
				$this->keyNovo,
				$data,
				MCRYPT_MODE_CBC,
				$this->iv
			);

			$decryptData = base64_decode(trim($descryptData));
			$response->data = json_decode($decryptData);
		}

		return $response;
	}

	public function encryptCoreServices($request)
	{
		writeLog('INFO', 'Encrypt_Decrypt: encryptCoreServices method Initialized');

		return $request;
	}

	public function decryptCoreServices($response)
	{
		writeLog('INFO', 'Encrypt_Decrypt: decryptCoreServices method Initialized');

		return $response;
	}
}
