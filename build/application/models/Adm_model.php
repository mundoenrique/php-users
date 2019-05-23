<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adm_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//ADMINISTRACION CUENTAS AFILIADAS
	public function adm_load($id_afiliacion, $nroPlasticoOrigen, $nroCuentaDestino, $id_ext_per, $beneficiario, $tipoOperacion, $email, $banco, $expDate) {

	    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","gestion afiliacion","gestion afiliacion","actualizar afiliacion");

		$data = json_encode(array(
			"idOperation"=>"41",
			"className"=>"com.novo.objects.TOs.AfiliacionTarjetasTO",
			"id_afiliacion"=>$id_afiliacion,
			"nroPlasticoOrigen"=>$nroPlasticoOrigen,
			"nroCuentaDestino"=>$nroCuentaDestino,
			"id_ext_per"=>$id_ext_per,
			"beneficiario"=> $beneficiario,
			"tipoOperacion"=> $tipoOperacion,
			"email"=>$email,
			"banco"=>$banco,
			"validacionFechaExp" => $expDate,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			));

		//print_r($data);
		log_message("info", "modificar : ".$data);
		$dataEncry = np_Hoplite_Encryption($data, 1, 'adm_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data, 1, 'adm_load'));

		$salida = json_encode($desdata);
		log_message("info", "Salida MODIFICAR desencriptado".$salida);

		//simulación respuesta del servicio
		 /*$desdata = '{"rc":-344,"msg":"Error cuenta destino ya esta afiliada"}';
		 $desdata = json_decode($desdata);*/

		return json_encode($desdata);

	}		//FIN

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//ELIMINAR CUENTAS AFILIADAS
	public function delete_load($noTarjeta, $noCuentaDestino, $tipoOperacion) {

	    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","gestion afiliacion","gestion afiliacion","eliminar afiliacion");

		$data = json_encode(array(
			"idOperation"=>"40",
			"className"=>"com.novo.objects.TOs.AfiliacionTarjetasTO",
			"noTarjeta"=>$noTarjeta,
			"noCuentaDestino"=>$noCuentaDestino,
			"tipoOperacion"=>$tipoOperacion,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			));

		//print_r($data);

		$dataEncry = np_Hoplite_Encryption($data,1,'delete_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'delete_load'));

		return json_encode($desdata);

	}		//FIN


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//LLAMADA A LISTA DE BANCOS
	public function consultarBancos_load() {

		//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","afiliar","consultar banco");

		$data = json_encode(array(
			"idOperation"=>"17",
			"className"=>"java.lang.String",
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			));
		//print_r($data);

		$dataEncry = np_Hoplite_Encryption($data,1,'consultarBancos_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'consultarBancos_load'));

		return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

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
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'ctasOrigen_load'));
		$salida = json_encode($desdata);
		log_message("info", "Salida ORIGEN desencriptado".$salida);

		return json_encode($desdata);

	}		//FIN LLAMADA A CARGAR CUENTAS ORIGEN

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	//LLAMADA A CARGAR CUENTAS DESTINO
	public function ctasDestino_load($tarjeta, $prefijo, $operacion)
	{
		//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","listados transferencia","consulta cuentas destino");

		$data = json_encode(array(
			"idOperation"=>"7",
			"className"=>"com.novo.objects.TOs.TarjetaTO",
			"tipoOperacion"=>$operacion,
			"prefix"=>$prefijo,
			"noTarjeta" => $tarjeta,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			));
		//print_r($data);
		$dataEncry = np_Hoplite_Encryption($data,1,'ctasDestino_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada Cta Destino : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'ctasDestino_load'));

		$salida = json_encode($desdata);

	  	log_message("info", "Salida ctasDestino_load transferencia".$salida);

		return json_encode($desdata);

	}		//FIN LLAMADA A CARGAR CUENTAS DESTINO

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
} // FIN GENERAL
