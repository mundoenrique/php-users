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
		writeLog('INFO', 'Reports Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date Sep 10th, 2020
	 */
	public function callWs_GetMovements_Reports($dataRequest)
	{
		writeLog('INFO', 'Reports Model: GetMovements Method Initialized');

		$this->dataAccessLog->modulo = 'Reportes';
		$this->dataAccessLog->function = 'Gastos por categoría';
		$this->dataAccessLog->operation = 'Movimientos';

		$cardNumber = decryptData($dataRequest->cardNumber);

		$this->dataRequest->idOperation = 'buscarListadoGastosRepresentacion';
		$this->dataRequest->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataRequest->idPersona = $this->session->userId;
		$this->dataRequest->nroTarjeta = $cardNumber;
		$this->dataRequest->fechaIni = $dataRequest->initDate;
		$this->dataRequest->fechaFin = $dataRequest->finalDate;
		$this->dataRequest->producto = $dataRequest->prefix;
		$this->dataRequest->tipoConsulta = $dataRequest->typeInquiry;

		$response = $this->sendToService('callWs_GetMovements');
		$headers = [];
		$body = [];
		$grafic = [];
		$labels = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				switch ($dataRequest->typeInquiry) {
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

				foreach ($response->listaGrafico AS $items) {
					foreach ($items->categorias AS $pos => $categories) {
						$category = new stdClass();
						$category->category = $categories->nombreCategoria;
						$category->value = '';
						$category->color = lang('REPORTS_CATEGORY_COLOR')[$pos];
						array_push($grafic, $category);
					}

					foreach ($items->series[0]->valores AS $pos => $value) {
						$grafic[$pos]->value = $value;
						$labels[$pos] = currencyFormat($value);
					}
				}

				$this->response->data->headers = $headers;
				$this->response->data->body = $body;
				$this->response->data->grafic = $grafic;
				$this->response->data->labels = $labels;
			break;
			case -150:
				$this->response->code = 1;
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}

		return $this->responseToTheView('callWs_GetMovements');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 14th, 2019
	 */
	public function callWs_DownloadInquiry_Reports($dataRequest)
	{
		writeLog('INFO', 'Reports Model: DownloadInquiry Method Initialized');

		$this->dataAccessLog->modulo = 'Reportes';
		$this->dataAccessLog->function = 'Gastos por categoría';
		$this->dataAccessLog->operation = 'Movimientos';

		$cardNumber = decryptData($dataRequest->cardNumber);

		$OperId = $dataRequest->id == 'downloadPDF' ||  $dataRequest->id == 'sendPDF' ? 'generarArchivoPDFGastosRepresentacion'
			: 'generarArchivoXlsGastosRepresentacion';
		$this->dataRequest->idOperation = $OperId;
		$this->dataRequest->className = 'com.novo.objects.MO.GastosRepresentacionMO';
		$this->dataRequest->idPersona = $this->session->userId;
		$this->dataRequest->nroTarjeta = $cardNumber;
		$this->dataRequest->fechaIni = $dataRequest->initDate;
		$this->dataRequest->fechaFin = $dataRequest->finalDate;
		$this->dataRequest->producto = $dataRequest->prefix;
		$this->dataRequest->tipoConsulta = $dataRequest->typeInquiry;
		$this->dataRequest->mail = $dataRequest->action == 'send' ? TRUE : FALSE;

		$response = $this->sendToService('callWs_DownloadInquiry');


		switch ($this->isResponseRc) {
			case 0:
				switch ($dataRequest->action) {
					case 'download':
						$this->response->code = 0;
						$file = $response->bean->archivo ?? $response->archivo;
						$name = $response->bean->nombre ?? $response->nombre;
						$ext = $dataRequest->id == 'downloadPDF' ? 'pdf' : 'xls';
						$this->response->data->file = $file;
						$this->response->data->name = $name.'.'.$ext;
						$this->response->data->ext = $ext;
					break;
					case 'send':
						$fitype = $dataRequest->id == 'downloadPDF' ? 'PDF' : 'EXCEL';
						$this->response->title = novoLang(lang('GEN_SEND_FILE'), $fitype);
						$this->response->icon = lang('CONF_ICON_SUCCESS');
						$this->response->msg = lang('GEN_MAIL_SUCCESS');
						$this->response->modalBtn['btn1']['action'] = 'destroy';
					break;
				}
			break;
		}

		return $this->responseToTheView('callWs_DownloadInquiry');
	}
}
