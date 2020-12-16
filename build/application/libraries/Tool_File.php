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
		$messageResult = [];

		if (!is_dir($configToUploadFile['upload_path'])) {
			mkdir($configToUploadFile['upload_path'], 0755, TRUE);
		}

		foreach ($_FILES as $key => $value) {
			if (is_array($value)) {
				$fileName = $value['nameForUpload'];
				$configToUploadFile['file_name'] = hash('ripemd160', $fileName);

				$this->CI->load->library('upload', $configToUploadFile);
				$this->CI->upload->initialize($configToUploadFile);

				if (!$this->CI->upload->do_upload($key)) {
					$statusCodeResponse = 400;

					$messageResult[$key] = $this->CI->upload->display_errors('', '');
					$_FILES[$key]['resultUpload'] = $this->CI->upload->display_errors('', '');
					$_FILES[$key]['error'] = 1;
				} else {
					$statusCodeResponse = 200;

					$_FILES[$key]['resultUpload'] = $this->CI->upload->data()['file_name'];
					$_POST[$key] = $this->CI->upload->data()['file_name'];
					$messageResult[$key] = 'upload successfull!!!';

					$matchedFiles = glob($this->buildDirectoryPath([
						$configToUploadFile['upload_path'],
						$configToUploadFile['file_name'].'.*'
					]));

					if ($matchedFiles && count($matchedFiles) > 0) {
						foreach ($matchedFiles as $fullPathFile) {
							if (!strpos($fullPathFile, $_POST[$key])) {
								unlink($fullPathFile);
							}
						}
					}
				}
				$resultUploadFiles[] = $statusCodeResponse;
			}
		}

		log_message('DEBUG', "Novo Tool_File: uploadFiles " . json_encode($messageResult));

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
				$fullPathFile = $this->buildDirectoryPath([
					$configUploadFile['upload_path'],
					$value['resultUpload']
				]);

				if (!file_exists($fullPathFile)) {
					$statusCodeResponse = 400;

					$_FILES[$key]['resultDelete'] = lang('GEN_SYSTEM_MESSAGE');
				} else {
					if (unlink($fullPathFile)) {
						$statusCodeResponse = 200;

						$_FILES[$key]['resultDelete'] = lang('GEN_SUCCESS_RESPONSE');
					} else {
						$statusCodeResponse = 400;

						$_FILES[$key]['resultDelete'] = lang('GEN_SYSTEM_MESSAGE');
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
	public function setNameToFile ($partOfTheName = [])
	{
		log_message('INFO', 'Novo Tool_File: setNameToFile Method Initialized');

		$setName = strtolower(join('_', $partOfTheName));

		log_message('DEBUG', "Novo Tool_Api: setNameToFile " . $setName);

		return $setName;
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
		$convertImage = new stdClass();
		$convertImage->result = FALSE;
		log_message('DEBUG', "Novo Tool_Api: CONFIG for uploadFiles " . json_encode($configToUploadFile));

		if (strpos($imageData, 'base64') > 0) {
			if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
				$data = substr($imageData, strpos($imageData, ',') + 1);
				$type = strtolower($type[1]);

				if (strpos($configToUploadFile['allowed_types'], $type)) {
					$data = str_replace( ' ', '+', $data );
					$data = base64_decode($data);
					$sizeImage = strlen($data);

					if ($sizeImage >= $configToUploadFile['min_size'] && $sizeImage <= $configToUploadFile['max_size']) {
						$fullPathFile = $this->buildDirectoryPath([
							$directoryToUpload,
							$fileName
						]);

						$totalBytesProcess = file_put_contents("$fullPathFile.{$type}", $data);
						if ($totalBytesProcess == $sizeImage ) {
							$convertImage->result = TRUE;
							$convertImage->resultProcess = "$fileName.{$type}";
						}else{
							$convertImage->resultProcess = lang('GEN_WRITE_NOT_COMPLETED');
						}
					}else{
						$convertImage->resultProcess = lang('GEN_SIZE_NOT_ALLOWED');
					}
				}else{
					$convertImage->resultProcess = lang('GEN_FILE_TYPE_NOT_ALLOWED');
				}
			}else{
				$convertImage->resultProcess = lang('GEN_FORMAT_NOT_VALID');
			}
		}else{
			$convertImage->resultProcess = lang('GEN_FILE_EMPTY');
		}
		log_message('DEBUG', "Novo Tool_Api: uploadFiles " . json_encode($convertImage));

		return $convertImage;
	}

	/**
	 * @info Crea una cadena con la estructura de directorio indicada, según el S.O.
	 * @author Pedro Torres
	 * @date Nov 06th, 2020
	 */
	public function buildDirectoryPath ($structureDirectory = [])
	{
		log_message('INFO', 'Novo Tool_File: buildDirectoryPath Method Initialized');

		$structure = join(DIRECTORY_SEPARATOR, $structureDirectory);

		log_message('DEBUG', "Novo Tool_Api: buildDirectoryPath " . $structure);

		return $structure;
	}

	/**
	 * @info cifra el contenido de un archivo indicado
	 * @author Pedro Torres
	 * @date Nov 07th, 2020
	 */
	public function cryptographyFile ($fileName = '', $encrypt = TRUE)
	{
		log_message('INFO', 'Novo Tool_File: cryptographyFile Method Initialized');

		$result = FALSE;
		if (is_file($fileName)) {
			$fileContent = file_get_contents($fileName);
			if (is_string($fileContent)) {
				$contentEncryt = $this->CI->encrypt_connect->cryptography($fileContent, $encrypt);

				$file = fopen($fileName, "wb");
				if ($file) {
					fwrite($file, $contentEncryt);
					fclose($file);
					$result = TRUE;
				}
			}
		}

		log_message('DEBUG', "Novo Tool_Api: buildDirectoryPath " . strval($result));
		return $result;
	}

	// TODO
	// Borrar
	public function fakeDataUpload($userName)
	{
		$fullPathToImage =
		$dirLoadImages = $this->buildDirectoryPath([
				'C:\Users',
				'ptorres',
				'Pictures',
				'fakeData'
			]);


		$matches = scandir($dirLoadImages);
		$imagesDocument = [];
		$ids = ['','','INE_A', 'INE_R'];
		foreach ($matches as $k => $v) {
			if (!is_dir($v)) {
				$imagesDocument[$ids[$k]]['base64'] = $v;
			}
		}

		foreach ($imagesDocument as $key => $value) {
			$fullPathToImage = $this->buildDirectoryPath([
				$dirLoadImages,
				$value['base64']
			]);
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
			'type_document' => 'CU',
			'nro_document' => 'aecj940429hchrrs01',
			'INE_A' => $imagesDocument['INE_A']['base64'],
			'INE_R' => $imagesDocument['INE_R']['base64'],
		);
		return $this->CI->encrypt_connect->cryptography(json_encode($r->request));
	}

	// TODO
	// Borrar
	public function fakeDataErase($userName)
	{
		$dirLoadImages  = $this->buildDirectoryPath([
			$this->buildDirectoryPath([BASE_CDN_PATH,'upload']),
			'BNT',
			strtoupper($userName)
		]);

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
