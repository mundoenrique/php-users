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
		writeLog('INFO', 'Api Model Class Initialized');

		$this->configUploadFile = lang('SETT_CONFIG_UPLOAD_FILE');
	}

	/**
	 * @info Método para generar hash
	 * @author Pedro A. Torres F.
	 * @date Oct. 1h, 2020
	 */
	public function generateHash($dataRequest)
	{
		writeLog('INFO', 'API Model: GenerateHash Method Initialized');

		$argon2 = $this->encrypt_decrypt->generateArgon2Hash($dataRequest->password);

		$bodyResponse = [
			'key' => KEY_API,
			'password' => $argon2->hexArgon2
		];

		$dataResponse = json_encode($bodyResponse);

		$this->response->code = 200;
		$this->response->data = $this->encrypt_decrypt->aesCryptography($dataResponse, TRUE);
		writeLog('DEBUG', 'API bodyResponse: ' . json_encode($this->response));

		return $this->response;
	}

	/**
	 * @info Método para generar Request
	 * @author Pedro A. Torres F.
	 * @date Oct. 1h, 2020
	 */
	public function generateRequest($dataRequest)
	{
		writeLog('INFO', 'API Model: GenerateRequest Method Initialized');

		$bodyRequest = [
			'key' => $dataRequest->key,
			'password' => $dataRequest->password
		];

		$dataResponse = json_encode($bodyRequest);
		$this->response->code = 200;
		$this->response->data= $this->encrypt_decrypt->aesCryptography($dataResponse, TRUE);

		writeLog('INFO', 'API bodyResponse: ' . json_encode($this->response));

		return $this->response;
	}
}
