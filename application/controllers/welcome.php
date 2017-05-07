<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function file(){
		$cdn = str_replace("online", "cdn", $_SERVER["DOCUMENT_ROOT"]);
		var_dump(file_exists($cdn."/personas/img"));
	}

	public function CallWsCtaDestino(){

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata("pais"));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load("format");

		$this->load->model('transfer_model','ctaDestino');

		//print_r($this->ctaDestino->ctasDestino_load());

		$tarjeta = $this->input->post('nroTarjeta');
		$tarjeta = substr_replace($tarjeta, "", 0,4);

		verify_img_ctaDestino($this->ctaDestino->ctasDestino_load($tarjeta));


		//$this->output->set_content_type('application/json')->set_output($this->ctaDestino->ctasDestino_load($tarjeta));

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */