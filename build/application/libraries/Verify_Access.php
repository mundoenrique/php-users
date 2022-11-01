<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Librería para validar el acceso del usuario a las funciones
 * @author J. Enrique Peñaloza Piñero
 * @date May 17th, 2020
 */
class Verify_Access
{
	private $CI;

	public function __construct()
	{
		writeLog('INFO', 'Verify_Access Library Class Initialized');

		$this->CI = &get_instance();
	}
	/**
	 * @info método que valida los datos de los formularios enviados
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function validateForm($validationMethod)
	{
		writeLog('INFO', 'Verify_Access: validateForm method initialized');

		$this->CI->form_validation->set_error_delimiters('', '---');
		$this->CI->config->set_item('language', 'global');
		$result = $this->CI->form_validation->run($validationMethod);

		writeLog('DEBUG', 'VALIDATION FORM ' . $validationMethod . ': ' . json_encode($result, JSON_UNESCAPED_UNICODE));

		if (!$result) {
			writeLog('ERROR', 'VALIDATION ' . $validationMethod . ' ERRORS: ' .
				json_encode(validation_errors(), JSON_UNESCAPED_UNICODE));
		}

		return $result;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function createRequest($class, $method)
	{
		writeLog('INFO', 'Verify_Access: createRequest method initialized');

		$requestServ = new stdClass();
		$arrAppUserName = explode("-", $this->CI->session->appUserName);
		$appUserName = $arrAppUserName[1];
		$logUsername = '';

		foreach ($_POST as $key => $value) {
			switch ($key) {
				case 'request':
				case 'plot':
				case 'cpo_name':
					break;
				default:
					$requestServ->$key = $value;
			}
		}

		unset($_POST);

		if ($this->CI->session->has_userdata('userName')) {
			$logUsername = $this->CI->session->userName;
		} elseif (isset($requestServ->userName)) {
			$logUsername = mb_strtoupper($requestServ->userName);
		} elseif (isset($requestServ->idNumber)) {
			$logUsername = mb_strtoupper($requestServ->idNumber);
		} elseif (isset($requestServ->documentId)) {
			$logUsername = mb_strtoupper($requestServ->documentId);
		}

		if ($appUserName !== $logUsername) {
			$appUserName = $arrAppUserName[0] . '-' . $logUsername;
			$this->CI->session->set_userdata('appUserName', $appUserName);
		}

		writeLog('DEBUG', 'REQUEST CREATED for ' . $class . ' and method ' . $method . ': '	.
			json_encode($requestServ, JSON_UNESCAPED_UNICODE));

		return $requestServ;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function responseByDefect()
	{
		writeLog('INFO', 'Verify_Access: ResponseByDefect method initialized');

		$responseDefect = new stdClass();
		$responseDefect->code = lang('CONF_DEFAULT_CODE');
		$responseDefect->icon = lang('CONF_ICON_DANGER');
		$responseDefect->title = lang('GEN_SYSTEM_NAME');
		$responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), '');
		$responseDefect->data = base_url(lang('CONF_LINK_SIGNIN'));
		$responseDefect->modalBtn = [
			'btn1' => [
				'text' => lang('GEN_BTN_ACCEPT'),
				'link' => lang('CONF_LINK_SIGNIN'),
				'action' => 'redirect'
			]
		];

		if ($this->CI->session->has_userdata('logged')) {
			$responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), lang('GEN_VALIDATION_LOGGED'));
			$this->CI->load->model('Novo_User_Model', 'finishSession');
			$this->CI->finishSession->callWs_FinishSession_User();
		}

		writeLog('DEBUG', 'ResponseByDefect: ' . json_encode($responseDefect, JSON_UNESCAPED_UNICODE));

		return $responseDefect;
	}
	/**
	 * @info método que valida la autorización de acceso del usuario a los módulos
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 19th, 2020
	 */
	public function accessAuthorization($module)
	{
		writeLog('INFO', 'Verify_Access: accessAuthorization method initialized');

		$isLogged = $this->CI->session->has_userdata('logged');
		$isUserId = $this->CI->session->has_userdata('userId');
		$referrer = $this->CI->agent->referrer();
		$mfaActive = lang('CONF_MFA_ACTIVE') === 'ON';

		if ($isUserId && ($this->CI->session->clientAgent !== $this->CI->agent->agent_string())) {
			clearSessionsVars();
		}

		switch ($module) {
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
			case 'cardToCard':
			case 'cardToBank':
			case 'mobilePayment':
			case 'getBanks':
			case 'getAffiliations':
			case 'affiliationP2P':
			case 'affiliationPMV':
			case 'affiliationP2T':
			case 'deleteAffiliation':
			case 'changeOperationKey':
			case 'transferP2P':
			case 'transferP2T':
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

		writeLog('DEBUG', 'accessAuthorization ' . $module . ': ' . json_encode($auth, JSON_UNESCAPED_UNICODE));

		if (!$auth) {
			$auth = !(preg_match('/Novo_/', $this->CI->router->fetch_class()) === 1);
		}

		return $auth;
	}
}
