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
			redirect('page-no-found', 'Location', 301);
		}
	}
	/**
	 * @info Método que valida y maneja las peticiones asincornas de la aplicación
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 18th, 2020
	 */
	public function index()
	{
		log_message('INFO', 'NOVO CallModels: index Method Initialized');

		if (!empty($this->dataRequest->data)) {
			foreach ($this->dataRequest->data AS $item => $value) {
				$_POST[$item] = $value;
			}
		}

		if (!$this->appUserName) {
			if ($this->input->post('userName') != NULL)	{
				$this->appUserName = mb_strtoupper($this->input->post('userName'));
			} elseif ($this->input->post('idNumber') != NULL)	{
				$this->appUserName = mb_strtoupper($this->input->post('idNumber'));
			} elseif ($this->input->post('documentId') != NULL)	{
				$this->appUserName = mb_strtoupper($this->input->post('documentId'));
			}
		}

		log_message('DEBUG', 'NOVO ['.$this->appUserName.'] REQUEST FROM THE VIEW '.json_encode($this->dataRequest, JSON_UNESCAPED_UNICODE));

		unset($this->dataRequest);
		$valid = $this->verify_access->accessAuthorization($this->rule, $this->customerUri, $this->appUserName);;

		if (!empty($_FILES) && $valid) {
			$valid = $this->tool_file->uploadFiles();
		}

		if ($valid) {
			$valid = $this->verify_access->validateForm($this->rule, $this->customerUri, $this->appUserName, $this->class);
		}

		if ($valid) {
			$this->request = $this->verify_access->createRequest($this->rule, $this->appUserName);
			$this->dataResponse = $this->loadModel($this->request);
		} else {
			$this->dataResponse = $this->verify_access->ResponseByDefect($this->appUserName);
		}

		$dataResponse = lang('CONF_CYPHER_DATA') == 'ON' ?  $this->cryptography->encrypt($this->dataResponse) : $this->dataResponse;
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
		$filenameT = time().'_'.date('s').$this->customerUri.$filename;
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
			$_POST['rawName'] = $this->customerUri.$filename;
			$_POST['fileExt'] = substr($uploadData->file_ext, 1);
			unset($_POST['typeBulkText'], $_POST['file']);

			$valid = TRUE;
		}

		return $valid;
	}
}
