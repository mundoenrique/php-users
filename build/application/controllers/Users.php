<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->scoreRecapcha = $this->config->item('scores_recapcha')[ENVIRONMENT]['score'];
		$this->initCookie();
		$this->config->set_item('language', 'core-base');
	}

	private function initCookie() {
		$requestMethod=$this->router->method; //Nombre del metodo que asiste a la solicitud HTTP

		if($requestMethod == 'index') {
			$requestMod=$this->uri->segment(1); //Modo al cual el usuario desea ingresar (latodo, pichincha, default)

			switch($requestMod){
				case 'latodo': 	$code='latodo'; break;
				case 'pichincha':
					$code='pichincha';
					np_hoplite_countryCheck('ec-bp');
					$this->scoreRecapcha = $this->config->item('scores_recapcha')[ENVIRONMENT]['score'];
					break;
				default: $code='default';
			}

			$this->setCookie($code);

		} else if($requestMethod == 'recoveryPassword' || $requestMethod == 'obtenerLogin'){
			$requestMod=$this->uri->segment(2); //Modo al cual el usuario desea ingresar (latodo, pichincha, default)

			switch($requestMod){
				case 'recoveryPassword_pe' : $code='latodo'; break;
				case 'recoveryPassword_pi' : $code='pichincha'; break;
				case 'obtenerLogin_pe' : $code='latodo'; break;
				case 'obtenerLogin_pi': $code='pichincha'; break;
				default: $code='default';
			}

			$this->setCookie($code);
		}
	}

	private function setCookie($code) {
		$cookie=$this->input->cookie( $this->config->item('cookie_prefix') . 'skin'); //Valor actual de la cookie

		if( $cookie !== $code || $cookie === false) {
			$this->load->helper('url');

			$cookie = array(
				'name' => 'skin',
				'value' => $code,
				'expire' => 0,
				'domain' => $this->config->item('cookie_domain'),
				'path' => $this->config->item('cookie_path'),
				'prefix' => $this->config->item('cookie_prefix'),
				'secure' => $this->config->item('cookie_secure')
			);
			$this->input->set_cookie($cookie);
			redirect(current_url());
		}
	}

	public function index()
	{
		//VALIDA SI EXISTE SESION
		np_hoplite_verificSession();
		$skin = $this->input->cookie('cpo_skin');
		validateUrl($skin);
		$this->lang->load('login', $skin);
		//INSTANCIA PARA TITULO DE PAGINA
 		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS

		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);

		$baseCdnCookie = [
			'name' => 'baseCdn',
			'value' => $this->config->item('asset_url'),
			'expire' => 0,
			'domain' => $this->config->item('cookie_domain'),
			'path' => $this->config->item('cookie_path'),
			'prefix' => $this->config->item('cookie_prefix'),
			'secure' => $this->config->item('cookie_secure')
		];


		$this->input->set_cookie($baseCdnCookie);

		$this->load->library('recaptcha');
		log_message('DEBUG', 'NOVO RESPONSE: recaptcha: ' . $this->recaptcha->getScriptTag());

		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER , INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets, 'scoreRecapcha' => $this->scoreRecapcha), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js','cypher/aes.min.js','cypher/aes-json-format.min.js', 'novo_helper.js', 'login.js',  'jquery.validate.min.js',  'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.isotope.min.js');
		//INSTANCIA DEL FOOTER
		$cookie = $this->input->cookie($this->config->item('cookie_prefix').'skin');
		if(ENVIRONMENT == 'production' && $cookie == 'pichincha') {
			array_push(
				$FooterCustomInsertJS,
				'borders.js'
			);
		}
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-login', array('insertRecaptcha'=>$this->recaptcha->getScriptTag()), true);
		//INSTANCIA DE SIDERBAR
		$placeHolderUser = 'Usuario';
		$placeHolderPass = 'Contraseña';
		if($cookie == 'pichincha') {
			$placeHolderUser = '';
			$placeHolderPass = '';
		}
		$sidebarlogin = $this->parser->parse('users/widget-signin', array(
			'sidebarActive' => true,
			'placeHolderUser' => $placeHolderUser,
			'placeHolderPass' => $placeHolderPass
		), true);
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function error_gral()
	{
		//INSTANCIA PARA TITULO DE PAGINA
 		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS=['jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js',  'jquery-md5.js', 'jquery.balloon.min.js'];
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-error', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

	public function recoveryPassword()
	{
		$skin = $this->input->cookie('cpo_skin');
		validateUrl($skin);
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive'=>false, 'menuHeader'=>$menuHeader, 'menuHeaderMainActive'=>false, 'titlePage'=>$titlePage, 'styleSheets'=>$styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'recovery-password.js',  'jquery.validate.min.js',  'jquery-md5.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive'=>true, 'FooterCustomInsertJSActive'=>true, 'FooterCustomInsertJS'=>$FooterCustomInsertJS, 'FooterCustomJSActive'=>false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-recovery', array(), true);

		$data = array('header'=>$header, 'content'=>$content, 'footer'=>$footer);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function cambiarPassword()
	{
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'novo_helper.js', 'cambiar-password.js',  'jquery.validate.min.js',  'jquery-md5.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$temporal = $this->input->get('t');
		$content = $this->parser->parse('users/content-cambiar-password', array('temporal' => $temporal), true);

		$data = array('header'=>$header, 'content'=>$content, 'footer'=>$footer);

		$this->parser->parse('layouts/layout-a', $data);
	}

	public function obtenerLogin()
	{
		$skin = $this->input->cookie('cpo_skin');
		validateUrl($skin);
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader',array(),true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER , INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js','cypher/aes-json-format.min.js', 'obtener-login.js',  'jquery.validate.min.js',  'jquery-md5.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-recovery-login', array(), true);

		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function crearPasswordOperaciones()
	{
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER, INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'novo_helper.js', 'password-operaciones.js',  'jquery.validate.min.js',  'jquery-md5.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-password-operaciones', array(), true);

		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	public function crearPasswordSms()
	{
		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'transfer');

		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'perfil'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'novo_helper.js', "password-sms.js" , 'jquery-md5.js', 'jquery.balloon.min.js',  'jquery.validate.min.js',  'kendo.dataviz.min.js',  'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('users/content-password-sms', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function actualizarPasswordOperaciones()
	{
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'signin.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'novo_helper.js', 'actualizar-password-operaciones.js', 'jquery.validate.min.js', 'jquery-md5.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('users/content-password-operaciones-actualizar', array(), true);

		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function validarCaptcha()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$token = $dataRequest->token;
		$user = $dataRequest->user;
		$cookie = $this->input->cookie( $this->config->item('cookie_prefix') . 'skin');
		$result = TRUE;

		$_POST['token'] = $token;
		$_POST['user'] = $user;

		$this->form_validation->set_error_delimiters('', '---');
		if($cookie == 'pichincha') {
			$result = $this->form_validation->run('validatecaptcha');
			log_message('DEBUG', 'NOVO VALIDATION FORM login: '.json_encode($result));
		}

		unset($_POST);

		if($result) {
			$this->load->model('users_model','user');

			$this->output->set_content_type('application/json')->set_output($this->user->validar_captcha($dataRequest->token,$dataRequest->user));
		} else {
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			$response = [
				'rc'=> -9999
			];
			$response = $this->cryptography->encrypt($response);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}

	public function CallWsLogin()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);

		$user = $dataRequest->user_name;
		$pass = $dataRequest->user_pass;
		$codeOTP = $dataRequest->codeOTP;
		$saveIP = $dataRequest->saveIP;

		if (isset($codeOTP) && $codeOTP === '000') {

            $dataLogin = new stdClass();
            $dataLogin->username = $user;
            $dataLogin->password = $pass;
            $this->session->set_flashdata('firstDataRquest', $dataLogin);
		} else {
            $firstDataRequest = $this->session->flashdata('firstDataRquest');
			$user = $firstDataRequest->username;
			$pass = $firstDataRequest->password;
        }

		$cookie = $this->input->cookie( $this->config->item('cookie_prefix') . 'skin');
		$result = TRUE;

		$_POST['user'] = $user;
		$_POST['pass'] = $pass;
		$_POST['codeOTP'] = $codeOTP;
		$_POST['saveIP'] = $saveIP;

		$this->form_validation->set_error_delimiters('', '---');
		if($cookie == 'pichincha') {
			$result = $this->form_validation->run('login');
			log_message('DEBUG', 'NOVO VALIDATION FORM login: '.json_encode($result));
		}

		unset($_POST);
		$codeOTP = $codeOTP == '000'? '': $codeOTP;

		if($result) {
			$this->load->model('users_model','user');
			$this->output->set_content_type('application/json')->set_output($this->user->login_user($user, $pass, $codeOTP, $saveIP));
		} else {
			log_message('DEBUG', 'NOVO VALIDATION FORM login: '.json_encode($result));
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			$response = [
				'rc'=> -9999
			];
			$response = $this->cryptography->encrypt($response);
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsObtenerLogin()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);

		$id_ext_per = $dataRequest->id_ext_per;
		$email = $dataRequest->email;

		$this->load->model('users_model','obtenerlogin');

		$this->output->set_content_type('application/json')->set_output($this->obtenerlogin->obtener_login($id_ext_per, $email));

	}
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsResetPassword()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);

		$id_ext_per = $dataRequest->id_ext_per;
		$email = $dataRequest->email;

		$this->load->model('users_model','resetpassword');

		$this->output->set_content_type('application/json')->set_output($this->resetpassword->reset_password($id_ext_per, $email));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsActualizarPassword()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$passwordOld = $dataRequest->passwordOld;
		$passwordNew = $dataRequest->passwordNew;

		$this->load->model('users_model','actualizarPassword');

		$this->output->set_content_type('application/json')->set_output($this->actualizarPassword->actualizar_password($passwordOld, $passwordNew));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsCrearPasswordOperaciones()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}

		$passwordOperaciones = $this->input->post('passwordOperaciones');

		$this->load->model('users_model','passwordOperaciones');

		$this->session->set_userdata('passwordOperaciones', 'clave');

		$this->output->set_content_type('application/json')->set_output($this->passwordOperaciones->password_operaciones($passwordOperaciones));

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsCrearPasswordSms()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}

		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$id_ext_per = $dataRequest->id_ext_per;
		$claveSMS = $dataRequest->claveSMS;
		$nroMovil = $dataRequest->nroMovil;

		$this->load->model('users_model','passwordSmsCrear');

		$this->output->set_content_type('application/json')->set_output($this->passwordSmsCrear->password_sms_crear($id_ext_per,$claveSMS,$nroMovil));

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsActualizarPasswordSms()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}

		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$id_ext_per = $dataRequest->id_ext_per;
		$claveSMS = $dataRequest->claveSMS;
		$nroMovil = $dataRequest->nroMovil;

		$this->load->model('users_model','passwordSmsActualizar');

		$this->output->set_content_type('application/json')->set_output($this->passwordSmsActualizar->password_sms_actualizar($id_ext_per,$claveSMS,$nroMovil));

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsEliminarPasswordSms()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$id_ext_per = $this->input->post('id_ext_per');
		$claveSMS = $this->input->post('claveSMS');
		$nroMovil = $this->input->post('nroMovil');

		$this->load->model('users_model','passwordSmsEliminar');

		$this->output->set_content_type('application/json')->set_output($this->passwordSmsEliminar->password_sms_eliminar($id_ext_per,$claveSMS,$nroMovil));

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsActualizarPasswordOperaciones()
	{
		if(!$this->input->is_ajax_request()) {
			redirect(base_url('dashboard'), 'location');
			exit();
		}
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$passwordOperacionesOld = $dataRequest->passwordOperacionesOld;
		$passwordOperaciones = $dataRequest->passwordOperaciones;

		$this->load->model('users_model','actualizarPasswordOperaciones');

		$this->output->set_content_type('application/json')->set_output($this->actualizarPasswordOperaciones->actualizar_password_operaciones($passwordOperacionesOld, $passwordOperaciones));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function sesss()
	{

		print_r(json_encode($this->session->all_userdata()));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function closeSess(){

		$valorCookie=$this->input->cookie($this->config->item('cookie_prefix') . 'skin');
		$this->load->model('users_model','logout');
		$this->output->set_content_type('application/json')->set_output($this->logout->logout());

		$this->session->unset_userdata($this->session->all_userdata());
		$this->session->sess_destroy();
		switch($valorCookie){
			case 'pichincha': redirect($this->config->item('base_url') . '/pichincha/home/'); break;
			case 'latodo': redirect($this->config->item('base_url') . '/latodo/home/'); break;
		  default: redirect($this->config->item('base_url')); break;
		}

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}		//FIN GENERAL
