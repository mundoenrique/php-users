<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class ServiceProduct extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO ServiceProduct Controller class Initialized');
	}

	public function listProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'listproduct';

		if(!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}

		$dataProduct = $this->loadDataProduct();
		if (count($dataProduct) == 1 and $dataProduct !== '--'){
			redirect("/atencioncliente");
		}

		array_push (
			$this->includeAssets->jsFiles,
			"$this->countryUri/serviceproduct/$view"
		);

		if(!is_null($this->config->item('timeIdleSession'))){
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

		$this->views = ['serviceproduct/'.$view];
		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($operation = 'all', $card = '')
	{
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		if (count($data) < 1){
			return '--';
		}

		$dataRequeried = [];
		foreach($data as $row){
			$productBalance = $this->transforNumber ($this->modelLoad->callWs_getBalance_Product($row->noTarjeta));
			if ( $operation === 'detail' && $card !== $row->noTarjeta ){
				continue;
			}
			array_push($dataRequeried, [
				"noTarjeta" => $row->noTarjeta,
				"noTarjetaConMascara" => $row->noTarjetaConMascara,
				"nombre_producto" => $row->nombre_producto,
				"prefix" => $row->prefix,
				"marca" => strtolower($row->marca),
				"nomEmp" => ucwords(strtolower($row->nomEmp)),
				"actualBalance" => $productBalance,
				"ledgerBalance" => "--",
				"availableBalance" => $productBalance,
				"id_ext_per" => $row->id_ext_per,
				"nom_plastico" => ucwords(strtolower($row->nom_plastico))
			]);
		}
		$this->session->set_flashdata('listProducts', $dataRequeried);

		return $dataRequeried;
	}

	public function customerSupport()
	{
		log_message('INFO', 'NOVO Consolidated: optionclient Method Initialized');
		$view = 'customersupport';

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}

		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/serviceproduct/$view",
			"third_party/kendo.dataviz"
		);

		if ($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}

		$listProducts = $this->session->flashdata('listProducts');
		$this->session->set_flashdata('listProducts', $listProducts);

		if (count($listProducts) == 1)
		{
			$dataProduct = $listProducts[0];
		}else
		{
			$posList = array_search($_POST['nroTarjeta'], array_column($listProducts,'noTarjeta'));
			$dataProduct = $listProducts[$posList];
		}
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$movements = $this->modelLoad->callWs_getTransactionHistory_Product($dataProduct);
		$dataProduct['movements'] = $this->transforNumberInArray ($movements);
		$dataProduct['totalInMovements'] = $this->totalInTransactions ($dataProduct['movements']);

		$data = $this->modelLoad->callWs_balanceInTransit_Product($dataProduct);
		if ( $data->rc === "200" ) {

			$dataProduct['actualBalance'] = $this->transforNumber ($data->balance->actualBalance);
			$dataProduct['ledgerBalance'] = $this->transforNumber ($data->balance->ledgerBalance);
			$dataProduct['availableBalance'] = $this->transforNumber ($data->balance->availableBalance);

			$dataProduct['pendingTransactions'] = $this->transforNumberInArray ($data->pendingTransactions);
			$dataProduct['totalInPendingTransactions'] = $this->totalInTransactions ($dataProduct['pendingTransactions']);
		}

		$this->views = ['serviceproduct/'.$view];
		$this->render->data = $dataProduct;
		$this->render->months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$this->render->titlePage = lang('GEN_DETAIL_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	function transforNumberInArray ($transforArray)
	{
		if ($transforArray !== '--')
		{
			foreach ($transforArray as $clave => $valor)
			{
				$valor->monto = $this->transforNumber ($valor->monto);
				$transforArray[$clave] = $valor;
			}
		}
		return $transforArray;
	}

	function transforNumber ($transforNumber)
	{
		return (float)str_replace(',','', $transforNumber);
	}

	function totalInTransactions($transactions)
	{
		$totalIncome = 0;
		$totalExpense = 0;
		if ($transactions !== '--')
		{
			foreach ($transactions as $row)
			{
				$totalIncome += $row->signo == '+'? $row->monto: 0;
				$totalExpense += $row->signo == '-'? $row->monto: 0;
			}
		}
		return ["totalIncome" => $totalIncome, "totalExpense" => $totalExpense];
	}
}
