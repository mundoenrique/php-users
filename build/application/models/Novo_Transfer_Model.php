<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información de las transferencias del usuario
 * @author Hector D. Corredor Gutierrez
 * @date May 06th, 2022
 */
class Novo_Transfer_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		writeLog('INFO', 'Transfer Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de bancos
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_GetBanks_Transfer()
	{
		writeLog('INFO', 'Transfer Model: GetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Listar';
		$this->dataAccessLog->operation = 'Consultar banco';

		$this->dataRequest->idOperation = '17';
		$this->dataRequest->className = 'java.lang.String';

		$response = $this->sendToWebServices('CallWs_GetBanks');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response->lista;
				break;
		}

		return $this->responseToTheView('CallWs_GetBanks');
	}
	/**
	 * @info Método para realizar un pago móvil
	 * @author Jhonatan Llerena
	 * @date October 24th, 2022
	 */
	public function CallWs_MobilePayment_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: MobilePayment Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';

		$this->dataAccessLog->function = 'Pago móvil';
		$this->dataAccessLog->operation = 'Procesar pago móvil';
		$this->dataRequest->idOperation = '250';


		$this->dataRequest->className = 'com.novo.objects.TOs.TransferenciaPagoMovilTO';
		$this->dataRequest->tipoOperacion = 'PMV';
		$this->dataRequest->idUsuario = $this->session->userName;
		$this->dataRequest->ctaOrigen = $dataRequest->cardNumber;
		$this->dataRequest->bancoDestino = $dataRequest->bank;
		$this->dataRequest->nombreBeneficiario = $dataRequest->beneficiary;
		$this->dataRequest->idExtPer = $dataRequest->idDocument;
		$this->dataRequest->telefonoDestino = $dataRequest->mobilePhone;
		$this->dataRequest->monto = $dataRequest->amount;
		$this->dataRequest->concepto = $dataRequest->concept;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;
		$this->dataRequest->validacionFechaExp = $dataRequest->expDateCta;
		$this->dataRequest->idAfilTerceros = isset($dataRequest->idAfiliation) ? $dataRequest->idAfiliation : '';

		$response = $this->sendToWebServices('callWs_MobilePayment');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response;
				break;
			case -344:
				$this->response->title = lang('GEN_MENU_MOBILE_PAYMENT');
				$this->response->msg = lang('TRANSF_INCORRECT_EXPIRATION_DATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case -322:
			case 31267:
			case 80031:
			case 80041:
			case 80042:
			case 80043:
			case 201017:
			case 202017:
			case 251033:
			case 1887809:
			case 1888010:
			case 248:
			case 80024:
			case 80025:
			case 80026:
			case 80027:
			case 80028:
			case 80029:
			case 80030:
			case 80032:
			case 80033:
			case 80034:
			case 80035:
			case 80036:
			case 80038:
			case 80039:
			case 80040:
			case 80044:
			case 80045:
			case 80046:
			case 80047:
			case 80048:
			case 80049:
			case 80050:
			case 101000:
			case 101001:
			case 101500:
			case 101501:
			case 101503:
			case 101504:
			case 101505:
			case 101506:
			case 101507:
			case 101508:
			case 101509:
			case 102511:
			case 141128:
			case 141133:
			case 164045:
			case 201008:
			case 201025:
			case 201134:
			case 201149:
			case 201284:
			case 203079:
			case 700700:
			case 900800:
			case 900801:
			case 900802:
			case 900803:
			case 900804:
			case 900805:
			case 900806:
			case 900807:
			case 900900:
			case 900901:
			case 900902:
			case 900905:
			case 900906:
			case 900907:
			case 900908:
			case 900909:
			case 900910:
			case 1010300:
			case 1802008:
			case 1817025:
			case 1850164:
			case 1875000:
			case 5203019:
			case 5203020:
				$this->response->title = lang('GEN_MENU_MOBILE_PAYMENT');
				$this->response->msg = lang('TRANSF_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case 101042:
			case 169032:
			case 701114:
			case 901100:
				$this->response->title = lang('GEN_MENU_MOBILE_PAYMENT');
				$this->response->msg = novoLang(lang('TRANSF_ID_NUMBER_INCORRECT'), [lang('SETT_CURRENCY'), currencyFormat($response->bean->commissionIncorrectData)]);
				$this->response->code = 2;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				$this->response->data = $response;
				break;
			case 103000:
			case 101029:
			case 161632:
				$this->response->title = lang('GEN_MENU_MOBILE_PAYMENT');
				$this->response->msg = novoLang(lang('TRANSF_PHONE_NUMBER_INCORRECT'), [lang('SETT_CURRENCY'), currencyFormat($response->bean->commissionIncorrectData)]);
				$this->response->code = 2;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case -224:
			case 999:
			case -777:
			case -99:
			case 1205:
			case 30002:
			case 40002:
			case 40003:
			case 40004:
			case 40009:
			case 80007:
			case 80022:
			case 80023:
			case 80037:
			case 1850125:
				$this->response->title = lang('GEN_MENU_MOBILE_PAYMENT');
				$this->response->msg = novoLang(lang('TRANSF_CONFIRM_CREDIT_MEMO'), $response->bean->billNumber);
				$this->response->code = 2;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('callWs_MobilePayment');
	}
	/**
	 * @info Método para realizar una transferencia a tarjeta
	 * @author Jhonatan Llerena
	 * @date October 24th, 2022
	 */
	public function CallWs_TransferP2P_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: TransferP2P Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';

		$this->dataAccessLog->function = 'Transferencia';
		$this->dataAccessLog->operation = 'Procesar transferencia P2P';
		$this->dataRequest->idOperation = '9';

		$this->dataRequest->className = 'com.novo.objects.TOs.TransferenciaTarjetahabienteMO';
		$this->dataRequest->tipoOpe = 'P2P';
		$this->dataRequest->idUsuario = $this->session->userName;
		$this->dataRequest->ctaOrigen = $dataRequest->cardNumber;
		$this->dataRequest->nombreBeneficiario = $dataRequest->beneficiary;
		$this->dataRequest->idExtPer = $dataRequest->idDocument;
		$this->dataRequest->ctaDestino = $dataRequest->destinationCard;
		$this->dataRequest->monto = $dataRequest->amount;
		$this->dataRequest->descripcion = $dataRequest->concept;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;
		$this->dataRequest->validacionFechaExp = $dataRequest->expDateCta;
		$this->dataRequest->idAfilTerceros = isset($dataRequest->idAfiliation) ? $dataRequest->idAfiliation : '';

		$response = $this->sendToWebServices('callWs_TransferP2P');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response;
				$this->response->data->ctaDestinoConMascara = maskString($response->ctaDestino, 4, 6);
				break;
			case -179:
				$this->response->title = lang('TRANSF_TRANSFER_TO_CARD');
				$this->response->msg = lang('GEN_INVALID_DATA');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case -344:
				$this->response->title = lang('TRANSF_TRANSFER_TO_CARD');
				$this->response->msg = lang('TRANSF_INCORRECT_EXPIRATION_DATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case -322:
				$this->response->title = lang('TRANSF_TRANSFER_TO_CARD');
				$this->response->msg = lang('TRANSF_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_TransferP2P');
	}
	/**
	 * @info Método para realizar una transferencia crédito inmediato
	 * @author Jhonatan Llerena
	 * @date March 8th, 2022
	 */
	public function CallWs_TransferPCI_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: TransferPCI Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';

		$this->dataAccessLog->function = 'Transferencia';
		$this->dataAccessLog->operation = 'Procesar transferencia PCI';
		$this->dataRequest->idOperation = '09';

		$this->dataRequest->className = 'com.novo.objects.TOs.TransferenciaCreditoInmediatoTO';
		$this->dataRequest->tipoOperacion = 'PCI';
		$this->dataRequest->idUsuario = $this->session->userName;
		$this->dataRequest->ctaOrigen = $dataRequest->cardNumber;
		$this->dataRequest->bancoDestino = $dataRequest->bank;
		$this->dataRequest->nombreBeneficiario = $dataRequest->beneficiary;
		$this->dataRequest->idExtPer = $dataRequest->idDocument;
		$this->dataRequest->instrumento = $dataRequest->instrumento;
		$this->dataRequest->ctaDestino = $dataRequest->destinationAccount;
		$this->dataRequest->telefonoDestino = $dataRequest->mobilePhone;
		$this->dataRequest->monto = $dataRequest->amount;
		$this->dataRequest->concepto = $dataRequest->concept;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;
		$this->dataRequest->validacionFechaExp = $dataRequest->expDateCta;
		$this->dataRequest->idAfilTerceros = isset($dataRequest->idAfiliation) ? $dataRequest->idAfiliation : '';

		$response = $this->sendToWebServices('callWs_TransferPCI');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response;
				$this->response->data->ctaDestinoConMascara = maskString($response->ctaDestino, 4, 6);
				break;
			case -344:
				$this->response->title = lang('TRANSF_BANK_TRANSFER');
				$this->response->msg = lang('TRANSF_INCORRECT_EXPIRATION_DATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			case -322:
				$this->response->title = lang('TRANSF_TRANSFER_TO_CARD');
				$this->response->msg = lang('TRANSF_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_TransferPCI');
	}
	/**
	 * @info Método para obtener el historial de transferencias/pagos realizados
	 * @author Jhonatan Llerena
	 * @date October 1st, 2022
	 */
	public function CallWs_History_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: History Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencias';
		$this->dataAccessLog->function = 'Historial';
		$this->dataAccessLog->operation = 'Consultar';

		$this->dataRequest->idOperation = '021';
		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->tarjeta = new stdClass();
		$this->dataRequest->tarjeta->tipoOperacion = $dataRequest->operationType;
		$this->dataRequest->tarjeta->noTarjeta = $dataRequest->cardNumber;
		$this->dataRequest->mes = $dataRequest->filterMonth;
		$this->dataRequest->anio = $dataRequest->filterYear;

		$response = $this->sendToWebServices('CallWs_History');
		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response->listaTransferenciasRealizadas;
				break;

			case -150:
				$this->response->code = 1;
				$this->response->msg = lang('TRANSF_DATATABLE_SEMPTYTABLE');
				break;

			default:
				$this->response->code = 2;
				$this->response->title = lang('AFFIL_MANAGE_AFFILIATIONS');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_History');
	}
}
