<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para las peticiones de API
 * @author Pedro A. Torres F.
 * @date 2 Oct. 2020
*/
class Novo_CallApi extends Novo_Controller {
	public $class;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO CallApi Controller Class Initialized');

		$this->method = $this->nameApi;
		$this->model = "Novo_".ucfirst($this->uri->segment(3))."_ApiModel";
	}
	/**
	 * @info Método que valida y maneja las peticiones de API
	 * @author Pedro A. Torres F.
	 * @date 2 Oct. 2020
	 */
	public function index()
	{
		log_message('INFO', 'NOVO CallApi: index Method Initialized');

		$isValid = FALSE;

		if (is_array($this->dataRequest) && count($this->dataRequest) > 0) {
			$_POST = $this->dataRequest;

			if (!array_key_exists('key', $_POST) || $_POST['key'] !== KEY_API) {
				$isValid = FALSE;
			} else {
				$isValid = $this->form_validation->run($this->nameApi);
				$_POST = [];

				log_message('DEBUG', 'NOVO VALIDATION PARAMS API: '.$this->nameApi.': '.json_encode($isValid));
			}
		}

		if ($isValid) {
			$this->response = $this->loadApiModel((object) $this->dataRequest);
		} else {
			$this->response = $this->tool_api->setResponseNotValid();
		}

		log_message('DEBUG', 'NOVO setResponseNotValid: '.json_encode($this->response));

		return $this->output
		->set_content_type('application/json')
		->set_status_header($this->response->code)
		->set_output(json_encode(
			[
				'response' => $this->response->data
			]
		));
	}
}
