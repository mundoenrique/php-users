<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = "users";

$route['(:any)/home'] = "users/index_pe/$1"; // Perú LATODO

$route['users'] = "users/index"; // Otros paises
$route['users/recoveryPassword'] = "users/recoveryPassword_pe"; // Perú LATODO
$route['users/recoveryPassword'] = "users/recoveryPassword"; // Otros paises
$route['users/obtenerlogin'] = "users/obtenerlogin_pe"; // Perú LATODO
$route['users/obtenerlogin'] = "users/obtenerlogin"; // Otros paises
$route['users/login'] = "users/CallWsLogin";
$route['users/error'] = "users/error_gral";
$route['users/resetpassword'] = "users/CallWsResetPassword";
$route['users/obtenerlogin_call'] = "users/CallWsObtenerLogin";
$route['users/actualizarPassword'] = "users/CallWsActualizarPassword";
$route['users/passwordOperaciones'] = "users/CallWsCrearPasswordOperaciones";
$route['users/passwordSmsCrear'] = "users/crearPasswordSms";
$route['users/passwordSmsActualizar'] = "users/CallWsActualizarPasswordSms";
$route['users/passwordSmsEliminar'] = "users/CallWsEliminarPasswordSms";
$route['users/passwordSmsNew'] = "users/CallWsCrearPasswordSms";
$route['users/passwordOperacionesActualizar'] = "users/CallWsActualizarPasswordOperaciones";


$route['politicas-condiciones'] = "registro/politicas"; // Otros paises
$route['registro'] = "registro/index_pe"; // Perú LATODO
$route['registro'] = "registro/index"; // Otros paises
$route['registro/listado'] = "registro/CallWsLista";
$route['registro/validar'] = "registro/CallWsValidarCuenta";
$route['registro/verificar'] = "registro/CallWsValidarUsuario";
$route['registro/telefonos'] = "registro/CallWsListaTelefonos";
$route['registro/listadoDepartamento'] = "registro/CallWsListaDepartamento";    // Listado de Departamento
$route['registro/ListadoProfesiones'] = "registro/CallWsListaProfesiones";      // Listado de Profesiones
$route['registro/registrar'] = "registro/CallWsRegistrar";
$route['registro/identificaciones'] = "registro/CallWsListaIdentificadores";

$route['dashboard'] = "dashboard";
$route['dashboard/error'] = "dashboard/error_dashboard";
$route['dashboard/load'] = "dashboard/CallWsDashboard";
$route['dashboard/saldo'] = "dashboard/CallWsSaldo";

$route['detalles'] = "detail";
$route['detalles/load'] = "detail/CallWsDetail";
$route['detalles/movimientos'] = "detail/CallWsMovimientos";
$route['detalles/exportar'] = "detail/CallWsExportar";

$route['transferencia'] = "transfer";
$route['transferencia/error'] = "transfer/error_transfer";
$route['transferencia/error_pago'] = "transfer/error_pago";
$route['transferencia/ctaDestino'] = "transfer/CallWsCtaDestino";
$route['transferencia/ctaOrigen'] = "transfer/CallWsCtaOrigen";
$route['transferencia/operaciones'] = "transfer/CallWsValidarClave";
$route['transferencia/crearClave'] = "transfer/CallWsClaveAutenticacion";
$route['transferencia/confirmacion'] = "transfer/CallWsValidarClaveAutenticacion";
$route['transferencia/procesar'] = "transfer/CallWsProcesarTransferencia";

$route['affiliation'] = "affiliation";
$route['affiliation/cuentasP2P'] = "affiliation/CallWstarjetasP2P";
$route['affiliation/affiliation'] = "affiliation/CallWsAffiliationP2P";
$route['affiliation/affiliation_P2T'] = "affiliation/CallWsAffiliationP2T";
$route['affiliation/affiliation_P2C'] = "affiliation/CallWsAffiliationP2C";
$route['affiliation/bancos'] = "affiliation/CallWsBancos";

$route['adm'] = "adm";
$route['adm/adm_bank'] = "adm/adm_bank";
$route['adm/adm_tdc'] = "adm/adm_tdc";
$route['adm/modificar'] = "adm/CallWsAdm";
$route['adm/eliminar'] = "adm/CallWsDlt";

$route['historial'] = "historial";
$route['historial/historial'] = "historial/CallWsHistorial";
		
$route['report'] = "report";
$route['report/error'] = "report/report_error";
$route['report/exp_xls'] = "report/CallWsExpXLS";
$route['report/exp_pdf'] = "report/CallWsExpPDF";

$route['perfil'] = "perfil";
$route['perfil/load'] = "perfil/CallWsPerfil";
$route['perfil/error'] = "perfil/error_perfil";
$route['perfil/listado'] = "perfil/CallWsLista";
$route['perfil/listaEstado'] = "perfil/CallWsListaEstado";
$route['perfil/listaCiudad'] = "perfil/CallWsListaCiudad";
$route['perfil/listadoDepartamento'] = "perfil/CallWsListaDepartamento"; // new
$route['perfil/verificarEmail']="perfil/CallWsverificarEmail"; // new
$route['perfil/profesiones'] = "perfil/CallWsListaProfesiones";
$route['perfil/telefonos'] = "perfil/CallWsListaTelefonos";
$route['perfil/direcciones'] = "perfil/CallWsListaDirecciones";
$route['perfil/actualizar'] = "perfil/CallWsActualizar";
$route['servicios'] = "service";
$route['servicios/modelo'] = "service/CallModel";
$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
