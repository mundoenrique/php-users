<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Módelo para la información del usuario
 * @author J. Enrique Peñaloza Piñero
 *
 */
class ServiceProduct_Model extends BDB_Model
{

  public function __construct()
  {
    parent::__construct();
    log_message('INFO', 'NOVO User Model Class Initialized');
  }

  public function callWs_generate_ServiceProduct($dataRequest)
  {
    log_message('INFO', 'NOVO Service Product Model: Generate PIN method Initialized');

    $dataProduct = $this->getDataWorkingProduct();

    $this->className = 'com.novo.objects.TOs.CuentaTO';
    $this->dataRequest->idOperation = '121';

    $this->dataAccessLog->modulo = 'Cuentas';
    $this->dataAccessLog->function = 'Generar PIN';
    $this->dataAccessLog->operation = 'Generar PIN';
    $this->dataAccessLog->userName = $this->session->userdata('userName');

    $this->dataRequest->userName = $this->session->userdata('userName');
    $this->dataRequest->token = $this->session->userdata('token');
    $this->dataRequest->codigoOtp = $dataRequest->codeOTP ??  '';
    $this->dataRequest->telephoneNumber = $this->session->userdata('celular');
    $this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
    $this->dataRequest->acCodCia = $this->session->userdata('codCompania');

    if (!empty($dataRequest->codeOTP)) {

      $this->className = 'com.novo.objects.TOs.TarjetaTO';
      $this->dataRequest->idOperation = '120';
      $this->dataRequest->accodUsuario = $this->session->userdata('userName');
      $this->dataRequest->pinNuevo = $dataRequest->newPin;
      $this->dataRequest->prefix = $dataProduct['prefix'];
      $this->dataRequest->fechaExp = $dataProduct['fechaExp'];
      $this->dataRequest->noTarjeta = $dataProduct['noTarjeta'];
    }
    log_message("info", "Request ServiceProduct:" . json_encode($this->dataRequest));
    $response = $this->sendToService('ServiceProduct');

    if ($this->isResponseRc !== FALSE) {
      switch ($this->isResponseRc) {
        case 0:
          $this->response->code = 0;
          $this->response->msg = lang('RESP_PIN_GENERATED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case 10:
          $this->response->code = 1;
          $this->response->msg = lang('RESP_CODEOTP');
          $this->response->validityTime = intval($response->bean) !== 0 ? intval($response->bean) * 60 : $this->defaultTimeOTP * 60;
          break;
        case -308:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_PIN_NOT_VALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -241:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_DATA_INVALIDATED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -345:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_FAILED_ATTEMPTS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -401:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_PIN_NOT_CHANGED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -266:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_LOCKED_CARD');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -286:
          $this->response->code = 5;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_ACCEPT'),
              'action' => 'close'
            ]
          ];

          if ($response->bean == "0") {

            $this->response->code = 3;
            $this->response->msg = lang('RESP_OTP_FAILED_ATTEMPTS');
            $this->response->data = [
              'btn1' => [
                'text' => lang('BUTTON_ACCEPT'),
                'link' => FALSE,
                'action' => 'close'
              ]
            ];
          }
          break;
        case -287:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_USED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -288:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_EXPIRED_CODEOTP');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -301:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -310:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_INVALID_EXPIRATION_DATE');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -306:
          break;
        case -125:
        case -304:
        case -911:
          $this->response->code = 2;
          $this->response->msg = ($this->isResponseRc == -125) ? lang('RESP_EXPIRED_CARD') : lang('RESP_NOT_PROCCESS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -35:
        case -61:
          $this->response->code = 2;
          $this->response->msg =  ($this->isResponseRc == -35) ? lang('RESP_USER_SUSPENDED') : lang('RESP_SESSION_EXPIRED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          $this->session->sess_destroy();
          break;
        default:
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
      }
    }
    return $this->response;
  }
  public function callWs_change_ServiceProduct($dataRequest)
  {
    log_message('INFO', 'NOVO Service Product Model: Change PIN method Initialized');

    $dataProduct = $this->getDataWorkingProduct();

    $this->className = 'com.novo.objects.TOs.TarjetaTO';
    $this->dataAccessLog->modulo = 'Cuentas';
    $this->dataAccessLog->function = 'cambio de PIN';
    $this->dataAccessLog->operation = 'cambio de PIN';
    $this->dataAccessLog->userName = $this->session->userdata('userName');
    $this->dataRequest->token = $this->session->userdata('token');
    $this->dataRequest->acCodCia = $this->session->userdata('codCompania');

    $this->dataRequest->idOperation = '122';

    $this->dataRequest->codigoOtp = $dataRequest->codeOTP ?? '';
    $this->dataRequest->fechaExp = $dataProduct['fechaExp'];
    $this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
    $this->dataRequest->noTarjeta = $dataProduct['noTarjeta'];
    $this->dataRequest->accodUsuario = $this->session->userdata('userName');
    $this->dataRequest->telephoneNumber = $this->session->userdata('celular');
    $this->dataRequest->pin = $dataRequest->pinCurrent;
    $this->dataRequest->pinNuevo = $dataRequest->newPin;
    $this->dataRequest->prefix = $dataProduct['prefix'];


    if (!empty($dataRequest->codeOTP)) {

      $this->dataRequest->idOperation = '112';
      $this->className = 'com.novo.objects.TOs.CuentaTO';

      if ($dataRequest->operation === 'r') {

        $this->dataRequest->idOperation = '215';
        $this->dataAccessLog->modulo = 'Cuentas';
        $this->dataAccessLog->function = 'Recuperar PIN';
        $this->dataAccessLog->operation = 'Recuperar PIN';

        $this->dataRequest->userName = $this->session->userdata('userName');
        $this->dataRequest->token = $this->session->userdata('token');
      }
    }

    log_message("info", "Request Change ServiceProduct:" . json_encode($this->dataRequest));
    $response = $this->sendToService('ServiceProduct');
    if ($this->isResponseRc !== FALSE) {
      switch ($this->isResponseRc) {
        case 0:
          $this->response->code = 0;
          $this->response->msg = lang('RESP_PIN_CHANGED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case 10:
          $this->response->code = 1;
          $this->response->msg = lang('RESP_CODEOTP');
          $this->response->validityTime = intval($response->bean) !== 0 ? intval($response->bean) * 60 : $this->defaultTimeOTP * 60;
          break;
        case -308:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_PIN_NOT_VALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -241:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_DATA_INVALIDATED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -266:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_LOCKED_CARD');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -345:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_FAILED_ATTEMPTS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -401:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_PIN_NOT_CHANGED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -286:
          $this->response->code = 5;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_ACCEPT'),
              'action' => 'close'
            ]
          ];

          if ($response->bean == "0") {

            $this->response->code = 3;
            $this->response->msg = lang('RESP_OTP_FAILED_ATTEMPTS');
            $this->response->data = [
              'btn1' => [
                'text' => lang('BUTTON_ACCEPT'),
                'link' => FALSE,
                'action' => 'close'
              ]
            ];
          }
          break;
        case -287:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_USED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -288:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_EXPIRED_CODEOTP');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -301:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -310:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_INVALID_EXPIRATION_DATE');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -306:
          break;
        case -125:
        case -304:
        case -911:
          $this->response->code = 2;
          $this->response->msg = ($this->isResponseRc == -125) ? lang('RESP_EXPIRED_CARD') : lang('RESP_NOT_PROCCESS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -35:
        case -61:
          $this->response->code = 2;
          $this->response->msg =  ($this->isResponseRc == -35) ? lang('RESP_USER_SUSPENDED') : lang('RESP_SESSION_EXPIRED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          $this->session->sess_destroy();
          break;
        default:
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
      }
    }
    return $this->response;
  }
  public function callWs_lock_ServiceProduct($dataRequest)
  {
    log_message('INFO', 'NOVO Service Product Model: Lock Product method Initialized');

    $dataProduct = $this->getDataWorkingProduct();

    $this->className = 'com.novo.objects.TOs.CuentaTO';
    $this->dataAccessLog->modulo = 'bloquearTarjeta';
    $this->dataAccessLog->function = 'bloquearTarjeta';
    $this->dataAccessLog->operation = 'bloquearTarjeta';
    $this->dataAccessLog->userName = $this->session->userdata('userName');

    $this->dataRequest->idOperation = '123';
    $this->dataRequest->codigoOtp = '';
    $this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
    $this->dataRequest->telephoneNumber = $this->session->userdata('celular');
    $this->dataRequest->acCodCia = $this->session->userdata('codCompania');

    if (!empty($dataRequest->codeOTP)) {
      $this->dataRequest->idOperation = '110';
      $this->className = 'com.novo.objects.TOs.TarjetaTO';
      $this->dataRequest->codigoOtp = $dataRequest->codeOTP;
      $this->dataRequest->fechaExp = $dataProduct['fechaExp'];
      $this->dataRequest->noTarjeta = $dataProduct['noTarjeta'];
      $this->dataRequest->prefix = $dataProduct['prefix'];
      $this->dataRequest->codBloqueo = $dataRequest->unlock ? '00' : 'PB';
      $this->dataRequest->accodUsuario = $this->session->userdata('userName');
    }

    log_message("info", "Request Change ServiceProduct:" . json_encode($this->dataRequest));
    $response = $this->sendToService('ServiceProduct');
    if ($this->isResponseRc !== FALSE) {
      switch ($this->isResponseRc) {
        case 0:
          $this->response->code = 0;
          $this->response->msg = lang('RESP_RC_0');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case 10:
          $this->response->code = 1;
          $this->response->msg = lang('RESP_CODEOTP');
          $this->response->validityTime = intval($response->bean) !== 0 ? intval($response->bean) * 60 : $this->defaultTimeOTP * 60;
          break;
        case -308:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_PIN_NOT_VALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -241:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_DATA_INVALIDATED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -345:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_FAILED_ATTEMPTS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -401:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_PIN_NOT_CHANGED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -286:
          $this->response->code = 5;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_ACCEPT'),
              'action' => 'close'
            ]
          ];

          if ($response->bean == "0") {

            $this->response->code = 3;
            $this->response->msg = lang('RESP_OTP_FAILED_ATTEMPTS');
            $this->response->data = [
              'btn1' => [
                'text' => lang('BUTTON_ACCEPT'),
                'link' => FALSE,
                'action' => 'close'
              ]
            ];
          }
          break;
        case -287:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_USED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -288:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_EXPIRED_CODEOTP');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -301:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -310:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_INVALID_EXPIRATION_DATE');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -306:
          break;
        case -125:
        case -304:
        case -911:
          $this->response->code = 2;
          $this->response->msg = ($this->isResponseRc == -125) ? lang('RESP_EXPIRED_CARD') : lang('RESP_NOT_PROCCESS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -35:
        case -61:
          $this->response->code = 2;
          $this->response->msg =  ($this->isResponseRc == -35) ? lang('RESP_USER_SUSPENDED') : lang('RESP_SESSION_EXPIRED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          $this->session->sess_destroy();
          break;
        default:
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
      }
    }
    return $this->response;
  }

  public function callWs_replace_ServiceProduct($dataRequest)
  {
    log_message('INFO', 'NOVO Service Product Model: Replace Product method Initialized');

    $dataProduct = $this->getDataWorkingProduct();

    $this->className = 'com.novo.objects.TOs.CuentaTO';
    $this->dataAccessLog->modulo = 'bloqueoReposicion';
    $this->dataAccessLog->function = 'bloqueoReposicion';
    $this->dataAccessLog->operation = 'bloqueoReposicion';
    $this->dataAccessLog->userName = $this->session->userdata('userName');

    $this->dataRequest->idOperation = '124';
    $this->dataRequest->codigoOtp = '';
    $this->dataRequest->id_ext_per = $this->session->userdata('idUsuario');
    $this->dataRequest->telephoneNumber = $this->session->userdata('celular');
    $this->dataRequest->acCodCia = $this->session->userdata('codCompania');

    if (!empty($dataRequest->codeOTP)) {
      $this->dataRequest->idOperation = '111';
      $this->className = 'com.novo.objects.TOs.TarjetaTO';
      $this->dataRequest->codigoOtp = $dataRequest->codeOTP;
      $this->dataRequest->fechaExp = $dataProduct['fechaExp'];
      $this->dataRequest->noTarjeta = $dataProduct['noTarjeta'];
      $this->dataRequest->prefix = $dataProduct['prefix'];
      $this->dataRequest->codBloqueo = $dataRequest->reasonRequest;
      $this->dataRequest->accodUsuario = $this->session->userdata('userName');
    }

    log_message("info", "Request Change ServiceProduct:" . json_encode($this->dataRequest));
    $response = $this->sendToService('ServiceProduct');
    if ($this->isResponseRc !== FALSE) {
      switch ($this->isResponseRc) {
        case 0:
          $this->response->code = 0;
          $this->response->msg = lang('RESP_RC_0');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case 10:
          $this->response->code = 1;
          $this->response->msg = lang('RESP_CODEOTP');
          $this->response->validityTime = intval($response->bean) !== 0 ? intval($response->bean) * 60 : $this->defaultTimeOTP * 60;
          break;
        case -308:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_PIN_NOT_VALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -241:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_DATA_INVALIDATED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -345:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_FAILED_ATTEMPTS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -401:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_PIN_NOT_CHANGED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -286:
          $this->response->code = 5;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_ACCEPT'),
              'action' => 'close'
            ]
          ];

          if ($response->bean == "0") {

            $this->response->code = 3;
            $this->response->msg = lang('RESP_OTP_FAILED_ATTEMPTS');
            $this->response->data = [
              'btn1' => [
                'text' => lang('BUTTON_ACCEPT'),
                'link' => FALSE,
                'action' => 'close'
              ]
            ];
          }
          break;
        case -287:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_USED');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -288:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_EXPIRED_CODEOTP');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -301:
          $this->response->code = 3;
          $this->response->msg = lang('RESP_CODEOTP_INVALID');
          $this->response->classIconName = 'ui-icon-info';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -310:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_INVALID_EXPIRATION_DATE');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -306:
          break;
        case -125:
        case -304:
        case -911:
          $this->response->code = 2;
          $this->response->msg = ($this->isResponseRc == -125) ? lang('RESP_EXPIRED_CARD') : lang('RESP_NOT_PROCCESS');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        case -35:
        case -61:
          $this->response->code = 2;
          $this->response->msg =  ($this->isResponseRc == -35) ? lang('RESP_USER_SUSPENDED') : lang('RESP_SESSION_EXPIRED');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          $this->session->sess_destroy();
          break;
        case -437:
          $this->response->code = 2;
          $this->response->msg = lang('RESP_THIRD_PARTY_SERVICE_ERROR');
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_ACCEPT'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
        default:
          $this->response->classIconName = 'ui-icon-alert';
          $this->response->data = [
            'btn1' => [
              'text' => lang('BUTTON_CONTINUE'),
              'link' => base_url('listaproducto'),
              'action' => 'redirect'
            ]
          ];
          break;
      }
    }
    return $this->response;
  }

  function getDataWorkingProduct()
  {
    return $this->session->userdata('setProductServices');
  }
}
