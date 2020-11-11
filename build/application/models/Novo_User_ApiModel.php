<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información de las peticiones de las Api
 * @author Pedro A. Torres F.
 * @date Oct 1th, 2020
 */
class Novo_User_ApiModel extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Api Model Class Initialized');

		$this->configUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
	}

	/**
	 * @info Método para generar hash
	 * @author Pedro A. Torres F.
	 * @date Oct. 1h, 2020
	 */
	public function generateHash($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: GenerateHash Method Initialized');

		$argon2 = $this->encrypt_connect->generateArgon2($dataRequest->password);

		$bodyResponse = [
			'key' => KEY_API,
			'password' => $argon2->hexArgon2
		];

		$dataResponse = json_encode($bodyResponse);

		$this->response->code = 200;
		$this->response->data = $this->encrypt_connect->cryptography($dataResponse, TRUE);
		log_message('DEBUG', 'API bodyResponse: ' . json_encode($this->response));

		return $this->response;
	}

	/**
	 * @info Método para generar Request
	 * @author Pedro A. Torres F.
	 * @date Oct. 1h, 2020
	 */
	public function generateRequest($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: GenerateRequest Method Initialized');

		$bodyRequest = [
			'key' => $dataRequest->key,
			'password' => $dataRequest->password
		];

		$dataResponse = json_encode($bodyRequest);
		$this->response->code = 200;
		$this->response->data= $this->encrypt_connect->cryptography($dataResponse, TRUE);
		log_message('INFO', 'API bodyResponse: ' . json_encode($this->response));

		return $this->response;
	}
}
