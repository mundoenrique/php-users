<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class Novo_Product_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}

	public function callWs_loadProducts_Product()
	{
		log_message('INFO', 'NOVO Product Model: Load Products method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'dashboard';
		$this->dataAccessLog->function = 'dashboard';
		$this->dataAccessLog->operation = 'consulta';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '2';
		$this->dataRequest->userName = $this->session->userdata('userName');
		$this->dataRequest->idUsuario = $this->session->userdata('idUsuario');
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request List Products:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response->lista;
					break;
			}
		}
	}

	public function callWs_getBalance_Product($dataRequest)
	{
		log_message('INFO', 'NOVO Product Model: Load Detail Product method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'obtener saldo';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '8';
		$this->dataRequest->noTarjeta = $dataRequest;
		$this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request getBalance Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response->disponible;
					break;
				default:
					return '--';
			}
		}
	}

	public function callWs_getTransactionHistory_Product($dataRequest)
	{
		log_message('INFO', 'NOVO Product Model: get Transaction History of Product method Initialized')
		;

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consulta';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '3';
		$this->dataRequest->noTarjeta = gettype($dataRequest) === "object" ? $dataRequest->noTarjeta: $dataRequest['noTarjeta'];
		$this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request Detail Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response;
					break;
				default:
					return '--';
			}
		}
	}

	public function callWs_balanceInTransit_Product($dataRequest)
	{
		$country = $this->session->userdata("pais");

		$urlAPI = '/api-cardholder-account/1.0/balance';
		$headerAPI = [
			'x-country: ' . $country
		];
		$body = [
			'idPrograma' => $dataRequest['prefix'],
			'noTarjetaConMascara' => $dataRequest['noTarjetaConMascara']
		];
		$bodyAPI = json_encode($body);
		$method = 'POST';

		$objectAPI = (object) [
			'urlAPI' => $urlAPI,
			'headerAPI' => $headerAPI,
			'bodyAPI' => $bodyAPI,
			'method' => $method
		];
		log_message("DEBUG", '['.$this->session->userdata("userName").']'." REQUEST WSinTransit objectAPI: ".json_encode($objectAPI));
		$response = connectionAPI($objectAPI);

		$httpCode = $response->httpCode;
		$resAPI = $response->resAPI;

		log_message("DEBUG", '['.$this->session->userdata("userName").']'.' RESPONSE WSinTransit====>> httpCode: ' . $httpCode . ', resAPI: ' . $resAPI);

		$dataResponse = json_decode($resAPI);
		$code = 1;
		switch ($httpCode) {
			case 200:
				$code = 0;
				// Formato de moneda de acuerdo al país
				$ledgerBalance = $dataResponse->balance->ledgerBalance;
				$availableBalance = (float) $dataResponse->balance->availableBalance;
				if($availableBalance < 0) {
					$availableBalance = $availableBalance/100;
				}
				$actualBalance = $ledgerBalance + $availableBalance;
				$ledgerBalance = np_hoplite_decimals($ledgerBalance, $country);
				$availableBalance = np_hoplite_decimals($availableBalance, $country);
				$actualBalance = np_hoplite_decimals($actualBalance, $country);
				$dataResponse->balance->ledgerBalance = $ledgerBalance;
				$dataResponse->balance->availableBalance = $availableBalance;
				$dataResponse->balance->actualBalance = $actualBalance;
				break;
		}
		return $dataResponse;
	}

	public function callWs_loadMovements_Product($dataRequest)
	{
		log_message('INFO', 'NOVO Product Model: get Transaction History of Product method Initialized');

		if ($dataRequest->month == 0 ) {

			$response = $this->callWs_getTransactionHistory_Product($dataRequest);

		}else{

			$this->className = 'com.novo.objects.MO.MovimientosTarjetaSaldoMO';
			$this->dataAccessLog->modulo = 'tarjeta';
			$this->dataAccessLog->function = 'tarjeta';
			$this->dataAccessLog->operation = 'consultar movimientos';
			$this->dataAccessLog->userName = $this->session->userdata('userName');

			$this->dataRequest->idOperation = '13';
			$this->dataRequest->tarjeta = array(
				"noTarjeta" => $dataRequest->noTarjeta,
				"id_ext_per"=> $this->session->userdata("idUsuario")
			);
			$this->dataRequest->mes = $dataRequest->month;
			$this->dataRequest->anio = $dataRequest->year;
			$this->dataRequest->token = $this->session->userdata('token');

			$response = $this->sendToService('Product');
		}

		log_message("info", "Request loadMovement Product:" . json_encode($this->dataRequest));
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response->movimientos;
					break;
				default:
					return '--';
			}
		}
	}

	public function callWs_dataReport_Product($dataRequest)
	{
		log_message('INFO', 'NOVO Product Model: get data expense report of Product method Initialized');

		$this->className = 'com.novo.objects.MO.MovimientosTarjetaSaldoMO';
		$this->dataAccessLog->modulo = 'transferencia';
		$this->dataAccessLog->function = 'listados transferencia';
		$this->dataAccessLog->operation = 'consulta cuentas origen';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '6';
		$this->dataRequest->id_ext_per = $this->session->userdata("idUsuario");
		$this->dataRequest->tipoOperacion = $dataRequest->tipoOperacion;
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request dataReport Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response->cuentaOrigen;
					break;
				default:
					return [];
			}
		}
	}

	public function getFile_Product ($dataRequest) {
		log_message('INFO', 'NOVO ExpenseReport Model: getPDF  method Initialized');

		$this->className = 'com.novo.objects.MO.MovimientosTarjetaSaldoMO';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->operation = 'exportar movimientos';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$idsOpereation = [
			'pdf' => 5,
			'xls' => 46,
			'ext' => 125,
		];

		$this->dataRequest->idOperation = $idsOpereation[$dataRequest->typeFile];
		$this->dataRequest->tarjeta = array (
			'noTarjeta' => $dataRequest->noTarjeta,
			'id_ext_per' => $this->session->userdata("idUsuario")
		);
		$this->dataRequest->mes = $dataRequest->month;
		$this->dataRequest->anio = $dataRequest->year;

		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request getFile Product: " . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->data = $response;
					break;

				case -150:
					$this->response->code = -150;
					$this->response->msg = $response->msg;
					break;

				case -423:
					$this->response->code = -150;
					$this->response->msg = lang('RESP_FAIL_DONWLOAD_FILE');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = '--';
					break;

				default:
					$this->response->code = 150;
					$this->response->msg = lang('RESP_MESSAGE_SYSTEM');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = '--';
			}
		}
		return $this->response;
	}

	public function callWs_getDetail_Product ($dataRequest) {
		log_message('INFO', 'NOVO Product Model: getDetail method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';

		$this->dataAccessLog->modulo = 'personasweb';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consulta';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$bean = new stdClass();
		$bean->id_ext_per = $dataRequest->id_ext_per;
		$bean->noTarjeta = $dataRequest->noTarjeta;

		// $logAccesoObject = new stdClass();
		// $logAccesoObject->sessionId = '52d62faec782b0745d3e58763c55133b';
		// $logAccesoObject->userName = 'BLANCO01';
		// $logAccesoObject->canal = 'personasWeb';
		// $logAccesoObject->modulo = 'tarjeta';
		// $logAccesoObject->operacion = 'consulta';
		// $logAccesoObject->RC = 0;
		// $logAccesoObject->IP = '172.4.6.82';
		// $logAccesoObject->lenguaje = 'ES';			
		// $logAccesoObject->dttimesstamp = '03/05/2020 21:33';

		// $bean->noTarjeta = '4875971301198715';
		// $bean->id_ext_per = '1101035010';
		// $bean->montoComisionTransaccion = 0.0;
		// $bean->montoComisionThTransaccion = 0.0;
		// $bean->numLote = 0;
		// $bean->paginaActual = '1';
		// $bean->tamanoPagina = '0';
		// $bean->paginar = false;
		// $bean->idAsignacion = 0;
		// $bean->condicion = 0;
		// $bean->pinGeneradoUsuario = false;
		// $bean->rc = 0;
		// $bean->className = 'com.novo.objects.TOs.TarjetaTO';
		// $bean->token ='4aa626e2d4e86623d45c770b1928be';
		// $bean->idOperation = '214';
		// $bean->logAccesoObject = $logAccesoObject;


		$this->dataRequest->idOperation = '214';
		$this->dataRequest->bean = json_encode($bean);
		// $this->dataRequest->pais = 'Co';

		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->timeLiveModal = intval($response->bean) * 10;
					$this->response->dataDetailCard = [
						'cardholderName'=>'Sergio Quijano Try',
						'cardNumber'=>'4193280000300080',
						'expirationDate'=>'19/20',
						'securityCode'=>'837',
						'request'=>$this->session->userdata('setProduct')
					];
					$this->response->data = $response->data || [""];
					
					break;
				case 10:
					$this->response->code = 1;
					$this->response->msg = lang('RESP_CODEOTP');
					$this->response->validityTime = intval($response->bean) * 20;
					$this->response->data = $response->data || [""];
					break;
				case -420:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_SHORT_CODEOTP_INVALID');

					//if (json_decode($response->bean)->bean == "0") {
					if (false) {
						$this->response->code = 3;
						$this->response->msg = lang('RESP_OTP_FAILED_ATTEMPTS');
					}
					break;
				case -421:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_EXPIRED_CODEOTP');
					$this->response->validityTime = intval($response->bean) * 60;
					break;
				default:
					$this->response->code = 2;	
			}
		}
		return $this->response;
	}
}
