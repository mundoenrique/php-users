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

		/*$this->dataAccessLog->modulo = 'modulo';
		$this->dataAccessLog->function = 'function';
		$this->dataAccessLog->operation = 'operation';

		$this->dataRequest->idOperation = 'idOperation';
		$this->dataRequest->className = 'className';
		$this->dataRequest->userName = 'userName';*/

		$requestBody = [
			'authenticationChannel' => $dataRequest->activationType,
			'username' => 'string'
		];

		$this->dataRequest->requestBody = $requestBody;

		log_message('INFO', '****NOVO Mfa Model REQUEST*****'.json_encode($this->dataRequest->requestBody));

		//$response = $this->sendToCoreServices('callWs_GenerateSecretToken');

		$response = json_decode('{"code": "string","message": "string","datetime": "string","data": {"qrCode": "string","secretToken": "string"}}');
		$this->isResponseRc = 0;

		log_message('INFO', '****NOVO Mfa Model RESPONSE*****'.json_encode($response));

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
			break;
		}

		$this->response->data = $response->data;
		$this->response->data->activationType = $dataRequest->activationType;

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

		$this->dataAccessLog->modulo = 'modulo';
		$this->dataAccessLog->function = 'function';
		$this->dataAccessLog->operation = 'operation';

		$this->dataRequest->idOperation = 'idOperation';
		$this->dataRequest->className = 'className';
		$this->dataRequest->userName = 'userName';

		$requestBody = [
			'username' => 'string'
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
	public function callWs_ValidateOTPMfa_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa ValidateOTPMfa Method Initialized');

		$requestBody = [
				'username' => 'string',
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
				$this->response->title = 'Prueba';
        $this->response->icon = lang('CONF_ICON_INFO');
        $this->response->msg = 'Validación exitosa';
        $this->response->modalBtn['btn1']['link'] = 'card-list';
      break;
    }

    $this->response->data = $response->data;

		return $this->responseToTheView('callWs_ValidateOTP');
	}
}
