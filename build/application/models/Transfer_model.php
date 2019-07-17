<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

			$dataEncry = np_Hoplite_Encryption($data,1,'ctasOrigen_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			log_message("info", "SALIDA ENCRIPTADA ORIGEN : ".$data);

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'ctasOrigen_load'));

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

			$data = json_encode([
				"idOperation"=>"7",
				"className"=>"com.novo.objects.TOs.TarjetaTO",
				"tipoOperacion"=>$operacion,
				"prefix"=>$prefijo,
				"noTarjeta" => $tarjeta,
				"logAccesoObject"=>$logAcceso,
				"token"=>$this->session->userdata("token")
			]);
			//print_r($data);
			log_message("info", "Request ctasDestino_load transferencia====>>>>>: ".$data);
			$dataEncry = np_Hoplite_Encryption($data,1,'ctasDestino_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada Cta Destino : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'ctasDestino_load'));
			if(isset($desdata->cuentaDestinoPlata)) {
				foreach($desdata->cuentaDestinoPlata as $pos => $cta) {
					$NombreCliente=ucwords(mb_strtolower($cta->NombreCliente, 'UTF-8'));
					$nom_plastico=ucwords(mb_strtolower($cta->nom_plastico, 'UTF-8'));
					$nomProducto=ucwords(mb_strtolower($cta->nombre_producto, 'UTF-8'));
					$cta->NombreCliente = $NombreCliente;
					$cta->nom_plastico = $nom_plastico;
					$cta->nombre_producto = $nomProducto;
				}
			}


			$salida = json_encode($desdata);

			log_message("info", "Response ctasDestino_load transferencia====>>>>>: " . $salida);

			$response = $this->cryptography->encrypt($desdata);
			return json_encode($response);

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
			$dataEncry = np_Hoplite_Encryption($data,1,'validarClave_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada Validar Clave : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'validarClave_load'));

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


			$dataEncry = np_Hoplite_Encryption($data,1,'claveAutenticacion_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada claveAutenticacion_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'claveAutenticacion_load'));

			$salida = json_encode($desdata);

			log_message("info", "Salida claveAutenticacion_load transferencia".$salida);

			//$desdata = json_decode('{"rc":0,"msg":"Error al crear la clave de"}');

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

			$dataEncry = np_Hoplite_Encryption($data,1,'validarClaveAutenticacion_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada validarClaveAutenticacion_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'validarClaveAutenticacion_load'));

			$salida = json_encode($desdata);

			log_message("info", "Salida validarClaveAutenticacion_load transferencia".$salida);

			//$desdata = json_decode('{"rc":0,"msg":"Error al crear la clave de"}');

			return json_encode($desdata);

		}			//FIN LLAMADA A VALIDAR CLAVE DE AUTENTICACION

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		//REALIZAR TRANSFERENCIA
		public function procesarTransferencia_load($cuentaOrigen, $cuentaDestino, $monto, $descripcion, $tipoOpe, $id_afil_terceros, $expDate){
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$monto = str_replace(',','.', $monto);
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
				                    "validacionFechaExp" => $expDate,
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));

			//print_r($data);
			log_message("info", "Request procesarTransferencia_load------>>>>>>" . $data);
			$dataEncry = np_Hoplite_Encryption($data,1,'procesarTransferencia_load');
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode($response);
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'procesarTransferencia_load'));

			$salida = json_encode($desdata);

			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			//$desdata = json_decode('{"rc":0,"dataTransaccion":{"referencia":"154548"}}');

			$response = $this->cryptography->encrypt($desdata);
			return json_encode($response);
		}

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	} // FIN
