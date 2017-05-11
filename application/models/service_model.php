<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }
    // -----------------------------------------------------------------------------------------------------------------

    //Solicitud de bloqueo y desbloqueo de cuenta
    public function callWsLockAccount ($dataRequest) {
        //Datos de la cuenta
        parse_str($dataRequest, $dataAccount);
        //se obtiene el tipo de bloqueo
        $lockType = $dataAccount['lock-type'];
        //log de acceso
        $session = $this->session->userdata("sessionId");
        $user = $this->session->userdata('userName');
        $token = $this->session->userdata("token");
        $canal = "personasWeb";
        $modulo = ($lockType == 'temporary') ? "bloquearTarjeta" : "bloqueoReposicion";
        $function = ($lockType == 'temporary') ? "bloquearTarjeta" : "bloqueoReposicion";
        $operation = ($lockType == 'temporary') ? "bloquearTarjeta" : "bloqueoReposicion";
        //Construccion de log de acceso
        $logAcceso = np_hoplite_log($session, $user, $canal, $modulo, $function, $operation);

        //parametros para la solicitud de bloq y desbloq
        $idOperation = ($lockType == 'temporary') ? "110" : "111";
        $tokenOper = (isset($dataAccount['token'])) ? $dataAccount['token'] : '';
        $permanentLock = (isset($dataAccount['mot-sol-now'])) ? $dataAccount['mot-sol-now'] : '';
        $cardNum = $dataAccount['card-bloq'];
        $fechaExp = $dataAccount['fecha-exp-bloq'];
        $action = ($dataAccount['status'] == 'N') ? 'PB' : '00';
        $action = ($lockType == 'temporary') ? $action : $permanentLock;
        $prefix = $dataAccount['prefix-bloq'];
        $idUser = $this->session->userdata('idUsuario');
        $pais = $this->session->userdata('pais');
        $msgLok = ($action == '00') ? 'Desbloqueada' : 'Bloqueada';
        $msgLok = ($lockType == 'temporary') ? $msgLok : 'Bloqueada';

        $data = json_encode(array(
            "idOperation" => $idOperation,
            "className" => "com.novo.objects.TOs.TarjetaTO",
            "noTarjeta" => $cardNum,
            "accodUsuario" => $user,
            "id_ext_per" => $idUser,
            "prefix" => $prefix,
            "fechaExp" => $fechaExp,
            "tokenOperaciones" => $tokenOper,
            "codBloqueo" => $action,
            "token" => $token,
            "logAccesoObject"=>$logAcceso,
            "pais" => $pais
        ));

        log_message("info", "REQUEST Bloqueo desbloqueo=====>>>>> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        log_message("info", "RESPONSE Bloqueo desbloqueo=====>>>>> ".json_encode($desdata));

        // sleep(2);
        // $response = '{"rc":-288,"msg":"Proceso OK"}';
        // $desdata = json_decode($response);

        if ($desdata) {
            switch ($desdata->rc) {
                case 0:
                    $response = [
                        'code' => 0,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => ($lockType == 'temporary') ? 'La cuenta ha sido <strong>'. $msgLok . '</strong> exitosamente' : 'Su tarjeta será enviada en los próximos días'
                    ];
                    break;
                case -241:
                    $response = [
                        'code' => 1,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => 'Los campos introducidos son inválidos, verifique e intente nuevamente.'
                    ];
                    break;
                case -286:
                    if($desdata->rc == -286) {
                        $msg = 'El código de seguridad introducido es inválido, verifique e intente nuevamente.';
                    }
                case -287:
                    if($desdata->rc == -287) {
                        $msg = 'El código de seguridad introducido ya fue usado, verifique e intente nuevamente.';
                    }
                case -288:
                    if($desdata->rc == -288) {
                        $msg = 'El código de seguridad introducido ha expirado, solicítelo nuevamente.';
                    }
                case -301:
                    if($desdata->rc == -301) {
                        $msg = 'El código de seguridad introducido es inválido, verifique e intente nuevamente.';
                    }
                case -310:
                    if($desdata->rc == -310) {
                        $msg = 'La fecha de expiración introducida es inválida, verifique e intente de nuevo.';
                    }
                    $response = [
                        'code' => 1,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => $msg
                    ];
                    break;
                case -267:
                    $response = [
                        'code' => 2,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => 'La tarjeta no pudo ser <strong>'. $msgLok . '</strong>, intente nuevamente.'
                    ];
                    break;
                case -356:
                    $response = [
                        'code' => 2,
                        'title' => 'Reposición de tarjeta',
                        'msg' => 'La tarjeta tiene una reposición pendiente, comuníquese con el centro de contacto.'
                    ];
                    break;
                case -306:
                    $response = $this->callWsGetToken();
                    break;
                case -125:
                case -304:
                case -911:
                    $response = [
                        'code' => 3,
                        'title' => 'Servicios',
                        'msg' => ($desdata->rc == -125) ? 'No es posible realizar esta acción, la tarjeta está vencida' :'Su solicitud no pudo ser procesada, intente más tarde.'
                    ];
                    break;
                case -35:
                case -61:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Su sesión ha expirado.'
                    ];
                    $this->session->sess_destroy();
                    break;
                default:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intente más tarde.'
                    ];
                    $this->session->sess_destroy();
            }
        } else {
            $response = [
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intente más tarde.'
            ];
            $this->session->sess_destroy();
        }

        return $response;

    }
    //fin Solicitud de bloqueo y desbloqueo de cuenta

    //Solicitud de cambio de PIN
    public function callWschangePin ($dataRequest) {
        //Datos de la cuenta
        parse_str($dataRequest, $dataAccount);

        //log de acceso
        $session = $this->session->userdata("sessionId");
        $user = $this->session->userdata('userName');
        $token = $this->session->userdata("token");
        $canal = "personasWeb";
        $modulo = "Cuentas";
        $function = "cambio de PIN";
        $operation = "cambio de PIN";

        //Construccion de log de acceso
        $logAcceso = np_hoplite_log($session, $user, $canal, $modulo, $function, $operation);

        //parametros para la solicitud de cambio de PIN
        $tokenOper = (isset($dataAccount['token'])) ? $dataAccount['token'] : '';
        $cardNum = $dataAccount['card-cambio'];
        $pinCurrent = $dataAccount['pin-current-now'];
        $pinNew = $dataAccount['new-pin-now'];
        $fechaExp = $dataAccount['fecha-exp-cambio'];
        $prefix = $dataAccount['prefix-cambio'];
        $idUser = $this->session->userdata('idUsuario');
        $pais = $this->session->userdata('pais');

        $data = json_encode(array(
            "idOperation" => "112",
            "className" => "com.novo.objects.TOs.TarjetaTO",
            "noTarjeta" => $cardNum,
            "accodUsuario" => $user,
            "id_ext_per" => $idUser,
            "prefix" => $prefix,
            "fechaExp" => $fechaExp,
            "tokenOperaciones" => $tokenOper,
            "pin" => $pinCurrent,
            "pinNuevo" => $pinNew,
            "token" => $token,
            "logAccesoObject"=>$logAcceso,
            "pais" => $pais
        ));

        log_message("info", "REQUEST Cambio de PIN=====>>>>> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        log_message("info", "RESPONSE Cambio de PIN=====>>>>> ".json_encode($desdata));

        /*sleep(2);
        $response = '{"rc":-306,"msg":"Proceso OK"}';
        $desdata = json_decode($response);*/

        if ($desdata) {
            switch ($desdata->rc){
                case 0:
                    $response = [
                        'code' => 0,
                        'title' => 'Cambio de PIN',
                        'msg' => 'El PIN ha sido cambiado exitosamente'
                    ];
                    break;
                case -308:
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => 'El PIN actual no es válido, verifique e intente nuevamente.'
                    ];
                    break;
                case -241:
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => 'Los campos introducidos son inválidos, verifique intente nuevamente.'
                    ];
                    break;
                case -130:
                case -310:
                    $msg = ($desdata->rc == -130) ? 'El código de seguridad introducido es inválido, verifique e intente nuevamente.' : 'La fecha de expiración introducida es inválida, verifique e intente de nuevo';
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => $msg
                    ];
                    break;
                case -306:
                    $response = $this->callWsGetToken();
                    break;
                case -125:
                case -304:
                case -911:
                    $response = [
                        'code' => 3,
                        'title' => 'Servicios',
                        'msg' => ($desdata->rc == -125) ? 'No es posible realizar esta acción, la tarjeta está vencida' :'Su solicitud no pudo ser procesada, intente más tarde.'
                    ];
                    break;
                case -35:
                case -61:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Su sesión ha expirado.'
                    ];
                    $this->session->sess_destroy();
                    break;
                default:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intente más tarde.'
                    ];
                    $this->session->sess_destroy();
            }
        } else {
            $response = [
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intente más tarde.'
            ];
            $this->session->sess_destroy();
        }

        return $response;

    }
    //Fin solicitud de cambio de PIN
    // -----------------------------------------------------------------------------------------------------------------

    //Solicitud de Token
    public function callWsGetToken()
    {
        //log de acceso
        $session = $this->session->userdata("sessionId");
        $user = $this->session->userdata('userName');
        $token = $this->session->userdata("token");
        $canal = "personasWeb";
        $modulo = "generarToken";
        $function = "generarToken";
        $operation = "generarToken";
        //Construccion de log de acceso
        $logAcceso = np_hoplite_log($session, $user, $canal, $modulo, $function, $operation);

        //parametros para la solicitud de token
        $idUser = $this->session->userdata('idUsuario');
        $pais = $this->session->userdata('pais');

        $data = json_encode(array(
            "idOperation" => "113",
            "className" => "com.novo.objects.TOs.TarjetaTO",
            "id_ext_per" => $idUser,
            "accodUsuario" => $user,
            "logAccesoObject"=>$logAcceso,
            "token" => $token,
            "pais" => $pais
        ));

        log_message("info", "REQUEST Generacion de Token=====>>>>> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        log_message("info", "RESPONSE Generacion de Token=====>>>>> ".json_encode($desdata));

        /*sleep(2);
        $response = '{"rc":0,"msg":"Proceso OK","bean":"uh4sf2"}';
        $desdata = json_decode($response);*/

        if ($desdata) {
            switch ($desdata->rc){
                case 0:
                    $response = [
                        'code' => 4,
                        'title' => 'Solicitud de token',
                        'msg' => 'Hemos enviado el código de seguridad a su correo'
                    ];
                    break;
                case -173:
                    $response = [
                        'code' => 5,
                        'title' => 'Solicitud de token',
                        'msg' => 'El correo no pudo ser enviado, intente de nuevo.'
                    ];
                    break;
                case -911:
                    $response = [
                        'code' => 3,
                        'title' => 'Servicios',
                        'msg' => 'Su solicitud no pudo ser procesada, intente más tarde.'
                    ];
                    break;
                case -35:
                case -61:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Su sesión ha expirado.'
                    ];
                    $this->session->sess_destroy();
                    break;
                default:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intente más tarde.'
                    ];
                    $this->session->sess_destroy();
            }
        } else {
            $response = [
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intente más tarde.'
            ];
            $this->session->sess_destroy();
        }

        return $response;

    }
    //FIN Solicitud de token

    //Solicitud de recuperar clave
    public function callWsrecoverKey ($dataRequest) {
        //Datos de la cuenta
        parse_str($dataRequest, $dataAccount);
        //log de acceso
        $session = $this->session->userdata("sessionId");
        $user = $this->session->userdata('userName');
        $token = $this->session->userdata("token");
        $canal = "personasWeb";
        $modulo = "reposicionClave";
        $function = "reposicionClave";
        $operation = "reposicionClave";
        //Construccion de log de acceso
        $logAcceso = np_hoplite_log($session, $user, $canal, $modulo, $function, $operation);

        //parametros para la solicitud de bloq y desbloq
        $idOperation = "117";
        $cardNum = $dataAccount['card-rec'];
        $fechaExp = $dataAccount['fecha-exp-rec'];
        $prefix = $dataAccount['prefix-rec'];
        $idUser = $this->session->userdata('idUsuario');
        $pais = $this->session->userdata('pais');

        $data = json_encode(array(
            "idOperation" => $idOperation,
            "className" => "com.novo.objects.TOs.TarjetaTO",
            "noTarjeta" => $cardNum,
            "accodUsuario" => $user,
            "id_ext_per" => $idUser,
            "prefix" => $prefix,
            "fechaExp" => $fechaExp,
            "tokenOperaciones" => '',
            "token" => $token,
            "logAccesoObject"=>$logAcceso,
            "pais" => $pais
        ));

        log_message("info", "REQUEST Recuperación de clave=====>>>>> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS("movilsInterfaceResource",$data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data,1)));

        log_message("info", "RESPONSE Recuperación de clave=====>>>>> ".json_encode($desdata));

        // sleep(2);
        // $response = '{"rc":-899,"msg":"Proceso OK"}';
        // $desdata = json_decode($response);

        //código, título y mensaje para la respuesta a la vista
        $code = '';
        $title = '';
        $msg = '';

        if ($desdata) {
            switch ($desdata->rc) {
                case 0:
                    $code = 0;
                    $title = 'Recuperar de clave';
                    $msg = 'Su clave ha sido recuperada exitosamente, le será enviada en los próximos días.';
                    break;
                case -356:
                    $code = 2;
                    $title = 'Recuperar de clave';
                    $msg = 'La tarjeta tiene una recuperación de clave pendiente, le será enviada en los próximos días.';
                    break;
                case -264:
                case -304:
                case -911:
                    $code = 3;
                    $title = 'Recuperar de clave';
                    $msg = 'Su solicitud no pudo ser procesada, intente más tarde.';
                    break;
                case -35:
                case -61:
                    $code = 7;
                    $title = 'Conexión Personas Online';
                    $msg = ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Su sesión ha expirado.';
                    break;
                default:
                    $code = 7;
                    $title = 'Conexión Personas Online';
                    $msg = 'Hubo un problema. Por favor intente más tarde.';

            }
        } else {
            $code = 7;
            $title = 'Conexión Personas Online';
            $msg = 'Ha ocurrido un error en el sistema. Por favor intente más tarde.';
        }

        if ($code === 7){
            $this->session->sess_destroy();
            $this->session->unset_userdata($this->session->all_userdata());
        }
        $response = [
            'code' => $code,
            'title' => $title,
            'msg' => $msg
        ];
        return $response;

    }
    //fin Solicitud recuperar clave



} // FIN
