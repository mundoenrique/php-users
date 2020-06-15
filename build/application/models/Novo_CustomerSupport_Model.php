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


		$response = $this->sendToService('callWs_CustomerSupport');

		switch ($this->isResponseRc) {
			case 0:
				$responseAction = $dataRequest->status == '' ? 'Bloqueada' : 'Desbloqueada';
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->title = $dataRequest->status == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang('La tarjeta %s, ha sido %s.', [$dataRequest->cardNumberMask, $responseAction]);
				$this->response->success = TRUE;
				$this->response->data['btn1']['action'] = 'close';
			break;
		}



		return $this->responseToTheView('callWs_CustomerSupport');
	}
}
