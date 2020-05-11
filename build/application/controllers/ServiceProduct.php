<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ServiceProduct extends BDB_Controller
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO ServiceProduct Controller class Initialized');
	}

	public function listProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'listproduct';

		if (!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}

		$this->session->unset_userdata('setProduct');

		$dataProduct = $this->loadDataProduct();
		if (count($dataProduct) == 1 and $dataProduct !== '--') {
			$this->session->set_userdata('setProduct', $dataProduct[0]);
			redirect("/atencioncliente");
		}

		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/serviceproduct/$view"
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

		$this->views = ['serviceproduct/' . $view];
		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->render->actualPage = lang('GEN_CONSOLIDATED_VIEW') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($card = '')
	{
		$this->load->model('Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		if (count($data) < 1) {
			return '--';
		}

		$this->session->set_userdata("totalProducts", count($data));

		$dataRequeried = [];
		foreach ($data as $row) {
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

	public function customerSupport()
	{
		log_message('INFO', 'NOVO Consolidated: optionclient Method Initialized');
		$view = 'customersupport';

		if (!$this->session->userdata('logged_in')) {
			redirect(base_url('inicio'), 'location');
			exit();
		}
		$dataProduct = [];
		$optionsAvailables = [];

		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/serviceproduct/$view",
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

		if (!$dataProduct = $this->session->userdata('setProduct')) {

			$dataProduct = $this->loadDataProduct(@$_POST['nroTarjeta'] ?: '')[0];
			$this->session->set_userdata('setProduct', $dataProduct);
		}

		$menuOptionsProduct = [
			'120' => [
				'id' => 'generate',
				'text' => "<i class='icon-key block'></i>Generar<br>PIN",
				'isVisible' => FALSE
			],
			'112' => [
				'id' => 'change',
				'text' => "<i class='icon-key block'></i>Gestión<br>de PIN",
				'isVisible' => TRUE
			],
			'110' => [
				'id' => 'lock',
				'text' => "<i class='icon-lock block'></i>Bloqueo<br>de tarjeta",
				'isVisible' => TRUE
			],
			'111' => [
				'id' => 'replace',
				'text' => "<i class='icon-spinner block'></i>Solicitud<br>de reposición",
				'isVisible' => TRUE
			]
		];

		foreach ($dataProduct['availableServices'] as $value) {

			if (!array_key_exists($value, $menuOptionsProduct)) {
				continue;
			}

			$menuOptionsProduct[$value]['isVisible'] = TRUE;
		}

		if (!empty($dataProduct['bloqueo'])) {
			$menuOptionsProduct['110']['text'] =  "<i class='icon-lock block'></i>Desbloqueo <br>de tarjeta";
		}

		foreach ($menuOptionsProduct as $key => $value) {

			$available = 'is-disabled';

			if (count($dataProduct['availableServices']) !== 0) {
				$available = array_search($key, $dataProduct['availableServices']) !== FALSE ? '' : 'is-disabled';
			}

			if ($value['isVisible']) {
				$option = "<li id='" . $value['id'] . "' class='list-inline-item services-item center " . $available . "'>" . $value['text'] . "</li>";
				array_push($optionsAvailables, $option);
			}
		}

		$this->views = ['serviceproduct/' . $view];

		$this->render->data = $dataProduct;
		$this->render->listReason = $this->config->item('listReasonReposition');
		$this->render->totalProducts = $this->session->userdata('totalProducts');
		$this->render->menuOptionsProduct = $optionsAvailables;
		$this->render->availableServices = count($dataProduct['availableServices']);

		$this->render->months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
		$this->render->titlePage = lang('GEN_DETAIL_VIEW') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}
}