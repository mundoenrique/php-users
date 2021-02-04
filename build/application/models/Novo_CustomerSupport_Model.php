<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Clase para la la atención al cliente
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

		$this->dataAccessLog->modulo = 'Atención al cliente';
		$this->dataAccessLog->function = 'Servicios';
		$this->dataAccessLog->operation = 'Solictud de bloqueo o desbloqueo';

		$expireDate = $this->cryptography->decryptOnlyOneData($dataRequest->expireDate);

		$this->dataRequest->idOperation = '110';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->accodUsuario = $this->session->userName;
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->prefix = $dataRequest->prefix;
		$this->dataRequest->fechaExp = $expireDate;
		$this->dataRequest->codBloqueo = $dataRequest->status == '' ? 'PB' : '00';
		$this->dataRequest->TextoBloqueo = isset($dataRequest->reasonText) ? $dataRequest->reasonText : '';
		$this->dataRequest->tokenOperaciones = isset($dataRequest->otpCode) ? $dataRequest->otpCode : '';
		$this->dataRequest->montoComisionTransaccion = isset($dataRequest->amount) ? $dataRequest->amount : '0';

		$response = $this->sendToService('callWs_TemporaryLock');

		switch ($this->isResponseRc) {
			case 0:
				$responseAction = $dataRequest->status == '' ? 'Bloqueada' : 'Desbloqueada';
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = $dataRequest->status == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang(lang('CUST_SUCCESS_OPERATION_RESPONSE'), [$dataRequest->cardNumberMask, $responseAction]);
				$this->response->success = TRUE;
				$this->response->modalBtn['btn1']['link'] = 'atencion-al-cliente';
			break;
			case 7:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang(lang('CUST_LOCK_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -125:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang(lang('CUST_EXPIRED_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -286:
			case -301:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -287:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = lang('GEN_OTP_USED');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -288:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = lang('GEN_EXPIRE_TIME');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -306:
				$this->load->model('Novo_Assets_Model', 'getToken');
				$this->response = $this->getToken->callWs_GetToken_Assets();
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
			break;
			case -300:
				$this->response->title = $dataRequest->action == '' ? 'Bloqueo' : 'Desbloqueo';
				$this->response->msg = novoLang(lang('CUST_NOT_LOCKED'), 'temporal');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}

		return $this->responseToTheView('callWs_TemporaryLock');
	}
	/**
	 * @info Método para solictar el bloqueo y/o reposición de una tarjeta
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Sep 11th, 2020
	 */
	public function callWs_Replacement_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->dataAccessLog->modulo = 'Atención al cliente';
		$this->dataAccessLog->function = 'Servicios';
		$this->dataAccessLog->operation = 'Solicitud de bloqueo permanente';

		$expireDate = $this->cryptography->decryptOnlyOneData($dataRequest->expireDate);

		$this->dataRequest->idOperation = '111';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->accodUsuario = $this->session->userName;
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->prefix = $dataRequest->prefix;
		$this->dataRequest->fechaExp = $expireDate;
		$this->dataRequest->codBloqueo = $dataRequest->status;
		$this->dataRequest->tokenOperaciones = isset($dataRequest->otpCode) ? $dataRequest->otpCode : '';
		$this->dataRequest->montoComisionTransaccion = isset($dataRequest->amount) ? $dataRequest->amount : '0';
		$this->dataRequest->tipoTarjeta = $dataRequest->virtual ? 'virtual' : 'fisica';

		$response = $this->sendToService('callWs_Replacement');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = $dataRequest->virtual ? lang('CUST_REPLACE_MSG') : novoLang(lang('CUST_SUCCESS_OPERATION_RESPONSE'), [$dataRequest->cardNumberMask, 'bloqueada de forma permanente']);
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->success = TRUE;
				$this->response->modalBtn['btn1']['link'] = $dataRequest->virtual ? 'lista-de-tarjetas' : 'atencion-al-cliente';
			break;
			case 7:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_LOCK_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -395:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_SPECIFIC_PERMANENT_LOCK'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -396:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_SPECIFIC_REVEWAL_LOCK'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -125:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_EXPIRED_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -286:
			case -301:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -287:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('GEN_OTP_USED');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -288:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('GEN_EXPIRE_TIME');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -544:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('CUST_LIMIT_REPLACEMENTS');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -306:
			case -382:
				$this->response->code = 3;
				if ($this->isResponseRc == -306) {
					$this->load->model('Novo_Assets_Model', 'getToken');
					$this->response = $this->getToken->callWs_GetToken_Assets();
					$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				}

				if (isset($reponse->bean->cost_repos_plas) && $reponse->bean->cost_repos_plas != '') {
					$cost = currencyFormat($reponse->bean->cost_repos_plas);
					$this->response->data->cost = TRUE;
					$this->response->data->msg = novoLang('La reposición tendra un costo de %s %s', [lang('GEN_CURRENCY'), $cost]);
				}
			break;
			case -300:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_NOT_LOCKED'), 'permanente');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}

		return $this->responseToTheView('callWs_Replacement');
	}
	/**
	 * @info Método para obtener la lista giros comerciales
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_TwirlsCommercial_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->dataAccessLog->modulo = 'atención al cliente';
		$this->dataAccessLog->function = 'Giros comerciales';
		$this->dataAccessLog->operation = 'Consulta de comercios';

		$this->dataRequest->idOperation = '130';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
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

		$response = $this->sendToService('callWs_TwirlsCommercial');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$response = $response->bean;
				$shops = new stdClass();
				$dataTwirls = new stdClass();
				$dataTwirls->updateDate = $response->cards[0]->datetimeLastUpdate != '' ?
				lang('CUST_UPDATE_CURRENT').' '.$response->cards[0]->datetimeLastUpdate : '';
				$dataTwirls->cardnumberT = maskString($response->cards[0]->numberCard, 4, 6);
				$dataTwirls->customerName = $response->cards[0]->personName;
				$dataTwirls->documentId = $response->cards[0]->personId;

				foreach ($response->cards[0]->mccItems AS $key => $value) {
					$name = lang('CUST_SHOPS')[$key];
					$shops->$name = $value;
				}

				$this->response->data->shops = $shops;
				$this->response->data->dataTwirls = $dataTwirls;
			break;
			case -438:
				$internalRc = $response->bean->cards[0]->rc ?? '';
				$default = TRUE;

				switch ($internalRc) {
					case -266:
						$this->response->msg = lang('CUST_CARD_TEMPORARY_LOCK');
						$default = FALSE;
					break;
					case -307:
						$this->response->msg = lang('CUST_CARD_CANCELED');
						$default = FALSE;
					break;
					case -439:
						$this->response->msg = lang('CUST_NON_RESULTS');
						$default = FALSE;
					break;
					case -440:
					case -441:
						$this->response->msg = lang('CUST_CARD_UNAVAILABLE');
						$default = FALSE;
					break;
				}

				if (!$default) {
					$this->response->title = lang('GEN_MENU_CUSTOMER_SUPPORT');
					$this->response->icon = lang('CONF_ICON_WARNING');
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}
			break;
			case -306:
				$this->load->model('Novo_Assets_Model', 'getToken');
				$this->response = $this->getToken->callWs_GetToken_Assets();
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
			break;
		}

		return $this->responseToTheView('callWs_TwirlsCommercial');
	}
	/**
	 * @info Método para obtener la lista de límites transaccionales
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Augusth 06th, 2020
	 */
	public function callWs_TransactionalLimits_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->dataAccessLog->modulo = 'atención al cliente';
		$this->dataAccessLog->function = 'Limites transaccionales';
		$this->dataAccessLog->operation = 'Consulta de limites';

		$this->dataRequest->idOperation = '217';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->opcion = 'consultar';
		$this->dataRequest->idEmpresa = '0';
		$this->dataRequest->prefix = $dataRequest->prefix;
		$this->dataRequest->cards = [
			[
				'card' => $dataRequest->cardNumber,
				'personName' => $this->session->fullName,
				'personId' => $this->session->userId,
				'lastUpdate' => ''
			]
		];
		$this->dataRequest->usuario = [
			'userName' => $this->userName,
			'idUsuario' => $this->session->userId
		];

		$response = $this->sendToService('callWs_TransactionalLimits');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$response = $response->bean;
				$limits = new stdClass();
				$datalimits = new stdClass();
				$datalimits->updateDateL = $response->cards[0]->lastUpdate != '' ?
				lang('CUST_UPDATE_CURRENT').' '.$response->cards[0]->lastUpdate : '';
				$datalimits->cardnumberL = maskString($response->cards[0]->card, 4, 6);
				$datalimits->customerNameL = $response->cards[0]->personName;
				$datalimits->documentIdL = $response->cards[0]->personId;

				foreach ($response->cards[0]->parameters AS $key => $value) {
					$name = lang('CUST_LIMITS')[$key];
					$limits->$name = $value;
				}

				$this->response->data->limits = $limits;
				$this->response->data->dataLimits = $datalimits;

			break;
			case -454:
				$this->response->title = lang('GEN_MENU_CUSTOMER_SUPPORT');
				$this->response->msg = lang('CUST_CARD_TEMPORARY_LOCK');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -447:
				$this->response->title = lang('GEN_MENU_CUSTOMER_SUPPORT');
				$this->response->msg = lang('CUST_NON_RESULTS');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -306:
				$this->load->model('Novo_Assets_Model', 'getToken');
				$this->response = $this->getToken->callWs_GetToken_Assets();
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
			break;
		}

		return $this->responseToTheView('callWs_TransactionalLimits');
	}
	/**
	 * @info Método para solictar el cambio de PIN de una tarjeta
	 * @author J. Enrique Peñaloza Piñero.
	 * @author: Jhonatan Llerena
	 * @date May 14th, 2019
	 */
	public function callWs_ChangePin_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO Business Model: CustomerSupport Method Initialized');

		$this->dataAccessLog->modulo = 'Atención al cliente';
		$this->dataAccessLog->function = 'Servicios';
		$this->dataAccessLog->operation = 'Solictud de Cambio de Pin';

		$expireDate = $this->cryptography->decryptOnlyOneData($dataRequest->expireDate);
		$currentPin = $this->cryptography->decryptOnlyOneData($dataRequest->currentPin);
		$newPin = $this->cryptography->decryptOnlyOneData($dataRequest->newPin);

		$this->dataRequest->idOperation = '112';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->accodUsuario = $this->session->userName;
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->prefix = $dataRequest->prefix;
		$this->dataRequest->fechaExp = $expireDate;
		$this->dataRequest->pin = $currentPin;
		$this->dataRequest->pinNuevo = $newPin;
		$this->dataRequest->tokenOperaciones = isset($dataRequest->otpCode) ? $dataRequest->otpCode : '';
		$this->dataRequest->montoComisionTransaccion = isset($dataRequest->amount) ? $dataRequest->amount : '0';

		$response = $this->sendToService('callWs_ChangePin');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = novoLang(lang('CUST_SUCCESS_CHANGE_PIN'), [$dataRequest->cardNumberMask]);
				$this->response->success = TRUE;
				$this->response->modalBtn['btn1']['link'] = 'atencion-al-cliente';
			break;
			case -308:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('CUST_PIN_NOT_VALID');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -241:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('CUST_DATA_INVALIDATED');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -345:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('CUST_FAILED_ATTEMPTS');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -401:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = novoLang(lang('CUST_PIN_NOT_CHANGED'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -286:
			case -301:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -287:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('GEN_OTP_USED');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -288:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('GEN_EXPIRE_TIME');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -310:
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
				$this->response->msg = lang('CUST_INVALID_EXPIRATION_DATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -125:
			case -304:
			case -911:
				$this->response->title = lang('GEN_MENU_SERVICES');
				$this->response->msg = ($this->isResponseRc == -125) ? novoLang(lang('CUST_EXPIRED_CARD'), $dataRequest->cardNumberMask)
					: lang('CUST_NOT_PROCCESS');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -306:
				$this->load->model('Novo_Assets_Model', 'getToken');
				$this->response = $this->getToken->callWs_GetToken_Assets();
				$this->response->title = lang('CUST_CHANGE_PIN_TITLE');
			break;
		}

		return $this->responseToTheView('callWs_ChangePin');
	}
}
