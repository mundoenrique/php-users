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
				$responseAction = $dataRequest->status == '' ? lang('CUST_LOCKED') : lang('CUST_UNLOCKED');
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = novoLang(lang('CUST_SUCCESS_OPERATION_RESPONSE'), [$dataRequest->cardNumberMask, $responseAction]);
				$this->response->success = TRUE;
				$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_CUSTOMER_SUPPORT');
			break;
			case 7:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = novoLang(lang('CUST_LOCK_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -125:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = novoLang(lang('CUST_EXPIRED_CARD'), $dataRequest->cardNumberMask);
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -286:
			case -301:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -287:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = lang('GEN_OTP_USED');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -288:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
				$this->response->msg = lang('GEN_EXPIRE_TIME');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -306:
				$this->load->model('Novo_Assets_Model', 'getToken');
				$this->response = $this->getToken->callWs_GetToken_Assets();
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');
			break;
			case 29:
			case -21:
			case -33:
			case -300:
				$this->response->title = $dataRequest->status == '' ? lang('CUST_LOCK') : lang('CUST_UNLOCK');

				if ($this->dataRequest->codBloqueo = $dataRequest->status == 'PB') {
					$this->response->msg = lang('CUST_UNLOCK_MESSAGE');
				}

				if ($this->dataRequest->codBloqueo = $dataRequest->status == '') {
					$this->response->msg = novoLang(lang('CUST_NOT_LOCKED'), lang('CUST_TEMPORARY'));
				}

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
				$this->response->msg = $dataRequest->virtual ? lang('CUST_REPLACE_MSG') : novoLang(lang('CUST_SUCCESS_OPERATION_RESPONSE'), [$dataRequest->cardNumberMask, lang('CUST_LOCK_PERMANENT')]);
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->success = TRUE;
				$this->response->modalBtn['btn1']['link'] = $dataRequest->virtual ? lang('CONF_LINK_CARD_LIST') : lang('CONF_LINK_CUSTOMER_SUPPORT');
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
					$this->response->data->msg = novoLang(lang('CUST_REPLACEMENT_COST'), [lang('CONF_CURRENCY'), $cost]);
				}
			break;
			case 29:
			case -33:
			case -300:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = novoLang(lang('CUST_NOT_LOCKED'), lang('CUST_PERMANENT'));
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -578:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('CUST_REPLACEMENT_NOT_PROCCESS');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			case -579:
				$this->response->title = lang('GEN_PERMANENT_LOCK_PRODUCT');
				$this->response->msg = lang('CUST_INSUFFICIENT_FUNDS');
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
				$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_CUSTOMER_SUPPORT');
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
	/**
	 * @info Método para obtener selección de notificaciones
	 * @author J. Enrique Peñaloza Piñero.
	 * @date September 20th, 2021
	 */
	public function callWs_Notifications_CustomerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO CustomerSupport Model: Notifications Method Initialized');

		$this->dataAccessLog->modulo = 'Notificaciones';
		$this->dataAccessLog->function = 'Lista de notificaciones';
		$this->dataAccessLog->operation = 'Consulta de notificaciones';

		$this->dataRequest->idOperation = '49';
		$this->dataRequest->className = 'com.novo.objects.MO.NotificacionMO';
		$this->dataRequest->accodusuario = $this->session->userName;

		$response = $this->sendToService('callWs_Notifications');
		$notification = [
			'userSignUp' => [
				'active' => '0',
				'description' => ''
			],
			'membership' => [
				'active' => '0',
				'description' => ''
			],
			'doubleAuth' => [
				'active' => '0',
				'description' => ''
			],
			'transferCard' => [
				'active' => '0',
				'description' => ''
			],
			'transferBank' => [
				'active' => '0',
				'description' => ''
			],
			'crediCardPay' => [
				'active' => '0',
				'description' => ''
			],
			'userRecovery' => [
				'active' => '0',
				'description' => ''
			],
			'resetPassword' => [
				'active' => '0',
				'description' => ''
			],
			'login' => [
				'active' => '0',
				'description' => ''
			],
			'passwordChange' => [
				'active' => '0',
				'description' => ''
			],
			'pinChange' => [
				'active' => '0',
				'description' => ''
			],
			'cardReplace' => [
				'active' => '0',
				'description' => ''
			],
			'temporaryLock' => [
				'active' => '0',
				'description' => ''
			],
			'temporaryUnLock' => [
				'active' => '0',
				'description' => ''
			]
		];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;

				foreach($response->bean->notificaciones AS $notifications) {
					switch ($notifications->codTexto) {
						case '01':
							$notification['userSignUp']['active'] = $notifications->notificacionAct;
							$notification['userSignUp']['description'] = $notifications->descripcion;
						break;
						case '04':
							$notification['membership']['active'] = $notifications->notificacionAct;
							$notification['membership']['description'] = $notifications->descripcion;
						break;
						case '05':
							$notification['doubleAuth']['active'] = $notifications->notificacionAct;
							$notification['doubleAuth']['description'] = $notifications->descripcion;
						break;
						case '06':
							$notification['transferCard']['active'] = $notifications->notificacionAct;
							$notification['transferCard']['description'] = $notifications->descripcion;
						break;
						case '07':
							$notification['transferBank']['active'] = $notifications->notificacionAct;
							$notification['transferBank']['description'] = $notifications->descripcion;
						break;
						case '08':
							$notification['crediCardPay']['active'] = $notifications->notificacionAct;
							$notification['crediCardPay']['description'] = $notifications->descripcion;
						break;
						case '09':
							$notification['userRecovery']['active'] = $notifications->notificacionAct;
							$notification['userRecovery']['description'] = $notifications->descripcion;
						break;
						case '10':
							$notification['resetPassword']['active'] = $notifications->notificacionAct;
							$notification['resetPassword']['description'] = $notifications->descripcion;
						break;
						case '11':
							$notification['login']['active'] = $notifications->notificacionAct;
							$notification['login']['description'] = $notifications->descripcion;
						break;
						case '12':
							$notification['passwordChange']['active'] = $notifications->notificacionAct;
							$notification['passwordChange']['description'] = $notifications->descripcion;
						break;
						case '13':
							$notification['pinChange']['active'] = $notifications->notificacionAct;
							$notification['pinChange']['description'] = $notifications->descripcion;
						break;
						case '14':
							$notification['cardReplace']['active'] = $notifications->notificacionAct;
							$notification['cardReplace']['description'] = $notifications->descripcion;
						break;
						case '15':
							$notification['temporaryLock']['active'] = $notifications->notificacionAct;
							$notification['temporaryLock']['description'] = $notifications->descripcion;
						break;
						case '16':
							$notification['temporaryUnLock']['active'] = $notifications->notificacionAct;
							$notification['temporaryUnLock']['description'] = $notifications->descripcion;
						break;
					}
				}
			break;
			default:
				if ($this->isResponseRc != -29 && $this->isResponseRc != -35 &&  $this->isResponseRc != -61) {
					$this->response->code = 3;
					$this->response->icon = lang('CONF_ICON_WARNING');
					$this->response->title = lang('GEN_MENU_NOTIFICATIONS');
					$this->response->msg = lang('CUST_NO_NOTIFI_SETTINGS');
					$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_NOTIFICATIONS');
					$this->response->modalBtn['btn1']['action'] = 'redirect';
					$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
					$this->response->modalBtn['btn2']['action'] = 'destroy';
				}
		}

		$this->response->data = $notification;

		return $this->responseToTheView('callWs_Notifications');
	}
	/**
	 * @info Método para actualizar selección de notificaciones
	 * @author J. Enrique Peñaloza Piñero.
	 * @date September 22th, 2021
	 */
	public function callWs_NotificationsUpdate_customerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO CustomerSupport Model: NotificationsUpdate Method Initialized');

		$this->dataAccessLog->modulo = 'Notificaciones';
		$this->dataAccessLog->function = 'Lista de notificaciones';
		$this->dataAccessLog->operation = 'Actualización de notificaciones';

		$this->dataRequest->idOperation = '50';
		$this->dataRequest->className = 'com.novo.objects.MO.NotificacionMO';
		$this->dataRequest->accodusuario = $this->session->userName;
		$this->dataRequest->notificaciones = [
			[
				'tipoMensaje' => 4,
				'codTexto' => 11,
				'notificacionAct' => $dataRequest->login
			],
			[
				'tipoMensaje' => 4,
				'codTexto' => 12,
				'notificacionAct' => $dataRequest->passwordChange
			],
			[
				'tipoMensaje' => 4,
				'codTexto' => 13,
				'notificacionAct' => $dataRequest->pinChange
			],
			[
				'tipoMensaje' => 4,
				'codTexto' => 14,
				'notificacionAct' => $dataRequest->cardReplace
			],
			[
				'tipoMensaje' => 4,
				'codTexto' => 15,
				'notificacionAct' => $dataRequest->temporaryLock
			],
			[
				'tipoMensaje' => 4,
				'codTexto' => 16,
				'notificacionAct' => $dataRequest->temporaryUnLock
			]
		];

		$response = $this->sendToService('callWs_NotificationsUpdate');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_NOTIFICATIONS');
				$this->response->msg = lang('CUST_UPT_NOTIFICATIONS');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}

		return $this->responseToTheView('callWs_NotificationsUpdate');
	}
	/**
	 * @info Método para obtener el historial de notoficaciones
	 * @author J. Enrique Peñaloza Piñero.
	 * @date September 22th, 2021
	 */
	public function callWs_NotificationHistory_customerSupport($dataRequest)
	{
		log_message('INFO', 'NOVO CustomerSupport Model: NotificationHistory Method Initialized');

		$this->dataAccessLog->modulo = 'Notificaciones';
		$this->dataAccessLog->function = 'Historial de notificaciones';
		$this->dataAccessLog->operation = 'Obtener historial';

		$this->dataRequest->idOperation = '51';
		$this->dataRequest->className = 'com.novo.objects.TOs.NotificacionTO';
		$this->dataRequest->accodusuario = $this->session->userName;
		$this->dataRequest->filtroFechaInicio = $dataRequest->initDate . ' 12:00:00 AM';
		$this->dataRequest->filtroFechaFin = $dataRequest->finalDate. ' 11:59:59 PM';
		$this->dataRequest->codTexto = $dataRequest->notificationType;

		$response = $this->sendToService('callWs_NotificationHistory');
		$notification = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;

				foreach($response->bean->notificaciones AS $item => $notifications) {
					$date = new DateTime($notifications->fechaNotificacion);
					$date = $date->format('d/m/Y g:i:s a');

					switch ($notifications->codTexto) {
						case '01':
							$notification[$item]['description'] = lang('CUST_USER_SIGNUP');
							$notification[$item]['date'] = $date;
						break;
						case '04':
							$notification[$item]['description'] = lang('CUST_USER_MEMBERSHIP');
							$notification[$item]['date'] = $date;
						break;
						case '05':
							$notification[$item]['description'] = lang('CUST_DOUBLE_AUTH');
							$notification[$item]['date'] = $date;
						break;
						case '06':
							$notification[$item]['description'] = lang('CUST_TRANSFER_CARD');
							$notification[$item]['date'] = $date;
						break;
						case '07':
							$notification[$item]['description'] = lang('CUST_TRANSFER_BANK');
							$notification[$item]['date'] = $date;
						break;
						case '08':
							$notification[$item]['description'] = lang('CUST_CARD_PAY');
							$notification[$item]['date'] = $date;
						break;
						case '09':
							$notification[$item]['description'] = lang('CUST_USER_RECOVERY');
							$notification[$item]['date'] = $date;
						break;
						case '10':
							$notification[$item]['description'] = lang('CUST_PASS_RECOVERY');
							$notification[$item]['date'] = $date;
						break;
						case '11':
							$notification[$item]['description'] = lang('CUST_LOGIN');
							$notification[$item]['date'] = $date;
						break;
						case '12':
							$notification[$item]['description'] = lang('CUST_PASS_CHANGE');
							$notification[$item]['date'] = $date;
						break;
						case '13':
							$notification[$item]['description'] = lang('CUST_PIN_CHANGE');
							$notification[$item]['date'] = $date;
						break;
						case '14':
							$notification[$item]['description'] = lang('CUST_CARD_REPLACE');
							$notification[$item]['date'] = $date;
						break;
						case '15':
							$notification[$item]['description'] = lang('CUST_TEMP_LOCK');
							$notification[$item]['date'] = $date;
						break;
						case '16':
							$notification[$item]['description'] = lang('CUST_TEMP_UNLOCK');
							$notification[$item]['date'] = $date;
						break;
					}
				}
			break;
		}

		$this->response->data = $notification;

		return $this->responseToTheView('callWs_NotificationHistory');
	}
}
