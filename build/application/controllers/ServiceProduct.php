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
		if (count($dataProduct) == 1 and $dataProduct !== '--') {
			redirect("/atencioncliente");
		}

		array_push (
			$this->includeAssets->jsFiles,
			"$this->countryUri/serviceproduct/$view"
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

		$this->views = ['serviceproduct/'.$view];
		$this->render->data = $dataProduct;
		$this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->render->actualPage = lang('GEN_CONSOLIDATED_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct()
	{
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		if (count($data) < 1){
			return '--';
		}

		$dataRequeried = [];
		foreach($data as $row){
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
				"availableServices" => $row->services
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

		$dataProduct['availableServices'] = ['117'];
		$optionsAvailables = [];
		$menuOptionsProduct = [
			'117' => [
				'id' => 'generate',
				'text' => "<i class='icon-key block'></i>Generar <br>PIN"
			],
			'112' => [
				'id' => 'change',
				'text' => "<i class='icon-key block'></i>Cambio <br>de PIN"
			],
			'110' => [
				'id' => 'lock',
				'text' => "<i class='icon-lock block'></i>Bloqueo <br>de cuenta"
			],
			'111' => [
				'id' => 'replace',
				'text' => "<i class='icon-spinner block'></i>Solicitud <br>de reposición"
			]
		];

		foreach ($menuOptionsProduct as $key => $value) {
			$available = array_search($key, $dataProduct['availableServices']) !== FALSE? '': 'is-disabled';
			$option = "<li id='". $value['id'] . "' class='list-inline-item services-item center ". $available ."'>".$value['text']."</li>";
			array_push($optionsAvailables,$option);
		}

		$this->views = ['serviceproduct/'.$view];

		$this->render->data = $dataProduct;
		$this->render->menuOptionsProduct = $optionsAvailables;
		$this->render->months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
		$this->render->titlePage = lang('GEN_DETAIL_VIEW').' - '.lang('GEN_CONTRACTED_SYSTEM_NAME');
		$this->loadView($view);
	}
}
