<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Libreria para el cifrtado y descifrado de datos
 * @author J. Enrique Peñaloza Piñero
 */
class BDB_Connect_Encrypt
{
  private $CI;
  private $userName;
  private $countryConf;
  private $iv;
  private $keyNovo;

  public function __construct()
  {
    log_message('INFO', 'NOVO BDB_Connect_Encrypt Library Class Initialized');
    $this->CI = &get_instance();
    $this->iv = "\0\0\0\0\0\0\0\0";
    $this->keyAES256 = base64_decode(KEY_AES256);
    $this->ivAES256 = base64_decode(IV_AES256);
  }
  /**
   * @info método para cifrar las petiones al servicio
   * @author J. Enrique Peñaloza Piñero
   */
  public function encode($data, $userName, $model)
  {
    log_message('INFO', 'NOVO BDB_Connect_Encrypt: encode Method Initialized');

    if (ENVIRONMENT === 'development') {
      error_reporting(E_ALL & ~E_DEPRECATED);
    }

    $this->keyNovo = is_null($this->CI->session->userdata('userName')) ? WS_KEY : base64_decode($this->CI->session->userdata('keyId'));

    if ($model !== 'REMOTE_ADDR') {
      $data = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_SLASHES);
    }
    log_message('DEBUG', 'NOVO encode [' . $userName . '] REQUEST ' . $model . ': ' . $data);

    $dataB = base64_encode($data);
    while ((strlen($dataB) % 8) != 0) {
      $dataB .= " ";
    }

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
    log_message('INFO', 'NOVO BDB_Connect_Encrypt: decode Method Initialized');

    if (ENVIRONMENT === 'development') {
      error_reporting(E_ALL & ~E_DEPRECATED);
    }

    $data = base64_decode($cryptData);

    $this->keyNovo = is_null($this->CI->session->userdata('userName')) ? WS_KEY : base64_decode($this->CI->session->userdata('keyId'));

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

      log_message('ERROR', 'NOVO decode [' . $userName . '] Sin respuesta del servicio');
      $response = new stdClass();
      $response->rc = lang('RESP_RC_DEFAULT');
      $response->msg = lang('GEN_CORE_MESSAGE');
    }

    if (!isset($response->pais)) {
      log_message('DEBUG', 'NOVO [' . $userName . '] Insertando pais al RESPONSE');
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
    log_message('INFO', 'NOVO BDB_Connect_Encrypt: connectWs Method Initialized');

    $subFix = '_' . strtoupper($this->CI->config->item('country_uri'));
    $urlWS = $_SERVER['WS_URL'];

    if (isset($_SERVER['WS_URL' . $subFix])) {
      $urlWS = $_SERVER['WS_URL' . $subFix];
    }

    log_message('DEBUG', $subFix . ' NOVO [' . $userName . '] REQUEST BY COUNTRY: ' . $request['pais'] . ', AND WEBSERVICE URL: ' . $urlWS);

    $requestSerV = json_encode($request);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlWS);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestSerV);
    curl_setopt($ch, CURLOPT_TIMEOUT, 59);
    curl_setopt(
      $ch,
      CURLOPT_HTTPHEADER,
      array(
        'Content-Type: text/plain',
        'Content-Length: ' . strlen($requestSerV)
      )
    );
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    log_message('DEBUG', 'NOVO [' . $userName . '] RESPONSE CURL HTTP CODE: ' . $httpCode);

    if ($httpCode !== 200 || !$response) {
      log_message('ERROR', 'NOVO [' . $userName . '] ERROR CURL: ' . json_encode($curlError) ?: 'none');
      $failResponse = new stdClass();
      $failResponse->rc = lang('RESP_DEFAULT_CODE');
      $failResponse->msg = lang('GEN_CORE_MESSAGE');
      $response = json_encode($failResponse);
      $fail = TRUE;
    }

    if ($fail) {
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
    log_message('DEBUG', 'NOVO [' . $userName . '] RESPONSE ' . $model . '= rc: ' . $rc . ', msg: ' . $msg . ', country: ' . $country);
  }

  /**
   * @info encripta/desencripta en base AES-256
   * @author Pedro Torres
   * @date Abril 16 2020
   * @parametros $data = string a cifrar/descrifrar
   *
   */
  public function cryptography($data, $encrip = TRUE)
  {
    log_message('INFO', 'NOVO BDB_Connect_Encrypt: cryptography Method Initialized');

    $encrypt_method = "AES-256-CBC";

    if ($encrip) {
      $output = openssl_encrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
    } else {
      $output = openssl_decrypt($data, $encrypt_method, $this->keyAES256, 0, $this->ivAES256);
    }
    return $output;
  }
}
