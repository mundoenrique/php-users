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

		log_message("info", "Request Detail Product:" . json_encode($this->dataRequest));
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
		log_message('INFO', 'NOVO Product Model: get Transaction History of Product method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consulta';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '3';
		$this->dataRequest->noTarjeta = $dataRequest['noTarjeta'];
		$this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request Detail Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
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

		$this->className = 'com.novo.objects.MO.MovimientosTarjetaSaldoMO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consultar movimientos';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '13';
		$this->dataRequest->tarjeta = array(
			"noTarjeta" => $dataRequest->noTarjeta,
			"id_ext_per"=>$this->session->userdata("idUsuario")
		);
		$this->dataRequest->mes = $dataRequest->month;
		$this->dataRequest->anio = $dataRequest->year;
		$this->dataRequest->token = $this->session->userdata('token');
		$this->dataRequest->pais = $this->session->userdata('pais');

		log_message("info", "Request loadMovement Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
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
}
