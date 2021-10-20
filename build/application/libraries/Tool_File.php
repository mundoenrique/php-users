<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para gestionar los procesos con API
 * @author Pedro Torres
 * @date September 18th, 2020
 * @modified J. Enrique Peñaloza Piñero
 * @date December 28th, 2020
 */
class Tool_File {
	private $CI;
	private $user;

	public function __construct()
	{
		log_message('INFO', 'NOVO Tool_File Library Class Initialized');

		$this->CI = &get_instance();
		$this->user = $_POST['nickName'] ?? $this->CI->session->userName;
	}
	/**
	 * @info Procesa carga de archivos
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 * @modified J. Enrique Peñaloza Piñero
	 * @date December 28th, 2020
	 */
	public function uploadFiles()
	{
		log_message('INFO', 'Novo Tool_File: uploadFiles Method Initialized');

		$this->CI->load->library('upload');
		$this->CI->load->library('image_lib');
		$valid = FALSE;
		$configUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
		$configUploadFile['upload_path'] = UPLOAD_PATH . $this->buildDirectoryPath([
			strtoupper($this->CI->session->customerUri),
			strtoupper($_POST['nickName'] ?? $this->CI->session->userName),
		]);
		$createDirectory = lang('GEN_UPLOAD_NOT_CREATE_DIRECTORY');

		if (!is_dir($configUploadFile['upload_path'])) {
			if (mkdir($configUploadFile['upload_path'], 0755, TRUE)) {
				$createDirectory = lang('GEN_UPLOAD_CREATE_DIRECTORY');
			};
		}

		log_message('DEBUG', 'Novo ['.$this->user.'] uploadFiles directory '.$configUploadFile['upload_path'].' ' .$createDirectory);

		foreach ($_FILES AS $key => $value) {
			log_message('INFO', 'Novo ['.$this->user.'] UPLOAD FILE MIMETYPE: '.$value['type']);

			$fileName = $this->setNameToFile([
				$key,
				$this->CI->session->abbrTypeDocument,
				$this->CI->session->userId
			]);

			$configUploadFile['file_name'] = hash('ripemd160', $fileName);

			$this->CI->upload->initialize($configUploadFile);

			$valid = $this->CI->upload->do_upload($key);

			if ($valid) {
				$uploadData = (object)$this->CI->upload->data();
				$_POST[$key] = $uploadData->file_name;

				log_message('DEBUG', 'Novo ['.$this->user.'] uploadFiles size '.$uploadData->file_size.' KB');

				//$this->compressImage($uploadData);
				$matchedFiles = glob($uploadData->file_path.$uploadData->raw_name.'.*');

				if ($matchedFiles && count($matchedFiles) > 0) {
					foreach ($matchedFiles as $fullPathFile) {
						if ($fullPathFile != $uploadData->full_path) {
							unlink($fullPathFile);
						}
					}
				}

				$valid = $this->cryptographyFile($uploadData->full_path);
			} else {
				log_message('ERROR', 'Novo ['.$this->user.'] uploadFiles ERRORS '.json_encode($this->CI->upload->display_errors(), JSON_UNESCAPED_UNICODE));
			}
		}

		return $valid;
	}
	/**
	 * @info Elimina archivos indicados
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function deleteFiles($configUploadFile)
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
		log_message('DEBUG', 'Novo ['.$this->user.'] deleteFiles ' . json_encode($_FILES));

		return !in_array(400, $resultDeletingFiles);
	}
	/**
	 * @info Crea array con nombre de archivos a procesar, dependiendo del tipo de documento
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function setNameToFile($partOfTheName = [])
	{
		log_message('INFO', 'Novo Tool_File: setNameToFile Method Initialized');

		$setName = strtolower(join('_', $partOfTheName));

		log_message('DEBUG', 'Novo ['.$this->user.'] setNameToFile ' . $setName);

		return $setName;
	}
	/**
	 * @info Crea array con nombre de archivos a procesar, dependiendo del tipo de documento
	 * @author Pedro Torres
	 * @date Oct 27th, 2020
	 */
	public function convertBase64ToImage($imageData, $directoryToUpload, $fileName, $userName = NULL)
	{
		log_message('INFO', 'Novo Tool_File: convertBase64ToImage Method Initialized');

		$configToUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
		$convertImage = new stdClass();
		$convertImage->result = FALSE;
		$this->user = $this->user ?? $userName;

		log_message('DEBUG', '['.$this->user.'] CONFIG for uploadFiles ' . json_encode($configToUploadFile));

		if (strpos($imageData, 'base64') > 0) {
			if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
				$data = substr($imageData, strpos($imageData, ',') + 1);
				$type = strtolower($type[1]);

				if (strpos($configToUploadFile['allowed_types'], $type)) {
					$data = str_replace( ' ', '+', $data );
					$data = base64_decode($data);
					$sizeImage = strlen($data);

					log_message('DEBUG', '['.$this->user.'] uploadFiles size '.strval(round($sizeImage/1000, 2)).'KB');

					if ($sizeImage >= ($configToUploadFile['min_size'] * 1024) && $sizeImage <= (($configToUploadFile['max_size'] + 512) * 1024)) {
						$fullPathFile = $this->buildDirectoryPath([
							$directoryToUpload,
							$fileName
						]);

						$totalBytesProcess = file_put_contents("$fullPathFile.{$type}", $data);
						if ($totalBytesProcess == $sizeImage ) {
							$convertImage->result = TRUE;
							$convertImage->resultProcess = "$fileName.{$type}";
						} else {
							$convertImage->resultProcess = lang('GEN_WRITE_NOT_COMPLETED');
						}
					} else {
						$convertImage->resultProcess = lang('GEN_SIZE_NOT_ALLOWED');
					}
				} else {
					$convertImage->resultProcess = lang('GEN_FILE_TYPE_NOT_ALLOWED');
				}
			} else {
				$convertImage->resultProcess = lang('GEN_FORMAT_NOT_VALID');
			}
		} else {
			$convertImage->resultProcess = lang('GEN_FILE_EMPTY');
		}

		log_message('DEBUG', '['.$this->user.'] result upload file ' . json_encode($convertImage));

		return $convertImage;
	}
	/**
	 * @info Crea una cadena con la estructura de directorio indicada, según el S.O.
	 * @author Pedro Torres
	 * @date Nov 06th, 2020
	 */
	public function buildDirectoryPath($structureDirectory = [])
	{
		log_message('INFO', 'Novo Tool_File: buildDirectoryPath Method Initialized');

		return join(DIRECTORY_SEPARATOR, $structureDirectory);
	}
	/**
	 * @info comprime un archivo
	 * @author J. Enrique Peñaloza Piñero
	 * @date December 28th, 2020
	 */
	public function compressImage($filePath)
	{
		log_message('INFO', 'Novo Tool_File: compressImage Method Initialized');

		log_message('DEBUG', 'Novo ['.$this->user.'] compressImage '.$filePath->full_path);

		$config['image_library'] = 'GD2';
		$config['quality'] = '20%';
		$config['source_image'] = $filePath->full_path;

		$this->CI->image_lib->initialize($config);
		$result = $this->CI->image_lib->resize();

		if (!$result) {
			log_message('ERROR', 'Novo ['.$this->user.'] compressImage ERRORS'.$this->CI->image_lib->display_errors());
		}

		return $result;
	}
	/**
	 * @info cifra el contenido de un archivo indicado
	 * @author Pedro Torres
	 * @date Nov 07th, 2020
	 */
	public function cryptographyFile($fileName = '', $encrypt = TRUE, $userName = NULL)
	{
		log_message('INFO', 'Novo Tool_File: cryptographyFile Method Initialized');

		$result = FALSE;
		$this->user = $this->user ?? $userName;
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
		$textResult = $result ? lang('GEN_UPLOAD_SUCCESSFULL') : lang('GEN_UPLOAD_ERROR_GENERAL');
		log_message('DEBUG', '['.$this->user.'] cryptographyFile '.$fileName.' '. $textResult);

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
			$this->buildDirectoryPath([UPLOAD_PATH]),
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
