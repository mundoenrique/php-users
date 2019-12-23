<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class Novo_ExpenseReport_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}

	public function callWs_getExpenses_ExpenseReport ($dataRequest) {
		log_message('INFO', 'NOVO ExpenseReport Model: get Expens  method Initialized');

		$dataProduct = $this->session->userdata('setProduct');

		$this->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consultar movimientos';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = 'buscarListadoGastosRepresentacion';
		$this->dataRequest->idPersona = $dataProduct['id_ext_per'];
		$this->dataRequest->nroTarjeta = $dataProduct['nroTarjeta'];
		$this->dataRequest->producto = $dataProduct['producto'];
		$this->dataRequest->fechaIni = empty($dataRequest->fechaInicial)?'01/01/'.date("Y"): $dataRequest->fechaInicial;
		$this->dataRequest->fechaFin = empty($dataRequest->fechaFinal)?'31/12/'.date("Y"): $dataRequest->fechaFinal;
		$this->dataRequest->tipoConsulta = empty($dataRequest->tipoOperacion)? '1': $dataRequest->tipoOperacion;
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request dataReport Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->data = $response; //->cuentaOrigen;
					break;

				default:
					$this->response->code = 1;
					$this->response->msg = lang('RES_DATA_INVALIDATED');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = '--';
			}
		}
		return $this->response;
	}









}
