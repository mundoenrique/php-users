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

		foreach ($dataRequest as $key => $value) {
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
		$decryptDataRequest = $this->encrypt_connect->cryptography($dataRequest->files, FALSE);
		$arrayFilesToDelete = explode(',', $decryptDataRequest);

		foreach ($arrayFilesToDelete as $fileName) {
			$fileName = trim($fileName);
			$fullPath = join(DIRECTORY_SEPARATOR, array($dir, $fileName));
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
	 * @info Método para generar el request a enviar para la eliminación de archivos
	 * @author Pedro A. Torres F.
	 * @date Oct. 18h, 2020
	 */
	public function requestFiles($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: requestFiles Method Initialized');

		$dataResponse = $this->encrypt_connect->cryptography($dataRequest->files);

		$this->response->code = 200;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API requestFiles: ' . json_encode($this->response));
		return $this->response;
	}
}
