<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function dashboard_load()
	{
		$logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'dashboard', 'dashboard', 'consulta');

		$data = json_encode(array(
			'idOperation' => '2',
			'className' => 'com.novo.objects.TOs.UsuarioTO',
			'userName' => $this->session->userdata('userName'),
			'idUsuario' => $this->session->userdata('idUsuario'),
			'logAccesoObject' => $logAcceso,
			'token' => $this->session->userdata('token')
		));

		$dataEncry = np_Hoplite_Encryption($data, 1,'dashboard_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
		$response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data, 1,'dashboard_load'));
		$username = $this->session->userdata('userName');
		log_message('DEBUG', '['.$username.'] RESPONSE dashboard_load: '.json_encode($desdata->lista));

		return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function saldo_load($tarjeta)
	{
		$logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'tarjeta', 'tarjeta', 'obtener saldo');

		$data = json_encode(array(
			'idOperation' => '8',
			'className' => 'com.novo.objects.TOs.TarjetaTO',
			'noTarjeta' => $tarjeta,
			'id_ext_per' => $this->session->userdata('idUsuario'),
			'logAccesoObject' => $logAcceso,
			'token' => $this->session->userdata('token')
		));

		log_message('info', $data);

		 $dataEncry = np_Hoplite_Encryption($data, 1, 'saldo_load');
		 $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
		 $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
		 $data = json_decode($response);
		 $desdata = json_decode(np_Hoplite_Decrypt($data->data, 1, 'saldo_load'));
		 log_message('info', 'Salida SALDO desencriptado: ' . json_encode($desdata));
		 //$desdata = json_decode('{"bloqueo":"0,00","disponible":"5.000.000,00","actual":"51.000,00","rc":0,"msg":"Saldo consultado satisfactoriamente"}');

		 return $desdata;
	}
}
