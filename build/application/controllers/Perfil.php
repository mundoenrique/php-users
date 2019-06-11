<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

    /**
     * [login description]
     * @param  [type] $urlCountry
     * @return [type]
     */

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function index()
    {

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');
        $this->load->model('perfil_model', 'perfil');

        $userName=$this->input->post('userName');
        //INSTANCIA PARA TITULO DE PAGINA
        $titlePage = 'Conexión Personas Online';
        //INSTANCIA PARA INSETAR HOJAS DE ESTILOS
        $styleSheets = array(
            array('url' => 'profile.css', 'media' => 'screen'),
            array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
            array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
        );
        //INSTANCIA GENERAR  HEADER
        $menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'perfil'), true);
        //INSTANCIA GENERAR  FOOTER
        $menuFooter = $this->parser->parse('widgets/widget-menuFooter', array(), true);
        //INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
        $header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeaderMainActive' => false, 'menuHeader' => $menuHeader, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
        //INSTANACIA DEL CONTENIDO PARA EL FOOTER.
        $FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js','cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'perfil.js' , 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'kendo.dataviz.min.js', 'additional-methods.min.js');
        //INSTANCIA DEL FOOTER
        $footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'menuFooter' => $menuFooter, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
        //INSTANCIA DE PARTE DE CUERPO
				$content = $this->parser->parse(
					'perfil/perfil-content',
					[
						'data' => serialize(json_decode($this->perfil->perfil_load($userName))),
						'country' => $this->session->userdata('pais')
					],
					true
				);
        //INSTANCIA DE SIDERBAR
        $sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

        //DATA QUE SE PASA AL LAYOUT EN GENERAL
        //ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
        $data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

        $this->parser->parse('layouts/layout-b', $data);
    }


    public function error_perfil()
    {
        //INSTANCIA PARA TITULO DE PAGINA
        $titlePage = 'Conexión Personas Online';
        //INSTANCIA PARA INSETAR HOJAS DE ESTILOS
        $styleSheets = array(
            array('url' => 'base.css', 'media' => 'screen'),
            array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
            array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
        );
        //INSTANCIA GENERAR  HEADER
        $menuHeader = $this->parser->parse('widgets/widget-menuHeader', array(), true);
        //INSTANCIA DEL CONTENIDO PARA EL HEADER, INCLUYE MENU
        $header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => false, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
        //INSTANACIA DEL CONTENIDO PARA EL FOOTER
        $FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.ui.sliderbutton.js',  'jquery-md5.js', 'jquery.balloon.min.js');
        //INSTANCIA DEL FOOTER
        $footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
        //INSTANCIA DE PARTE DE CUERPO
        $content = $this->parser->parse('perfil/perfil-content-error', array(), true);
        //INSTANCIA DE SIDERBAR
        $sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

        //DATA QUE SE PASA AL LAYOUT EN GENERAL
        //ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
        $data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

        $this->parser->parse('layouts/layout-a', $data);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsPerfil() {
				if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');

			$userName = $this->input->post('userName');
			$this->load->model('perfil_model', 'perfil');

			$this->output->set_content_type('application/json')->set_output($this->perfil->perfil_load($userName));
			log_message('info', 'Salida cargar perfil ' . $this->perfil->perfil_load($userName));

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsActualizar(){
				if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTILIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');


			$this->load->model('perfil_model', 'actualizar');

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

        //print_r($dataRequest);
        $userName = (isset($dataRequest->userName))? $dataRequest->userName :""; // /1
        $primerNombre = (isset($dataRequest->primerNombre))? $dataRequest->primerNombre : ""; // /2
        $segundoNombre = (isset($dataRequest->segundoNombre))? $dataRequest->segundoNombre : ""; // /3
        $primerApellido = (isset($dataRequest->primerApellido))? $dataRequest->primerApellido : ""; // /4
        $segundoApellido = (isset($dataRequest->segundoApellido))? $dataRequest->segundoApellido : ""; // /5
        $lugarNacimiento = (isset($dataRequest->lugar_nac))? $dataRequest->lugar_nac : "";// /6
        $fechaNacimiento = (isset($dataRequest->fechaNacimiento))? $dataRequest->fechaNacimiento : ""; // /7
        $sexo = (isset($dataRequest->sexo))? $dataRequest->sexo : ""; // /8
        $edocivil = (isset($dataRequest->edocivil))? $dataRequest->edocivil : ""; // /9
        $nacionalidad = (isset($dataRequest->nacionalidad))? $dataRequest->nacionalidad : ""; // /10
        $profesion = (isset($dataRequest->profesion))? $dataRequest->profesion : ""; // /11
        $tipoDireccion = (isset($dataRequest->tipo_direccion))? $dataRequest->tipo_direccion :""; // /12
        $codepostal = (isset($dataRequest->acZonaPostal))? $dataRequest->acZonaPostal :""; // /13
        $paisResidencia = (isset($dataRequest->paisResidencia))? $dataRequest->paisResidencia :""; // /14
        $departamento_residencia = (isset($dataRequest->departamento_residencia))? $dataRequest->departamento_residencia :""; // /15
        $provincia_residencia = (isset($dataRequest->provincia_residencia))? $dataRequest->provincia_residencia :""; // /16
        $distrito_residencia = (isset($dataRequest->distrito_residencia))? $dataRequest->distrito_residencia :""; // /17
        $direccion = (isset($dataRequest->direccion))? $dataRequest->direccion :""; // /18
        $telefono_hab = (isset($dataRequest->telefono_hab))? $dataRequest->telefono_hab : ""; // /19
        $telefono = (isset($dataRequest->telefono))? $dataRequest->telefono : ""; // /20
        $otro_telefono_tipo = (isset($dataRequest->otro_telefono_tipo))? $dataRequest->otro_telefono_tipo: ""; // /21
        $otro_telefono_num = (isset($dataRequest->otro_telefono_num))? $dataRequest->otro_telefono_num:""; // /22
        $email = (isset($dataRequest->email))? $dataRequest->email:""; // /23
        $ruc_cto_labora = (isset($dataRequest->ruc_cto_labora))? $dataRequest->ruc_cto_labora: ""; // /24
        $centro_laboral = (isset($dataRequest->centro_laboral))? $dataRequest->centro_laboral: ""; // /25
        $situacion_laboral = (isset($dataRequest->situacion_laboral))? $dataRequest->situacion_laboral: ""; // /26
        $antiguedad_laboral_value = (isset($dataRequest->antiguedad_laboral_value))? $dataRequest->antiguedad_laboral_value: ""; // /27
        $profesion_labora = (isset($dataRequest->profesion_labora))? $dataRequest->profesion_labora: ""; // /28
        $cargo = (isset($dataRequest->cargo))? $dataRequest->cargo: ""; // /29
        $ingreso_promedio = (isset($dataRequest->ingreso_promedio))? $dataRequest->ingreso_promedio: ""; // /30
        $cargo_public = (isset($dataRequest->cargo_publico_sino))? $dataRequest->cargo_publico_sino: ""; // /31
        $cargo_publico = (isset($dataRequest->cargo_publico))? $dataRequest->cargo_publico: ""; // /32
        $institucion_publica = (isset($dataRequest->institucion_publica))? $dataRequest->institucion_publica: ""; // /33
        $sujeto_obligado = (isset($dataRequest->sujeto_obligado))? $dataRequest->sujeto_obligado: ""; // /34
        $notEmail = (isset($dataRequest->notEmail))? $dataRequest->notEmail: ""; // /35
        $notSms = (isset($dataRequest->notSms))? $dataRequest->notSms: ""; // /36
        $dtfechorcrea_usu = (isset($dataRequest->dtfechorcrea_usu))? $dataRequest->dtfechorcrea_usu: ""; // /37
        $id_ext_per= (isset($dataRequest->id_ext_per))? $dataRequest->id_ext_per: ""; // /38
        $tipo_profesion= (isset($dataRequest->tipo_profesion))? $dataRequest->tipo_profesion: ""; // /39
        $tipo_identificacion= (isset($dataRequest->tipo_identificacion))? $dataRequest->tipo_identificacion: ""; // /40
        $tipo_id_ext_per=(isset($dataRequest->tipo_id_ext_per))? $dataRequest->tipo_id_ext_per: ""; // /41
        $aplicaPerfil=(isset($dataRequest->aplicaPerfil))? $dataRequest->aplicaPerfil: ""; // /42
        $notarjeta=(isset($dataRequest->notarjeta))? $dataRequest->notarjeta: ""; // /43
        $acCodCiudad=(isset($dataRequest->acCodCiudad))? $dataRequest->acCodCiudad: "";
        $acCodEstado=(isset($dataRequest->acCodEstado))? $dataRequest->acCodEstado: "";
        $acCodPais=(isset($dataRequest->acCodPais))? $dataRequest->acCodPais: "";
        $acTipo=(isset($dataRequest->acTipo))? $dataRequest->acTipo: "";
        $acZonaPostal=(isset($dataRequest->acZonaPostal))? $dataRequest->acZonaPostal: "";
        $disponeClaveSMS=(isset($dataRequest->disponeClaveSMS))? $dataRequest->disponeClaveSMS: "";
        $codigopais=(isset($dataRequest->acCodPais))? $dataRequest->acCodPais: "";
        $verifyDigit=(isset($dataRequest->verifyDigit))? $dataRequest->verifyDigit: "";
        $proteccion=(isset($dataRequest->proteccion))? $dataRequest->proteccion: "";
        $contrato=(isset($dataRequest->contrato))? $dataRequest->contrato: "";
        $tyc=(isset($dataRequest->tyc))? $dataRequest->tyc: "";
        $notSms= (isset($dataRequest->notSms))? $dataRequest->notSms: "";
		$notEmail= (isset($dataRequest->notEmail))? $dataRequest->notEmail: "";
		$proteccion = (isset($dataRequest->proteccion))? $dataRequest->proteccion: "";
		$contrato = (isset($dataRequest->contrato))? $dataRequest->contrato: "";
        log_message("info", "COMPROBAR ACTUALIZAR PERFIL===> ".$userName);



        $this->output->set_content_type('application/json')->set_output($this->actualizar->perfil_update($userName, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $lugarNacimiento, $fechaNacimiento, $sexo, $edocivil, $nacionalidad, $profesion, $tipoDireccion,
            $codepostal, $paisResidencia, $departamento_residencia, $provincia_residencia, $distrito_residencia, $direccion, $telefono_hab, $telefono, $otro_telefono_tipo, $otro_telefono_num, $email, $ruc_cto_labora, $centro_laboral, $situacion_laboral, $antiguedad_laboral_value,
            $profesion_labora, $cargo, $ingreso_promedio, $cargo_public, $cargo_publico, $institucion_publica, $sujeto_obligado, $notEmail, $notSms, $dtfechorcrea_usu, $id_ext_per, $tipo_profesion, $tipo_identificacion, $tipo_id_ext_per, $aplicaPerfil,
            $notarjeta, $acCodCiudad, $acCodEstado, $acCodPais, $acTipo, $acZonaPostal, $disponeClaveSMS, $codigopais, $verifyDigit, $proteccion, $contrato, $tyc));

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsLista(){
			if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTILIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');

			$this->load->model('perfil_model', 'listado');
			$this->output->set_content_type('application/json')->set_output($this->listado->lista_paises());

    }
//-----------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function CallWsverificarEmail()
    {

        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');

				$this->load->model('perfil_model','verificarEmail');

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

        $pais			= $dataRequest->pais;
        $email		= $dataRequest->email;
        $username	= $dataRequest->username;


        $this->output->set_content_type('application/json')->set_output($this->verificarEmail->verificar_email($pais, $email, $username));

    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsListaEstado()
		{
			if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');

			$this->load->model('perfil_model', 'listaEstado');

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
			$codPais = $dataRequest->codPais;

			$this->output->set_content_type('application/json')->set_output($this->listaEstado->lista_estados($codPais));

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsListaCiudad()
		{
			if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');

			$this->load->model('perfil_model', 'listaCiudad');

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

			$codEstado = $dataRequest->codEstado;
			$codPais = $dataRequest->codPais;

			$this->output->set_content_type('application/json')->set_output($this->listaCiudad->lista_ciudad($codEstado,$codPais));

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsListaProfesiones()
		{
			if(!$this->input->is_ajax_request()) {
				redirect(base_url('dashboard'), 'location');
				exit();
			}

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');

        $this->load->model('perfil_model', 'profesiones');
        $this->output->set_content_type('application/json')->set_output($this->profesiones->lista_profesiones());

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsListaDirecciones(){

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');

        $this->load->model('perfil_model', 'direcciones');
        $this->output->set_content_type('application/json')->set_output($this->direcciones->lista_direcciones());

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsListaTelefonos(){

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');

        $this->load->model('perfil_model', 'telefonos');
        $this->output->set_content_type('application/json')->set_output($this->telefonos->lista_telefonos());

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function CallWsListaDepartamento()
    {

        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');

				$this->load->model('perfil_model', 'listadoDepartamento');

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

        $pais		= $dataRequest->pais;
        $subRegion	= $dataRequest->subRegion;
        $this->output->set_content_type('application/json')->set_output($this->listadoDepartamento->lista_departamentos($pais, $subRegion));

    }
//------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
