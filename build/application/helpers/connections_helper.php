<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

if ( ! function_exists('np_Hoplite_GetWS'))
{
	/**
	 * [np_Hoplite_GetWS description]
	 * @param  [type] $nameWS
	 * @param  [type] $cryptDataBase64
	 * @return [type]
	 */
	function np_Hoplite_GetWS($nameWS,$cryptDataBase64)
	{
		log_message("DEBUG","INICIANDO LLAMADO WS: ".$nameWS);
		$CI =& get_instance();
		$urlcurlWS=$CI->config->item('urlWS').$nameWS;
		log_message("INFO",$urlcurlWS);
	    $ch = curl_init();
		$dataPost = $cryptDataBase64;
		curl_setopt($ch, CURLOPT_URL, $urlcurlWS);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataPost);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: text/plain',
			'Content-Length: ' . strlen($dataPost))
		);
		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($response === FALSE) {
			log_message("DEBUG","RESPONSE CURL TIMEOUT: " .json_encode(curl_error($ch)));
		}
		log_message("DEBUG","RESPONSE CURL HTTP CODE: ".$httpCode);
		if($httpCode == 404 || !$response){
			return '{"data": false}';
		} else {
			return $response;
		}
	}
}

if(!function_exists('getTokenOauth'))
{
	/**
	 * @info: Función para la obtención de token oauth
	 * @date: 11/01/2018
	 * @author: J. Enrique Peñaloza
	*/
	function getTokenOauth($clientId, $ClientSecret)
	{
		$CI = &get_instance();
		$url = $CI->config->item('urlAPI') . ':8008/auth2/1.0/token';
		log_message('INFO', '<===Iniciando llamado al API OAUTH===>' . $url);
		log_message('DEBUG', 'ClientId: ==>' . $clientId . ', ClientSecret: ==>' . $ClientSecret);
		$header = [
			'Content-type: application/x-www-form-urlencoded; charset=utf-8',
			'language: es',
			'channel: web',
			'accept: application/json; charset=utf-8'
		];
		$body = [
			'grant_type' => 'client_credentials',
			'client_id' => $clientId,
			'client_secret' => $ClientSecret
		];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		$responseAPI = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		$response = new stdClass();
		$response->httpCode = $httpCode;
		$response->respOauth = $responseAPI;
		log_message('DEBUG', 'RESPONSE OAUTH====>>>>>>' . json_encode($response));
		return $response;
	}
}

if(!function_exists('connectionAPI'))
{
	/**
	 * @info: Función para conexión con API
	 * @date: 30/08/2018
	 * @author: J. Enrique Peñaloza
	 * @author: Jhonatan Llerena
	*/
	function connectionAPI($objectAPI)
	{
		$urlAPI = $objectAPI->urlAPI;
		$headerAPI = $objectAPI->headerAPI;
		$bodyAPI = $objectAPI->bodyAPI;
		$method = $objectAPI->method;
		log_message('INFO', 'ConnectionAPI:==>> ' . json_encode($objectAPI));
		log_message('DEBUG', 'Iniciando el llamado al API por el metodo:==>> ' . $method);
		$CI = &get_instance();
		$clientId = $CI->config->item('clientId');
		$ClientSecret = $CI->config->item('clientSecret');
		$responseOauth = getTokenOauth($clientId, $ClientSecret);
		$httpCode = $responseOauth->httpCode;
		$responseAPI = json_decode ($responseOauth->respOauth);
		if($httpCode === 200) {
			$token = trim($responseAPI->access_token);
			$url = $CI->config->item('urlAPI') . $urlAPI;
			log_message('DEBUG', 'URL API: ' . $url);
			//Encabezado de la petición al API
			$header = [
				'Language: es',
				'Channel: CPO',
				'Accept: application/json',
				'Content-Type: application/json',
				'x-session: ' . $CI->session->userdata("token"),
				'Authorization: Bearer ' . $token,
			];
			//Completar el encabezado de la petición con los parámetros especificos
			foreach($headerAPI as $item) {
				$item = trim($item);
				array_unshift($header, $item);
			}
			log_message('INFO', 'HEADER API' . json_encode($header));
			log_message('INFO', 'BODY API' . $bodyAPI);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyAPI);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			$responseAPI = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
		} else {
			$responseAPI = json_decode(responseOauth);
		}
		$response = new stdClass();
		$response->httpCode = $httpCode;
		$response->resAPI = $responseAPI;
		log_message('DEBUG', 'RESPONSE API:===>>>>' . json_encode($response));
		return $response;
	}
}
