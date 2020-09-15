<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
 */
class ExpenseReport extends BDB_Controller
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO ExpenseReport Controller class Initialized');
	}

	public function listProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'listproduct';

		if (!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}
		$this->session->unset_userdata('setProductExpense');

		$dataProduct = $this->loadDataProduct();
		if (is_array($dataProduct) && count($dataProduct) == 1) {
			if (in_array("120",  $dataProduct[0]['availableServices'])) {

				redirect('/atencioncliente');
			}

			$this->session->set_userdata('setProductExpense', $dataProduct[0]);
			redirect("/detallereporte");
		}


		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/expensereport/$view"
		);

		if (!is_null($this->config->item('timeIdleSession'))) {
			array_push(
				$this->includeAssets->jsFiles,
				"$this->countryUri/watchsession"
			);
		}

		if ($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/core-base/messages_$this->countryUri"
			);
		}

		$this->views = ['expensereport/' . $view];
		$this->render->data = $dataProduct;
		$this->render->totalProducts = $this->session->userdata("totalProducts");
		$this->render->titlePage = lang('GEN_REPORT') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->render->actualPage = lang('GEN_REPORT') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($card = '')
	{
		$dataRequest = new stdClass();
		$dataRequest->tipoOperacion = 'RGR';

		$this->load->model('Product_Model', 'loadData');
		$listProducts = $this->loadData->callWs_dataReport_Product($dataRequest);


		if (is_array($listProducts->data) && count($listProducts->data) < 1) {
			return $listProducts;
		}

		$this->session->set_userdata("totalProducts", count($listProducts->data));
		$servicesAvailableCards = $this->session->userdata("servicesAvailableCards");

		$dataRequeried = [];
		foreach ($listProducts->data as $row) {
			if (!empty($card) && $card !== $row->noTarjeta) {
				continue;
			}

			$indexServices = array_search($row->nroTarjeta, array_column($servicesAvailableCards, 'noTarjeta'));
			$services = json_decode($servicesAvailableCards[$indexServices]['availableService']);

			array_push($dataRequeried, [
				"nroTarjeta" => $row->nroTarjeta,
				"nroTarjetaMascara" => $row->nroTarjetaMascara,
				"producto" => $row->prefix,
				"nombre_producto" => $row->producto,
				"marca" => $row->marca,
				"tarjetaHabiente" => $row->nomPlastico,
				"nomPlastico" => $row->nomPlastico,
				"nomEmp" => $row->nomEmp,
				"tipoTarjeta" => $row->tipoTarjeta,
				"id_ext_per" => $row->id_ext_per,
				"availableServices" => $services,
				"prefix" => $row->prefix,
				"id_ext_emp" => $row->id_ext_emp,
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

		array_push(
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

		$dataProduct = $this->session->userdata('setProductExpense');

		if (is_null($dataProduct)){

			$dataProduct = array_filter($_POST, function($k) {
				return $k !== 'cpo_name';
			}, ARRAY_FILTER_USE_KEY);

			unset($_POST);

			if (count($dataProduct) < 1) {
				redirect('/reporte');
			}

			$dataProduct['availableServices'] = json_decode($dataProduct['availableServices']);
			$this->session->set_userdata('setProductExpense', $dataProduct);
		}
		if (is_array($dataProduct) && in_array("120", $dataProduct['availableServices'])) {

			redirect('/atencioncliente');
		}

		$this->load->model('ExpenseReport_Model', 'modelExpense');

		if (isset($_POST['frmInitialDate']) && isset($_POST['frmFinalDate'])) {

			$dataRequest = new stdClass();
			$dataRequest->initialDate = $_POST['frmInitialDate'];
			$dataRequest->finalDate = $_POST['frmFinalDate'];
			$dataRequest->typeFile = $_POST['frmTypeFile'];
			$dataRequest->idPersona = $dataProduct['id_ext_per'];
			$dataRequest->nroTarjeta = $dataProduct['nroTarjeta'];
			$dataRequest->producto = $dataProduct['producto'];
			$dataRequest->idExtEmp = $dataProduct['id_ext_emp'];

			$response = $this->modelExpense->getFile_ExpenseReport($dataRequest);
			if ($response->code == 0) {

				$oDate = new DateTime();
				$dateFile = $oDate->format("YmdHis");
				np_hoplite_byteArrayToFile($response->data->archivo, $_POST['frmTypeFile'], 'reporte_' . $dateFile);

				$expenses = (object)[];
				$data = (object) ['listaGrupo' => []];
				$expenses->data = $data;
			} else {

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
		} else {

			$dataRequest = new stdClass();
			$dataRequest->tipoOperacion = '99';
			$dataRequest->id_ext_per = $dataProduct['id_ext_per'];
			$dataRequest->nroTarjeta = $dataProduct['nroTarjeta'];
			$dataRequest->producto = $dataProduct['producto'];
			$dataRequest->fechaInicial = '01/01/' . date("Y");
			$dataRequest->fechaFinal = '31/12/' . date("Y");

			$expenses = $this->modelExpense->callWs_getExpenses_ExpenseReport($dataRequest);
			if ($expenses->code !== 0) {

				$expensesMsg = $expenses->msg;

				$expenses = (object)[];
				$data = (object) ['listaGrupo' => []];
				$expenses->data = $data;
				$expenses->msg = $expensesMsg;
			}
		}

		$this->views = ['expensereport/' . $view];

		$this->render->totalProducts = $this->session->userdata("totalProducts");
		$this->session->unset_userdata("totalProducts");

		$this->render->data = $dataProduct;
		$this->render->expenses = $expenses->data;
		$this->render->titlePage = lang('GEN_REPORT') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');

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
