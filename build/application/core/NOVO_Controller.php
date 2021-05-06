<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase contralador de Conexión Personas Online (CPO)
 *
 * Esta clase es la súper clase de la que heredarán todos los controladores
 * de la aplicación.
 *
 * @package controllers
 * @author J. Enrique Peñaloza Piñero
 * @date May 16th, 2020
 */
class NOVO_Controller extends CI_Controller {
	protected $skin;
	protected $rule;
	protected $includeAssets;
	protected $countryUri;
	protected $views;
	protected $render;
	protected $dataRequest;
	protected $model;
	protected $method;
	protected $request;
	protected $dataResponse;
	protected $appUserName;
	protected $greeting;
	protected $products;
	protected $folder;
	protected $nameApi;
	private $ValidateBrowser;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Controller Class Initialized');

		$this->includeAssets = new stdClass();
		$this->request = new stdClass();
		$this->dataResponse = new stdClass();
		$this->render = new stdClass();
		$this->rule = lcfirst(str_replace('Novo_', '', $this->router->fetch_method()));
		$this->model = ucfirst($this->router->fetch_class()).'_Model';
		$this->method = 'callWs_'.ucfirst($this->router->fetch_method()).'_'.str_replace('Novo_', '', $this->router->fetch_class());
		$this->countryUri = $this->uri->segment(1, 0) ? $this->uri->segment(1, 0) : 'null';
		$this->render->logged = $this->session->logged;
		$this->render->userId = $this->session->userId;
		$this->appUserName = $this->session->userName;
		$this->products = $this->session->has_userdata('products');
		$this->render->fullName = $this->session->fullName;
		$this->render->productName = !$this->session->has_userdata('productInf') ?:
		$this->session->productInf->productName.' / '.$this->session->productInf->brand;
		$this->render->prefix = '';
		$this->render->sessionTime = $this->config->item('session_time');
		$this->render->callModal = $this->render->sessionTime < 180000 ? ceil($this->render->sessionTime * 50 / 100) : 15000;
		$this->render->callServer = $this->render->callModal;
		$this->ValidateBrowser = FALSE;
		$this->nameApi = '';

		if ($this->countryUri === "api") {
			$transforNameApi = explode("-", $this->uri->segment(4));
			$this->nameApi = $transforNameApi[0] . ucfirst($transforNameApi[1]);
		}

		$this->optionsCheck();
	}
	/**
	 * Método para varificar datos génericos de la solcitud
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 * @Modified Pedro A. Torres F.
	 * @date Oct. 1th, 2020
	 */
	private function optionsCheck()
	{
		log_message('INFO', 'NOVO Controller: optionsCheck Method Initialized');

		if ($this->countryUri === "api") {
			$this->dataRequest = $this->tool_api->readHeader($this->nameApi);
		} else {

			if ($this->session->has_userdata('userName')) {
				$data = ['username' => $this->session->userName];
				$this->db->where('id', $this->session->session_id)
				->update('cpo_sessions', $data);
			}

			languageLoad('generic', $this->router->fetch_class());
			clientUrlValidate($this->countryUri);
			languageLoad('specific', $this->router->fetch_class());
			$this->skin = $this->config->item('client');
			$this->form_validation->set_error_delimiters('', '---');
			$this->config->set_item('language', 'global');

			if ($this->rule !== 'suggestion') {
				$this->ValidateBrowser = $this->checkBrowser();
			}

			if ($this->session->has_userdata('time')) {
				$customerTime = $this->session->time->customerTime;
				$serverTime = $this->session->time->serverTime;
				$currentTime = (int) date("H");
				$currentTime2 = date("Y-d-m H:i:s");
				$serverelapsed = $currentTime - $serverTime;
				$serverelapsed = $serverelapsed >= 0 ? $serverelapsed : $serverelapsed + 24;
				$elapsed = $customerTime + $serverelapsed;
				$this->greeting = $elapsed < 24 ? $elapsed : $elapsed - 24;
			}

			switch ($this->greeting) {
				case $this->greeting >= 19 && $this->greeting <= 23:
					$this->render->greeting = lang('GEN_EVENING');
					break;
				case $this->greeting >= 12 && $this->greeting < 19:
					$this->render->greeting = lang('GEN_AFTERNOON');
					break;
				case $this->greeting >= 0 && $this->greeting < 12:
					$this->render->greeting = lang('GEN_MORNING');
					break;
			}

			if ($this->input->is_ajax_request()) {
				$this->dataRequest = lang('CONFIG_CYPHER_DATA') == 'ON' ? json_decode(
					$this->security->xss_clean(
						strip_tags(
							$this->cryptography->decrypt(
								base64_decode($this->input->get_post('plot')),
								utf8_encode($this->input->get_post('request'))
							)
						)
					)
				) : json_decode(utf8_encode($this->input->get_post('request')));
			} else {
				$accept = ($this->session->longProfile == 'S' && $this->session->affiliate == '0') || $this->session->terms == '0';
				$module = $this->rule != 'profileUser' && $this->rule != 'finishSession';

				if ($this->session->has_userdata('logged') && $accept && $module) {
					redirect(base_url('perfil-usuario'), 'location', 301);
				}

				$access = $this->verify_access->accessAuthorization($this->router->fetch_method(), $this->countryUri, $this->appUserName);
				$valid = TRUE;

				if ($_POST && $access) {
					log_message('DEBUG', 'NOVO ['.$this->appUserName.'] REQUEST FROM THE VIEW '.json_encode($this->input->post(), JSON_UNESCAPED_UNICODE));

					$valid = $this->verify_access->validateForm($this->rule, $this->countryUri, $this->appUserName);

					if ($valid) {
						$this->request = $this->verify_access->createRequest($this->rule, $this->appUserName);
					}
				}

				$this->preloadView($access && $valid);
			}
		}
	}
	/**
	 * Método para realizar la precarga de las vistas
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function preloadView($auth)
	{
		log_message('INFO', 'NOVO Controller: preloadView Method Initialized');

		if ($auth) {
			$this->render->favicon = lang('GEN_FAVICON');
			$this->render->ext = lang('GEN_FAVICON_EXT');
			$this->render->countryConf = $this->config->item('country');
			$this->render->countryUri = $this->countryUri;
			$this->render->novoName = $this->security->get_csrf_token_name();
			$this->render->novoCook = $this->security->get_csrf_hash();
			$this->folder = $this->countryUri;
			$validateRecaptcha = in_array($this->router->fetch_method(), lang('CONF_VALIDATE_CAPTCHA'));

			$this->includeAssets->cssFiles = [
				"$this->countryUri/root-$this->skin",
				"root-general",
				"reboot",
				"$this->folder/"."$this->skin-base"
			];

			if (gettype($this->ValidateBrowser) !== 'boolean') {
				array_push(
					$this->includeAssets->cssFiles,
					"$this->countryUri/$this->skin-$this->ValidateBrowser-base"
				);
			}

			$this->includeAssets->jsFiles = [
				"third_party/jquery-3.4.0",
				"third_party/jquery-ui-1.12.1",
				"third_party/aes",
				"aes-json-format",
				"helper"
			];

			if ($this->session->has_userdata('logged') || $this->session->has_userdata('userId')) {
				array_push(
					$this->includeAssets->jsFiles,
					"sessionControl"
				);
			}

			if ($validateRecaptcha) {
				array_push(
					$this->includeAssets->jsFiles,
					"googleRecaptcha"
				);

				if(ACTIVE_RECAPTCHA){
					$this->load->library('recaptcha');
					$this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
				}
			}
		} else {
			redirect(base_url('inicio'), 'location');
		}

	}
	/**
	 * Método para cargar un modelo especifico
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function loadModel($request = FALSE)
	{
		log_message('INFO', 'NOVO Controller: loadModel Method Initialized. Model loaded: '.$this->model);

		$this->load->model($this->model,'modelLoaded');
		$method = $this->method;

		return $this->modelLoaded->$method($request);
	}

	/**
	 * Método para extraer mensaje al usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function responseAttr($responseView = 0)
	{
		log_message('INFO', 'NOVO Controller: responseAttr Method Initialized');

		$this->render->code = $responseView;

		if(is_object($responseView)) {
			$this->render->code = $responseView->code;
		}

		if($this->render->code > 2) {
			$this->render->title = $responseView->title;
			$this->render->msg = $responseView->msg;
			$this->render->icon = $responseView->icon;
			$this->render->modalBtn = json_encode($responseView->modalBtn);
		}
	}

	/**
	 * Método para validar la versión de browser
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function checkBrowser()
	{
		log_message('INFO', 'NOVO Controller: checkBrowser Method Initialized');
		$this->load->library('Tool_Browser');

		$valid = $this->tool_browser->validBrowser($this->skin);

		if(!$valid) {
			redirect(base_url('sugerencia'),'location', 301);
			exit();
		}

		return $valid;
	}
	/**
	 * Método para renderizar una vista
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function loadView($module)
	{
		log_message('INFO', 'NOVO Controller: loadView Method Initialized. Module loaded: '.$module);

		$userMenu = new stdClass();
		$mainMenu = mainMenu();

		if ($this->session->has_userdata('noService')) {
			unset($mainMenu['CUSTOMER_SUPPORT']);
		}

		if ($this->session->has_userdata('canTransfer') && $this->session->canTransfer == 'N') {
			unset($mainMenu['PAYS_TRANSFER']);
		}

		$userMenu->mainMenu = $mainMenu;
		$userMenu->currentClass = $this->router->fetch_class();
		$this->render->settingsMenu = $userMenu;
		$this->render->goOut = ($this->render->logged || $this->session->flashdata('changePassword'))
			? 'cerrar-sesion/inicio' : 'inicio';
		$this->render->module = $module;
		$this->render->viewPage = $this->views;
		$this->asset->initialize($this->includeAssets);
		$this->load->view('master_content-core', $this->render);
	}
		/**
	 * Método para cargar un modelo especifico
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function loadApiModel($request = FALSE)
	{
		log_message('INFO', 'NOVO Controller: loadApiModel Method Initialized');

		$responseModel = $this->tool_api->setResponseNotValid();
		$showMsgLog = 'NOVO Controller: loadApiModel Model NOT loaded: '.$this->model.'/'.$this->method;

		if (file_exists(APPPATH."models/{$this->model}.php")) {
			$this->load->model($this->model,'modelLoaded');

			$method = $this->method;
			$responseModel = $this->modelLoaded->$method($request);
			$showMsgLog = 'NOVO Controller: loadApiModel Successfully loaded model: '.$this->model.'/'.$this->method;
		}
		log_message('DEBUG', $showMsgLog);

		return $responseModel;
	}
}
