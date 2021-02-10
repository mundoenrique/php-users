<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para el cifrtado y descifrado de datos
 * @author J. Enrique Peñaloza Piñero
 */
class Encrypt_Connect
{
	private $CI;
	private $userName;
	private $countryConf;
	private $iv;
	private $keyNovo;
	private $logMessage;
	private $keyAES256;
	private $ivAES256;
	public function __construct()
	{
		log_message('INFO', 'NOVO Encrypt_Connect Library Class Initialized');
		$this->CI = &get_instance();
		$this->iv = "\0\0\0\0\0\0\0\0";
		$this->logMessage = new stdClass();
		$this->keyAES256 = base64_decode(KEY_AES256);
		$this->ivAES256 = base64_decode(IV_AES256);

		if (ENVIRONMENT == 'development') {
			error_reporting(E_ALL & ~E_DEPRECATED);
		}
	}
	/**
	 * @info método para cifrar las petiones al servicio
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function encode($data, $userName, $model)
	{
		log_message('INFO', 'NOVO Encrypt_Connect: encode Method Initialized');
		if ($model !== 'REMOTE_ADDR') {
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		}
		log_message('DEBUG', 'NOVO [' . $userName . '] REQUEST ' . $model . ': ' . $data);
		$dataB = base64_encode($data);
		while ((strlen($dataB) % 8) != 0) {
			$dataB .= " ";
		}
		$this->keyNovo = $this->CI->session->has_userdata('userId') ?  base64_decode($this->CI->session->encryptKey) : WS_KEY;
		$cryptData = mcrypt_encrypt(
			MCRYPT_DES,
			$this->keyNovo,
			$dataB,
			MCRYPT_MODE_CBC,
			$this->iv
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
		$this->keyNovo = $this->CI->session->has_userdata('userId') ?  base64_decode($this->CI->session->encryptKey) : WS_KEY;
		$descryptData = mcrypt_decrypt(
			MCRYPT_DES,
			$this->keyNovo,
			$data,
			MCRYPT_MODE_CBC,
			$this->iv
		);
		$decryptData = base64_decode(trim($descryptData));
		$response = json_decode($decryptData);
		if (!$response) {
			log_message('ERROR', 'NOVO [' . $userName . '] NO SERVICE RESPONSE');
			$response = new stdClass();
			$response->rc = lang('GEN_RC_DEFAULT');
			$response->msg = lang('GEN_SYSTEM_MESSAGE');
		}
		if (!isset($response->pais)) {
			log_message('INFO', 'NOVO [' . $userName . '] INSERTING COUNTRY TO THE RESPONSE');
			$response->pais = $this->CI->config->item('country');
		}

		if (isset($response->bean)) {

			if (gettype($response->bean) == 'object' || gettype($response->bean) == 'array') {
				$response->bean = $response->bean;
			} elseif (gettype(json_decode($response->bean)) == 'object' || gettype(json_decode($response->bean)) == 'array') {
				$response->bean = json_decode($response->bean);
			} else {
				$response->bean = $response->bean;
			}

			$this->logMessage->inBean = ' IN BEAN';
		}

		foreach ($response AS $pos => $responseAttr) {
			switch ($pos) {
				case 'archivo':
					$this->logMessage->archivo = 'OK';

					if(!is_array($responseAttr)) {
						$this->logMessage->archivo = 'Sin arreglo binario';
					}
				break;
				case 'bean':
					$this->logMessage->bean = new stdClass();

					if (isset($responseAttr->archivo)) {
						$this->logMessage->bean->archivo = 'OK';

						if(!is_array($responseAttr->archivo)) {
							$this->logMessagebean->archivo = 'Sin arreglo binario';
						}
					} else {
						$this->logMessage->bean = $responseAttr;
					}
				break;
				case 'msg':
					$this->logMessage->msg = $responseAttr;
				break;
				default:
					$this->logMessage->$pos = $responseAttr;
			}
		}

		$this->logMessage->msg = $this->logMessage->msg ?? 'Sin mensaje del servicio';
		$this->logMessage->model = $model;
		$this->logMessage->userName = $userName;
		$this->writeLog($this->logMessage);

		return $response;
	}
	/**
	 * @info método para realizar la petición al servicio
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 13th, 2019
	 */
	public function connectWs($request, $userName, $model)
	{
		log_message('INFO', 'NOVO Encrypt_Connect: connectWs Method Initialized');
		$fail = FALSE;
		$subFix = '_' . strtoupper($this->CI->config->item('country-uri'));
		$wsUrl = $_SERVER['WS_URL'];

		if (isset($_SERVER['WS_URL' . $subFix])) {
			$wsUrl = $_SERVER['WS_URL' . $subFix];
		}

		log_message('DEBUG', 'NOVO [' . $userName . '] REQUEST BY COUNTRY: ' . $request['pais'] . ', AND WEBSERVICE URL: ' . $wsUrl);

		$requestSerV = json_encode($request, JSON_UNESCAPED_UNICODE);
		$start = microtime(true);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $wsUrl);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 58);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestSerV);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: text/plain',
			'Content-Length: ' . strlen($requestSerV)
		));
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$CurlError = curl_error($ch);
		$CurlErrorNo = curl_errno($ch);

		curl_close($ch);
		$final = microtime(true);
		$executionTime = round($final - $start, 2, PHP_ROUND_HALF_UP) ;

		log_message('DEBUG','NOVO ['.$userName.'] RESPONSE IN '. $executionTime .' sec CURL HTTP CODE: ' . $httpCode);

		if($httpCode != 200 || !$response) {
			$CurlError = novoLang('ERROR CURL NUMBER: %s, MESSAGE: %s ', [$CurlErrorNo, json_encode($CurlError, JSON_UNESCAPED_UNICODE)]);

			log_message('ERROR','NOVO ['.$userName.'] '.$CurlError);

			$failResponse = new stdClass();
			$failResponse->msg = lang('GEN_MESSAGE_SYSTEM');

			switch ($CurlErrorNo) {
				case 28:
					$failResponse->rc = 504;
					$failResponse->msg = lang('GEN_TIMEOUT');
				break;
				default:
					$failResponse->rc = lang('GEN_RC_DEFAULT');
			}

			switch ($httpCode) {
				case 502:
					$failResponse->rc = 502;
				break;
			}

			$response = $failResponse;
			$fail = TRUE;
		}

		if ($fail) {
			$this->logMessage = $failResponse;
			$this->logMessage->userName = $userName;
			$this->logMessage->model = $model;
			$this->logMessage->pais = $request['pais'];
			$this->writeLog($this->logMessage);
		}

		return gettype($response) == 'object' ? $response : json_decode($response);
	}
	/**
	 * @info método para enviar archivos al servidor de backend
	 * @author J. Enrique Peñaloza Piñero
	 * @date December113th, 2019
	 */
	public function moveFile($file, $userName, $model)
	{
		log_message('INFO', 'NOVO Encrypt_Connect: moveFile Method Initialized');
		$urlBulkService = $this->CI->config->item('url_bulk_service');
		$userpassBulk = $this->CI->config->item('userpass_bulk');
		$uploadBulk = $this->CI->config->item('upload_bulk');
		$respUpload = new stdClass;
		$respUpload->rc = 0;

		log_message('INFO', 'NOVO UPLOAD FILE BY: ' . $urlBulkService . ' AND: ' . $userpassBulk);

		$ch = curl_init();
		$Fclose = $fOpen = fopen($uploadBulk . $file, 'r');
		curl_setopt($ch, CURLOPT_URL, $urlBulkService . $file);
		curl_setopt($ch, CURLOPT_USERPWD, $userpassBulk);
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
		curl_setopt($ch, CURLOPT_INFILE, $fOpen);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($uploadBulk . $file));
		curl_exec($ch);
		$result = curl_errno($ch);

		log_message('DEBUG', 'NOVO [' . $userName . '] UPLOAD FILE BULK SFTP ' . $model . ': ' . $result . ' ' . lang('RESP_UPLOAD_SFTP(' . $result . ')'));

		if ($result != 0) {
			$respUpload->rc = -105;
		}

		curl_close($ch);
		fclose($Fclose);
		unlink($uploadBulk . $file);

		return $respUpload;
	}
	/**
	 * @info encripta/desencripta en base AES-256
	 * @author Pedro Torres
	 * @date Abril, 16th 2020
	 */
	public function cryptography($data, $encrip = TRUE)
	{
		log_message('INFO', 'NOVO Encrypt_Connect: cryptography Method Initialized');

		$encrypt_method = "AES-256-CBC";

		if ($encrip) {
			$output = openssl_encrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
		} else {
			$output = openssl_decrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
		}

		return $output;
	}
	/**
	 * @info Método para escribir el log de la respuesta del servicio
	 * @author J. Enrique Peñaloza Piñero
	 * @date October 25th, 2019
	 */
	private function writeLog($logMessage)
	{
		$model = &$logMessage->model;
		$userName = &$logMessage->userName;
		$country = &$logMessage->pais;
		unset($logMessage->userName, $logMessage->model, $logMessage->pais);

		$writeLog = novoLang('%s = rc: %s, msg: %s, client: %s', [$model, $logMessage->rc, $logMessage->msg, $country]);
		$inBean = $logMessage->inBean ?? '';

		log_message('DEBUG', 'NOVO ['.$userName.'] RESPONSE '.$writeLog);

		$writeLog = novoLang('%s %s: %s', [$inBean, $model, json_encode($logMessage, JSON_UNESCAPED_UNICODE)]);

		log_message('DEBUG', 'NOVO ['.$userName.'] COMPLETE RESPONSE'.$writeLog);

		unset($logMessage, $writeLog);
	}
	/**
	 * @info Genera hash Argon2 de un valor dado
	 * @author Pedro Torres
	 * @date Agosto 18th, 2020
	 */
	public function generateArgon2($string)
	{
		$hash = sodium_crypto_pwhash(
			ARGON2_LENGTH,
			$string,
			hex2bin(ARGON2_SALT),
			ARGON2_OPS_LIMIT,
			ARGON2_MEMORY_LIMIT,
			SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
		);
		$result = new stdClass();
		$result->hashArgon2 =  unpack("C*", $hash);
		$result->hexArgon2 =  bin2hex($hash);
		return $result;
	}
	/**
	 * @info Genera hexadecimal partiendo de un array Binario
	 * @author Pedro Torres
	 * @date Agosto 19th, 2020
	 * @param $binaryUnpack = array bin a empaquetar y convertir a hex
	 */
	function binary2Hexadecimal($binaryUnpack)
	{
		$chars = array_map("chr", $binaryUnpack);
		$binary = join($chars);
		return bin2hex($binary);
	}
}
