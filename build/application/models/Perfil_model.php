<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR PERFIL
    public function perfil_load()
    {
        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","perfil","perfil","consulta");

        $data = json_encode(array(
            "idOperation"=>"30",
            "className"=>"com.novo.objects.TOs.UsuarioTO",
            "userName"=>$this->session->userdata("userName"),
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        log_message("info", "Salida perfil_usuario ".$data);
        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada perfil_load : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        $salida = json_encode($desdata);

        log_message("info", "Salida perfil model response".$salida);

        return json_encode($desdata);

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //MODIFICAR PERFIL
    public function perfil_update($userName, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $lugarNacimiento, $fechaNacimiento, $sexo, $edocivil, $nacionalidad, $profesion, $tipoDireccion,
                                  $codepostal, $paisResidencia, $departamento_residencia, $provincia_residencia, $distrito_residencia, $direccion, $telefono_hab, $telefono, $otro_telefono_tipo, $otro_telefono_num, $email, $ruc_cto_labora, $centro_laboral, $situacion_laboral, $antiguedad_laboral_value,
                                  $profesion_labora, $cargo, $ingreso_promedio, $cargo_public, $cargo_publico, $institucion_publica, $sujeto_obligado, $notEmail, $notSms, $dtfechorcrea_usu, $id_ext_per, $tipo_profesion, $tipo_identificacion, $tipo_id_ext_per, $aplicaPerfil,
                                  $notarjeta, $acCodCiudad, $acCodEstado, $acCodPais, $acTipo, $acZonaPostal, $disponeClaveSMS, $codigopais, $verifyDigit = '', $proteccion = '', $contrato = '')
    {
        //PARAMS
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","perfil","perfil","actualizar");
        if($telefono_hab==false){
            $telefono_hab='';
        }else{
            $telefono_hab=$telefono_hab;
        }

        if($otro_telefono_tipo==false){

            $otro_telefono_tipo="";
        }else {

            $otro_telefono_tipo=$otro_telefono_tipo;
        }


        $user = array(
            "userName"			=> $userName,
            "primerNombre"		=> $primerNombre,
            "segundoNombre"		=> $segundoNombre,
            "primerApellido"	=> $primerApellido,
            "segundoApellido"	=> $segundoApellido,
            "email"				=> strtolower($email),
            "dtfechorcrea_usu" => $dtfechorcrea_usu,
            "passwordOperaciones" => "",
            "notEmail"			=> $notEmail,
            "notSms"			=> $notSms,
            "sexo"				=> $sexo,
            "id_ext_per"		=> $id_ext_per,
            "fechaNacimiento"	=> $fechaNacimiento,
            "tipo_profesion" => $tipo_profesion,
            "profesion" => $profesion,
            "tipo_id_ext_per"	=> $tipo_id_ext_per,
            "descripcion_tipo_id_ext_per" => $tipo_identificacion,
            "disponeClaveSMS" => "",
						"aplicaPerfil"=> $aplicaPerfil,
						"idPersona" => $this->session->userdata('idPersona'),
            "rc"=> "0"
        );

        $tHabitacion = array(
            "tipo"	=> "HAB",
            "numero"=> $telefono_hab,
            "descripcion"=> "HABITACION"
        );

        $tOtro = array(
            "tipo"	=> $otro_telefono_tipo,
            "numero"=> $otro_telefono_num,
            "descripcion"=>$otro_telefono_tipo
        );

        $tMobile = array(
            "tipo"	=> "CEL",
            "numero"=> $telefono,
            "descripcion"=> "MOVIL",
            "aplicaClaveSMS"=> "No Aplica mensajes SMS"
        );

        if($aplicaPerfil=='S'){
            $afiliacion = array(

                "notarjeta"					=> $notarjeta,
                "idpersona"					=> $id_ext_per,
                "nombre1"					=> $primerNombre,
                "nombre2"					=> $segundoNombre,
                "apellido1"					=> $primerApellido,
                "apellido2"					=> $segundoApellido,
                "fechanac"					=> $fechaNacimiento,
                "sexo"						=> $sexo,
                "codarea1"					=> "",
                "telefono1"					=> $telefono_hab,
                "telefono2"					=> $telefono,
                "correo"					=> $email,
                "direccion"					=> $direccion,
                "distrito"					=> $distrito_residencia,
                "provincia"					=> $provincia_residencia,
                "departamento"				=> $departamento_residencia,
                "edocivil"					=> $edocivil,
                "labora"					=> $situacion_laboral,
                "centrolab"					=> $centro_laboral,
                "fecha_reg"					=> "",
                "estatus"					=> "",
                "notifica"					=> "",
                "fecha_proc"				=> "",
                "fecha_afil"				=> "",
                "tipo_id"					=> "",
                "fecha_solicitud"			=> "",
                "antiguedad_laboral"		=> $antiguedad_laboral_value,
                "profesion"					=> $profesion_labora,
                "cargo"						=> $cargo,
                "ingreso_promedio_mensual"	=> $ingreso_promedio,
                "cargo_publico_last2"		=> $cargo_public,
                "cargo_publico"				=> $cargo_publico,
                "institucion_publica"		=> $institucion_publica,
                "uif"						=> $sujeto_obligado,
                "lugar_nacimiento"			=> $lugarNacimiento,
                "nacionalidad"				=> $nacionalidad,
                "punto_venta"				=> "",
                "cod_vendedor"				=> "",
                "dni_vendedor"				=> "",
                "cod_ubigeo"				=> "",
                "dig_verificador"			=> $verifyDigit,
                "telefono3"					=> $otro_telefono_num,
                "tipo_direccion"			=> $acTipo,
                "cod_postal"				=> $acZonaPostal,
                "ruc_cto_laboral"			=> $ruc_cto_labora,
                "aplicaPerfil"				=> $aplicaPerfil,
                "acepta_contrato"           => $contrato,
                "acepta_proteccion"         => $proteccion
            );
        }else if($aplicaPerfil=='N'){
            $afiliacion = array(

                "notarjeta"					=> "",
                "idpersona"					=> "",
                "nombre1"					=> "",
                "nombre2"					=> "",
                "apellido1"					=> "",
                "apellido2"					=> "",
                "fechanac"					=> "",
                "sexo"						=> "",
                "codarea1"					=> "",
                "telefono1"					=> "",
                "telefono2"					=> "",
                "correo"					=> "",
                "direccion"					=> "",
                "distrito"					=> "",
                "provincia"					=> "",
                "departamento"				=> "",
                "edocivil"					=> "",
                "labora"					=> "",
                "centrolab"					=> "",
                "fecha_reg"					=> "",
                "estatus"					=> "",
                "notifica"					=> "",
                "fecha_proc"				=> "",
                "fecha_afil"				=> "",
                "tipo_id"					=> "",
                "fecha_solicitud"			=> "",
                "antiguedad_laboral"		=> "",
                "profesion"					=> "",
                "cargo"						=> "",
                "ingreso_promedio_mensual"	=> "",
                "cargo_publico_last2"		=> "",
                "cargo_publico"				=> "",
                "institucion_publica"		=> "",
                "uif"						=> "",
                "lugar_nacimiento"			=> "",
                "nacionalidad"				=> "",
                "punto_venta"				=> "",
                "cod_vendedor"				=> "",
                "dni_vendedor"				=> "",
                "cod_ubigeo"				=> "",
                "dig_verificador"			=> "",
                "telefono3"					=> "",
                "tipo_direccion"			=> "",
                "cod_postal"				=> "",
                "ruc_cto_laboral"			=> "",
                "aplicaPerfil"				=> "",
            );
        }


        $listaTelefonos = array($tHabitacion, $tOtro, $tMobile);

        $direccion= array(
            "acCodCiudad"=> $acCodCiudad,
            "acCodEstado"=> $acCodEstado,
            "acCodPais"=> $codigopais,
            "acTipo"=> $acTipo,
            "acZonaPostal"=> $acZonaPostal,
            "acDir"=> $direccion
        );


        $registro=[
            "user" => $user,
            "listaTelefonos"	=> $listaTelefonos,
            "registroValido"=> false,
            "corporativa"=> false,
            "afiliacion"		=> $afiliacion
        ];


        $data = json_encode(array(
            "idOperation"		=> "39",
            "className"			=> "com.novo.objects.MO.DatosPerfilMO",
            "registro"				=> $registro,
            "rc"=>0,
            "direccion"=>$direccion,
            "isParticular"=> true,
            "logAccesoObject"	=> $logAcceso,
            "token"				=> $this->session->userdata("token")
        ));



        log_message("info", "REQUEST DEL FORMULARIO LARGO ACTUALIZAR PERFIL===> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada perfil_update : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        log_message("info", "RESPONSE DEL FORMULARIO LARGO ACTUALIZAR PERFIL===> ".json_encode($desdata));

        if($aplicaPerfil=='S' && $verifyDigit != '') {
            switch ($desdata->rc) {
                case -317:
                case -314:
                case -313:
                case -311:
                case -21:
                case 0:
                    $this->session->set_userdata('afiliado', $contrato);
            }
        } elseif ($desdata->rc === 0) {
        	$this->session->set_userdata('cantCorreos', 0);
        }

        return json_encode($desdata);
        // Simula respuesta de servicio
        // $desdata = '{"rc":-317,"msg":"Error cuenta invalida"}';
        // $this->session->set_userdata('afiliado', $contrato);
        // return $desdata;

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTA DE PAISES
    public function lista_paises(){

        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","validar cuenta","lista pais","consultar");

        $data = json_encode(array(
            "idOperation"=>"22",
            "className"=>"com.novo.objects.MO.ListaPaisMO",
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada lista_paises : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        return json_encode($desdata);

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTA DE ESTADOS POR PAIS
    public function lista_estados($codPais){

        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista estados","lista estados","consultar");

        $data = json_encode(array(
            "idOperation"=>"34",
            "className"=>"com.novo.objects.TOs.PaisTO",
            "codPais"=>$codPais,
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada lista_estados : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));


        log_message("info", "Salida desencriptada lista_estados : ".json_encode($desdata));
        return json_encode($desdata);

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTA DE CIUDADES POR ESTADO
    public function lista_ciudad($codEstado,$codPais){

        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista ciudad","lista ciudad","consultar");

        $data = json_encode(array(
            "idOperation"=>"35",
            "className"=>"com.novo.objects.TOs.EstadoTO",
            "codEstado"=>$codEstado,
            "codPais"=>$codPais,
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada lista_ciudad : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        return json_encode($desdata);

    }
//----------------------------------------------------------------------------------------------------------------------------------------------------------------
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
        log_message("info", "JSONDATA LLAMADO AL SERVICIO==>: ".$data);

        $response	= np_Hoplite_GetWS("movilsInterfaceResource",$data);
        log_message("info", "RESPONSE DESPUES DEL LLAMADO AL WS ===>: ".$response);

        /*$response	= np_Hoplite_GetWSdepartament("movilsInterfaceResource",$data);
        log_message("info", "RESPONSE DESPUES DEL LLAMADO AL WS ===>: ".$response);*/

        $data		= json_decode(utf8_encode($response));

        $desdata	= json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,0)));
        log_message("info", "Salida desencriptada lista_departamento : ".json_encode($desdata));

        return json_encode($desdata);
    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTA DE PROFESIONES
    public function lista_profesiones(){

        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista profesion","lista profesion","consultar");

        $data = json_encode(array(
            "idOperation"=>"37",
            "className"=>"com.novo.objects.MO.ListaTipoProfesionesMO",
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada lista_profesiones : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        return json_encode($desdata);

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTA DE DIRECCIONES
    public function lista_direcciones(){

        //PARAMS                    //$sessionId - $username - $canal - $modulo - $function - $operacion
        $logAcceso = np_hoplite_log($this->session->userdata("sessionId"),$this->session->userdata("userName"),"personasWeb","lista direcciones","lista direcciones","consultar");

        $data = json_encode(array(
            "idOperation"=>"36",
            "className"=>"com.novo.objects.MO.TipoDireccionesMO",
            "logAccesoObject"=>$logAcceso,
            "token"=>$this->session->userdata("token")
        ));

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada lista_direcciones : ".$data);
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        return json_encode($desdata);

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CARGAR LISTADO DE TIPOS DE TELEFONO
    public function lista_telefonos(){

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
    public function verificar_email($pais, $email, $username)
    {
        $logAcceso	= np_hoplite_log($this->session->userdata("sessionId"), $username, "personasWeb", "perfil", "perfil", "verificarEmailCPO");

        $data		= json_encode(array(
            "idOperation"		=> "verificarEmailCPO",
            "email" => $email,
            "className"			=> "com.novo.objects.TO.UsuarioTO",
            "token"				=> $this->session->userdata("token"),
            "pais"				=> $pais,
            "logAccesoObject"	=> $logAcceso
        ));
        log_message("info", "Salida verificar email---------> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' =>  $this->session->userdata("pais"), 'keyId'=> $this->session->userdata("userName")));
        log_message("info", "Salida encriptada verificar email------------> : ".$data);

        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);

        $data = json_decode(utf8_encode($response));

        $desdata = np_Hoplite_Decrypt($data->data,1);

        log_message("info", "Salida Verificar email------------->".$desdata);

        return json_encode(utf8_encode($desdata));
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
}//FIN
