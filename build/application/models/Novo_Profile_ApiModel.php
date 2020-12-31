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

	}

	/**
	 * @info Método para generar cargar imagenes
	 * @author Pedro A. Torres F.
	 * @date Oct. 16h, 2020
	 */
	public function uploadFile ($dataRequest)
	{
		log_message('INFO', 'NOVO API Model: uploadFile Method Initialized');

		$statusCodeResponse = 400;
		$resultUploadFiles = [];
		$dataResponse = [];
		$resultData = '';
		$directoryToUpload = BASE_CDN_PATH . $this->tool_file->buildDirectoryPath([
			'upload',
			strtoupper($this->CI->session->countryUri),
			strtoupper($_POST['nickName'] ?? $this->CI->session->userName),
		]);

		if (!is_dir($directoryToUpload)) {
			mkdir($directoryToUpload, 0755, TRUE);
		}

		foreach($dataRequest as $property => $bodyBase64) {
			$resultEcryptFile = FALSE;
			$statusCodeResponse = 400;
			if (strpos($bodyBase64, 'base64') > 0) {

				$realFileName = $this->tool_file->setNameToFile([
					$property,
					$dataRequest->type_document,
					$dataRequest->nro_document
				]);
				$shortFileName = hash('ripemd160', $realFileName);

				$convertedFile = $this->tool_file->convertBase64ToImage($bodyBase64, $directoryToUpload, $shortFileName);
				if ($convertedFile->result) {
					$statusCodeResponse = 200;

					$fullPathName = $this->tool_file->buildDirectoryPath([
						$directoryToUpload,
						$convertedFile->resultProcess,
					]);

					$resultEcryptFile = $this->tool_file->cryptographyFile($fullPathName);
				};
				$dataResponse[$property] = [
					'status' => $statusCodeResponse,
					'data' => $convertedFile->resultProcess
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

			$fullPath = $this->tool_file->buildDirectoryPath([
				$this->tool_file->buildDirectoryPath([BASE_CDN_PATH,'upload']),
				strtoupper($dataRequest->client),
				strtoupper($dataRequest->user_name),
				$fileName
			]);

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
		$directory = $this->tool_file->buildDirectoryPath([
			$this->tool_file->buildDirectoryPath([BASE_CDN_PATH,'upload']),
			strtoupper($dataRequest->client),
			strtoupper($dataRequest->user_name)
		]);
		count(scandir($directory )) < 3 && rmdir($directory );

		count(array_unique($resultUploadFiles)) > 1 && $statusCodeResponse = 206;
		$this->response->code = $statusCodeResponse;
		$this->response->data = $dataResponse;

		log_message('DEBUG', 'API eraseFile: ' . json_encode($this->response));
		return $this->response;
	}
}
