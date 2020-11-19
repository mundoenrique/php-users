<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_model extends CI_Model {

	protected $code;
	protected $title;
	protected $msn;
	protected $modalType;
	protected $dataUser;


	public function __construct()
	{
		parent::__construct();
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR LISTADO DE PAISES
	public function lista_paises()
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso	= np_hoplite_log("","","personasWeb","validar cuenta","lista pais","consultar");

		$data		= json_encode(array(
			"idOperation"		=>"22",
			"className"			=>"com.novo.objects.MO.ListaPaisMO",
			"logAccesoObject"	=>$logAcceso,
			"token"				=>""
		));

		log_message("info", "Request lista_paises: ".$data);
		$dataEncry	= np_Hoplite_Encryption($data,0,'lista_paises');
		$data		= json_encode(array('data' => $dataEncry, 'pais' => "Global", 'keyId'=> 'CPONLINE'));

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  $data		= json_decode($response);
	  $desdata	= json_decode(np_Hoplite_Decrypt($data->data,0,'lista_paises'));

		log_message("info", "Response lista_paises: ".json_encode($desdata));

		$response = $this->cryptography->encrypt($desdata);
		return json_encode($response);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR LISTADO DE DEPARTAMENTOS
	public function lista_departamentos($pais, $subRegion=1)
	{
		$sessionId 	= "REGISTROCPO";
		$username 	= "REGISTROCPO";
		$canal 		= "ceoApi";
		$modulo		= "";
		$function 	= "Data General";
		$operacion	= "Obtener Regiones";
		$logAcceso	= np_hoplite_log($sessionId,$username,$canal,$modulo,$function,$operacion);

		$data		= json_encode(array(
			"idOperation"		=> "buscarRegiones",
			"userName"			=> "REGISTROCPO",
			"codigoGrupo"		=> "$subRegion",
			"className"			=> "com.novo.objects.TOs.UsuarioTO",
			"logAccesoObject"	=> $logAcceso,
			"pais"				=> $pais
		));

		log_message("info", "Request lista_departamentos: ".$data);

		$dataEncry	= np_Hoplite_Encryption($data,0,'lista_departamentos');
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId' => 'CPONLINE'));
		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data		= json_decode($response);
		$desdata	= json_decode(np_Hoplite_Decrypt($data->data,0,'lista_departamentos'));

		log_message("info", "Response lista_departamentos: ".json_encode($desdata));

		$response = $this->cryptography->encrypt($desdata);
		return json_encode($response);
	}


	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR LISTA DE PROFESIONES
	public function lista_profesiones($pais){
		//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$sessionId 	= "REGISTROCPO";
		$username 	= "REGISTROCPO";
		$canal 		= "personasWeb";
		$modulo		= "lista profesion";
		$function 	= "lista profesion";
		$operacion	= "consultar";
		$logAcceso	= np_hoplite_log($sessionId,$username,$canal,$modulo,$function,$operacion);

		$data = json_encode(array(
			"idOperation"=>"37",
			"className"=>"com.novo.objects.MO.ListaTipoProfesionesMO",
			"logAccesoObject"=>$logAcceso,
		));

		log_message("info", "Request lista_profesiones: ".$data);
		$dataEncry = np_Hoplite_Encryption($data,0,'lista_profesiones');
		$data = json_encode(array('data' => $dataEncry, 'pais' => "Global", 'keyId'=> "CPONLINE"));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode($response);
		$desdata = json_decode(np_Hoplite_Decrypt($data->data,0,'lista_profesiones'));

		log_message("info", "Response lista_profesiones: ".json_encode($desdata));

		$response = $this->cryptography->encrypt($desdata);
		return json_encode($response);

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//VALIDAR EXISTENCIA DE LA TARJETA O CUENTA EN LA BD
	public function validar_cuenta($userName, $pais, $cuenta, $id_ext_per, $pin)
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso	= np_hoplite_log("", $userName,"personasWeb","validar cuenta","validar cuenta","validar cuenta");
		$cuenta		= base64_decode($cuenta);
		$id_ext_per	= base64_decode($id_ext_per);

		$data		= json_encode(array(
			"idOperation"			=> "18",
			"className"				=> "com.novo.objects.TOs.CuentaTO",
			"pais"						=> $pais,
			"cuenta"					=> $cuenta,
			"id_ext_per"			=> $id_ext_per,
			"pin"							=> $pin,
			'claveWeb' 				=> md5($pin),
			"logAccesoObject"	=> $logAcceso,
			"token"						=> ""
		));

		$newCore = array (
			'Usd',
			'Pe'
			//'Ec-bp',
			//'Co',
			//'Ve'
		);

		if (!empty($newCore)){
			$validateNewCore = in_array($pais,$newCore);
		}

		log_message("info", "Request validar_cuenta: ".$data);
		$dataEncry	= np_Hoplite_Encryption($data,0,'validar_cuenta');
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> 'CPONLINE'));
		if(!$validateNewCore){
			$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
			$data		= json_decode($response);
			$desdata	= json_decode(np_Hoplite_Decrypt($data->data,0,'validar_cuenta'));
			$salida		= json_encode($desdata);
			log_message("info", "Response validar_cuenta: ".$salida);
		}

	  	if(isset($response) && isset($desdata->rc) && $desdata->rc == 0){
		  	$newdata	= array(
			   'userName'	=> $desdata->logAccesoObject->userName,
			   'pais'		=> $pais,
			   'id_ext_per'	=> $id_ext_per,
		       'token'		=> $desdata->token,
		       'sessionId'	=> $desdata->logAccesoObject->sessionId,
		       'keyId'		=> $desdata->keyUpdate,
		       'cl_addr'	=> np_Hoplite_Encryption($this->input->ip_address(),0)
		   	);
			$this->session->set_userdata($newdata);
	  	}

		$this->code = 2;
		$this->modalType = "alert-error";
		$this->codPaisUrl = '';

		if(isset($desdata->rc) && $desdata->rc !== NULL){
			switch ($desdata->rc) {

				case 0:
					$this->code = 0;
					$this->dataUser = $desdata;
					$this->modalType = "";

					break;

				case -183:
					$this->title = 'Conexión Personas Online';
					$this->msn = "La tarjeta indicada <strong>NO es válida</strong> o ya te encuentras <strong>registrado</strong>. Por favor verifica tus datos, e intenta nuevamente.";
					break;

				case -184:
					$this->title = 'Validar Cuenta';
					$this->msn = "La tarjeta indicada <strong>NO es válida</strong> o la <strong>Clave Secreta/Clave Web</strong> introducida es inválida. Por favor verifica tus datos, e intenta nuevamente.";
					break;

				default:
					$this->title = 'Conexión Personas Online';
					$this->msn = "No fue posible realizar el registro, por favor intenta nuevamente";
					break;

			}
		}
		else {
			if($validateNewCore){
				$this->code = 5;
				$this->title = 'Conexión Personas';
				$this->msn = 'Estimado usuario.<br> Esta página ha sido cambiada, para ingresar a <strong>Conexión Personas Online</strong> presiona el botón "<strong>Aceptar</strong>" o puedes acceder desde <strong><a id="link-href"></a></strong>';
				$this->codPaisUrl = changeCoreUrl($pais);
				$this->modalType = "alert-warning";
			}else{
				$this->title = "Conexión Personas Online";
				$this->msn = "En estos momentos no podemos procesar tu solicitud, por favor intenta nuevamente.";
			}
		}

		//Crea respuesta de error
		$this->response = [
			"code" => $this->code,
			"title" => $this->title,
			"msn" => $this->msn,
			"modalType" => $this->modalType,
			'dataUser' => $this->dataUser,
			'codPaisUrl' => $this->codPaisUrl
		];
		$response = $this->cryptography->encrypt($this->response);
		log_message("info", "RESPONSE: ".json_encode($response));
		return json_encode($response);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//VALIDAR LA EXISTENCIA DEL USERNAME EN LA BD, SI ESTA DISPONIBLE O NO
	public function validar_usuario($usuario)
	{
		 //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion   $this->session->userdata("userName")
		$logAcceso	= np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","registrar usuario","usuario","validar");
		$data		= json_encode(array(
			"idOperation"		=> "19",
			"className"			=> "com.novo.objects.TOs.UsuarioTO",
			"userName"			=> $usuario,
			"logAccesoObject"	=> $logAcceso,
			"token"				=> $this->session->userdata("token")
		));
		log_message("info", "Request validar_usuario: ".$data);
		$dataEncry	= np_Hoplite_Encryption($data,1,'validar_usuario');
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId' => $this->session->userdata("userName")));
		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
  	$data		= json_decode($response);
  	$desdata	= json_decode(np_Hoplite_Decrypt($data->data,1,'validar_usuario'));
		log_message("info", "Response validar_usuario: ".json_encode($desdata));
		$response = $this->cryptography->encrypt($desdata);
	  return json_encode($response);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//EFECTUAR REGISTRO DE USUARIO
	public function registrar_usuario($aplicaPerfil, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $telefono, $numDoc, $verifyDigit, $fechaNacimiento, $typeIdentifier, $lugarNacimiento,
									  $sexo, $edocivil, $nacionalidad, $tipo_direccion, $cod_postal, $pais, $departamento, $provincia, $distrito, $direccion, $correo,
									  $otroTelefono, $telefono2, $telefono3, $ruc, $centrolab, $situacionLaboral, $antiguedadLaboral, $profesion, $cargo, $ingreso, $desemPublico,
									  $cargoPublico, $institucionPublica, $uif, $userName,$password, $notarjeta, $proteccion= '', $contrato= '')
	{
		 //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso	= np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","registro usuario","registro usuario","registro usuario");

		if($otroTelefono == "NULL" || $otroTelefono == false){
			$otroTelefono="";
		}else {
			$otroTelefono=$otroTelefono;
		}

		$password = json_decode(base64_decode($password));
		$password = $this->cryptography->decrypt(
			base64_decode($password->plot),
			utf8_encode($password->password)
		);

		$passwordMobile	= strtoupper($password); // To allow cardholders to sign in through mobile app 'Acceso Móvil'

		$argon2 = $this->encrypt_connect->generateArgon2($password);
		$argon2Mobile = $this->encrypt_connect->generateArgon2($passwordMobile);
		// TODO: quitar logs
		// log_message('info', 'PRUEBA PASSWORD en plano: ' . json_encode($password));
		// log_message('info', 'PRUEBA PASSWORD en Argon2: ' . json_encode($argon2->hexArgon2));
		// log_message('info', 'PRUEBA PASSWORD_MOBILE en plano: ' . json_encode($passwordMobile));
		// log_message('info', 'PRUEBA PASSWORD_MOBILE en Argon2: ' . json_encode($argon2Mobile->hexArgon2));

		if($aplicaPerfil == 'S') {

			$user = array(
				"userName"				=> $userName,
				"primerNombre"		=> $primerNombre,
				"segundoNombre"		=> $segundoNombre,
				"primerApellido"	=> $primerApellido,
				"segundoApellido"	=> $segundoApellido,
				"fechaNacimiento"	=> $fechaNacimiento,
				"id_ext_per"			=> $numDoc,
				"tipo_id_ext_per"	=> $typeIdentifier,
				"codPais"					=> $pais,
				"sexo"						=> $sexo,
				"notEmail"				=> "1",
				"notSms"					=> "1",
				"email"						=> $correo,
				"password"				=> md5($password),
				"passwordOld4"		=> md5($passwordMobile),
				// TODO: Cambiar cuando servicio funcione
				// 'password' => $argon2->hexArgon2,
				// "passwordOld4"		=> $argon2Mobile->hexArgon2,
				// 'hashMD5' => md5($password),
				// 'hashMD5Old4' => md5($passwordMobile),
			);

			$tHabitacion = array(
				"tipo"	=> "HAB",
				"numero"=> $telefono
			);

			$tMobile = array(
				"tipo"	=> "CEL",
				"numero"=> $telefono2
			);

			$tOtro = array(
				"tipo"	=> $otroTelefono,
				"numero"=> $telefono3
			);

			$afiliacion = array(

				"notarjeta"					=> $notarjeta,
				"idpersona"					=> $numDoc,
        "nombre1"					=> $primerNombre,
				"nombre2"					=> $segundoNombre,
				"apellido1"					=> $primerApellido,
				"apellido2"					=> $segundoApellido,
				"fechanac"					=> $fechaNacimiento,
				"sexo"						=> $sexo,
				"codarea1"					=> "",
				"telefono1"					=> $telefono,
				"telefono2"					=> $telefono2,
				"correo"					=> $correo,
				"direccion"					=> $direccion,
				"distrito"					=> $distrito,
				"provincia"					=> $provincia,
				"departamento"				=> $departamento,
				"edocivil"					=> $edocivil,
				"labora"					=> $situacionLaboral,
				"centrolab"					=> $centrolab,
				"fecha_reg"					=> "",
				"estatus"					=> "",
				"notifica"					=> "",
				"fecha_proc"				=> "",
				"fecha_afil"				=> "",
				"tipo_id"					=> "",
				"fecha_solicitud"			=> "",
				"antiguedad_laboral"		=> $antiguedadLaboral,
				"profesion"					=> $profesion,
				"cargo"						=> $cargo,
				"ingreso_promedio_mensual"	=> $ingreso,
				"cargo_publico_last2"		=> $desemPublico,
				"cargo_publico"				=> $cargoPublico,
				"institucion_publica"		=> $institucionPublica,
				"uif"						=> $uif,
				"lugar_nacimiento"			=> $lugarNacimiento,
				"nacionalidad"				=> $nacionalidad,
				"punto_venta"				=> "",
				"cod_vendedor"				=> "",
				"dni_vendedor"				=> "",
				"cod_ubigeo"				=> "",
				"dig_verificador"			=> $verifyDigit,
				"telefono3"					=> $telefono3,
				"tipo_direccion"			=> $tipo_direccion,
				"cod_postal"				=> $cod_postal,
				"ruc_cto_laboral"			=> $ruc,
				"aplicaPerfil"				=> $aplicaPerfil,
				"acepta_proteccion"			=> $proteccion,
				"acepta_contrato"			=> $contrato
			);

		}else if ($aplicaPerfil == 'N') {

			$user = array(
				"userName"			=> $userName,
				"primerNombre"		=> $primerNombre,
				"segundoNombre"		=> $segundoNombre,
				"primerApellido"	=> $primerApellido,
				"segundoApellido"	=> $segundoApellido,
				"fechaNacimiento"	=> $fechaNacimiento,
				"id_ext_per"			=> $numDoc,
				"tipo_id_ext_per"	=> $typeIdentifier,
				"codPais"					=> $pais,
				"sexo"						=> $sexo,
				"notEmail"				=> "1",
				"notSms"					=> "1",
				"email"						=> $correo,
				"password"				=> md5($password),
				"passwordOld4"		=> md5($passwordMobile),
				// TODO: Cambiar cuando servicio funcione
				// 'password' => $argon2->hexArgon2,
				// "passwordOld4"		=> $argon2Mobile->hexArgon2,
				// 'hashMD5' => md5($password),
				// 'hashMD5Old4' => md5($passwordMobile),
			);

			$tHabitacion = array(
				"tipo"	=> "HAB",
				"numero"=> $telefono
			);

			$tMobile = array(
				"tipo"	=> "CEL",
				"numero"=> $telefono2
			);

			$tOtro = array(
				"tipo"	=> $otroTelefono,
				"numero"=> $telefono3
			);
		}

		$listaTelefonos = array($tHabitacion, $tMobile, $tOtro);

		if($aplicaPerfil == 'S'){
			$data = json_encode(array(
				"idOperation"		=> "20",
				"className"			=> "com.novo.objects.MO.RegistroUsuarioMO",
				"user"				=> $user,
				"listaTelefonos"	=> $listaTelefonos,
				"afiliacion"		=> $afiliacion,
				"logAccesoObject"	=> $logAcceso,
				"token"				=> $this->session->userdata("token")
			));
		} else if($aplicaPerfil == 'N'){
			$data = json_encode(array(
				"idOperation"		=> "20",
				"className"			=> "com.novo.objects.MO.RegistroUsuarioMO",
				"user"				=> $user,
				"listaTelefonos"	=> $listaTelefonos,
				"logAccesoObject"	=> $logAcceso,
				"token"				=> $this->session->userdata("token")
			));
		}

		log_message("info", "Request registrar_usuario ".$data);

		$dataEncry	= np_Hoplite_Encryption($data,1,'registrar_usuario');
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId' => $this->session->userdata("userName")));
		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
  	$data		= json_decode($response);
		$desdata	= json_decode(np_Hoplite_Decrypt($data->data,1,'registrar_usuario'));

		log_message("info", "Response registrar_usuario: ".json_encode($desdata));

		$this->code = 3;
		$this->modalType = "alert-error";
		$responseCode = isset($desdata->rc) ? $desdata->rc : '-9999';
				switch ($responseCode) {
					case 0:
						$this->title = "Usuario registrado exitosamente";
						$this->msn = "se ha registrado de forma correcta en el <strong> Sistema Conexión Personas Online. </strong>";
						$this->code = 0;
						$this->modalType = "";
					break;

					case -61:
					case -5:
					case -3:
						$this->title = "";
						$this->msn = "";
						$this->code = 2;
						$this->modalType = "";
					break;

					case -181:
						$this->title = "Conexión Personas Online";
						$this->msn = "El correo indicado se encuentra registrado. Por favor verifica e intenta nuevamente.";
						$this->code = 3;
						$this->modalType = "alert-error";

					break;

					case -284:

						$this->title = "Conexión Personas Online";
						$this->msn = "El teléfono móvil ya se encuentra registrado.";
						$this->code = 3;
						$this->modalType = "alert-error";

					break;

					case -206:
						$this->title = "Conexión Personas Online";
						$this->msn = "El usuario fue registrado satisfactoriamente. Ha ocurrido un error al enviar el mail de confirmación";
						$this->code = 4;
						$this->modalType = "alert-warning";
					break;

					case -230:
						$this->title = "Conexión Personas Online";
						$this->msn = "No se puede realizar el registro en estos momentos, por favor intenta nuevamente.";
						$this->code = 4;
						$this->modalType = "alert-error";
					break;

					case -271:
					case -335:

						$this->title = "Usuario registrado";
						$this->msn = "se ha registrado, pero algunos datos no fueron cargados en su totalidad.</br> Por favor complétalos en la sección de <strong>Perfil.</strong>";
						$this->code = 0;
						$this->modalType = "2";

					break;

					case -317:
					case -314:
					case -313:
					case -311:

						$this->title = "Usuario registrado";
						$this->msn = "se registró satisfactoriamente, aunque tu tarjeta no fue activada. Comunícate con el <strong>Centro de Contacto</strong>";
						$this->code = 0;
						$this->modalType = "2";

					break;

					//verificacion de reniec grupo 1
					case 5002:
					case 5003:
					case -102:
					case -104:
					case -118:
					case 5004:
					case 5008:
					case 5009:
					case 5010:
					case 5011:
					case 5020:
					case 5021:
					case 5030:
					case 5100:
					case 5104:
					case 6000: //Valida conexión fallida
						$this->title = "Conexión Personas Online";
						$this->msn = "No hemos podido validar tus datos, por favor intenta nuevamente.";
						break;

					// verificacion de reniec  grupo 2
					case 5101:
					case 5102:
					case 5103:
					case 5104:
					case 5105:
					case 5111:
					case 5112:
					case 5113:
					case 5032:
					case 5033:
					case 5034:
					case 5036:
					case 5037:
					case 5114:
						$this->title = "Conexión Personas Online";
						$this->msn = "Datos de afiliación inválidos. Verifica tu DNI en RENIEC e intenta de nuevo. <br> Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta";
						break;

					case -397:
						$this->title = "Conexión Personas Online";
						$this->msn = "Datos de afiliación inválidos. Verifica tus datos e intenta de nuevo. <br> Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta";
						break;

					default:
						$this->title = "Conexión Personas Online";
						$this->msn = "No fue posible realizar el registro, por favor intenta nuevamente.";
						$this->code = 2;
						$this->modalType = "alert-error";
					break;

				}

				$this->response = [
					"code" => $this->code,
					"title" => $this->title,
					"msn" => $this->msn,
					"modalType" => $this->modalType
				];

			$response = $this->cryptography->encrypt($this->response);
			return json_encode($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CONSULTAR LISTADO DE TELEFONOS
	public function lista_telefonos()
	{

	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","login","login","login");

		$data = json_encode(array(
			"idOperation"=>"26",
			"className"=>"com.novo.objects.MO.ListaTipoTLFMO",
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		log_message("info", "Request lista_telefonos: ".$data);
		$dataEncry = np_Hoplite_Encryption($data,1,'registrar_usuario');
		$data = json_encode(array('data' => $dataEncry, 'pais' =>  $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
  	$data = json_decode($response);
  	$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'registrar_usuario'));
		log_message("info", "Response lista_telefonos : ".json_encode($desdata));

	  	return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR LISTA DE TIPOS DE IDENTIFICADORES(DNI, CEDULA, ETC)
	public function lista_identificadores()
	{

	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista id","lista id","consulta");

		$data = json_encode(array(
			"idOperation"=>"38",
			"className"=>"com.novo.objects.MO.IdentificadoresMO",
			"pais"=> $this->session->userdata("pais"),
			"logAccesoObject"=>$logAcceso,
			"token"=>$this->session->userdata("token")
		));

		log_message("info", "Request lista_telefonos: ".$data);
		$dataEncry = np_Hoplite_Encryption($data,1,'lista_identificadores');
		$data = json_encode(array('data' => $dataEncry, 'pais' =>  $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada lista_identificadores : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
  	$data = json_decode($response);
  	$desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'lista_identificadores'));
		log_message("info", "Response lista_telefonos: ".json_encode($desdata));

	  	return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}	//FIN FUNCION GENERAL
