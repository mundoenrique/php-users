<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class Novo_User_Model extends NOVO_Model
{

	public function __construct()
	{
		parent::__construct();
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
		$this->dataAccessLog->operation = '1';
		$this->dataAccessLog->userName = $dataRequest->user;

		$this->dataRequest->idOperation = '1';
		$this->dataRequest->userName = mb_strtoupper($dataRequest->user);
		$this->dataRequest->password = $dataRequest->pass;
		$this->dataRequest->ctipo = $dataRequest->active;
		$this->dataRequest->pais = 'Global';

		$response = $this->sendToService('Login');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					log_message('DEBUG', 'NOVO [' . $this->dataRequest->userName . '] RESPONSE: Login: ' . json_encode($response->userName));

					if ($this->isUserLoggedIn($dataRequest->user))
					{
						$this->response->code = 1;
						$this->response->msg = lang('RES_OWN_ANOTHER_SESSION');
						$this->response->classIconName = 'ui-icon-alert';
					}else
					{
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

						$target = 'cambiarclave';
						$this->response->msg = lang('RES_ACCESS_RECOVERED');
						if (intval($response->passwordTemp)) {
							$reasonOperation = 't';
						} elseif (intval($response->passwordVencido)) {
							$reasonOperation = 'v';
						}else{

							$target = 'vistaconsolidada';
							$reasonOperation =  NULL;
							$this->response->msg = '';

							$this->db->where('id', $this->session->session_id);
							$this->db->update('cpo_sessions', ['username' => $dataRequest->user]);
						}
						is_null($reasonOperation)? '' : $this->session->set_flashdata('changePassword', $reasonOperation);

						$this->response->code = 0;
						$this->response->data = is_null($reasonOperation)? str_replace('/' . 'bdb' . '/', '/', base_url($target)) : base_url($target);
					}
					break;
				case -1:
				case -263:
					$this->response->code = 1;
					$this->response->msg = lang('RES_BAD_USER_PASSWORD');
					$this->response->classIconName = 'ui-icon-closethick';
					break;
				case -8:
				case -35:
					$this->response->code = 1;
					$this->response->msg = lang('RES_SUSPENDED_USER');
					$this->response->classIconName = 'ui-icon-alert';
					break;
				case -194:
					$this->response->code = 1;
					$this->response->msg = lang('RES_EXPIRED_TEMPORARY_KEY');
					$this->response->classIconName = 'ui-icon-alert';
					break;
			}
		}
		return $this->response;
	}

	public function callWs_validateCaptcha_User($dataRequest)
	{
		$this->load->library('recaptcha');
		$result = $this->recaptcha->verifyResponse($dataRequest->token);

		$logMessage = 'NOVO [' . $dataRequest->user . '] RESPONSE: recaptcha: País: "' . $this->config->item('country');
		$logMessage .= '", Score: "' . $result["score"] . '", Hostname: "' . $result["hostname"] . '"';
		log_message('DEBUG', $logMessage);

		if ($result["score"] <= 0) {

			$this->response->owner = 'captcha';
			$this->response->code = 4;
			$this->response->icon = 'ui-icon-closethick';
			$this->response->msg = lang('RES_ERROR_CAPTCHA');
			$this->response->data = [
				'btn1' => [
					'text' => lang('BUTTON_ACCEPT'),
					'link' => base_url('inicio'),
					'action' => 'close'
				]
			];
		} else {
			$this->callWs_Login_User($dataRequest->dataLogin[0]);
			$this->response->owner = 'login';
		}
		return $this->response;
	}

	public function callWs_verifyAccount_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: verifyAccount  method Initialized');

		$date = new DateTime();
		$fechaRegistro = $date->format('mdy');

		$this->className = 'com.novo.objects.TOs.CuentaTO';

		$this->dataAccessLog->modulo = 'validar cuenta';
		$this->dataAccessLog->function = 'validar cuenta';
		$this->dataAccessLog->operation = 'validar cuenta';
		$this->dataAccessLog->userName = $dataRequest->id_ext_per . $fechaRegistro;

		// fake data
		$this->dataAccessLog->sessionId = "";
		$this->dataAccessLog->RC = 0;
		$this->dataAccessLog->IP = "::1";
		$this->dataAccessLog->dttimesstamp = "10\/21\/2019 15:28";
		$this->dataAccessLog->lenguaje = "ES";

		$this->dataRequest->idOperation = '18';
		$this->dataRequest->id_ext_per = $dataRequest->id_ext_per;
		$this->dataRequest->telephoneNumber = $dataRequest->telephone_number;
		$this->dataRequest->pais = 'Ve';

		// fake data
		$this->dataRequest->cuenta = "6048411619458425";
		$this->dataRequest->pin = "6e08dc8e4e3ac59d3c61dc0ff2f59c7c";
		$this->dataRequest->claveWeb = "9d98257cef258260de0cf058ff3e93d7";

		$response = $this->sendToService('User');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$newdata	= array(
						'userName'	=> $this->dataAccessLog->userName,
						'pais'		=> $this->dataRequest->pais,
						'id_ext_per'	=> $this->dataRequest->id_ext_per,
						'token'		=> $this->token,
						'sessionId'	=> "f98d07e6927f8f3ada10a909cca1dec7",
						'keyId'		=> "MTgyNjcxMDg=",
						'cl_addr'	=> np_Hoplite_Encryption($_SERVER['REMOTE_ADDR'], 0)
					);
					$this->session->set_userdata($newdata);

					$this->session->set_flashdata('registryUser', 'TRUE');
					$this->session->set_flashdata('registryUserData', $response);

					$this->response->code = 0;
					$this->response->data = base_url('registro');
					break;
				case -184:
					$this->response->code = 2;
					$this->response->msg = lang('RES_DATA_INVALIDATED');
					$this->response->classIconName = 'ui-icon-alert';
					break;
			}
		}
		return $this->response;
	}

	public function callWs_registry_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Registty method Initialized');

		$user = array(
			"userName" => $dataRequest->username,
			"primerNombre" => $dataRequest->firstName,
			"segundoNombre" => $dataRequest->middleName,
			"primerApellido"	=> $dataRequest->lastName,
			"segundoApellido"	=> $dataRequest->secondSurname,
			"fechaNacimiento"	=> $dataRequest->birthDate,
			"id_ext_per"		=> $dataRequest->idNumber,
			"tipo_id_ext_per"	=> $dataRequest->tipo_id_ext_per,
			"codPais"			=> $dataRequest->pais,
			"sexo"				=> 'M',
			"notEmail"			=> "1",
			"notSms"			=> "1",
			"email"				=> $dataRequest->email,
			"password"			=> md5($dataRequest->userpwd),
			"passwordOld4"		=> md5(strtoupper($dataRequest->userpwd))
		);
		$phones = array(
			[
				"tipo"	=> "HAB",
				"numero" => $dataRequest->landLine
			],
			[
				"tipo"	=> "CEL",
				"numero" => $dataRequest->mobilePhone
			],
			[
				"tipo"	=> $dataRequest->otro_telefono,
				"numero" => $dataRequest->otherPhoneNum
			]
		);

		$this->className = 'com.novo.objects.MO.RegistroUsuarioMO';
		$this->dataAccessLog->modulo = 'registro usuario';
		$this->dataAccessLog->function = 'registro usuario';
		$this->dataAccessLog->operation = 'registro usuario';
		$this->dataAccessLog->userName = $dataRequest->username;

		$this->dataRequest->idOperation = '20';
		$this->dataRequest->user = $user;
		$this->dataRequest->listaTelefonos = $phones;
		$this->dataRequest->pais = 'Global';

		//$response = $this->sendToService('User');
		//log_message("info", "Request validar_cuenta:". json_encode($this->dataRequest));
		//
		// if($this->isResponseRc !== FALSE) {
		// 	$this->isResponseRc = 0;
		// 	switch($this->isResponseRc) {

		if (true) {
			$isResponseRc = -181;
			switch ($isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->msg = lang('RES_SUCCESSFUL_REGISTRATION');
					$this->response->classIconName = 'ui-icon-info';
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;

				case -61:
				case -5:
				case -3:
					$this->response->msg = lang('RES_ERROR_SERVER');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;
				case -181:
					$this->response->msg = lang('RES_REGISTERED_MAIL');
					$this->response->code = 3;
					$this->response->classIconName = "ui-icon-alert";
					break;

				case -284:
					$this->response->msg = lang('RES_REGISTERED_CELLPHONE');
					$this->response->code = 3;
					$this->response->classIconName = "ui-icon-alert";
					break;

				case -206:
					$this->response->msg = lang('RES_CONFIRMATION_MAIL_NOT_SENT');
					$this->response->code = 4;
					$this->response->classIconName = "ui-icon-info";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;

				case -230:
					$this->response->code = 1;
					$this->response->msg = lang('RES_ERROR_SERVER');
					$this->response->classIconName = "ui-icon-alert";
					$this->modalType = "alert-error";
					break;

				case -271:
				case -335:
					$this->response->msg = lang('RES_PARTIAL_REGISTRATION');
					$this->response->code = 0;
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;

				case -317:
				case -314:
				case -313:
				case -311:
					$this->response->msg = lang('RES_CARD_NOT_ACTIVATED');
					$this->response->code = 0;
					$this->response->classIconName = "ui-icon-info";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;

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
				case 6000:
					$this->response->msg = lang('RES_ERROR_SERVER');
					$this->response->code = 1;
					$this->response->classIconName = "ui-icon-alert";
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
					$this->response->msg = lang('RES_ERROR_DNI');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->code = 1;
					break;

				case -397:
					$this->response->msg = lang('RES_WRONG_MEMBERSHIP_DATA');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->code = 1;
					break;
			}
		}
		return $this->response;
	}

	public function callWs_recoveryAccess_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Registty method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$ubication = $dataRequest->recovery === 'C' ? 'reset password': 'obtener login';
		$messageNotiSystem = $dataRequest->recovery === 'C' ? 'RES_SEND_EMAIL_PASSWORD': 'RES_SEND_EMAIL_LOGIN';
		$this->dataAccessLog->modulo = $ubication;
		$this->dataAccessLog->function = $ubication;
		$this->dataAccessLog->operation = $ubication;
		$this->dataAccessLog->userName = $dataRequest->idNumber;

		$this->dataRequest->idOperation = $dataRequest->recovery === 'C' ? '23' : '24';
		$this->dataRequest->id_ext_per = $dataRequest->idNumber;
		$this->dataRequest->email = $dataRequest->email;
		$this->dataRequest->pais = 'Global';

		$response = $this->sendToService('User');
		log_message("info", "Request recovery_access:" . json_encode($this->dataRequest));

		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->msg = str_replace( '{$maskMail$}', mask_account($dataRequest->email), lang($messageNotiSystem) );
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;
				case -61:
					$this->response->code = 2;
					$this->response->msg = lang('RES_MESSAGE_SYSTEM');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;
				case -187:
				case -186:
					$this->response->code = 1;
					$this->response->msg = lang('RES_DATA_INVALIDATED');
					$this->response->classIconName = "ui-icon-alert";
					break;
			}
		}
		return $this->response;
	}

	public function callWs_changePassword_User($dataRequest)
	{
		log_message('INFO', 'NOVO User Model: Registty method Initialized');

		$this->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataAccessLog->modulo = 'password';
		$this->dataAccessLog->function = 'password';
		$this->dataAccessLog->operation = 'actualizar';
		$this->dataAccessLog->userName = $this->session->userdata('userName');

		$this->dataRequest->userName = $this->session->userdata('userName');
		$this->dataRequest->pais = 'Ve';
		$this->dataRequest->idOperation = '25';
		$this->dataRequest->passwordOld = md5($dataRequest->currentPassword);
		$this->dataRequest->password = md5($dataRequest->newPassword);
		$this->dataRequest->passwordOld4 = md5(strtoupper($dataRequest->newPassword));
		$this->dataRequest->token = $this->session->userdata('token');

		log_message("info", "Request Change Password:" . json_encode($this->dataRequest));
		$response = $this->sendToService('User');
		if ($this->isResponseRc !== FALSE) {
			switch ($this->isResponseRc) {
				case 0:
					$this->response->code = 0;
					$this->response->msg = lang('RES_ACCESS_RECOVERED');
					$this->response->classIconName = "ui-icon-circle-check";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;
				case -61:
					$this->response->code = 2;
					$this->response->msg = lang('RES_MESSAGE_SYSTEM');
					$this->response->classIconName = "ui-icon-alert";
					$this->response->data = [
						'btn1' => [
							'text' => lang('BUTTON_CONTINUE'),
							'link' => base_url('inicio'),
							'action' => 'redirect'
						]
					];
					break;
				case -187:
				case -186:
					$this->response->code = 1;
					$this->response->msg = lang('RES_DATA_INVALIDATED');
					$this->response->classIconName = "ui-icon-alert";
					break;
			}
		}
		return $this->response;
	}

	public function isUserLoggedIn($username)
	{
		$sql = $this->db->select(array('id', 'username'))
			->where('username', $username)
			->get_compiled_select('cpo_sessions', FALSE);

		$result = $this->db->get()->result_array();

		if (count($result) !== 0) {

			$this->db->where('id', $result[0]['id']);
			$this->db->delete('cpo_sessions');
			return TRUE;
		}
		else {
			return FALSE;
		}
	}

	public function pad_key($key){
		if(strlen($key) > 8) return substr($key, 0, 8);
		return $key;
	}

}
