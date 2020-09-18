<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Novo_APi extends NOVO_Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function generateHash()
  {
		log_message('INFO', 'Novo_Api: generateHash Method Initialized');

    $statusResponse = 400;
    $response = '';

    if (count($this->dataRequest) > 0) {

      $argon2 = $this->encrypt_connect->generateArgon2($this->dataRequest['password']);
      $bodyResponse = [
        'key' => $this->key_api,
				'password' => $argon2->hexArgon2,
				'clave' => $this->dataRequest['password']
      ];
			$statusResponse = 200;

			log_message('INFO', 'API bodyResponse: ' .  json_encode($bodyResponse));

      $dataResponse = json_encode($bodyResponse);
      $response = $this->encrypt_connect->cryptography($dataResponse, TRUE);
    }

		return $this->output
      ->set_content_type('application/json')
      ->set_status_header($statusResponse)
      ->set_output(json_encode(
        [
					'response' => $response,
					'bodyResponse' => $bodyResponse
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
				'key' => $inputData['key'],
        'password' => $inputData['password']
      ];

      $dataResponse = json_encode($bodyRequest);
      $response = $this->encrypt_connect->cryptography($dataResponse, TRUE);
			$statusResponse = 200;
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
