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

		//pais, cuenta, id_ext_per, pinNuevo, fecExpTarjeta, telephoneNumber

		$this->className = 'com.novo.objects.TOs.CuentaTO';
		$this->dataAccessLog->modulo = 'Cuentas';
		$this->dataAccessLog->function = 'Generar PIN';
		$this->dataAccessLog->operation = 'Generar PIN';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '120';
		$this->dataRequest->userName = $this->session->userdata('userName');
		$this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
		$this->dataRequest->telephoneNumber = $this->session->userdata('celular');
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

		$this->dataRequest->pinNuevo = $dataRequest->newPin;
		$this->dataRequest->codigoOtp = base64_encode($dataRequest->codeOTP);
		$this->dataRequest->cuenta = $dataProduct['noTarjeta'];
		$this->dataRequest->fecExpTarjeta = $dataProduct['fechaExp'];
		$this->dataRequest->prefix = $dataProduct['prefix'];

		log_message("info", "Request ServiceProduct:" . json_encode($this->dataRequest));
		$response = $this->sendToService('ServiceProduct');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->msg = lang('RESP_PIN_GENERATED');
				break;
				case 10:
					$this->response->code = 1;
					break;
				case -308:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_PIN_NOT_VALID');
					break;
				case -241:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_DATA_INVALIDATED');
					break;
				case -345:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_FAILED_ATTEMPTS');
					break;
				case -401:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_PIN_NOT_CHANGED');
					break;
				case -286:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_CODEOTP_INVALID');
					break;
				case -287:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_CODEOTP_USED');
					break;
				case -288:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_EXPIRED_CODEOTP');
					break;
				case -301:
					$this->response->code = 3;
					$this->response->msg = lang('RESP_CODEOTP_INVALID');
					break;
				case -310:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_INVALID_EXPIRATION_DATE');
					break;
				case -306:
					break;
				case -125:
				case -304:
				case -911:
					$this->response->code = 2;
					$this->response->msg = ($this->isResponseRc == -125)? lang('RESP_EXPIRED_CARD'): lang('RESP_NOT_PROCCESS');
					break;
				case -35:
				case -61:
					$this->response->code = 2;
					$this->response->msg =  ($this->isResponseRc == -35)? lang('RESP_USER_SUSPENDED'): lang('RESP_SESSION_EXPIRED');
					$this->session->sess_destroy();
					break;
			}
		}
		return $this->response;
	}
}
