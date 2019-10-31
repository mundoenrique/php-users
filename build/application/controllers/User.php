<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class User extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Controller class Initialized');
	}
	/**
	 * @info Método que renderiza la vista de login
	 * @author J. Enrique Peñaloza P.
	 */
	public function login()
	{
		log_message('INFO', 'NOVO User: index Method Initialized');
		$view = 'login';

		if($this->session->userdata('logged')) {

			redirect(base_url('empresas'), 'location');
			exit();
		}

		$userData = [
			'sessionId',
			'idUsuario',
			'userName',
			'fullName',
			'codigoGrupo',
			'lastSession',
			'token',
			'cl_addr',
			'countrySess',
			'pais',
			'nombreCompleto'
		];

		$this->session->unset_userdata($userData);

		$this->load->library('user_agent');
		$this->load->library('recaptcha');

		$this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
		log_message('DEBUG', 'NOVO RESPONSE: recaptcha: ' . $this->recaptcha->getScriptTag());

		$browser = strtolower($this->agent->browser());
		$version = (float) $this->agent->version();
		$noBrowser = "internet explorer";
		$views = ['user/'.$view];
		if($this->countryUri == 'bp') {
			$views = ['user/signin'];
		}
		if($browser == $noBrowser && $version < 11.0) {
			$views = ['staticpages/content-browser'];
		}
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.md5",
			"third_party/jquery.balloon",
			"third_party/jquery.validate",
			"validate-forms",
			"third_party/additional-methods",
			"$this->countryUri/user/login",
			"$this->countryUri/clave",
			"localization/spanish-base/messages_base"
		);
		if($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}
		if($this->countryUri !== 'bp') {
			array_push(
				$this->includeAssets->jsFiles,
				"third_party/jquery.kwicks",
				"$this->countryUri/user/kwicks"
			);
		}
		if($this->countryUri === 'bp' && ENVIRONMENT === 'production') {
			array_push(
				$this->includeAssets->jsFiles,
				"third_party/borders"
			);
		}

		if($this->render->activeRecaptcha) {
			$this->load->library('recaptcha');
			$this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
			$this->render->loginUri = 'validateCaptcha';
		}

		$this->views = $views;
		$this->render->titlePage = lang('SYSTEM_NAME');

		$this->loadView($view);
	}
	/**
	 * @info Método que renderiza la vista para recuperar la contraseña
	 * @author J. Enrique Peñaloza P.
	 */
	public function recoveryPass()
	{
		$view = 'pass-recovery';

		log_message('INFO', 'NOVO User: passwordRecovery Method Initialized');
		array_push(
			$this->includeAssets->jsFiles,
			"user/pass-recovery",
			"third_party/jquery.validate",
			"validate-forms",
			"third_party/additional-methods"
		);
		$this->views = ['user/'.$view];
		$this->render->titlePage = lang('PASSRECOVERY_TITLE');
		$this->loadView($view);
	}
	/**
	 * @info Método que renderiza la vista para cambiar la contraseña
	 * @author J. Enrique Peñaloza P.
	 */
	public function changePassword()
	{
		$view = 'change-password';
		log_message('INFO', 'NOVO User: changePassword Method Initialized');
		if(!$this->session->flashdata('changePassword')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}
		$this->lang->load([$view], 'base-spanish');
		if(in_array($view, $this->config->item('language_file_specific')) ) {
			$this->lang->load($view);
		}
		array_push(
			$this->includeAssets->jsFiles,
			"user/change-pass",
			"third_party/jquery.md5",
			"third_party/jquery.balloon",
			"third_party/jquery.validate",
			"validate-forms",
			"third_party/additional-methods"
		);
		switch($this->session->flashdata('changePassword')) {
			case 'newUser':
			$this->render->message = lang("MSG_NEW_PASS_USER");
			break;
			case 'expiredPass':
			$this->render->message = lang("MSG_NEW_PASS_CADU");
			break;
		}

		$this->render->fullName = $this->session->userdata('fullName');
		$this->render->userType = $this->session->flashdata('userType');
		$this->views = ['user/'.$view];
		$this->render->titlePage = LANG('CHANGEPASSWORD_TITLE');

		$this->session->set_flashdata('changePassword', $this->session->flashdata('changePassword'));
		$this->session->set_flashdata('userType', $this->session->flashdata('userType'));

		$this->loadView($view);
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza P.
	 */
	public function finishSession()
	{
		log_message('INFO', 'NOVO User: finishSession Method Initialized');
		if($this->render->logged) {
			$this->load->model('Novo_User_Model', 'finishSession');
			$this->finishSession->callWs_FinishSession_User();
		}
		redirect(base_url('inicio'), 'location');
	}

	public function preRegistry()
	{
		$view = 'validate';

		log_message('INFO', 'NOVO User: preRegistry Method Initialized');
		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/user/$view",
			"third_party/jquery.validate",
			"validate-forms",
			"third_party/additional-methods",
			"localization/spanish-base/messages_base"
		);
		if($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}
		$this->views = ['user/'.$view];
		$this->render->titlePage = lang('PASSRECOVERY_TITLE');
		$this->loadView($view);
	}

	public function registry()
	{
		$view = 'registry';
		if(!$this->session->flashdata('registryUser')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}
		$this->session->set_flashdata('registryUserData', $this->session->flashdata('registryUserData'));
		$this->session->set_flashdata('registryUser', $this->session->flashdata('registryUser'));

		log_message('INFO', 'NOVO User: registry Method Initialized');
		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/user/$view",
			"third_party/jquery.validate",
			"third_party/moment",
			"validate-forms",
			"third_party/additional-methods",
			"localization/spanish-base/messages_base"
		);
		if($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}
		$this->views = ['user/'.$view];
		$this->render->data = $this->session->flashdata('registryUserData');
		$this->render->titlePage = lang('PASSRECOVERY_TITLE');
		$this->loadView($view);
	}
}
