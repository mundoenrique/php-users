<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class ExpenseReport extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO ExpenseReport Controller class Initialized');
	}

	public function listProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'listproduct';

		if(!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}

		$this->session->unset_userdata('setProduct');

		$dataProduct = $this->loadDataProduct();
		if (count($dataProduct) == 1 and $dataProduct !== '--') {
			$this->session->set_userdata('setProduct', $dataProduct[0]);
			redirect("/detallereporte");
		}

		array_push (
			$this->includeAssets->jsFiles,
			"$this->countryUri/expensereport/$view"
		);

		if(!is_null($this->config->item('timeIdleSession'))) {
			array_push (
				$this->includeAssets->jsFiles,
				"$this->countryUri/watchsession"
			);
		}

		if($this->config->item('language_form_validate')) {
			array_push (
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}

		$this->views = ['expensereport/'.$view];
		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_REPORT').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->render->actualPage = lang('GEN_REPORT').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($card = '')
	{
		$dataRequest = new stdClass();
		$dataRequest->tipoOperacion = 'RGR';

		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_dataReport_Product($dataRequest);

		if (count($data) < 1) {
			return '--';
		}

		$dataRequeried = [];
		foreach($data as $row) {
			if (!empty($card) && $card !== $row->noTarjeta) {
				continue;
			}
			array_push($dataRequeried, [
				"nroTarjeta" => $row->nroTarjeta,
				"nroTarjetaMascara" => $row->nroTarjetaMascara,
				"producto" => $row->prefix,
				"marca" => $row->marca,
				"tarjetaHabiente" => $row->tarjetaHabiente,
				"nomPlastico" => $row->nomPlastico,
				"nomEmp" => $row->nomEmp,
				"tipoTarjeta" => $row->tipoTarjeta,
				"id_ext_per" => $row->id_ext_per,
				"prefix" => $row->prefix,
				"id_ext_emp" => $row->id_ext_emp,
				"bloque" => $row->bloque
			]);
		}
		return $dataRequeried;
	}

	public function detailReport()
	{
		log_message('INFO', 'NOVO Consolidated: optionclient Method Initialized');
		$view = 'detailreport';

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}
		$dataProduct = [];

		array_push (
			$this->includeAssets->jsFiles,
			"$this->countryUri/expensereport/$view",
			"third_party/jquery.validate",
			"validate-forms",
			"third_party/additional-methods",
			"localization/spanish-base/messages_base"
		);

		if ($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}

		if (!$dataProduct = $this->session->userdata('setProduct')) {

			$dataProduct = $this->loadDataProduct(@$_POST['nroTarjeta']?:'')[0];
			$this->session->set_userdata('setProduct', $dataProduct);
		}

		$dataRequest = new stdClass();
		$dataRequest->tipoOperacion = '0';
		$dataRequest->id_ext_per = $dataProduct['id_ext_per'];
		$dataRequest->nroTarjeta = $dataProduct['nroTarjeta'];
		$dataRequest->producto = $dataProduct['producto'];
		$dataRequest->fechaInicial = '01/01/'.date("Y");
		$dataRequest->fechaFinal = '31/12/'.date("Y");

		$this->load->model('Novo_ExpenseReport_Model', 'modelLoad');
		$expenses = $this->modelLoad->callWs_getExpenses_ExpenseReport ($dataRequest);

		$this->views = ['expensereport/'.$view];
		$this->render->data = $dataProduct;
		$this->render->expenses = $expenses;
		$this->render->titlePage = lang('GEN_REPORT').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}
}
