<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para el manejo de afiliaciones
 * @author Jhonatan Llerena
 * @date October 20th, 2022
 */
class Novo_PasswordOperation_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		writeLog('INFO', 'PasswordOperation Model Class Initialized');
	}
		/**
	 * @info Método para crear clave de operaciones
	 * @author Hector D. Corredor Gutierrez
	 * @date October 11th, 2022
	 */
	public function CallWs_SetOperationKey_PasswordOperation($dataRequest)
	{
		writeLog('INFO', 'PasswordOperation Model: SetOperationKey Method Initialized');

		$this->dataAccessLog->modulo = 'Transferencia';
		$this->dataAccessLog->function = 'Clave de operaciones';
		$this->dataAccessLog->operation = 'Creacion clave de operaciones';

		$newOperKey = decryptData($dataRequest->newPass);
		$bntLinkTransfer = uriRedirect();

		$this->dataRequest->idOperation = '31';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;
		$this->dataRequest->passwordOperaciones = md5($newOperKey);

		$response = $this->sendToWebServices('callWs_SetOperationKey');

		if ($this->session->flashdata('currentUri') !== NULL) {
			$bntLinkTransfer = $this->session->flashdata('currentUri');
			$this->session->keep_flashdata('currentUri');
		}

		switch ($this->isResponseRc) {
			case 0:
				$this->session->set_userdata('operKey', TRUE);
				$this->response->code = 0;
				$this->response->icon = lang('SETT_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('PASS_SUCCESS_CREATED_OPER_KEY');
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
	public function CallWs_ChangeOperationKey_PasswordOperation($dataRequest)
	{
		writeLog('INFO', 'PasswordOperation Model: ChangeOperationKey Method Initialized');

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

		$response = $this->sendToWebServices('callWs_ChangeOperationKey');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->session->set_userdata('transferAuth', FALSE);
				$this->response->icon = lang('SETT_ICON_SUCCESS');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('PASS_UPDATE_OPER_KEY');
				$this->response->modalBtn['btn1']['link'] = uriRedirect();
				break;
			case -22:
				$this->response->icon = lang('SETT_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('PASS_INCORRECT_CURRENT_OPER_KEY');
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
	public function CallWs_GetOperationKey_PasswordOperation($dataRequest)
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

		$response = $this->sendToWebServices('CallWs_GetOperationKey');

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
				$this->response->icon = lang('SETT_ICON_WARNING');
				$this->response->title = lang('GEN_MENU_PAYS_TRANSFER');
				$this->response->msg = lang('PASS_INCORRECT_OPER_KEY');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_GetOperationKey');
	}
}
