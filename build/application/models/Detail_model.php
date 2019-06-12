<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		$dataEncry = np_Hoplite_Encryption($data,1,'detail_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada DETALLE : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode($response);
	  	$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'detail_load'));

			$response = $this->cryptography->encrypt($desdata);
			return json_encode($response);

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
		$dataEncry = np_Hoplite_Encryption($data,1,'exportar');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada exportar : ".$data);

		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'exportar'));

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
		$dataEncry = np_Hoplite_Encryption($data,1,'movimientos_load');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada movimientos_load : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode($response);
	  	$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'movimientos_load'));

			$response = $this->cryptography->encrypt($desdata);
			return json_encode($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function WSinTransit($data){
		$country = $this->session->userdata("pais");

		$urlAPI = ':8016/api-cardholder-account/1.0/balance';
		$headerAPI = [
			'x-country: ' . $country
		];
		$body = [
			'idPrograma' => $data->idPrograma,
			'noTarjetaConMascara' => $data->tarjeta
		];
		$bodyAPI = json_encode($body);
		$method = 'POST';

		$objectAPI = (object) [
			'urlAPI' => $urlAPI,
			'headerAPI' => $headerAPI,
			'bodyAPI' => $bodyAPI,
			'method' => $method
		];
		log_message("INFO", '['.$this->session->userdata("userName").']'." REQUEST WSinTransit objectAPI: ".json_encode($objectAPI));
		$response = connectionAPI($objectAPI);

		$httpCode = $response->httpCode;
		$resAPI = $response->resAPI;

		log_message('INFO', '['.$this->session->userdata("userName").']'.' RESPONSE WSinTransit====>> httpCode: ' . $httpCode . ', resAPI: ' . $resAPI);

		$dataResponse = json_decode($resAPI);
		$title = 'Mensaje';
		switch ($httpCode) {
			case 200:
				$code = 0;
				// Formato de moneda de acuerdo al país
				$ledgerBalance = $dataResponse->balance->ledgerBalance;
				$availableBalance = $dataResponse->balance->availableBalance;
				$actualBalance = $ledgerBalance + $availableBalance;
				$ledgerBalance = np_hoplite_decimals($ledgerBalance, $country);
				$availableBalance = np_hoplite_decimals($availableBalance, $country);
				$actualBalance = np_hoplite_decimals($actualBalance, $country);
				$dataResponse->balance->ledgerBalance = $ledgerBalance;
				$dataResponse->balance->availableBalance = $availableBalance;
				$dataResponse->balance->actualBalance = $actualBalance;

				$msg = json_encode($dataResponse);
				break;
			default:
				$code = 3;
				$msg = json_encode('Error ' . $httpCode);
		}
		$response = [
			'code' => $code,
			'title' => $title,
			'msg' => json_decode($msg)
		];

		$response = $this->cryptography->encrypt($response);
		return json_encode($response);
	}
}
