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
	public function uploadFiles ($configToUploadFile)
	{
		log_message('INFO', 'Novo Tool_File: uploadFiles Method Initialized');

		$resultUploadFiles = [];

		if (!is_dir($configToUploadFile['upload_path'])) {
			mkdir($configToUploadFile['upload_path'], 0755, TRUE);
		}

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$fileName = $value['nameForUpload'];
				$configToUploadFile['file_name'] = hash('ripemd160', $fileName);

				$matchedFiles = glob(join(DIRECTORY_SEPARATOR,
					[$configToUploadFile['upload_path'],
					$configToUploadFile['file_name'].'.*']
				));

				if ($matchedFiles && count($matchedFiles) > 0) {
					foreach ($matchedFiles as $fullPathFile) {
						unlink($fullPathFile);
					}
				}

				$this->CI->load->library('upload', $configToUploadFile);
				$this->CI->upload->initialize($configToUploadFile);

				if (!$this->CI->upload->do_upload($key)) {
					$statusCodeResponse = 400;

					$_FILES[$key]['resultUpload'] = $this->CI->upload->display_errors('', '');
				} else {
					$statusCodeResponse = 200;

					$_FILES[$key]['resultUpload'] = $this->CI->upload->data()['orig_name'];
					$_POST[$key] = $fileName.$this->CI->upload->data()['file_ext'];
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
	public function deleteFiles ($configUploadFile)
	{
		log_message('INFO', 'Novo Tool_File: deleteFiles Method Initialized');

		$resultDeletingFiles = [];
		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$fullPath = join(DIRECTORY_SEPARATOR,
					array($configUploadFile['upload_path'],
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
	public function setNewNames ($lastPartFileName)
	{
		log_message('INFO', 'Novo Tool_File: setNewNames Method Initialized');

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$_FILES[$key]['nameForUpload'] = strtolower($key."_".$lastPartFileName);
			}
		}
	}

	/**
	 * @info Crea array con nombre de archivos a procesar, dependiendo del tipo de documento
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function convertBase64ToImage($imageData, $directoryToUpload, $fileName)
	{
		log_message('INFO', 'Novo Tool_File: convertBase64ToImage Method Initialized');

		$configToUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
		$result = FALSE;
		if (strpos($imageData, 'base64') > 0) {
			if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
				$data = substr($imageData, strpos($imageData, ',') + 1);
				$type = strtolower($type[1]);

				if (in_array($type, explode('|', $configToUploadFile['allowed_types']))) {
					$data = str_replace( ' ', '+', $data );
					$data = base64_decode($data);

					if (strlen($data) <= $configToUploadFile['max_size']) {
						$fullPathFile = join(DIRECTORY_SEPARATOR,
							[$directoryToUpload, $fileName]
						);
						if (file_put_contents("$fullPathFile.{$type}", $data) > 0 ) {
							$result = "$fileName.{$type}";
						}
					}
				}
			}
		}
		log_message('DEBUG', "Novo Tool_Api: uploadFiles " . json_encode($result));

		return $result;
	}

	public function fakeDataUpload($userName)
	{
		$dirLoadImages = join(DIRECTORY_SEPARATOR,
			['C:\Users',
				'ptorres',
				'Pictures',
				'fakeData'
			],
		);

		$matches = scandir($dirLoadImages);
		$imagesDocument = [];
		$ids = ['','','INE_A', 'INE_R'];
		foreach ($matches as $k => $v) {
			if (!is_dir($v)) {
				$imagesDocument[$ids[$k]]['base64'] = $v;
			}
		}

		foreach ($imagesDocument as $key => $value) {
			$fullPathToImage = join(DIRECTORY_SEPARATOR,
				[$dirLoadImages, $value['base64']	],
			);
			$type = pathinfo($fullPathToImage, PATHINFO_EXTENSION);
			$data = file_get_contents($fullPathToImage);
			$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
			if (file_exists($fullPathToImage)) {
				$imagesDocument[$key]['base64'] = $base64;
				$imagesDocument[$key]['validate'] = 'ignore';
			}
		}

		$r = new stdClass();
		$r->request = (object)
		array (
			'key' => 'b4556ab03a8a120d1e77abfc55f515e3',
			'user_name' => $userName,
			'client' => 'bnt',
			'type_document' => '15',
			'nro_document' => '1232352435',
			'INE_A' => $imagesDocument['INE_A']['base64'],
			'INE_R' => $imagesDocument['INE_R']['base64'],
		);
		return $this->CI->encrypt_connect->cryptography(json_encode($r->request));
	}

	public function fakeDataErase($userName)
	{
		$dirLoadImages = join(DIRECTORY_SEPARATOR,
			[BASE_UPLOAD_PATH,
				'BNT',
				strtoupper($userName)
			],
		);

		$matches = scandir($dirLoadImages);
		$imagesDocument = [];
		foreach ($matches as $k => $v) {
			if (!is_dir($v)) {
				$imagesDocument[] = $v;
			}
		}

		$r = new stdClass();
		$r->request = (object)
		array (
			'key' => 'b4556ab03a8a120d1e77abfc55f515e3',
			'user_name' => $userName,
			'client' => 'bnt',
			'files' => implode ("; ", $imagesDocument),
		);
		return $this->CI->encrypt_connect->cryptography(json_encode($r->request));
	}
}
