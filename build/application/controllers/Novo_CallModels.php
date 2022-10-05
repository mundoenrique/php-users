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
		writeLog('INFO', 'CallModels Controller Class Initialized');

		if($this->input->is_ajax_request()) {
			$this->fileLanguage = lcfirst($this->dataRequest->who);
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
		writeLog('INFO', 'CallModels: index Method Initialized');

		if (!empty($this->dataRequest->data)) {
			foreach ($this->dataRequest->data AS $item => $value) {
				$_POST[$item] = $value;
			}
		}

		unset($this->dataRequest);
		$valid = $this->verify_access->accessAuthorization($this->rule);

		if (!empty($_FILES) && $valid) {
			$valid = $this->tool_file->uploadFiles();
		}

		if ($valid) {
			$valid = $this->verify_access->validateForm($this->rule);
		}

		$this->config->set_item('language', BASE_LANGUAGE . '-base');
		languageLoad('generic', $this->fileLanguage);
		$this->config->set_item('language', BASE_LANGUAGE . '-' . $this->customerUri);
		languageLoad('specific', $this->fileLanguage, $this->customerUri);

		if ($valid) {
			$this->request = $this->verify_access->createRequest($this->model, $this->method);
			$this->dataResponse = $this->loadModel($this->request);
		} else {
			$this->dataResponse = $this->verify_access->responseByDefect();
		}

		$customerData = encryptData($this->dataResponse);

		$this->output->set_content_type('application/json')->set_output($customerData);
	}
}
