<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_model extends CI_Model {

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

		$dataEncry	= np_Hoplite_Encryption($data,0);
		$data		= json_encode(array('data' => $dataEncry, 'pais' => "Global", 'keyId'=> 'CPONLINE'));
		log_message("info", "JSONDATA LLAMADO AL SERVICIO LISTA PAISES==>: ".$data);

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
		log_message("info", "RESPONSE DESPUES DEL LLAMADO AL WS LISTA PAISES===>: ".$response);

	  	$data		= json_decode(utf8_encode($response));

	  	$desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,0)));
		log_message("info", "Salida desencriptada LISTA PAISES : ".json_encode($desdata));

	  	return json_encode($desdata);
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
		log_message("info", "JSONData departamento==>: ".$data);

		$dataEncry	= np_Hoplite_Encryption($data,0);
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId' => 'CPONLINE'));

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);

		$data		= json_decode(utf8_encode($response));

		$desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,0)));
		log_message("info", "Salida desencriptada lista_departamento : ".json_encode($desdata));

		return json_encode($desdata);
	}


	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	//CARGAR LISTA DE PROFESIONES
	public function lista_profesiones($pais){
		//PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		//$logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista profesion","lista profesion","consultar");

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
			//"token"=>$this->session->userdata("token")  $this->session->userdata("pais")
		));

		$dataEncry = np_Hoplite_Encryption($data,0);
		$data = json_encode(array('data' => $dataEncry, 'pais' => "Global", 'keyId'=> "CPONLINE"));
		//log_message("info", "Salida encriptada lista_profesiones : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
		$data = json_decode(utf8_encode($response));
		$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,0)));
		log_message("info", "Salida desencriptada lista_profesiones : ".json_encode($desdata));

		return json_encode($desdata);

	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------



	//VALIDAR EXISTENCIA DE LA TARJETA O CUENTA EN LA BD
	public function validar_cuenta($userName, $pais, $cuenta, $id_ext_per, $pin,$claveWeb)
	{
	    //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
		$logAcceso	= np_hoplite_log("", $userName,"personasWeb","validar cuenta","validar cuenta","validar cuenta");
		$cuenta		= base64_decode($cuenta);
		$id_ext_per	= base64_decode($id_ext_per);

		$data		= json_encode(array(
			"idOperation"		=> "18",
			"className"			=> "com.novo.objects.TOs.CuentaTO",
			"pais"				=> $pais,
			"cuenta"			=> $cuenta,
			"id_ext_per"		=> $id_ext_per,
			"pin"				=> $pin,
			"claveWeb"			=> $claveWeb,
			"logAccesoObject"	=> $logAcceso,
			"token"				=> ""
		));
		log_message("info", "Salida validar cuenta ".$data);

		$dataEncry	= np_Hoplite_Encryption($data,0);
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> 'CPONLINE'));
		log_message("info", "Salida encriptada validar_cuenta : ".$data);

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
		log_message("info", "RESPONSE DESPUES DEL LLAMADO AL WS validar_cuenta ---->: ".$data);

	  	$data		= json_decode(utf8_encode($response));
	  	$desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,0)));
	  	$salida		= json_encode($desdata);
	  	log_message("info", "Salida Validar Cuentas".$salida);

	  	if(isset($response) && $desdata->rc == 0){
		  	$newdata	= array(
			   'userName'	=> $desdata->logAccesoObject->userName,
			   'pais'		=> $pais,
			   'id_ext_per'	=> $id_ext_per,
		       'token'		=> $desdata->token,
		       'sessionId'	=> $desdata->logAccesoObject->sessionId,
		       'keyId'		=> $desdata->keyUpdate,
		       'cl_addr'	=> np_Hoplite_Encryption($_SERVER['REMOTE_ADDR'],0)
		   	);
			$this->session->set_userdata($newdata);
	  	}
	  	return json_encode($desdata);
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
		log_message("info", "validar_usuario ==>".$data);

		$dataEncry	= np_Hoplite_Encryption($data,1);
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId' => $this->session->userdata("userName")));
		log_message("info", "Salida encriptada validar_usuario : ".$data);

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
		log_message("info", "Response validar_usuario -----> ".$response);

	  	$data		= json_decode(utf8_encode($response));
	  	$desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
		log_message("info", "Response validar_usuario -->".json_encode($desdata));

	  	return json_encode($desdata);
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

		$passwordMobile	= strtoupper($password); // To allow cardholders to sign in through mobile app 'Acceso Móvil'

		if($aplicaPerfil == 'S') {

			$user = array(
				"userName"			=> $userName,
				"primerNombre"		=> $primerNombre,
				"segundoNombre"		=> $segundoNombre,
				"primerApellido"	=> $primerApellido,
				"segundoApellido"	=> $segundoApellido,
				"fechaNacimiento"	=> $fechaNacimiento,
				"id_ext_per"		=> $numDoc,
				"tipo_id_ext_per"	=> $typeIdentifier,
				"codPais"			=> $pais,
				"sexo"				=> $sexo,
				"notEmail"			=> "1",
				"notSms"			=> "1",
				"email"				=> $correo,
				"password"			=> md5($password),
				"passwordOld4"		=> md5($passwordMobile)
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
				"id_ext_per"		=> $numDoc,
				"tipo_id_ext_per"	=> $typeIdentifier,
				"codPais"			=> $pais,
				"sexo"				=> $sexo,
				"notEmail"			=> "1",
				"notSms"			=> "1",
				"email"				=> $correo,
				"password"			=> md5($password),
				"passwordOld4"		=> md5($passwordMobile)
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
		log_message("info", "REQUEST DEL FORMULARIO LARGO ===> ".$data);

		$dataEncry	= np_Hoplite_Encryption($data,1);
		$data		= json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId' => $this->session->userdata("userName")));

		$response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data		= json_decode(utf8_encode($response));

		$desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));
		log_message("info", "RESPONSE FINAL DEL REGISTRO ===>>> : ".json_encode($desdata));
		return json_encode($desdata);

		//Simula respuesta del servicio
		// sleep(2);
		// $desdata = '{"rc":0,"msg":"Error cuenta invalida"}';
		// return $desdata;
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

		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' =>  $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada lista_telefonos : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode(utf8_encode($response));
	  	$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

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

		$dataEncry = np_Hoplite_Encryption($data,1);
		$data = json_encode(array('data' => $dataEncry, 'pais' =>  $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
		log_message("info", "Salida encriptada lista_identificadores : ".$data);
		$response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
	  	$data = json_decode(utf8_encode($response));
	  	$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

	  	return json_encode($desdata);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}	//FIN FUNCION GENERAL