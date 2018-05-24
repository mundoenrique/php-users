<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class TransferPe_model extends CI_Model {

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

			$dataEncry = np_Hoplite_Encryption($data,1);
				$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada validarClaveAutenticacion_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(np_Hoplite_Decrypt($data->data,1));

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
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

			$salida = json_encode($desdata);

			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			//$desdata = json_decode('{"rc":0,"dataTransaccion":{"referencia":"154548"}}');


			return json_encode($desdata);
		}

		// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


		//Busqueda de cuentas por telefono
		public function accountPhone($telefonoDestino){

			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencia","transferencia","procesar transferencia");
			$data = json_encode(array(
				                    "idOperation"=>"302",
				                    "className"=>"com.novo.objects.TOs.TarjetaTO",
				                    "telefonoDestino"=> $telefonoDestino,
				                    "logAccesoObject"=>$logAcceso,
				                    "token"=>$this->session->userdata("token")
			                    ));

			//print_r($data);
			log_message("info", "Request accounts by phone" . $data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
			$salida = json_encode($desdata);
			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			$desdata = json_decode('{"lista":[{"noTarjeta":"6048427001614714","noTarjetaConMascara":"604842******4714"},{"noTarjeta":"6048426500029317","noTarjetaConMascara":"604842******9317"}],"rc":0,"msg":"Proceso OK","logAccesoObject":{"sessionId":"9fadc0ada62ef0a84a3a54d7c9b1143e","userName":"ANNY123","canal":"personasWeb","modulo":"lista tarjetas","operacion":"consulta Lista Tarjeta por Telefono","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 19:46","lenguaje":"ES"}}');

			if($desdata){
				switch ($desdata->rc) {
					case 0:
						$response = [
							'code' => 0,
							'phone' => $desdata->lista,
							'title' => '',
							'msg' => ''
						];
						break;

					default:
						$response = [
							'code' => 1,
							'msg' => 'No hay cuentas asociadas al teléfono',
							'title' => 'Búsqueda de cuentas por teléfono',
						];
						break;
				}
			}

			//return json_encode($response);
			return json_encode($response);
		}



		//LIMITES BASE PARA OPERACIONES SIN CONFIRMARCIÓN
		public function baseAmount(){
			//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista montos bases","lista montos bases","consulta lista montos bases");
			$data = json_encode(array(
														"idOperation"=>"300",
														"className"=>"com.novo.objects.TOs.MontoBaseTO",
														"codPais"=> $this->session->userdata("pais"),
														"logAccesoObject"=>$logAcceso,
														"token"=>$this->session->userdata("token")
													));

			//print_r($data);
			log_message("info", "Request base amount operation" . $data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
			$salida = json_encode($desdata);
			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			$desdata = json_decode('{"lista":[{"codigo":"A","monto":100.00,"default":0},{"codigo":"B","monto":200.00,"default":1},{"codigo":"C","monto":300.00,"default":0}],"rc":0,"msg":"Proceso OK","idOperation":"300","className":"com.novo.objects.TOs.MontoBaseTO","token":"e7159e5a787ef254056e7c877870d89e","logAccesoObject":{"sessionId":"af7990ca8b4673ec123af41728610dc9","userName":"ANNY123","canal":"personasWeb","modulo":"lista montos bases","operacion":"consultar","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 20:33","lenguaje":"ES"}}');

			if($desdata){
				switch ($desdata->rc) {
					case 0:
						$response = [
							'code' => 0,
							'amounts' => $desdata->lista,
							'title' => '',
							'msg' => ''
						];
						break;

					default:
						$response = [
							'code' => 1,
							'msg' => 'No hay montos base asociados',
							'title' => 'Montos base',
						];
						break;
				}
			}

			//return json_encode($response);
			return json_encode($response);

		}


		public function setAmount($dataRequest){

			log_message("error", "Set amount verify" . $dataRequest);


			parse_str($dataRequest, $dataAccount);

			$monto = $dataAccount['monto'];
			$codigo = $dataAccount['codigo'];
			$clave = $dataAccount['clave'];

			//$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","actualiza monto base","actualiza monto base","actualiza monto base");
			$data = json_encode(array(
														"idOperation"=>"301",
														"className"=>"com.novo.objects.TOs.MontoBaseTO",
														"monto"=> $monto,
														"codigo"=> $codigo,
														"codPais"=> $this->session->userdata("pais"),
														"logAccesoObject"=>$logAcceso,
														"token"=>$this->session->userdata("token")
													));

			//print_r($data);
			log_message("info", "Request set amount" . $data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));

			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			log_message("info", "Response encriptado procesarTransferencia_load------>>>>>>".$response);
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
			$salida = json_encode($desdata);
			log_message("info", "Response procesarTransferencia_load------>>>>>>".$salida);

			$desdata = json_decode('{"rc":0,"msg":"Proceso OK","idOperation":"0","className":"com.novo.objects.TOs.MontoBaseTO","token":"e7159e5a787ef254056e7c877870d89e","logAccesoObject":{"sessionId":"af7990ca8b4673ec123af41728610dc9","userName":"ANNY123","canal":"personasWeb","modulo":" actualiza monto base ","operacion":" actualiza monto base ","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 20:33","lenguaje":"ES"}}');

			if($desdata){
				switch ($desdata->rc) {
					case 0:
						$response = [
							'code' => 0,
							'title' => 'Actualizar Montos Base',
							'msg' => 'El monto base se ha actualizado exitosamente'
						];
						break;
					default:
						$response = [
							'code' => 1,
							'title' => 'Actualizar Montos Base',
							'msg' => 'Ha ocurrido un error en el sistema. Por favor intente más tarde.',
						];
						break;
				}
			}
			//return json_encode($response);
			return json_encode($response);
		}


		//HISTORIAL DE PARAMETROS MONTOS BASE
		//CARGAR HISTORIAL
		public function historial_loadPe($dataRequest) {

			parse_str($dataRequest, $dataAccount);
		    									                  //$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencias","historial","consultar");

			$tarjeta = $dataAccount['noTarjeta'];
			$tipoOperacion = "P2P";
			$anio = $dataAccount['anio'];
			$mes = $dataAccount['mes'];

			$data = json_encode(array(
				"idOperation"=>"305",
				"className"=>"com.novo.objects.MO.MovimientosTarjetaSaldoMO",
				'tarjeta'=>array(
					"noTarjeta" => $tarjeta,
					"tipoOperacion"=>$tipoOperacion
				),
				"mes"=>$mes,
				"anio"=>$anio,
				"pais"=> $this->session->userdata("pais"),
				"logAccesoObject"=>$logAcceso,
				"token"=>$this->session->userdata("token")
				));

			//print_r($data);
			log_message("info", "Salida HISTORIAL : ".$data);
			$dataEncry = np_Hoplite_Encryption($data,1);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
			log_message("info", "Salida encriptada historial_load : ".$data);
			$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

			$salida = json_encode($desdata);
			log_message("info", "Salida historial_load".$salida);

			$desdata = json_decode('{"listaTransferenciasRealizadas":[{"referencia":"879008","fechaTransferencia":"05/01/2018 11:05:58","beneficiario":"ANNY CALDERA","montoTransferencia":"100.00","concepto":"Este es un concepto de transferencia","Autorizacion":true,"estatusOperacion":"1"},{"referencia":"879009","fechaTransferencia":"05/05/2018 11:05:58","beneficiario":"DANIEL GONZALES","montoTransferencia":"500.00","concepto":"Envio para pago de servicio","Autorizacion":false,"estatusOperacion":"9"},{"referencia":"879009","fechaTransferencia":"05/05/2018 11:05:58","beneficiario":"MARIANA CARDONA","montoTransferencia":"200.00","concepto":"Tranferencia para transporte","Autorizacion":false,"estatusOperacion":"1"}],"rc":0,"msg":"Proceso OK","logAccesoObject":{"sessionId":"af7990ca8b4673ec123af41728610dc9","userName":"ANNY123","canal":"personasWeb","modulo":"transferencias","operacion":"consultar","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 20:33","lenguaje":"ES"}}');

				if($desdata){
				switch ($desdata->rc) {
					case 0:
							$response = [
								'code' => 0,
								'listaTransferenciasRealizadas'=>$desdata->listaTransferenciasRealizadas,
								'title' => '',
								'msg' => ''
							];
						break;

					case -61:
						$response = [
							'code' => 1,
						];
					break;
					default:
						$response = [
							'code' => 2,
						];
						break;
				}
			}
			return json_encode($response);
		}




		//HISTORIAL DE PARAMETROS MONTOS BASE
		public function makeTransferPe($dataRequest) {

			parse_str($dataRequest, $dataAccount);
			//$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","transferencias","historial","consultar");

			$ctaOrigen = $dataAccount['ctaOrigen'];
			$ctaDestino = $dataAccount['ctaDestino'];
			$monto = $dataAccount['monto'];
			$descripcion = $dataAccount['descripcion'];
			$pin = isset($dataAccount['pin']) ? $dataAccount['pin'] : '';

			$data = json_encode(array(
				"idOperation"=>"303",
				"className"=>"com.novo.objects.MO.TransferenciaTarjetahabienteMO",
				"idUsuario"=>$this->session->userdata("userName"),
				"ctaOrigen"=>$ctaOrigen,
				"ctaDestino"=>$ctaDestino,
				"monto"=>$monto,
				"descripcion"=>$descripcion,
				"tipoOpe"=>"P2P",
				"idUsuario"=>$this->session->userdata("userName"),
				"logAccesoObject"=>$logAcceso,
				"token"=>$this->session->userdata("token"),
				'tokenTransferenciaP2P' => $pin
				));

				log_message("info", "Salida HISTORIAL : ".$data);
				$dataEncry = np_Hoplite_Encryption($data,1);
				$data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
				log_message("info", "Salida encriptada historial_load : ".$data);
				$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
				$data = json_decode(utf8_encode($response));
				$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

				$salida = json_encode($desdata);
				log_message("info", "Salida historial_load".$salida);

				/* sin token
				$desdata = json_decode('{"ctaOrigen":"6048427001614714","ctaDestino":"5267491200018313","monto":"1000","telefonoDestino":"5555","descripcion":"Prueba","tipoOpe":"P2P","idUsuario":"ANNY123","dataTransaccion":{"referencia":"891899","transferenciaRealizada":true},"rc":0,"msg":"Proceso OK","className":"com.novo.objects.MO.TransferenciaTarjetahabienteMO","token":"f76d8828c726d8cb148489f33bebb93e","idOperation":"303","logAccesoObject":{"sessionId":"9fadc0ada62ef0a84a3a54d7c9b1143e","userName":"ANNY123","canal":"personasWeb","modulo":"transferencia","operacion":"procesar transferencia","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 18:57","lenguaje":"ES"}}');
				*/

				$desdata = json_decode('{"ctaOrigen":"6048427001614714","ctaDestino":"5267491200018313","monto":"1000","telefonoDestino":"5555","descripcion":"Prueba","tipoOpe":"P2P","idUsuario":"ANNY123","rc":-394,"msg":"Necesita un Token de Acceso","className":"com.novo.objects.MO.TransferenciaTarjetahabienteMO","token":"f76d8828c726d8cb148489f33bebb93e","idOperation":"303","logAccesoObject":{"sessionId":"9fadc0ada62ef0a84a3a54d7c9b1143e","userName":"ANNY123","canal":"personasWeb","modulo":"transferencia","operacion":"procesar transferencia","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 18:57","lenguaje":"ES"}}');


				 //respusta de cambio de pin
				$desdata = json_decode('{"ctaOrigen":"6048427001614714","ctaDestino":"5267491200018313","monto":"1000","telefonoDestino":"5555","descripcion":"Prueba","tipoOpe":"P2P","idUsuario":"ANNY123","tokenTransferenciaP2P":"81dc9bdb52d04dc20036dbd8313ed055","dataTransaccion":{"referencia":"891899","transferenciaRealizada":true},"rc":0,"msg":"Proceso OK","className":"com.novo.objects.MO.TransferenciaTarjetahabienteMO","token":"f76d8828c726d8cb148489f33bebb93e","idOperation":"303","logAccesoObject":{"sessionId":"9fadc0ada62ef0a84a3a54d7c9b1143e","userName":"ANNY123","canal":"personasWeb","modulo":"transferencia","operacion":"procesar transferencia","RC":0,"IP":"172.17.0.4","dttimesstamp":"05/15/2018 18:57","lenguaje":"ES"}}');


				if($desdata){
				switch ($desdata->rc) {
					case 0:

						$transation = $desdata->dataTransaccion;
						$date = $desdata->logAccesoObject;

							$response = [
								'code' => 0,
								'ctaOrigen' => $desdata->ctaOrigen,
								'ctaDestino'=>$desdata->ctaDestino,
								'ctaOrigenMascara' => $desdata->ctaOrigen,
								'ctaDestinoMascara'=>$desdata->ctaDestino,
								'monto'=>$desdata->monto,
								'descripcion'=>$desdata->descripcion,
								'referencia'=>$transation->referencia,
								'transferenciaRealizada'=>$transation->transferenciaRealizada,
								'fecha'=>$date->dttimesstamp,
								];
						break;

					case -394:
							$response = [
								'code' => 1,
							];
						break;

					default:
						$response = [
							'code' => 1,
							'title' => "mal",
							"msn" => "mal mal",
						];
						break;
				}
			}
			return json_encode($response);

		}


	} // FIN
