<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la peticion de los servicios
 * @author Luis Molina.
 * @date June 29th, 2022
 */
class Novo_Mfa_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		writeLog('INFO', 'Mfa Model Class Initialized');
	}

	/**
	 * @info Método para generar Secret Token del multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_ActivateSecretToken_Mfa($dataRequest)
	{
		writeLog('INFO', 'Mfa Model: ActivateSecretToken Method Initialized');

		$this->dataRequest->uri = 'secret-token/generate';
		$this->dataRequest->requestBody = [
			'username' => $this->session->userName,
			'authenticationChannel' => $dataRequest->channel
		];

		$response = $this->sendToCoreServices('callWs_GenerateSecretToken');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response->info->data;
				break;
		}

		return $this->responseToTheView('callWs_GenerateSecretToken');
	}

	/**
	 * @info Método para Generar Otp de multifactor de autenticación
   * @author Luis Molina.
   * @date August 26th, 2022
	 */
	public function callWs_GenerateOtp2fa_Mfa($dataRequest)
  {
    log_message('INFO', 'NOVO Mfa Model: Mfa GenerateOtp2fa Method Initialized');

    $requestBody = [
      'username' => $this->session->userName
    ];

    log_message('INFO', '****NOVO Mfa Model dataRequest*****'.json_encode($requestBody));

    //$response = $this->sendToCoreServices('callWs_DesactivateSecretToken');
    $response = json_decode('{"code":"200"}');

		switch ($response->code) {
			case 200:
				if ($dataRequest->sendResendOtp2fa) {
					$this->response->code = 0;
				} else {
					$this->response->code = 2;
					$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
					$this->response->icon = lang('CONF_ICON_SUCCESS');
					$this->response->msg =  novoLang(lang('MFA_TWO_FACTOR_RESEND_CODE'), $this->session->maskMail);
					$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}
			break;
			default:
				$this->response->code = 3;
				$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}
    return $this->responseToTheView('callWs_GenerateOtp2fa');
  }

	/**
	 * @info Método para desactivar Secret Token de multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_GenerateOtp_Mfa($dataRequest)
  {
    writeLog('INFO', 'Mfa Model: GenerateOtp Method Initialized');

    $requestBody = [
      'username' => $this->session->userName
    ];

    log_message('INFO', '****NOVO Mfa Model dataRequest*****'.json_encode($requestBody));

    //$response = $this->sendToCoreServices('callWs_DesactivateSecretToken');
    $response = json_decode('{"code":"200"}');

    switch ($response->code) {
      case 200:
				if ($dataRequest->resendDisableSecretToken) {
          $this->response->code = 0;
					$this->response->msg = novoLang(lang('MFA_TWO_FACTOR_EMAIL_TEXT'), $this->session->maskMail);
				} else {
					$this->response->code = 2;
					$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
					$this->response->icon = lang('CONF_ICON_SUCCESS');
					$this->response->msg = novoLang(lang('MFA_TWO_FACTOR_RESEND_CODE'), $this->session->maskMail);
					$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}
      break;
			default:
				$this->response->code = 3;
				$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
    }
    return $this->responseToTheView('callWs_DesactivateSecretToken');
  }

	/**
	 * @info Método para validar codigo OTP de multifactor autenticación
   * @author Luis Molina.
   * @date Jul 07th, 2022
	 */
	public function callWs_ValidateOtp_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa ValidateOTP2fa Method Initialized');

		$requestBody = [
				'username' => $this->session->userName,
				'otpValue' => $dataRequest->authenticationCode,
				'operationType' => $dataRequest->operationType
		];

		$this->dataRequest->requestBody = $requestBody;

		log_message('INFO', '****NOVO Mfa Model REQUEST*****'.json_encode($this->dataRequest->requestBody));

		//$response = $this->sendToCoreServices('callWs_ValidateOTP2fa');
		$response = json_decode('{ "code": "200", "message": "string", "datetime": "string","data": {"validationResult": true }}');

		log_message('INFO', '****NOVO Mfa Model RESPONSE*****'.json_encode($response));

    switch ($response->code) {
      case 200:
				switch ($dataRequest->operationType) {
					case lang('CONF_MFA_ACTIVATE_SECRET_TOKEN'):
						$this->response->code = 0;
						$this->response->msg = lang('MFA_TWO_FACTOR_ENABLED');
						$this->response->modalBtn['btn1']['link'] = 'card-list';
						$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
						$this->response->icon = lang('CONF_ICON_SUCCESS');
						$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
						$this->response->modalBtn['btn1']['action'] = 'redirect';
						$this->session->set_userdata('otpActive', TRUE);
						$this->session->set_userdata('otpChannel', $dataRequest->channel);
					break;
					case lang('CONF_MFA_DESACTIVATE_SECRET_TOKEN'):
						$this->response->code = 2;
						$this->response->msg = lang('MFA_TWO_FACTOR_DISABLED_REDIRECT');
						$this->response->modalBtn['btn1']['link'] = 'two-factor-enablement';
						$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
						$this->response->icon = lang('CONF_ICON_SUCCESS');
						$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
						$this->response->modalBtn['btn1']['action'] = 'redirect';
						$this->session->set_userdata('otpActive', FALSE);
						$this->session->set_userdata('otpChannel', '');
						$this->session->set_userdata('otpMfaAuthorization', FALSE);
					break;
					case lang('CONF_MFA_VALIDATE_OTP'):
						$this->response->code = 0;
						$this->response->modal = TRUE;
						$this->session->set_userdata('otpMfaAuthorization', TRUE);
					break;
				}
      break;
      case 405:
				$this->response->code = 3;
				$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			default:
				$this->response->code = 3;
				$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
    }
		return $this->responseToTheView('callWs_ValidateOTP');
	}
}
