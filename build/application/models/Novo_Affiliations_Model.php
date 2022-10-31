<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para el manejo de afiliaciones
 * @author Jhonatan Llerena
 * @date October 20th, 2022
 */
class Novo_Affiliations_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		writeLog('INFO', 'Affiliations Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de cuentas afiliadas
	 * @author Jhonatan Llerena
	 * @date October 17th, 2022
	 */
	public function CallWs_GetAffiliations_Affiliations($dataRequest)
	{
		writeLog('INFO', 'Affiliations Model: GetAffiliations Method Initialized');

		$this->dataAccessLog->modulo = 'Afiliaciones';
		$this->dataAccessLog->function = 'Listar';
		$this->dataAccessLog->operation = $dataRequest->operationType === 'PMV' ? 'Lista los afiliados a un pago movil' : 'Lista los afiliados';

		$this->dataRequest->idOperation = '017';
		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->tipoOperacion = $dataRequest->operationType;
		$this->dataRequest->noTarjeta = isset($dataRequest->cardNumber) ? $dataRequest->cardNumber : '';
		$this->dataRequest->prefix = isset($dataRequest->prefix) ? $dataRequest->prefix : '';

		$response = $this->sendToWebServices('CallWs_GetAffiliations');
		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->data = $response->bean;
				break;

			case -150:
				$this->response->code = 1;
				$this->response->msg = lang('AFFIL_EMPTY_AFFILIATE_ACCOUNTS');
				break;

			default:
				$this->response->code = 2;
				$this->response->title = lang('AFFIL_MANAGE_AFFILIATIONS');
				$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
				break;
		}

		return $this->responseToTheView('CallWs_GetAffiliations');
	}
	/**
	 * @info Método para afiliar una tarjeta beneficiaria
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_AffiliationP2P_Affiliations($dataRequest)
	{
		writeLog('INFO', 'Affiliations Model: AffiliationP2P Method Initialized');

		$this->dataAccessLog->modulo = 'Afiliaciones';

		if (isset($dataRequest->idAfiliation)) {
			$this->dataAccessLog->function = 'Modificar';
			$this->dataAccessLog->operation = 'Procesar modificación P2P';
			$this->dataRequest->idOperation = '041';
			$this->dataRequest->id_afiliacion = $dataRequest->idAfiliation;
		} else {
			$this->dataAccessLog->function = 'Afiliar';
			$this->dataAccessLog->operation = 'Procesar afiliación P2P';
			$this->dataRequest->idOperation = '016';
		}

		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->tipoOperacion = 'P2P';
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->id_ext_per = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->nroCuentaDestino = $dataRequest->destinationCard;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;

		$this->sendToWebServices('callWs_AffiliationP2P');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_SUCCESS_AFFILIATE_UPDATE') : lang('AFFIL_SUCCESS_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'none';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_FAILED_AFFILIATE_UPDATE') : lang('AFFIL_FAILED_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_AffiliationP2P');
	}
	/**
	 * @info Método para afiliar/modificar un benficiario pago movil
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_AffiliationPMV_Affiliations($dataRequest)
	{
		writeLog('INFO', 'Affiliations Model: AffiliationPMV Method Initialized');

		$this->dataAccessLog->modulo = 'Afiliaciones';

		if (isset($dataRequest->idAfiliation)) {
			$this->dataAccessLog->function = 'Modificar';
			$this->dataAccessLog->operation = 'Procesar modificación PMV';
			$this->dataRequest->idOperation = '041';
			$this->dataRequest->id_afiliacion = $dataRequest->idAfiliation;
		} else {
			$this->dataAccessLog->function = 'Afiliar';
			$this->dataAccessLog->operation = 'Procesar afiliación PMV';
			$this->dataRequest->idOperation = '016';
		}

		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->canal = 'CPO';
		$this->dataRequest->tipoOperacion = 'PMV';
		$this->dataRequest->banco = $dataRequest->bank;
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->id_ext_per = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->nro_movil = $dataRequest->mobilePhone;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;

		$this->sendToWebServices('callWs_AffiliationPMV');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_SUCCESS_AFFILIATE_UPDATE') : lang('AFFIL_SUCCESS_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'none';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_FAILED_AFFILIATE_UPDATE') : lang('AFFIL_FAILED_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_AffiliationPMV');
	}
	/**
	 * @info Método para afiliar/modificar una cuenta bancaria beneficiaria
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_AffiliationP2T_Affiliations($dataRequest)
	{
		writeLog('INFO', 'Affiliations Model: AffiliationP2T Method Initialized');

		$this->dataAccessLog->modulo = 'Afiliaciones';

		if (isset($dataRequest->idAfiliation)) {
			$this->dataAccessLog->function = 'Modificar';
			$this->dataAccessLog->operation = 'Procesar modificación P2T';
			$this->dataRequest->idOperation = '041';
			$this->dataRequest->id_afiliacion = $dataRequest->idAfiliation;
		} else {
			$this->dataAccessLog->function = 'Afiliar';
			$this->dataAccessLog->operation = 'Procesar afiliación P2T';
			$this->dataRequest->idOperation = '016';
		}

		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->tipoOperacion = 'P2T';
		$this->dataRequest->banco = $dataRequest->bank;
		$this->dataRequest->beneficiario = $dataRequest->beneficiary;
		$this->dataRequest->id_ext_per = $dataRequest->typeDocument . $dataRequest->idNumber;
		$this->dataRequest->nroCuentaDestino = $dataRequest->destinationAccount;
		$this->dataRequest->nro_movil = $dataRequest->mobilePhone;
		$this->dataRequest->email = $dataRequest->beneficiaryEmail;

		$this->sendToWebServices('callWs_AffiliationP2T');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_SUCCESS_AFFILIATE_UPDATE') : lang('AFFIL_SUCCESS_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'none';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = isset($dataRequest->idAfiliation) ? lang('AFFIL_EDIT_AFFILIATE') : lang('AFFIL_NEW_AFFILIATE');
				$this->response->msg = isset($dataRequest->idAfiliation) ? lang('AFFIL_FAILED_AFFILIATE_UPDATE') : lang('AFFIL_FAILED_AFFILIATE_CREATION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_AffiliationP2T');
	}
	/**
	 * @info Método para eliminar una afiliación
	 * @author Jhonatan Llerena
	 * @date October 11th, 2022
	 */
	public function CallWs_DeleteAffiliation_Affiliations($dataRequest)
	{
		writeLog('INFO', 'Affiliations Model: DeleteAffiliation Method Initialized');

		$this->dataAccessLog->modulo = 'Afiliaciones';
		$this->dataAccessLog->function = 'Eliminar';
		$this->dataAccessLog->operation = 'Procesar eliminación de afiliación ' . $dataRequest->operationType;

		$this->dataRequest->idOperation = '040';
		$this->dataRequest->className = 'com.novo.objects.TOs.AfiliacionTarjetasTO';
		$this->dataRequest->tipoOperacion = $dataRequest->operationType;
		$this->dataRequest->id_afiliacion = $dataRequest->idAfiliation;

		$this->sendToWebServices('callWs_DeleteAffiliation');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->title = lang('AFFIL_DELETE_AFFILIATE');
				$this->response->msg = lang('AFFIL_SUCCESS_AFFILIATE_DELETION');
				$this->response->modalBtn['btn1']['action'] = 'none';
				break;
			default:
				$this->response->code = 1;
				$this->response->title = lang('AFFIL_DELETE_AFFILIATE');
				$this->response->msg = lang('AFFIL_FAILED_AFFILIATE_DELETION');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_DeleteAffiliation');
	}
}
