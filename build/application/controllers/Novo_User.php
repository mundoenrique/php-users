<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza Piñero
 * @date May 20th, 2020
*/
class Novo_User extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Controller Class Initialized');

		$this->CI = &get_instance();
    $this->key_api = $this->CI->config->item('key_api');
	}
	/**
	 * @info Método para el inicio de sesión
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function signin()
	{
		log_message('INFO', 'NOVO User: signin Method Initialized');

		$view = 'signin';

		if ($this->session->has_userdata('logged')) {
			redirect(base_url(lang('GEN_LINK_CARDS_LIST')), 'location', 301);
			exit();
		}

		if ($this->session->has_userdata('userId')) {
			clearSessionsVars();
		}

		if ($this->render->activeRecaptcha) {
			$this->load->library('recaptcha');
			$this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
		}

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.balloon",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/signin"
		);

		if($this->skin === 'pichincha' && ENVIRONMENT === 'production') {
			array_push(
				$this->includeAssets->jsFiles,
				"third_party/borders"
			);
		}

		$this->render->skipProductInf = TRUE;
		$this->render->titlePage = lang('GEN_SYSTEM_NAME');
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método que renderiza la vista la identificación positiva del usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function userIdentify()
	{
		log_message('INFO', 'NOVO User: userIdentify Method Initialized');

		$view = 'userIdentify';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/userIdentify",
			"user/manageImageTerm"
		);
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_USER_IDENTIFY');
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para el registro del usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function signup()
	{
		log_message('INFO', 'NOVO User: signup Method Initialized');

		$view = 'signup';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/validPass",
			"user/signup",
			"user/manageImageTerm"
		);

		$dataUser = json_decode(base64_decode($this->request->dataUser));
		$dataUser = json_decode($this->cryptography->decrypt(
			base64_decode($dataUser->plot),
			utf8_encode($dataUser->password)
		));
		$dataUser = $dataUser->dataUser;

		foreach ($dataUser->signUpData AS $index => $render) {
			$this->render->$index = $render;
		}

		foreach ($dataUser->affiliation AS $index => $render) {
			$this->render->$index = $render;
		}

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_SIGNUP');
		$this->render->updateName = lang('CONF_UPDATE_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->skipLandLine = lang('CONF_LANDLINE') == 'OFF' ? 'hide' : '';
		$this->render->skipOtherPhone = lang('CONF_OTHER_PHONE') == 'OFF' ? 'hide' : '';
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método que renderiza la vista para recuperar el acceso a la aplicación
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function accessRecover()
	{
		log_message('INFO', 'NOVO User: accessRecover Method Initialized');

		$view = 'accessRecover';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/accessRecover"
		);
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_ACCESS_RECOVER');
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método que renderiza la vista para cambiar la contraseña
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function changePassword()
	{
		log_message('INFO', 'NOVO User: changePassword Method Initialized');

		$view = 'changePassword';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/changePassword"
		);

		if ($this->session->logged) {
			$cancelBtn = base_url('perfil-usuario');
			$this->render->message = novoLang(lang('USER_PASS_CHANGE'), lang('GEN_SYSTEM_NAME'));
		}

		if ($this->session->flashdata('changePassword') != NULL) {
			$cancelBtn = base_url('cerrar-sesion/inicio');

			switch($this->session->flashdata('changePassword')) {
				case 'TemporalPass':
					$this->render->message = novoLang(lang("USER_PASS_TEMPORAL"), lang('GEN_SYSTEM_NAME'));
				break;
				case 'expiredPass':
					$this->render->message = novoLang(lang("USER_PASS_EXPIRED"), lang('GEN_SYSTEM_NAME'));
				break;
			}

			$this->session->set_flashdata('changePassword', $this->session->flashdata('changePassword'));
		}

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = LANG('GEN_MENU_CHANGE_PASS');
		$this->render->cancelBtn = $cancelBtn;
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener el perfil del usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function profileUser()
	{
		log_message('INFO', 'NOVO User: profileUser Method Initialized');

		$view = 'profileUser';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/profileUser",
			"user/manageImageTerm"
		);

		$dataUser = $this->loadModel();

		$this->responseAttr($dataUser);

		foreach($dataUser->data->profileData AS $index => $render) {
			$this->render->$index = $render;
		}

		foreach($dataUser->data->phonesList AS $index => $render) {
			$this->render->$index = $render;
		}

		$this->render->titlePage = lang('GEN_MENU_PORFILE');
		$this->render->updateUser = lang('CONF_UPDATE_USER') == 'OFF' ? 'no-write' : '';
		$this->render->disabled = lang('CONF_UPDATE_USER') == 'OFF' ? 'disabled' : '';
		$this->render->updateName = lang('CONF_UPDATE_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->skipProfession = lang('CONF_PROFESSION') == 'OFF' ? 'hide' : '';
		$this->render->skipContacData = lang('CONF_CONTAC_DATA') == 'OFF' ? 'hide' : '';
		$this->render->skipLandLine = lang('CONF_LANDLINE') == 'OFF' ? 'hide' : '';
		$this->render->skipOtherPhone = lang('CONF_OTHER_PHONE') == 'OFF' ? 'hide' : '';
		$this->render->skipSms = lang('CONF_CHECK_NOTI_SMS') == 'OFF' ? 'hide' : '';
		$this->render->skipEmail = lang('CONF_CHECK_NOTI_EMAIL') == 'OFF' ? 'hide' : '';
		$this->render->skipBoth = lang('CONF_CHECK_NOTI_EMAIL') == 'OFF' && lang('CONF_CHECK_NOTI_SMS') == 'OFF' ? 'hide' : '';
		$this->render->dataUser = $this->session->longProfile == 'S' ? 'col-lg-6' : 'col-lg-12';
		$this->render->dataUserOptions = $this->session->longProfile == 'S' ? 'col-6' : 'col-4';
		$this->render->terms = $this->session->terms;
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function finishSession($redirect)
	{
		log_message('INFO', 'NOVO User: finishSession Method Initialized');

		$view = 'finishSession';

		if($this->render->userId || $this->render->logged) {
			$this->load->model('Novo_User_Model', 'finishSession');
			$this->finishSession->callWs_FinishSession_User();
		}

		if($redirect == 'fin') {
			$pos = array_search('sessionControl', $this->includeAssets->jsFiles);
			$this->render->action = base_url('inicio');
			$this->render->showBtn = TRUE;
			$this->render->sessionEnd = novoLang(lang('GEN_EXPIRED_SESSION'), lang('GEN_SYSTEM_NAME'));

			unset($this->includeAssets->jsFiles[$pos]);
			$this->render->activeHeader = TRUE;
			$this->render->skipProductInf = TRUE;
			$this->render->titlePage = LANG('GEN_FINISH_TITLE');
			$this->views = ['user/'.$view];
			$this->loadView($view);
		} else {
			redirect(base_url('inicio'), 'location');
		}

	}
	/**
	 * @info Método que renderiza la vista de segerencias de navegador
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function suggestion()
	{
		log_message('INFO', 'NOVO User: suggestion Method Initialized');

		$view = 'suggestion';

		if(!$this->session->flashdata('messageBrowser')) {
			redirect(base_url('inicio'), 'location', 301);
			exit();
		}

		$views = ['staticpages/content-browser'];
		$this->includeAssets->cssFiles = [
			"$this->folder/"."$this->skin-browser"
		];
		$messageBrowser = $this->session->flashdata('messageBrowser');
		$this->render->activeHeader = TRUE;
		$this->render->platform = $messageBrowser->platform;
		$this->render->title = $messageBrowser->title;
		$this->render->msg1 = $messageBrowser->msg1;
		$this->render->msg2 = $messageBrowser->msg2;
		$this->render->titlePage = lang('GEN_SYSTEM_NAME');
		$this->views = $views;
		$this->loadView($view);
	}
		/**
	 * @info Método que renderiza la vista de terminos y condiciones
	 * @author Hector D Corredor.
	 * @date Jul 21th, 2020
	 */
	public function termsConditions()
	{
		log_message('INFO', 'NOVO User: termsConditions Method Initialized');

		$view = 'termsConditions';
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_TERMS_TITLE');
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}

	public function generateHash()
  {
    $statusResponse = 400;
    $response = '';
    $password = NULL;
    $key = FALSE;

    $inputData = $this->input->post();
    if (count($inputData) > 0) {

      $bodyRequest = json_decode($this->encrypt_connect->cryptography($inputData['request'], FALSE));
      if (!is_null($bodyRequest)) {

        $password = trim($bodyRequest->password) == '' ? NULL : $bodyRequest->password;
        $key = $bodyRequest->key === $this->key_api;
      }
    }

    if (!is_null($password) && $key) {

      $argon2 = $this->encrypt_connect->generateArgon2($password);
      $bodyResponse = [
        'key' => $this->key_api,
        'password' => $argon2->hexArgon2
      ];
      $statusResponse = 200;

      $dataResponse = json_encode($bodyResponse);
      $response = $this->encrypt_connect->cryptography($dataResponse, TRUE);
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header($statusResponse)
      ->set_output(json_encode(
        [
          'response' => $response
        ]
      ));
  }
}
