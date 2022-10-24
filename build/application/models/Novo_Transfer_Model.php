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
	 * @author Jhonatan Llerena
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
				$this->response->msg = 'La clave de operaciones se ha creado con exito.';
				$this->response->modalBtn['btn1']['link'] = $bntLinkTransfer;
				break;
		}

		return $this->responseToTheView('CallWs_SetOperationKey');
	}
		/**
	 * @info Método para actualizar la clave de operaciones
	 * @author Jhonatan Llerena
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
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = 'La clave de operaciones se actualizo con exito.';
				$this->response->modalBtn['btn1']['link'] = uriRedirect();
				break;
			case -22:
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = 'La clave de operaciones actual introducida es incorrecto';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_ChangeOperationKey');
	}
	/**
	 * @info Método para validar clave de operaciones
	 * @author Jhonatan Llerena
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
				$this->session->set_userdata('transferAuth', TRUE);
				$this->response->code = 0;
				$this->response->data = $bntLinkTransfer;
				break;
			case -22:
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = 'El password actual introducido es incorrecto';
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
		$this->dataAccessLog->function = 'Afiliar';
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
	 * @info Método para obtener la lista de cuentas afiliadas
	 * @author Jhonatan Llerena
	 * @date October 17th, 2022
	 */
	public function CallWs_GetAffiliations_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: GetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Listados transferencia';
		$this->dataAccessLog->operation = 'Consulta cuentas destino';

		$this->dataRequest->idOperation = '7';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->tipoOperacion = $dataRequest->operationType;
		// $this->dataRequest->tipoOperacion = 'PMOVIL';
		$this->dataRequest->noTarjeta = "5267491400303119";
		$this->dataRequest->prefix = "Y";

		$response = $this->sendToService('CallWs_GetAffiliations');
		// cuentaDestinoPlata
		$affiliateAccounts = [];
		switch ($this->isResponseRc) {
			case 0:
				switch ($dataRequest->operationType) {
					case 'P2P':
						$affiliateAccounts = $response->cuentaDestinoPlata;
						break;
					default:
						$affiliateAccounts = $response->cuentaDestinoTercero;
						break;
				}
				$this->response->code = 0;
				$this->response->data = $affiliateAccounts;
				break;

			case -150:
				$this->response->code = 1;
				$this->response->data = [];
				$this->response->msg = lang('TRANSF_EMPTY_AFFILIATE_ACCOUNTS');
				break;

			default:
				$this->response->code = 2;
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				break;
		}

		return $this->responseToTheView('CallWs_GetAffiliations');
	}
	/**
	 * @info Método para afiliar cuentas de transferencias/pagos
	 * @date October 11th, 2022
	 */
	public function CallWs_Affiliate_Transfer($dataRequest)
	{
		writeLog('INFO', 'Transfer Model: Affiliate Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Afiliar';
		$this->dataAccessLog->operation = $dataRequest->operationType === 'PMV' ? 'Procesar afiliación pago móvil' : 'Procesar afiliacion';

		$nroCuentaDestino = "";
		if ($dataRequest->operationType !== 'PMV') {
			$nroCuentaDestino = $dataRequest->operationType === 'P2P' ? $dataRequest->destinationCard : $dataRequest->destinationAccount;
		}

		$this->dataRequest->idOperation = '16';
		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->id_ext_per = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->nroPlasticoOrigen = "5267491400303119";
		$this->dataRequest->prefix = "Y";
		$this->dataRequest->validacionFechaExp = "0318";
		// $this->dataRequest->nroPlasticoOrigen = $dataRequest->cardNumber;
		// $this->dataRequest->prefix = "$dataRequest->prefix";
		// $this->dataRequest->validacionFechaExp = $dataRequest->expireDate;
		$this->dataRequest->banco = $dataRequest->bank;
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->nroCuentaDestino = $nroCuentaDestino;
		$this->dataRequest->tipoOperacion = $dataRequest->operationType;
		$this->dataRequest->email = isset($dataRequest->email) ? $dataRequest->email : '';
		$this->dataRequest->nro_movil = isset($dataRequest->mobilePhone) ? $dataRequest->mobilePhone : '';

		$this->sendToService('callWs_Affiliate');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('TRANSF_NEW_AFFILIATE');
				$this->response->msg = lang('TRANSF_SUCCESS_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
			default:
				$this->response->code = 1;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('TRANSF_NEW_AFFILIATE');
				$this->response->msg = lang('TRANSF_FAILED_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_Affiliate');
	}
}
