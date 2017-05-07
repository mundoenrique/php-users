<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Affiliation_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//AFILIAR CUENTA PLATA PLATA
	public function affiliation_load($nroPlasticoOrigen, $beneficiario, $nroCuentaDestino, $tipoOperacion, $email, $cedula,$prefix) {

	    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","afiliar","procesar afiliacion");

		$data = json_encode(array(
			"idOperation"=>"16",
			"className"=>"com.novo.objects.TOs.AfiliacionTarjetasTO",
			"nroPlasticoOrigen"=>$nroPlasticoOrigen,
			"beneficiario"=>$beneficiario,
			"nroCuentaDestino"=>$nroCuentaDestino,
			"tipoOperacion"=>$tipoOperacion,
			"email"=> $email,
			"canal"=> "CPO",
			"id_ext_per"=>$cedula,
			"prefix"=>$prefix,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			),JSON_UNESCAPED_UNICODE);

		//print_r($data);

		log_message("info", "JSON afiliacion P2P : ".$data);
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

		return json_encode($desdata);

	}		//FIN 

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//AFILIAR CUENTA TDC Y BANCOS
	public function affiliationP2T_load($nroPlasticoOrigen, $beneficiario, $nroCuentaDestino, $tipoOperacion, $email, $banco,$cedula,$prefix) {

	    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","afiliar","procesar afiliacion");
		$data = json_encode(array(
			"idOperation"=>"16",
			"className"=>"com.novo.objects.TOs.AfiliacionTarjetasTO",
			"nroPlasticoOrigen"=>$nroPlasticoOrigen,
			"beneficiario"=>$beneficiario,
			"nroCuentaDestino"=>$nroCuentaDestino,
			"tipoOperacion"=>$tipoOperacion,
			"email"=> $email,
			"canal"=> "CPO",
			"banco"=>$banco,
			"id_ext_per"=>$cedula,
			"prefix"=>$prefix,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			),JSON_UNESCAPED_UNICODE);
		
		log_message("info","JSON afiliacion P2T-C  json",$data);

		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info","JSON afiliacion P2T-C   todo",$data);
		log_message("info","JSON afiliacion P2T-C encriptado ",$dataEncry);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
		log_message("info","JSON afiliacion P2T-C response ",$response);
		return json_encode($desdata);

	}		//FIN 
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CUENTAS
	public function affiliationP2T_cuenta($noTarjeta) {

		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","afiliar","consultar tarjeta afiliacion");
		$data = json_encode(array(
			"idOperation"=>"45",
			"className"=>"com.novo.objects.TOs.TarjetaTO",
			"noTarjeta"=>$noTarjeta,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
			),JSON_UNESCAPED_UNICODE);
		
		log_message("info","JSON tarjeta P2T-C 55 json".$data);

		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info","JSON tarjeta P2T-C   todo".$data);
		log_message("info","JSON tarjeta P2T-C encriptado ".$dataEncry);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
		log_message("info","JSON tarjeta P2T-C response ".$response);
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
		
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

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
		
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1));

		return json_encode($desdata);

	}		//FIN LLAMADA A CARGAR CUENTAS ORIGEN

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

} // FIN GENERAL
