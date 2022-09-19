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

		writeLog('DEBUG', 'REQUEST ' . $model . ': ' . json_encode($request, JSON_UNESCAPED_UNICODE));

		return $request;
	}

	public function decryptCoreServices($response)
	{
		log_message('INFO', 'NOVO Encrypt_Decrypt: decryptCoreServices method Initialized');

		return $response;
	}
}
