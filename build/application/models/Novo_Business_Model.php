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
		writeLog('INFO', 'Business Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_UserCardsList_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: UserCardsList Method Initialized');


		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Lista de tarjetas';
		$this->dataAccessLog->operation = 'Obtener la lista de tarjetas';

		$this->dataRequest->idOperation = '2';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->idUsuario = $this->session->userId;

		$response = $this->sendToWebServices('callWs_UserCardsList');
		$cardsList = [];
		$serviceList = [];

		switch ($this->isResponseRc) {
			case 0:
				if (isset($response->lista) && count($response->lista) > 0) {
					$this->response->code = 0;
					$this->checkImageUpload();

					foreach ($response->lista AS $pos => $cardsRecords) {
						$cardRecord = new stdClass();
						$cardRecord->cardNumber = $cardsRecords->noTarjeta;
						$cardRecord->expireDate = $cardsRecords->fechaExp;
						$cardRecord->enterprise = $cardsRecords->nomEmp;
						$cardRecord->prefix = $cardsRecords->prefix;
						$cardRecord->status = $cardsRecords->bloque;
						$cardRecord->cardNumberMask = $cardsRecords->noTarjetaConMascara;
						$cardRecord->services = $cardsRecords->services;
						$cardRecord->isVirtual = $cardsRecords->tvirtual;
						$cardRecord->virtualCard = $cardsRecords->tvirtual ? novoLang(lang('GEN_VIRTUAL'), lang('GEN_VIRTUAL_DISJOIN')) : '';
						$cardRecord->tittleVirtual = $cardsRecords->tvirtual ? lang('GEN_VIRTUAL_CARD') : '';

						switch ($cardRecord->status) {
							case '':
								$cardRecord->statusMessage = isset($dataRequest->module) ? '' : lang('GEN_WAIT_BALANCE');
							break;
							case 'PB':
								$cardRecord->statusMessage = lang('GEN_TEMPORARY_LOCK_PRODUCT');
							break;
							case 'NE':
								$cardRecord->statusMessage = lang('GEN_INACTIVE_PRODUCT');
							break;
							case '41':
								$cardRecord->statusMessage =  lang('GEN_LOCK_CARD_LOSS');
							break;
							case '43':
								$cardRecord->statusMessage =  lang('GEN_LOCK_CARD_THEFT');
							break;
							case '75':
								$cardRecord->statusMessage = lang('GEN_LOCK_CARD_WRONG_PIN');
							break;
							default:
								$cardRecord->statusMessage = lang('GEN_PERMANENT_LOCK_PRODUCT');
							break;
						}

						if (isset($dataRequest->module)) {
							$cardRecord->module = $dataRequest->module;
							$cardRecord->statusClasses = $cardRecord->status != '' && $cardRecord->status != 'PB' ? 'inactive cursor-default' : '' ;
						}

						foreach ($cardRecord->services AS $service) {
							array_push($serviceList, $service);
						}

						$cardRecord->productName = mb_strtoupper($cardsRecords->nombre_producto);
						$cardRecord->userIdNumber = $cardsRecords->id_ext_per;
						$produtImgName = normalizeName($cardsRecords->nombre_producto);
						$produtImg =  lang('IMG_PROGRAM_IMG_DEFAULT');
						$produtImgRev = lang('IMG_PROGRAM_IMG_DEFAULT_REV');

						if (array_key_exists($produtImgName, lang('IMG_PROGRAM_IMAGES'))) {
							$produtImg = lang('IMG_PROGRAM_IMAGES')[$produtImgName].'.svg';

							if (file_exists(assetPath('images/programs/'.$this->customerUri.'/'.lang('IMG_PROGRAM_IMAGES')[$produtImgName].'_rev.svg'))) {
								$produtImgRev = lang('IMG_PROGRAM_IMAGES')[$produtImgName].'_rev.svg';
							}
						}

						$cardRecord->productImg = $produtImg;
						$cardRecord->productImgRev = $cardsRecords->tvirtual ? $produtImgRev : '';
						$brand = normalizeName($cardsRecords->marca);
						$brand = str_replace('_', '-', $brand);
						$cardRecord->brand = $brand;
						$cardsList[] = $cardRecord;
					}
				} else {
					$this->response->code = 4;
					$this->response->icon = lang('CONF_ICON_WARNING');
					$this->response->msg = novoLang(
						lang('BUSINESS_WITH_OUT_CARDS'), mb_strtolower(lang('GEN_VALIDATION_LOGGED'))
					);
					$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_SIGNOUT').lang('CONF_LINK_SIGNOUT_START');
				}
			break;
			default:
				if ($this->isResponseRc != -61) {
					$this->session->sess_destroy();
				}

				$this->response->modalBtn['btn1']['link'] = lang('CONF_LINK_SIGNIN');
		}

		$serviceList = array_unique($serviceList);
		$totalCards = count($cardsList);

		if (count($serviceList) == 0) {
			$this->session->set_userdata('noService', TRUE);
		}

		if ($totalCards > 0) {
			$this->session->set_userdata('products', TRUE);
			$this->session->set_userdata('totalCards', $totalCards);
		}

		if (isset($dataRequest->module) && $totalCards == 1) {
			$cardsList[0]->statustext = $cardsList[0]->status == '' ? lang('CUST_TEMPORARY_LOCK') : lang('CUST_UNLOCK_CARD');
			$cardsList[0]->statustextCard = $cardsList[0]->status == '' ? lang('CUST_TEMPORARILY_LOCK') : lang('CUST_UNLOCK');
		}

		if ($totalCards == 1 && !isset($dataRequest->module)) {
			$this->session->set_userdata('oneCard', $cardsList[0]);

			if ($this->response->code == 0) {
				redirect(base_url(lang('CONF_LINK_CARD_DETAIL')), 'Location', 301);
				exit();
			}
		}

		$this->response->data->cardsList = $cardsList;
		$this->response->data->serviceList = $serviceList;

		return $this->responseToTheView('callWs_UserCardsList');
	}
	/**
	 * @info Método para obtener el saldo de una tarjeta
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2020
	 */
	public function callWs_GetBalance_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: GetBalance Method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Lista de tarjetas';
		$this->dataAccessLog->operation = 'Obtener Saldo';

		$this->dataRequest->idOperation = '8';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;

		$response = $this->sendToWebServices('callWs_GetBalance');
		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->msg = lang('CONF_CURRENCY').' '.$response->disponible;
				break;
				default:
				$this->response->code = 1;
				$this->response->msg = '---';
			}

		$this->response->modal = TRUE;
		return $this->responseToTheView('callWs_GetBalance');
	}
	/**
	 * @info Método para obtener el detalle de una tarjeta
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Jun 04th, 2020
	 */
	public function callWs_CardDetail_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: CardDetail Method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'Detalle de la tarjeta';

		$this->dataRequest->idOperation = '3';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->signo = '';
		$this->dataRequest->id_ext_per = $this->session->userId;

		$response = $this->sendToWebServices('callWs_CardDetail');

		$movesList = [];
		$balance = new stdClass();
		$balance->currentBalance = '---';
		$balance->inTransitBalance = '---';
		$balance->availableBalance = '---';
		$totalMoves = new stdClass();
		$totalMoves->credit = '0';
		$totalMoves->debit = '0';
		$cardRecord = new stdClass();
		$cardRecord->status = $response->tarjeta->bloque ?? '';
		$cardRecord->statusMessage = '';

		switch ($this->isResponseRc) {
			case 0:
			case -150:
				$this->response->code = 0;

				switch ($cardRecord->status) {
					case '':
						$cardRecord->statusMessage = '';
					break;
					case 'PB':
						$cardRecord->statusMessage = lang('GEN_TEMPORARY_LOCK_PRODUCT');
					break;
					case 'NE':
						$cardRecord->statusMessage = lang('GEN_INACTIVE_PRODUCT');
					break;
					case '41':
						$cardRecord->statusMessage =  lang('GEN_LOCK_CARD_LOSS');
					break;
					case '43':
						$cardRecord->statusMessage =  lang('GEN_LOCK_CARD_THEFT');
					break;
					case '75':
						$cardRecord->statusMessage = lang('GEN_LOCK_CARD_WRONG_PIN');
					break;
					default:
						$cardRecord->statusMessage = lang('GEN_PERMANENT_LOCK_PRODUCT');
					break;
				}

				if (isset($response->saldos)) {
					$balance->currentBalance = lang('CONF_CURRENCY').' '.$response->saldos->actual;
					$balance->inTransitBalance = lang('CONF_CURRENCY').' '.$response->saldos->bloqueo;
					$balance->availableBalance = lang('CONF_CURRENCY').' '.$response->saldos->disponible;
				}

				if (isset($response->movimientos) && count($response->movimientos) > 0) {
					foreach($response->movimientos AS $pos => $moves) {
						$move = new stdClass();
						$move->date = transformDate($moves->fecha);
						$move->desc = implode(' ',array_filter(explode(' ',ucfirst(mb_strtolower($moves->concepto)))));
						$move->ref = $moves->referencia;
						$move->sign = $moves->signo;
						$move->amount = lang('CONF_CURRENCY').' '.$moves->monto;
						$movesList[] = $move;
					}
				}

				$totalMoves->credit = isset($response->totalAbonos) ? $response->totalAbonos : $totalMoves->credit;
				$totalMoves->debit = isset($response->totalCargos) ? $response->totalCargos : $totalMoves->debit;
			break;
			default:
				if ($this->session->totalCards == 1) {
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}
		}

		$this->response->data->movesList = $movesList;
		$this->response->data->balance = $balance;
		$this->response->data->totalMoves = $totalMoves;
		$this->response->data->status = $cardRecord->status;
		$this->response->data->statusMessage = $cardRecord->statusMessage;

		return $this->responseToTheView('callWs_CardDetail');
	}
	/**
	 * @info Método para obtener los movimientos mensuales
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Jun 06th, 2020
	 */
	public function callWs_MonthlyMovements_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: MonthlyMovements Method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'Movimientos mensuales';

		$this->dataRequest->idOperation = '13';
		$this->dataRequest->className = 'com.novo.objects.MO.MovimientosTarjetaSaldoMO';
		$this->dataRequest->mes = $dataRequest->filterMonth;
		$this->dataRequest->anio = $dataRequest->filterYear;
		$this->dataRequest->signo = $dataRequest->transType ?? '';
		$this->dataRequest->tarjeta = [
			'noTarjeta' => $dataRequest->cardNumber,
			'id_ext_per' => $this->session->userId,
		];

		$response = $this->sendToWebServices('callWs_MonthlyMovements');
		$movesList = [];
		$totalMoves = new stdClass();
		$totalMoves->credit = '0';
		$totalMoves->debit = '0';

		switch ($this->isResponseRc) {
			case 0:
			case -150:
				$this->response->code = 0;

				if (isset($response->movimientos) && count($response->movimientos) > 0) {
					foreach($response->movimientos AS $pos => $moves) {
						$move = new stdClass();
						$move->date = transformDate($moves->fecha);
						$move->desc = implode(' ',array_filter(explode(' ',ucfirst(mb_strtolower($moves->concepto)))));
						$move->ref = $moves->referencia;
						$move->sign = $moves->signo;
						$move->amount = lang('CONF_CURRENCY').' '.$moves->monto;
						$movesList[] = $move;
					}
				}

				$totalMoves->credit = isset($response->totalAbonos) ? $response->totalAbonos : $totalMoves->credit;
				$totalMoves->debit = isset($response->totalCargos) ? $response->totalCargos : $totalMoves->debit;
			break;
			default:

		}
		$this->response->data->movesList = $movesList;
		$this->response->data->totalMoves = $totalMoves;

		return $this->responseToTheView('callWs_MonthlyMovements');
	}
	/**
	 * @info Método para obtener descargar xls o pdf de movimientos
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Jun 06th, 2020
	 */
	public function callWs_DownloadMoves_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: DownloadMoves Method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'Decargar archivos';

		$this->dataRequest->idOperation = $dataRequest->id == 'downloadPDF' ||  $dataRequest->id == 'sendPDF' ? '5' : '46';
		$this->dataRequest->className = 'novo.objects.MO.MovimientosTarjetaSaldoMO';
		$this->dataRequest->mes = $dataRequest->month == '0' ? '' : $dataRequest->month;
		$this->dataRequest->anio = $dataRequest->year  == '0' ? '' : $dataRequest->year;
		$this->dataRequest->signo = '';
		$this->dataRequest->mail = $dataRequest->action == 'send' ? TRUE : FALSE;
		$this->dataRequest->tarjeta = [
			'noTarjeta' => $dataRequest->cardNumberDownd,
			'id_ext_per' => $this->session->userId,
		];

		$response = $this->sendToWebServices('callWs_DownloadMoves');

		switch ($this->isResponseRc) {
			case 0:
				switch ($dataRequest->action) {
					case 'download':
						$this->response->code = 0;
						$file = $response->bean->archivo ?? $response->archivo;
						$name = $response->bean->nombre ?? $response->nombre;
						$ext = isset($response->bean->formatoArchivo) ? mb_strtolower($response->bean->formatoArchivo) : mb_strtolower($response->formatoArchivo);
						$this->response->data->file = $file;
						$this->response->data->name = $name.'.'.$ext;
						$this->response->data->ext = $ext;
					break;
					case 'send':
						$fitype = $dataRequest->id == 'downloadPDF' ? 'PDF' : 'EXCEL';
						$this->response->title = novoLang(lang('GEN_SEND_FILE'), $fitype);
						$this->response->icon = lang('CONF_ICON_SUCCESS');
						$this->response->msg = lang('GEN_MAIL_SUCCESS');
						$this->response->modalBtn['btn1']['action'] = 'destroy';
					break;
				}
			break;
		}

		return $this->responseToTheView('callWs_DownloadMoves');
	}
	/**
	 * @info Método para obtener lista de tarjetas para operaciones
	 * @author J. Enrique Peñaloza Piñero
	 * @date Sep 08th, 2020
	 */
	public function callWs_CardListOperations_Business ($dataRequest)
	{
		writeLog('INFO', 'Business Model: CardListOperations Method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'Lista de tarjetas para ' . $dataRequest->operation;

		$this->dataRequest->idOperation = '6';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->tipoOperacion = $dataRequest->operType;
		$this->dataRequest->id_ext_per = $this->session->userId;

		$response = $this->sendToWebServices('callWs_CardListOperations');
		$cardsList = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;

				if (isset($response->cuentaOrigen) && count($response->cuentaOrigen) > 0) {
					foreach ($response->cuentaOrigen AS $pos => $cardsRecords) {
						$cardRecord = new stdClass();
						$cardRecord->cardNumber = $cardsRecords->nroTarjeta;
						$cardRecord->prefix = $cardsRecords->prefix;
						$cardRecord->status = $cardsRecords->bloque;
						$cardRecord->statusMessage = $cardsRecords->bloque;
						$cardRecord->enterprise = $cardsRecords->nomEmp;
						$cardRecord->cardNumberMask = $cardsRecords->nroTarjetaMascara;
						$cardRecord->productName = mb_strtoupper($cardsRecords->producto);
						$produtImgName = normalizeName($cardsRecords->producto);
						$produtImg =  lang('IMG_PROGRAM_IMG_DEFAULT');
						$produtImgRev = lang('IMG_PROGRAM_IMG_DEFAULT_REV');
						$cardRecord->isVirtual = $cardsRecords->tvirtual ?? '';
						$cardRecord->tittleVirtual = $cardRecord->isVirtual ? lang('GEN_VIRTUAL_CARD') : '';
						$cardRecord->virtualCard = $cardRecord->isVirtual ? novoLang(lang('GEN_VIRTUAL'), lang('GEN_VIRTUAL_DISJOIN')) : '';

						if (array_key_exists($produtImgName, lang('IMG_PROGRAM_IMAGES'))) {
							$produtImg = lang('IMG_PROGRAM_IMAGES')[$produtImgName].'.svg';

							if (file_exists(assetPath('images/programs/'.$this->customerUri.'/'.lang('IMG_PROGRAM_IMAGES')[$produtImgName].'_rev.svg'))) {
								$produtImgRev = lang('IMG_PROGRAM_IMAGES')[$produtImgName].'_rev.svg';
							}
						}

						$cardRecord->productImg = $produtImg;
						$cardRecord->productImgRev = $cardRecord->isVirtual ? $produtImgRev : '';
						$brand = normalizeName($cardsRecords->marca);
						$brand = str_replace('_', '-', $brand);
						$cardRecord->brand = $brand;
						$cardsList[] = $cardRecord;
					}
				}
			break;
			case -150:
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('GEN_CARDS_NO_ENABLED');
			break;
		}

		$this->response->data->cardsList = $cardsList;

		return $this->responseToTheView('callWs_CardListOperations');
	}

	public function callWs_getVirtualDetail_Business($dataRequest)
	{
		writeLog('INFO', 'Business Model: getVirtualDetail method Initialized');

		$this->dataAccessLog->modulo = 'Tarjetas';
		$this->dataAccessLog->function = 'Consulta';
		$this->dataAccessLog->operation = 'obtener cvv2';

		$this->dataRequest->idOperation = '121';
		$this->dataRequest->className = 'com.novo.objects.TOs.CuentaTO';

		$this->dataRequest->codigoOtp = !empty($dataRequest->codeOTP) ? $dataRequest->codeOTP : '';
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->telephoneNumber = $this->session->mobilePhone;

		if (empty($dataRequest->codeOTP)) {
			$this->dataRequest->idOperation = '214';
			$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
			$this->dataRequest->emailCliente = $this->session->userEmail;
			$this->dataRequest->noTarjeta = $dataRequest->cardNumberDownd;
		}

		$response = $this->sendToWebServices('callWs_getVirtualDetail');

		switch ($this->isResponseRc) {
			case 0:
				$fechaExp = $this->encrypt_decrypt->aesCryptography($response->fechaExp, FALSE);
				$left = substr($fechaExp, 0, 2);
				$right = substr($fechaExp, 2, 2);
				$expirationDate = $left.'/'.$right;

				$this->response->code = 0;
				$this->response->dataDetailCard =  [
					'cardNumber' => $this->encrypt_decrypt->aesCryptography($response->noTarjeta, FALSE),
					'cardholderName' => $this->encrypt_decrypt->aesCryptography($response->NombreCliente, FALSE),
					'expirationDate' => $expirationDate,
					'securityCode' => $this->encrypt_decrypt->aesCryptography($response->secureToken, FALSE),
				];
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_CLOSE');
				$this->response->modalBtn['btn1']['action'] = 'none';
			break;
			case -424://MODAL OTP
				$this->response->code = 2;
				$this->response->modalBtn['btn1']['action'] = 'none';
				$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
				$this->response->modalBtn['btn2']['action'] = 'none';
			break;
		}

		return $this->responseToTheView('callWs_getVirtualDetail');
	}
}
