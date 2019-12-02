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

		$this->render = new stdClass();
		$this->request = new stdClass();
		$this->dataResponse = new stdClass();
		$this->includeAssets = new stdClass();

		$this->idProductos = $this->session->userdata('idProductos');
		$this->render->logged = $this->session->userdata('logged_in');
		$this->render->fullName = $this->session->userdata('fullName');

		$this->countryUri = $this->uri->segment(1, 0) ?: 'default';
		$this->render->rootHome = base_url($this->render->logged? 'bdb/vistaconsolidada': 'bdb/inicio');
		$this->render->pathViewPreview = base_url('bdb/vistaconsolidada');

		$this->countryConf = $this->config->item('country');
		$this->render->activeRecaptcha = $this->config->item('active_recaptcha');

		$this->lang->load(['general', 'error', 'response'], 'spanish-base');
		$this->rule = strtolower($this->router->fetch_method());

		$this->optionsCheck();
	}

	private function optionsCheck()
	{
		log_message('INFO', 'NOVO optionsCheck Method Initialized');

		languageLoad();
		countryCheck($this->countryUri);
		languageLoad($this->countryUri);
		$this->render->idleSession = $this->session->userdata('logged_in')? $this->config->item('timeIdleSession'): 0;

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
			$this->render->novoName = $this->security->get_csrf_token_name(); // name
			$this->render->novoCook = $this->security->get_csrf_hash(); // value
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
				"$this->countryUri/reboot",
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
			case 'preregistry':
			case 'registry':
			case 'recoveryaccess':
			case 'pass-recovery':
			case 'rates':
				$auth = TRUE;
				break;
			case 'changepassword':
				$auth = ($this->session->flashdata('changePassword'));
				break;
			case 'products':
			case 'enterprise':
			case 'listproduct':
			case 'detailproduct':
			case 'customersupport':
				$auth = ($this->render->logged);
				break;
			default:
				$auth = FALSE;
		}
		if($auth) {
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
	protected function loadLanguajes($views = [], $folder = 'base-spanish')
	{
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
