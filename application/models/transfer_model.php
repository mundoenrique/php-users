<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Transfer_model extends CI_Model {

		public function __construct()
		{
			parent::__construct();

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

			log_message("info", "SALIDA ORIGEN : ".$data);

			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			log_message("info", "SALIDA ENCRIPTADA ORIGEN : ".$data);

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

			$salida = json_encode($desdata);

			log_message("info", "Salida ctasOrigen_load transferencia".$salida);

			return json_encode($desdata);

		}		//FIN LLAMADA A CARGAR CUENTAS ORIGEN

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

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
			log_message("info", "SALIDA DESTINO : ".$data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada Cta Destino : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

			$salida = json_encode($desdata);

			log_message("info", "Response ctasDestino_load transferencia====>>>>>".$salida);

			return json_encode($desdata);

		}		//FIN LLAMADA A CARGAR CUENTAS DESTINO

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		//LLAMADA A VALIDAR CLAVE DE OPERACIONES
		public function validarClave_load($clave)
		{
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","realizar transferencia","validar clave op");

			$data = json_encode(array(
				                    "idOperation"=>"10",
				                    "className"=>"com.novo.objects.TOs.UsuarioTO",
				                    "userName"=> $this->session->userdata("userName"),
				                    "passwordOperaciones"=> $clave,
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));

			//print_r($data);
			log_message("info", "Salida Validar Clave : ".$data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada Validar Clave : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1));

			$salida = json_encode($desdata);

			log_message("info", "Salida validarClave_load transferencia".$salida);

			return json_encode($desdata);

		}		//FIN LLAMADA A VALIDAR CLAVE DE OPERACIONES

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		//LLAMADA A GENERAR CLAVE DE AUTENTICACION
		public function claveAutenticacion_load()
		{
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","realizar transferencia","crear clave auten");

			$data = json_encode(array(
				                    "idOperation"=>"11",
				                    "className"=>".novo.objects.TOs.UsuarioTO",
				                    "userName"=> $this->session->userdata("userName"),
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));


			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada claveAutenticacion_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1));

			$salida = json_encode($desdata);

			log_message("info", "Salida claveAutenticacion_load transferencia".$salida);

			return json_encode($desdata);

		}			//FIN LLAMADA A GENERAR CLAVE DE AUTENTICACION

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		//LLAMADA A VALIDAR CLAVE DE AUTENTICACION
		public function validarClaveAutenticacion_load($clave)
		{
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","realizar transferencia","validar clave auten");

			$data = json_encode(array(
				                    "idOperation"=>"12",
				                    "className"=>"com.novo.objects.TOs.UsuarioTO",
				                    "userName"=> $this->session->userdata("userName"),
				                    "claveConfirmacion"=> $clave,
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));

			//print_r($data);

			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada validarClaveAutenticacion_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1));

			$salida = json_encode($desdata);

			log_message("info", "Salida validarClaveAutenticacion_load transferencia".$salida);

			return json_encode($desdata);

		}			//FIN LLAMADA A VALIDAR CLAVE DE AUTENTICACION

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		//REALIZAR TRANSFERENCIA
		public function procesarTransferencia_load($cuentaOrigen, $cuentaDestino, $monto, $descripcion, $tipoOpe, $id_afil_terceros){
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","transferencia","procesar transferencia");
			$data = json_encode(array(
				                    "idOperation"=>"9",
				                    "className"=>"com.novo.objects.MO.TransferenciaTarjetahabienteMO",
				                    "ctaOrigen"=> $cuentaOrigen,
				                    "ctaDestino"=> $cuentaDestino,
				                    "monto"=> $monto,
				                    "descripcion" => $descripcion,
				                    "tipoOpe" => $tipoOpe,
				                    "idUsuario"=> $this->session->userdata("userName"),
				                    "id_afil_terceros" => $id_afil_terceros,
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));

			//print_r($data);
			log_message("info", "Request procesarTransferencia_load------>>>>>>".$data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

			$salida = json_encode($desdata);

			/*$salida = '{"rc": -343, "msg": "La tarjeta se encuentra bloqueada (43).", "logAcceso": {"sessionId": "46485b5e1b4fc11fff7d768a8f543253", "userName": "TESTVZLA", "canal": "personasWeb", "modulo": "transferencia", "operacion": "procesar transferencia", "RC": 0, "IP": "172.24.15.182", "dttimesstamp": "06/14/2017 14:30", "lenguaje": "ES"}}';
			$salida = '{"ctaOrigen":"5267491400303119","ctaDestino":"5267491200018313","monto":"7","descripcion":"prueba","tipoOpe":"P2C","idUsuario":"ANNY","id_afil_terceros":"74466","dataTransaccion":{"referencia":"101028","comision":"3","transferenciaRealizada":true},"rc":0,"msg":"Proceso OK","className":"com.novo.objects.MO.TransferenciaTarjetahabienteMO","token":"a6fbee02e833eb6f65336c3eec38a0b3","idOperation":"9","logAccesoObject":{"sessionId":"a969d785ba7c28c5bb230cb765e43814","userName":"ANNY","canal":"personasWeb","modulo":"transferencia","operacion":"procesar transferencia","RC":0,"IP":"172.24.15.162","dttimesstamp":"06\/20\/2017 11:18","lenguaje":"ES"}}';
			$desdata = json_decode($salida);*/

			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			return json_encode($desdata);
		}

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	} // FIN