<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Adm extends CI_Controller {

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
		$this->load->model('adm_model', 'adm');

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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'adm-affiliation.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('adm_affiliation/adm-affiliation-p2p-content', array('data' => serialize(json_decode($this->adm->ctasOrigen_load('P2P')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	public function adm_bank() {

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('adm_model', 'adm');

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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'adm-affiliation-bank.js', 'jquery-md5.js', 'jquery.balloon.min.js',  'jquery.validate.min.js',  'additional-methods.min.js');
			//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('adm_affiliation/adm-affiliation-bank-content', array('data' => serialize(json_decode($this->adm->ctasOrigen_load('P2T')))), true);
			//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


	public function adm_tdc() {

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('adm_model', 'adm');
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
		//INSTANCIA DEL CONTENIDO PARA EL HEADER , INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANCIA DEL CONTENIDO PARA EL FOOTER
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'adm-affiliation-tdc.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
			//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
			//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('adm_affiliation/adm-affiliation-tdc-content', array('data' => serialize(json_decode($this->adm->ctasOrigen_load('P2C')))), true);
			//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsAdm(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('adm_model', 'adm');

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

		$id_afiliacion = $dataRequest->id_afiliacion;
		$nroPlasticoOrigen = $dataRequest->nroPlasticoOrigen;
		$nroCuentaDestino = $dataRequest->nroCuentaDestino;
		$id_ext_per = $dataRequest->id_ext_per;
		$beneficiario = (isset($dataRequest->beneficiario)) ? $dataRequest->beneficiario :"";
		$tipoOperacion = $dataRequest->tipoOperacion;
		$email = $dataRequest->email;
		$banco = $dataRequest->banco;
		$expDate = $dataRequest->expDate;

		$this->output->set_content_type('application/json')->set_output($this->adm->adm_load($id_afiliacion, $nroPlasticoOrigen, $nroCuentaDestino, $id_ext_per, $beneficiario, $tipoOperacion, $email, $banco, $expDate));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

		public function CallWsDlt(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('adm_model', 'adm');

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
		$noCuentaDestino = $dataRequest->noCuentaDestino;
		$tipoOperacion = $dataRequest->tipoOperacion;

		$this->output->set_content_type('application/json')->set_output($this->adm->delete_load($noTarjeta,$noCuentaDestino,$tipoOperacion));

	}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsBancos(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('adm_model', 'consultarBancos');
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
	public function CallWsCtaDestino(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('transfer_model', 'ctaDestino');

		$tarjeta = $this->input->post('nroTarjeta');
		$prefijo = $this->input->post('prefijo');
		$pais = $this->session->userdata('pais');
		log_message('info', 'PAIS Cta Destino Controller: ' . $pais);
		$operacion = $this->input->post('operacion');

		$json = verify_img_ctaDestino($this->ctaDestino->ctasDestino_load($tarjeta, $prefijo, $operacion),$pais);

		$this->output->set_content_type('application/json')->set_output($json);

	}

}  // FIN GENERAL
