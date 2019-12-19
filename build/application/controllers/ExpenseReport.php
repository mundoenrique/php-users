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
		$this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->render->actualPage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($card = '')
	{
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		if (count($data) < 1) {
			return '--';
		}

		$dataRequeried = [];
		foreach($data as $row) {
			if (!empty($card) && $card !== $row->noTarjeta) {
				continue;
			}
			array_push($dataRequeried, [
				"noTarjeta" => $row->noTarjeta,
				"noTarjetaConMascara" => $row->noTarjetaConMascara,
				"nombre_producto" => $row->nombre_producto,
				"prefix" => $row->prefix,
				"marca" => strtolower($row->marca),
				"nomEmp" => ucwords(strtolower($row->nomEmp)),
				"id_ext_per" => $row->id_ext_per,
				"fechaExp" => $row->fechaExp,
				"nom_plastico" => ucwords(strtolower($row->nom_plastico)),
				"availableServices" => $row->services,
				"bloqueo" => $row->bloque
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
			"$this->countryUri/serviceproduct/$view",
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

		$this->views = ['expensereport/'.$view];

		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_DETAIL_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}
}
