<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para las peticiones asíncronas de la aplicación
 * @author J. Enrique Peñaloza Piñero
 * @date May 18th, 2019
*/
class Novo_CallModels extends Novo_Controller {
	public $class;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO CallModels Controller Class Initialized');

		if($this->input->is_ajax_request()) {
			$this->class = lcfirst($this->dataRequest->who);
			$this->rule = lcfirst($this->dataRequest->where);
			$this->model = 'Novo_'.ucfirst($this->dataRequest->who).'_Model';
			$this->method = 'callWs_'.ucfirst($this->dataRequest->where).'_'.$this->dataRequest->who;

		} else {
			show_404();
		}
	}
	/**
	 * @info Método que valida y maneja las peticiones asincornas de la aplicación
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 18th, 2019
	 */
	public function index()
	{
		log_message('INFO', 'NOVO CallModels: index Method Initialized');

		if (!empty($this->dataRequest->data)) {
			foreach ($this->dataRequest->data AS $item => $value) {
				$_POST[$item] = $value;
			}
		}

		$this->appUserName = $this->input->post('userName') ? mb_strtoupper($this->input->post('userName')) : $this->appUserName;

		log_message('DEBUG', 'NOVO ['.$this->appUserName.'] REQUEST FROM THE VIEW '.json_encode($this->dataRequest, JSON_UNESCAPED_UNICODE));

		unset($this->dataRequest);
		$valid = $this->verify_access->accessAuthorization($this->rule, $this->countryUri, $this->appUserName);;

		if (!empty($_FILES) && $valid) {

			foreach ($_FILES as $key => $value) {
				if (is_array($value)) {
					$_FILES[$key]['nameForUpload'] = $this->tool_file->setNameToFile([
						$key,
						$this->session->abbrTypeDocument,
						$this->session->userId
					]);
				}
			}

			$configUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
			$configUploadFile['upload_path'] = $this->tool_file->buildDirectoryPath([
				$this->tool_file->buildDirectoryPath([BASE_CDN_PATH,'upload']),
				strtoupper($this->session->countryUri),
				strtoupper($_POST['nickName'] ?? $this->session->userName),
			]);

			$this->tool_file->uploadFiles($configUploadFile);
			foreach ($_FILES as $clave => $valor) {
				if ($valor['error'] == 0) {
					$fullPathName = $this->tool_file->buildDirectoryPath([
						$configUploadFile['upload_path'],
						$valor['resultUpload'],
					]);

					$resultEcryptFile = $this->tool_file->cryptographyFile($fullPathName);
				} else {
					$_POST[$clave] = '';
				}
			}
		}

		if ($valid) {
			$valid = $this->verify_access->validateForm($this->rule, $this->countryUri, $this->appUserName, $this->class);
		}

		if ($valid) {
			$this->request = $this->verify_access->createRequest($this->rule, $this->appUserName);
			$this->dataResponse = $this->loadModel($this->request);
		} else {
			$this->dataResponse = $this->verify_access->ResponseByDefect($this->appUserName);
		}

		$dataResponse = $this->cryptography->encrypt($this->dataResponse);
		$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse, JSON_UNESCAPED_UNICODE));
	}
	/**
	 * @info Método que maneja los archivos enviados al servidor
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 18th, 2019
	 */
	private function manageFile()
	{
		log_message('INFO', 'NOVO CallModels: manageFile Method Initialized');
		log_message('DEBUG', 'NOVO UPLOAD FILE MIMETYPE: '.$_FILES['file']['type']);

		$ext =  explode('.', $_FILES['file']['name']);
		$ext = end($ext);
		$pattern = [];
		$replace = [];
		$pattern[0] = '/\s/';
		$pattern[1] = '/\(/';
		$replace[0] = '';
		$replace[1] = '_';
		$filename = '_'.substr(preg_replace($pattern, $replace, $_POST['typeBulkText']), 0, 17);
		$filenameT = time().'_'.date('s').$this->countryUri.$filename;
		$filenameT = mb_strtolower($filenameT.'.'.$ext);
		$config['file_name'] = $filenameT;
		$config['upload_path'] = $this->config->item('upload_bulk');
		$config['allowed_types'] = lang('VALIDATE_FILES_EXTENSION');
		$this->load->library('upload', $config);

		if(!$this->upload->do_upload('file')) {
			$errors = $this->upload->display_errors();

			log_message('DEBUG', 'NOVO  ['.$this->appUserName.'] VALIDATION FILEUPLOAD ERRORS: '.json_encode($errors, JSON_UNESCAPED_UNICODE));

			$valid = FALSE;
		} else {
			$uploadData = (object) $this->upload->data();
			$_POST['fileName'] = $uploadData->file_name;
			$_POST['filePath'] = $uploadData->file_path;
			$_POST['rawName'] = $this->countryUri.$filename;
			$_POST['fileExt'] = substr($uploadData->file_ext, 1);
			unset($_POST['typeBulkText'], $_POST['file']);

			$valid = TRUE;
		}

		return $valid;
	}
}
