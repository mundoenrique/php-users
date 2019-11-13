<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para la vista principal de la aplicación
 * @author J. Enrique Peñaloza P
*/
class Product extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Controller class Initialized');
	}

	public function listProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'listproduct';

		if(!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}

		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/product/$view"
		);

		if(!is_null($this->config->item('timeIdleSession'))){
			array_push(
				$this->includeAssets->jsFiles,
				"$this->countryUri/watchsession"
			);
		}

		if($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}

		$this->views = ['product/'.$view];
		$this->render->data = $this->loadDataProduct();
		$this->render->titlePage = lang('GEN_SYSTEM_NAME');
		$this->loadView($view);
	}

	public function loadDataProduct($operation = 'all', $card = '')
	{
		$this->load->model('Novo_Product_Model', 'modelLoad');
		$data = $this->modelLoad->callWs_loadProducts_Product();

		$dataRequeried = [];
		foreach($data as $row){
			$productBalance = $this->modelLoad->callWs_getBalance_Product($row->noTarjeta);
			if ( $operation === 'detail' && $card !== $row->noTarjeta ){
				continue;
			}
			array_push($dataRequeried, [
				"noTarjeta" => $row->noTarjeta,
				"noTarjetaConMascara" => $row->noTarjetaConMascara,
				"nombre_producto" => $row->nombre_producto,
				"marca" => strtolower($row->marca),
				"nomEmp" => ucwords(strtolower($row->nomEmp)),
				"productBalance" => $productBalance,
				"id_ext_per" => $row->id_ext_per,
				"nom_plastico" => ucwords(strtolower($row->nom_plastico))
			]);
		}

		return $dataRequeried;
	}

	public function detailProduct()
	{
		log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
		$view = 'detailproduct';

		if(!$this->session->userdata('logged_in')) {

			redirect(base_url('inicio'), 'location');
			exit();
		}

		array_push(
			$this->includeAssets->jsFiles,
			"$this->countryUri/product/$view"
		);
		if($this->config->item('language_form_validate')) {
			array_push(
				$this->includeAssets->jsFiles,
				"localization/spanish-base/messages_$this->countryUri"
			);
		}

		$this->views = ['product/'.$view];
		$this->render->data = $this->loadDataProduct('detail', $_POST['nroTarjeta'])[0];
		$this->render->titlePage = lang('GEN_SYSTEM_NAME');
		$this->loadView($view);
	}

}
