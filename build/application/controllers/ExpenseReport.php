<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class ExpenseReport extends BDB_Controller {

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
		if (is_array($dataProduct) && count($dataProduct) == 1) {
			$this->session->set_userdata('setProduct', $dataProduct[0]);
			redirect("/detallereporte");
		}

		$this->session->set_userdata("totalProducts", count($dataProduct));
		$this->session->set_userdata("listProducts",$dataProduct);

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
				"localization/core-base/messages_$this->countryUri"
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

		$this->load->model('Product_Model', 'modelLoad');
		$listProducts = $this->modelLoad->callWs_loadProducts_Product();

		if (is_array($listProducts->data) && count($listProducts->data) < 1) {
			return $listProducts;
		}

		$dataRequeried = [];
		foreach($listProducts->data as $row) {
			if (!empty($card) && $card !== $row->noTarjeta) {
				continue;
			}
			array_push($dataRequeried, [
				"nroTarjeta" => $row->noTarjeta,
				"nroTarjetaMascara" => $row->noTarjetaConMascara,
				"producto" => $row->prefix,
				"marca" => $row->marca,
				"tarjetaHabiente" => $row->nom_plastico,
				"nomPlastico" => $row->nom_plastico,
				"nomEmp" => $row->nomEmp,
				"tipoTarjeta" => $row->tipo,
				"id_ext_per" => $row->id_ext_per,
				"availableServices" => $row->services,
				"prefix" => $row->prefix,
				"id_ext_emp" => $row->rif,
				"bloque" => $row->bloque
			]);
		}
		$listProducts->data = $dataRequeried;
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
			"third_party/kendo.dataviz",
			"third_party/dataTables-1.10.20",
			"$this->countryUri/expensereport/$view",
			"third_party/jquery.validate",
			"default/validate-forms",
			"third_party/additional-methods",
			"localization/core-base/messages_base"
		);

		if ($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/core-base/messages_$this->countryUri"
			);
		}

		$dataProduct = $this->session->userdata('setProduct');

		if (is_null($dataProduct) || !array_key_exists('producto',$dataProduct)) {

			if (is_null($_POST['nroTarjeta'])){
				redirect('reporte');
			}

			$listProducts = $this->session->userdata('listProducts');
			$cardToLocate = $_POST['nroTarjeta']?:'';

			if (is_null($listProducts)){

				$dataProduct = $this->loadDataProduct($cardToLocate)[0];
			}else{

				$positionNumber = array_search($cardToLocate, array_column($listProducts, 'nroTarjeta'));
				$dataProduct = $listProducts[$positionNumber];
			}
			$this->session->set_userdata('setProduct', $dataProduct);
		}
		$this->load->model('ExpenseReport_Model', 'modelExpense');

		if (isset($_POST['frmInitialDate']) && isset($_POST['frmFinalDate'])){

			$dataRequest = new stdClass();
			$dataRequest->initialDate = $_POST['frmInitialDate'];
			$dataRequest->finalDate = $_POST['frmFinalDate'];
			$dataRequest->typeFile = $_POST['frmTypeFile'];

			$response = $this->modelExpense->getFile_ExpenseReport($dataRequest);
			if ($response->code == 0){

				$oDate = new DateTime();
				$dateFile = $oDate->format("YmdHis");
				np_hoplite_byteArrayToFile($response->data->archivo, $_POST['frmTypeFile'], 'reporte_'.$dateFile);

				$expenses = (object)[];
				$data = (object) ['listaGrupo'=>[]];
				$expenses->data = $data;
			}else{

				$dataForAlert = new stdClass();
				$dataForAlert->message = $response->msg;
				$dataForAlert->redirect = $response->redirect;

				$dataForAlert->monthSelected = $_POST['frmMonth'];
				$dataForAlert->yearSelected = $_POST['frmYear'];

				unset($_POST['frmMonth']);
				unset($_POST['frmYear']);

				$this->session->set_flashdata('showAlert', $dataForAlert);
				redirect(base_url() . 'detallereporte', 'location', 301);
			}
		}else{

			$dataRequest = new stdClass();
			$dataRequest->tipoOperacion = '99';
			$dataRequest->id_ext_per = $dataProduct['id_ext_per'];
			$dataRequest->nroTarjeta = $dataProduct['nroTarjeta'];
			$dataRequest->producto = $dataProduct['producto'];
			$dataRequest->fechaInicial = '01/01/'.date("Y");
			$dataRequest->fechaFinal = '31/12/'.date("Y");

			$expenses = $this->modelExpense->callWs_getExpenses_ExpenseReport($dataRequest);
			if ($expenses->code !== 0) {

				$expensesMsg = $expenses->msg;

				$expenses = (object)[];
				$data = (object) ['listaGrupo'=>[]];
				$expenses->data = $data;
				$expenses->msg = $expensesMsg;
			}
		}

		$this->views = ['expensereport/'.$view];
		$this->render->data = $dataProduct;
		$this->render->totalProducts = $this->session->userdata("totalProducts");
		$this->render->expenses = $expenses->data;
		$this->render->titlePage = lang('GEN_REPORT').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');

		if ($dataAlert = $this->session->flashdata('showAlert')) {

			$this->render->loadAlert = '1';
			$this->render->msgAlert = $dataAlert->message;
			$this->render->redirectAlert = $dataAlert->redirect;
			$this->render->monthSelected = $dataAlert->monthSelected;
			$this->render->yearSelected = $dataAlert->yearSelected;
		}

		$this->loadView($view);

	}
}
