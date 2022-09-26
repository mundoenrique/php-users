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
	public function twoFactorEnablement()
	{
		writeLog('INFO', 'Mfa: twoFactorEnablement Method Initialized');

		$view = 'twoFactorEnablement';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"mfa/twoFactorEnablement"
		);

		if ($this->session->otpActive == TRUE) {
			redirect(base_url(lang('CONF_LINK_CARD_LIST')), 'Location', 301);
		}

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = LANG('GEN_MENU_TWO_FACTOR_ENABLEMENT');
		$this->views = ['mfa/'.$view];
		$this->loadView($view);
	}

	/**
	 * @info Método que renderiza la vista para ingresar código autenticación de dos factores
	 * @author Jennifer C Cadiz G.
	 * @date Jun 14th, 2022
	 */
	public function twoFactorCode($value)
	{
		writeLog('INFO', 'Mfa: twoFactorCode Method Initialized');

		$view = 'twoFactorCode';

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"mfa/twoFactorCode"
		);

		if (empty((array)$this->request) && $this->session->otpActive == TRUE) {
			redirect(base_url(lang('CONF_LINK_CARD_LIST')), 'Location', 301);
		}

		switch ($value) {
			case lang('CONF_MFA_APP'):
				$value = lang('CONF_MFA_CHANNEL_APP');
				break;
			case lang('CONF_MFA_EMAIL'):
				$value = lang('CONF_MFA_CHANNEL_EMAIL');
				break;
		}

		$this->render->channel = $value;
		$this->render->activeHeader = TRUE;
		$this->render->titlePage = LANG('GEN_MENU_TWO_FACTOR_ENABLEMENT');
		$this->views = ['mfa/'.$view];
		$this->loadView($view);
	}
}
