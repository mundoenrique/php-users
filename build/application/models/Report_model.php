<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR REPORTE DE GASTOS
	public function gastos_model($tarjeta, $idPersona, $producto, $tipoConsulta,$fechaIni, $fechaFin){
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","tarjeta","tarjeta","consultar movimientos");

		$data = json_encode(array(
			"idOperation"=>"buscarListadoGastosRepresentacion",
			"className"=>"com.novo.objects.MO.GastosRepresentacionMO",
			"idPersona"=> $idPersona,
			"nroTarjeta"=> $tarjeta,
			"fechaIni"=> $fechaIni,
			"fechaFin"=> $fechaFin,
			"producto"=> $producto,
			"tipoConsulta"=> $tipoConsulta,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		$dataEncry = np_Hoplite_Encryption($data,1,'gastos_model');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'gastos_model'));

	  $salida = json_encode($desdata);

		$response = $this->cryptography->encrypt($desdata);
		return json_encode($response);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//EXPORTAR REPORTES A EXCEL
	//EXPORTAR REPORTES A EXCEL ELIMINADO POR REQUERIMIENTO DEL USUARIO
	public function exp_xls($idpersona,$tarjeta,$producto,$tipoConsulta,$id_ext_emp,$fechaIni, $fechaFin){
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","reportes","gastos por categoria","generarArchivoXlsGastosRepresentacion");

	 	$data = json_encode(array(
	 		"idOperation"=>"generarArchivoXlsGastosRepresentacion",
	 		"className"=>"com.novo.objects.MO.GastosRepresentacionMO",
	 		"idPersona"=> $idpersona,
	 		"nroTarjeta"=>$tarjeta,
	 	    "fechaIni"=> $fechaIni,
	 	    "fechaFin"=> $fechaFin,
	 	    "producto"=> $producto,
	 	    "tipoConsulta"=> $tipoConsulta,
		    "idExtEmp"=> $id_ext_emp,
	 		"logAccesoObject"=>$logAcceso,
	 		"token"=>$this->session->userdata("token")
		 ));

	 	$dataEncry = np_Hoplite_Encryption($data,1,'exp_xls');
	 	$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
	 	$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'exp_xls'));

		$salida = json_encode($desdata);

		return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//EXPORTAR REPORTES A PDF
	public function exp_pdf($idpersona,$tarjeta,$producto,$tipoConsulta, $id_ext_emp,$fechaIni, $fechaFin){
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","reportes","gastos por categoria","generarArchivoXlsGastosRepresentacion");

		$data = json_encode(array(
			"idOperation"=>"generarArchivoPDFGastosRepresentacion",
			"className"=>"com.novo.objects.MO.GastosRepresentacionMO",
			"idPersona"=> $idpersona,
			"nroTarjeta"=>$tarjeta,
		    "fechaIni"=> $fechaIni,
		    "fechaFin"=> $fechaFin,
		    "producto"=> $producto,
		    "tipoConsulta"=> $tipoConsulta,
		    "idExtEmp"=> $id_ext_emp,
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));
		log_message("info", "Salida  exp_pdf : ".$data);
		$dataEncry = np_Hoplite_Encryption($data,1,'exp_pdf');
		$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada exp_pdf : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'exp_pdf'));

		$salida = json_encode($desdata);

		log_message("info", "Salida exp_pdf reporte".$salida);

		return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}//FIN
