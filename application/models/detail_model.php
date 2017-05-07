<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Detail_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR DETALLE DE CUENTA
	public function detail_load($tarjeta)
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","tarjeta","tarjeta","consulta");

		$data = json_encode(array(
			"idOperation"=>"3",
			"className"=>"com.novo.objects.TOs.TarjetaTO",
			"noTarjeta" => $tarjeta,
			"id_ext_per"=>$this->session->userdata("idUsuario"),
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		//print_r($data);
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada DETALLE : ".$data);	
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode(utf8_encode($response));
	  	$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

	  	return json_encode($desdata);

	}
	
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------.

	//EXPORTAR MOVIMIENTOS
	public function exportar($tarjeta,$mes,$anio,$idOperation){

	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","tarjeta","tarjeta","exportar movimientos");

		$data = json_encode(array( /* PDF => 5; EXCEL => 46*/
			//"idOperation"=>"5",
			"idOperation"=>$idOperation,
			"className"=>".novo.objects.MO.MovimientosTarjetaSaldoMO",
			'tarjeta'=>array(
				"noTarjeta" => $tarjeta,
				"id_ext_per"=>$this->session->userdata("idUsuario")
			),			
			"mes"=>$mes,
			"anio"=>$anio,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		//print_r($data);
		log_message("info", "Salida exportar detalle".$data);
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada exportar : ".$data);	

		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode(utf8_encode($response));
	  	$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

	  	$salida = json_encode($desdata);

	  	log_message("info", "Salida exportar detalle desencriptado".$salida);

	  	return json_encode($desdata);

	}	

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR MOVIMIENTOS DE TARJETA
	public function movimientos_load($tarjeta,$mes,$anio)
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","tarjeta","tarjeta","consultar movimientos");

		$data = json_encode(array(
			"idOperation"=>"13",
			"className"=>"com.novo.objects.MO.MovimientosTarjetaSaldoMO",
			"mes"=>$mes,
			"anio"=>$anio,
			'tarjeta'=>array(
				"noTarjeta" => $tarjeta,
				"id_ext_per"=>$this->session->userdata("idUsuario")
			),
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));
		log_message("info", "Salida movimientos detalle".$data);
		//print_r($data);
		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada movimientos_load : ".$data);	
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode(utf8_encode($response));
	  	$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

	  	return json_encode($desdata);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}