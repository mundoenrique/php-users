<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controller que expone el método que atenderá la petición de un API
 * @author Pedro A. Torres F.
 * @date Sept. 30th 2020
*/
class Novo_Api extends NOVO_Controller
{

  public function __construct()
  {
		parent::__construct();
		log_message('INFO', 'NOVO Api Controller Class Initialized');
	}

	/**
	 * @info Método que atiende la petición para generar un hash de Argon2 para una clave dada
	 * @author Pedro A. Torres F.
	 * @date Sept 30th, 2020
	 */
  public function generateHash()
  {
		log_message('INFO', 'Novo_Api: generateHash Method Initialized');

		if (get_object_vars($this->dataRequest)) {
			$this->response = $this->loadModel($this->dataRequest);
		}

		return $this->output
      ->set_content_type('application/json')
      ->set_status_header($this->response->code)
      ->set_output(json_encode(
        [
					'response' => $this->response->data
        ]
      ));
  }

  public function generateRequest()
  {
		log_message('INFO', 'Novo_Api: generateRequest Method Initialized');

		$this->response = $this->loadModel($this->dataRequest);

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
