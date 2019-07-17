<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historial_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR HISTORIAL
	public function historial_load($tarjeta,$tipoOperacion,$mes,$anio) {

	    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencias","historial","consultar");

		$data = json_encode(array(
			"idOperation"=>"21",
			"className"=>"com.novo.objects.MO.MovimientosTarjetaSaldoMO",
			'tarjeta'=>array(
				"noTarjeta" => $tarjeta,
				"tipoOperacion"=>$tipoOperacion
			),
			"mes"=>$mes,
			"anio"=>$anio,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		//print_r($data);
		log_message("info", "Salida HISTORIAL : ".$data);
		$dataEncry = np_Hoplite_Encryption($data,1,'historial_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada historial_load : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'historial_load'));

		$salida = json_encode($desdata);

	  log_message("info", "Salida historial_load".$salida);

		$response = $this->cryptography->encrypt($desdata);
		return json_encode($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//LLAMADA A CARGAR CUENTAS ORIGEN
	public function ctasOrigen_load($operacion)
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","listados transferencia","consulta cuentas origen");

		$data = json_encode(array(
			"idOperation"=>"6",
			"className"=>"com.novo.objects.TOs.TarjetaTO",
			"tipoOperacion"=>$operacion,
			"id_ext_per"=>$this->session->userdata("idUsuario"),
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			));

		$dataEncry = np_Hoplite_Encryption($data,1,'ctasOrigen_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada historial ctasOrigen_load : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'ctasOrigen_load'));

		$salida = json_encode($desdata);

	  	log_message("info", "Salida ctasOrigen_load historial".$salida);

		return json_encode($desdata);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

} // FIN GENERAL
