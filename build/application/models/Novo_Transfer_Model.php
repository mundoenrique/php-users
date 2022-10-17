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
		log_message('INFO', 'NOVO Transfer Model Class Initialized');
	}
	/**
	 * @info Método para crear clave de operaciones
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_SetOperationKey_Transfer($dataRequest)
	{
		log_message('INFO', 'NOVO Transfer Model: SetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Creacion clave de operaciones';

		$this->dataRequest->idOperation = '16';
		$this->dataRequest->className = 'com.novo.objects.TOs.';
		$this->dataRequest->accodusuario = $this->session->userName;

		$response = $this->sendToService('callWs_NotificationsUpdate');

		return $this->responseToTheView('CallWs_SetOperationKey');
	}
	/**
	 * @info Método para validar clave de operaciones
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_GetOperationKey_Transfer($dataRequest)
	{
		log_message('INFO', 'NOVO Transfer Model: GetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Validar clave de operaciones';

		$this->dataRequest->idOperation = '16';
		$this->dataRequest->className = 'com.novo.objects.TOs.';
		$this->dataRequest->accodusuario = $this->session->userName;

		$response = $this->sendToService('CallWs_GetOperationKey');

		return $this->responseToTheView('CallWs_GetOperationKey');
	}
	/**
	 * @info Método para obtener la lista de bancos
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_GetBanks_Transfer()
	{
		log_message('INFO', 'NOVO Transfer Model: GetOperationKey Method Initialized');

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
	 * @info Método para afiliar cuentas de transferencias/pagos
	 * @date October 11th, 2022
	 */
	public function CallWs_Affiliate_Transfer($dataRequest)
	{
		log_message('INFO', 'NOVO Transfer Model: Affiliate Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Afiliar';
		$this->dataAccessLog->operation = 'Procesar afiliacion';

		// $expireDate = $this->cryptography->decryptOnlyOneData($dataRequest->expireDate);

		$this->dataRequest->idOperation = '16';
		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->id_ext_per = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->nroPlasticoOrigen ="5267491400303119";
		// $this->dataRequest->nroPlasticoOrigen = $dataRequest->cardNumber;
		// $this->dataRequest->prefix = "$dataRequest->prefix";
		// $this->dataRequest->validacionFechaExp = $dataRequest->expireDate;
		$this->dataRequest->validacionFechaExp = "0318";
		$this->dataRequest->banco = $dataRequest->bank;
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->nroCuentaDestino = $dataRequest->operationType === 'P2P' ? $dataRequest->destinationCard : $dataRequest->destinationAccount;
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
