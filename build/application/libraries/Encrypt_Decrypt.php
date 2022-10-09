<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para la comunicación con los servicios y APIs
 * @author J. Enrique Peñaloza Piñero
 */
class Encrypt_Decrypt
{
	private $CI;
	private $logMessage;

	public function __construct()
	{
		log_message('INFO', 'NOVO Encrypt_Decrypt Library Class Initialized');

		$this->CI = &get_instance();
		$this->logMessage = new stdClass();
	}

	public function encryptCoreServices($request, $model)
	{
		log_message('INFO', 'NOVO Encrypt_Decrypt: encryptCoreServices method Initialized');
		$request->requestBody = json_encode($request->requestBody, JSON_UNESCAPED_UNICODE);

		log_message('DEBUG', 'REQUEST ' . $model . ': ' . $request->requestBody);

		if (API_GEE_WAY) {
		}

		return $request;
	}

	public function decryptCoreServices($response)
	{
		log_message('INFO', 'NOVO Encrypt_Decrypt: decryptCoreServices method Initialized');

		if (API_GEE_WAY && $response->data !== 'No data') {
		}

		log_message('DEBUG', 'RC: ' . $response->rc . ' RESPONSE ' . json_encode($response, CURLINFO_HTTP_CODE));

		return $response;
	}
}
