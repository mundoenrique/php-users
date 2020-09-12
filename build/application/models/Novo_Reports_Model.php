<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Clase para la obtención de reportes
 * @author J. Enrique Peñaloza Piñero
 * @date Sep 10th, 2020
 */
class Novo_Reports_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Reports Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_GetMovements_Reports($dataRequest)
	{
		log_message('INFO', 'NOVO Reports Model: GetMovements Method Initialized');

		$this->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataAccessLog->modulo = 'Reportes';
		$this->dataAccessLog->function = 'Gastos por categoría';
		$this->dataAccessLog->operation = 'Movimientos';

		$cardNumber = json_decode(base64_decode($dataRequest->cardNumber));
		$cardNumber = $this->cryptography->decrypt(
			base64_decode($cardNumber->plot),
			utf8_encode($cardNumber->password)
		);

		$this->dataRequest->idOperation = 'buscarListadoGastosRepresentacion';
		$this->dataRequest->idPersona = $this->session->userId;
		$this->dataRequest->nroTarjeta = $cardNumber;
		$this->dataRequest->fechaIni = $dataRequest->initDate;
		$this->dataRequest->fechaFin = $dataRequest->finalDate;
		$this->dataRequest->producto = $dataRequest->prefix;
		$this->dataRequest->tipoConsulta = $dataRequest->action;

		$response = $this->sendToService('GetMovements');
		$headers = [];
		$body = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				switch ($dataRequest->action) {
					case '0':
						foreach (lang('GEN_SELECT_MONTH') AS $monthName) {
							$body[$monthName] = [];
						}

						foreach ($response->listaGrupo AS $items) {
							$headers[lang('REPORTS_CATEGORY_ICON')[$items->idGrupo]] = lang('REPORTS_CATEGORY_GROUP')[$items->idGrupo];

							foreach ($items->gastoMensual AS $expense) {
								$body[ucfirst(mb_strtolower($expense->mes))][] = $expense->monto;
							}

							$body['Total'][] = $items->totalCategoria;
						}

						foreach ($response->totalesAlMes AS $expense) {
							$body[ucfirst(mb_strtolower($expense->mes))][] = $expense->monto;
						}

						$body['Total'][] = $response->totalGeneral;
					break;
					case '1':
						foreach ($response->listaGrupo AS $items) {
							$headers[lang('REPORTS_CATEGORY_ICON')[$items->idGrupo]] = lang('REPORTS_CATEGORY_GROUP')[$items->idGrupo];

							foreach ($items->gastoDiario AS $expense) {
								$body[$expense->fechaDia][] = $expense->monto;
							}

							$body['Total'][] = $items->totalCategoria;
						}

						foreach ($response->totalesPorDia AS $expense) {
							$body[$expense->fechaDia][] = $expense->monto;
						}

						$body['Total'][] = $response->totalGeneral;
					break;
				}

				$this->response->data['headers'] = $headers;
				$this->response->data['body'] = $body;
			break;
			case -150:
				$this->response->code = 1;
				$this->response->data['btn1']['action'] = 'close';
			break;
		}

		return $this->responseToTheView('GetMovements');
	}
}
