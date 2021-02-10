<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class ExpenseReport_Model extends BDB_Model
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}

	public function callWs_getExpenses_ExpenseReport($dataRequest)
	{
		log_message('INFO', 'NOVO ExpenseReport Model: get Expens  method Initialized');

		$this->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataAccessLog->modulo = 'tarjeta';
		$this->dataAccessLog->function = 'tarjeta';
		$this->dataAccessLog->operation = 'consultar movimientos';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = 'buscarListadoGastosRepresentacion';
		$this->dataRequest->idPersona = $dataRequest->id_ext_per;
		$this->dataRequest->nroTarjeta = $dataRequest->nroTarjeta;
		$this->dataRequest->producto = $dataRequest->producto;
		$this->dataRequest->fechaIni = empty($dataRequest->fechaInicial) ? '01/01/' . date("Y") : $dataRequest->fechaInicial;
		$this->dataRequest->fechaFin = empty($dataRequest->fechaFinal) ? '31/12/' . date("Y") : $dataRequest->fechaFinal;
		$this->dataRequest->tipoConsulta = empty($dataRequest->tipoOperacion) ? '1' : '0';
		$this->dataRequest->token = $this->session->userdata('token');
		$this->dataRequest->acCodCia = $this->session->userdata('codCompania');

		log_message("info", "Request dataReport Product:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->data = $response;
					$this->response->msg = $response->msg;
					break;

				case -150:
					$this->response->code = 1;
					$this->response->data = [];
					$this->response->msg = lang('RESP_EMPTY_TRANSACTIONHISTORY_PRODUCTS');
					break;

				default:
					$this->response->code = 2;
					$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
					break;
			}
		}
		return $this->response;
	}

	public function getFile_ExpenseReport($dataRequest)
	{
		log_message('INFO', 'NOVO ExpenseReport Model: getPDF  method Initialized');

		if ($dataRequest->typeFile == 'pdf') {

			$this->dataAccessLog->operation = 'generarArchivoXlsGastosRepresentacion';
			$this->dataRequest->idOperation = 'generarArchivoPDFGastosRepresentacion';
		} else {

			$this->dataAccessLog->operation = 'generarArchivoXlsGastosRepresentacion';
			$this->dataRequest->idOperation = 'generarArchivoXlsGastosRepresentacion';
		}

		$this->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataAccessLog->function = 'gastos por categoria';
		$this->dataAccessLog->modulo = 'reportes';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idPersona = $dataRequest->idPersona;
		$this->dataRequest->nroTarjeta = $dataRequest->nroTarjeta;
		$this->dataRequest->producto = $dataRequest->producto;
		$this->dataRequest->idExtEmp = $dataRequest->idExtEmp;

		$this->dataRequest->fechaIni = empty($dataRequest->initialDate) ? '01/01/' . date("Y") : $dataRequest->initialDate;
		$this->dataRequest->fechaFin = empty($dataRequest->finalDate) ? '31/12/' . date("Y") : $dataRequest->finalDate;
		$this->dataRequest->tipoConsulta = empty($dataRequest->tipoOperacion) ? '1' : $dataRequest->tipoOperacion;

		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request getFile Expenses: " . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->data = $response;
					break;

				case -150:
					$this->response->code = 1;
					$this->response->data = [];
					$this->response->msg = lang('RESP_EMPTY_TRANSACTIONHISTORY_PRODUCTS');
					break;

				default:
					$this->response->code = 2;
					$this->response->msg = lang('GEN_SYSTEM_MESSAGE');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url(''),
							'action' => 'redirect'
						]
					];
					break;
			}
		}
		return $this->response;
	}
}
