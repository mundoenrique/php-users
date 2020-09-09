<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información de las tarjetas del usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 14th, 2020
 */
class Novo_User_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}
	/**
	 * @info Método para el inicio de sesión
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 14th, 2020
	 */
	public function callWs_Signin_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Signin Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Ingreso al sistema';
		$this->dataAccessLog->operation = 'Iniciar sesion';
		$userName = mb_strtoupper($dataRequest->userName);
		$this->dataAccessLog->userName = $userName;

		$password = json_decode(base64_decode($dataRequest->userPass));
		$password = $this->cryptography->decrypt(
			base64_decode($password->plot),
			utf8_encode($password->password)
		);

		$argon2 = $this->encrypt_connect->generateArgon2($password);

		$this->dataRequest->idOperation = '1';
		$this->dataRequest->userName = $userName;
		$this->dataRequest->pais = 'Global';
		$this->dataRequest->password = md5($password);//BORRAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->password = $argon2->hexArgon2;//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->hashMD5 = md5($password);//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS

		if(ACTIVE_RECAPTCHA) {
			$this->isResponseRc = $this->callWs_ValidateCaptcha_User($dataRequest);

			if ($this->isResponseRc === 0) {
				$response = $this->sendToService('callWs_Signin');
			}
		} else {
			$response = $this->sendToService('callWs_Signin');
		}

		$time = (object) [
			'customerTime' => (int) $dataRequest->currentTime,
			'serverTime' => (int) date("H")
		];

		switch($this->isResponseRc) {
			case 0:
				if ($this->validateUserLogged($userName)) {
					$this->response->title = lang('GEN_SYSTEM_NAME');
					$this->response->icon = lang('GEN_ICON_WARNING');
					$this->response->msg = lang('USER_SIGNIN_INCORRECTLY_CLOSED');
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('GEN_BTN_ACCEPT'),
							'link'=> 'inicio',
							'action'=> 'close'
						]
					];
				} else {
					$this->response->code = 0;
					$this->response->data = base_url(lang('GEN_LINK_CARDS_LIST'));
					$fullSignin = TRUE;
					$fullName = mb_strtolower($response->primerNombre).' ';
					$fullName.= mb_strtolower($response->primerApellido);
					$formatDate = $this->config->item('format_date');
					$formatTime = $this->config->item('format_time');
					$lastSession = date(
						"$formatDate $formatTime", strtotime(
							str_replace('/', '-', $response->fechaUltimaConexion)
						)
					);
					$userData = [
						'logged' => TRUE,
						'encryptKey' => $response->keyUpdate,
						'sessionId' => $response->logAccesoObject->sessionId,
						'userId' => $response->idUsuario,
						'userName' => $response->userName,
						'fullName' => ucwords(mb_strtolower($fullName)),
						'lastSession' => $lastSession,
						'token' => $response->token,
						'client' => $this->config->item('client'),
						'time' => $time,
						'cl_addr' => $this->encrypt_connect->encode($this->input->ip_address(), $userName, 'REMOTE_ADDR'),
						'countrySess' => $response->codPais,
						'countryUri' => $this->config->item('country-uri'),
						'canTransfer' => $response->aplicaTransferencia,
						'operKey' => $response->passwordOperaciones,
						'affiliate' => $response->afiliado,
						'longProfile' => $response->aplicaPerfil,
						'terms' => $response->tyc,
						'mobilePhone' => $response->celular ?? '',
						'clientAgent' => $this->agent->agent_string()
					];
					$this->session->set_userdata($userData);

					$data = ['username' => $userName];
					$this->db->where('id', $this->session->session_id)
					->update('cpo_sessions', $data);

					if ($response->passwordTemp == '1') {
						$fullSignin = FALSE;
						$this->session->set_flashdata('changePassword', 'TemporalPass');
					}

					if ($response->passwordVencido == '1') {
						$fullSignin = FALSE;
						$this->session->set_flashdata('changePassword', 'expiredPass');
					}

					if (!$fullSignin) {
						$this->session->unset_userdata('logged');
						$this->response->data = base_url(lang('GEN_LINK_CHANGE_PASS'));
					}
				}
				break;
			case -1:
			case -205:
				$this->response->code = 1;
				$this->response->msg = lang('USER_SIGNIN_INVALID_USER');
				$this->response->className = lang('CONF_VALID_INVALID_USER');
				$this->response->position = lang('CONF_VALID_POSITION');
				if (isset($response->bean->intentos) && $response->bean->intentos == 2) {
					$this->response->msg = lang('USER_SIGNIN_WILL_BLOKED');
					$this->response->className = lang('CONF_VALID_INVALID_USER');
					$this->response->position = lang('CONF_VALID_POSITION');
				}
				break;
			case -194:
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('GEN_ICON_INFO');
				$this->response->msg = novoLang(lang('USER_SIGNIN_PASS_EXPIRED'), base_url('recuperar-acceso'));
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_ACCEPT'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				$this->session->set_flashdata('recoverAccess', 'temporalPass');
				break;
			case -8:
			case -35:
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('GEN_ICON_WARNING');
				$this->response->msg = novoLang(lang('USER_SIGNIN_SUSPENDED_USER'), base_url('recuperar-acceso'));
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_ACCEPT'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				$this->session->set_flashdata('recoverAccess', 'blockedPass');
				break;
			case 9999:
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('GEN_ICON_DANGER');
				$this->response->msg = lang('USER_SIGNIN_RECAPTCHA_VALIDATE');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_ACCEPT'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				break;
				default:
				if ($this->isResponseRc != -61) {
					$this->session->sess_destroy();
				}

		}

		return $this->responseToTheView('callWs_Signin');
	}
	/**
	 * @info Método para validar si el usuariio esta logueado
	 * @author J. Enrique Peñaloza Piñero
	 * @date April 29th, 2020
	 */
	private function validateUserLogged($userName)
	{
		log_message('INFO', 'NOVO User Model: validateUserLogged Method Initialized');
		$logged = FALSE;

		$this->db->select(['id', 'username'])
		->where('username',  $userName)
		->get_compiled_select('cpo_sessions', FALSE);

		$result = $this->db->get()->result_array();

		if (count($result) > 0) {
			$this->db->where('id', $result[0]['id'])
			->delete('cpo_sessions');
			$logged = TRUE;
		}

		return $logged;
	}
	/**
	 * @info Método para recuperar contraseña o usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 24th, 2020
	 */
	public function callWs_AccessRecover_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: AccessRecover Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Recuperar acceso';
		$this->dataAccessLog->operation = 'Obtener usuario o clave temporal';
		$this->dataAccessLog->userName = $dataRequest->email;;

		$this->dataRequest->idOperation = isset($dataRequest->recoveryPwd) ? '23' : '24';
		$this->dataRequest->id_ext_per = $dataRequest->idNumber;
		$this->dataRequest->email = $dataRequest->email;
		$this->dataRequest->pais = 'Global';
		$maskMail = maskString($dataRequest->email, 4, $end = 6, '@');
		$msgGeneral = '0';

		$response = $this->sendToService('callWs_AccessRecover');

		switch($this->isResponseRc) {
			case 0:
				$recover = isset($dataRequest->recoveryPwd) ? lang('USER_RECOVER_PASS_TEMP') : lang('USER_RECOVER_USERNAME');
				$this->response->msg = novoLang(lang('USER_RECOVER_SUCCESS'),  [$maskMail, $recover]);
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_CONTINUE'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				break;
			case -186:
			case -187:
				$msgGeneral = '1';
				$this->response->msg = LANG('USER_RECOVER_DATA_INVALID');
				break;
		}

		if($this->isResponseRc != 0 && $msgGeneral == '1') {
			$this->response->title = lang('GEN_MENU_ACCESS_RECOVER');
			$this->response->icon = lang('GEN_ICON_INFO');
			$this->response->data = [
				'btn1'=> [
					'action'=> 'close'
				]
			];
		}

		return $this->responseToTheView('callWs_AccessRecover');
	}
	/**
	 * @info Método para el cambio de Contraseña
	 * @author J. Enrique Peñaloza Piñero
	 * @date April 22th, 2020
	 */
	public function CallWs_ChangePassword_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: ChangePassword Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Clave';
		$this->dataAccessLog->operation = 'Cambiar Clave';

		$current = json_decode(base64_decode($dataRequest->currentPass));
		$current = $this->cryptography->decrypt(
			base64_decode($current->plot),
			utf8_encode($current->password)
		);
		$new = json_decode(base64_decode($dataRequest->newPass));
		$new = $this->cryptography->decrypt(
			base64_decode($new->plot),
			utf8_encode($new->password)
		);

		$argon2 = $this->encrypt_connect->generateArgon2($new);

		$this->dataRequest->idOperation = '25';
		$this->dataRequest->userName = $this->userName;
		$this->dataRequest->passwordOld = md5($current);
		$this->dataRequest->password = md5($new);
		$this->dataRequest->passwordOld4 = md5(strtoupper($new));
		//$this->dataRequest->password = $argon2->hexArgon2;//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->hashMD5 = md5($new);//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS

		$changePassType = $this->session->flashdata('changePassword');
		$this->sendToService('CallWs_ChangePassword');
		//$code = 0;

		switch($this->isResponseRc) {
			case 0:
				if($this->session->has_userdata('userId')) {
					$this->callWs_FinishSession_User();
				}

				$this->response->code = 4;
				$goLogin = $this->session->has_userdata('logged') ? '' : lang('USER_PASS_LOGIN');
				$this->response->msg = novoLang(lang('USER_PASS_CHANGED'), $goLogin);
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_CONTINUE'),
						'link'=> $this->session->has_userdata('logged') ? lang('GEN_LINK_CARDS_LIST') : 'inicio',
						'action'=> 'redirect'
					]
				];
				break;
			case -4:
				$code = 1;
				$this->response->msg = lang('USER_PASS_USED');
				break;
			case -192:
				$code = 1;
				$this->response->msg = lang('USER_PASS_INCORRECT');
				break;
			break;
			default:
			if ($this->isResponseRc != -61) {
				$this->session->sess_destroy();
			}
		}

		if($this->isResponseRc != 0 && $code == 1) {
			$this->session->set_flashdata('changePassword', $changePassType);

			$this->response->title = lang('GEN_PASSWORD_CHANGE_TITLE');
			$this->response->icon = lang('GEN_ICON_WARNING');
			$this->response->data = [
				'btn1'=> [
					'action'=> 'close'
				]
			];
		}
		return $this->responseToTheView('CallWs_ChangePassword');
	}
	/**
	 * @info Método identificar al usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date jun 10th, 2020
	 */
	public function CallWs_UserIdentify_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: UserIdentify Method Initialized');

		$this->className = 'com.novo.objects.TOs.CuentaTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Identificar usuario';
		$this->dataAccessLog->operation = 'validar datos de registro';
		$this->dataAccessLog->userName = $dataRequest->docmentId.date('dmy');

		$this->dataRequest->idOperation = '18';
		$this->dataRequest->cuenta = $dataRequest->numberCard;
		$this->dataRequest->id_ext_per = $dataRequest->docmentId;
		$this->dataRequest->pin = $dataRequest->cardPIN ?? '1234';
		$this->dataRequest->claveWeb = isset($dataRequest->cardPIN) ? md5($dataRequest->cardPIN) : md5('1234');
		$this->dataRequest->pais = $dataRequest->client ?? $this->country;

		$response = $this->sendToService('CallWs_UserIdentify');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$userData = new stdClass();

				$userData->idType = $response->user->tipo_id_ext_per ?? '';
				$userData->idnumber = $response->user->id_ext_per ?? '';
				$userData->idEnterprise = $response->user->id_ext_emp ?? '';
				$userData->firstName = $response->user->primerNombre ?? '';
				$userData->lastName = $response->user->primerApellido ?? '';
				$userData->middleName = $response->user->segundoNombre ?? '';
				$userData->surName = $response->user->segundoApellido ?? '';
				$userData->birthDate = $response->user->fechaNacimiento ?? '';
				$userData->email = $response->user->email ?? '';
				$userData->landLine = $response->user->telefono ?? '';
				$userData->mobilePhone = $response->user->celular ?? '';
				$userData->longProfile = $response->user->aplicaPerfil ?? '';

				$this->response->data['signUpData'] = $userData;
				$this->response->data['affiliation'] = $response->afiliacion;

				$userSess = [
					'userIdentity' => TRUE,
					'encryptKey' => $response->keyUpdate,
					'sessionId' => $response->logAccesoObject->sessionId,
					'userId' => $dataRequest->docmentId,
					'userName' => $response->logAccesoObject->userName,
					'docmentId' => $dataRequest->docmentId,
					'token' => $response->token,
					'cl_addr' => $this->encrypt_connect->encode($this->input->ip_address(), $dataRequest->docmentId, 'REMOTE_ADDR'),
					'countrySess' => $dataRequest->client ?? $this->country,
					'clientAgent' => $this->agent->agent_string()
				];
				$this->session->set_userdata($userSess);
			break;
			case -21:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = 'No fue posible validar tus datos, por favor vuelve a intentarlo';
				$this->response->data['btn1']['action'] = 'close';
			break;
			case -183:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = 'El número de tarjeta no es válido o ya fue registrada';
				$this->response->data['btn1']['action'] = 'close';
			break;
			case -184:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = 'Alguno de los datos indicado no es válido';
				$this->response->data['btn1']['action'] = 'close';
			break;
		}

		return $this->responseToTheView('CallWs_UserIdentify');
	}
	/**
	 * @info Método validar la existencia delnombre de usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date jun 10th, 2020
	 */
	public function CallWs_ValidNickName_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: ValidNickName Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Registro';
		$this->dataAccessLog->operation = 'validar nombre de usuario';

		$this->dataRequest->idOperation = '19';
		$this->dataRequest->userName = mb_strtoupper($dataRequest->nickName);

		$response = $this->sendToService('CallWs_ValidNickName');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->session->set_userdata('userNameValid', TRUE);
			break;
			case -193:
				$this->response->code = 1;
				$this->response->msg = lang('VALIDATE_AVAILABLE_NICKNAME');
			break;
		}

		return $this->responseToTheView('CallWs_ValidNickName');

	}
	/**
	 * @info Método para registrar un usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date jun 10th, 2020
	 */
	public function CallWs_SignUpData_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Signup Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Registro';
		$this->dataAccessLog->operation = 'Registrar usuario';

		$password = json_decode(base64_decode($dataRequest->newPass));
		$password = $this->cryptography->decrypt(
			base64_decode($password->plot),
			utf8_encode($password->password)
		);

		$argon2 = $this->encrypt_connect->generateArgon2($password);

		$this->dataRequest->idOperation = '20';
		$this->dataRequest->user = [
			'userName' => mb_strtoupper($dataRequest->nickName),
			'primerNombre' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->firstName)))),
			'segundoNombre' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->middleName)))),
			'primerApellido' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->lastName)))),
			'segundoApellido' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->surName)))),
			'fechaNacimiento' => $dataRequest->birthDate,
			'id_ext_per' => $dataRequest->idNumber,
			'tipo_id_ext_per' => lang('CONF_COUNTRY_CODE')[$this->country],
			'codPais' => $dataRequest->client ?? $this->country,
			'sexo' => $dataRequest->gender,
			'notEmail' => '1',
			'notSms' => '1',
			'email' => $dataRequest->email,
			'password' => md5($password),
			'passwordOld4' => md5(mb_strtoupper($password))
			// 'password' => $argon2->hexArgon2, // DESCOMENTAR Y PROBAR CUANDO SERVICIO ESTE OK
			// 'hashMD5' => md5($password), // DESCOMENTAR Y PROBAR CUANDO SERVICIO ESTE OK
		];
		$this->dataRequest->listaTelefonos = [
			[
				'tipo' => 'HAB',
				'numero' => $dataRequest->landLine
			],
			[
				'tipo' => 'CEL',
				'numero' => $dataRequest->mobilePhone
			],
			[
				'tipo' => $dataRequest->phoneType == '' ? FALSE : $dataRequest->phoneType,
				'numero' => $dataRequest->otherPhoneNum
			]
		];

		$response = $this->sendToService('CallWs_Signup');


		switch ($this->isResponseRc) {
			case 0:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->msg = 'El registro se ha hecho satisfactoriamente, por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña';
				$this->session->sess_destroy();
			break;
			case -181:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('GEN_ICON_INFO');
				$this->response->msg = 'El correo eléctronico que indicas ya se encuentra registrado, por favor intenta con otro';
				$this->response->data['btn1']['action'] = 'close';
			break;
			case -284:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('GEN_ICON_INFO');
				$this->response->msg = 'El telefóno movil que indicas ya se encuentra registrado, por favor intenta con otro';
				$this->response->data['btn1']['action'] = 'close';
			break;
			default:
				$this->session->sess_destroy();
		}

		return $this->responseToTheView('CallWs_Signup');

	}
	/**
	 * @info Método para obtener el perfil del usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date Jun 11th, 2020
	 */
	public function callWs_ProfileUser_User()
	{
		log_message('INFO', 'NOVO User Model: ProfileUser Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Perfil';
		$this->dataAccessLog->operation = 'Datos del usuario';

		$this->dataRequest->idOperation = '30';
		$this->dataRequest->userName = $this->session->userName;

		$response = $this->sendToService('callWs_ProfileUser');
		$phonesList = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
			break;
		}

		$profileData = new stdClass();
		$profileData->nickName = $response->registro->user->userName ?? '';
		$profileData->firstName = $response->registro->user->primerNombre ?? '';
		$profileData->middleName = $response->registro->user->segundoNombre ?? '';
		$profileData->lastName = $response->registro->user->primerApellido ?? '';
		$profileData->surName = $response->registro->user->segundoApellido ?? '';
		$profileData->email = $response->registro->user->email ?? '';
		$profileData->creationDate = $response->registro->user->dtfechorcrea_usu ?? '';
		$profileData->emailNot = $response->registro->user->notEmail ?? '';
		$profileData->smsNot = $response->registro->user->notSms ?? '';
		$profileData->gender = $response->registro->user->sexo ?? '';
		$profileData->idNumber = $response->registro->user->id_ext_per ?? '';
		$profileData->birthday = $response->registro->user->fechaNacimiento ?? '';
		$profileData->professionType = $response->registro->user->tipo_profesion ?? '';
		$profileData->profession = $response->registro->user->profesion ?? '';
		$profileData->idTypeCode = $response->registro->user->tipo_id_ext_per ?? '';
		$profileData->idTypeText = $response->registro->user->descripcion_tipo_id_ext_per ?? '';
		$profileData->smsKey = $response->registro->user->disponeClaveSMS ?? '';
		$profileData->operPass = $response->registro->user->passwordOperaciones ?? '';
		$profileData->longProfile = $response->registro->user->aplicaPerfil ?? '';
		$profileData->addressType = $response->direccion->acTipo ?? '';
		$profileData->addressType = ucfirst(mb_strtolower($profileData->addressType));
		$profileData->address = $response->direccion->acDir ?? '';
		$profileData->postalCode = $response->direccion->acZonaPostal ?? '';
		$profileData->countryCod = $response->direccion->acCodPais ?? '';
		$profileData->country = $response->direccion->acPais ?? '';
		$profileData->departmentCod = $response->direccion->acCodEstado ?? '';
		$profileData->department = $response->direccion->acEstado ?? '';
		$profileData->cityCod = $response->direccion->acCodCiudad ?? '';
		$profileData->city = $response->direccion->acCiudad ?? '';

		$phonesList['otherPhoneNum'] = '';
		$phonesList['landLine'] = '';
		$phonesList['mobilePhone'] = '';
		$phonesList['otherType'] = '';

		if (isset($response->registro->listaTelefonos)) {
			foreach ($response->registro->listaTelefonos AS $phonesType) {
				switch ($phonesType->tipo) {
					case 'FAX':
						$phonesList['otherPhoneNum'] = $phonesType->numero;
						$phonesList['otherType'] = 'FAX';
					break;
					case 'OFC':
						$phonesList['otherPhoneNum'] = $phonesType->numero;
						$phonesList['otherType'] = 'OFC';
					break;
					case 'OTRO':
						$phonesList['otherPhoneNum'] = $phonesType->numero;
						$phonesList['otherType'] = 'OTRO';
					break;
					case 'HAB':
						$phonesList['landLine'] = $phonesType->numero;
					break;
					case 'CEL':
						$phonesList['mobilePhone'] = $phonesType->numero;
					break;
				}
			}
		}

		$this->response->data->profileData = $profileData;
		$this->response->data->phonesList = (object) $phonesList;

		return $this->responseToTheView('callWs_ProfileUser');
	}
	/**
	 * @info Método para actualizar los datos del usuario
	 * @author J. Enrique Peñaloza Piñero
	 * @date August 18th, 2020
	 */
	public function CallWs_UpdateProfile_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: UpdateProfile Method Initialized');

		$this->className = 'com.novo.objects.MO.DatosPerfilMO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Perfil';
		$this->dataAccessLog->operation = 'Actualizar usuario';

		$this->dataRequest->idOperation = '39';
		$this->dataRequest->registro = [
			'user' => [
				'userName' => $this->userName,
				'primerNombre' => $dataRequest->firstName,
				'segundoNombre' => $dataRequest->middleName,
				'primerApellido' => $dataRequest->lastName,
				'segundoApellido' => $dataRequest->surName,
				'email' => $dataRequest->email,
				'dtfechorcrea_usu' => $dataRequest->creationDate,
				'notEmail' => $dataRequest->notEmail,
				'notSms' => $dataRequest->notSms,
				'sexo' => $dataRequest->gender,
				'id_ext_per' => $this->session->userId,
				'fechaNacimiento' => $dataRequest->birthDate,
				'tipo_profesion' => $dataRequest->profession,
				'profesion' => $dataRequest->profession,
				'tipo_id_ext_per' => $dataRequest->idTypeCode,
				'descripcion_tipo_id_ext_per' => $dataRequest->idTypeText,
				'aplicaPerfil' => $this->session->longProfile,
				'tyc' => '1',
				'rc' => '0',
				'passwordOperaciones' => '',
				'disponeClaveSMS' => ''
			],
			'listaTelefonos' => [
				[
					'tipo' => 'HAB',
					'numero' => $dataRequest->landLine,
					'descripcion' => 'HABITACION'
				],
				[
					'tipo' => 'CEL',
					'numero' => $dataRequest->mobilePhone,
					'descripcion' => 'MOVIL',
					'aplicaClaveSMS' => 'No Aplica mensajes SMS'
				],
				[
					'tipo' => $dataRequest->phoneType == '' ? FALSE : $dataRequest->phoneType,
					'numero' => $dataRequest->otherPhoneNum,
					'descripcion' => $dataRequest->phoneType == '' ? FALSE : $dataRequest->phoneType
				]
			],
			'afiliacion' => [
				'aplicaPerfil' => $this->session->longProfile,
				'idpersona' => $this->session->userId,
				'nombre1' => $dataRequest->firstName,
				'nombre2' => $dataRequest->middleName,
				'apellido1' => $dataRequest->lastName,
				'apellido2' => $dataRequest->surName,
				'fechanac' => $dataRequest->birthDate,
				'sexo' => $dataRequest->gender,
				'telefono1' => $dataRequest->landLine,
				'telefono2' => $dataRequest->mobilePhone,
				'telefono3' => $dataRequest->otherPhoneNum,
				'correo' => $dataRequest->email,
				'notarjeta' => $dataRequest->cardNum ?? '',
				'tipo_direccion' => $dataRequest->addressType ?? '',
				'departamento' => $dataRequest->department ?? '',
				'provincia' => $dataRequest->city ?? '',
				'distrito' => $dataRequest->district ?? '',
				'cod_postal' => $dataRequest->postalCode ?? '',
				'direccion' => $dataRequest->address ?? '',
				'edocivil' => $dataRequest->civilStatus ?? '',
				'labora' => $dataRequest->employed ?? '',
				'centrolab' => $dataRequest->workplace ?? '',
				'antiguedad_laboral' => $dataRequest->laborOld ?? '',
				'profesion' => $dataRequest->profession ?? '',
				'cargo' => $dataRequest->position ?? '',
				'ingreso_promedio_mensual' => $dataRequest->averageIncome ?? '',
				'cargo_publico_last2' => $dataRequest->publicOfficeOld ?? '',
				'cargo_publico' => $dataRequest->publicOffice ?? '',
				'institucion_publica' => $dataRequest->publicInst ?? '',
				'institucion_publica' => $dataRequest->publicInst ?? '',
				'uif' => $dataRequest->taxesObligated ?? '',
				'lugar_nacimiento' => $dataRequest->birthPlace ?? '',
				'nacionalidad' => $dataRequest->nationality ?? '',
				'dig_verificador' => $dataRequest->verifyDigit ?? '',
				'ruc_cto_laboral' => $dataRequest->fiscalId ?? '',
				'ruc_cto_laboral' => $dataRequest->fiscalId ?? '',
				'acepta_contrato' => $dataRequest->contract ?? '',
				'acepta_proteccion' => $dataRequest->protection ?? '',
				'codarea1' => '',
				'fecha_solicitud' => '',
				'fecha_reg' => '',
				'estatus' => '',
				'notifica' => '',
				'fecha_proc' => '',
				'fecha_afil' => '',
				'tipo_id' => '',
				'punto_venta' => '',
				'cod_vendedor' => '',
				'dni_vendedor' => '',
				'cod_ubigeo' => '',
			],
			'registroValido' => FALSE,
			'corporativa' => FALSE
		];
		$this->dataRequest->direccion = [
			'acTipo' => $dataRequest->addressType,
			'acCodPais' => $this->session->countrySess,
			'acCodEstado' => $dataRequest->department,
			'acCodCiudad' => $dataRequest->city,
			'acZonaPostal' => $dataRequest->postalCode,
			'acDir' => $dataRequest->address
		];
		$this->dataRequest->isParticular = TRUE;
		$this->dataRequest->rc = 0;

		$response = $this->sendToService('CallWs_UpdateProfile');

		switch ($this->isResponseRc) {
			case 0:
				if ($this->session->terms == '0') {
					$this->session->set_userdata('terms', '1');
				}

				$this->response->title = lang('USER_PROFILE_TITLE');
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->msg = lang('USER_UPDATE_SUCCESS');
				$this->response->data['btn1']['link'] = 'perfil-usuario';
			break;
			case -200:
				$this->response->title = lang('USER_PROFILE_TITLE');
				$this->response->msg = lang('USER_UPDATE_FAIL');
				$this->response->data['btn1']['link'] = 'perfil-usuario';
			break;
		}

		return $this->responseToTheView('CallWs_UpdateProfile');
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 1st, 2019
	 */
	public function callWs_KeepSession_User($dataRequest = FALSE)
	{
		log_message('INFO', 'NOVO User Model: KeepSession Method Initialized');
		$response = new stdClass();
		$response->rc =  0;
		$this->makeAnswer($response);
		$this->response->code = 0;

		return $this->responseToTheView('KeepSession');
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 1st, 2019
	 */
	public function callWs_FinishSession_User($dataRequest = FALSE)
	{
		log_message('INFO', 'NOVO User Model: FinishSession Method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';

		$userName = $dataRequest ? mb_strtoupper($dataRequest->userName) : $this->userName;

		$this->dataAccessLog->userName = $userName;
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Salir del sistema';
		$this->dataAccessLog->operation = 'Cerrar sesion';

		$this->dataRequest->idOperation = 'desconectarUsuario';
		$this->dataRequest->userName = $userName;

		if ($this->session->logged) {
			$response = $this->sendToService('callWs_FinishSession');
		}

		$this->response->code = 0;
		$this->response->msg = lang('GEN_BTN_ACCEPT');
		$this->response->data = FALSE;
		$userData = ['logged', 'encryptKey', 'sessionId', 'token'];
		$this->session->unset_userdata($userData);
		$this->session->sess_destroy();

		return $this->responseToTheView('callWs_FinishSession');
	}
	/**
	 * @info Método validación recaptcha
	 * @author Yelsyns Lopez
	 * @date May 16th, 2019
	 * @modified J. Enrique Peñaloza Piñero
	 * @date October 21st, 2019
	 */
	public function callWs_ValidateCaptcha_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: validateCaptcha Method Initialized');

		$this->load->library('recaptcha');

		$result = $this->recaptcha->verifyResponse($dataRequest->token);
		$logMessage = 'NOVO ['.$dataRequest->userName.'] RESPONSE: recaptcha País: "' .$this->config->item('country');
		$logMessage.= '", Score: "' . $result["score"] .'", Hostname: "'. $result["hostname"].'"';

		log_message('DEBUG', $logMessage);

		return $result["score"] <= lang('CONF_SCORE_CAPTCHA')[ENVIRONMENT] ? 9999 : 0;
	}
}
