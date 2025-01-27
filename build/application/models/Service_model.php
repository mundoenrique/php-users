<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
				$this->lang->load('format');

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
        $cardNum = base64_decode($dataAccount['card-bloq']);
        $fechaExp = $dataAccount['fecha-exp-bloq'];
        $action = ($dataAccount['status'] == 'N') ? 'PB' : '00';
        $action = ($lockType == 'temporary') ? $action : $permanentLock;
        $prefix = $dataAccount['prefix-bloq'];
        $idUser = $this->session->userdata('idUsuario');
        $pais = $this->session->userdata('pais');
        $msgLok = ($action == '00') ? 'desbloqueada' : 'bloqueada';
        $msgLok = ($lockType == 'temporary') ? $msgLok : 'bloqueada';
				$montoComisionTransaccion = $dataAccount['montoComisionTransaccion'];

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
            "pais" => $pais,
						"montoComisionTransaccion" => $montoComisionTransaccion
        ));

        log_message("info", "REQUEST Bloqueo desbloqueo=====>>>>> ".$data);

        $dataEncry = np_Hoplite_Encryption($data,1,'callWsLockAccount');
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS($data);
        $data = json_decode($response);
        $desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'callWsLockAccount'));

        log_message("info", "RESPONSE Bloqueo desbloqueo=====>>>>> ".json_encode($desdata));

        if ($desdata) {
            switch ($desdata->rc) {
                case 0:

										//para operaciones con costo, muestra el saldo actual
										$saldo = "";
										$desdatacosto = json_decode($desdata->bean);
										if(isset($desdatacosto->disponible))
										{
											$saldo = ". Su saldo actual es ".lang('MONEDA').$desdatacosto->disponible;
										}
                    $response = [
                        'code' => 0,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => ($lockType == 'temporary') ? 'La cuenta ha sido <strong>'. $msgLok . '</strong> exitosamente' : 'Tu tarjeta será enviada en los próximos días'.$saldo,
                    ];

                    break;
                case -241:
                    $response = [
                        'code' => 1,
                        'title' => ($lockType == 'temporary') ? 'Bloqueo o Desbloqueo de cuenta' : 'Reposición de tarjeta',
                        'msg' => 'Los campos introducidos son inválidos, verifica e intenta nuevamente.'
                    ];
                    break;
                case -286:
                    if($desdata->rc == -286) {
                        $msg = 'El código de seguridad introducido es inválido, verifica e intenta nuevamente.';
                    }
                case -287:
                    if($desdata->rc == -287) {
                        $msg = 'El código de seguridad introducido ya fue usado, verifica e intenta nuevamente.';
                    }
                case -288:
                    if($desdata->rc == -288) {
                        $msg = 'El código de seguridad introducido ha expirado, solicítalo nuevamente.';
                    }
                case -301:
                    if($desdata->rc == -301) {
                        $msg = 'El código de seguridad introducido es inválido, verifica e intenta nuevamente.';
                    }
                case -310:
                    if($desdata->rc == -310) {
                        $msg = 'La fecha de expiración introducida es inválida, verifica e intenta de nuevo.';
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
                        'msg' => 'La tarjeta no pudo ser <strong>'. $msgLok . '</strong>, intenta nuevamente.'
                    ];
                    break;
                case -395:
                    $response = [
                        'code' => 2,
                        'title' => 'Reposición de tarjeta',
                        'msg' => 'La tarjeta tiene una reposición pendiente, comunícate con el centro de contacto.'
                    ];
                    break;
								case -396:
                    $response = [
                        'code' => 2,
                        'title' => 'Reposición de tarjeta',
                        'msg' => 'La tarjeta tiene una renovación pendiente, comunícate con el centro de contacto.'
                    ];
                    break;
                case -306: //Bloqueo por reposición, si viene o no viene solo peru por el momento, valor del bloqueo
										$desdatacosto = json_decode($desdata->bean);
										$cost_repos_plas = (isset($desdatacosto->cost_repos_plas) && $desdatacosto->cost_repos_plas != '') ? $desdatacosto->cost_repos_plas : NULL;
                    $response = $this->callWsGetToken($cost_repos_plas);
                    break;

								case -382: //Reposición con costo sin token

									$desdatacosto = json_decode($desdata->bean);
									if((isset($desdatacosto->cost_repos_plas) && $desdatacosto->cost_repos_plas != '')) {

										$cost_repos_plas = $desdatacosto->cost_repos_plas;
										$response = [
												'code' => 6,
												'title' => 'Solicitud Reposición',
												'msg' => 'Costo de la transacción',
												'cost_repos_plas' => $cost_repos_plas,
										];
									}
									else {
										$response = [
				                'title' => 'Conexión Personas Online',
				                'msg' => 'Ha ocurrido un error en el sistema. Por favor intenta más tarde.'
				            ];
									}

                  break;

								case -114:
										$response = [
												'code' => 3,
												'title' => 'Conexión Personas Online',
												'msg' => 'No se pudo realizar la reposición de tu tarjeta. Favor intente nuevamente.'
										];
									break;

                case -125:
                case -304:
                case -911:
                    $response = [
                        'code' => 3,
                        'title' => 'Servicios',
                        'msg' => ($desdata->rc == -125) ? 'No es posible realizar esta acción, la tarjeta está vencida' :'Tu solicitud no pudo ser procesada, intente más tarde.'
                    ];
                    break;
                case -35:
                case -61:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Tu sesión ha expirado.'
                    ];
                    $this->session->sess_destroy();
                    break;

								//Manejo de errores - se incluye error por falta de saldo
								case -322:
								case -21:
									$response = [
											'code' => 3,
											'title' => 'Solicitud de reposición',
											'msg' => 'Tu solicitud no puede ser procesada por este canal, comunícate al Centro de Contacto Tebca'
									];

									break;

                default:
                    $response = [
                        'code' => 3,
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intenta más tarde.'
                    ];
            }
        } else {
            $response = [
                'code' => 3,
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intenta más tarde.'
            ];
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
        $cardNum = base64_decode($dataAccount['card-cambio']);
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

        $dataEncry = np_Hoplite_Encryption($data,1,'callWschangePin');
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS($data);
        $data = json_decode($response);
        $desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'callWschangePin'));

        log_message("info", "RESPONSE Cambio de PIN=====>>>>> ".json_encode($desdata));

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
                        'msg' => 'El PIN actual no es válido, verifica e intenta nuevamente.'
                    ];
                    break;
                case -241:
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => 'Los campos introducidos son inválidos, verifica  e intenta nuevamente.'
                    ];
                    break;
                case -345:
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => 'Has superado la cantidad de intentos fallidos por el dia de hoy. Por favor intenta mañana.'
                    ];
										break;
								case -401:
                    $response = [
                        'code' => 1,
                        'title' => 'Cambio de PIN',
                        'msg' => 'No fue posible cambiar el PIN de tu tarjeta, intenta en unos minutos.'
                    ];
										break;
                case -286:
                        if($desdata->rc == -286) {
                            $msg = 'El código de seguridad introducido es inválido, verifica e intenta nuevamente.';
                        }
                case -287:
                        if($desdata->rc == -287) {
                            $msg = 'El código de seguridad introducido ya fue usado, verifica e intenta nuevamente.';
                        }
                case -288:
                        if($desdata->rc == -288) {
                            $msg = 'El código de seguridad introducido ha expirado, solicítalo nuevamente.';
                        }
                case -301:
                        if($desdata->rc == -301) {
                            $msg = 'El código de seguridad introducido es inválido, verifica e intenta nuevamente.';
                        }
                case -310:
                        if($desdata->rc == -310) {
                            $msg = 'La fecha de expiración introducida es inválida, verifica e intenta de nuevo.';
                        }
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
                        'msg' => ($desdata->rc == -125) ? 'No es posible realizar esta acción, la tarjeta está vencida' :'Tu solicitud no pudo ser procesada, intente más tarde.'
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
                        'code' => 3,
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intente más tarde.'
                    ];
            }
        } else {
            $response = [
                'code' => 3,
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intente más tarde.'
            ];
        }

        return $response;

    }
    //Fin solicitud de cambio de PIN
    // -----------------------------------------------------------------------------------------------------------------

    //Solicitud de Token
    public function callWsGetToken($cost_repos_plas=NULL)
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

        $dataEncry = np_Hoplite_Encryption($data,1,'callWsGetToken');
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS($data);
        $data = json_decode($response);
        $desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'callWsGetToken'));

        log_message("info", "RESPONSE Generacion de Token=====>>>>> ".json_encode($desdata));

        if ($desdata) {
            switch ($desdata->rc){
                case 0:

										$response = [
												'code' => 4,
												'title' => 'Solicitud de token',
												'msg' => 'Hemos enviado el código de seguridad a tu correo'
										];

										//Si hay costo de reposición, se agreaga en la respuesta
                    if($cost_repos_plas != NULL){
											$response = [
	                        'code' => 4,
	                        'title' => 'Solicitud de token',
	                        'msg' => 'Hemos enviado el código de seguridad a tu correo',
													'cost_repos_plas' => $cost_repos_plas
	                    ];
										}

                    break;
                case -173:
                    $response = [
                        'code' => 5,
                        'title' => 'Solicitud de token',
                        'msg' => 'El correo no pudo ser enviado, intenta de nuevo.'
                    ];
                    break;
                case -911:
                    $response = [
                        'code' => 3,
                        'title' => 'Servicios',
                        'msg' => 'Tu solicitud no pudo ser procesada, intenta más tarde.'
                    ];
                    break;
                case -35:
                case -61:
                    $response = [
                        'title' => 'Conexión Personas Online',
                        'msg' => ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Tu sesión ha expirado.'
                    ];
                    $this->session->sess_destroy();
                    break;
                default:
                    $response = [
                        'code' => 3,
                        'title' => 'Conexión Personas Online',
                        'msg' => 'Hubo un problema. Por favor intenta más tarde.'
                    ];
            }
        } else {
            $response = [
                'code' => 3,
                'title' => 'Conexión Personas Online',
                'msg' => 'Ha ocurrido un error en el sistema. Por favor intenta más tarde.'
            ];
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
        $cardNum = base64_decode($dataAccount['card-rec']);
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

        $dataEncry = np_Hoplite_Encryption($data,1,'callWsrecoverKey');
        $data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId'=> $user));
        $response = np_Hoplite_GetWS($data);
        $data = json_decode($response);
        $desdata = json_decode(np_Hoplite_Decrypt($data->data,1,'callWsrecoverKey'));

        log_message("info", "RESPONSE Recuperación de clave=====>>>>> ".json_encode($desdata));

        //código, título y mensaje para la respuesta a la vista
        $code = '';
        $title = '';
        $msg = '';

        if ($desdata) {
            switch ($desdata->rc) {
                case 0:
                    $code = 0;
                    $title = 'Reposición de PIN';
                    $msg = 'Solicitud procesada exitosamente. El PIN será enviado en sobre de seguridad a la dirección de la empresa en un máximo de 5 días hábiles.';
                    break;
                case -356:
                    $code = 2;
                    $title = 'Reposición de PIN';
                    $msg = 'Tu tarjeta ya posee una solicitud pendiente de reposición de PIN, que será enviado a la dirección de la empresa en los próximos días.';
                    break;
                case -264:
                case -304:
                case -911:
                    $code = 3;
                    $title = 'Reposición de PIN';
                    $msg = 'Tu solicitud no pudo ser procesada, intenta más tarde.';
                    break;
                case -35:
                case -61:
                    $code = 7;
                    $title = 'Conexión Personas Online';
                    $msg = ($desdata->rc == -35) ? 'El usuario se encuentra suspendido.'  : 'Tu sesión ha expirado.';
                    break;
								case -395:
										$code = 3;
										$title = 'Reposición de tarjeta';
										$msg = 'La tarjeta tiene una reposición pendiente, comunícate con el centro de contacto.';
                    break;
								case -396:
										$code = 3;
										$title = 'Reposición de tarjeta';
										$msg = 'La tarjeta tiene una renovación pendiente, comunícate con el centro de contacto.';
                    break;
                default:
                    $code = 3;
                    $title = 'Conexión Personas Online';
                    $msg = 'Se ha presentado un problema en la gestión de tu solicitud. Por favor inténtelo nuevamente más tarde.';

            }
        } else {
            $code = 3;
            $title = 'Conexión Personas Online';
            $msg = 'Ha ocurrido un error en el sistema. Por favor intenta más tarde.';
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
