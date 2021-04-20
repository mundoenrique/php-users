<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Librería para validar el acceso del usuario a las funciones
 * @author J. Enrique Peñaloza Piñero
 * @date May 17th, 2020
 */
class Verify_Access {
	private $CI;
	private $class;
	private $method;
	private $operation;
	private $requestServ;
	private $responseDefect;
	private $user;

	public function __construct()
	{
		log_message('INFO', 'NOVO Verify_Access Library Class Initialized');

		$this->CI = &get_instance();
		$this->requestServ = new stdClass();
		$this->user = $this->CI->session->userName;
	}
	/**
	 * @info método que valida los datos de los formularios enviados
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function validateForm($rule, $countryUri, $user, $class = FALSE)
	{

		log_message('INFO', 'NOVO Verify_Access: validateForm method initialized');

		$result = $this->CI->form_validation->run($rule);

		log_message('DEBUG', 'NOVO ['.$user.'] VALIDATION FORM '.$rule.': '.json_encode($result, JSON_UNESCAPED_UNICODE));

		if(!$result) {
			log_message('DEBUG', 'NOVO  ['.$user.'] VALIDATION '.$rule.' ERRORS: '.json_encode(validation_errors(), JSON_UNESCAPED_UNICODE));
		}

		if ($class) {
			languageLoad('generic', $class);
			$this->CI->config->set_item('language', 'spanish-'.$countryUri);
			languageLoad('specific', $class);
		}

		return $result;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function createRequest($rule, $user)
	{
		log_message('INFO', 'NOVO Verify_Access: createRequest method initialized');

		foreach ($_POST AS $key => $value) {
			switch($key) {
				case 'request':
				case 'plot':
				case 'cpo_name':
				break;
				case 'screenSize':
					$this->CI->session->set_userdata('screenSize', $value);
				break;
				default:
				$this->requestServ->$key = $value;
			}
		}

		unset($_POST);
		log_message('INFO', 'NOVO ['.$user.'] '.$rule.' REQUEST CREATED '.json_encode($this->requestServ, JSON_UNESCAPED_UNICODE));

		return $this->requestServ;
	}
	/**
	 * @info método para crear el request al modelo
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 17th, 2020
	 */
	public function ResponseByDefect($user)
	{
		log_message('INFO', 'NOVO Verify_Access: ResponseByDefect method initialized');

		$this->responseDefect = new stdClass();
		$this->responseDefect->code = lang('GEN_DEFAULT_CODE');
		$this->responseDefect->icon = lang('CONF_ICON_DANGER');
		$this->responseDefect->title = lang('GEN_SYSTEM_NAME');
		$this->responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), '');
		$this->responseDefect->data = base_url('inicio');
		$this->responseDefect->modalBtn = [
			'btn1'=> [
				'text'=> lang('GEN_BTN_ACCEPT'),
				'link'=> 'inicio',
				'action'=> 'redirect'
			]
		];

		if ($this->CI->session->has_userdata('logged')) {
			$this->responseDefect->msg = novoLang(lang('GEN_VALIDATION_INPUT'), lang('GEN_VALIDATION_LOGGED'));
			$this->CI->load->model('Novo_User_Model', 'finishSession');
			$this->CI->finishSession->callWs_FinishSession_User();
		}

		log_message('DEBUG', 'NOVO  ['.$user.'] ResponseByDefect: '.json_encode($this->responseDefect, JSON_UNESCAPED_UNICODE));

		return $this->responseDefect;
	}
	/**
	 * @info método que valida la autorización de acceso del usuario a los módulos
	 * @author J. Enrique Peñaloza Piñero
	 * @date May 19th, 2020
	 */
	public function accessAuthorization($module, $countryUri, $user = FALSE)
	{
		log_message('INFO', 'NOVO Verify_Access: accessAuthorization method initialized');

		$auth = FALSE;
		$user = $user ?: $this->user;
		$freeAccess = ['signin', 'suggestion', 'accessRecover', 'finishSession', 'userIdentify', 'termsConditions', 'accessRecoverOTP', 'validateOTP'];
		$auth = in_array($module, $freeAccess);

		if(!$auth) {
			if ($this->CI->session->has_userdata('userId') && $this->CI->session->clientAgent != $this->CI->agent->agent_string()) {
				clearSessionsVars();
				$module = 'noModule';
			}

			switch($module) {
				case 'userCardsList':
				case 'profileUser':
				case 'updateProfile':
					$auth = $this->CI->session->has_userdata('logged');
				break;
				case 'keepSession':
				case 'professionsList':
				case 'statesList':
				case 'cityList':
				case 'regions':
					$auth = $this->CI->session->has_userdata('logged') || $this->CI->session->has_userdata('userId');
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
				case 'getVirtualDetail':
					$auth = $this->CI->session->has_userdata('products');
				break;
				case 'expensesCategory':
				case 'getMovements':
				case 'downloadInquiry':
					$auth = $this->CI->session->has_userdata('products') && lang('CONF_REPORTS') == 'ON';
				break;
				case 'signup':
					$auth = $this->CI->agent->referrer() == base_url(lang('GEN_LINK_USER_IDENTITY')) && $this->CI->session->has_userdata('userIdentity');
				break;
				case 'signUpData':
					$auth = $this->CI->session->has_userdata('userNameValid');
				break;
				case 'validNickName':
					$auth = $this->CI->session->has_userdata('userName');
				break;
				case 'changePassword':
					$auth = ($this->CI->session->flashdata('changePassword') != NULL || $this->CI->session->has_userdata('logged'));
				break;
			}
		}

		log_message('INFO', 'NOVO ['.$user.'] accessAuthorization '. $module.': '.json_encode($auth, JSON_UNESCAPED_UNICODE));

		return $auth;
	}
}
