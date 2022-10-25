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
	 * @info Método para crear clave de operaciones
	 * @author Hector D. Corredor Gutierrez
	 * @date October 11th, 2022
	 */
	public function CallWs_SetOperationKey_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: SetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Creacion clave de operaciones';

		$newOperKey = decryptData($dataRequest->newPass);
		$bntLinkTransfer = uriRedirect();

		$this->dataRequest->idOperation = '31';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->passwordOperaciones = md5($newOperKey);

		$response = $this->sendToService('callWs_NotificationsUpdate');

		if ($this->session->flashdata('currentUri') !== NULL) {
			$bntLinkTransfer = $this->session->flashdata('currentUri');
			$this->session->keep_flashdata('currentUri');
		}

		switch ($this->isResponseRc) {
			case 0:
				$this->session->set_userdata('operKey', TRUE);
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('TRANSF_SUCCESS_CREATED_OPER_KEY');
				$this->response->modalBtn['btn1']['link'] = $bntLinkTransfer;
				break;
		}

		return $this->responseToTheView('CallWs_SetOperationKey');
	}
	/**
	 * @info Método para actualizar la clave de operaciones
	 * @author Hector D. Corredor Gutierrez
	 * @date October 11th, 2022
	 */
	public function CallWs_ChangeOperationKey_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: ChangeOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Actualizar clave operaciones';

		$currentOperKey = decryptData($dataRequest->currentPass);
		$newOperKey = decryptData($dataRequest->newPass);

		$this->dataRequest->idOperation = '32';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->passwordOperacionesOld = md5($currentOperKey);
		$this->dataRequest->passwordOperaciones = md5($newOperKey);

		$response = $this->sendToService('callWs_NotificationsUpdate');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->session->set_userdata('transferAuth', FALSE);
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('TRANSF_UPDATE_OPER_KEY');
				$this->response->modalBtn['btn1']['link'] = uriRedirect();
				break;
			case -22:
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('TRANSF_INCORRECT_CURRENT_OPER_KEY');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_ChangeOperationKey');
	}
	/**
	 * @info Método para validar clave de operaciones
	 * @author Hector D. Corredor Gutierrez
	 * @date October 11th, 2022
	 */
	public function CallWs_GetOperationKey_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: GetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Validar clave operaciones';

		$operKey = decryptData($dataRequest->currentPass);
		$bntLinkTransfer = uriRedirect();

		$this->dataRequest->idOperation = '10';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->passwordOperaciones = md5($operKey);

		$response = $this->sendToService('CallWs_GetOperationKey');

		if ($this->session->flashdata('currentUri') !== NULL) {
			$bntLinkTransfer = $this->session->flashdata('currentUri');
			$this->session->keep_flashdata('currentUri');
		}

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->session->set_userdata('transferAuth', TRUE);
				$this->response->data = $bntLinkTransfer;
				break;
			case -22:
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('TRANSF_INCORRECT_OPER_KEY');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_GetOperationKey');
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

		$response = $this->sendToService('CallWs_GetBanks');

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
		$this->dataRequest->ctaOrigen = $dataRequest->cardNumber;
		$this->dataRequest->bancoDestino = $dataRequest->bank;
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->idExtPer = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->telefonoDestino = $dataRequest->mobilePhone;
		$this->dataRequest->nombreBeneficiario = $dataRequest->beneficiary;
		$this->dataRequest->monto = $dataRequest->amount;
		$this->dataRequest->concepto = $dataRequest->concept;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;
		$this->dataRequest->validacionFechaExp = "0318";

		$this->sendToService('callWs_MobilePayment');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('TRANSF_NEW_AFFILIATE') : lang('TRANSF_EDIT_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('TRANSF_SUCCESS_AFFILIATE_CREATION') : lang('TRANSF_SUCCESS_AFFILIATE_UPDATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			default:
				$this->response->code = 1;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('TRANSF_NEW_AFFILIATE') : lang('TRANSF_FAILED_AFFILIATE_CREATION');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('TRANSF_FAILED_AFFILIATE_CREATION') : lang('TRANSF_FAILED_AFFILIATE_UPDATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_MobilePayment');
	}
}
