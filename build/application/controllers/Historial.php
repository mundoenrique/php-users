<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Historial extends CI_Controller {

/**
 * [login description]
 * @param  [type] $urlCountry
 * @return [type]
 */

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function index(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('historial_model', 'historial');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'historial.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('historial/historial-p2p-content', array('data' => serialize(json_decode($this->historial->ctasOrigen_load('P2P')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function historial_bank(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('historial_model', 'historial');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'historial_bank.js',  'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO BANCO
		$content = $this->parser->parse('historial/historial-bank-content', array('data' => serialize(json_decode($this->historial->ctasOrigen_load("P2T")))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function historial_tdc(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('historial_model', 'historial');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
			//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'pago'), true);
			//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
			//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-1.9.1.min.js', 'jquery-ui-1.10.3.custom.min.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'historial_tdc.js', 'jquery-md5.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'jquery.balloon.min.js');
			//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO TDC
		$content = $this->parser->parse('historial/historial-tdc-content', array('data' => serialize(json_decode($this->historial->ctasOrigen_load("P2C")))), true);
			//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsHistorial(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('historial_model', 'historial');

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
		$noTarjeta = $dataRequest->noTarjeta;
		$tipoOperacion = $dataRequest->tipoOperacion;
		$mes = $dataRequest->mes;
		$anio = $dataRequest->anio;

		$this->output->set_content_type('application/json')->set_output($this->historial->historial_load($noTarjeta, $tipoOperacion, $mes, $anio));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsCtaOrigen(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'transfer');
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

}// FIN
