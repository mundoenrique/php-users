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
		log_message('INFO', 'NOVO Mfa Model Class Initialized');
	}

	/**
	 * @info Método para generar Secret Token del multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_GenerateSecretToken_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa GenerateSecretToken Method Initialized');

		$this->dataRequest->uri = 'mfa/secrettoken/generate';
		$this->dataRequest->requestBody = [
			'username' => $this->session->userName,
			'authenticationChannel' => 'THIRD_PARTY_APP'
		];

		$response = $this->sendToCoreServices('callWs_GenerateSecretToken');

		switch ($authenticationChannel) {
			case lang('CONF_MFA_CHANNEL_APP'):
				$response = json_decode('{"code":"200","datetime":"2022-08-02T15:33:07.154Z[UTC]","message":"Process Ok","data":{"appName":"Conexion personas","qrCode":"iVBORw0KGgoAAAANSUhEUgAAAMgAAADIAQAAAACFI5MzAAAB8ElEQVR4Xu2XUWoDMQxEDb6WQVc36FoL7rzZbWgK/ZOghZolIX4Gj6SxvBnnpzG+T7zGP/n1ZI8xzxXX3POK3GN6op6knj3PjrOZDE90kD3zVrCGdXiih2jvtUKhDtFGcs2Tye5K8LuCQqJHoQ7Dxecro6UEQ+TX8eadOuKhGKVCE/fH7fhacntc9Vp4ZHlEA8kdl9wRhHzziYpy4sIdpvSl0rHyVlBL1B4UbsgeUqDZKT3ZQZRR5TQ4VRorvLSePNZAgSpGu9iPglrCkV2yhoQEaU3W9hD2Vu/DIJGX+F25WnJpb7UIErmd0ZeCWpIunvy+cL4ojmwgYhwr7YyGIL3RQhTmcsU24VK+HuIWIap7yQklxQ1EzYFM2vHqTMONvYGoiWNGKVCQMqMEPZHWEjySPk/Xff0Z1xPNUjJXT62JlM4WcvFGd+h+EzmJMTuIDhZneGBDJVMlbCGEOdGxWUCYXQTnJfeSvK68urE3EOrE47LpxhifN3otSX5oa+0cyEj6YAuJJ6tooS99nqxiokGTWCzwKR6gcsLYinEK24i8rjQQDMh/iBFw3GgrlhP7I/HjZokVnA7iX8fbct2ad5HkbE1ftRjyibSeqCu5s/JFxB0EyNaUMN1h16OglNgh4W1xvo7yqyOVkh/GP/mr5AMhn0ZEpGg3rwAAAABJRU5ErkJggg==","qrCodeUrl":"otpauth://totp/Conexion%20personas:Novopayment?secret=EFN4FB227APRY5YW&issuer=Conexion+personas&algorithm=SHA1&digits=6&period=30","secretToken":"EFN4FB227APRY5YW"}}');
			break;
			default:
				$response = json_decode('{"code":"200","message":"-----------Email-------------","datetime":"2012-10-01T09:45:00.000+02:00","data":""}');
			break;
		}
		log_message('INFO', '****NOVO Mfa PRUEBA RESPONSE*****'.json_encode($response));

		switch ($response->code) {
			case 200:
				if ($dataRequest->sendResendToken) {
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
				$this->response->modalBtn['btn1']['link'] = 'two-factor-enablement';
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'redirect';
			break;
		}

		$this->response->data = $response->data;
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
	public function callWs_DesactivateSecretToken_Mfa($dataRequest)
  {
    log_message('INFO', 'NOVO Mfa Model: Mfa DesactivateSecretToken Method Initialized');

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
	public function callWs_ValidateOTP2fa_Mfa($dataRequest)
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
