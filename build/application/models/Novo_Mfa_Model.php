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
				$response = json_decode('{"code":"0","message":"Secret token generated successfully","datetime":"2012-10-01T09:45:00.000+02:00","data":{"qrCode":"iVBORw0KGgoAAAANSUhEUgAAAMgAAADIAQAAAACFI5MzAAAB9ElEQVR4Xu2WUWrEMAxEDb6WQFc3+FqCdJ6cLG1h/yRoYU1IvHoBW6ORs+N6N8bvwGt8yJ8na4y5r73mmuF7jUmggWyumFzLfGtkrJ6syfKu7GLovgl0EQ8zV6rDhneSYTaGkau1kbwuSuiaZLiDpEO+j5/eKSMM3DGygEbxGOWEBHfuYxkw/FG0lqidLpxBR6lqNgVPprXk2nH8foWxdEjfW4NSgt2HI+gObpo93qklWjJUMLLVMJek3kIcGtKTLqOZn5OvlJAeZ97Rk5/k2kAmDlF+gUFcG9JrDUSDKbqeT4bp0UAWStJREpXYxpENhGY6N9bXZSRaT2QKk//01Ft4cjKrJxRMMRnej6BCR9FaIgVdZaN/+QqqufKoKCdScObxoM2wCdVwnB0UkxNMd8gtFO7lxFqSEp6NzNv8HUQryu5yoCeQsGypnrAw1cMpajE9YjYQOUMySk9S3nli+NlBMTk/0hhH2WyBcsJ6Gz0v9qHyyY9nB7VEmdJNt6romdYsJ0KYkPItT/vH3Vm1JPijwPpDLyy+6s9JUUsYG3cIaWlFVb8GcgddoUi3K2lvIBtN8V7gj0z86axasrKXsp/0vaB4t6L1hNOIP3Xkuci5i0xunp5XX/WQC1ds3K4cNc9uricETlB3bWIiawN5Mz7kv5Ivy8YtbNFioaEAAAAASUVORK5CYII=","secretToken":"ZSWAEMX5P3TO47ZT"}}');
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
					$this->response->msg = 'Se ha reenviado el código OTP';
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
	public function callWs_DesactivateSecretToken_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa DesactivateSecretToken Method Initialized');

		$requestBody = [
			'username' => $this->session->userName
		];

		$this->dataRequest->requestBody = json_encode($requestBody);

		log_message('INFO', '****NOVO Mfa Model dataRequest*****'.$this->dataRequest);

		//$response = $this->sendToCoreServices('callWs_DesactivateSecretToken');

		$response = '200';

		//return $this->responseToTheView('callWs_DesactivateSecretToken');
		return $response;
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
      break;
    }

    $this->response->data = $response->data;

		return $this->responseToTheView('callWs_ValidateOTP');
	}
}
