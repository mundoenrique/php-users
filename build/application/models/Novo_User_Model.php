<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 14th, 2019
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
	 * @date May 14th, 2019
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

		$this->dataRequest->idOperation = '1';
		$this->dataRequest->userName = $userName;
		$this->dataRequest->password = md5($password);
		$this->dataRequest->pais = 'Global';

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
					$this->response->msg = lang('LOGIN_INCORRECTLY_CLOSED');
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
						'countrySess' => $response->keyUpdate,
						'countryUri' => $this->config->item('country-uri')
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
				$this->response->msg = lang('LOGIN_INVALID_USER');
				$this->response->className = lang('CONF_VALID_INVALID_USER');
				$this->response->position = lang('CONF_VALID_POSITION');
				if (isset($response->bean->intentos) && $response->bean->intentos == 2) {
					$this->response->msg = lang('LOGIN_WILL_BLOKED');
					$this->response->className = lang('CONF_VALID_INVALID_USER');
					$this->response->position = lang('CONF_VALID_POSITION');
				}
				break;
			case -194:
				$this->response->title = lang('GEN_SYSTEM_NAME');
				$this->response->icon = lang('GEN_ICON_INFO');
				$this->response->msg = novoLang(lang('LOGIN_PASS_EXPIRED'), base_url('recuperar-acceso'));
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
				$this->response->msg = novoLang(lang('LOGIN_SUSPENDED_USER'), base_url('recuperar-acceso'));
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
				$this->response->msg = lang('LOGIN_RECAPTCHA_VALIDATE');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_ACCEPT'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				break;
		}

		return $this->responseToTheView('callWs_Signin');
	}
	/**
	 * @info Método para validar si el usuariio esta logueado
	 * @author J. Enrique Peñaloza Piñero
	 * @date April 29th, 2019
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
	 * @info Método para recuperar contraseña
	 * @author J. Enrique Peñaloza Piñero
	 * @date April 29th, 2019
	 */
	public function callWs_RecoverPass_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: RecoverPass Method Initialized');

		$this->className = 'com.novo.objects.TO.UsuarioTO';
		$this->dataAccessLog->modulo = 'Usuario';
		$this->dataAccessLog->function = 'Recuperar Clave';
		$this->dataAccessLog->operation = 'Enviar Clave';
		$userName = mb_strtoupper($dataRequest->user);
		$this->dataAccessLog->userName = $userName;

		$this->dataRequest->idOperation = 'olvidoClave';
		$this->dataRequest->userName = $userName;
		$this->dataRequest->idEmpresa = $dataRequest->idEmpresa;
		$this->dataRequest->email = $dataRequest->email;
		$maskMail = maskString($dataRequest->email, 4, $end = 6, '@');
		$response = $this->sendToService(lang('GEN_RECOVER_PASS'));

		switch($this->isResponseRc) {
			case 0:
				$this->response->code = 0;
				$this->response->msg = novoLang(lang('RESP_TEMP_PASS'), [$this->dataRequest->userName, $maskMail]);
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_CONTINUE'),
						'link'=> 'inicio',
						'action'=> 'redirect'
					]
				];
				break;
			case -6:
				$this->response->code = 1;
				$this->response->msg = novoLang(lang('RESP_COMPANNY_NOT_ASSIGNED'), $this->dataRequest->userName);
				break;
			case -150:
				$this->response->code = 1;
				$this->response->msg = novoLang(lang('RESP_FISCAL_REGISTRY_NO_FOUND'), lang('GEN_FISCAL_REGISTRY'));
				break;
			case -159:
				$this->response->code = 1;
				$this->response->msg = novoLang(lang('RESP_EMAIL_NO_FOUND'), $maskMail);
				break;
			case -173:
				$this->response->code = 1;
				$this->response->msg = lang('RESP_EMAIL_NO_SENT');
				break;
			case -205:
				$this->response->code = 1;
				$this->response->msg = lang('RESP_UNREGISTERED_USER');
				$this->response->msg.= novoLang(lang('RESP_SUPPORT'), [lang('RESP_SUPPORT_MAIL'), lang('RESP_SUPPORT_TELF')]);
				break;
		}

		if($this->isResponseRc != 0 && $this->response->code == 1) {
			$this->response->title = lang('GEN_RECOVER_PASS_TITLE');
			$this->response->icon = lang('GEN_ICON_INFO');
			$this->response->data = [
				'btn1'=> [
					'action'=> 'close'
				]
			];
		}

		return $this->responseToTheView(lang('GEN_RECOVER_PASS'));
	}
	/**
	 * @info Método para el cambio de Contraseña
	 * @author J. Enrique Peñaloza Piñero
	 * @date April 29th, 2019
	 * @modified Diego Acosta García
	 * @date April 29th, 2020
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

		$this->dataRequest->idOperation = 'cambioClave';
		$this->dataRequest->userName = $this->userName;
		$this->dataRequest->passwordOld = md5($current);
		$this->dataRequest->password = md5($new);
		$changePassType = $this->session->flashdata('changePassword');
		$this->sendToService('CallWs_ChangePassword');
		$code = 0;

		switch($this->isResponseRc) {
			case 0:
				if(!$this->session->has_userdata('logged')) {
					$this->callWs_FinishSession_User();
				}
				$this->response->code = 4;
				$goLogin = $this->session->has_userdata('logged') ? '' : lang('RESP_PASSWORD_LOGIN');
				$this->response->msg = novoLang(lang('RESP_PASSWORD_CHANGED'), $goLogin);
				$this->response->icon = lang('GEN_ICON_SUCCESS');
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('GEN_BTN_CONTINUE'),
						'link'=> 'inicio',
						'action'=> $this->session->has_userdata('logged') ? 'close' :  'redirect'
					]
				];
				break;
			case -4:
				$code = 1;
				$this->response->msg = lang('RESP_PASSWORD_USED');
				break;
			case -22:
				$code = 1;
				$this->response->msg = lang('RESP_PASSWORD_INCORRECT');
				break;
		}

		if($this->isResponseRc != 0 && $code == 1) {
			$this->session->set_flashdata('changePassword', $changePassType);
			$this->session->set_flashdata('userType', $this->session->flashdata('userType'));

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
		$this->dataRequest->idUsuario = $userName;

		$response = $this->sendToService(lang('GEN_FINISH_SESSION'));

		$this->response->code = 0;
		$this->response->msg = lang('GEN_BTN_ACCEPT');
		$this->response->data = FALSE;

		$this->session->sess_destroy();

		return $this->responseToTheView(lang('GEN_FINISH_SESSION'));
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

		return $result["score"] <= $this->config->item('score_recaptcha')[ENVIRONMENT] ? 9999 : 0;
	}
}
