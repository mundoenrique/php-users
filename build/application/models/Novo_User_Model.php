<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información de las tarjetas del usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 14th, 2020
 */
class Novo_User_Model extends NOVO_Model
{

  public function __construct()
  {
    parent::__construct();
    writeLog('INFO', 'User Model Class Initialized');
  }
  /**
   * @info Método para el inicio de sesión
   * @author J. Enrique Peñaloza Piñero
   * @date May 14th, 2020
   */
  public function callWs_Signin_User($dataRequest)
  {
    writeLog('INFO', 'User Model: Signin Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Ingreso al sistema';
    $this->dataAccessLog->operation = 'Iniciar sesion';

    $userName = mb_strtoupper($dataRequest->userName);
    $dataRequest->userName = $userName;

    $this->dataAccessLog->userName = $userName;
    $password = decryptData($dataRequest->userPass);
    $argon2 = $this->encrypt_decrypt->generateArgon2Hash($password);
    $authToken = $this->session->flashdata('authToken') ?? '';

    $this->dataRequest->idOperation = '1';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->userName = $userName;
    $this->dataRequest->password = md5($password);

    if (lang('SETT_ARGON2_ACTIVE') === 'ON') {
      $this->dataRequest->password = $argon2->hexArgon2;
      $this->dataRequest->passwordAux = md5($password);
    }

    $this->dataRequest->pais = 'Global';

    if (lang('SETT_IP_VERIFY') === 'ON') {
      $this->dataRequest->codigoOtp = [
        'tokenCliente' => $dataRequest->OTPcode ?? '',
        'authToken' => $authToken
      ];

      $this->dataRequest->guardaIp = $dataRequest->saveIP ?? FALSE;
    }

    if (lang('SETT_MAINTENANCE') === 'ON') {
      $this->isResponseRc = lang('SETT_MAINTENANCE_RC');
    } elseif (isset($dataRequest->OTPcode) && $authToken === '') {
      $this->isResponseRc = 9998;
    } else {
      $this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

      if ($this->isResponseRc === 0) {
        $response = $this->sendToWebServices('callWs_Signin');
      }
    }

    $time = (object) [
      'customerTime' => (int) $dataRequest->currentTime,
      'serverTime' => (int) date("H")
    ];

    $validateRc = $this->isResponseRc === 0 || $this->isResponseRc === -8 || $this->isResponseRc === -205;
    $userCustomer = $response->codPais ?? '';
    $userCustomer = $response->bean->codPais ?? $userCustomer;
    $differUserCust = $userCustomer !== $this->config->item('customer');
    $userLogged = $this->isResponseRc === 0 ? $this->validateUserLogged($userName) : FALSE;

    if (($validateRc && $differUserCust) || $userLogged) {
      if ($this->isResponseRc === 0 && $differUserCust) {
        $userData = [
          'logged' => TRUE,
          'encryptKey' => $response->keyUpdate,
          'sessionId' => $response->logAccesoObject->sessionId,
          'userId' => $response->idUsuario
        ];
        $this->session->set_userdata($userData);
        unset($this->dataRequest->password);
        $this->dataRequest->pais = $userCustomer;
        $this->token = $response->token;
        $this->keyId = $userName;
        $this->callWs_FinishSession_User($this->dataRequest);
      }

      $this->isResponseRc = $differUserCust ? -1 : -28;
    }

    switch ($this->isResponseRc) {
      case 0:
        $this->response->code = 0;
        $this->response->modal = TRUE;
        $this->response->data = base_url(lang('SETT_LINK_CARD_LIST'));
        $fullSignin = TRUE;
        $fullName = mb_strtolower($response->primerNombre) . ' ';
        $fullName .= mb_strtolower($response->primerApellido);
        $formatDate = $this->config->item('format_date');
        $formatTime = $this->config->item('format_time');
        $lastSession = date(
          "$formatDate $formatTime",
          strtotime(
            str_replace('/', '-', $response->fechaUltimaConexion)
          )
        );
        $statusImgValida = FALSE;

        if (property_exists($response, "aplicaImgDoc") && strtoupper($response->aplicaImgDoc) == 'S') {
          $statusImgValida = strtoupper($response->img_valida) == 'FALSE' ? TRUE : FALSE;
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
          'time' => $time,
          'customerSess' => $response->codPais,
          'customerUri' => $this->config->item('customer_uri'),
          'canTransfer' => strtoupper($response->aplicaTransferencia),
          'transferAuth' => FALSE,
          'operKey' => $response->passwordOperaciones === '' ? FALSE : TRUE,
          'affiliate' => $response->afiliado,
          'longProfile' => $response->aplicaPerfil,
          'terms' => $response->tyc,
          'mobilePhone' => $response->celular ?? '',
          'enterpriseCod' => $response->acCodCia ?? '',
          'clientAgent' => $this->agent->agent_string(),
          'missingImages' => $statusImgValida,
          'abbrTypeDocument' => $response->abrev_tipo_id_ext_per ?? '',
          'userEmail' => $response->email,
          'maskMail' => maskString($response->email, 4, $end = 6, '@'),
          'otpActive' => $response->otpActive ?? FALSE,
          'otpChannel' =>  $response->otpChannel ?? FALSE,
          'otpMfaAuth' => lang('SETT_MFA_ACTIVE') === 'OFF'
        ];

        $this->session->set_userdata($userData);

        if (SESS_DRIVER == 'database') {
          $data = ['username' => $userName];
          $this->db->where('id', $this->session->session_id)
            ->update('cpo_sessions', $data);
        }

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
          $this->response->data = base_url(lang('SETT_LINK_CHANGE_PASS'));
        }
        break;

      case -1:
      case -205:
        $this->response->code = 1;
        $this->response->msg = lang('USER_SIGNIN_INVALID_USER');
        $this->response->className = lang('SETT_VALID_INVALID_USER');
        $this->response->position = lang('SETT_VALID_POSITION');

        if (isset($response->bean->intentos) && $response->bean->intentos === 2) {
          $this->response->msg = lang('USER_SIGNIN_WILL_BLOKED');
          $this->response->className = lang('SETT_VALID_INVALID_USER');
          $this->response->position = lang('SETT_VALID_POSITION');
        }
        break;

      case -28:
        $this->response->code = 4;
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->msg = lang('USER_SIGNIN_INCORRECTLY_CLOSED');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;

      case -194:
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = novoLang(lang('USER_SIGNIN_PASS_EXPIRED'), base_url(LANG('SETT_LINK_RECOVER_ACCESS')));
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
        $this->session->set_flashdata('recoverAccess', 'temporalPass');
        break;

      case -8:
      case -35:
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->msg = novoLang(lang('USER_SIGNIN_SUSPENDED_USER'), base_url(LANG('SETT_LINK_RECOVER_ACCESS')));
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
        $this->session->set_flashdata('recoverAccess', 'blockedPass');
        break;

      case -286:
      case -287:
      case -288:
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->msg = $this->isResponseRc === -286 ? lang('GEN_OTP_INVALID') : lang('GEN_OTP_ERROR');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;

      case -424:
        $this->response->code = 2;
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = novoLang(lang('GEN_IP_VERIFY'), $response->bean->emailEnc);
        $this->response->modalBtn['btn1']['action'] = 'none';
        $this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
        $this->response->modalBtn['btn2']['action'] = 'destroy';
        $this->session->set_flashdata('authToken', $response->bean->codigoOtp->authToken);
        break;

      case 9996:
        $this->response->code = 3;
        $this->response->icon = '';
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->msg = novolang(lang('GEN_MSG_MAINT_NOTIF'), assetUrl('images/nueva-expresion-monetaria.png'));
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        $this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
        break;

      case 9997:
        $this->response->code = 4;
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->msg = lang('GEN_MAINTENANCE_MSG');
        $this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
        $this->response->modalBtn['btn1']['action'] = 'redirect';
        break;

      case 9998:
        $this->response->code = 4;
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->msg = lang('GEN_EXPIRE_TIME');
        $this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_ACCEPT');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
    }

    return $this->responseToTheView('callWs_Signin');
  }
  /**
   * @info Método para validar si el usuario esta logueado
   * @author J. Enrique Peñaloza Piñero
   * @date April 29th, 2020
   */
  private function validateUserLogged($userName)
  {
    writeLog('INFO', 'User Model: validateUserLogged Method Initialized');

    $logged = FALSE;

    if (ACTIVE_SAFETY && SESS_DRIVER == 'database') {
      $this->db->select(['id', 'username'])
        ->where('username',  $userName)
        ->get_compiled_select('cpo_sessions', FALSE);

      $result = $this->db->get()->result_array();

      if (count($result) > 0) {
        $this->db->where('id', $result[0]['id'])
          ->delete('cpo_sessions');
        $logged = TRUE;
      }
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
    writeLog('INFO', 'User Model: AccessRecover Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Recuperar acceso';
    $this->dataAccessLog->operation = 'Obtener usuario o clave temporal';
    $this->dataAccessLog->userName = $dataRequest->idNumber;

    $this->dataRequest->idOperation = isset($dataRequest->recoveryPwd) ? '23' : '24';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->id_ext_per = $dataRequest->idNumber;
    $this->dataRequest->email = $dataRequest->email;
    $this->dataRequest->pais = 'Global';
    $maskMail = maskString($dataRequest->email, 4, $end = 6, '@');
    $msgGeneral = '0';

    $this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

    if ($this->isResponseRc === 0) {
      $response = $this->sendToWebServices('callWs_AccessRecover');
    }

    switch ($this->isResponseRc) {
      case 0:
        $recover = isset($dataRequest->recoveryPwd) ? lang('USER_RECOVER_PASS_TEMP') : lang('USER_RECOVER_USERNAME');
        $this->response->msg = novoLang(lang('USER_RECOVER_SUCCESS'),  [$maskMail, $recover]);
        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_CONTINUE');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
        break;
      case -186:
      case -187:
        $msgGeneral = '1';
        $this->response->msg = LANG('USER_RECOVER_DATA_INVALID');
        break;
    }

    if ($this->isResponseRc != 0 && $msgGeneral == '1') {
      $this->response->title = lang('GEN_MENU_ACCESS_RECOVER');
      $this->response->icon = lang('SETT_ICON_INFO');
      $this->response->modalBtn['btn1']['action'] = 'destroy';
    }

    return $this->responseToTheView('callWs_AccessRecover');
  }
  /**
   * @info Método para recuperar contraseña o usuario con OTP
   * @author Jhonnatan Vega
   * @date October 28th, 2020
   */
  public function callWs_AccessRecoverOTP_User($dataRequest)
  {
    writeLog('INFO', 'User Model: AccessRecoverOTP Method Initialized');

    $username = $this->session->flashdata('userName') ?? 'default';
    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Recuperar acceso';
    $this->dataAccessLog->operation = 'Generar código OTP';
    $this->dataAccessLog->userName = $username;

    $this->dataRequest->idOperation = '275';
    $this->dataRequest->className = 'com.novo.objects.MO.GenericBusinessObject';
    $this->dataRequest->tipoDocumento = $dataRequest->typeDocument;
    $this->dataRequest->cedula = $dataRequest->idNumber;
    $this->dataRequest->email = $dataRequest->email;
    $this->dataRequest->opcion = 'generarOTPCpo';
    $this->dataRequest->subOpciones = [
      [
        'subOpcion' => 'validarDatosRecuperarCpo',
        'orden' => '1'
      ]
    ];
    $this->dataRequest->pais = $this->config->item('customer');
    $msgGeneral = 0;

    $this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

    if ($this->isResponseRc === 0) {
      $response = $this->sendToWebServices('callWs_AccessRecoverOTP');
    }

    switch ($this->isResponseRc) {
      case 200:
        $this->session->set_flashdata('authToken', $response->bean->TokenTO->authToken);
        $this->session->set_flashdata('username', $response->logAccesoObject->userName);
        $this->response->code = 0;
        $this->response->msg = lang('GEN_OTP_SENT');
        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->modalBtn['btn1']['action'] = 'none';
        $this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
        $this->response->modalBtn['btn2']['action'] = 'destroy';
        break;
      case -100:
      case -101:
      case -102:
      case -103:
      case -110:
        $msgGeneral = 1;
        $this->response->msg = LANG('USER_RECOVER_DATA_INVALID');
        break;
    }

    if ($this->isResponseRc != 0 && $msgGeneral == 1) {
      $this->response->title = lang('GEN_MENU_ACCESS_RECOVER');
      $this->response->icon = lang('SETT_ICON_INFO');
      $this->response->modalBtn['btn1']['action'] = 'destroy';
    }

    return $this->responseToTheView('callWs_AccessRecoverOTP');
  }
  /**
   * @info Método para validar código OTP en recuperación de acceso
   * @author Jhonnatan Vega
   * @date October 28th, 2020
   */
  public function callWs_ValidateOTP_User($dataRequest)
  {
    writeLog('INFO', 'User Model: ValidateOTP Method Initialized');

    $username = $this->session->flashdata('username');
    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Recuperar Acceso';
    $this->dataAccessLog->operation = 'Validar código OTP';
    $this->dataAccessLog->userName = $username;

    $this->dataRequest->idOperation = '275';
    $this->dataRequest->className = 'com.novo.objects.MO.GenericBusinessObject';
    $this->dataRequest->opcion = 'validarOTPCpo';
    $this->dataRequest->TokenTO = [
      'access_token' => $this->session->flashdata('authToken'),
      'token' => $dataRequest->otpCode,
    ];
    $this->dataRequest->subOpciones = [
      [
        'subOpcion' => 'envioEmailRecuperacionCpo',
        'orden' => '1'
      ]
    ];
    $maskMail = maskString($dataRequest->email, 4, $end = 6, '@');
    $msgGeneral = 0;

    $this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

    if ($this->session->flashdata('authToken') !== NULL && $this->isResponseRc === 0) {
      $response = $this->sendToWebServices('callWs_ValidateOTP');
    } else {
      $this->isResponseRc = 998;
    }

    switch ($this->isResponseRc) {
      case 0:
        $this->response->msg = novoLang(lang('GEN_SENT_ACCESS'), [$maskMail]);
        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
        break;
      case -286:
        $msgGeneral = 1;
        $this->response->msg = lang('GEN_OTP_INCORRECT');
        break;
      case -287:
      case -288:
        $msgGeneral = 1;
        $this->response->msg = lang('GEN_OTP_EXPIRED');
        break;
      case 998:
        $msgGeneral = 1;
        $this->response->code = 4;
        $this->response->msg = lang('USER_TIME_EXPIRE');
        $this->response->modalBtn['btn1']['text'] = 'Aceptar';
        break;
    }

    if ($this->isResponseRc != 0 && $msgGeneral == 1) {
      $this->response->title = lang('GEN_MENU_ACCESS_RECOVER');
      $this->response->icon = lang('SETT_ICON_INFO');
      $this->response->modalBtn['btn1']['action'] = 'destroy';
    }

    return $this->responseToTheView('callWs_ValidateOTP');
  }
  /**
   * @info Método para el cambio de Contraseña
   * @author J. Enrique Peñaloza Piñero
   * @date April 22th, 2020
   */
  public function CallWs_ChangePassword_User($dataRequest)
  {
    writeLog('INFO', 'User Model: ChangePassword Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Clave';
    $this->dataAccessLog->operation = 'Cambiar Clave';

    $current = decryptData($dataRequest->currentPass);
    $new = decryptData($dataRequest->newPass);
    $argon2 = $this->encrypt_decrypt->generateArgon2Hash($new);

    $this->dataRequest->idOperation = '25';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->userName = $this->session->userName;
    $this->dataRequest->passwordOld = md5($current);
    $this->dataRequest->password = md5($new);
    $this->dataRequest->passwordOld4 = md5(strtoupper($new));
    //$this->dataRequest->password = $argon2->hexArgon2;//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS
    //$this->dataRequest->hashMD5 = md5($new);//DESCOMENTAR Y PROBAR CUANDO ESTEN OK LOS SERVICIOS

    $changePassType = $this->session->flashdata('changePassword');
    $this->sendToWebServices('CallWs_ChangePassword');

    switch ($this->isResponseRc) {
      case 0:
        if ($this->session->has_userdata('userId')) {
          $this->callWs_FinishSession_User();
        }

        $this->response->code = 4;
        $goLogin = $this->session->has_userdata('logged') ? '' : lang('USER_PASS_LOGIN');

        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->msg = novoLang(lang('USER_PASS_CHANGED'), $goLogin);
        $this->response->modalBtn['btn1']['text'] = lang('GEN_BTN_CONTINUE');
        $this->response->modalBtn['btn1']['link'] = uriRedirect();
        break;
      case -465:
        $code = 1;
        $this->response->msg = lang('USER_PASS_USED');
        break;
      case -192:
        $code = 1;
        $this->response->msg = lang('USER_PASS_INCORRECT');
        break;
    }

    if ($this->isResponseRc != 0 && $code == 1) {
      $this->session->set_flashdata('changePassword', $changePassType);

      $this->response->icon = lang('SETT_ICON_WARNING');
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
    writeLog('INFO', 'User Model: UserIdentify Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Identificar usuario';
    $this->dataAccessLog->operation = 'validar datos de registro';
    $this->dataAccessLog->userName = $dataRequest->documentId . date('dmy');

    $this->dataRequest->idOperation = '18';
    $this->dataRequest->className = 'com.novo.objects.TOs.CuentaTO';
    $this->dataRequest->cuenta = $dataRequest->numberCard ?? '';
    $this->dataRequest->tipoDocumento = $dataRequest->typeDocument ?? '';
    $this->dataRequest->id_ext_per = $dataRequest->documentId;
    $this->dataRequest->pin = $dataRequest->cardPIN ?? '1234';
    $this->dataRequest->claveWeb = isset($dataRequest->cardPIN) ? md5($dataRequest->cardPIN) : md5('1234');
    $this->dataRequest->pais = $dataRequest->client ?? $this->customer;
    $this->dataRequest->email = $dataRequest->email ?? '';
    $this->dataRequest->tipoTarjeta = isset($dataRequest->virtualCard) ? 'virtual' : (isset($dataRequest->physicalCard) ? 'fisica' : '');
    $authToken = $this->session->flashdata('authToken') ?? '';
    $maskMail = $this->dataRequest->email != '' ? maskString($this->dataRequest->email, 4, $end = 6, '@') : '';
    $this->dataRequest->otp = [
      'authToken' => $authToken,
      'tokenCliente' => (isset($dataRequest->codeOtp) && $dataRequest->codeOtp != '') ? $dataRequest->codeOtp : '',
    ];

    $this->isResponseRc = ACTIVE_RECAPTCHA ? $this->callWs_ValidateCaptcha_User($dataRequest) : 0;

    if ($this->isResponseRc === 0) {
      $response = $this->sendToWebServices('CallWs_UserIdentify');
    }

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
          $userData->CurrentVerifierCode = $response->afiliacion->dig_verificador_aux;
        }

        $this->response->data = $userData;
        $this->response->modal = TRUE;
        $cardNumber = '';

        if (isset($dataRequest->numberCard)) {
          $cardNumber = $dataRequest->numberCard;
        } elseif (isset($response->afiliacion->notarjeta)) {
          $cardNumber = $response->afiliacion->notarjeta;
        } elseif ($response->user->numeroCuentaRecarga) {
          $cardNumber = $response->user->numeroCuentaRecarga;
        }

        $userSess = [
          'userIdentity' => TRUE,
          'encryptKey' => $response->keyUpdate,
          'sessionId' => $response->logAccesoObject->sessionId,
          'userId' => $response->user->id_ext_per,
          'userName' => $response->logAccesoObject->userName,
          'docmentId' => $response->user->id_ext_per,
          'abbrTypeDocument' => $response->user->abrev_tipo_id_ext_per ?? '',
          'token' => $response->token,
          'customerSess' => $dataRequest->client ?? $this->customer,
          'customerUri' => $this->config->item('customer_uri'),
          'clientAgent' => $this->agent->agent_string(),
          'longProfile' => $userData->longProfile,
          'cardNumber' => $cardNumber

        ];
        $this->session->set_userdata($userSess);
        break;
      case 200: //MODAL OTP
        $this->response->code = 2;
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->labelInput = lang('GEN_OTP_LABEL_INPUT');
        $this->response->msg = novoLang(lang('GEN_OTP_MSG'), $maskMail);
        $this->response->modalBtn['btn1']['action'] = 'none';
        $this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
        $this->response->modalBtn['btn2']['link']  = lang('SETT_LINK_USER_IDENTIFY');
        $this->response->modalBtn['btn2']['action'] = 'redirect';

        $this->session->set_flashdata('authToken', $response->bean->otp->authToken);
        break;
      case -21:
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('USER_INVALID_DATE');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -183:
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('GEN_INVALID_CARD');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -184:
      case -304:
      case -308:
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('GEN_INVALID_DATA');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -286: //OTP INVALIDO
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->msg = lang('GEN_OTP_INVALID');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -300: //MENSAJE TARJETA VIRTUAL EXISTENTE
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = novoLang(lang('USER_IDENTIFY_EXIST'), lang('GEN_SYSTEM_NAME'));
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -125: //MENSAJE TARJETA VENCIDA
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('GEN_EXPIRED_PRODUCT');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -343: //MENSAJE TARJETA BLOQUEADA
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('GEN_LOCK_PRODUCT');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -345: //MENSAJE TARJETA BLOQUEADA POR PIN ERRONEOS
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = novoLang(lang('GEN_LOCK_PRODUCT_WRONG_PIN'), lang('GEN_INVALID_DATA'));
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -446: //MENSAJE TARJETA INACTIVA
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('GEN_MENU_USER_IDENTIFY');
        $this->response->msg = lang('GEN_INACTIVE_PRODUCT');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
    }

    return $this->responseToTheView('CallWs_UserIdentify');
  }
  /**
   * @info Método validar la existencia del nombre de usuario
   * @author J. Enrique Peñaloza Piñero
   * @date jun 10th, 2020
   */
  public function CallWs_ValidNickName_User($dataRequest)
  {
    writeLog('INFO', 'User Model: ValidNickName Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Registro';
    $this->dataAccessLog->operation = 'validar nombre de usuario';

    $this->dataRequest->idOperation = '19';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->userName = mb_strtoupper($dataRequest->nickName);

    $response = $this->sendToWebServices('CallWs_ValidNickName');

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
    writeLog('INFO', 'User Model: Signup Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Registro';
    $this->dataAccessLog->operation = 'Registrar usuario';

    $password = decryptData($dataRequest->newPass);
    $argon2 = $this->encrypt_decrypt->generateArgon2Hash($password);

    $this->dataRequest->idOperation = '20';
    $this->dataRequest->className = 'com.novo.objects.MO.RegistroUsuarioMO';
    $this->dataRequest->user = [
      'userName' => mb_strtoupper($dataRequest->nickName),
      'primerNombre' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->firstName)))),
      'segundoNombre' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->middleName)))),
      'primerApellido' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->lastName)))),
      'segundoApellido' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->surName)))),
      'fechaNacimiento' => $dataRequest->birthDate,
      'id_ext_per' => $dataRequest->idNumber,
      'tipo_id_ext_per' => lang('SETT_COUNTRY_CODE')[$this->customer],
      'codPais' => $dataRequest->client ?? $this->customer,
      'sexo' => $dataRequest->gender,
      'notEmail' => '1',
      'notSms' => '1',
      'email' => $dataRequest->email,
      'password' => md5($password),
      'passwordOld4' => md5(mb_strtoupper($password)),
      'aplicaImgDoc' => lang('SETT_LOAD_DOCS') == 'ON' ? 'S' : 'N',
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

    if (isset($dataRequest->internationalCode)) {
      $dataRequest->mobilePhone = $dataRequest->internationalCode . ' ' . $dataRequest->mobilePhone;
    }

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
        'nombre1' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->firstName)))),
        'nombre2' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->middleName)))),
        'apellido1' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->lastName)))),
        'apellido2' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->surName)))),
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
        'ingreso_promedio_mensual' => isset($dataRequest->averageIncome) ? floatFormat($dataRequest->averageIncome) : '',
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

    $response = $this->sendToWebServices('CallWs_Signup');

    if ($this->isResponseRc !== 0) {
      $configUploadFile = lang('SETT_CONFIG_UPLOAD_FILE');
      $configUploadFile['upload_path'] = $this->tool_file->buildDirectoryPath([
        $this->tool_file->buildDirectoryPath([UPLOAD_PATH]),
        strtoupper($this->session->customerUri),
        strtoupper($dataRequest->nickName ?? $this->session->userName),
      ]);

      $this->tool_file->deleteFiles($configUploadFile);
    }

    switch ($this->isResponseRc) {
      case 0:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->msg = lang('USER_SATISFACTORY_REG');
        clearSessionsVars();
        break;
      case -206:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REG_NOT_CONFIRMED');
        clearSessionsVars();
        break;
      case -271:
      case -335:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REG_SOME_DATA');
        clearSessionsVars();
        break;
      case -317:
      case -314:
      case -313:
      case -311:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REG_INACTIVE_CARD');
        clearSessionsVars();
        break;
      case -181:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REGISTERED_MAIL');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -284:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REGISTERED_PHONE');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      case -397:
        $this->response->title = lang('GEN_MENU_SIGNUP');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_CHECK_DATA');
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
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_NOT_VALIDATE_DATA');
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
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_VERIFY_DNI');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        break;
      default:
        clearSessionsVars();
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
    writeLog('INFO', 'User Model: ProfileUser Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Perfil';
    $this->dataAccessLog->operation = 'Datos del usuario';

    $this->dataRequest->idOperation = '30';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->userName = $this->session->userName;

    $response = $this->sendToWebServices('callWs_ProfileUser');
    $phonesList = [];

    switch ($this->isResponseRc) {
      case 0:
        $this->response->code = 0;
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->title = lang('GEN_SYSTEM_NAME');
        $this->response->modalBtn['btn1']['action'] = 'destroy';
        $modal = FALSE;

        if ($this->session->terms == '0') {
          $this->response->code = 4;
          $this->response->msg = lang('USER_ACCEPT_TERMS');
          $modal = TRUE;
        }

        if ($this->session->longProfile == 'S' && $this->session->affiliate == '0') {
          $this->response->code = 4;
          $this->response->msg = lang('USER_ELECTRONIC_MONEY');
          $this->response->modalBtn['btn1']['action'] = 'destroy';
          $modal = TRUE;
        }
        break;
    }

    $profileData = new stdClass();
    $profileData->nickNameProfile = $response->registro->user->userName ?? '';
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
    $profileData->state = $response->direccion->acEstado ?? '';
    $profileData->cityCode = $response->direccion->acCodCiudad ?? '';
    $profileData->city = $response->direccion->acCiudad ?? '';
    $profileData->districtCode = $response->direccion->acCodDistrito ?? '';
    $profileData->district = $response->direccion->acDistrito ?? '';
    $profileData->addresInput = '0';
    $countryCode = '';
    $countryIso = 'off';

    if (lang('SETT_INTERNATIONAL_ADDRESS') == 'ON') {
      $profileData->addresInput = '1';

      if (get_object_vars($response->direccion)) {
        $addressArray = explode('|', $profileData->address);
        $profileData->addresInput = count($addressArray) == 0 || count($addressArray) > 1 ? '1' : '0';
        $countryIso = 'pe';

        if (count($addressArray) > 1) {
          $key = array_search($addressArray[1], array_column(lang('USER_COUNTRIES'), 'iso'));
          $countryCode = lang('USER_COUNTRIES')[$key]['code'];
          $countryIso = lang('USER_COUNTRIES')[$key]['iso'];
          $profileData->address = $addressArray[0];
          $profileData->stateCode = '';
          $profileData->state = $addressArray[2] ?? '';
          $profileData->cityCode = '';
          $profileData->city = $addressArray[3] ?? '';
          $profileData->districtCode = '';
          $profileData->district = $addressArray[4] ?? '';
        }
      }
    }

    $phonesList['otherPhoneNum'] = '';
    $phonesList['landLine'] = '';
    $phonesList['mobilePhone'] = '';
    $phonesList['countryCode'] = '';
    $phonesList['countryIso'] = '';
    $phonesList['otherType'] = '';

    if (isset($response->registro->listaTelefonos)) {
      foreach ($response->registro->listaTelefonos as $phonesType) {
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
            $mobilePhone = $phonesType->numero;
            if (preg_match('/^[\+][0-9]{2,3}[\s]{1}/', $mobilePhone, $matches)) {
              $countryCode = trim($matches[0]);
            }

            if (preg_match('/[0-9]{7,16}$/', $mobilePhone, $matches)) {
              $mobilePhone = trim($matches[0]);
            }

            if ($countryIso == 'off' && $countryCode != '') {
              $key = array_search($countryCode, array_column(lang('USER_COUNTRIES'), 'code'));
              $countryIso = lang('USER_COUNTRIES')[$key]['iso'];
            }

            $phonesList['countryCode'] = $countryCode;
            $phonesList['countryIso'] = $countryIso;
            $phonesList['mobilePhone'] = $mobilePhone;
            break;
        }
      }
    }

    $profileData->generalAccount =  '';

    if ($profileData->longProfile == 'S') {
      $cardNumber = $response->registro->afiliacion->notarjeta ?? '';
      $this->session->set_userdata('cardNumber', $cardNumber);

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

      $profileData->cityCode = isset($response->registro->afiliacion->provincia) &&  $response->registro->afiliacion->provincia != ''
        ? $response->registro->afiliacion->provincia : $profileData->cityCode;

      $profileData->districtCode = $response->registro->afiliacion->distrito ?? '';
      $profileData->district = '';

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

      $profileData->averageIncome = isset($response->registro->afiliacion->ingreso_promedio_mensual) && $response->registro->afiliacion->ingreso_promedio_mensual != ''
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
            $fullPathToImage = UPLOAD_PATH . $this->tool_file->buildDirectoryPath([
              strtoupper($this->session->customerUri),
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
    writeLog('INFO', 'User Model: UpdateProfile Method Initialized');

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
    $this->dataRequest->country = $this->session->customerSess;

    if (isset($dataRequest->internationalCode)) {
      $dataRequest->mobilePhone = $dataRequest->internationalCode . ' ' . $dataRequest->mobilePhone;
    }

    $this->dataRequest->registro = [
      'user' => [
        'userName' => $this->session->userName,
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
        'notarjeta' => $this->session->cardNumber,
        'idpersona' => $this->session->userId,
        'nombre1' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->firstName)))),
        'nombre2' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->middleName)))),
        'apellido1' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->lastName)))),
        'apellido2' => implode(' ', array_filter(explode(' ', mb_strtoupper($dataRequest->surName)))),
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
        'ingreso_promedio_mensual' => isset($dataRequest->averageIncome) ? floatFormat($dataRequest->averageIncome) : '',
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
    if (isset($dataRequest->country) && $dataRequest->country != 'pe') {
      $dataRequest->address = $dataRequest->address . '|' . $dataRequest->country . '|' . $dataRequest->stateInput . '|' . $dataRequest->cityInput;
      $dataRequest->address .=  '|' . $dataRequest->districtInput;
      $dataRequest->state = '15000';
      $dataRequest->city = '15008';
      $dataRequest->district = '8315';
    }

    $this->dataRequest->direccion = [
      'acTipo' => $dataRequest->addressType,
      'acCodPais' => $this->session->customerSess,
      'acCodEstado' => $dataRequest->state,
      'acCodCiudad' => $dataRequest->city,
      'acCodDistrito' => $dataRequest->district ?? '',
      'acZonaPostal' => $dataRequest->postalCode,
      'acDir' => $dataRequest->address
    ];
    $this->dataRequest->isParticular = TRUE;
    $this->dataRequest->rc = 0;

    if ($mailAvailable) {
      $response = $this->sendToWebServices('CallWs_UpdateProfile');
    }

    switch ($this->isResponseRc) {
      case 0:
        $this->response->title = lang('USER_PROFILE_TITLE');
        $this->response->icon = lang('SETT_ICON_SUCCESS');
        $this->response->msg = lang('USER_UPDATE_SUCCESS');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_USER_PROFILE');

        if ($this->session->terms == '0') {
          $this->session->set_userdata('terms', '1');
          $this->response->modalBtn['btn1']['link'] = uriRedirect();
        }

        if ($this->session->affiliate == '0') {
          $this->session->set_userdata('affiliate', '1');
          $this->response->modalBtn['btn1']['link'] = uriRedirect();
        }

        $emailUser = [
          'userEmail' => $dataRequest->email,
          'maskMail' => maskString($dataRequest->email, 4, $end = 6, '@'),
        ];

        $this->session->set_userdata($emailUser);

        break;
      case -200:
      case -271:
        $this->response->title = lang('USER_PROFILE_TITLE');
        $this->response->msg = lang('USER_UPDATE_FAIL');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_USER_PROFILE');
        break;
      case -335:
        $this->response->title = lang('USER_PROFILE_TITLE');
        $this->response->msg = lang('USER_INVALID_DIGIT');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_USER_PROFILE');
        break;
      case -21:
      case -311:
      case -313:
      case -314:
      case -317:
        $this->response->icon = lang('SETT_ICON_WARNING');
        $this->response->title = lang('USER_PROFILE_TITLE');
        $this->response->msg = lang('USER_ACTIVATION_FAIL');
        $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_USER_PROFILE');
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
    writeLog('INFO', 'User Model: ValidateEmail Method Initialized');

    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Actualizar email';
    $this->dataAccessLog->operation = 'Validar email';

    $this->dataRequest->idOperation = 'verificarEmailCPO';
    $this->dataRequest->className = 'com.novo.objects.TO.UsuarioTO';
    $this->dataRequest->email = $dataRequest->email;

    $response = $this->sendToWebServices('callWs_ValidateEmail');

    switch ($this->isResponseRc) {
      case 0:
        $this->response->title = lang('USER_PROFILE_TITLE');
        $this->response->icon = lang('SETT_ICON_INFO');
        $this->response->msg = lang('USER_REGISTERED_MAIL');
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
    writeLog('INFO', 'User Model: KeepSession Method Initialized');

    $response = new stdClass();
    $response->responseCode =  0;
    $response->data =  NULL;
    $this->makeAnswer($response);
    $this->response->code = 0;

    foreach ($this->session->flashdata() as $key => $value) {
      $this->session->set_flashdata($key, $value);
    }

    return $this->responseToTheView('KeepSession');
  }
  /**
   * @info Método para el cambiar el idioma de la aplicaición
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2021
   */
  public function callWs_ChangeLanguage_User($dataRequest)
  {
    writeLog('INFO', 'User Model: ChangeLanguage Method Initialized');

    $response = new stdClass();
    $response->responseCode =  0;
    $response->data = NULL;
    $this->makeAnswer($response);
    $this->response->code = 0;

    languageCookie(lang('GEN_AFTER_LANG'));

    return $this->responseToTheView('ChangeLanguage');
  }
  /**
   * @info Método para el cierre de sesión
   * @author J. Enrique Peñaloza Piñero
   * @date May 1st, 2019
   */
  public function callWs_FinishSession_User($dataRequest = FALSE)
  {
    writeLog('INFO', 'User Model: FinishSession Method Initialized');

    $userName = $dataRequest ? mb_strtoupper($dataRequest->userName) : $this->session->userName;

    $this->dataAccessLog->userName = $userName;
    $this->dataAccessLog->modulo = 'Usuario';
    $this->dataAccessLog->function = 'Salir del sistema';
    $this->dataAccessLog->operation = 'Cerrar sesion';

    $this->dataRequest->idOperation = 'desconectarUsuario';
    $this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
    $this->dataRequest->userName = $userName;

    $response = $this->sendToWebServices('callWs_FinishSession');

    $this->response->code = 0;
    $this->response->msg = lang('GEN_BTN_ACCEPT');
    $this->response->data = FALSE;

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
    writeLog('INFO', 'User Model: validateCaptcha Method Initialized');

    $this->load->library('recaptcha');

    $userName = $dataRequest->userName ?? ($dataRequest->idNumber ?? ($dataRequest->documentId ?? ''));
    $result = $this->recaptcha->verifyResponse($dataRequest->token, $userName);

    writeLog('DEBUG', 'RESPONSE: recaptcha, Score: ' . $result["score"] . ', Hostname: ' . $result["hostname"]);

    $resultRecaptcha = $result["score"] <= lang('SETT_SCORE_CAPTCHA')[ENVIRONMENT] ? 9999 : 0;

    if ($resultRecaptcha == 9999) {
      $this->response->code = 4;
      $this->response->title = lang('GEN_SYSTEM_NAME');
      $this->response->icon = lang('SETT_ICON_DANGER');
      $this->response->msg = lang('USER_SIGNIN_RECAPTCHA_VALIDATE');
      $this->response->modalBtn['btn1']['link'] = lang('SETT_LINK_SIGNIN');
      $this->response->modalBtn['btn1']['action'] = 'redirect';
    }

    return $resultRecaptcha;
  }
}
