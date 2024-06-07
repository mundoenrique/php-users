<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Clase contralador de Conexión Personas Online (CPO)
 *
 * Esta clase es la súper clase de la que heredarán todos los controladores
 * de la aplicación.
 *
 * @package controllers
 * @author J. Enrique Peñaloza Piñero
 * @date May 16th, 2020
 */
class NOVO_Controller extends CI_Controller
{
  private $ValidateBrowser;
  protected $customerUri;
  protected $customerLang;
  protected $customerFiles;
  protected $customerStyle;
  protected $fileLanguage;
  protected $controllerClass;
  protected $controllerMethod;
  protected $modelClass;
  protected $modelMethod;
  protected $validationMethod;
  protected $includeAssets;
  protected $request;
  protected $dataResponse;
  protected $render;
  protected $nameApi;
  protected $dataRequest;
  protected $greeting;
  protected $views;

  public function __construct()
  {
    parent::__construct();
    writeLog('INFO', 'Controller Class Initialized');

    $class = $this->router->fetch_class();
    $method = $this->router->fetch_method();
    $customerUri = $this->uri->segment(1, 0) ?? 'null';

    $this->ValidateBrowser = FALSE;
    $this->customerUri = $customerUri;
    $this->customerLang = $customerUri;
    $this->customerStyle = $customerUri;
    $this->customerFiles = $customerUri;
    $this->fileLanguage = lcfirst(str_replace('Novo_', '', $class));
    $this->controllerClass = $class;
    $this->controllerMethod = $method;
    $this->modelClass = $class . '_Model';
    $this->modelMethod = 'callWs_' . ucfirst($method) . '_' . str_replace('Novo_', '', $class);
    $this->validationMethod = $method;
    $this->includeAssets = new stdClass();
    $this->request = new stdClass();
    $this->dataResponse = new stdClass();
    $this->render = new stdClass();
    $this->nameApi = '';

    if ($this->customerUri === "api") {
      $transforNameApi = explode("-", $this->uri->segment(4));
      $this->nameApi = $transforNameApi[0] . ucfirst($transforNameApi[1]);
      $this->config->set_item('language', 'global');
      $this->lang->load('settings');
    }

    $this->optionsCheck();
  }
  /**
   * Método para varificar datos génericos de la solcitud
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   * @Modified Pedro A. Torres F.
   * @date Oct. 1th, 2020
   */
  private function optionsCheck()
  {
    writeLog('INFO', 'Controller: optionsCheck Method Initialized');

    if ($this->customerUri === "api") {
      $this->dataRequest = $this->tool_api->readHeader($this->nameApi);
    } else {
      if ($this->session->has_userdata('userName') && SESS_DRIVER == 'database') {
        $data = ['username' => $this->session->userName];
        $this->db->where('id', $this->session->session_id)
          ->update('cpo_sessions', $data);
      }

      LoadLangFile('generic', $this->fileLanguage, $this->customerLang);
      clientUrlValidate($this->customerUri);
      $this->customerUri = config_item('customer_uri');
      $this->customerLang = config_item('customer_lang');
      $this->customerStyle = config_item('customer_style');
      $this->customerFiles = config_item('customer_files');
      LoadLangFile('specific', $this->fileLanguage, $this->customerLang);

      if ($this->controllerMethod !== 'suggestion') {
        $this->ValidateBrowser = $this->checkBrowser();
      }

      if ($this->session->has_userdata('time')) {
        $customerTime = $this->session->time->customerTime;
        $serverTime = $this->session->time->serverTime;
        $currentTime = (int) date("H");
        $currentTime2 = date("Y-d-m H:i:s");
        $serverelapsed = $currentTime - $serverTime;
        $serverelapsed = $serverelapsed >= 0 ? $serverelapsed : $serverelapsed + 24;
        $elapsed = $customerTime + $serverelapsed;
        $this->greeting = $elapsed < 24 ? $elapsed : $elapsed - 24;
      }

      if ($this->input->is_ajax_request()) {
        $request = decryptData($this->input->get_post('request'));
        $this->dataRequest = json_decode($request);
      } else {
        if ($this->session->has_userdata('logged')) {
          $redirectMfa = lang('SETT_MFA_ACTIVE') === 'ON' && !$this->session->otpActive;
          $redirectProfile = $this->session->longProfile === 'S' && $this->session->affiliate === '0';
          $redirectTerms = $this->session->terms === '0';
          $redirectRule = in_array($this->controllerMethod, lang('SETT_REDIRECT_RULE'));
          $redirect = ($redirectMfa || $redirectProfile || $redirectTerms) && !$redirectRule;

          if ($redirect) {
            $redirectUrl = $redirectMfa ? lang('SETT_LINK_MFA_ENABLE') : lang('SETT_LINK_USER_PROFILE');
            redirect(base_url($redirectUrl), 'Location', 301);
            exit();
          }
        }

        $access = $this->verify_access->accessAuthorization($this->validationMethod);
        $valid = TRUE;

        if ($_POST && $access) {
          if ($this->input->post('traslate')) {
            $request = decryptData($this->input->post('request'));
            $this->dataRequest = json_decode($request);

            foreach ($this->dataRequest as $item => $value) {
              $_POST[$item] = $value;
            }
          }

          $this->request = $this->verify_access->createRequest($this->controllerClass, $this->controllerMethod);
          $valid = $this->verify_access->validateForm($this->validationMethod);
        }

        $this->preloadView($access && $valid);
      }
    }
  }
  /**
   * Método para realizar la precarga de las vistas
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function preloadView($auth)
  {
    writeLog('INFO', 'Controller: preloadView Method Initialized');

    $this->render->totalCards = 0;

    if ($this->session->has_userdata('totalCards')) {
      $this->render->totalCards = $this->session->totalCards;
    }

    if ($auth) {
      $this->render->favicon = lang('IMG_FAVICON') . '.' . lang('IMG_FAVICON_EXT');
      $this->render->faviconExt = lang('IMG_FAVICON_EXT');
      $this->render->customerUri = $this->customerUri;
      $this->render->customerFiles = $this->customerFiles;
      $this->render->logged = $this->session->has_userdata('logged');
      $this->render->userId = $this->session->has_userdata('userId');
      $this->render->fullName = $this->session->fullName;
      $this->render->sessionTime = $this->config->item('session_time');
      $this->render->callServer = $this->config->item('session_call_server');
      $this->render->prefix = '';

      switch ($this->greeting) {
        case $this->greeting >= 19 && $this->greeting <= 23:
          $this->render->greeting = lang('GEN_EVENING');
          break;
        case $this->greeting >= 12 && $this->greeting < 19:
          $this->render->greeting = lang('GEN_AFTERNOON');
          break;
        case $this->greeting >= 0 && $this->greeting < 12:
          $this->render->greeting = lang('GEN_MORNING');
          break;
      }

      $this->includeAssets->cssFiles = [
        "$this->customerStyle/$this->customerStyle-root",
        "general-root",
        "reboot",
        "$this->customerStyle/$this->customerStyle-base"
      ];

      $this->includeAssets->jsFiles = [
        "third_party/jquery-3.6.0",
        "third_party/jquery-ui-1.13.1",
        "third_party/aes",
        "aes-json-format",
        "encrypt_decrypt",
        "helper",
        "thirdPartyConfig"
      ];

      if ($this->session->has_userdata('logged') || $this->session->has_userdata('userId')) {
        array_push(
          $this->includeAssets->jsFiles,
          "sessionControl",
          "mfa/mfaControl"
        );
      }

      $validateRecaptcha = in_array($this->controllerMethod, lang('SETT_VALIDATE_CAPTCHA'));

      if ($validateRecaptcha) {
        array_push(
          $this->includeAssets->jsFiles,
          "googleRecaptcha"
        );

        if (ACTIVE_RECAPTCHA) {
          $this->load->library('recaptcha');
          $this->render->scriptCaptcha = $this->recaptcha->getScriptTag();
        }
      }
    } else {
      $linkredirect = uriRedirect();
      redirect(base_url($linkredirect), 'Location', 301);
      exit();
    }
  }
  /**
   * Método para cargar un modelo especifico
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function loadModel($request = FALSE)
  {
    writeLog('INFO', 'Controller: loadModel Method Initialized. Model loaded: ' . $this->modelClass);

    $this->load->model($this->modelClass, 'modelLoaded');
    $method = $this->modelMethod;

    return $this->modelLoaded->$method($request);
  }

  /**
   * Método para extraer mensaje al usuario
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function responseAttr($responseView = 0)
  {
    writeLog('INFO', 'Controller: responseAttr Method Initialized');

    $this->render->code = $responseView;

    if (is_object($responseView)) {
      $this->render->code = $responseView->code;
    }

    if ($this->render->code > 2) {
      $this->render->title = $responseView->title;
      $this->render->msg = $responseView->msg;
      $this->render->icon = $responseView->icon;
      $this->render->modalBtn = $responseView->modalBtn;
    }

    $this->render->response = $responseView;
  }

  /**
   * Método para validar la versión de browser
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function checkBrowser()
  {
    writeLog('INFO', 'Controller: checkBrowser Method Initialized');
    $this->load->library('Tool_Browser');

    $valid = $this->tool_browser->validBrowser($this->customerUri);

    if (!$valid) {
      redirect(base_url('suggestion'), 'location', 301);
      exit();
    }

    return $valid;
  }
  /**
   * Método para renderizar una vista
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function loadView($module)
  {
    writeLog('INFO', 'Controller: loadView Method Initialized. Module loaded: ' . $module);

    $userMenu = new stdClass();
    $mainMenu = mainMenu();

    if ($this->session->has_userdata('totalCards') && $this->session->totalCards == 1) {
      unset($mainMenu['CARD_LIST']);
      $cardDetail = [
        'CARD_DETAIL' => []
      ];
      $mainMenu = $cardDetail + $mainMenu;
    }

    if ($this->session->has_userdata('noService')) {
      unset($mainMenu['CUSTOMER_SUPPORT']);
    }

    if ($this->session->has_userdata('canTransfer') && $this->session->canTransfer == 'N') {
      unset($mainMenu['TRANSFERS']);
      unset($mainMenu['MOBILE_PAYMENT']);
    }

    $userMenu->mainMenu = $mainMenu;
    $userMenu->currentMethod = $this->controllerMethod;
    $this->render->settingsMenu = $userMenu;
    $this->render->module = $module;
    $this->render->viewPage = $this->views;
    $this->asset->initialize($this->includeAssets);
    $this->load->view('master_content-core', $this->render);
  }
  /**
   * Método para cargar un modelo especifico
   * @author J. Enrique Peñaloza Piñero
   * @date May 16th, 2020
   */
  protected function loadApiModel($request = FALSE)
  {
    writeLog('INFO', 'Controller: loadApiModel Method Initialized');

    $responseModel = $this->tool_api->setResponseNotValid();
    $showMsgLog = 'Controller: loadApiModel Model NOT loaded: ' . $this->modelClass . '/' . $this->modelMethod;

    if (file_exists(APPPATH . "models/{$this->modelClass}.php")) {
      $this->load->model($this->modelClass, 'modelLoaded');

      $method = $this->modelMethod;
      $responseModel = $this->modelLoaded->$method($request);
      $showMsgLog = 'Controller: loadApiModel Successfully loaded model: ' . $this->modelClass . '/' .
        $this->modelMethod;
    }

    writeLog('DEBUG', $showMsgLog);

    return $responseModel;
  }
}
