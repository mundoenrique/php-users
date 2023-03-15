<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para el doble factor de autenticacion
 * @author Luis Molina
 * @date August 22th, 2022
*/
class Novo_Mfa extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		writeLog('INFO', 'Mfa Controller Class Initialized');
	}

	/**
	 * @info Método que renderiza la vista para habilitar autenticación de dos factores
	 * @author Jennifer C Cadiz G.
	 * @date Jun 14th, 2022
	 */
	public function mfaEnable()
	{
		writeLog('INFO', 'Mfa: mfaEnable Method Initialized');

		$view = 'mfaEnable';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"mfa/mfaEnable"
		);

		$this->render->titlePage = LANG('GEN_MENU_MFA');
		$this->views = ['mfa/'.$view];
		$this->loadView($view);
	}

	/**
	 * @info Método que renderiza la vista para ingresar código autenticación de dos factores
	 * @author Jennifer C Cadiz G.
	 * @date Jun 14th, 2022
	 */
	public function mfaConfirm($otpChannel)
	{
		writeLog('INFO', 'Mfa: mfaConfirm Method Initialized');

		$view = 'mfaConfirm';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"mfa/mfaConfirm"
		);

		switch ($otpChannel) {
			case lang('SETT_MFA_APP'):
				$otpChannel = lang('SETT_MFA_CHANNEL_APP');
				break;
			case lang('SETT_MFA_EMAIL'):
				$otpChannel = lang('SETT_MFA_CHANNEL_EMAIL');
				break;
		}

		$this->request->channel = $otpChannel;
		$this->request->resendToken = FALSE;
		$this->modelMethod = 'callWs_ActivateSecretToken_Mfa';
		$responseMfa = $this->loadModel($this->request);
		$this->responseAttr($responseMfa);

		$this->render->channel = $otpChannel;
		$this->render->titlePage = LANG('GEN_MENU_MFA');
		$this->views = ['mfa/'.$view];
		$this->loadView($view);
	}
}
