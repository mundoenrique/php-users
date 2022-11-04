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
	 * @info Método para realizar un pago movil
	 * @author Jhonatan Llerena
	 * @date October 24th, 2022
	 */
	public function CallWs_MobilePayment_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: MobilePayment Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';

		$this->dataAccessLog->function = 'Pago movil';
		$this->dataAccessLog->operation = 'Procesar pago movil';
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
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('TRANSF_RESULTS');
				$this->response->data = $response;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = lang('TRANSF_RESULTS');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
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
		// $this->dataRequest->nombreBeneficiario = $dataRequest->beneficiary;
		// $this->dataRequest->idExtPer = $dataRequest->idDocument;
		$this->dataRequest->ctaDestino = $dataRequest->destinationCard;
		$this->dataRequest->monto = $dataRequest->amount;
		$this->dataRequest->descripcion = $dataRequest->concept;
		// $this->dataRequest->email = $dataRequest->beneficiaryEmail;
		$this->dataRequest->validacionFechaExp = $dataRequest->expDateCta;
		$this->dataRequest->id_afil_terceros = isset($dataRequest->idAfiliation) ? $dataRequest->idAfiliation : '';

		$response = $this->sendToWebServices('callWs_TransferP2P');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('TRANSF_RESULTS');
				$this->response->data = $response;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = lang('TRANSF_RESULTS');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_TransferP2P');
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
				$this->response->data = $response->data->listaTransferenciasRealizadas;
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
