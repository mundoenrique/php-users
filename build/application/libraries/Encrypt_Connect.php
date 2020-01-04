<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para el cifrtado y descifrado de datos
 * @author J. Enrique Peñaloza Piñero
 */
class Encrypt_Connect {
	private $CI;
	private $userName;
	private $countryConf;
	private $iv;
	private $keyNovo;

	public function __construct()
	{
		log_message('INFO', 'NOVO Encrypt_Connect Library Class Initialized');
		$this->CI = &get_instance();
		$this->keyNovo = $this->CI->config->item('keyNovo');
		$this->iv = "\0\0\0\0\0\0\0\0";
	}
	/**
	 * @info método para cifrar las petiones al servicio
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function encode($data, $userName, $model) {
		log_message('INFO', 'NOVO Encrypt_Connect: encode Method Initialized');

		$this->keyNovo = is_null($this->CI->session->userdata('userName'))? $this->keyNovo: base64_decode($this->CI->session->userdata('keyId'));

		if($model !== 'REMOTE_ADDR') {
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		}
		log_message('DEBUG', 'NOVO encode ['.$userName.'] REQUEST '.$model.': '.$data);

		$dataB = base64_encode($data);
		while((strlen($dataB)%8) != 0) {
			$dataB .= " ";
		}

		$cryptData = mcrypt_encrypt(
			MCRYPT_DES, $this->keyNovo, $dataB, MCRYPT_MODE_CBC, $this->iv
		);

		return base64_encode($cryptData);
	}
	/**
	 * @info método para descifrar las respuesta al servicio
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function decode($cryptData, $userName, $model)
	{
		log_message('INFO', 'NOVO Encrypt_Connect: decode Method Initialized');
		$data = base64_decode($cryptData);

		$this->keyNovo = is_null($this->CI->session->userdata('userName'))? $this->keyNovo: base64_decode($this->CI->session->userdata('keyId'));

		$descryptData = mcrypt_decrypt(
			MCRYPT_DES, $this->keyNovo, $data, MCRYPT_MODE_CBC, $this->iv
		);
		$decryptData = base64_decode(trim($descryptData));
		$response = json_decode($decryptData);

		if(!$response) {
			log_message('ERROR', 'NOVO decode ['.$userName.'] Sin respuesta del servicio');
			$response = new stdClass();
			$response->rc = lang('RESP_RC_DEFAULT');
			$response->msg = lang('RESP_MESSAGE_SYSTEM');
		}

		if(!isset($response->pais)) {
				log_message('DEBUG', 'NOVO ['.$userName.'] Insertando pais al RESPONSE');
				$response->pais = $this->CI->config->item('country');
		}

		$this->logMessage = $response;
		$this->logMessage->model = $model;
		$this->logMessage->userName = $userName;
		$this->writeLog($this->logMessage);

		return $response;
	}
	/**
	 * @info método para realizar la petición al servicio
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function connectWs($request, $userName, $model)
	{
		$fail = FALSE;
		log_message('INFO', 'NOVO Encrypt_Connect: connectWs Method Initialized');

		$urlWS = $this->CI->config->item('urlWS').'movilsInterfaceResource';

		log_message('DEBUG', 'NOVO ['.$userName.'] REQUEST BY COUNTRY: '.$request['pais'].', AND WEBSERVICE URL: '.$urlWS);

		$requestSerV = json_encode($request);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $urlWS);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestSerV);
		curl_setopt($ch, CURLOPT_TIMEOUT, 59);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			               'Content-Type: text/plain',
			               'Content-Length: ' . strlen($requestSerV))
		);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$curlError = curl_error($ch);
		curl_close($ch);

		log_message('DEBUG','NOVO ['.$userName.'] RESPONSE CURL HTTP CODE: ' . $httpCode);

		if ($httpCode !== 200 || !$response){
			log_message('ERROR','NOVO ['.$userName.'] ERROR CURL: ' . json_encode($curlError)?:'none');
			$failResponse = new stdClass();
			$failResponse->rc = lang('RESP_DEFAULT_CODE');
			$failResponse->msg = lang('RES_MESSAGE_SYSTEM');
			$response = $failResponse;
			$fail = TRUE;
		}

		if ($fail){
			$this->logMessage = $failResponse;
			$this->logMessage->userName = $userName;
			$this->logMessage->model = $model;
			$this->logMessage->pais = $request['pais'];

			$this->writeLog($this->logMessage);
		}

		return json_decode($response);
	}

	/**
	 * @info Método para es cribir el log de la respuesta del servicio
	 * @author J. Enrique Peñaloza Piñero
	 * @date October 25th, 2019
	 */
	private function writeLog($logMessage)
	{
		$userName = $logMessage->userName;
		$model = $logMessage->model;
		$msg = @$logMessage->msg || '';
		$rc = $logMessage->rc;
		$country = $logMessage->pais;
		log_message('DEBUG', 'NOVO ['.$userName.'] RESPONSE '.$model.'= rc: '.$rc.', msg: '.$msg.', country: '.$country);
	}
}
