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
		if(curl_exec($ch) === FALSE) {
			log_message("DEBUG","RESPONSE CURL TIMEOUT: " .json_encode(curl_error($ch)));
		}
		log_message("DEBUG","RESPONSE CURL HTTP CODE: ".$httpCode);
		if($httpCode == 404 || curl_exec($ch) === FALSE){
			return '{"data": false}';
		} else {
			return $response;
		}

	}
}
