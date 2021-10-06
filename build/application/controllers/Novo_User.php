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

	}
	/**
	 * @info Método para el inicio de sesión
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function signin()
	{
		log_message('INFO', 'NOVO User: signin Method Initialized');

		languageCookie(BASE_LANGUAGE);
		$view = 'signin';

		if ($this->session->has_userdata('logged')) {
			redirect(base_url(lang('CONF_LINK_CARD_LIST')), 'location', 301);
			exit();
		}

		if ($this->session->has_userdata('userId')) {
			clearSessionsVars();
		}

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.balloon",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/signin"
		);

		if($this->customerUri === 'bp' && ENVIRONMENT === 'production') {
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

		languageCookie(BASE_LANGUAGE);
		$view = 'userIdentify';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/sharedFunctions",
			"user/userIdentify"
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
	 * @modified Jhonnatan Vega
	 * @date January 08th, 2021
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
			"third_party/jquery.mask-1.14.16",
			"user/validPass",
			"user/getRegions",
			"user/sharedFunctions",
			"user/signup"
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

		$this->render->previewINE_A = FALSE;
		$this->render->previewINE_R = FALSE;
		$this->render->previewPASS_A = FALSE;
		$this->render->previewPASS_R = FALSE;

		$this->render->countryDocument = lang('CONF_COUNTRY_DOCUMENT')[$this->session->customerSess];
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_SIGNUP');
		$this->render->updateName = lang('CONF_UPDATE_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->updateLastName = lang('CONF_UPDATE_SECOND_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->updatePhone = lang('CONF_UPDATE_PHONE_MOBILE') == 'OFF' ? 'readonly' : '';
		$this->render->updateEmail = lang('CONF_UPDATE_EMAIL') == 'OFF' ? 'readonly' : '';
		$this->render->skipConfirmEmail = lang('CONF_UPDATE_EMAIL') == 'OFF' ? 'hide' : '';
		$this->render->skipLandLine = lang('CONF_LANDLINE') == 'OFF' ? 'hide' : '';
		$this->render->skipOtherPhone = lang('CONF_OTHER_PHONE') == 'OFF' ? 'hide' : '';
		$this->render->longMobile = lang('CONF_INTERNATIONAL_ADDRESS') == 'OFF' ? 'col-lg-4' : 'col-lg-2';
		$this->render->dataUser = $this->session->longProfile == 'S' ? 'col-lg-6' : 'col-lg-12';
		$this->render->dataPass = $this->session->longProfile == 'S' ? '' : 'col-lg-6';
		$this->render->dataStep = $this->session->longProfile == 'S' ? 'col-lg-12' : 'col-lg-7';
		$this->render->stepTitles = $this->session->longProfile == 'S' ? lang('USER_STEP_TITLE_REGISTRY_LONG') : lang('USER_STEP_TITLE_REGISTRY');

		if (lang('CONF_LOAD_DOCS') == 'OFF') {
      foreach ($this->render->stepTitles as $key => $value) {
        if ($value == lang('USER_LOAD_DOCS_STEP')) {
          unset($this->render->stepTitles[$key]);
        }
      }
      $this->render->stepTitles = array_values($this->render->stepTitles);
    }

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

		languageCookie(BASE_LANGUAGE);
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
			$cancelBtn = $this->agent->referrer() != '' ? $this->agent->referrer() : base_url(lang('CONF_LINK_CARD_LIST')) ;
			$this->render->message = novoLang(lang('USER_PASS_CHANGE'), lang('GEN_SYSTEM_NAME'));
		}

		if ($this->session->flashdata('changePassword') != NULL) {
			$cancelBtn = base_url(lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START'));

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
			"third_party/jquery.mask-1.14.16",
			"user/getRegions",
			"user/sharedFunctions",
			"user/profileUser"
		);

		$dataUser = $this->loadModel();

		$this->responseAttr($dataUser);

		foreach($dataUser->data->profileData AS $index => $render) {
			$this->render->$index = $render;
		}

		foreach($dataUser->data->phonesList AS $index => $render) {
			$this->render->$index = $render;
		}

		$this->render->previewINE_A = FALSE;
		$this->render->previewINE_R = FALSE;
		$this->render->previewPASS_A = FALSE;
		$this->render->previewPASS_R = FALSE;

		$inputPreviewImage = ['INE_A', 'INE_R'];
		if (strtoupper($this->render->img_valida) == 'TRUE') {
			foreach ($inputPreviewImage as $value) {
				if (key_exists($value, $this->render->imagesLoaded)) {
					$attributeInput = 'preview'.$value;
					$this->render->$attributeInput = key_exists('base64', $this->render->imagesLoaded[$value]) ? TRUE : FALSE;
				}
			}
		}

		$this->render->countryDocument = lang('CONF_COUNTRY_DOCUMENT')[$this->session->customerSess];
		$this->render->titlePage = lang('GEN_MENU_PROFILE');
		$this->render->updateUser = lang('CONF_UPDATE_USER') == 'OFF' ? 'no-write' : '';
		$this->render->disabled = lang('CONF_UPDATE_USER') == 'OFF' ? 'disabled' : '';
		$this->render->updateName = lang('CONF_UPDATE_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->updateSecondName = lang('CONF_UPDATE_SECOND_NAME') == 'OFF' ? 'readonly' : '';
		$this->render->updatePhoneMobile = lang('CONF_UPDATE_PHONE_MOBILE') == 'OFF' ? 'readonly' : '';
		$this->render->updateEmail = lang('CONF_UPDATE_EMAIL') == 'OFF' ? 'readonly' : '';
		$this->render->skipProfession = lang('CONF_PROFESSION') == 'OFF' ? 'hide' : '';
		$this->render->ignoreProfession = lang('CONF_PROFESSION') == 'OFF' ? 'ignore' : '';
		$this->render->skipContacData = lang('CONF_CONTAC_DATA') == 'OFF' ? 'hide' : '';
		$this->render->ignoreContacData = lang('CONF_CONTAC_DATA') == 'OFF' ? 'ignore' : '';
		$this->render->skipConfirmEmail = lang('CONF_UPDATE_EMAIL') == 'OFF' ? 'hide' : '';
		$this->render->ignoreConfirmEmail = lang('CONF_UPDATE_EMAIL') == 'OFF' ? 'ignore' : '';
		$this->render->skipLandLine = lang('CONF_LANDLINE') == 'OFF' ? 'hide' : '';
		$this->render->ignoreLandLine = lang('CONF_LANDLINE') == 'OFF' ? 'ignore' : '';
		$this->render->skipOtherPhone = lang('CONF_OTHER_PHONE') == 'OFF' ? 'hide' : '';
		$this->render->ignoreOtherPhone = lang('CONF_OTHER_PHONE') == 'OFF' ? 'ignore' : '';
		$this->render->skipSms = lang('CONF_CHECK_NOTI_SMS') == 'OFF' ? 'hide' : '';
		$this->render->skipEmail = lang('CONF_CHECK_NOTI_EMAIL') == 'OFF' ? 'hide' : '';
		$this->render->longMobile = lang('CONF_INTERNATIONAL_ADDRESS') == 'OFF' ? 'col-lg-4' : 'col-lg-2';
		$this->render->skipBoth = lang('CONF_CHECK_NOTI_EMAIL') == 'OFF' && lang('CONF_CHECK_NOTI_SMS') == 'OFF' ? 'hide' : '';
		$this->render->terms = $this->session->terms;
		$this->render->imagesLoaded = $this->render->imagesLoaded ?? [];
		$this->render->dataStep = $this->session->longProfile == 'S' ? 'col-lg-12' : 'col-lg-7';
		$this->render->stepTitles = $this->session->longProfile == 'S' ? lang('USER_STEP_TITLE_REGISTRY_LONG') : lang('USER_STEP_TITLE_REGISTRY');

		if (lang('CONF_LOAD_DOCS') == 'OFF') {
      foreach ($this->render->stepTitles as $key => $value) {
        if ($value == lang('USER_LOAD_DOCS_STEP')) {
          unset($this->render->stepTitles[$key]);
        }
      }
      $this->render->stepTitles = array_values($this->render->stepTitles);
		}

		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 18th, 2020
	 */
	public function finishSession($redirect)
	{
		log_message('INFO', 'NOVO User: finishSession Method Initialized');

		$view = 'finishSession';

		$callFinishSession = $this->session->has_userdata('userId') || $this->session->has_userdata('logged');

		if($callFinishSession) {
			$this->load->model('Novo_User_Model', 'finishSession');
			$this->finishSession->callWs_FinishSession_User();
		}

		if($redirect == lang('CONF_LINK_SIGNOUT_END') && $callFinishSession) {
			$pos = array_search('sessionControl', $this->includeAssets->jsFiles);
			$this->render->action = base_url(lang('CONF_LINK_SIGNIN'));
			$this->render->showBtn = TRUE;
			$this->render->sessionEnd = novoLang(lang('GEN_EXPIRED_SESSION'), lang('GEN_SYSTEM_NAME'));

			unset($this->includeAssets->jsFiles[$pos]);
			$this->render->activeHeader = TRUE;
			$this->render->skipProductInf = TRUE;
			$this->render->titlePage = LANG('GEN_FINISH_TITLE');
			$this->views = ['user/'.$view];
			$this->loadView($view);
		} else {
			redirect(base_url(lang('CONF_LINK_SIGNIN')), 'location', 301);
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
			redirect(base_url(lang('CONF_LINK_SIGNIN')), 'location', 301);
			exit();
		}

		$views = ['staticpages/content-browser'];
		$this->includeAssets->cssFiles = [
			"$this->customerUri/"."$this->customerUri-browser",
			"reboot"
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
}
