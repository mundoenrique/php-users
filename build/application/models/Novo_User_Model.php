<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
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
	 */
	public function callWs_Login_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Login method Initialized');
		$this->className = 'com.novo.objects.TOs.UsuarioTO';

		$this->dataAccessLog->modulo = 'login';
		$this->dataAccessLog->function = 'login';
		$this->dataAccessLog->operation = '1'; //'loginFull';
		$this->dataAccessLog->userName = $dataRequest->user;

		$this->dataRequest->userName = mb_strtoupper($dataRequest->user);
		$this->dataRequest->password = $dataRequest->pass;
		$this->dataRequest->ctipo = $dataRequest->active;

		$response = $this->sendToService('Login');
		if($this->isResponseRc !== FALSE) {
			switch($this->isResponseRc) {
				case 0:
					log_message('DEBUG', 'NOVO ['.$this->dataRequest->userName.'] RESPONSE: Login: ' . json_encode($response->userName));
					if ($this->isUserLoggedIn($dataRequest->user)) {

						$userData = [
							'idUsuario' => $response->idUsuario,
							'userName' => $response->userName,
							'nombreCompleto' => strtolower(substr($response->primerNombre, 0, 18)) . ' ' . strtolower(substr($response->primerApellido, 0, 18)),
							'token' => $response->token,
							'sessionId' => $response->logAccesoObject->sessionId,
							'keyId' => $response->keyUpdate,
							'logged_in' => true,
							'pais' => $response->codPais,
							'aplicaTransferencia' => $response->aplicaTransferencia,
							'passwordOperaciones' => $response->passwordOperaciones,
							'cl_addr' => np_Hoplite_Encryption($_SERVER['REMOTE_ADDR'], 0),
							'afiliado' => $response->afiliado,
							'aplicaPerfil' => $response->aplicaPerfil,
							'tyc' => $response->tyc
						];
						$this->session->set_userdata($userData);
						$this->response->code = 0;
						$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
						$this->response->data = "http://localhost/site-conexionpersonas/build/dashboard";
						//$this->response->data = base_url('empresas');

						$data = ['username' => $dataRequest->user];
						$this->db->where('id', $this->session->session_id);
						$this->db->update('cpo_sessions', $data);

					} else {
						$this->response->code = -5;
						$this->response->msg = 'El sistema ha identificado que cuenta con una sesión abierta, procederemos a cerrarla para continuar.';
					}

					break;
				case -2:
				case -185:
					$fullName = mb_strtolower($response->usuario->primerNombre.' '.$response->usuario->primerApellido);
					$userData = [
						'sessionId' => $response->logAccesoObject->sessionId,
						'idUsuario' => $response->usuario->idUsuario,
						'userName' => $response->usuario->userName,
						'fullName' => $fullName,
						'codigoGrupo' => $response->usuario->codigoGrupo,
						'token' => $response->token,
						'cl_addr' => $this->encrypt_connect->encode($_SERVER['REMOTE_ADDR'], $dataRequest->user, 'REMOTE_ADDR'),
						'countrySess' => $this->config->item('country')
					];

					$this->session->set_userdata($userData);

					$this->response->code = 0;
					$this->response->title = lang('LOGIN_TITLE'.$this->isResponseRc);
					$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
					$this->response->data = base_url('inf-condiciones');
					$this->session->set_flashdata('changePassword', 'newUser');
					$this->session->set_flashdata('userType', $response->usuario->ctipo);

					if($this->isResponseRc === -185) {
						$this->response->code = 0;
						$this->response->title = lang('LOGIN_TITLE'.$this->isResponseRc);
						$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
						$this->response->data = base_url('cambiar-clave');
						$this->session->set_flashdata('changePassword', 'expiredPass');
						break;
					}
					break;
				case -1:
				case -263:
					$this->response->code = 1;
					$this->response->title = lang('LOGIN_TITLE'.$this->isResponseRc);
					$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
					$this->response->className = 'error-login-2';
					break;
				case -8:
				case -35:
					$this->response->code = 1;
					$this->response->title = lang('LOGIN_TITLE'.$this->isResponseRc);
					$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
					$this->response->className = 'login-inactive';
					break;
				case -229:
					$this->response->code = 2;
					$this->response->title = lang('LOGIN_TITLE'.$this->isResponseRc);
					break;
				case -262:
					$this->response->code = 3;
					$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
					$this->response->icon = 'ui-icon-info';
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('BUTTON_ACCEPT'),
							'link'=> FALSE,
							'action'=> 'close'
						]
					];
					break;
				case -28:
					$this->response->code = 3;
					$this->response->msg = lang('LOGIN_MSG'.$this->isResponseRc);
					$this->response->icon = 'ui-icon-alert';
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('BUTTON_ACCEPT'),
							'link'=> [
								'who'=> 'User',
								'where'=> 'FinishSession'
							],
							'action'=> 'logout'
						]
					];
					break;
			}
		}
		return $this->response;
	}
	/**
	 * @info Método para recuperar contraseña
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function callWs_RecoveryPass_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: RecoveryPass method Initialized');
		$this->className = 'com.novo.objects.TO.UsuarioTO';

		$this->dataAccessLog->modulo = 'clave';
		$this->dataAccessLog->function = 'recuperarClave';
		$this->dataAccessLog->operation = 'olvidoClave';
		$this->dataAccessLog->userName = $dataRequest->userName;

		$this->dataRequest->userName = mb_strtoupper($dataRequest->userName);
		$this->dataRequest->idEmpresa = $dataRequest->idEmpresa;
		$this->dataRequest->email = $dataRequest->email;

		$response = $this->sendToService('RecoveryPass');

		if($this->isResponseRc !== FALSE) {
			$this->response->title = lang('RECOVERYPASS_TITLE');
			switch($this->isResponseRc) {
				case 0:
					$maskMail = maskString($dataRequest->email, 4, $end = 6, '@');
					$this->response->code = 0;
					$this->response->msg = str_replace('{$maskMail$}', $maskMail, lang('RECOVERYPASS_MSG-'.$this->isResponseRc));
					$this->response->icon = 'ui-icon-circle-check';
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('BUTTON_CONTINUE'),
							'link'=> base_url('inicio'),
							'action'=> 'redirect'
						]
					];
					break;
				case -205:
					$msg = lang('RECOVERYPASS_MSG-'.$this->isResponseRc);
					if($this->countryUri == 've') {
						$msg.= '<br>'.lang('ERROR_SUPPORT');
					}
					break;
			}

			if($this->isResponseRc != 0) {
				$this->response->code = 1;
				$this->response->msg = lang('RECOVERYPASS_MSG-'.$this->isResponseRc);
				$this->response->icon = 'ui-icon-info';
				$this->response->data = [
					'btn1'=> [
						'text'=> lang('BUTTON_ACCEPT'),
						'link'=> FALSE,
						'action'=> 'close'
					]
				];
			}
		}

		return $this->response;
	}
	/**
	 * @info Método para el cambio de Contraseña
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function CallWs_ChangePassword_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: ChangePassword Method Initialized');
		$this->className = 'com.novo.objects.TOs.UsuarioTO';

		$this->dataAccessLog->modulo = 'login';
		$this->dataAccessLog->function = 'login';
		$this->dataAccessLog->operation = 'cambioClave';

		$this->dataRequest->userName = $this->session->userdata('userName');
		$this->dataRequest->passwordOld = $dataRequest->currentPass;
		$this->dataRequest->password = $dataRequest->newPass;

		$changePassType = $this->session->flashdata('changePassword');

		$response = $this->sendToService('ChangePassword');

		if($this->isResponseRc !== FALSE) {
			switch($this->isResponseRc) {
				case 0:
					$this->callWs_FinishSession_User();
					$this->response->code = 0;
					$this->response->msg = lang('CHANGEPASSWORD_MSG-'.$this->isResponseRc);
					$this->response->icon = 'ui-icon-circle-check';
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('BUTTON_CONTINUE'),
							'link'=> base_url('inicio'),
							'action'=> 'redirect'
						]
					];
					break;
				case -4:
				case -22:
					$this->response->code = 1;
					$this->response->icon = 'ui-icon-alert';
					$this->response->msg = lang('CHANGEPASSWORD_MSG-'.$this->isResponseRc);
					$this->response->data = [
						'btn1'=> [
							'text'=> lang('BUTTON_ACCEPT'),
							'link'=> FALSE,
							'action'=> 'close'
						]
					];
					$this->session->set_flashdata('changePassword', $changePassType);
					$this->session->set_flashdata('userType', $this->session->flashdata('userType'));
					break;
			}
		}

		return $this->response;
	}
	/**
	 * @info Método para el cierre de sesión
	 * @author J. Enrique Peñaloza Piñero
	 */
	public function callWs_FinishSession_User($dataRequest = FALSE)
	{
		log_message('INFO', 'NOVO User Model: FinishSession method Initialized');
		$user = $dataRequest ? mb_strtoupper($dataRequest->user) : $this->session->userdata('userName');
		$this->className = 'com.novo.objects.TOs.UsuarioTO';

		$this->dataAccessLog->userName = $user;
		$this->dataAccessLog->modulo = 'logout';
		$this->dataAccessLog->function = 'logout';
		$this->dataAccessLog->operation = 'desconectarUsuario';

		$this->dataRequest->idUsuario = $user;
		$this->dataRequest->codigoGrupo = $this->session->userdata('codigoGrupo');

		$response = $this->sendToService('FinishSession');

		if($this->isResponseRc !== FALSE) {
			$this->response->code = 0;
			$this->response->msg = lang('FINISHSESSION_MSG-'.$this->isResponseRc);
			$this->response->data = 'finishSession';
		}

		$this->session->sess_destroy();
		return $this->response;
	}

	public function callWs_validateCaptcha_User($dataRequest)
	{
		$this->load->library('recaptcha');
		$result = $this->recaptcha->verifyResponse($dataRequest->token);

		$logMessage = 'NOVO ['.$dataRequest->user.'] RESPONSE: recaptcha: País: "' .$this->config->item('country');
		$logMessage.= '", Score: "' . $result["score"] .'", Hostname: "'. $result["hostname"].'"';
		log_message('DEBUG', $logMessage);

		$this->response->title = lang('SYSTEM_NAME');
		if($result["score"] <= 0) {

			$this->response->owner = 'captcha';
			$this->response->code = 1;
			$this->response->icon = 'ui-icon-closethick';
			$this->response->msg = lang('VALIDATECAPTCHA_MSG-0');
			$this->response->data = [
				'btn1'=> [
					'text'=> lang('BUTTON_ACCEPT'),
					'link'=> base_url('inicio'),
					'action'=> 'close'
				]
			];
		} else {
			$this->callWs_Login_User($dataRequest->dataLogin[0]);
			$this->response->owner = 'login';

		}
		return $this->response;
	}

	public function isUserLoggedIn($username)
	{
		$sql = $this->db->select(array('id','username'))
						->where('username',$username)
						->get_compiled_select('cpo_sessions', FALSE);

		$result = $this->db->get()->result_array();

		if(!isset($result[0]['username'])) {

			return true;
		} else {
			$this->db->where('id',$result[0]['id']);
			$this->db->delete('cpo_sessions');

			return false;
		}
	}
}
