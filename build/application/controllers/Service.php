<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function index()
    {

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        $pais = $this->session->userdata('pais');
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');
        //$this->load->model('transfer_model', 'service');
        $this->load->model('dashboard_model', 'getCuentas');
        //INSTANCIA PARA TITULO DE PAGINA
        $titlePage = 'Conexión Personas Online';
        //INSTANCIA PARA INSERTAR HOJAS DE ESTILOS
        $styleSheets = array(
            array('url' => 'base.css', 'media' => 'screen'),
            array('url' => 'service.css', 'media' => 'screen'),
            array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
            array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
        );
        //INSTANCIA GENERAR  HEADER
        $menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'service'), true);
        //INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
        $header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
        //INSTANACIA DEL CONTENIDO PARA EL FOOTER
        $FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js','service.js', 'service-functions.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
        //INSTANCIA DEL FOOTER
        $footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
        //INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
        $content = $this->parser->parse('service/service-content', array('data' => serialize(json_decode($this->getCuentas->dashboard_load('P2P'))), 'pais'=>$pais), true);
        //INSTANCIA DE SIDERBAR
        $sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

        //DATA QUE SE PASA AL LAYOUT EN GENERAL
        //ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
        $data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

        $this->parser->parse('layouts/layout-a', $data);
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function CallModel() {

        //VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        //VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
				//Get Data
				$data = json_decode(
					$this->security->xss_clean(
						strip_tags(
							$this->cryptography->decrypt(
								base64_decode($this->input->get_post('plot')),
								utf8_encode($this->input->get_post('request'))
							)
						)
					)
				);
				$dataRequest = $data->formData;
				//Load model file
        $this->load->model('service_model', 'service');
        //Get method
        $method = 'callWs'.$data->model;
        //Call the method
				$dataResponse = $this->service->$method($dataRequest);
				$dataResponse = $this->cryptography->encrypt($dataResponse);
        //Response to the js file
        $this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));
    }

		public function error_services()
		{

			// VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			// CARGO EL ARCHIVO DE LENGUAJE
			$this->lang->load('format');
			$this->load->model('service_model', 'error');
			//INSTANCIA PARA TITULO DE PAGINA
			$titlePage = 'Conexión Personas Online';
			//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
			$styleSheets = array(
				array('url' => 'base.css', 'media' => 'screen'),
				array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
				array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
			);
			//INSTANCIA GENERAR  HEADER
			$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'service'), true);
			//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
			$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
			//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
			$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'transfer-tdc.js', 'jquery-md5.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'jquery.balloon.min.js');
			//INSTANCIA DEL FOOTER
			$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO TDC
			$content = $this->parser->parse('service/service-error-content', array(), true);
			//INSTANCIA DE SIDERBAR
			$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);
			//DATA QUE SE PASA AL LAYOUT EN GENERAL
			//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
			$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

			$this->parser->parse('layouts/layout-a', $data);
		}

}// FIN
