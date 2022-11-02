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

	public function encryptWebServices($request)
	{
		writeLog('INFO', 'Encrypt_Decrypt: encryptWebServices Method Initialized');

		if (ENVIRONMENT === 'development') {
			error_reporting(E_ALL & ~E_DEPRECATED);
		}

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

	public function decryptWebServices($response)
	{
		writeLog('INFO', 'Encrypt_Decrypt: decryptWebServices Method Initialized');

		if (ENVIRONMENT === 'development') {
			error_reporting(E_ALL & ~E_DEPRECATED);
		}

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

	function aesCryptography($data, $encrip = TRUE)
	{
		writeLog('INFO', 'Encrypt_Decrypt: aesCryptography Method Initialized');

		$encrypt_method = "AES-256-CBC";
		$output = NULL;

		if ($encrip) {
			$output = openssl_encrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
		} else {
			$output = openssl_decrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
		}

		return $output;
	}

	function generateArgon2Hash($payload)
	{
		writeLog('INFO', 'Encrypt_Decrypt: generateArgon2Hash Method Initialized');

		$hash = sodium_crypto_pwhash(
			ARGON2_LENGTH,
			$payload,
			hex2bin(ARGON2_SALT),
			ARGON2_OPS_LIMIT,
			ARGON2_MEMORY_LIMIT,
			SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
		);
		$output = new stdClass();
		$output->hashArgon2 =  unpack("C*", $hash);
		$output->hexArgon2 =  bin2hex($hash);

		return $output;
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
