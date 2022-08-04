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

		$authenticationChannel = $dataRequest->channel == LANG('GEN_APP') ? 'thirdPartyApp' : 'Email';
		$method = $dataRequest->method;

		$requestBody = [
			'authenticationChannel' => $authenticationChannel,
			'username' => $this->session->userName
		];

		$this->dataRequest->requestBody = $requestBody;

		log_message('INFO', '****NOVO Mfa Model REQUEST*****'.json_encode($this->dataRequest->requestBody));

		//$response = $this->sendToCoreServices('callWs_GenerateSecretToken');

		switch ($dataRequest->channel) {
			case 'app':
				$response = json_decode('{"code":"200.00.000","datetime":"2022-08-02T15:33:07.154Z[UTC]","message":"Process Ok","data":{"appName":"Conexion personas","qrCode":"iVBORw0KGgoAAAANSUhEUgAAAMgAAADIAQAAAACFI5MzAAAB8ElEQVR4Xu2XUWoDMQxEDb6WQVc36FoL7rzZbWgK/ZOghZolIX4Gj6SxvBnnpzG+T7zGP/n1ZI8xzxXX3POK3GN6op6knj3PjrOZDE90kD3zVrCGdXiih2jvtUKhDtFGcs2Tye5K8LuCQqJHoQ7Dxecro6UEQ+TX8eadOuKhGKVCE/fH7fhacntc9Vp4ZHlEA8kdl9wRhHzziYpy4sIdpvSl0rHyVlBL1B4UbsgeUqDZKT3ZQZRR5TQ4VRorvLSePNZAgSpGu9iPglrCkV2yhoQEaU3W9hD2Vu/DIJGX+F25WnJpb7UIErmd0ZeCWpIunvy+cL4ojmwgYhwr7YyGIL3RQhTmcsU24VK+HuIWIap7yQklxQ1EzYFM2vHqTMONvYGoiWNGKVCQMqMEPZHWEjySPk/Xff0Z1xPNUjJXT62JlM4WcvFGd+h+EzmJMTuIDhZneGBDJVMlbCGEOdGxWUCYXQTnJfeSvK68urE3EOrE47LpxhifN3otSX5oa+0cyEj6YAuJJ6tooS99nqxiokGTWCzwKR6gcsLYinEK24i8rjQQDMh/iBFw3GgrlhP7I/HjZokVnA7iX8fbct2ad5HkbE1ftRjyibSeqCu5s/JFxB0EyNaUMN1h16OglNgh4W1xvo7yqyOVkh/GP/mr5AMhn0ZEpGg3rwAAAABJRU5ErkJggg==","qrCodeUrl":"otpauth://totp/Conexion%20personas:Novopayment?secret=EFN4FB227APRY5YW&issuer=Conexion+personas&algorithm=SHA1&digits=6&period=30","secretToken":"EFN4FB227APRY5YW"}}');
			break;
			default:
				$response = json_decode('{"code":"0","message":"-----------Email-------------","datetime":"2012-10-01T09:45:00.000+02:00","data":""}');
			break;
		}

		$this->isResponseRc = 0;

		switch ($this->isResponseRc) {
			case 0:
				if ($method == 'send') {
					$this->response->code = 0;
				} else {
					$this->response->code = 2;
					$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
					$this->response->icon = lang('CONF_ICON_SUCCESS');
					$this->response->msg = lang('GEN_TWO_FACTOR_RESEND_CODE');
					$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}
			break;
		}

		$this->response->data = $response->data;

		return $this->responseToTheView('callWs_GenerateSecretToken');
	}

	/**
	 * @info Método para desactivar Secret Token de multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_DesactivateSecretToken_Mfa()
  {
    log_message('INFO', 'NOVO Mfa Model: Mfa DesactivateSecretToken Method Initialized');
    $requestBody = [
      'username' => $this->session->userName
    ];
    log_message('INFO', '****NOVO Mfa Model dataRequest*****'.json_encode($requestBody));

    //$response = $this->sendToCoreServices('callWs_DesactivateSecretToken');
    //$response = '200';

    $response = json_decode('{"code":"0"}');
    $this->isResponseRc = 0;
    switch ($this->isResponseRc) {
      case 0:
          $this->response->code = 0;
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
				'operationType' => 'ActivateSecretToken'
		];

		$this->dataRequest->requestBody = $requestBody;
		log_message('INFO', '****NOVO Mfa Model REQUEST*****'.json_encode($this->dataRequest->requestBody));

		$response = json_decode('{ "code": "string", "message": "string", "datetime": "string","data": {"validationResult": true }}');

		$this->isResponseRc = 0;
    log_message('INFO', '****NOVO Mfa Model RESPONSE*****'.json_encode($response));
    switch ($this->isResponseRc) {
      case 0:
        $this->response->code = 0;
				$this->response->title = lang('GEN_MENU_TWO_FACTOR_ENABLEMENT');
        $this->response->icon = lang('CONF_ICON_INFO');
        $this->response->msg = 'Validación exitosa';
        $this->response->modalBtn['btn1']['link'] = 'card-list';
				$this->response->modalBtn['btn1']['action'] = 'redirect';

				$this->session->set_userdata('optActive', false);
      break;
    }

    $this->response->data = $response->data;

		return $this->responseToTheView('callWs_ValidateOTP');
	}
}
