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
		writeLog('INFO', 'Encrypt_Decrypt Library Class Initialized');

		$this->CI = &get_instance();
		$this->logMessage = new stdClass();
	}

	public function encryptCoreServices($request, $model)
	{
		writeLog('INFO', 'Encrypt_Decrypt: encryptCoreServices method Initialized');
		$request->requestBody = json_encode($request->requestBody, JSON_UNESCAPED_UNICODE);

		writeLog('DEBUG', 'REQUEST ' . $model . ': ' . $request->requestBody);

		if (API_GEE_WAY === 'ON') {
		}

		return $request;
	}

	public function decryptCoreServices($response)
	{
		writeLog('INFO', 'Encrypt_Decrypt: decryptCoreServices method Initialized');

		$response->info->data = $response->info->data ?? 'NO DATA';

		if (API_GEE_WAY === 'ON' && $data !== 'NO DATA') {
		}

		writeLog('DEBUG', 'RC: ' . $response->rc . ' RESPONSE ' . json_encode($response, CURLINFO_HTTP_CODE));

		return $response;
	}
}
