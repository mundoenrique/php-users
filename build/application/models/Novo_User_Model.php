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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Ingreso al sistema';
		$this->dataAccessLog->operation = 'Iniciar sesion';

		$userName = mb_strtoupper($dataRequest->userName);

		$this->dataAccessLog->userName = $userName;

		$password = $this->cryptography->decryptOnlyOneData($dataRequest->userPass);
		$argon2 = $this->encrypt_connect->generateArgon2($password);
		$authToken = $this->session->flashdata('authToken') ?? '';

		$this->dataRequest->idOperation = '1';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $userName;
		$this->dataRequest->pais = 'Global';
		$this->dataRequest->password = md5($password);//BORRAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->password = $argon2->hexArgon2;//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->hashMD5 = md5($password);//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
		if (IP_VERIFY == 'ON' && lang('CONF_VALIDATE_IP') == 'ON') {
			$this->dataRequest->codigoOtp = [
				'tokenCliente' => $dataRequest->OTPcode ?? '',
				'authToken' => $authToken
			];

			$this->dataRequest->guardaIp = $dataRequest->saveIP ?? FALSE;
		}

		if (lang('CONFIG_MAINTENANCE') == 'ON') {
			$this->isResponseRc = 9997;
		} elseif (isset($dataRequest->OTPcode) && $authToken == '') {
			$this->isResponseRc = 9998;
		} else {
			$this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

			if ($this->isResponseRc === 0) {
				$response = $this->sendToService('callWs_Signin');
			}
		}

		$time = (object) [
			'customerTime' => (int) $dataRequest->currentTime,
			'serverTime' => (int) date("H")
		];

		$validateClient = $this->isResponseRc == 0 || $this->isResponseRc == -8 || $this->isResponseRc == -205;
		$clientCod = $response->codPais ?? '';
		$clientCod = $response->bean->codPais ?? $clientCod;

		if ($validateClient && $clientCod != $this->config->item('country') && COUNTRY_VERIFY == 'ON') {
			if ($this->isResponseRc == 0) {
				$userData = [
					'logged' => TRUE,
					'encryptKey' => $response->keyUpdate,
					'sessionId' => $response->logAccesoObject->sessionId,
					'userId' => $response->idUsuario
				];
				$this->session->set_userdata($userData);
				unset($this->dataRequest->password);
				$this->dataRequest->pais = $clientCod;
				$this->token = $response->token;
				$this->keyId = $userName;
				$this->callWs_FinishSession_User($this->dataRequest);
			}

			$this->isResponseRc = -1;
		}

		switch($this->isResponseRc) {
			case 0:
				if ($this->validateUserLogged($userName)) {
					$this->response->title = lang('GEN_SYSTEM_NAME');
					$this->response->icon = lang('CONF_ICON_WARNING');
					$this->response->msg = lang('USER_SIGNIN_INCORRECTLY_CLOSED');
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				} else {
					$this->response->code = 0;
					$this->response->modal = TRUE;
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
					$statusImgValida = FALSE;
					if (property_exists($response, "aplicaImgDoc") && strtoupper($response->aplicaImgDoc) == 'S') {
						$statusImgValida = strtoupper($response->img_valida) == 'FALSE'? TRUE: FALSE;
					}
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
						'enterpriseCod' => $response->acCodCia ?? '',
						'clientAgent' => $this->agent->agent_string(),
						'missingImages' => $statusImgValida,
						'abbrTypeDocument' => $response->abrev_tipo_id_ext_per ?? ''
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
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = novoLang(lang('USER_SIGNIN_PASS_EXPIRED'), base_url('recuperar-acceso'));
				$this->response->modalBtn['btn1']['link'] = 'inicio';
				$this->session->set_flashdata('recoverAccess', 'temporalPass');
			break;
			case -8:
			case -35:
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->msg = novoLang(lang('USER_SIGNIN_SUSPENDED_USER'), base_url('recuperar-acceso'));
				$this->response->modalBtn['btn1']['link'] = 'inicio';
				$this->session->set_flashdata('recoverAccess', 'blockedPass');
			break;
			case -286:
			case -287:
			case -288:
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->msg = $this->isResponseRc == -286 ? lang('GEN_OTP_INVALID') : lang('GEN_OTP_ERROR');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -424:
				$this->response->code = 2;
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = novoLang(lang('GEN_IP_VERIFY'), $response->bean->emailEnc);
				$this->response->modalBtn['btn1']['action'] = 'none';
				$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
				$this->response->modalBtn['btn2']['action'] = 'destroy';
				$this->session->set_flashdata('authToken', $response->bean->codigoOtp->authToken);
			break;
			case 9997:
				$this->response->code = 4;
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->msg = 'estamos haciendo mantenimiento a la plataforma para atenderte mejor';
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['link'] = 'inicio';
				$this->response->modalBtn['btn1']['action'] = 'redirect';
			break;
			case 9998:
				$this->response->code = 4;
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->msg = lang('GEN_EXPIRE_TIME');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case 9999:
				$this->response->code = 4;
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('CONF_ICON_DANGER');
				$this->response->msg = lang('USER_SIGNIN_RECAPTCHA_VALIDATE');
				$this->response->modalBtn['btn1']['link'] = 'inicio';
				$this->response->modalBtn['btn1']['action'] = 'redirect';
			break;
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Recuperar acceso';
		$this->dataAccessLog->operation = 'Obtener usuario o clave temporal';
		$this->dataAccessLog->userName = $dataRequest->email;

		$this->dataRequest->idOperation = isset($dataRequest->recoveryPwd) ? '23' : '24';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
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
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_CONTINUE');
				$this->response->modalBtn['btn1']['link'] = 'inicio';
				break;
			case -186:
			case -187:
				$msgGeneral = '1';
				$this->response->msg = LANG('USER_RECOVER_DATA_INVALID');
				break;
		}

		if($this->isResponseRc != 0 && $msgGeneral == '1') {
			$this->response->title = lang('GEN_MENU_ACCESS_RECOVER');
			$this->response->icon = lang('CONF_ICON_INFO');
			$this->response->modalBtn['btn1']['action'] = 'destroy';
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Clave';
		$this->dataAccessLog->operation = 'Cambiar Clave';

		$current = $this->cryptography->decryptOnlyOneData($dataRequest->currentPass);
		$new = $this->cryptography->decryptOnlyOneData($dataRequest->newPass);

		$argon2 = $this->encrypt_connect->generateArgon2($new);

		$this->dataRequest->idOperation = '25';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->userName;
		$this->dataRequest->passwordOld = md5($current);
		$this->dataRequest->password = md5($new);
		$this->dataRequest->passwordOld4 = md5(strtoupper($new));
		//$this->dataRequest->password = $argon2->hexArgon2;//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
		//$this->dataRequest->hashMD5 = md5($new);//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS

		$changePassType = $this->session->flashdata('changePassword');
		$this->sendToService('CallWs_ChangePassword');

		switch($this->isResponseRc) {
			case 0:
				if($this->session->has_userdata('userId')) {
					$this->callWs_FinishSession_User();
				}

				$this->response->code = 4;
				$goLogin = $this->session->has_userdata('logged') ? '' : lang('USER_PASS_LOGIN');

				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->msg = novoLang(lang('USER_PASS_CHANGED'), $goLogin);
				$this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_CONTINUE');
				$this->response->modalBtn['btn1']['link'] = $this->session->has_userdata('logged') ? lang('GEN_LINK_CARDS_LIST') : 'inicio';
			break;
			case -4:
				$code = 1;
				$this->response->msg = lang('USER_PASS_USED');
			break;
			case -192:
				$code = 1;
				$this->response->msg = lang('USER_PASS_INCORRECT');
			break;
		}

		if($this->isResponseRc != 0 && $code == 1) {
			$this->session->set_flashdata('changePassword', $changePassType);

			$this->response->icon = lang('CONF_ICON_WARNING');
			$this->response->title = lang('GEN_PASSWORD_CHANGE_TITLE');
			$this->response->modalBtn['btn1']['action'] = 'destroy';
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Identificar usuario';
		$this->dataAccessLog->operation = 'validar datos de registro';
		$this->dataAccessLog->userName = $dataRequest->docmentId.date('dmy');

		$this->dataRequest->idOperation = '18';
		$this->dataRequest->className = 'com.novo.objects.TOs.CuentaTO';
		$this->dataRequest->cuenta = $dataRequest->numberCard ?? '';
		$this->dataRequest->id_ext_per = $dataRequest->docmentId;
		$this->dataRequest->pin = $dataRequest->cardPIN ?? '1234';
		$this->dataRequest->claveWeb = isset($dataRequest->cardPIN) ? md5($dataRequest->cardPIN) : md5('1234');
		$this->dataRequest->pais = $dataRequest->client ?? $this->country;
		$this->dataRequest->email = $dataRequest->email ?? '';
		$this->dataRequest->tipoTarjeta = isset($dataRequest->virtualCard) ? 'virtual' : (isset ($dataRequest->physicalCard) ? 'fisica' : '');
		$authToken = $this->session->flashdata('authToken') ??  '';
		$maskMail = $this->dataRequest->email !='' ? maskString($this->dataRequest->email, 4, $end = 6, '@') : '';
		$this->dataRequest->otp =[
			'authToken' => $authToken,
			'tokenCliente' => (isset($dataRequest->codeOtp) && $dataRequest->codeOtp != '') ? $dataRequest->codeOtp : '',
		];

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
				$userData->email = isset($dataRequest->virtualCard) ? '' : ($response->user->email ?? '');
				$userData->landLine = $response->user->telefono ?? '';
				$userData->mobilePhone = $response->user->celular ?? '';
				$userData->longProfile = $response->user->aplicaPerfil ?? '';
				$userData->generalAccount =  '';
				$userData->CurrentVerifierCode = '';

				if ($userData->longProfile == 'S') {
					$userData->idnumber = $response->afiliacion->idpersona ?? $userData->idnumber;
					$userData->fiscalId = $response->afiliacion->ruc_cto_laboral ?? '';
					$userData->generalAccount = $response->afiliacion->acepta_contrato ?? $userData->generalAccount;
					$userData->CurrentVerifierCode = $response->afiliacion->dig_verificador_aux ?? '';
				}

				$this->response->data->signUpData = $userData;
				$this->response->modal = TRUE;

				$userSess = [
					'userIdentity' => TRUE,
					'encryptKey' => $response->keyUpdate,
					'sessionId' => $response->logAccesoObject->sessionId,
					'userId' => $response->user->id_ext_per,
					'userName' => $response->logAccesoObject->userName,
					'docmentId' => $response->user->id_ext_per,
					'abbrTypeDocument' => $response->user->abrev_tipo_id_ext_per ?? '',
					'token' => $response->token,
					'cl_addr' => $this->encrypt_connect->encode($this->input->ip_address(), $dataRequest->docmentId, 'REMOTE_ADDR'),
					'countrySess' => $dataRequest->client ?? $this->country,
					'countryUri' => $this->config->item('country-uri'),
					'clientAgent' => $this->agent->agent_string(),
					'longProfile' => $userData->longProfile,
					'cardNumber' => $dataRequest->numberCard ?? ''
				];
				$this->session->set_userdata($userSess);
			break;
			case 200://MODAL OTP
				$this->response->code = 2;
				$this->response->labelInput = lang('GEN_OTP_LABEL_INPUT');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->msg = novoLang(lang('GEN_OTP_MSG'), $maskMail);
				$this->response->modalBtn['btn1']['action'] = 'none';
				$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
				$this->response->modalBtn['btn2']['link']  = 'identificar-usuario';
				$this->response->modalBtn['btn2']['action'] = 'redirect';

				$this->session->set_flashdata('authToken', $response->bean->otp->authToken);
			break;
			case -21:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = lang('USER_INVALID_DATE');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -183:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = lang('GEN_INVALID_CARD');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -184:
			case -308:
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = lang('GEN_INVALID_DATA');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -286://OTP INVALIDO
				$this->response->msg = lang('GEN_OTP_INVALID');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -300://MENSAJE TARJETA VIRTUAL EXISTENTE
				$this->response->title = lang('GEN_MENU_USER_IDENTIFY');
				$this->response->msg = novoLang(lang('USER_IDENTIFY_EXIST'), lang('GEN_SYSTEM_NAME'));
				$this->response->modalBtn['btn1']['action'] = 'destroy';
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Registro';
		$this->dataAccessLog->operation = 'validar nombre de usuario';

		$this->dataRequest->idOperation = '19';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Registro';
		$this->dataAccessLog->operation = 'Registrar usuario';

		$password = $this->cryptography->decryptOnlyOneData($dataRequest->newPass);
		$argon2 = $this->encrypt_connect->generateArgon2($password);

		$this->dataRequest->idOperation = '20';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
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
			'passwordOld4' => md5(mb_strtoupper($password)),
			'aplicaImgDoc' => 'S',
			'img_valida' => 'FALSE',
			'imagenes' => [
				'id_ext_per' => $dataRequest->idNumber,
				'tipoDocumento' => $dataRequest->countryDocument ?? '',
				'rutaAnverso' => $dataRequest->INE_A ?? '',
				'rutaReverso' => $dataRequest->INE_R ?? '',
				'operacion' => 'insertar'
			]
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

		if ($this->session->longProfile == 'S') {
			$this->dataRequest->afiliacion = [
				'aplicaPerfil' => $this->session->longProfile,
				'notarjeta' => $this->session->cardNumber,
				'idpersona' => $this->session->userId,
				'nombre1' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->firstName)))),
				'nombre2' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->middleName)))),
				'apellido1' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->lastName)))),
				'apellido2' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->surName)))),
				'fechanac' => $dataRequest->birthDate,
				'sexo' => $dataRequest->gender,
				'telefono1' => $dataRequest->landLine,
				'telefono2' => $dataRequest->mobilePhone,
				'telefono3' => $dataRequest->otherPhoneNum,
				'correo' => $dataRequest->email,
				'tipo_direccion' => $dataRequest->addressType ?? '',
				'departamento' => $dataRequest->state ?? '',
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
				'ingreso_promedio_mensual' => $dataRequest->averageIncome ? (float)$dataRequest->averageIncome : '',
				'cargo_publico_last2' => $dataRequest->publicOfficeOld ?? '',
				'cargo_publico' => $dataRequest->publicOffice ?? '',
				'institucion_publica' => $dataRequest->publicInst ?? '',
				'uif' => $dataRequest->taxesObligated ?? '',
				'lugar_nacimiento' => $dataRequest->birthPlace ?? '',
				'nacionalidad' => $dataRequest->nationality ?? '',
				'dig_verificador' => $dataRequest->verifierCode ?? '',
				'ruc_cto_laboral' => $dataRequest->fiscalId ?? '',
				'acepta_contrato' => $dataRequest->contract ? (int)$dataRequest->contract : '',
				'acepta_proteccion' => $dataRequest->protection ? (int)$dataRequest->protection :  '',
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
				'cod_ubigeo' => ''
			];
		}

		$response = $this->sendToService('CallWs_Signup');

		if ($this->isResponseRc !== 0) {
			$configUploadFile = lang('CONF_CONFIG_UPLOAD_FILE');
			$configUploadFile['upload_path'] = $this->tool_file->buildDirectoryPath([
			$this->tool_file->buildDirectoryPath([BASE_CDN_PATH,'upload']),
				strtoupper($this->session->countryUri),
				strtoupper($dataRequest->nickName ?? $this->session->userName),
			]);

			$this->tool_file->deleteFiles($configUploadFile);
		}

		switch ($this->isResponseRc) {
			case 0:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->msg = 'El registro se ha hecho satisfactoriamente, por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
				$this->session->sess_destroy();
			break;
			case -206:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El registro fue realizado; aunque no fue posible enviar el correo de confirmación. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
				$this->session->sess_destroy();
			break;
			case -271:
			case -335:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El registro fue realizado; algunos datos no fueron cargados en su totalidad.</br> Por favor complétalos en la sección de <strong>Perfil.</strong>"<br>. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
				$this->session->sess_destroy();
			break;
			case -317:
			case -314:
			case -313:
			case -311:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El registro fue realizado; aunque tu tarjeta no fue activada. Comunícate con el <strong>Centro de Contacto</strong>.<br>. Por motivos de seguridad es necesario que inicies sesión con tu usuario y contraseña.';
				$this->session->sess_destroy();
			break;
			case -181:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El correo eléctronico que indicas ya se encuentra registrado, por favor intenta con otro.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -284:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El telefóno movil que indicas ya se encuentra registrado, por favor intenta con otro.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -397:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'Verifica tus datos e intenta de nuevo. <br>Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -102:
			case -104:
			case -118:
			case 5002:
			case 5003:
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
			case 6000:
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'No fue posible validar tus datos, por favor verifícalos e intenta nuevamente.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
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
				$this->response->title = lang('GEN_MENU_SIGNUP');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'Verifica tu DNI en RENIEC e intenta de nuevo. <br> Si continuas viendo este mensaje comunícate con la empresa emisora de tu tarjeta.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
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

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Perfil';
		$this->dataAccessLog->operation = 'Datos del usuario';

		$this->dataRequest->idOperation = '30';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $this->session->userName;

		$response = $this->sendToService('callWs_ProfileUser');
		$phonesList = [];

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$modal = FALSE;

				if ($this->session->terms == '0') {
					$this->response->code = 4;
					$this->response->icon = lang('CONF_ICON_INFO');
					$this->response->title = lang('GEN_SYSTEM_NAME');
					$this->response->msg = 'Completa el formulario para activar tu tarjeta (Dinero electrónico)';
					$this->response->modalBtn['action'] = 'destroy';
					$modal = TRUE;
				}

				if ($this->session->longProfile == 'S' && $this->session->affiliate == '0') {
					$this->response->code = 4;
					$this->response->icon = lang('CONF_ICON_INFO');
					$this->response->title = lang('GEN_SYSTEM_NAME');
					$this->response->msg = 'Completa el formulario para activar tu tarjeta (Dinero electrónico)';
					$this->response->modalBtn['btn1']['action'] = 'destroy';
					$modal = TRUE;
				}
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
		$profileData->abbrTypeDocument = $response->registro->user->abrev_tipo_id_ext_per ?? '';
		$profileData->smsKey = $response->registro->user->disponeClaveSMS ?? '';
		$profileData->operPass = $response->registro->user->passwordOperaciones ?? '';
		$profileData->longProfile = $response->registro->user->aplicaPerfil ?? '';
		$profileData->aplicaImgDoc = $response->registro->user->aplicaImgDoc ?? '';
		$profileData->img_valida = $response->registro->user->img_valida ?? '';
		$profileData->addressType = $response->direccion->acTipo ?? '';
		$profileData->address = $response->direccion->acDir ?? '';
		$profileData->postalCode = $response->direccion->acZonaPostal ?? '';
		$profileData->countryCod = $response->direccion->acCodPais ?? '';
		$profileData->country = $response->direccion->acPais ?? '';
		$profileData->stateCode = $response->direccion->acCodEstado ?? '';
		$profileData->state = $response->direccion->acEstado ?? 'Selecciona';
		$profileData->cityCod = $response->direccion->acCodCiudad ?? '';
		$profileData->city = $response->direccion->acCiudad ?? 'Selecciona';

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

		$profileData->generalAccount =  '';

		if ($profileData->longProfile == 'S') {
			$cardNumber = $response->registro->afiliacion->cardNumber ?? '';
			$this->session->set_flashdata('cardNumber', $cardNumber);

			$profileData->firstName = isset($response->registro->afiliacion->nombre1) && $response->registro->afiliacion->nombre1 != ''
				? $response->registro->afiliacion->nombre1 : $profileData->firstName;

			$profileData->middleName = isset($response->registro->afiliacion->nombre2) && $response->registro->afiliacion->nombre2 != ''
				? $response->registro->afiliacion->nombre2 : $profileData->middleName;

			$profileData->lastName = isset($response->registro->afiliacion->apellido1) && $response->registro->afiliacion->apellido1 != ''
				? $response->registro->afiliacion->apellido1 : $profileData->lastName;

			$profileData->surName = isset($response->registro->afiliacion->apellido2) && $response->registro->afiliacion->apellido2 != ''
				? $response->registro->afiliacion->apellido2 : $profileData->surName;

			$profileData->gender = isset($response->registro->afiliacion->sexo) && $response->registro->afiliacion->sexo != ''
				? $response->registro->afiliacion->sexo : $profileData->gender;

			$phonesList['landLine'] = isset($response->registro->afiliacion->telefono1) &&  $response->registro->afiliacion->telefono1 != ''
				? $response->registro->afiliacion->telefono1 : $phonesList['landLine'];

			$phonesList['mobilePhone'] = isset($response->registro->afiliacion->telefono2) &&  $response->registro->afiliacion->telefono2 != ''
				? $response->registro->afiliacion->telefono2 : $phonesList['mobilePhone'];

			$phonesList['otherPhoneNum'] = isset($response->registro->afiliacion->telefono3) &&  $response->registro->afiliacion->telefono3 != ''
				? $response->registro->afiliacion->telefono3 : $phonesList['otherPhoneNum'];

			$profileData->email = isset($response->registro->afiliacion->correo) &&  $response->registro->afiliacion->correo != ''
				? $response->registro->afiliacion->correo : $profileData->email;

			$profileData->addressType = isset($response->registro->afiliacion->tipo_direccion) &&  $response->registro->afiliacion->tipo_direccion != ''
				? $response->registro->afiliacion->tipo_direccion : $profileData->addressType;

			$profileData->stateCode = isset($response->registro->afiliacion->departamento) &&  $response->registro->afiliacion->departamento != ''
				? $response->registro->afiliacion->departamento : $profileData->stateCode;

			$profileData->cityCod = isset($response->registro->afiliacion->provincia) &&  $response->registro->afiliacion->provincia != ''
				? $response->registro->afiliacion->provincia : $profileData->cityCod;

			$profileData->districtCod = $response->registro->afiliacion->distrito ?? '';

			$profileData->district = 'Selecciona';

			$profileData->postalCode = isset($response->registro->afiliacion->cod_postal) &&  $response->registro->afiliacion->cod_postal != ''
				? $response->registro->afiliacion->cod_postal : $profileData->postalCode;

			$profileData->address = isset($response->registro->afiliacion->direccion) &&  $response->registro->afiliacion->direccion != ''
				? $response->registro->afiliacion->direccion : $profileData->address;

			$profileData->civilStatus = $response->registro->afiliacion->edocivil ?? '';
			$profileData->workplace = $response->registro->afiliacion->centrolab ?? '';
			$profileData->employed = $response->registro->afiliacion->labora ?? '';
			$profileData->laborOld = $response->registro->afiliacion->antiguedad_laboral ?? '';
			$profileData->professionType = $response->registro->afiliacion->profesion ?? '';
			$profileData->position = $response->registro->afiliacion->cargo ?? '';

			$profileData->averageIncome = isset($response->registro->afiliacion->ingreso_promedio_mensual) &&$response->registro->afiliacion->ingreso_promedio_mensual != ''
				? currencyFormat($response->registro->afiliacion->ingreso_promedio_mensual) : '';

			$profileData->publicOfficeOld = $response->registro->afiliacion->cargo_publico_last2 ?? '';
			$profileData->publicOffice = $response->registro->afiliacion->cargo_publico ?? '';
			$profileData->publicInst = $response->registro->afiliacion->institucion_publica ?? '';
			$profileData->taxesObligated = '';

			if (isset($response->registro->afiliacion->uif)) {
				$profileData->taxesObligated = $response->registro->afiliacion->uif == '' ? '0' : $response->registro->afiliacion->uif;
			}

			$profileData->birthPlace = $response->registro->afiliacion->lugar_nacimiento ?? '';
			$profileData->nationality = $response->registro->afiliacion->nacionalidad ?? '';

			$profileData->verifierCode = isset($response->registro->afiliacion->dig_verificador) && !$modal ?
				$response->registro->afiliacion->dig_verificador : '';

			$profileData->fiscalId = $response->registro->afiliacion->ruc_cto_laboral ?? '';
			$profileData->contract = $response->registro->afiliacion->acepta_contrato ?? '';
			$profileData->generalAccount = $response->registro->afiliacion->acepta_contrato ?? $profileData->generalAccount;
			$profileData->protection = $response->registro->afiliacion->acepta_proteccion ?? '';
		}

		$imagesDocument = [];
		if (property_exists($profileData, "aplicaImgDoc") && strtoupper($profileData->aplicaImgDoc) == 'S') {
			if (strtoupper($profileData->img_valida) == 'TRUE') {
				$imagesDocumentLoaded = [
					'INE_A' => ['nameFile' => $response->registro->user->imagenes->rutaAnverso ?? ''],
					'INE_R' => ['nameFile' => $response->registro->user->imagenes->rutaReverso ?? '']
				];

				foreach ($imagesDocumentLoaded as $typeDocument => $nameDocument) {
					if ($nameDocument['nameFile'] !== '') {
						$fullPathToImage = $this->tool_file->buildDirectoryPath([
							$this->tool_file->buildDirectoryPath([BASE_CDN_PATH,'upload']),
							strtoupper($this->session->countryUri),
							strtoupper($this->session->userName),
							$nameDocument['nameFile']
						]);

						if (is_file($fullPathToImage)) {
							$resultDecrypt = $this->tool_file->cryptographyFile($fullPathToImage, FALSE);

							if ($resultDecrypt) {
								$type = pathinfo($fullPathToImage, PATHINFO_EXTENSION);
								$data = file_get_contents($fullPathToImage);

								$this->tool_file->cryptographyFile($fullPathToImage);

								$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
								$imagesDocument[$typeDocument]['base64'] = $base64;
								$imagesDocument[$typeDocument]['validate'] = 'ignore';
							}
						}
					}
				}
			}
		}
		$profileData->imagesLoaded = $imagesDocument;

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

		$mailAvailable = TRUE;

		if ($dataRequest->email != $dataRequest->oldEmail) {
			$this->callws_ValidateEmail_User($dataRequest);
			$mailAvailable = FALSE;
			if ($this->response->code == 2) {
				$mailAvailable = TRUE;
			} else {
				$this->isResponseRc = -9997;
			}
		}

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Perfil';
		$this->dataAccessLog->operation = 'Actualizar usuario';

		$this->dataRequest->idOperation = '39';
		$this->dataRequest->className = 'com.novo.objects.MO.DatosPerfilMO';
		$this->dataRequest->country = $this->session->countrySess;
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
				'tipo_id_ext_per' => $dataRequest->idType,
				'descripcion_tipo_id_ext_per' => $dataRequest->idTypeText,
				'aplicaPerfil' => $this->session->longProfile,
				'aplicaImgDoc' => $dataRequest->aplicaImgDoc ?? '',
				'img_valida' => $dataRequest->img_valida ?? '',
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
				'notarjeta' => $this->session->flashdata('cardNumber'),
				'idpersona' => $this->session->userId,
				'nombre1' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->firstName)))),
				'nombre2' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->middleName)))),
				'apellido1' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->lastName)))),
				'apellido2' => implode(' ',array_filter(explode(' ',mb_strtoupper($dataRequest->surName)))),
				'fechanac' => $dataRequest->birthDate,
				'sexo' => $dataRequest->gender,
				'telefono1' => $dataRequest->landLine,
				'telefono2' => $dataRequest->mobilePhone,
				'telefono3' => $dataRequest->otherPhoneNum,
				'correo' => $dataRequest->email,
				'tipo_direccion' => $dataRequest->addressType ?? '',
				'departamento' => $dataRequest->state ?? '',
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
				'uif' => $dataRequest->taxesObligated ?? '',
				'lugar_nacimiento' => $dataRequest->birthPlace ?? '',
				'nacionalidad' => $dataRequest->nationality ?? '',
				'dig_verificador' => $dataRequest->verifierCode ?? '',
				'ruc_cto_laboral' => $dataRequest->fiscalId ?? '',
				'acepta_contrato' => '1',
				'acepta_proteccion' => '1',
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
				'cod_ubigeo' => ''
			],
			'registroValido' => FALSE,
			'corporativa' => FALSE
		];

		if (property_exists($dataRequest, "aplicaImgDoc") && strtoupper($dataRequest->aplicaImgDoc) == 'S') {
			if (strtoupper($dataRequest->img_valida) == 'TRUE') {
				if ($dataRequest->INE_A !== '' || $dataRequest->INE_R !== '') {
					$this->dataRequest->registro['user']['imagenes'] = [
						'id_ext_per' => $dataRequest->idNumber,
						'tipoDocumento' => $dataRequest->countryDocument ?? '',
						'rutaAnverso' => $dataRequest->INE_A ?? '',
						'rutaReverso' => $dataRequest->INE_R ?? '',
						'operacion' => 'actualizar'
					];
				}
			}
		}
		$this->dataRequest->direccion = [
			'acTipo' => $dataRequest->addressType,
			'acCodPais' => $this->session->countrySess,
			'acCodEstado' => $dataRequest->state,
			'acCodCiudad' => $dataRequest->city,
			'acZonaPostal' => $dataRequest->postalCode,
			'acDir' => $dataRequest->address
		];
		$this->dataRequest->isParticular = TRUE;
		$this->dataRequest->rc = 0;

		if ($mailAvailable) {
			$response = $this->sendToService('CallWs_UpdateProfile');
		}

		switch ($this->isResponseRc) {
			case 0:
				if ($this->session->terms == '0') {
					$this->session->set_userdata('terms', '1');
				}

				if ($this->session->affiliate == '0') {
					$this->session->set_userdata('affiliate', '1');
				}

				$this->response->title = lang('USER_PROFILE_TITLE');
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->msg = lang('USER_UPDATE_SUCCESS');
				$this->response->modalBtn['btn1']['link'] = 'perfil-usuario';
			break;
			case -200:
				$this->response->title = lang('USER_PROFILE_TITLE');
				$this->response->msg = lang('USER_UPDATE_FAIL');
				$this->response->modalBtn['btn1']['link'] = 'perfil-usuario';
			break;
		}

		return $this->responseToTheView('CallWs_UpdateProfile');
	}
	/**
	 * @info Método para validar la existencia de un correo
	 * @author J. Enrique Peñaloza Piñero
	 * @date November 19th, 2020
	 */
	public function callws_ValidateEmail_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: ValidateEmail Method Initialized');

		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Actualizar email';
		$this->dataAccessLog->operation = 'Validar email';

		$this->dataRequest->idOperation = 'verificarEmailCPO';
		$this->dataRequest->className = 'com.novo.objects.TO.UsuarioTO';
		$this->dataRequest->email = $dataRequest->email;

		$response = $this->sendToService('callWs_ValidateEmail');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->title = lang('USER_PROFILE_TITLE');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'El correo eléctronico que indicas ya se encuentra registrado, por favor intenta con otro.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
			case -238:
				$this->response->code = 2;
			break;
		}

		$this->dataAccessLog = new stdClass();
		$this->dataRequest = new stdClass();

		return $this->responseToTheView('callWs_ValidateEmail');
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

		$userName = $dataRequest ? mb_strtoupper($dataRequest->userName) : $this->userName;
		$this->dataAccessLog->userName = $userName;
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Salir del sistema';
		$this->dataAccessLog->operation = 'Cerrar sesion';

		$this->dataRequest->idOperation = 'desconectarUsuario';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = $userName;

		if ($this->session->logged) {
			$response = $this->sendToService('callWs_FinishSession');
		}

		$this->response->code = 0;
		$this->response->msg = lang('GEN_BTN_ACCEPT');
		$this->response->data = FALSE;

		if (!$this->input->is_ajax_request()) {
			$this->session->sess_destroy();
		}

		clearSessionsVars();

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
