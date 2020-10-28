<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para gestionar los procesos con API
 * @author Pedro Torres
 * @date Septiembre 18th, 2020
 */
class Tool_File {

	public function __construct()
	{
		log_message('INFO', 'NOVO Tool_File Library Class Initialized');

		$this->CI = &get_instance();
	}

	/**
	 * @info Procesa carga de archivos
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function uploadFiles ($configToUploadFile, $params)
	{
		log_message('INFO', 'Novo Tool_File: uploadFiles Method Initialized');

		$resultUploadFiles = [];
		$configToUploadFile['upload_path'] = join(DIRECTORY_SEPARATOR,
			array(BASE_UPLOAD_PATH,
				strtoupper($params['client']),
				strtoupper($params['nickName'])
			),
		);

		if (!is_dir($configToUploadFile['upload_path'])) {
			mkdir($configToUploadFile['upload_path'], 0755, TRUE);
		}

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$fileName = $value['nameForUpload'];
				$configToUploadFile['file_name'] = $this->CI->encrypt_connect->cryptography(
					$fileName
				);

				$this->CI->load->library('upload', $configToUploadFile);
				$this->CI->upload->initialize($configToUploadFile);

				if (!$this->CI->upload->do_upload($key)) {
					$statusCodeResponse = 400;

					$_FILES[$key]['resultUpload'] = $this->CI->upload->display_errors('', '');
				} else {
					$statusCodeResponse = 200;

					$_FILES[$key]['resultUpload'] = $this->CI->upload->data()['orig_name'];
				}
				$resultUploadFiles[] = $statusCodeResponse;
			}
		}

		log_message('DEBUG', "Novo Tool_Api: uploadFiles " . json_encode($_FILES));

		return !in_array(400, $resultUploadFiles);
	}

	/**
	 * @info Elimina archivos indicados
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function deleteFiles ($params)
	{
		log_message('INFO', 'Novo Tool_File: deleteFiles Method Initialized');

		$resultDeletingFiles = [];
		$dirUpload = join(DIRECTORY_SEPARATOR,
			array(BASE_UPLOAD_PATH,
				strtoupper($params['client']),
				strtoupper($params['nickName'])
			),
		);

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$fullPath = join(DIRECTORY_SEPARATOR,
					array($dirUpload,
						$value['resultUpload']
					),
				);

				if (!file_exists($fullPath)) {
					$statusCodeResponse = 400;

					$_FILES[$key]['resultUpload'] = lang('GEN_SYSTEM_MESSAGE');;
				} else {
					if (unlink($fullPath)) {
						$statusCodeResponse = 200;

						$_FILES[$key]['resultUpload'] = lang('GEN_SUCCESS_RESPONSE');
					} else {
						$statusCodeResponse = 400;

						$_FILES[$key]['resultUpload'] = lang('GEN_SYSTEM_MESSAGE');
					}
				}

				$resultDeletingFiles[] = $statusCodeResponse;
			}
		}

		log_message('DEBUG', "Novo Tool_Api: deleteFiles " . json_encode($_FILES));

		return !in_array(400, $resultDeletingFiles);
	}

	/**
	 * @info Crea array con nombre de archivos a procesar, dependiendo del tipo de documento
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function setNewNames ($params)
	{
		log_message('INFO', 'Novo Tool_File: setNewNames Method Initialized');

		$rulesRename = [
			'frontINE' => [
				'pattern' => $params['idType'] . "_A_" . $params['idNumber']
			],
			'backINE' => [
				'pattern' => $params['idType'] . "_R_" . $params['idNumber']
			],
		];

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$rules = $rulesRename[$key];
				$_FILES[$key]['nameForUpload'] = $rules['pattern'];
			}
		}
	}
}
