<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para las peticiones asíncronas de la aplicación
 * @author J. Enrique Peñaloza P
 */
class CallModels extends BDB_Controller
{
  protected $model;
  protected $method;
  protected $rule;
  protected $request;
  protected $dataResponse;

  public function __construct()
  {
    parent::__construct();
    log_message('INFO', 'NOVO CallModels Controller Class Initialized');
    if ($this->input->is_ajax_request()) {
      $this->model = $this->dataRequest->who . '_Model';
      $this->rule = strtolower($this->dataRequest->where);
      $this->method = 'callWs_' . $this->dataRequest->where . '_' . $this->dataRequest->who;
      $this->request = new stdClass();
      $this->dataResponse = new stdClass();
    } else {
      show_404();
    }
  }

  public function index()
  {
    log_message('INFO', 'NOVO CallModels: index Method Initialized');

    if (!empty($this->dataRequest->data)) {
      foreach ($this->dataRequest->data as $item => $value) {
        $_POST[$item] = $value;
      }
      unset($this->dataRequest);
    }

    $result = $this->form_validation->run($this->rule);
    log_message('DEBUG', 'NOVO VALIDATION FORM ' . $this->rule . ': ' . json_encode($result));
    if ($result) {
      foreach ($_POST as $key => $value) {
        switch ($key) {
          case 'request':
          case 'plot':
            break;
          default:
            $this->request->$key = $value;
        }
      }
      unset($_POST);

      loadLanguage(NULL, $this->rule);
      $this->config->set_item('language', 'core-bdb');
      loadLanguage('bdb', $this->rule);

      $this->load->model($this->model, 'modelLoad');
      $method = $this->method;
      $this->dataResponse = $this->modelLoad->$method($this->request);
    } else {
      log_message('DEBUG', 'NOVO VALIDATION ERRORS: ' . json_encode(validation_errors()));
      $this->dataResponse->code = 2;
      $this->dataResponse->title = lang('GEN_CORE_NAME');
      $this->dataResponse->msg = lang('RESP_DATA_INVALIDATED');
      $this->dataResponse->icon = 'ui-icon-alert';
      $this->dataResponse->data = [
        'btn1' => [
          'text' => lang('GEN_BTN_ACCEPT'),
          'link' => FALSE,
          'action' => 'close'
        ]
      ];
      $this->session->sess_destroy();
    }
    $dataResponse = $this->cryptography->encrypt($this->dataResponse);
    $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
  }
}
