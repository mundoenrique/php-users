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
		writeLog('INFO', 'Connect_Services_Apis: getJwtOauth Method Initialized');

		$urlApiGeeHost = URL_APIGEE_OAUTH;
		$clientIdApiGee = CLIENT_ID_APIGEE;
		$ClientSecretApigee = CLIENT_SECRET_APIGEE;

		writeLog('DEBUG', 'CORE_SERVICE URL: ' . $urlApiGeeHost);

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
		// Validación para llamar a esta método
		if (!$this->CI->session->tempdata('jwtOauth')) {
			$this->getJwtOauth()						;
		}

		return $curlResponse;
	}

	public function connectMfaServices($request)
	{
		writeLog('INFO', 'Connect_Services_Apis: connectMfaServices Method Initialized');

		$urlMfaServ = URL_MFA_SERV . $request->uri;
		$uuIdV4 = uuIdV4Generate();
		$startReq = microtime(true);

		writeLog('DEBUG', 'URL: ' . $urlMfaServ. ', UUID: '. $uuIdV4);

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => $urlMfaServ,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_ENCODING => 'gzip, deflate, br',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 58,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $request->method ?? 'POST',
			CURLOPT_HTTPHEADER => [
				'Content-Type: application/json; charset=utf-8',
				'accept: application/json; charset=utf-8',
				'X-Request-Id: ' . $uuIdV4,
				'X-Tenant-Id: ST-PE',
			],
			CURLOPT_POSTFIELDS => $request->requestBody
		]);

		$response = new stdClass();
		$response->info = json_decode(curl_exec($curl));
		$response->HttpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$response->error = curl_error($curl);
		$response->errorNo = (int) curl_errno($curl);

		curl_close($curl);
		$finalReq = microtime(true);
		$executionTime = round($finalReq - $startReq, 2, PHP_ROUND_HALF_UP);
		$message = isset($response->info->message) ? ', MESSAGE: ' . $response->info->message : '';
		$serviceCode = isset($response->info->code) ? $response->info->code : lang('CONF_RC_DEFAULT');

		writeLog('DEBUG', 'RESPONSE IN '. $executionTime . ' SEC, CURL HTTPCODE: ' . $response->HttpCode .
			', SERVICE CODE: ' . $serviceCode . $message);

		if ($response->errorNo !== 0) {
			writeLog('ERROR', 'CURL ERROR NUMBER: ' . $response->errorNo . ', ERROR MESSAGE: ' . $response->error);
		}

		return responseServer($response);
	}
}
