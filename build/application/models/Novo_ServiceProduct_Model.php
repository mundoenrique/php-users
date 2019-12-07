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
		log_message('INFO', 'NOVO Service Product Model: Generate PIN method Initialized');

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
		$this->dataRequest->codigoOtp = $dataRequest->codeOTP;
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
					$this->response->classIconName = 'ui-icon-info';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('vistaconsolidada'),
							'action' => 'redirect'
						]
					];
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
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -345:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_FAILED_ATTEMPTS');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -401:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_PIN_NOT_CHANGED');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
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
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -306:
					break;
				case -125:
				case -304:
				case -911:
					$this->response->code = 2;
					$this->response->msg = ($this->isResponseRc == -125)? lang('RESP_EXPIRED_CARD'): lang('RESP_NOT_PROCCESS');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -35:
				case -61:
					$this->response->code = 2;
					$this->response->msg =  ($this->isResponseRc == -35)? lang('RESP_USER_SUSPENDED'): lang('RESP_SESSION_EXPIRED');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					$this->session->sess_destroy();
					break;
				default:
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
			}
		}
		return $this->response;
	}
	public function callWs_change_ServiceProduct($dataRequest)
	{
		log_message('INFO', 'NOVO Service Product Model: Change PIN method Initialized');

		$this->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataAccessLog->modulo = 'Cuentas';
		$this->dataAccessLog->function = 'cambio de PIN';
		$this->dataAccessLog->operation = 'cambio de PIN';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->idOperation = '112';
		$this->dataRequest->accodUsuario = $this->session->userdata('userName');
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

		//$this->dataRequest->tokenOperaciones = $dataRequest->tokenOperaciones;
		$this->dataRequest->pin = $dataRequest->pinCurrent;
		$this->dataRequest->pinNuevo = $dataRequest->newPin;
		$this->dataRequest->codigoOtp = base64_encode($dataRequest->codeOTP);
		$this->dataRequest->noTarjeta = $dataProduct['noTarjeta'];
		$this->dataRequest->fechaExp = $dataProduct['fechaExp'];
		$this->dataRequest->prefix = $dataProduct['prefix'];

		log_message("info", "Request Change ServiceProduct:" . json_encode($this->dataRequest));
		$response = $this->sendToService('ServiceProduct');
		if ($this->isResponseRc !== FALSE) {
			//$this->isResponseRc = -308;
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->msg = lang('RESP_PIN_GENERATED');
					$this->response->classIconName = 'ui-icon-info';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('vistaconsolidada'),
							'action' => 'redirect'
						]
					];
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
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -345:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_FAILED_ATTEMPTS');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -401:
					$this->response->code = 2;
					$this->response->msg = lang('RESP_PIN_NOT_CHANGED');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
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
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -306:
					break;
				case -125:
				case -304:
				case -911:
					$this->response->code = 2;
					$this->response->msg = ($this->isResponseRc == -125)? lang('RESP_EXPIRED_CARD'): lang('RESP_NOT_PROCCESS');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
				case -35:
				case -61:
					$this->response->code = 2;
					$this->response->msg =  ($this->isResponseRc == -35)? lang('RESP_USER_SUSPENDED'): lang('RESP_SESSION_EXPIRED');
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					$this->session->sess_destroy();
					break;
				default:
					$this->response->classIconName = 'ui-icon-alert';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('listaproducto'),
							'action' => 'redirect'
						]
					];
					break;
			}
		}
		return $this->response;
	}
}
