<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro extends CI_Controller {

/**
 * [login description]
 * @param  [type] $urlCountry
 * @return [type]
 */

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
		$this->initCookie();

	}

	private function initCookie() {
		$requestMethod=$this->router->method;

		if($requestMethod == 'index' || $requestMethod == 'index_pe' || $requestMethod == 'index_pi') {

			switch($requestMethod){
				case 'index_pe': 	$code='latodo'; break;
				case 'index_pi': $code='pichincha'; break;
				default: $code='default';
			}

			if ($this->input->cookie($this->config->item('cookie_prefix') . 'skin') === false) {
				$this->load->helper('url');

				$cookie = array(
					'name' => 'skin',
					'value' => $code,
					'expire' => 0,
					'domain' => $this->config->item('cookie_domain'),
					'path' => $this->config->item('cookie_path'),
					'prefix' => $this->config->item('cookie_prefix'),
					'secure' => $this->config->item('cookie_secure')
				);
				$this->input->set_cookie($cookie);
				redirect(current_url());
			}
		}
	}

	public function index_pi()
	{
		$this->load->model('registro_model', 'registro');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS

		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)'),
			array('url' => 'formulario-registro.css', 'media' => 'screen')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'registro.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js',  'kendo.dataviz.min.js', 'additional-methods.min.js', 'jquery.ui.datepicker.validation.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer-registro', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('registro/registro-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header'=>$header, 'content'=>$content, 'footer'=>$footer, 'sidebar'=>$sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

	public function index_pe()
	{
		$this->load->model('registro_model', 'registro');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS

		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)'),
			array('url' => 'formulario-registro.css', 'media' => 'screen')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'registro.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js',  'kendo.dataviz.min.js', 'additional-methods.min.js', 'jquery.ui.datepicker.validation.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer-registro', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('registro/registro-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header'=>$header, 'content'=>$content, 'footer'=>$footer, 'sidebar'=>$sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function index()
	{
		$this->load->model('registro_model','registro');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS

		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)'),
			array('url' => 'formulario-registro.css', 'media' => 'screen')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader	= $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header		= $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'registro.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js',  'kendo.dataviz.min.js', 'additional-methods.min.js', 'jquery.ui.datepicker.validation.min.js');
		//INSTANCIA DEL FOOTER
		$footer		= $this->parser->parse('layouts/layout-footer-registro', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content	= $this->parser->parse('registro/registro-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsLista()
	{
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'listado');
		$this->output->set_content_type('application/json')->set_output($this->listado->lista_paises());
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsValidarCuenta()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model','validar');

		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$pais	= $dataRequest->pais;
		$cuenta	= $dataRequest->cuenta;
		$id_ext_per	= $dataRequest->id_ext_per;
		$pin = $dataRequest->pin;
		$claveWeb	= $dataRequest->claveWeb;
		$userName	= $dataRequest->userName;

		$this->output->set_content_type('application/json')->set_output($this->validar->validar_cuenta($userName, $pais, $cuenta, $id_ext_per, $pin, $claveWeb));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsValidarUsuario()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'validar_usuario');
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$usuario = $dataRequest->usuario;

		log_message('info', 'VALIDACION DEL USUARIO ---> ' . $usuario);

		$this->output->set_content_type('application/json')->set_output($this->validar_usuario->validar_usuario($usuario));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsListaTelefonos()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model','telefonos');
		$this->output->set_content_type('application/json')->set_output($this->telefonos->lista_telefonos());

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsListaDepartamento()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'listadoDepartamento');
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$pais = $dataRequest->pais;
		$subRegion = $dataRequest->subRegion;
		$this->output->set_content_type('application/json')->set_output($this->listadoDepartamento->lista_departamentos($pais, $subRegion));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsListaProfesiones(){

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'profesiones');
		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		$pais = $dataRequest->pais;
		$this->output->set_content_type('application/json')->set_output($this->profesiones->lista_profesiones($pais));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsRegistrar()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'registrar');

		$dataRequest = json_decode(
			$this->security->xss_clean(
				strip_tags(
					$this->cryptography->decrypt(
						base64_decode($this->input->get_post('plot')),
						utf8_encode($this->input->get_post('request'))
					)
				)
			)
		);
		log_message('info', 'dataRequest---> '.json_encode($dataRequest));
		$aplicaPerfil		= $dataRequest->aplicaPerfil;				//0
		$primerNombre		= $dataRequest->primerNombre;				//1
		$segundoNombre 		= $dataRequest->segundoNombre;				//2
		$primerApellido 	= $dataRequest->primerApellido;				//3
		$segundoApellido 	= $dataRequest->segundoApellido;			//4
		$telefono 			= $dataRequest->telefono;					//5
		$numDoc 			= $dataRequest->id_ext_per;					//6
		$verifyDigit		= isset($dataRequest->verifyDigit) ? $dataRequest->verifyDigit : '';
		$fechaNacimiento 	= $dataRequest->fechaNacimiento;			//7
		$typeIdentifier 	= $dataRequest->tipo_id_ext_per;			//8
		$lugarNacimiento 	= isset($dataRequest->lugar_nacimiento) ? $dataRequest->lugar_nacimiento : '';			//9
		$sexo 				= $dataRequest->sexo;						//10
		$edocivil 			= isset($dataRequest->edocivil) ? $dataRequest->edocivil : '';					//11
		$nacionalidad 		= isset($dataRequest->nacionalidad) ? $dataRequest->nacionalidad : '';				//12
		$tipo_direccion 	= isset($dataRequest->tipo_direccion) ? $dataRequest->tipo_direccion : '';				//13
		$cod_postal 		= isset($dataRequest->cod_postal) ? $dataRequest->cod_postal : '';					//14
		$pais 				= $dataRequest->pais;						//15
		$departamento 		= isset($dataRequest->departamento) ? $dataRequest->departamento : '';				//16
		$provincia 			= isset($dataRequest->provincia) ? $dataRequest->provincia : '';					//17
		$distrito 			= isset($dataRequest->distrito) ? $dataRequest->distrito : '';					//18
		$direccion 			= isset($dataRequest->direccion) ? $dataRequest->direccion : '';					//19
		$correo 			= $dataRequest->correo;						//20
		$otroTelefono		= $dataRequest->otro_telefono;				//21
		$telefono2 			= $dataRequest->telefono2;					//22
		$telefono3 			= $dataRequest->telefono3;					//23
		$ruc 				= isset($dataRequest->ruc_cto_laboral) ? $dataRequest->ruc_cto_laboral : '';		//24
		$centrolab 			= isset($dataRequest->centrolab) ? $dataRequest->centrolab : '';					//25
		$situacionLaboral 	= isset($dataRequest->situacionLaboral) ? $dataRequest->situacionLaboral : '';		//26
		$antiguedadLaboral 	= isset($dataRequest->antiguedad_laboral) ? $dataRequest->antiguedad_laboral : '';			//27
		$profesion 			= isset($dataRequest->profesion) ? $dataRequest->profesion : '';					//28
		$cargo 				= isset($dataRequest->cargo) ? $dataRequest->cargo : '';						//29
		$ingreso 			= isset($dataRequest->ingreso_promedio_mensual) ? $dataRequest->ingreso_promedio_mensual : '';	//30
		$desemPublico 		= isset($dataRequest->cargo_publico_last2) ? $dataRequest->cargo_publico_last2 : '';		//31
		$cargoPublico 		= isset($dataRequest->cargo_publico) ? $dataRequest->cargo_publico : '';				//32
		$institucionPublica	= isset($dataRequest->institucion_publica) ? $dataRequest->institucion_publica : '';		//33
		$uif 				= isset($dataRequest->uif) ? $dataRequest->uif : '';						//34
		$userName 			= $dataRequest->userName;					//35
		$password 			= $dataRequest->password;					//36
		$notarjeta			= isset($dataRequest->notarjeta) ? $dataRequest->notarjeta : '';
		$proteccion			= isset($dataRequest->proteccion) ? $dataRequest->proteccion : '';
		$contrato			= isset($dataRequest->contrato) ? $dataRequest->contrato : '';

		log_message('info', 'REGISTRO REGISTRAR ---> ' .$aplicaPerfil.'; '.$primerNombre.'; '.$segundoNombre.'; '.$primerApellido.'; '.$segundoApellido.'; '.$telefono.'; '.$numDoc.'; '.$verifyDigit.'; '.$fechaNacimiento.'; '.$typeIdentifier.'; '.$lugarNacimiento.'; '.$sexo.'; '.$edocivil.'; '.$nacionalidad.'; '.$tipo_direccion.'; '.$cod_postal.'; '.$pais.'; '.$departamento.'; '.$provincia.'; '.$distrito.'; '.$direccion.'; '.$correo.'; '.$telefono2.'; '.$telefono3.'; '.$ruc.'; '.$centrolab.'; '.$situacionLaboral.'; '.$antiguedadLaboral.'; '.$profesion.'; '.$cargo.'; '.$ingreso.'; '.$desemPublico.'; '.$cargoPublico.'; '.$institucionPublica.'; '.$uif.'; '.$userName.'; '.$password.'; '.$proteccion.'; '.$contrato.' FIN<--');

		$this->output->set_content_type('application/json')->set_output($this->registrar->registrar_usuario($aplicaPerfil, $primerNombre, $segundoNombre, $primerApellido,
			$segundoApellido, $telefono, $numDoc, $verifyDigit, $fechaNacimiento, $typeIdentifier, $lugarNacimiento, $sexo, $edocivil, $nacionalidad, $tipo_direccion, $cod_postal, $pais,
			$departamento, $provincia, $distrito, $direccion, $correo, $otroTelefono, $telefono2, $telefono3, $ruc, $centrolab, $situacionLaboral, $antiguedadLaboral, $profesion, $cargo,
			$ingreso, $desemPublico, $cargoPublico, $institucionPublica, $uif, $userName, $password, $notarjeta, $proteccion, $contrato));
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsListaIdentificadores()
	{

		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('registro_model', 'identificadores');
		$this->output->set_content_type('application/json')->set_output($this->identificadores->lista_identificadores());

	}

	public function politicas()
	{
		//$this->load->model('registro_model','registro');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS
		if ($this->input->cookie($this->config->item('cookie_prefix') . 'skin') === false) {
			$this->load->helper('url');

			$cookie = array(
				'name'		=> 'skin',
				'value' 	=> 'default',
				'expire'	=> 0,
				'domain'	=> $this->config->item('cookie_domain'),
				'path'		=> $this->config->item('cookie_path'),
				'prefix'	=> $this->config->item('cookie_prefix'),
				'secure'	=> $this->config->item('cookie_secure')
			);
			$this->input->set_cookie($cookie);
			redirect(current_url());
		}

		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-1.9.1.min.js', 'jquery-ui-1.10.3.custom.min.js', 'jquery.ui.sliderbutton.js', 'jquery.isotope.min.js', 'registro.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js',  'kendo.dataviz.min.js', 'additional-methods.min.js', 'jquery.ui.datepicker.validation.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer-registro', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('registro/politicas-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}		//FIN GENERAL
