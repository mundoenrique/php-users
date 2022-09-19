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
	public $customer;
	public $customerUri;
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
		$this->customer = $this->session->customerSess ?? $this->config->item('customer');
		$this->customerUri = $this->session->customerUri;
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

		$this->dataRequest->pais = $this->dataRequest->pais ?? $this->customer;
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
	 * @info Método para comunicación con el microservicio
	 * @author Luis Molina.
	 * @date MJun 16th, 2022
	 */
	public function sendToCoreServices($model)
	{
		log_message('INFO', 'NOVO Model: sendToCoreServices Method Initialized');

		$request = $this->encrypt_decrypt->encryptCoreServices($this->dataRequest, $model);
		$response = $this->connect_services_apis->connectCoreServices($request, $model);
		$decryptResponse = $this->encrypt_decrypt->decryptCoreServices($response, $model);

		return $this->makeAnswer($decryptResponse);
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
		$this->response->code = lang('CONF_DEFAULT_CODE');
		$this->response->icon = lang('CONF_ICON_WARNING');
		$this->response->title = lang('GEN_SYSTEM_NAME');
		$this->response->msg = '';
		$this->response->data = new stdClass();
		$linkredirect = uriRedirect();
		$arrayResponse = [
			'btn1'=> [
				'text'=> lang('GEN_BTN_ACCEPT'),
				'link'=> $linkredirect,
				'action'=> 'redirect'
			]
		];

		switch($this->isResponseRc) {
			case -29:
			case -35:
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
				$this->response->icon = lang('CONF_ICON_DANGER');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
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
			if (isset($response->file)) {
				continue;
			}

			$responsetoView->$pos = $response;

			if (!empty($response->profileData->imagesLoaded)) {
				$responsetoView->data->profileData->imagesLoaded = 'cypher image';
			}
		}

		log_message('DEBUG', 'NOVO ['.$this->userName.'] IP ' . $this->input->ip_address() . ' RESULT ' . $model .
			' SENT TO THE VIEW '.json_encode($responsetoView, JSON_UNESCAPED_UNICODE));

		unset($responsetoView);

		return $this->response;
	}
	/**
	 * @info Método para validar la carga de imagenes del usurio
	 * @author J. Enrique Peñaloza Piñero.
	 * @date July 13th, 2021
	 */
	public function checkImageUpload()
	{
		log_message('INFO', 'NOVO Model: checkImageUpload Method Initialized');

		if($this->session->missingImages) {
			$this->response->code = 3;
			$this->response->title = lang('GEN_TITLE_IMPORTANT');
			$this->response->icon = lang('CONF_ICON_INFO');
			$this->response->msg = lang('GEN_MISSING_IMAGES');
			$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_YES');
			$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_USER_PROFILE');
			$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_NO');
			$this->response->modalBtn['btn2']['action'] = 'destroy';

			$this->session->set_userdata('missingImages', FALSE);
		}
	}
}
