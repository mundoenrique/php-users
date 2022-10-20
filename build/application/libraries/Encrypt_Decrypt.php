<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para la comunicación con los servicios y APIs
 * @author J. Enrique Peñaloza Piñero
 */
class Encrypt_Decrypt
{
	private $CI;

	public function __construct()
	{
		writeLog('INFO', 'Encrypt_Decrypt Library Class Initialized');

		$this->CI =& get_instance();
	}

	public function encryptCoreServices($request, $model)
	{
		writeLog('INFO', 'Encrypt_Decrypt: encryptCoreServices method Initialized');
		$request->requestBody = json_encode($request->requestBody, JSON_UNESCAPED_UNICODE);

		writeLog('DEBUG', 'REQUEST ' . $model . ': ' . $request->requestBody);

		if (API_GEE_WAY) {
		}

		return $request;
	}

	public function decryptCoreServices($response)
	{
		writeLog('INFO', 'Encrypt_Decrypt: decryptCoreServices method Initialized');

		if (API_GEE_WAY && $response->data !== 'No data') {
		}

		writeLog('DEBUG', 'RC: ' . $response->rc . ' RESPONSE ' . json_encode($response, CURLINFO_HTTP_CODE));

		return $response;
	}
}
