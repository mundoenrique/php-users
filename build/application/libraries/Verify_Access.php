<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Librería para validar el acceso del usuario a las funciones
 * @author J. Enrique Peñaloza Piñero
 * @date May 17th, 2020
 */
class Verify_Access {
	private $CI;

	public function __construct()
	{
		log_message('INFO', 'NOVO Verify_Access Library Class Initialized');

		$this->CI =& get_instance();
	}
	/**
	 * @info método que valida los datos de los formularios enviados
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function validateForm($validationMethod, $user)
	{

		log_message('INFO', 'NOVO Verify_Access: validateForm method initialized');

		$this->CI->form_validation->set_error_delimiters('', '---');
		$this->CI->config->set_item('language', 'global');
		$result = $this->CI->form_validation->run($validationMethod);

		log_message('DEBUG', 'NOVO [' . $user . '] VALIDATION FORM ' . $validationMethod . ': ' .
			json_encode($result, JSON_UNESCAPED_UNICODE));

		if(!$result) {
			log_message('ERROR', 'NOVO  [' . $user . '] VALIDATION ' . $validationMethod . ' ERRORS: ' .
				json_encode(validation_errors(), JSON_UNESCAPED_UNICODE));
		}

		return $result;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function createRequest($class, $method, $user)
	{
		log_message('INFO', 'NOVO Verify_Access: createRequest method initialized');

		$requestServ = new stdClass();

		foreach ($_POST AS $key => $value) {
			switch($key) {
				case 'request':
				case 'plot':
				case 'cpo_name':
				break;
				default:
				$requestServ->$key = $value;
			}
		}

		log_message('DEBUG', 'NOVO [' . $user . '] IP ' . $this->CI->input->ip_address() . ' REQUEST CREATED for ' .
			$class .' and method '. $method . ': '	. json_encode($requestServ, JSON_UNESCAPED_UNICODE));

		unset($_POST);

		return $requestServ;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function responseByDefect($user)
	{
		log_message('INFO', 'NOVO Verify_Access: ResponseByDefect method initialized');

		$responseDefect = new stdClass();
		$responseDefect->code = lang('CONF_DEFAULT_CODE');
		$responseDefect->icon = lang('CONF_ICON_DANGER');
		$responseDefect->title = lang('GEN_SYSTEM_NAME');
		$responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), '');
		$responseDefect->data = base_url(lang('CONF_LINK_SIGNIN'));
		$responseDefect->modalBtn = [
			'btn1'=> [
				'text'=> lang('GEN_BTN_ACCEPT'),
				'link'=> lang('CONF_LINK_SIGNIN'),
				'action'=> 'redirect'
			]
		];

		if ($this->CI->session->has_userdata('logged')) {
			$responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), lang('GEN_VALIDATION_LOGGED'));
			$this->CI->load->model('Novo_User_Model', 'finishSession');
			$this->CI->finishSession->callWs_FinishSession_User();
		}

		log_message('DEBUG', 'NOVO  [' . $user . '] IP ' . $this->CI->input->ip_address() . ' ResponseByDefect: ' .
			json_encode($this->responseDefect, JSON_UNESCAPED_UNICODE));

		return $responseDefect;
	}
	/**
	 * @info método que valida la autorización de acceso del usuario a los módulos
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 19th, 2020
	 */
	public function accessAuthorization($module, $user)
	{
		log_message('INFO', 'NOVO Verify_Access: accessAuthorization method initialized');

		$isLogged = $this->CI->session->has_userdata('logged');
		$isUserId = $this->CI->session->has_userdata('userId');
		$referrer = $this->CI->agent->referrer();
		$mfaActive = lang('CONF_MFA_ACTIVE') === 'ON';

		if ($isUserId && ($this->CI->session->clientAgent !== $this->CI->agent->agent_string())) {
			clearSessionsVars();
		}

		switch($module) {
			case 'userCardsList':
			case 'profileUser':
			case 'updateProfile':
				$auth = $isLogged;
				break;
			case 'mfaEnable':
				$auth = $mfaActive && !$this->CI->session->otpActive && $isLogged;
				break;
			case 'mfaConfirm':
				$referrerUrl = $referrer === base_url(lang('CONF_LINK_MFA_ENABLE'));
				$auth = $isLogged && $referrerUrl;
				break;
			case 'activateSecretToken':
				$referrerUrl = $referrer === base_url(lang('CONF_LINK_MFA_CONFIRM') . '/' . lang('CONF_MFA_EMAIL'));
				$auth = $isLogged && !$this->CI->session->otpActive && $referrerUrl;
				break;
			case 'validateTotp':
				$auth = $isLogged && $mfaActive;
				break;
			case 'desactivateSecretToken':
			case 'generateTotp':
				$auth = $isLogged && $this->CI->session->otpActive;
				break;
			case 'getVirtualDetail':
				$auth = $this->CI->session->has_userdata('products') && $this->CI->session->otpMfaAuth;
				break;
			case 'keepSession':
			case 'professionsList':
			case 'statesList':
			case 'cityList':
			case 'regions':
				$auth = $isLogged || $isUserId;
				break;
			case 'getBalance':
			case 'cardDetail':
			case 'monthlyMovements':
			case 'downloadMoves':
			case 'services':
			case 'temporaryLock':
			case 'twirlsCommercial':
			case 'transactionalLimits':
			case 'replacement':
			case 'changePin':
				$auth = $this->CI->session->has_userdata('products');
				break;
			case 'expensesCategory':
			case 'getMovements':
			case 'downloadInquiry':
				$auth = $this->CI->session->has_userdata('products') && lang('CONF_REPORTS') === 'ON';
				break;
			case 'notifications':
			case 'notificationHistory':
				$auth = $this->CI->session->has_userdata('products') && lang('CONF_NOTIFICATIONS') === 'ON';
				break;
			case 'setOperationKey':
			case 'getOperationKey':
			case 'getBanks':
			case 'affiliate':
			case 'changeOperationKey':
			case 'cardToCard':
			case 'cardToBank':
			case 'mobilePayment':
			case 'cardToCreditCard':
			case 'cardToDigitel':
				$auth = $this->CI->session->has_userdata('canTransfer') && $this->CI->session->canTransfer === 'S';
				break;
			case 'signup':
				$referrerUrl = $referrer === base_url(lang('CONF_LINK_USER_IDENTIFY'));
				$auth = $referrerUrl && $this->CI->session->has_userdata('userIdentity');
				break;
			case 'signUpData':
				$auth = $this->CI->session->has_userdata('userNameValid');
				break;
			case 'validNickName':
				$auth = $this->CI->session->has_userdata('userName');
				break;
			case 'changePassword':
				$auth = ($this->CI->session->flashdata('changePassword') !== NULL || $isLogged);
				break;
			default:
				$freeAccess = [
					'signin', 'suggestion', 'accessRecover', 'finishSession', 'userIdentify',
					'termsConditions', 'accessRecoverOTP', 'validateOTP', 'changeLanguage'
				];
				$auth = in_array($module, $freeAccess);
		}

		log_message('DEBUG', 'NOVO [' . $user . '] accessAuthorization ' . $module . ': ' .
			json_encode($auth, JSON_UNESCAPED_UNICODE));

		if (!$auth) {
			$auth = !(preg_match('/Novo_/', $this->CI->router->fetch_class()) === 1);
		}

		return $auth;
	}
}
