<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    // FUNCION PARA HACER LOGIN
    public function login_user($username, $password)
    {
        $logAcceso = np_hoplite_log('', $username, 'personasWeb', 'login', 'login', 'Login');

        $data = json_encode(array(
            'idOperation' => '1',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $username,
            'password' => $password,
            'logAccesoObject' => $logAcceso,
            'token' => ''
				));

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));
				$salida = json_encode($desdata);
				$code = $desdata->rc;
				$title = '';
				$msg = '';

				log_message('INFO', '[' . $username . '] Salida login usuario:==>> ' . $salida);

				if($desdata) {
					$skin = $this->input->cookie($this->config->item('cookie_prefix') . 'skin');
					if ($skin == 'latodo') {
						$recoverPwd = $this->config->item('base_url') . '/users/recoveryPassword_pe';
					} else {
						$recoverPwd = $this->config->item('base_url') . '/users/recoveryPassword';
					}
					switch($desdata->rc) {
						case 0:
							if($desdata->codPais == 'Ve' && base_url() == 'https://online.novopayment.net/personas/') {
								$code = 1;

							} else {
								$newdata = [
									'idUsuario' => $desdata->idUsuario,
									'userName' => $desdata->userName,
									'idPersona' => $desdata->idPersona,
									'nombreCompleto' => strtolower(substr($desdata->primerNombre, 0, 18)) . ' ' . strtolower(substr($desdata->primerApellido, 0, 18)),
									'cantCorreos' => $desdata->cantCorreos,
									'token' => $desdata->token,
									'sessionId' => $desdata->logAccesoObject->sessionId,
									'keyId' => $desdata->keyUpdate,
									'logged_in' => true,
									'pais' => $desdata->codPais,
									'aplicaTransferencia' => $desdata->aplicaTransferencia,
									'passwordOperaciones' => $desdata->passwordOperaciones,
									'cl_addr' => np_Hoplite_Encryption($_SERVER['REMOTE_ADDR'], 0),
									'afiliado' => $desdata->afiliado,
									'aplicaPerfil' => $desdata->aplicaPerfil
								];
							$this->session->set_userdata($newdata);
							}
							break;
						case -185:
						case -381:
							$dataUser = json_decode($desdata->bean);
							$temporary = [
								'nickName' => $dataUser->userName,
								'country' => $dataUser->codPais
							];
							$this->session->set_userdata($temporary);
							break;
						case -1:
							$title = 'Acceso denegado';
							$msg = 'Usuario o Contraseña <strong>inválido</strong>. Por favor <strong>verifica</strong> tus datos, e intenta nuevamente.';
							break;
						case -8:
						case -35:
							$title = 'Acceso denegado';
							$msg = 'Usuario bloqueado. Para desbloquearlo, por favor <a href="' . $recoverPwd . '" rel="section">recupera tu contraseña</a>';
							break;
						case -194:
							$title = 'Contraseña temporal';
							$msg = '¡La contraseña temporal <strong>ha caducado</strong>! <br>Por favor <a href="' . $recoverPwd . '" rel="section">recupera tu contraseña</a> para restaurarla. <br>Recuerda cambiarla en un plazo menor a 24 horas';
							break;
						default:
							$title = 'Conexión Personas Online';
							$msg = 'En estos momentos no podemos atender tu solicitud, por favor <strong>intenta más tarde.</strong>';
					}

				} else {
					$code = '';
					$title = 'Conexión Personas Online';
					$msg = 'En estos momentos no podemos atender tu solicitud, por favor <strong>intenta más tarde.</strong>';
				}
				$response = [
					'code' => $code,
					'title' => $title,
					'msg' => $msg
				];

        return json_encode($response);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //RECUPERAR LOGIN
    public function obtener_login($id_ext_per, $email)
    {
        $logAcceso = np_hoplite_log('', '', 'personasWeb', 'obtener login', 'obtener login', 'obtener login');

        $id_ext_per = base64_decode($id_ext_per);
        $email = base64_decode($email);

        $data = json_encode(array(
            'idOperation'  => '24',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'id_ext_per' => $id_ext_per,
            'email' => $email,
            'logAccesoObject' => $logAcceso,
            'token' => ''
        ));

        log_message('info', 'Salida: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        log_message('info', 'Salida encriptada obtener_login: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //RESETEAR PASSWORD
    public function reset_password($id_ext_per, $email)
    {
        $logAcceso = np_hoplite_log('','','personasWeb','reset password','reset password','reset password');

        $id_ext_per = base64_decode($id_ext_per);
        $email = base64_decode($email);

        $data = json_encode(array(
            'idOperation' => '23',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'id_ext_per' => $id_ext_per,
            'email' => $email,
            'logAccesoObject' => $logAcceso,
            'token' => ''
        ));

        log_message('info', 'Salida : '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 0);
        $data = json_encode(array('data' => $dataEncry, 'pais' => 'Global', 'keyId' => 'CPONLINE'));
        log_message('info', 'Salida encriptada reset_password: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 0)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD
    public function actualizar_password($passwordOld, $passwordNew, $temporary)
    {
			$pais = $this->session->userdata('pais') ? $this->session->userdata('pais')
							: $this->session->userdata('country');
			$user = $this->session->userdata('userName') ? $this->session->userdata('userName')
							: $this->session->userdata('nickName');
			$keyId = $this->session->userdata('userName') ? $this->session->userdata('userName')
							: 'CPONLINE';
			$sessionId = $this->session->userdata('sessionId') ? $this->session->userdata('sessionId')
									: '';
			$token = $this->session->userdata('token') ? $this->session->userdata('token') : '';
			$keyIdEncript = $this->session->userdata('keyId') ? 1 : 0;

			$logAcceso = np_hoplite_log($sessionId, $user, 'personasWeb', 'password', 'password', 'actualizar');

			$data = json_encode([
				'idOperation' => '25',
				'className' => 'com.novo.objects.TOs.UsuarioTO',
				'userName' => $user,
				'passwordOld' => $passwordOld,
				'password' => $passwordNew,
				'logAccesoObject' => $logAcceso,
				'token' => $token
			]);

			log_message('info', 'Request actualizar password:====>>>>' . $data);

			$dataEncry = np_Hoplite_Encryption($data, $keyIdEncript);
			$data = json_encode(array('data' => $dataEncry, 'pais' => $pais, 'keyId' => $keyId));
			$response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
			$data = json_decode(utf8_encode($response));
			$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, $keyIdEncript)));
			$code = $desdata->rc;
			$title = '';
			$msg = '';
			$alert = '';
			$action = false;

			log_message('info', 'Response actualizar password:====>>>>>' . json_encode($desdata));

			switch($desdata->rc) {
				case 0:
					$sessionTemp = ['nickName', 'country'];
					$this->session->unset_userdata($sessionTemp);
					$title = 'Cambio de Contraseña';
					$msg = 'La contraseña ha sido actualizada <b>exitosamente.</b> ';
					$temporary !== 'n' ? $msg.= 'Ya puedes ingresar a Conexión Personas': '';

					$alert = 'alert-success';
					$action = true;
					break;
				case -192:
					$title = 'Cambio de Contraseña';
					$msg = 'La <b>contraseña actual</b> es incorrecta. Por favor verificala e intenta de nuevo.';
					$alert = 'alert-warning';
					break;
				case -205:
					$title = 'Cambio de Contraseña';
					$msg = 'El usuario no está registrado, verifica tus datos e intenta de nuevo';
					$alert = 'alert-warning';
					break;
				default:
					$title = 'Conexión Personas Online';
					$msg = 'En estos momentos no podemos atender tu solicitud, por favor <strong>intenta más tarde.</strong>';
					$alert = 'alert-error';
					$action = true;
			}

			$response = [
				'code' => $code,
				'title' => $title,
				'msg' => $msg,
				'alert' => $alert,
				'action' => $action
			];

			return json_encode($response);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CREAR PASSWORD DE OPERACIONES
    public function password_operaciones($passwordOperaciones)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'password op', 'password op', 'crear');

        $data = json_encode(array(
            'idOperation' => '31',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'passwordOperaciones' => md5($passwordOperaciones),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Crear: '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //CREAR PASSWORD sms
    public function password_sms_crear($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','registrar clave');

        $data = json_encode(array(
            'idOperation' => '42',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Crear SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId'=> $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD sms
    public function password_sms_actualizar($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','actualizar clave');

        $data = json_encode(array(
            'idOperation' => '43',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Actualizar SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ELIMINAR PASSWORD sms
    public function password_sms_eliminar($id_ext_per, $claveSMS, $nroMovil)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','perfil','clave sms','eliminar clave');

        $data = json_encode(array(
            'idOperation' => '44',
            'className' => 'com.novo.objects.TOs.TarjetaTO',
            'id_ext_per' => $id_ext_per,
            'claveSMS' => $claveSMS,
            'nroMovil' => $nroMovil,
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')

        ));

        log_message('info', 'Salida ELIMINAR SMS: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));

        return json_encode($desdata);
    }
    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //ACTUALIZAR PASSWORD DE OPERACIONES
    public function actualizar_password_operaciones($passwordOperacionesOld, $passwordOperaciones)
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'),$this->session->userdata('userName'),'personasWeb','password operaciones','password operaciones','actualizar');

        $data = json_encode(array(
            'idOperation' => '32',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'passwordOperacionesOld' => md5($passwordOperacionesOld),
            'passwordOperaciones' => md5($passwordOperaciones),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Salida Actualizar: ' . $data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada actualizar_password_operaciones: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        $desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));
        $salida = json_encode($desdata);

        log_message('info', 'Salida password_operaciones: ' . $salida);

        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    //FUNCION PARA CERRAR SESION
    public function logout()
    {
        $logAcceso = np_hoplite_log($this->session->userdata('sessionId'), $this->session->userdata('userName'), 'personasWeb', 'logout', 'logout', 'logout');

        $data = json_encode(array(
            'idOperation' => 'desconectarUsuario',
            'className' => 'com.novo.objects.TOs.UsuarioTO',
            'userName' => $this->session->userdata('userName'),
            'logAccesoObject' => $logAcceso,
            'token' => $this->session->userdata('token')
        ));

        log_message('info', 'Logout: '.$data);

        $dataEncry = np_Hoplite_Encryption($data, 1);
        $data = json_encode(array('data' => $dataEncry, 'pais' => $this->session->userdata('pais'), 'keyId' => $this->session->userdata('userName')));
        log_message('info', 'Salida encriptada logout: ' . $data);
        $response = np_Hoplite_GetWS('movilsInterfaceResource', $data);
        $data = json_decode(utf8_encode($response));
        log_message('info', 'Before Logout:----------->>>>>>>>> '.$response);
				$desdata = json_decode(utf8_encode(np_Hoplite_Decrypt($data->data, 1)));
				log_message('INFO', 'RESPONSE LOGOUT======>>>>>>>>' . json_encode($desdata));


        return json_encode($desdata);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


}	//FIN FUNCION GENERAL
