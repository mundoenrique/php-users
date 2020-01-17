<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class Product extends NOVO_Controller {

	public function __construct ()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Controller class Initialized');
	}

	public function listProduct ()
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
			if (in_array("120",  $dataProduct[0]['availableServices'])) {
				redirect('/atencioncliente');
			}
			else{
				redirect("/detalle");
			}
		}

		array_push (
			$this->includeAssets->jsFiles,
			"$this->countryUri/product/$view"
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

		$this->views = ['product/'.$view];
		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct ($card = '')
	{
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		if (count($data) < 1){
			return '--';
		}

		$dataRequeried = [];
		foreach($data as $row){
			if (!empty($card) && $card !== $row->noTarjeta ){
				continue;
			}
			$productBalance = $this->transforNumber ($this->modelLoad->callWs_getBalance_Product($row->noTarjeta));
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
				"fechaExp" => $row->fechaExp,
				"nom_plastico" => ucwords(strtolower($row->nom_plastico)),
				"availableServices" => $row->services
			]);
		}
		return $dataRequeried;
	}

	public function detailProduct ()
	{
		log_message('INFO', 'NOVO Consolidated: detailProduct Method Initialized');
		$view = 'detailproduct';

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}
		$dataProduct = [];

		array_push(
			$this->includeAssets->jsFiles,
			"third_party/moment",
			"third_party/jquery.easyPaginate",
			"third_party/kendo.dataviz",
			"$this->countryUri/product/$view"
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

		if (in_array("120", $dataProduct['availableServices'])) {

			redirect('/atencioncliente');
		}

		$this->load->model('Novo_Product_Model', 'modelLoad');
		if (isset($_POST['frmMonth']) && isset($_POST['frmYear'])) {
			$dataRequest = new stdClass();
			$dataRequest->month = $_POST['frmMonth'];
			$dataRequest->year = $_POST['frmYear'];
			$dataRequest->typeFile = $_POST['frmTypeFile'];
			$dataRequest->noTarjeta = $dataProduct['noTarjeta'];

			$response = $this->modelLoad->getFile_Product ($dataRequest);
			if ( $response->code == 0) {

					$oDate = new DateTime();
					$dateFile = $oDate->format("YmdHis");
					np_hoplite_byteArrayToFile($response->data->archivo, $_POST['frmTypeFile'], 'movimientos_' . $dateFile);
			}
		}else{

			$dataProduct['movements'] = $this->modelLoad->callWs_getTransactionHistory_Product($dataProduct);
			$dataProduct['totalInMovements'] = $this->calculateTotalTransactions ($dataProduct['movements']);

			$data = $this->modelLoad->callWs_balanceInTransit_Product($dataProduct);
			if (is_object($data) && $data->rc === "200" ) {

				$dataProduct['pendingTransactions'] = $data->pendingTransactions;
				$dataProduct['totalInPendingTransactions'] = $this->calculateTotalTransactions ($dataProduct['pendingTransactions']);
			}
		}

		$year = intval(date("Y"));
		$years = [];
		for($i = $year ; $i>$year-4; $i--) {
			array_push($years, $i);
		}

		$this->views = ['product/'.$view];
		$this->render->data = $dataProduct;
		$this->render->months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$this->render->years = $years;
		$this->render->titlePage = lang('GEN_DETAIL_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	function transforNumberIntoArray ($transforArray)
	{
		if ($transforArray !== '--')
		{
			foreach ($transforArray as $clave => $valor)
			{
				$transforArray[$clave] = $valor->monto ;
			}
		}
		return $transforArray;
	}

	function transforNumber ($transforNumber)
	{

		if ($transforNumber !== '--' and is_string($transforNumber)) {

			$transforNumber = (float)str_replace(',','.', str_replace('.','', $transforNumber));
		}
		return $transforNumber;
	}

	function calculateTotalTransactions ($transactions)
	{
		$totalIncome = 0;
		$totalExpense = 0;
		if ($transactions !== '--')
		{
			foreach ($transactions as $row)
			{
				if (is_string($row->monto)) {
					$row->monto = $this->transforNumber($row->monto);
				}
				$totalIncome += $row->signo == '+'? $row->monto: 0;
				$totalExpense += $row->signo == '-'? $row->monto: 0;
			}
		}
		return ["totalIncome" => $totalIncome, "totalExpense" => $totalExpense];
	}

	function downloadDetail()
	{
		log_message('INFO', 'NOVO Consolidated: downloadDetail Method Initialized');

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}
		$dataProduct = [];

		if (!$dataProduct = $this->session->userdata('setProduct')) {

			$dataProduct = $this->loadDataProduct(@$_POST['nroTarjeta']?:'')[0];
			$this->session->set_userdata('setProduct', $dataProduct);
		}

		$this->load->model('Novo_Product_Model', 'modelLoad');
		if (isset($_POST['frmMonth']) && isset($_POST['frmYear'])) {
			$dataRequest = new stdClass();
			$dataRequest->month = $_POST['frmMonth'];
			$dataRequest->year = $_POST['frmYear'];
			$dataRequest->typeFile = $_POST['frmTypeFile'];
			$dataRequest->noTarjeta = $dataProduct['noTarjeta'];

			$response = $this->modelLoad->getFile_Product ($dataRequest);
			if ( $response->code == 0) {

				$oDate = new DateTime();
				$dateFile = $oDate->format("YmdHis");
				np_hoplite_byteArrayToFile($response->data->archivo, $_POST['frmTypeFile'], 'Movimientos_' . $dateFile);
			}
		}
	}


}
