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

		log_message('info', 'Salida dash uno: ' . $data);

		$dataEncry = np_Hoplite_Encryption($data, 1,'dashboard_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));

		log_message('info', 'Salida encriptada Dashboard: ' . $data);
		$response = np_Hoplite_GetWS('movilsInterfaceResource', $data);

		log_message('info', 'Salida dashboard response: ' . $response);

		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data, 1,'dashboard_load'));

		$salida = json_encode($desdata);
		log_message('info', 'Salida dashboard desencriptado: ' . $salida);

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

		 $salida = json_encode($desdata);
		 log_message('info', 'Salida SALDO desencriptado: ' . $salida);
		 //$desdata = json_decode('{"bloqueo":"0,00","disponible":"5.000.000,00","actual":"51.000,00","rc":0,"msg":"Saldo consultado satisfactoriamente"}');

		 $response = $this->cryptography->encrypt($desdata);
		 return json_encode($response);
	}
}
