<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * An example class
 *
 * The class is empty for the sake of this example.
 *
 * @package    Users
 * @subpackage Controller
 * @author     Lenin Luque <xleninx@gmail.com>
*/

	class Affiliation extends CI_Controller {

	/**
	 * [login description]
	 * @param  [type] $urlCountry
	 * @return [type]
	 */

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function index() {

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		// CARGO EL MODELO
		$this->load->model('affiliation_model', 'affiliation');
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
		$FooterCustomInsertJS = array('jquery-1.9.1.min.js', 'jquery-ui-1.10.3.custom.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'affiliation.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('affiliation/affiliation-p2p-content', array('data' => serialize(json_decode($this->affiliation->ctasOrigen_load('P2P')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	public function affiliation_bank() {

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('affiliation_model', 'affiliation');
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
		$FooterCustomInsertJS = array('jquery-1.9.1.min.js', 'jquery-ui-1.10.3.custom.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'affiliation.js', 'affiliation.js', 'affiliation_bank.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
			//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('affiliation/affiliation-bank-content', array('data' => serialize(json_decode($this->affiliation->ctasOrigen_load('P2T')))), true);
			//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	public function affiliation_tdc() {

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('affiliation_model', 'affiliation');
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
			//INSTANCIA DEL CONTENIDO PARA EL HEADER, INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
			//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-1.9.1.min.js', 'jquery-ui-1.10.3.custom.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'affiliation_tdc.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
			//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('affiliation/affiliation-tdc-content', array('data' => serialize(json_decode($this->affiliation->ctasOrigen_load('P2C')))), true);
			//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}
	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWstarjetasP2P(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('affiliation_model', 'cuentaP2P');
		$noTarjeta =  $this->input->post('noTarjeta');
		$this->output->set_content_type('application/json')->set_output($this->cuentaP2P->affiliationP2T_cuenta($noTarjeta));

	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


		public function CallWsAffiliationP2P(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('affiliation_model', 'affiliation');
		$nroPlasticoOrigen = $this->input->post('nroPlasticoOrigen');
		$beneficiario = $this->input->post('beneficiario');
		$nroCuentaDestino = $this->input->post('nroCuentaDestino');
		$tipoOperacion = $this->input->post('tipoOperacion');
		$email = $this->input->post('email');
		$cedula = $this->input->post('cedula');
		$prefix = $this->input->post('prefix');
		$expDate = $this->input->post('expDate');


		$this->output->set_content_type('application/json')->set_output($this->affiliation->affiliation_load($nroPlasticoOrigen, $beneficiario, $nroCuentaDestino, $tipoOperacion, $email, $cedula, $prefix, $expDate));
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsAffiliationP2T(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('affiliation_model', 'affiliationP2T');
		$nroPlasticoOrigen = $this->input->post('nroPlasticoOrigen');
		$beneficiario = $this->input->post('beneficiario');
		$nroCuentaDestino = $this->input->post('nroCuentaDestino');
		$tipoOperacion = $this->input->post('tipoOperacion');
		$email = $this->input->post('email');
		$cedula = $this->input->post('cedula');
		$banco =  $this->input->post('banco');
		$prefix = $this->input->post('prefix');

		log_message('info', 'Beneficiario ', $beneficiario);

		$this->output->set_content_type('application/json')->set_output($this->affiliationP2T->affiliationP2T_load($nroPlasticoOrigen, $beneficiario, $nroCuentaDestino, $tipoOperacion, $email, $banco, $cedula, $prefix));

	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsBancos(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('affiliation_model', 'consultarBancos');
		$this->output->set_content_type('application/json')->set_output($this->consultarBancos->consultarBancos_load());

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

}  // FIN GENERAL
