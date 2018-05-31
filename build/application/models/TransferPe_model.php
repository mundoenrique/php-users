<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class TransferPe_model extends CI_Model {

		protected $code;
		protected $title;
		protected $msg;
		protected $modalType;
		protected $listaTransferenciasRealizadas;
		protected $amounts;

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
				                    "idOperation"=>"306",
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


			if($desdata){
				switch ($desdata->rc) {

					case 0:
						$this->code = 0;
						$this->amounts = $desdata->listaMontos;
						break;

					default:
						$this->code = 1;
						$this->msg = 'No hay montos base asociados';
						$this->title = 'Conexión Personas Online';
						$this->modalType = 'alert-error';

						break;
				}
			}

			$response = [
				'code' => $this->code,
				'amounts' => $this->amounts,
				'title' => $this->title,
				'msg' => $this->msg,
				'modalType' => $this->modalType
			];

			//return json_encode($response);
			return json_encode($response);

		}


		public function setAmount($dataRequest){

			parse_str($dataRequest, $dataAccount);

			$montoUser = intval($dataAccount['monto']);
			$codigo = $dataAccount['codigo'];
			$claveUser = $dataAccount['clave'];


			log_message("info", "Request set amount" . $montoUser);
			//$sessionId - $username - $canal - $modulo - $function - $operacion
			$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","actualiza monto base","actualiza monto base","actualiza monto base");
			$data = json_encode(array(
														"idOperation"=>"301",
														"className"=>"com.novo.objects.TOs.MontoBaseTO",
														"codigo"=> $codigo,
														"clave"=> $claveUser,
														"codPais"=> $this->session->userdata("pais"),
														"logAccesoObject"=>$logAcceso,
														"token"=>$this->session->userdata("token"),
														"monto"=> $montoUser,
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

			if($desdata){
				switch ($desdata->rc) {
					case 0:
						$this->code = 0;
						$this->title = 'Actualizar Montos Base';
						$this->msg = 'El monto base se ha actualizado exitosamente';
						$this->modalType = 'alert-success';
						break;

					case -391:
						$this->code = 5;
						$this->title = 'Actualizar Montos Base';
						$this->msg = "Ha ingresado una clave incorrecta";
						$this->modalType = 'alert-error';
						break;

					case -33:
						case 2:
							$this->code = 2;
						break;

					default:
						$this->code = 1;
						$this->title = 'Actualizar Montos Base';
						$this->msg = 'Ha ocurrido un error en el sistema. Por favor intente más tarde.';
						$this->modalType = 'alert-error';
						break;
				}
			}

			$response = [
				'code' => $this->code,
				'title' => $this->title,
				'msg' => $this->msg,
				'modalType' => $this->modalType
			];
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

			if($desdata){
				switch ($desdata->rc) {
					case 0:
						$this->code = 0;
						$this->listaTransferenciasRealizadas = $desdata->listaTransferenciasRealizadas;
						break;

					case -61:
					case -33:
						$this->code = 1;
					break;

					case -150:
							$this->code = 2;
						break;

					default:
						$this->code = 3;
						$this->title = 'Conexión Personas Online';
						$this->msg = 'Ha ocurrido un error en el sistema. Por favor intente más tarde.';
						$this->modalType = 'alert-error';
						break;
				}
			}

				$response = [
					'code' => $this->code,
					'title' => $this->title,
					'msg' => $this->msg,
					'modalType' => $this->modalType,
					'listaTransferenciasRealizadas' => $this->listaTransferenciasRealizadas,
				];

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
								'nombreCuentaOrigen' => '',
								'nombreCuentaDestino' => ''
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
							'title' => "Conexión Personas Online",
							"msn" => "Ha ocurrido un error en el sistema. Por favor intente más tarde.",
						];
						break;
				}
			}
			return json_encode($response);

		}

	} // FIN
