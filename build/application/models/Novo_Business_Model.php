<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 23th, 2020
 */
class Novo_Business_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Business Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_UserCardsList_Business()
	{
		log_message('INFO', 'NOVO Business Model: UserCardsList Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Lista de tarjetas';
		$this->dataAccessLog->operation = 'Obtener la lista de tarjetas';

		$this->dataRequest->idOperation = '2';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->idUsuario = $this->session->userId;

		$response = $this->sendToService('callWs_UserCardsList');
		$cardsList = [];
		switch ($this->isResponseRc) {
			case 0:
				if (isset($response->lista) && count($response->lista > 0)) {
					foreach ($response->lista AS $pos => $cardsRecords) {
						$cardRecord = new stdClass();
						$cardRecord->cardNumber = $cardsRecords->noTarjeta;
						$cardRecord->cardNumberMask = $cardsRecords->noTarjetaConMascara;
						$cardRecord->productName = mb_strtoupper($cardsRecords->nombre_producto);
						$cardRecord->userIdNumber = $cardsRecords->id_ext_per;
						$produtImg = normalizeName($cardsRecords->nombre_producto).'.svg';
						$productUrl = 'images/'.$this->countryUri;
						if(!file_exists(assetPath('images/'.$this->countryUri.'/'.$produtImg))) {
							$produtImg = $this->countryUri.'_default.svg';
							$productUrl = 'images/default';
						}
						$cardRecord->productImg = $produtImg;
						$cardRecord->productUrl = $productUrl;
						$brand = normalizeName($cardsRecords->marca);
						$brand = str_replace('_', '-', $brand);
						$cardRecord->brand = $brand;
						$cardsList[] = $cardRecord;
					}
				}

				$this->session->set_userdata('products', TRUE);
				$this->response->code = isset($response->lista) && count($response->lista > 0) ? 0 : 1;
			break;
			default:
				if ($this->isResponseRc != -61) {
					$this->session->sess_destroy();
				}
				$this->response->data->resp['btn1']['link'] = 'inicio';
		}

		$this->response->data->cardsList = $cardsList;

		return $this->responseToTheView('callWs_UserCardsList');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_GetBalance_Business($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: GetBalance Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Lista de tarjetas';
		$this->dataAccessLog->operation = 'Obtener Saldo';

		$this->dataRequest->idOperation = '8';
		$this->dataRequest->id_ext_per = $dataRequest->userIdNumber;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;

		$response = $this->sendToService('callWs_GetBalance');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->msg = lang('GEN_CURRENCY').' '.$response->disponible;
			break;
			default:
				$this->response->code = 1;
				$this->response->msg = '---';
		}

		return $this->responseToTheView('callWs_GetBalance');
	}
	/**
	 * @info Método para obtener el detalle de una tarjeta
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Jun 04th, 2020
	 */
	public function callWs_CardDetail_Business($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CardDetail Method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'Detalle de la tarjeta';

		$this->dataRequest->idOperation = '3';
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->id_ext_per = $dataRequest->userIdNumber;

		$response = $this->sendToService('callWs_CardDetail');
		$movesList = [];
		$balance = new stdClass();
		$balance->currentBalance = '---';
		$balance->inTransitBalance = '---';
		$balance->availableBalance = '---';

		switch ($this->isResponseRc) {
			case 0:
			case -150:
				$this->response->code = 0;
				$balance->currentBalance = lang('GEN_CURRENCY').' '.$response->saldos->actual;
				$balance->inTransitBalance = lang('GEN_CURRENCY').' '.$response->saldos->bloqueo;
				$balance->availableBalance = lang('GEN_CURRENCY').' '.$response->saldos->disponible;
				if (count($response->movimientos) > 0) {
					foreach($response->movimientos AS $pos => $moves) {
						$move = new stdClass();
						$move->date = transformDate($moves->fecha);
						$move->desc = implode(' ',array_filter(explode(' ',ucfirst(mb_strtolower($moves->concepto)))));
						$move->ref = $moves->referencia;
						$move->sign = $moves->signo;
						$move->amount = lang('GEN_CURRENCY').' '.$moves->monto;
						$movesList[] = $move;
					}
				}

			break;
			default:

		}

		$this->response->data->movesList = $movesList;
		$this->response->data->balance = $balance;

		return $this->responseToTheView('callWs_CardDetail');
	}
}
