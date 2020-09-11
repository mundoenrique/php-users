<?php
defined('BASEPATH') or exit('No direct script access allowed');

class APi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->CI = &get_instance();
    $this->key_api = $this->CI->config->item('key_api');
  }

  public function generateHash()
  {
    $statusResponse = 400;
    $response = '';
    $password = NULL;
    $key = FALSE;

    $inputData = $this->input->post();
    if (count($inputData) > 0) {

      $bodyRequest = json_decode($this->encrypt_connect->cryptography($inputData['request'], FALSE));
      if (!is_null($bodyRequest)) {

        $password = trim($bodyRequest->password) == '' ? NULL : $bodyRequest->password;
        $key = $bodyRequest->key === $this->key_api;
      }
    }

    if (!is_null($password) && $key) {

      $argon2 = $this->encrypt_connect->generateArgon2($password);
      $bodyResponse = [
        'key' => $this->key_api,
        'password' => $argon2->hexArgon2
      ];
      $statusResponse = 200;

      $dataResponse = json_encode($bodyResponse);
      $response = $this->encrypt_connect->cryptography($dataResponse, TRUE);
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header($statusResponse)
      ->set_output(json_encode(
        [
          'response' => $response
        ]
      ));
  }

  public function generateRequest()
  {
    $statusResponse = 400;
    $response = '';

    $inputData = $this->input->post();
    if (count($inputData) > 0) {

      $bodyRequest = [
        'key' => $this->key_api,
        'password' => $inputData['password']
      ];

      $dataResponse = json_encode($bodyRequest);
      $response = $this->encrypt_connect->cryptography($dataResponse, TRUE);
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header($statusResponse)
      ->set_output(json_encode(
        [
          'response' => $response
        ]
      ));
  }


}
