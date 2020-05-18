<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BDB_Model extends CI_Model {
	public $dataAccessLog;
	public $className;
	public $logAccess;
	public $token;
	public $country;
	public $countryUri;
	public $dataRequest;
	public $response;
	public $isResponseRc;
	public $userName;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'BDB_Model  Class Initialized');

		$this->dataAccessLog = new stdClass();
		$this->dataRequest = new stdClass();

		$this->response = new stdClass();
		$this->response->code = lang('RESP_DEFAULT_CODE');
		$this->response->title = lang('GEN_SYSTEM_NAME');
		$this->response->msg = lang('RESP_MESSAGE_SYSTEM');
		$this->response->classIconName = 'ui-icon-closethick';
		$this->response->data = [
			'btn1'=> [
				'text'=> lang('GEN_BTN_ACCEPT'),
				'link'=> FALSE,
				'action'=> 'close'
			]
		];

		$this->country = $this->session->userdata('pais') ?: $this->config->item('country');
		$this->countryUri = $this->session->userdata('countryUri');
		$this->isResponseRc = 'No web service';
		$this->token = $this->session->userdata('token') ?: '';
		$this->userName = mb_strtoupper($this->session->userdata('userName'));
		$this->lang->load(['error','general', 'response'], 'base-spanish' );
		$this->keyId = $this->session->userdata('userName')?: 'CPONLINE';
	}

	public function sendToService($model)
	{
		log_message('INFO', 'NOVO sendToService Method Initialized');

		$this->logAccess = logAccess($this->dataAccessLog);
		$this->userName = $this->userName ?: mb_strtoupper($this->dataAccessLog->userName);

		$this->dataRequest->className = $this->className;
		$this->dataRequest->logAccesoObject = $this->logAccess;
		$this->dataRequest->token = $this->token;
		$this->dataRequest->pais = empty($this->dataRequest->pais)? ucwords($this->country): $this->dataRequest->pais;

		$encryptData = $this->encrypt_connect->encode($this->dataRequest, $this->dataAccessLog->userName, $model);
		$request = ['data'=> $encryptData, 'pais'=> $this->dataRequest->pais, 'keyId' => $this->keyId];
		$response = [];
		$response = $this->encrypt_connect->connectWs($request, $this->dataAccessLog->userName, $model);

		if(isset($response->rc)){
			$responseDecrypt = $response;
		}else{
			$responseDecrypt = $this->encrypt_connect->decode($response->data, $this->userName, $model);
		}

		log_message("info", "Response: " . json_encode($responseDecrypt));

		$this->isResponseRc = (int) $responseDecrypt->rc;
		switch($this->isResponseRc) {
			case -61:
				$this->response->msg = lang('RESP_DUPLICATED_SESSION');
				$this->session->sess_destroy();
				break;

			case -9999:
			case 4:
				$this->response->msg = $responseDecrypt->msg;
				break;
		}
		$this->response->msg = $this->isResponseRc == 0 ? lang('RESP_RC_0') : $this->response->msg;

		return $responseDecrypt;
	}

	public function cypherData()
	{
		log_message('INFO', 'NOVO cypherData Method Initialized');
		log_message('DEBUG', 'NOVO RESPONSE TO VIEW: '.json_encode($this->response));

		return $this->cryptography->encrypt($this->response);
	}
}
