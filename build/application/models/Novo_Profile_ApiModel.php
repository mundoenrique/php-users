<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información de las peticiones de las Api
 * @author Pedro A. Torres F.
 * @date Oct 1th, 2020
 */
class Novo_Profile_ApiModel extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Api Model Class Initialized');

		$this->configUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
	}

	/**
	 * @info Método para generar cargar imagenes
	 * @author Pedro A. Torres F.
	 * @date Oct. 16h, 2020
	 */
	public function uploadFile($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: uploadFile Method Initialized');

		$statusCodeResponse = 400;
		$dataResponse = [];
		$resultUploadFiles = [];
		$resultData = "";

		$filesToProcess = array_diff_key((array) $dataRequest, ["key" => "", "data" => ""]);
		$dataRequest = json_decode($this->encrypt_connect->cryptography($dataRequest->data, FALSE));

		$this->configUploadFile['upload_path'] = join(DIRECTORY_SEPARATOR,
			array(BASE_CDN_PATH,
				'upload',
				'profile',
				strtoupper($dataRequest->client),
				strtoupper($dataRequest->user_name))
		);

		if (!is_dir($this->configUploadFile['upload_path'])) {
			mkdir($this->configUploadFile['upload_path'], 0755, TRUE);
		}

		foreach ($filesToProcess as $key => $value) {
			if (is_array($value)) {
				$fileName = $dataRequest->type_document . "_" . strtoupper(substr($key,0,1)) . "_" . $dataRequest->nro_document;
				$this->configUploadFile['file_name'] = $this->encrypt_connect->cryptography(
					$fileName
				);

				$this->load->library('upload', $this->configUploadFile);
				$this->upload->initialize($this->configUploadFile);

				if (!$this->upload->do_upload($key)) {
					$statusCodeResponse = 400;

					$resultData = $this->upload->display_errors('', '');
				} else {
					$statusCodeResponse = 200;

					$resultData = $this->upload->data()['orig_name'];
				}

				$dataResponse[$key] = [
					'status' => $statusCodeResponse,
					'data' => $resultData
				];
				$resultUploadFiles[] = $statusCodeResponse;
			}
		}
		count(array_unique($resultUploadFiles)) > 1 && $statusCodeResponse = 206;
		$this->response->code = $statusCodeResponse;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API uploadFile: ${$value}' . json_encode($this->response));
		return $this->response;
	}

	/**
	 * @info Método para generar cargar imagenes
	 * @author Pedro A. Torres F.
	 * @date Oct. 17h, 2020
	 */
	public function eraseFiles($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: eraseFile Method Initialized');

		$statusCodeResponse = 400;
		$dataResponse = [];
		$resultUploadFiles = [];

		$dir = $this->configUploadFile['upload_path'];
		$decryptDataRequest = $this->encrypt_connect->cryptography($dataRequest->data, FALSE);
		$dataRequest = json_decode($decryptDataRequest);
		$arrayFilesToDelete = explode(',', $dataRequest->files);

		foreach ($arrayFilesToDelete as $fileName) {
			$fileName = trim($fileName);
			$fullPath = join(DIRECTORY_SEPARATOR,
				array(BASE_CDN_PATH,
					'upload',
					'profile',
					strtoupper($dataRequest->client),
					strtoupper($dataRequest->user_name),
					$fileName
				),
			);

			if (!file_exists($fullPath)) {
				$statusCodeResponse = 400;

				$resultData = lang('GEN_FILE_NOT_FOUND');
			} else {
				if (unlink($fullPath)) {
					$statusCodeResponse = 200;

					$resultData = lang('GEN_SUCCESS_RESPONSE');
				} else {
					$statusCodeResponse = 400;

					$resultData = lang('GEN_SYSTEM_MESSAGE');
				}
			}
			$dataResponse[$fileName] = [
				'status' => $statusCodeResponse,
				'data' => $resultData
			];
			$resultUploadFiles[] = $statusCodeResponse;
		}

		count(array_unique($resultUploadFiles)) > 1 && $statusCodeResponse = 206;
		$this->response->code = $statusCodeResponse;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API eraseFile: ' . json_encode($this->response));
		return $this->response;
	}

	/**
	 * @info Método para generar cargar imagenes
	 * @author Pedro A. Torres F.
	 * @date Oct. 16h, 2020
	 */
	public function keyForm($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: keyForm Method Initialized');

		$salt = $dataRequest->salt.substr(KEY_API, 0, rand(1,32));
		$bodyKey = json_encode(["key" => KEY_API, "salt" => $salt]);
		$dataResponse = $this->encrypt_connect->cryptography($bodyKey);

		$this->response->code = 200;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API keyForm: ' . json_encode($this->response));
		return $this->response;
	}

	/**
	 * @info Método para encriptar el contenido del campo data para las peticiones de imagenes
	 * @author Pedro A. Torres F.
	 * @date Oct. 24h, 2020
	 */
	private function encryptFielData($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: createEncryptData Method Initialized');

		$dataToEncrypt = array_diff_key((array) $dataRequest, ["key" => ""]);
		$dataResponse = $this->encrypt_connect->cryptography(json_encode($dataToEncrypt));

		$this->response->code = 200;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API createEncryptData: ' . json_encode($this->response));
		return $this->response;
	}

	/**
	 * @info Método para generar el request a enviar para la eliminación de archivos
	 * @author Pedro A. Torres F.
	 * @date Oct. 18h, 2020
	 */
	public function dataErase($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: dataErase Method Initialized');

		$this->encryptFielData($dataRequest);

		log_message('DEBUG', 'API requestFiles: ' . json_encode($this->response));
		return $this->response;
	}

	/**
	 * @info Método para generar el request a enviar para la eliminación de archivos
	 * @author Pedro A. Torres F.
	 * @date Oct. 24h, 2020
	 */
	public function dataUpload($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: dataUpload Method Initialized');

		$this->encryptFielData($dataRequest);

		log_message('DEBUG', 'API dataUpload: ' . json_encode($this->response));
		return $this->response;
	}

}
