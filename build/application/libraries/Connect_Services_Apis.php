<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para la comunicación con los servicios y APIs
 * @author J. Enrique Peñaloza Piñero
 */
class Connect_Services_Apis
{
	private $CI;
	private $logMessage;

	public function __construct()
	{
		writeLog('INFO', 'Connect_Services_Apis Library Class Initialized');

		$this->CI = &get_instance();
		$this->logMessage = new stdClass();

	}

	public function getJwtOauth()
	{
		writeLog('INFO', 'Connect_Services_Apis: getTotpJwtOauth Method Initialized');

		$urlApiGeeHost = URL_APIGEE_OAUTH;
		$clientIdApiGee = CLIENT_ID_APIGEE;
		$ClientSecretApigee = CLIENT_SECRET_APIGEE;

		writeLog('DEBUG', 'REQUEST BY CUSTOMER:' . $this->CI->session->customerSess . ', AND CORE_SERVICE URL: ' . $urlApiGeeHost);

		$startReq = microtime(true);
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => $urlApiGeeHost,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_ENCODING => 'gzip, deflate, br',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 58,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_HTTPHEADER => [
				'Content-type: application/x-www-form-urlencoded; charset=utf-8',
				'accept: application/json; charset=utf-8',
			],
			CURLOPT_POSTFIELDS => http_build_query([
				'grant_type' => 'client_credentials',
				'client_id' => $clientIdApiGee,
				'client_secret' => $ClientSecretApigee
			]),
		]);

		$curlResponse = curl_exec($curl);
		$curlHttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$curlErrorNo = curl_errno($curl);
		$curlError = curl_error($curl);

		curl_close($curl);
		$finalReq = microtime(true);
		$executionTime = round($finalReq - $startReq, 2, PHP_ROUND_HALF_UP);

		writeLog('DEBUG', 'RESPONSE IN '. $executionTime .' sec CURL HTTP CODE: ' . $curlHttpCode);

		$curlResponse = json_decode($curlResponse);

		if($curlHttpCode !== 200 || !$curlResponse) {
			switch ($CurlErrorNo) {
				case 28:
					$failResponse->rc = 504;
					break;
				default:
					$curlResponse->rc = lang('CONF_RC_DEFAULT');
			}

			switch ($curlHttpCode) {
				case 502:
					$failResponse->rc = 502;
					break;
			}

		} else {
			$curlResponse->rc = 0;
			$this->CI->session->set_tempdata('jwtOauth', $curlResponse->access_token, 1860);
		}

		return $curlResponse;
	}

	public function connectCoreServices()
	{
		log_message('INFO', 'NOVO Connect_Services_Apis: connectCoreServices Method Initialized');

		if (!$this->CI->session->tempdata('jwtOauth')) {
			$this->getJwtOauth()						;
		}
	}
}
