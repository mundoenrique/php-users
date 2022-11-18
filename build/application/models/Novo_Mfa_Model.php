<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la peticion de los servicios
 * @author Luis Molina.
 * @date June 29th, 2022
 */
class Novo_Mfa_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		writeLog('INFO', 'Mfa Model Class Initialized');
	}

	/**
	 * @info Método para generar Secret Token del multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_ActivateSecretToken_Mfa($dataRequest)
	{
		writeLog('INFO', 'Mfa Model: ActivateSecretToken Method Initialized');

		$this->dataRequest->uri = 'secret-token/generate';
		$this->dataRequest->requestBody = [
			'username' => $this->session->userName,
			'authenticationChannel' => $dataRequest->channel
		];

		$response = $this->sendToMfaServices('callWs_ActivateSecretToken');

		switch ($this->isResponseRc) {
			case 0:
				$this->response->code = 0;

				if ($dataRequest->resendToken) {
					$this->response->code = 4;
					$this->response->title = lang('GEN_MENU_MFA');
					$this->response->icon = lang('CONF_ICON_SUCCESS');
					$this->response->msg = novoLang(lang('MFA_TWO_FACTOR_RESEND_CODE'), $this->session->maskMail);
					$this->response->modalBtn['btn1']['action'] = 'destroy';
				}

				$this->response->data = $response;
				break;

			case 462:
				$this->response->title = lang('GEN_MENU_MFA');
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = lang('MFA_TWO_FACTOR_ENABLED');
				$this->session->set_userdata('otpActive', TRUE);
				$this->session->set_userdata('otpChannel', $dataRequest->channel);
				break;
		}

		return $this->responseToTheView('callWs_ActivateSecretToken');
	}

	/**
	 * @info Método para desactivar Secret Token de multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_GenerateTotp_Mfa($dataRequest)
  {
    writeLog('INFO', 'Mfa Model: GenerateTotp Method Initialized');

		$uriValidateTopt = [
			lang('CONF_MFA_GENERATE_OTP') => 'otp/generate',
			lang('CONF_MFA_DEACTIVATE') => 'secret-token/deactivate',
		];

		$this->dataRequest->uri = $uriValidateTopt[$dataRequest->operationType];
		$this->dataRequest->requestBody = [
			'username' => $this->session->userName
		];

    $response = $this->sendToMfaServices('callWs_GenerateTotp');

		switch ($this->isResponseRc) {
			case 0:
				$msgArray = [lang('GEN_EMAIL'), '(' . $this->session->maskMail . ')'];

				$this->response->code = 0;
				$this->response->title = lang('GEN_MENU_MFA');
				$this->response->icon = lang('CONF_ICON_SUCCESS');
				$this->response->msg = novoLang(lang('GEN_TWO_FACTOR_CODE_VERIFY'), $msgArray);
				$this->response->msg.=  ' ' . lang('GEN_TWO_FACTOR_SEND_CODE');
				$this->response->modalBtn['btn1']['action'] = 'none';
				break;

			default:
				$this->response->modalBtn['btn1']['action'] = 'destroy';
		}

		return $this->responseToTheView('callWs_GenerateTotp');
  }

	/**
	 * @info Método para validar codigo OTP de multifactor autenticación
   * @author Luis Molina.
   * @date Jul 07th, 2022
	 */
	public function callWs_ValidateTotp_Mfa($dataRequest)
	{
		writeLog('INFO', 'Mfa Model: ValidateTotp Method Initialized');

		$uriValidateTopt = [
			lang('CONF_MFA_ACTIVATE') => 'secret-token/generate/confirm',
			lang('CONF_MFA_DEACTIVATE') => 'secret-token/deactivate/confirm',
			lang('CONF_MFA_VALIDATE_OTP') => 'otp/validate',
		];
		$otpChannel = isset($dataRequest->channel) ? $dataRequest->channel : $this->session->otpChannel;

		$this->dataRequest->uri = $uriValidateTopt[$dataRequest->operationType];
		$this->dataRequest->requestBody = [
			'username' => $this->session->userName,
			'otpValue' => $dataRequest->authenticationCode,
		];

		$response = $this->sendToMfaServices('callWs_ValidateTotp');

    switch ($this->isResponseRc) {
			case 0:
				$this->response->title = lang('GEN_MENU_MFA');
				$this->response->icon = lang('CONF_ICON_SUCCESS');

				if ($dataRequest->operationType === lang('CONF_MFA_ACTIVATE')) {
					$this->response->msg = lang('MFA_TWO_FACTOR_ENABLED');
					$this->session->set_userdata('otpActive', TRUE);
					$this->session->set_userdata('otpChannel', $otpChannel);
					$this->response->modalBtn['btn1']['link'] = 'card-list';
				}

				if ($dataRequest->operationType === lang('CONF_MFA_DEACTIVATE')) {
					$this->response->msg = lang('MFA_TWO_FACTOR_DISABLED_REDIRECT');
					$this->response->modalBtn['btn1']['link'] = 'two-factor-enablement';
					$this->session->unset_userdata('otpActive');
					$this->session->unset_userdata('otpChannel');
					$this->session->unset_userdata('otpMfaAuth');
					$this->session->unset_userdata('products');
				}

				if ($dataRequest->operationType === lang('CONF_MFA_VALIDATE_OTP')) {
					if ($response->validationResult) {
						$this->response->code = 0;
						$this->response->modal = TRUE;
						$this->session->set_userdata('otpMfaAuth', TRUE);
					} else {
						$this->response->code = 1;
						$this->response->icon = lang('CONF_ICON_WARNING');
						$this->response->msg = $otpChannel === lang('CONF_MFA_CHANNEL_APP') ? lang('MFA_CODE_INCORRECT') : lang('MFA_CODE_INCORRECT_AGAIN');
						$this->response->modalBtn['btn1']['action'] = 'none';
					}
				}
				break;

			case 464:
				$this->response->title = lang('GEN_MENU_MFA');
				$this->response->icon = lang('CONF_ICON_WARNING');
				$this->response->msg = (isset($dataRequest->channel) && $dataRequest->channel === lang('MFA_CODE_INCORRECT'))
				 	? lang('CONF_MFA_CHANNEL_APP')
					: lang('MFA_CODE_INCORRECT_AGAIN');
				$this->response->modalBtn['btn1']['action'] = 'destroy';

				if ($dataRequest->operationType === lang('CONF_MFA_DEACTIVATE')) {
					$this->response->code = 1;
					$this->response->modalBtn['btn1']['action'] = 'none';
				}
				break;

			default:
				$this->response->modalBtn['btn1']['action'] = 'destroy';

    }

		return $this->responseToTheView('callWs_ValidateTotp');
	}
}
