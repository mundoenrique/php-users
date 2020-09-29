<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
| URI contains no data. In the above example, the 'welcome' class
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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//BDB ROUTES
$route['bdb/'] = "user/login";
$route['bdb/inicio'] = "user/login";
$route['bdb/preregistro'] = "user/preRegistry";
$route['bdb/registro'] = "user/registry";
$route['bdb/perfil'] = "user/profile";
$route['bdb/recuperaracceso'] = "user/recoveryAccess";
$route['bdb/cerrarsesion'] = "user/closeSession";
$route['bdb/cambiarclave'] = "user/changePassword";
$route['bdb/cambiarclaveprofile'] = "user/changePasswordProfile";
$route['bdb/sugerencia'] = "user/notRender";
$route['bdb/app/(:any)'] = "user/notRender/$2";
$route['bdb/vistaconsolidada'] = "product/listProduct";
$route['bdb/detalle'] = "product/detailProduct";
$route['bdb/detalle/download'] = "product/downloadDetail";
$route['bdb/async-call'] = "callModels";
$route['bdb/listaproducto'] = "serviceProduct/listProduct";
$route['bdb/atencioncliente'] = "serviceProduct/customerSupport";
$route['bdb/reporte'] = "expenseReport/listProduct";
$route['bdb/detallereporte'] = "expenseReport/detailReport";
$route['bdb/reporte/getpdf'] = "expenseReport/getPDF";

// API
$route['api/v1/generate-hash']['POST'] = "Novo_Api/generateHash";
$route['api/v1/generate-request']['POST'] = "Novo_Api/generateRequest";

//Asynchronous
$route['(:any)/async-call'] = "Novo_CallModels";
//User
$route['(:any)/sugerencia'] = "Novo_User/suggestion";
$route['(:any)/inicio'] = "Novo_User/signin";
$route['(:any)/registro'] = "Novo_User/signup";
$route['(:any)/cerrar-sesion/(:any)'] = "Novo_User/finishSession/$2";
$route['(:any)/cambiar-clave'] = "Novo_User/changePassword";
$route['(:any)/recuperar-acceso'] = "Novo_User/accessRecover";
$route['(:any)/identificar-usuario'] = "Novo_User/userIdentify";
$route['(:any)/perfil-usuario'] = "Novo_User/profileUser";
$route['(:any)/terminos-condiciones'] = "Novo_User/termsConditions";
//Business
$route['(:any)/lista-de-tarjetas'] = "Novo_Business/userCardsList";
$route['(:any)/detalle-de-tarjeta'] = "Novo_Business/cardDetail";
//Resports
$route['(:any)/reportes'] = "Novo_Reports/expensesCategory";
//Custumer suppor
$route['(:any)/atencion-al-cliente'] = "Novo_CustomerSupport/services";
$route['(:any)/notificaciones'] = "Novo_CustomerSupport/notifications";

//Actual Structure
$route['(:any)/home'] = 'users/index'; // Perú LATODO | Ecuador pichincha
$route['users'] = 'users/index'; // Otros paises
$route['users/recoveryPassword_pe'] = 'users/recoveryPassword'; // Perú LATODO
$route['users/recoveryPassword_pi'] = 'users/recoveryPassword'; // Ecuador pichincha
$route['users/recoveryPassword'] = 'users/recoveryPassword'; // Otros paises
$route['users/obtenerLogin_pe'] = 'users/obtenerLogin'; // Perú LATODO
$route['users/obtenerLogin_pi'] = 'users/obtenerLogin'; // Ecuador pichincha
$route['users/obtenerLogin'] = 'users/obtenerLogin'; // Otros paises
$route['users/login'] = 'users/CallWsLogin';
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
$route['perfil/verificarEmail']='perfil/CallWsverificarEmail';
$route['perfil/profesiones'] = 'perfil/CallWsListaProfesiones';
$route['perfil/telefonos'] = 'perfil/CallWsListaTelefonos';
$route['perfil/direcciones'] = 'perfil/CallWsListaDirecciones';
$route['perfil/actualizar'] = 'perfil/CallWsActualizar';
$route['servicios'] = 'service/index';
$route['servicios/modelo'] = 'service/CallModel';
$route['servicios/error'] = 'service/error_services';
