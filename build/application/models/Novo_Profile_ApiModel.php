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
		$resultData = '';
		$directoryToUpload = join(DIRECTORY_SEPARATOR,
			array(BASE_UPLOAD_PATH,
				strtoupper($dataRequest->client),
				strtoupper($dataRequest->user_name),
			),
		);

		if (!is_dir($directoryToUpload)) {
			mkdir($directoryToUpload, 0755, TRUE);
		}

		foreach($dataRequest as $property => $bodyBase64) {
			if (strpos($bodyBase64, 'base64') > 0) {
				$realFileName = $property.'_'.$dataRequest->type_document.'_'.$dataRequest->nro_document;
				$shortFileName = hash('ripemd160', $realFileName);

				$uploadedFileName = $this->tool_file->convertBase64ToImage($bodyBase64, $directoryToUpload, $shortFileName);
				if ($uploadedFileName) {
					$statusCodeResponse = 200;

					$resultData = $uploadedFileName;
				};
				$dataResponse[$property] = [
					'status' => $statusCodeResponse,
					'data' => $resultData
				];
				$resultUploadFiles[] = $statusCodeResponse;
			}
		}
		count(array_unique($resultUploadFiles)) > 1 && $statusCodeResponse = 206;
		$this->response->code = $statusCodeResponse;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API uploadFile: ' . json_encode($this->response));
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

		$arrayFilesToDelete = explode(';', $dataRequest->files);

		foreach ($arrayFilesToDelete as $fileName) {
			$fileName = trim($fileName);
			$fullPath = join(DIRECTORY_SEPARATOR,
				array(BASE_UPLOAD_PATH,
					strtoupper($dataRequest->client),
					strtoupper($dataRequest->user_name),
					$fileName
				),
			);

			if (!file_exists($fullPath)) {
				$statusCodeResponse = 400;

				$resultData = lang('GEN_FILE_NOT_FOUND');
			} else {
				$statusCodeResponse = 400;
				if (unlink($fullPath)) {
					$statusCodeResponse = 200;
				}
			}
			$dataResponse[$fileName] = [
				'status' => $statusCodeResponse
			];
			$resultUploadFiles[] = $statusCodeResponse;
		}
		$directory = join(DIRECTORY_SEPARATOR,
			array(BASE_UPLOAD_PATH,
				strtoupper($dataRequest->client),
				strtoupper($dataRequest->user_name)
			),
		);
		count(scandir($directory)) < 3 && rmdir($directory);

		count(array_unique($resultUploadFiles)) > 1 && $statusCodeResponse = 206;
		$this->response->code = $statusCodeResponse;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API eraseFile: ' . json_encode($this->response));
		return $this->response;
	}
}
