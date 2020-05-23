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

		$view = 'signin';

		if ($this->session->has_userdata('logged')) {
			redirect(base_url(lang('GEN_LINK_CARDS_LIST')), 'location', 301);
			exit();
		}

		if($this->render->activeRecaptcha) {
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
			"user/signup"
		);

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_SIGNUP');
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
			"user/user_identify"
		);
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_USER_IDENTIFY');
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

		/* if(!$this->session->flashdata('changePassword')) {
			redirect(base_url('inicio'), 'location');
			exit();
		} */

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/changePassword"
		);

		/* switch($this->session->flashdata('changePassword')) {
			case 'newUser':
			$this->render->message = novoLang(lang("PASSWORD_NEWUSER"), lang('GEN_SYSTEM_NAME'));
			break;
			case 'expiredPass':
			$this->render->message = novoLang(lang("PASSWORD_EXPIRED"), lang('GEN_SYSTEM_NAME'));
			break;
		} */

		/* $this->render->userType = $this->session->flashdata('userType');
		$this->session->set_flashdata('changePassword', $this->session->flashdata('changePassword'));
		$this->session->set_flashdata('userType', $this->session->flashdata('userType')); */
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = LANG('GEN_MENU_CHANGE_PASS');
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
		log_message('INFO', '*************************************    '.json_encode($this->session->all_userdata()));


		if($redirect == 'fin') {
			$pos = array_search('datepicker_options', $this->includeAssets->jsFiles);
			$this->render->action = base_url('inicio');
			$this->render->showBtn = TRUE;
			$this->render->sessionEnd = novoLang(lang('GEN_EXPIRED_SESSION'), lang('GEN_SYSTEM_NAME'));

			unset($this->includeAssets->jsFiles[$pos]);
			$this->render->activeHeader = TRUE;
			$this->render->skipProductInf = TRUE;
			$this->render->titlePage = LANG('GEN_FINISH_TITLE');
			$this->views = ['user/'.$view];
			$this->loadView($view);
			$this->session->sess_destroy();
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
	 * @info Método para obtener el perfil del usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function profile()
	{
		log_message('INFO', 'NOVO User: profile Method Initialized');

		$view = 'profile';
		array_push(
			$this->includeAssets->jsFiles,
			"user/profile"
		);

		$this->render->activeHeader = TRUE;
		$this->render->activeMenuUser = TRUE;
		$this->render->titlePage = lang('GEN_MENU_PORFILE');
		$this->views = ['user/'.$view];
		$this->loadView($view);
	}
}
