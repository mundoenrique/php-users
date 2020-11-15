<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Clase Modelo de Conexión Personas Online (CEO)
 *
 * Esta clase es la súper clase de la que heredarán todos los modelos
 * de la aplicación.
 *
 * @package models
 * @author J. Enrique Peñaloza Piñero
 * @date May 16th, 2020
 */
class NOVO_Model extends CI_Model {
	public $dataAccessLog;
	public $accessLog;
	public $token;
	public $country;
	public $countryUri;
	public $dataRequest;
	public $isResponseRc;
	public $response;
	public $userName;
	public $keyId;

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Model Class Initialized');

		$this->dataAccessLog = new stdClass();
		$this->dataRequest = new stdClass();
		$this->response = new stdClass();
		$this->country = $this->session->countrySess ?? $this->config->item('country');
		$this->countryUri = $this->session->countryUri;
		$this->token = $this->session->token ?? '';
		$this->userName = $this->session->userName;
		$this->keyId = $this->session->userName ?? 'CPONLINE';
	}
	/**
	 * @info Método para comunicación con el servicio
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 16th, 2020
	 */
	public function sendToService($model)
	{
		log_message('INFO', 'NOVO Model: sendToService Method Initialized');

		$this->accessLog = accessLog($this->dataAccessLog);
		$this->userName = $this->userName ?: mb_strtoupper($this->dataAccessLog->userName);

		if ($this->session->has_userdata('enterpriseCod') && $this->session->enterpriseCod != '') {
			$this->dataRequest->acCodCia = $this->session->enterpriseCod;
		}

		$this->dataRequest->pais = $this->dataRequest->pais ?? $this->country;
		$this->dataRequest->token = $this->token;
		$this->dataRequest->logAccesoObject = $this->accessLog;
		$encryptData = $this->encrypt_connect->encode($this->dataRequest, $this->userName, $model);
		$request = ['data'=> $encryptData, 'pais'=> $this->dataRequest->pais, 'keyId' => $this->keyId];
		$response = $this->encrypt_connect->connectWs($request, $this->userName, $model);

		if(isset($response->rc)) {
			$responseDecrypt = $response;
		} else {
			$responseDecrypt = $this->encrypt_connect->decode($response->data, $this->userName, $model);
		}

		return $this->makeAnswer($responseDecrypt);
	}
	/**
	 * @info Método para comunicación con el servicio
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 16th, 2020
	 */
	public function sendFile($file, $model)
	{
		log_message('INFO', 'NOVO Model: sendFile Method Initialized');

		$responseUpload = $this->encrypt_connect->moveFile($file, $this->userName, $model);

		return $this->makeAnswer($responseUpload);
	}
	/**
	 * @info Método armar la respuesta a los modelos
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function makeAnswer($responseModel)
	{
		log_message('INFO', 'NOVO Model: makeAnswer Method Initialized');

		$this->isResponseRc = (int) $responseModel->rc;
		$this->response->code = lang('GEN_DEFAULT_CODE');
		$this->response->icon = lang('GEN_ICON_WARNING');
		$this->response->title = lang('GEN_SYSTEM_NAME');
		$this->response->data = new stdClass();
		$this->response->msg = '';
		$arrayResponse = [
			'btn1'=> [
				'text'=> lang('GEN_BTN_ACCEPT'),
				'link'=> $this->session->has_userdata('logged') ? lang('GEN_LINK_CARDS_LIST') : 'inicio',
				'action'=> 'redirect'
			]
		];

		switch($this->isResponseRc) {
			case -29:
			case -61:
				$this->response->msg = lang('GEN_DUPLICATED_SESSION');
				if($this->session->has_userdata('logged') || $this->session->has_userdata('userId')) {
					$this->session->sess_destroy();
				}
			break;
			case 502:
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->session->sess_destroy();
			break;
			case 504:
				$this->response->msg = lang('GEN_TIMEOUT');
			break;
			default:
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->icon = lang('GEN_ICON_DANGER');
		}

		$this->response->modalBtn = $arrayResponse;
		$this->response->msg = $this->isResponseRc == 0 ? lang('GEN_SUCCESS_RESPONSE') : $this->response->msg;

		return $responseModel;
	}
	/**
	 * @info Método enviar el resultado de la consulta a la vista
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 16th, 2020
	 */
	public function responseToTheView($model)
	{
		log_message('INFO', 'NOVO Model: responseToView Method Initialized');
		$responsetoView = new stdClass();

		foreach ($this->response AS $pos => $response) {
			if (is_array($response) && isset($response['file'])) {
				continue;
			}

			if ($pos == 'data' && isset($response->profileData->imagesLoaded)) {
				continue;
			}

			$responsetoView->$pos = $response;
		}

		log_message('DEBUG', 'NOVO ['.$this->userName.'] RESULT '.$model.' SENT TO THE VIEW '.json_encode($responsetoView, JSON_UNESCAPED_UNICODE));

		unset($responsetoView);

		return $this->response;
	}
}
