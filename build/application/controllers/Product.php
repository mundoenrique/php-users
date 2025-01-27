<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends BDB_Controller
{

  public function __construct()
  {
    parent::__construct();
    log_message('INFO', 'NOVO User Controller class Initialized');
    $this->listProducts = 'muchos productos';
  }

  public function listProduct()
  {
    log_message('INFO', 'NOVO Consolidated: listProduct Method Initialized');
    $view = 'listproduct';

    if (!$this->session->userdata('logged_in')) {

      redirect(base_url('inicio'), 'location');
      exit();
    }
    $this->session->unset_userdata('setProductDetail');

    $dataProduct = $this->loadDataProduct();
    if (is_array($dataProduct->data) && count($dataProduct->data) == 1) {
      if (in_array("120",  $dataProduct->data[0]['availableServices'])) {

        $this->session->set_userdata('setProductServices', $dataProduct->data[0]);
        redirect('/atencioncliente');
      }

      $dataProduct = $this->session->set_userdata('setProductDetail', $dataProduct->data[0]);
      redirect("/detalle");
    }

    array_push(
      $this->includeAssets->jsFiles,
      "bdb/product/$view"
    );

    if (!is_null($this->config->item('timeIdleSession'))) {
      array_push(
        $this->includeAssets->jsFiles,
        "bdb/watchsession"
      );
    }

    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }

    $this->views = ['product/' . $view];
    $this->render->data = $dataProduct;
    $this->render->titlePage = lang('GEN_CONSOLIDATED_VIEW') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->loadView($view);
  }

  public function loadDataProduct($card = '')
  {
    $this->load->model('Product_Model', 'modelLoad');
    $loadProducts = $this->modelLoad->callWs_loadProducts_Product();
    $totalProducts = count($loadProducts->data);

    if ($totalProducts < 1) {
      return $loadProducts;
    }

    $dataRequeried = [];
    foreach ($loadProducts->data as $row) {
      if (!empty($card) && $card !== $row->noTarjeta) {
        continue;
      }

      $productBalance = $this->modelLoad->callWs_getBalance_Product($row->noTarjeta);
      $mountActual =  isset($productBalance->data['actual']) ? $this->transforNumber($productBalance->data['actual']) : '--';
      $mountAvailable =  isset($productBalance->data['available']) ? $this->transforNumber($productBalance->data['available']) : '--';

      array_push($dataRequeried, [
        "noTarjeta" => $row->noTarjeta,
        "noTarjetaConMascara" => $row->noTarjetaConMascara,
        "nombre_producto" => $row->nombre_producto,
        "prefix" => $row->prefix,
        "marca" => strtolower($row->marca),
        "nomEmp" => ucwords(strtolower($row->nomEmp)),
        "actualBalance" => $mountActual,
        "ledgerBalance" => "--",
        "availableBalance" => $mountAvailable,
        "id_ext_per" => $row->id_ext_per,
        "fechaExp" => $row->fechaExp,
        "nom_plastico" => ucwords(strtolower($row->nom_plastico)),
        "availableServices" => $row->services,
        "bloqueo" => $row->bloque,
        "totalProducts" => $totalProducts,
        "vc" => isset($row->tvirtual) ? $row->tvirtual : FALSE,
        "nameImage" => $row->nameImageOfProduct
      ]);
    }
    $loadProducts->data = $dataRequeried;
    return $loadProducts;
  }

  public function detailProduct()
  {
    log_message('INFO', 'NOVO Consolidated: detailProduct Method Initialized');
    $view = 'detailproduct';

    if (!$this->session->userdata('logged_in')) {
      redirect(base_url('inicio'), 'location');
      exit();
    }
    $dataProduct = [];

    array_push(
      $this->includeAssets->jsFiles,
      "third_party/moment",
      "third_party/jquery.easyPaginate",
      "third_party/kendo.dataviz",
      "third_party/jquery.validate",
      "default/validate-forms",
      "bdb/product/$view",
      "localization/core-base/messages_base"
    );

    if ($this->config->item('language_form_validate')) {
      array_push(
        $this->includeAssets->jsFiles,
        "localization/core-base/messages_$this->countryUri"
      );
    }

    $dataProduct = $this->session->userdata('setProductDetail');

    if (is_null($dataProduct)) {

      $dataProduct = array_filter($_POST, function ($k) {
        return $k !== 'cpo_name';
      }, ARRAY_FILTER_USE_KEY);

      unset($_POST);

      if (count($dataProduct) < 1) {
        redirect('/vistaconsolidada');
      }

      $this->session->set_userdata('setProductDetail', $dataProduct);
    }

    $this->load->model('Product_Model', 'modelLoad');
    if (isset($_POST['frmMonth']) && isset($_POST['frmYear'])) {
      $dataRequest = new stdClass();
      $dataRequest->month = $_POST['frmMonth'];
      $dataRequest->year = $_POST['frmYear'];
      $dataRequest->typeFile = $_POST['frmTypeFile'];
      $dataRequest->noTarjeta = $dataProduct['noTarjeta'];

      $response = $this->modelLoad->getFile_Product($dataRequest);
      if ($response->code == 0) {

        $oDate = new DateTime();
        $dateFile = $oDate->format("YmdHis");
        $_POST['frmTypeFile'] = $_POST['frmTypeFile'] === 'ext' ? 'pdf' : $_POST['frmTypeFile'];
        np_hoplite_byteArrayToFile($response->data->archivo, $_POST['frmTypeFile'], 'movimientos_' . $dateFile);
      }
    } else {

      $transactionsHistory = $this->modelLoad->callWs_getTransactionHistory_Product($dataProduct);

      $dataProduct['movements'] = is_array($transactionsHistory->data) && count($transactionsHistory->data) == 0 ? '--' : $transactionsHistory->data->movimientos;

      $dataProduct['totalInMovements'] = ["totalIncome" => 0, "totalExpense" => 0];
      if (is_array($dataProduct['movements']) && count($dataProduct['movements']) > 0) {
        $dataProduct['totalInMovements'] = ["totalIncome" => $transactionsHistory->data->totalAbonos, "totalExpense" => $transactionsHistory->data->totalCargos];
      }

      if (lang('loadBalanceInTransit') === 'TRUE') {

        $data = $this->modelLoad->callWs_balanceInTransit_Product($dataProduct);
        if (is_object($data) && $data->rc === "200") {

          $dataProduct['pendingTransactions'] = $data->pendingTransactions;
          $dataProduct['totalInPendingTransactions'] = $this->calculateTotalTransactions($dataProduct['pendingTransactions']);
        }
      }
    }

    $year = intval(date("Y"));
    $years = [];
    for ($i = $year; $i > $year - 4; $i--) {
      array_push($years, $i);
    }

    $this->views = ['product/' . $view];

    $this->render->data = $dataProduct;
    $this->render->months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $this->render->years = $years;
    $this->render->titlePage = lang('GEN_DETAIL_VIEW') . ' - ' . lang('GEN_CONTRACTED_SYSTEM_NAME');
    $this->render->booLoadNotiSystem = '';

    if ($dataAlert = $this->session->flashdata('showAlert')) {

      $this->render->loadAlert = '1';
      $this->render->msgAlert = $dataAlert->message;
      $this->render->action = $dataAlert->action;
      $this->render->monthSelected = $dataAlert->monthSelected;
      $this->render->yearSelected = $dataAlert->yearSelected;

      $this->session->unset_userdata('showAlert');
    }
    $this->loadView($view);
  }

  function transforNumberIntoArray($transforArray)
  {
    if ($transforArray !== '--') {
      foreach ($transforArray as $clave => $valor) {
        $transforArray[$clave] = $valor->monto;
      }
    }
    return $transforArray;
  }

  function transforNumber($transforNumber)
  {

    if ($transforNumber !== '--' and is_string($transforNumber)) {

      $transforNumber = (float) str_replace(',', '.', str_replace('.', '', $transforNumber));
    }
    return $transforNumber;
  }

  function calculateTotalTransactions($transactions)
  {
    $totalIncome = 0;
    $totalExpense = 0;
    if ($transactions !== '--') {
      foreach ($transactions as $row) {
        if (is_string($row->monto)) {
          $row->monto = $this->transforNumber($row->monto);
        }
        $totalIncome += $row->signo == '+' ? $row->monto : 0;
        $totalExpense += $row->signo == '-' ? $row->monto : 0;
      }
    }
    return ["totalIncome" => $totalIncome, "totalExpense" => $totalExpense];
  }

  function downloadDetail()
  {
    log_message('INFO', 'NOVO Consolidated: downloadDetail Method Initialized');

    if (!$this->session->userdata('logged_in') && is_null($_POST['frmNoTarjeta'])) {
      redirect(base_url('inicio'), 'location');
      exit();
    }

    $this->load->model('Product_Model', 'modelLoad');
    if (isset($_POST['frmMonth']) && isset($_POST['frmYear'])) {
      $dataRequest = new stdClass();
      $dataRequest->month = $_POST['frmMonth'];
      $dataRequest->year = $_POST['frmYear'];
      $dataRequest->typeFile = $_POST['frmTypeFile'];
      $dataRequest->noTarjeta = $_POST['frmNoTarjeta'];

      $response = $this->modelLoad->getFile_Product($dataRequest);
      if ($response->code == 0) {

        $oDate = new DateTime();
        $dateFile = $oDate->format("YmdHis");
        np_hoplite_byteArrayToFile($response->data->archivo, strtolower($response->data->formatoArchivo), $response->data->nombre . '_' . $dateFile);
      } else {

        $dataForAlert = new stdClass();
        $dataForAlert->message = $response->msg;
        $dataForAlert->action = 'close';
        $dataForAlert->monthSelected = $_POST['frmMonth'];
        $dataForAlert->yearSelected = $_POST['frmYear'];
        $dataForAlert->noTarjeta = $_POST['frmNoTarjeta'];

        unset($_POST['frmMonth']);
        unset($_POST['frmYear']);

        $this->session->set_flashdata('showAlert', $dataForAlert);
        redirect(base_url() . 'detalle', 'location', 301);
      }
    }
  }
}
