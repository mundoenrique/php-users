<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase contralador de Conexión Empresas Online (CEO)
 *
 * Esta clase es la súper clase de la que heredarán todos los controladores
 * de la aplicación.
 *
 * @package controllers
 * @author J. Enrique Peñaloza P
 */
class NOVO_Controller extends CI_Controller {
	protected $includeAssets;
	protected $countryUri;
	protected $skin;
	protected $views;
	protected $render;
	protected $dataRequest;
	protected $idProductos;
	protected $model;
	protected $method;
	protected $request;
	protected $dataResponse;

	public $accessControl;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO_Controller Class Initialized');

		$this->includeAssets = new stdClass();
		$this->render = new stdClass();
		$this->request = new stdClass();
		$this->dataResponse = new stdClass();

		$this->countryUri = $this->uri->segment(1, 0) ? $this->uri->segment(1, 0) : 'default';
		$this->countryConf = $this->config->item('country');
		$this->render->logged = $this->session->userdata('logged');
		$this->render->fullName = $this->session->userdata('fullName');
		$this->idProductos = $this->session->userdata('idProductos');
		$this->render->activeRecaptcha = $this->config->item('active_recaptcha');
		$this->lang->load(['general', 'error', 'response'], 'spanish-base');

		$this->optionsCheck();
	}

	private function optionsCheck()
	{
		log_message('INFO', 'NOVO optionsCheck Method Initialized');

		languageLoad();
		countryCheck($this->countryUri);
		languageLoad($this->countryUri);

		$this->form_validation->set_error_delimiters('', '---');
		$this->config->set_item('language', 'spanish-base');

		if($this->input->is_ajax_request()) {
			$this->dataRequest = json_decode(
				$this->security->xss_clean(
					strip_tags(
						$this->cryptography->decrypt(
							base64_decode($this->input->get_post('plot')),
							utf8_encode($this->input->get_post('request'))
						)
					)
				)
			);
		} else {
			$faviconLoader = getFaviconLoader();
			$this->render->favicon = $faviconLoader->favicon;
			$this->render->ext = $faviconLoader->ext;
			$this->render->loader = $faviconLoader->loader;
			$this->render->countryConf = $this->countryConf;
			$this->render->countryUri = $this->countryUri;
			$this->render->settingContents = $this->config->item('settingContents');
			$this->render->layoutView = $this->config->item('layout');
			$this->render->novoName = $this->security->get_csrf_token_name();
			$this->render->novoCook = $this->security->get_csrf_hash();
			$this->session->set_userdata('countryUri', $this->countryUri);
			switch($this->countryUri) {
				case 'bp':
					$this->skin = 'pichincha';
					$structure = 'pichincha';
					break;
				default:
					$this->skin = 'novo';
					$structure = 'novo';
			}
			if($this->skin !== 'pichincha') {
				$structure = 'novo';
			}
			$this->includeAssets->cssFiles = [
				"$this->countryUri/root",
				"$this->countryUri/reboot", //minificar
				"$this->countryUri/base"
			];
			$this->includeAssets->jsFiles = [
				"third_party/html5",
				"third_party/jquery-3.4.0",
				"third_party/jquery-ui-1.12.1",
				"third_party/aes",
				"aes-json-format",
				"helper"
			];
			if($this->render->logged) {
				array_push(
					$this->includeAssets->jsFiles,
					"third_party/jquery.balloon",
					"menu-datepicker"
				);
			}
		}
	}

	protected function loadView($module)
	{
		log_message('INFO', 'NOVO loadView Method Initialized Module loaded: '.$module);
		$auth = FALSE;
		switch($module) {
			case 'login':
			case 'benefits':
			case 'registry':
			case 'terms':
			case 'pass-recovery':
			case 'rates':
				$auth = TRUE;
				break;
			case 'change-password':
				$auth = ($this->session->flashdata('changePassword'));
				break;
			case 'products':
			case 'enterprise':
				$auth = ($this->render->logged);
				break;
			default:

		}
		$auth = TRUE;
		if($auth) {
			$this->render->goOut = ($this->render->logged) ? 'cerrar-sesion' : 'inicio';
			$this->render->module = $module;
			$this->render->viewPage = $this->views;
			$this->asset->initialize($this->includeAssets);
			$this->load->view('layouts/'.$this->render->layoutView, $this->render);
		} else {
			redirect(base_url('inicio'), 'location');
		}
	}

	/**
	 * Carga lenguajes especificos de las vistas y el de cada cliente definidos en el config
	 *
	 * @return void
	 * @author Pedro Torres
	 */
	protected function loadLanguajes($views = [], $folder = 'base-spanish'){
		$this->lang->load($views, $folder);

		foreach ($views as $view) {
				if(in_array($view, $this->config->item('language_file_specific'))) {
					$this->lang->load($view);
				}
		}
	}


	/**
	 * Llama un metodo especifico de un modelo
	 *
	 * @return void
	 * @author Pedro Torres
	 */
	protected function callMethodNotAsync($params = '')
	{
		$this->load->model($this->model,'modelLoaded');
		$method = $this->method;
		return $this->modelLoaded->$method($params);
	}
}
