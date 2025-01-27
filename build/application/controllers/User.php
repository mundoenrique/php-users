<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends BDB_Controller
{

  public function __construct()
  {
    parent::__construct();
    log_message('INFO', 'NOVO User Controller class Initialized');

    $this->key_api = $this->config->item('key_api');
  }

  public function login()
  {
    log_message('INFO', 'NOVO User: index Method Initialized');
    $view = 'login';

    if ($this->session->userdata('logged_in')) {

      redirect(base_url('vistaconsolidada'), 'location');
      exit();
    }

    $userData = [
      'sessionId',
      'idUsuario',
      'userName',
      'fullName',
      'codigoGrupo',
      'lastSession',
      'token',
      'cl_addr',
      'countrySess',
      'pais',
      'nombreCompleto'
    ];

    $this->session->unset_userdata($userData);

    $this->load->library('user_agent');

    $browser = strtolower($this->agent->browser());
    $version = (float) $this->agent->version();
    $noBrowser = "internet explorer";
    $views = ['user/' . $view];
    if ($this->countryUri == 'bp') {
      $views = ['user/signin'];
    }
    if ($browser == $noBrowser && $version < 11.0) {
      $views = ['staticpages/content-browser'];
    }
    array_push(
      $this->includeAssets->jsFiles,
      "third_party/jquery.md5",
      "third_party/jquery.balloon",
      "third_party/jquery.validate",
      "default/validate-forms",
      "third_party/additional-methods",
      "bdb/user/login",
      "bdb/clave",
      "localization/core-base/messages_base"
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    if ($this->countryUri !== 'bp') {
      array_push(
        $this->includeAssets->jsFiles,
        "third_party/jquery.kwicks",
        "bdb/user/kwicks"
      );
    }
    if ($this->countryUri === 'bp' && ENVIRONMENT === 'production') {
      array_push(
        $this->includeAssets->jsFiles,
        "third_party/borders"
      );
    }

    if ($this->render->activeRecaptcha) {
      $this->load->library('recaptcha');
      $this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
      $this->render->loginUri = 'validateCaptcha';
      log_message('DEBUG', 'NOVO RESPONSE: script to load: ' . $this->recaptcha->getScriptTag());
    }

    $this->views = $views;
    $this->render->titlePage = lang('GEN_CORE_NAME') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');

    $this->loadView($view);
  }

  public function changePassword()
  {
    $view = 'changepassword';

    log_message('INFO', 'NOVO User: Change Password Method Initialized');

    if (!$reasonOperation = $this->session->flashdata('changePassword')) {
      log_message('INFO', 'NOVO User: Change Password Redirect to Login');
      redirect(base_url('inicio'), 'location');
      exit();
    }
    array_push(
      $this->includeAssets->jsFiles,
      "bdb/user/$view",
      "third_party/jquery.validate",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base",
      "user/validPass",
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    $this->session->set_flashdata('changePassword', $reasonOperation);
    $this->session->set_flashdata('userType', $this->session->flashdata('userType'));

    $this->views = ['user/' . $view];
    $this->render->reason = $reasonOperation === 't' ? lang('PASSWORD_TEMPORAl_KEY') : lang('PASSWORD_EXPIED_KEY');
    $this->render->titlePage = lang('GEN_PASSWORD_CHANGE_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->loadView($view);
  }

  public function changePasswordProfile()
  {
    $view = 'changepassword';

    log_message('INFO', 'NOVO User: Change Password from profile Method Initialized');

    if (!$this->session->userdata('logged_in')) {

      redirect(base_url('inicio'), 'location');
      exit();
    }
    array_push(
      $this->includeAssets->jsFiles,
      "bdb/user/$view",
      "third_party/jquery.validate",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base",
      "user/validPass",
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    $this->session->set_flashdata('changePassword', 'changePaswordProfile');

    $this->views = ['user/' . $view];
    $this->render->reason = lang('GEN_PASSWORD_CHANGE_TITLE');
    $this->render->titlePage = lang('GEN_PASSWORD_CHANGE_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->loadView($view);
  }

  public function preRegistry()
  {
    $view = 'preregistry';

    log_message('INFO', 'NOVO User: preRegistry Method Initialized');
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    array_push(
      $this->includeAssets->jsFiles,
      "third_party/jquery.validate",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base",
      "bdb/user/$view"
    );

    $this->load->model('User_Model', 'modelLoad');
    $listTypeDocument = $this->modelLoad->callWs_loadTypeDocument_User();

    $this->views = ['user/' . $view];
    $this->render->titlePage = lang('GEN_REGISTRY_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->render->nameAplication = lang('GEN_CORE_NAME');
    $this->render->typeDocument = $listTypeDocument->data;
    $this->render->statusListTypeDocument = $listTypeDocument->code !== 0 ? 'disabled' : '';
    $this->loadView($view);
  }

  public function registry()
  {
    $view = 'registry';
    if (!$this->session->flashdata('registryUser')) {

      redirect(base_url('inicio'), 'location');
      exit();
    }
    $this->session->set_flashdata('registryUserData', $this->session->flashdata('registryUserData'));
    $this->session->set_flashdata('registryUser', $this->session->flashdata('registryUser'));

    log_message('INFO', 'NOVO User: registry Method Initialized');
    array_push(
      $this->includeAssets->jsFiles,
      "bdb/user/$view",
      "third_party/jquery.validate",
      "third_party/moment",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base",
      "user/validPass",
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    $this->views = ['user/' . $view];
    $this->render->data = $this->session->flashdata('registryUserData');
    $this->render->titlePage = lang('GEN_REGISTRY_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->loadView($view);
  }

  public function profile()
  {
    $view = 'profile';
    if (!$this->session->userdata('logged_in')) {

      redirect(base_url('vistaconsolidada'), 'location');
      exit();
    }

    $this->load->model('User_Model', 'modelLoad');

    $objData = new stdClass();
    $objData->profileUser = $this->modelLoad->callWs_profile_User()->data;

    log_message('INFO', 'NOVO User: profile Method Initialized');
    array_push(
      $this->includeAssets->jsFiles,
      "bdb/user/$view",
      "third_party/jquery.validate",
      "third_party/moment",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base"
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    $this->views = ['user/' . $view];

    $listaTelefonos = [];
    if ($objData->profileUser !== '--') {
      foreach ($objData->profileUser->registro->listaTelefonos as $row) {
        $listaTelefonos[$row->tipo] = $row->numero;
      }
      $objData->profileUser->ownTelephones = $listaTelefonos;
    }

    if (!empty((array) $objData->profileUser->direccion)) {

      $codState = new stdClass;
      $codState->codState = $objData->profileUser->direccion->acCodEstado;
      $this->render->dataCitys = $this->modelLoad->callWs_getListCitys_User($codState)->data;
    }

    $objData->professions = $this->modelLoad->getListProfessions()->data;
    $objData->states = $this->modelLoad->getListStates()->data;

    $this->render->data = $objData->profileUser;
    $this->render->dataProfessions = $objData->professions;
    $this->render->dataStates = $objData->states;
    $this->render->titlePage = lang('GEN_PROFILE_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');

    $this->loadView($view);
  }

  public function recoveryAccess()
  {
    $view = 'recoveryaccess';

    log_message('INFO', 'NOVO User: recoveryAccess Method Initialized');
    array_push(
      $this->includeAssets->jsFiles,
      "bdb/user/$view",
      "third_party/jquery.validate",
      "default/validate-forms",
      "third_party/additional-methods",
      "localization/core-base/messages_base"
    );
    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }
    $this->load->model('User_Model', 'modelLoad');
    $listTypeDocument = $this->modelLoad->callWs_loadTypeDocument_User();

    $this->views = ['user/' . $view];
    $this->render->titlePage = lang('GEN_RECOVER_ACCESS_TITLE') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->render->nameAplication = lang('GEN_CORE_NAME');
    $this->render->typeDocument = $listTypeDocument->data;
    $this->render->statusListTypeDocument = $listTypeDocument->code !== 0 ? 'disabled' : '';
    $this->loadView($view);
  }

  public function closeSession()
  {
    log_message('INFO', 'NOVO User: CloseSession Method Initialized');

    $this->load->model('User_Model', 'modelLoad');
    $this->modelLoad->callWs_closeSession_User();

    redirect($this->config->item('base_url') . 'inicio');
  }

  public function notRender($reason = 'b')
  {
    $view = 'notrender';
    if (!$this->session->flashdata('checkBrowser')) {

      redirect(base_url('inicio'), 'location', 301);
      exit();
    }

    log_message('INFO', 'NOVO Controller: notRender Method Initialized');

    $this->includeAssets->cssFiles = [
      "$this->countryUri/notrender"
    ];
    $this->render->viewPage = [$view];
    $this->render->titlePage = lang('GEN_CORE_NAME') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->render->reason = $reason;
    $this->render->reasonTitle = $reason !== 'b' ? lang('GEN_NOT_RENDER_MOBILE') : lang('GEN_NOT_RENDER_BROWSER');
    $this->render->reasonMessage = $reason !== 'b' ? lang('GEN_NOT_RENDER_MOBILE_MSG') : lang('GEN_NOT_RENDER_BROWSER_MSG');
    $this->asset->initialize($this->includeAssets);
    $this->load->view('layouts/designNotRender', $this->render);
  }

  public function bdb_generateHash()
  {
    $statusResponse = 400;
    $response = '';
    $password = NULL;
    $key = FALSE;

    $inputData = $this->input->post();
    if (count($inputData) > 0) {

      $bodyRequest = json_decode($this->encrypt_decrypt->aesCryptography($inputData['request'], FALSE));
      if (!is_null($bodyRequest)) {

        $password = trim($bodyRequest->password) == '' ? NULL : $bodyRequest->password;
        $key = $bodyRequest->key === $this->key_api;
      }
    }

    if (!is_null($password) && $key) {

      $argon2 = $this->encrypt_decrypt->generateArgon2Hash($password);
      $bodyResponse = [
        'key' => $this->key_api,
        'password' => $argon2->hexArgon2
      ];
      $statusResponse = 200;

      $dataResponse = json_encode($bodyResponse);
      $response = $this->encrypt_decrypt->aesCryptography($dataResponse, TRUE);
    }

    return $this->output
      ->set_content_type('application/json')
      ->set_status_header($statusResponse)
      ->set_output(json_encode(
        [
          'response' => $response
        ]
      ));
  }
}
