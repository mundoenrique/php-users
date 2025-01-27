<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'users';
$route['404_override'] = ERROR_CONTROLLER;
$route['translate_uri_dashes'] = FALSE;
/*
|--------------------------------------------------------------------------
| CURRENT ROUTES
|--------------------------------------------------------------------------
*/
// API
$route['api/v1/(:any)/(:any)']['POST'] = "Novo_CallApi";
//Asynchronous
$route['(:any)/novo-async-call'] = "Novo_CallModels";
//Suggestion
$route['(:any)/suggestion'] = "Novo_User/suggestion";
//User
$route['(:any)/inicio'] = function ($customer) {
  if (SUBCLASS_PREFIX === 'BDB_') {
    return "user/login";
  } else {
    header('Location: ' . BASE_URL . '/' . $customer . '/sign-in', 'GET');
    exit;
  }
};
$route['(:any)/recuperar-acceso'] = function ($customer) {
  header('Location: ' . BASE_URL . '/' . $customer . '/recover-access', 'GET');
  exit;
};
$route['(:any)/identificar-usuario'] = function ($customer) {
  header('Location: ' . BASE_URL . '/' . $customer . '/user-identify', 'GET');
  exit;
};
$route['(:any)/terminos-condiciones'] = function ($customer) {
  header('Location: ' . BASE_URL . '/' . $customer . '/terms-conditions', 'GET');
  exit;
};
$route['(:any)/sign-in'] = function ($customer) {
  return SUBCLASS_PREFIX === 'BDB_' ? "user/login" : "Novo_User/signin";
};
$route['(:any)/sign-in/(:any)'] = "Novo_User/signin";
$route['(:any)/sign-up'] = "Novo_User/signup";
$route['(:any)/sign-out/(:any)'] = "Novo_User/finishSession/$2";
$route['(:any)/recover-access'] = "Novo_User/accessRecover";
$route['(:any)/recover-access/(:any)'] = "Novo_User/accessRecover";
$route['(:any)/user-identify'] = "Novo_User/userIdentify";
$route['(:any)/user-identify/(:any)'] = "Novo_User/userIdentify";
$route['(:any)/change-password'] = "Novo_User/changePassword";
$route['(:any)/user-profile'] = "Novo_User/profileUser";
$route['(:any)/mfa-enable'] = "Novo_Mfa/mfaEnable";
$route['(:any)/mfa-confirm/(email|app)'] = "Novo_Mfa/mfaConfirm/$2";
$route['(:any)/terms-conditions'] = "Novo_User/termsConditions";
$route['(:any)/card-list'] = "Novo_Business/userCardsList";
$route['(:any)/card-detail'] = "Novo_Business/cardDetail";
$route['(:any)/set-operations-key'] = "Novo_Transfer/setOperationKey";
$route['(:any)/get-operations-key'] = "Novo_Transfer/getOperationKey";
$route['(:any)/change-operations-key'] = "Novo_Transfer/changeOperationKey";
$route['(:any)/transfer-cards'] = "Novo_Transfer/cardToCard";
$route['(:any)/transfer-banks'] = "Novo_Transfer/cardToBank";
$route['(:any)/mobile-payment'] = "Novo_Transfer/mobilePayment";
$route['(:any)/pay-credit-cards'] = "Novo_Transfer/cardToCreditCard";
$route['(:any)/pay-digitel-recharge'] = "Novo_Transfer/cardToDigitel";
$route['(:any)/reports'] = "Novo_Reports/expensesCategory";
$route['(:any)/customer-support'] = "Novo_CustomerSupport/services";
$route['(:any)/notifications'] = "Novo_CustomerSupport/notifications";
/*
|--------------------------------------------------------------------------
| BOGOTÁ ROUTES
|--------------------------------------------------------------------------
*/
$route['(bdb|bdbo)/'] = "user/login";
$route['(bdb|bdbo)/inicio'] = "user/login";
$route['(bdb|bdbo)/preregistro'] = "user/preRegistry";
$route['(bdb|bdbo)/registro'] = "user/registry";
$route['(bdb|bdbo)/perfil'] = "user/profile";
$route['(bdb|bdbo)/recuperaracceso'] = "user/recoveryAccess";
$route['(bdb|bdbo)/cerrarsesion'] = "user/closeSession";
$route['(bdb|bdbo)/cambiarclave'] = "user/changePassword";
$route['(bdb|bdbo)/cambiarclaveprofile'] = "user/changePasswordProfile";
$route['(bdb|bdbo)/sugerencia'] = "user/notRender";
$route['(bdb|bdbo)/app/(:any)'] = "user/notRender/$2";
$route['(bdb|bdbo)/vistaconsolidada'] = "product/listProduct";
$route['(bdb|bdbo)/detalle'] = "product/detailProduct";
$route['(bdb|bdbo)/detalle/download'] = "product/downloadDetail";
$route['(bdb|bdbo)/async-call'] = "callModels";
$route['(bdb|bdbo)/listaproducto'] = "serviceProduct/listProduct";
$route['(bdb|bdbo)/atencioncliente'] = "serviceProduct/customerSupport";
$route['(bdb|bdbo)/reporte'] = "expenseReport/listProduct";
$route['(bdb|bdbo)/detallereporte'] = "expenseReport/detailReport";
$route['(bdb|bdbo)/reporte/getpdf'] = "expenseReport/getPDF";
/*
|--------------------------------------------------------------------------
| OLD ROUTES
|--------------------------------------------------------------------------
*/
$route['(:any)/home'] = 'users/index'; // Perú LATODO | Ecuador pichincha
$route['users'] = 'users/index'; // Otros paises
$route['users/recoveryPassword_pe'] = 'users/recoveryPassword'; // Perú LATODO
$route['users/recoveryPassword_pi'] = 'users/recoveryPassword'; // Ecuador pichincha
$route['users/recoveryPassword'] = 'users/recoveryPassword'; // Otros paises
$route['users/obtenerLogin_pe'] = 'users/obtenerLogin'; // Perú LATODO
$route['users/obtenerLogin_pi'] = 'users/obtenerLogin'; // Ecuador pichincha
$route['users/obtenerLogin'] = 'users/obtenerLogin'; // Otros paises
$route['users/login'] = 'users/CallWsLogin';
$route['cerrar-sesion'] = 'users/closeSess';
$route['users/validateRecaptcha'] = 'users/validarCaptcha';
$route['users/error'] = 'users/error_gral';
$route['users/resetpassword'] = 'users/CallWsResetPassword';
$route['users/obtenerlogin_call'] = 'users/CallWsObtenerLogin';
$route['users/actualizarPassword'] = 'users/CallWsActualizarPassword';
$route['users/passwordOperaciones'] = 'users/CallWsCrearPasswordOperaciones';
$route['users/passwordSmsCrear'] = 'users/crearPasswordSms';
$route['users/passwordSmsActualizar'] = 'users/CallWsActualizarPasswordSms';
$route['users/passwordSmsEliminar'] = 'users/CallWsEliminarPasswordSms';
$route['users/passwordSmsNew'] = 'users/CallWsCrearPasswordSms';
$route['users/passwordOperacionesActualizar'] = 'users/CallWsActualizarPasswordOperaciones';
$route['politicas-condiciones'] = 'registro/politicas'; // Otros paises
$route['registro'] = 'registro/index_pe'; // Perú LATODO
$route['registro'] = 'registro/index_pi'; // Ecuador pichincha
$route['registro'] = 'registro/index'; // Otros paises
$route['registro/listado'] = 'registro/CallWsLista';
$route['registro/validar'] = 'registro/CallWsValidarCuenta';
$route['registro/verificar'] = 'registro/CallWsValidarUsuario';
$route['registro/telefonos'] = 'registro/CallWsListaTelefonos';
$route['registro/listadoDepartamento'] = 'registro/CallWsListaDepartamento';
$route['registro/ListadoProfesiones'] = 'registro/CallWsListaProfesiones';
$route['registro/registrar'] = 'registro/CallWsRegistrar';
$route['registro/identificaciones'] = 'registro/CallWsListaIdentificadores';
$route['dashboard'] = 'dashboard';
$route['dashboard/error'] = 'dashboard/error_dashboard';
$route['dashboard/load'] = 'dashboard/CallWsDashboard';
$route['dashboard/saldo'] = 'dashboard/CallWsSaldo';
$route['detalles'] = 'detail';
$route['detalles/load'] = 'detail/CallWsDetail';
$route['detalles/movimientos'] = 'detail/CallWsMovimientos';
$route['detalles/exportar'] = 'detail/CallWsExportar';
$route['detalles/enTransito'] = 'detail/inTransit';
$route['transferencia'] = 'transfer';
$route['transferencia/error'] = 'transfer/error_transfer';
$route['transferencia/error_pago'] = 'transfer/error_pago';
$route['transferencia/ctaDestino'] = 'transfer/CallWsCtaDestino';
$route['transferencia/ctaOrigen'] = 'transfer/CallWsCtaOrigen';
$route['transferencia/operaciones'] = 'transfer/CallWsValidarClave';
$route['transferencia/crearClave'] = 'transfer/CallWsClaveAutenticacion';
$route['transferencia/confirmacion'] = 'transfer/CallWsValidarClaveAutenticacion';
$route['transferencia/procesar'] = 'transfer/CallWsProcesarTransferencia';
$route['transferencia/pe'] = 'transferPe/index';
$route['transferencia/HistorialPe'] = 'transferPe/historial_pe';
$route['limit/pe'] = 'transferPe/limit';
$route['transferencia/peGeneral'] = 'transferPe/CallModel';
$route['transfererencia/transferPe'] = 'transferPe/maketransferPe';
$route['affiliation'] = 'affiliation';
$route['affiliation/cuentasP2P'] = 'affiliation/CallWstarjetasP2P';
$route['affiliation/affiliation'] = 'affiliation/CallWsAffiliationP2P';
$route['affiliation/affiliation_P2T'] = 'affiliation/CallWsAffiliationP2T';
$route['affiliation/affiliation_P2C'] = 'affiliation/CallWsAffiliationP2C';
$route['affiliation/bancos'] = 'affiliation/CallWsBancos';
$route['adm'] = 'adm';
$route['adm/adm_bank'] = 'adm/adm_bank';
$route['adm/adm_tdc'] = 'adm/adm_tdc';
$route['adm/modificar'] = 'adm/CallWsAdm';
$route['adm/eliminar'] = 'adm/CallWsDlt';
$route['historial'] = 'historial';
$route['historial/historial'] = 'historial/CallWsHistorial';
$route['report'] = 'report/index';
$route['report/error'] = 'report/report_error';
$route['report/exp_xls'] = 'report/CallWsExpXLS';
$route['report/exp_pdf'] = 'report/CallWsExpPDF';
$route['perfil'] = 'perfil/index';
$route['perfil/load'] = 'perfil/CallWsPerfil';
$route['perfil/error'] = 'perfil/error_perfil';
$route['perfil/listado'] = 'perfil/CallWsLista';
$route['perfil/listaEstado'] = 'perfil/CallWsListaEstado';
$route['perfil/listaCiudad'] = 'perfil/CallWsListaCiudad';
$route['perfil/listadoDepartamento'] = 'perfil/CallWsListaDepartamento';
$route['perfil/verificarEmail'] = 'perfil/CallWsverificarEmail';
$route['perfil/profesiones'] = 'perfil/CallWsListaProfesiones';
$route['perfil/telefonos'] = 'perfil/CallWsListaTelefonos';
$route['perfil/direcciones'] = 'perfil/CallWsListaDirecciones';
$route['perfil/actualizar'] = 'perfil/CallWsActualizar';
$route['servicios'] = 'service/index';
$route['servicios/modelo'] = 'service/CallModel';
$route['servicios/error'] = 'service/error_services';
