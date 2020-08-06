<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 23th, 2020
 */
class Novo_CustomerSupport_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO CustomerSupport Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_TemporaryLock_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'atención al cliente';
		$this->dataAccessLog->function = 'Bloqueo temporal';
		$this->dataAccessLog->operation = 'Solictud de bloqueo o desbloqueo';

		$this->dataRequest->idOperation = '110';
		$this->dataRequest->accodUsuario = $this->session->userName;
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->prefix = $dataRequest->prefix;
		$this->dataRequest->fechaExp = $dataRequest->expireDate;
		$this->dataRequest->codBloqueo = $dataRequest->status == '' ? 'PB' : '00';
		$this->dataRequest->tokenOperaciones = isset($dataRequest->otp) ? $dataRequest->otp : '';
		$this->dataRequest->montoComisionTransaccion = isset($dataRequest->amount) ? $dataRequest->amount : '0';


		$response = $this->sendToService('callWs_TemporaryLock');

		switch ($this->isResponseRc) {
			case 0:
				$responseAction = $dataRequest->status == '' ? 'Bloqueada' : 'Desbloqueada';
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->title = $dataRequest->status == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang('La tarjeta %s, ha sido %s.', [$dataRequest->cardNumberMask, $responseAction]);
				$this->response->success = TRUE;
				$this->response->data['btn1']['link'] = 'atencion-al-cliente';
			break;
		}

		return $this->responseToTheView('callWs_TemporaryLock');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_TwirlsCommercial_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'atención al cliente';
		$this->dataAccessLog->function = 'Giros comerciales';
		$this->dataAccessLog->operation = 'Consulta de comercios';

		$this->dataRequest->idOperation = '130';
		$this->dataRequest->opcion = 'find_mcc';
		$this->dataRequest->companyId = '0';
		$this->dataRequest->product = $dataRequest->prefix;
		$this->dataRequest->cards = [
			[
				'numberCard' => $dataRequest->cardNumber,
				'rc' => '0'
			]
		];
		$this->dataRequest->usuario = [
			'userName' => $this->userName,
			'envioCorreoLogin' => false,
			'guardaIp' => false,
			'rc' => '0'
		];


		$response = $this->sendToService('callWs_CustomerSupport');
		$response = json_decode('{"rc":0,"msg":"Proceso OK","bean":"{\"companyId\":\"1234567890\",\"product\":\"T1\",\"cards\":[{\"numberCard\":\"4189281080003016\",\"personName\":\"AL PORTADOR\",\"personId\":\"NOVO200618SGCTST10\",\"datetimeLastUpdate\":\"05\/08\/2020 07:52:09 PM\",\"mccItems\":{\"hoteles\":\"1\",\"supermercados\":\"1\",\"hospitales\":\"1\",\"gobiernos\":\"1\",\"entretenimiento\":\"1\",\"beneficencia\":\"1\",\"aseguradoras\":\"1\",\"rentaAuto\":\"1\",\"transporteAereo\":\"0\",\"peajes\":\"1\",\"colegios\":\"0\",\"estacionamientos\":\"1\",\"gasolineras\":\"1\",\"telecomunicaciones\":\"1\",\"agenciaViajes\":\"1\",\"ventasDetalle\":\"1\",\"restaurantes\":\"1\",\"transporteTerrestre\":\"1\"},\"rc\":0}],\"allRejected\":false,\"allSuccess\":true}","pais":"Mx-Bn"}');
		$this->isResponseRc = 0;
		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$response = json_decode($response->bean);
				$shops = new stdClass();
				$dataTwirls = new stdClass();
				$dataTwirls->updateDate = 'Fecha de actualización: '.$response->cards[0]->datetimeLastUpdate;
				$dataTwirls->cardnumberT = maskString($response->cards[0]->numberCard, 4, 6);
				$dataTwirls->customerName = $response->cards[0]->personName;
				$dataTwirls->documentId = $response->cards[0]->personId;

				foreach ($response->cards[0]->mccItems AS $key => $value) {
					$name = lang('CUST_SHOPS')[$key];
					$shops->$name = $value;
				}

				$this->response->data['shops'] = $shops;
				$this->response->data['dataTwirls'] = $dataTwirls;
			break;
			case -438:

			break;
		}

		return $this->responseToTheView('callWs_CustomerSupport');
	}
}
