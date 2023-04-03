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
	public $customerImages;
	public $dataRequest;
	public $isResponseRc;
	public $response;
	public $userName;
	public $keyId;

	public function __construct()
	{
		parent:: __construct();
		writeLog('INFO', 'Model Class Initialized');

		$this->dataAccessLog = new stdClass();
		$this->dataRequest = new stdClass();
		$this->response = new stdClass();
		$this->customer = $this->session->customerSess ?? $this->config->item('customer');
		$this->customerUri = $this->session->customerUri;
		$this->customerImages = $this->config->item('customer_images');
		$this->token = $this->session->token ?? '';
		$this->userName = $this->session->userName;
		$this->keyId = $this->session->userName ?? 'CPONLINE';
	}
	/**
	 * @info Método para comunicación con el servicio
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 16th, 2020
	 */
	public function sendToWebServices($model)
	{
		writeLog('INFO', 'Model: sendToWebServices Method Initialized');

		$logResponse = new stdClass();
		$this->accessLog = accessLog($this->dataAccessLog);

		if ($this->session->has_userdata('enterpriseCod') && $this->session->enterpriseCod !== '') {
			$this->dataRequest->acCodCia = $this->session->enterpriseCod;
		}

		$this->dataRequest->pais = $this->dataRequest->pais ?? $this->customer;
		$this->dataRequest->token = $this->token;
		$this->dataRequest->logAccesoObject = $this->accessLog;
		$dataRequest = json_encode($this->dataRequest, JSON_UNESCAPED_UNICODE);

		writeLog('DEBUG', 'WEB SERVICES REQUEST ' . $model . ': ' . $dataRequest);

		$encryptRequest = $this->encrypt_decrypt->encryptWebServices($dataRequest);
		$request = ['data'=> $encryptRequest, 'pais'=> $this->dataRequest->pais, 'keyId' => $this->keyId];
		$encryptResponse = $this->connect_services_apis->connectWebServices($request, $model);
		$response = $this->encrypt_decrypt->decryptWebServices($encryptResponse);
		$response = handleResponseServer($response);

		foreach ($response as $key => $value) {
			if (isset($value->archivo) || isset($value->bean->archivo)) {
				continue;
			}

			$logResponse->$key = $value;
		}

		writeLog('DEBUG', 'WEB SERVICES RESPONSE COMPLETE ' . $model . ': '
			.json_encode($logResponse, JSON_UNESCAPED_UNICODE));

		unset($logResponse);

		return $this->makeAnswer($response);
	}

	/**
	 * @info Método para comunicación con el microservicio
	 * @author Luis Molina.
	 * @date MJun 16th, 2022
	 */
	public function sendToMfaServices($model)
	{
		writeLog('INFO', 'Model: sendToMfaServices Method Initialized');

		$response = NULL;
		$this->dataRequest->requestBody = json_encode($this->dataRequest->requestBody, JSON_UNESCAPED_UNICODE);

		writeLog('DEBUG', 'MFA SERVICES REQUEST ' . $model . ': ' . $this->dataRequest->requestBody);

		if (API_GEE_WAY) {
			$this->dataRequest->requestBody = $this->encrypt_decrypt->encryptCoreServices($this->dataRequest->requestBody);
		}

		$response = $this->connect_services_apis->connectMfaServices($this->dataRequest);

		if (API_GEE_WAY && $response->data) {
			$response = $this->encrypt_decrypt->decryptCoreServices($response->data);
		}

		writeLog('DEBUG', 'MFA SERVICES RESPONSE COMPLETE ' . $model . ': '
			. json_encode($response, JSON_UNESCAPED_UNICODE));

		return $this->makeAnswer($response);
	}

	/**
	 * @info Método armar la respuesta a los modelos
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 16th, 2020
	 */
	protected function makeAnswer($responseModel)
	{
		writeLog('INFO', 'Model: makeAnswer Method Initialized');

		$this->isResponseRc = (int) $responseModel->responseCode;
		$this->response->code = lang('SETT_DEFAULT_CODE');
		$this->response->icon = lang('SETT_ICON_WARNING');
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
				clearSessionsVars();
			break;
			case 502:
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				clearSessionsVars();
			break;
			case 504:
				$this->response->msg = lang('GEN_TIMEOUT');
			break;
			default:
				$this->response->icon = lang('SETT_ICON_DANGER');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
		}

		$this->response->modalBtn = $arrayResponse;
		$this->response->msg = $this->isResponseRc === 0 ? lang('GEN_SUCCESS_RESPONSE') : $this->response->msg;

		return $responseModel->data;
	}
	/**
	 * @info Método enviar el resultado de la consulta a la vista
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 16th, 2020
	 */
	public function responseToTheView($model)
	{
		writeLog('INFO', 'Model: responseToView Method Initialized');
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

		writeLog('DEBUG', 'RESULT ' . $model . ' SENT TO THE VIEW '.json_encode($responsetoView, JSON_UNESCAPED_UNICODE));

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
		writeLog('INFO', 'Model: checkImageUpload Method Initialized');

		if($this->session->missingImages) {
			$this->response->code = 3;
			$this->response->title = lang('GEN_TITLE_IMPORTANT');
			$this->response->icon = lang('SETT_ICON_INFO');
			$this->response->msg = lang('GEN_MISSING_IMAGES');
			$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_YES');
			$this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_USER_PROFILE');
			$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_NO');
			$this->response->modalBtn['btn2']['action'] = 'destroy';

			$this->session->set_userdata('missingImages', FALSE);
		}
	}
}
