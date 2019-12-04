<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class Novo_ServiceProduct_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}

	public function callWs_generate_ServiceProduct($dataRequest)
	{
		log_message('INFO', 'NOVO Service Product Model: Services Product method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'Cuentas';
		$this->dataAccessLog->function = 'Generar PIN';
		$this->dataAccessLog->operation = 'Generar PIN';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '120';
		$this->dataRequest->userName = $this->session->userdata('userName');
		$this->dataRequest->idUsuario = $this->session->userdata('idUsuario');
		$this->dataRequest->token = $this->session->userdata('token');

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

		$this->dataRequest->newPin = base64_encode($dataRequest->newPin);
		$this->dataRequest->noTarjeta = base64_encode($dataProduct['noTarjeta']);
		$this->dataRequest->fechaExp = $dataProduct['fechaExp'];
		$this->dataRequest->prefix = $dataProduct['prefix'];

		log_message("info", "Request List Products:" . json_encode($this->dataRequest));
		$response = $this->sendToService('Product');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					return $response->lista;
					break;
			}
		}
	}
}
