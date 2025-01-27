<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para las peticiones asíncronas de la aplicación
 * @author J. Enrique Peñaloza Piñero
 * @date May 18th, 2019
*/
class Novo_CallModels extends Novo_Controller {

	public function __construct()
	{
		parent:: __construct();
		writelog('INFO', 'CallModels Controller Class Initialized');

		if($this->input->is_ajax_request()) {
			$this->fileLanguage = lcfirst($this->dataRequest->who);
			$this->validationMethod = lcfirst($this->dataRequest->where);
			$this->modelClass = 'Novo_'.ucfirst($this->dataRequest->who).'_Model';
			$this->modelMethod = 'callWs_'.ucfirst($this->dataRequest->where).'_'.$this->dataRequest->who;
		} else {
			redirect('page-no-found', 'Location', 301);
			exit();
		}
	}
	/**
	 * @info Método que valida y maneja las peticiones asincornas de la aplicación
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 18th, 2020
	 */
	public function index()
	{
		writelog('INFO', 'CallModels: index Method Initialized');

		if (!empty($this->dataRequest->data)) {
			foreach ($this->dataRequest->data AS $item => $value) {
				$_POST[$item] = $value;
			}
		}

		unset($this->dataRequest);
		$valid = $this->verify_access->accessAuthorization($this->validationMethod);

		if (!empty($_FILES) && $valid) {
			$valid = $this->tool_file->uploadFiles();
		}

		if ($valid) {
			$this->request = $this->verify_access->createRequest($this->modelClass, $this->modelMethod);
			$valid = $this->verify_access->validateForm($this->validationMethod);
		}

		LoadLangFile('generic', $this->fileLanguage, $this->customerLang);
		$this->config->set_item('language', BASE_LANGUAGE . '-' . $this->customerLang);
		LoadLangFile('specific', $this->fileLanguage, $this->customerLang);

		if ($valid) {
			$this->dataResponse = $this->loadModel($this->request);
		} else {
			$this->dataResponse = $this->verify_access->responseByDefect();
		}

		$customerData = encryptData($this->dataResponse);

		$this->output->set_content_type('application/json')->set_output($customerData);
	}
}
