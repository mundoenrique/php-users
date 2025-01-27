<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer extends CI_Controller {

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
		$this->lang->load('transfer');
		$this->load->model('transfer_model', 'transfer');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfers/transfersHelpers.js', 'transfers/transfer.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'novo_helper.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('transfer/transfers-content', array('data' => serialize(json_decode($this->transfer->ctasOrigen_load('P2P')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function index_bank()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->lang->load('transfer');
		$this->load->model('transfer_model', 'transfer');

		$t=$this->session->userdata('transferir');
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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfers/transfersHelpers.js', 'transfers/transfer-bank.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'novo_helper.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO BANCO
		$content = $this->parser->parse('transfer/transfers-bank-content', array('data' => serialize(json_decode($this->transfer->ctasOrigen_load('P2T'))), 't' => $t), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);
		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function index_tdc()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->lang->load('transfer');
		$this->load->model('transfer_model', 'transfer');
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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfers/transfersHelpers.js', 'transfers/transfer-tdc.js', 'jquery-md5.js', 'jquery.ui.sliderbutton.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'jquery.balloon.min.js', 'novo_helper.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO TDC
		$content = $this->parser->parse('transfer/transfers-tdc-content', array('data' => serialize(json_decode($this->transfer->ctasOrigen_load('P2C')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);
		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function error_transfer()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('transfer_model', 'error');
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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'transfer-tdc.js', 'jquery-md5.js', 'jquery.validate.min.js', 'additional-methods.min.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO TDC
		$content = $this->parser->parse('transfer/transfers-error-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);
		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function error_pago()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('transfer_model', 'error');
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
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'transfer-tdc.js', 'jquery-md5.js', 'jquery.validate.min.js',  'additional-methods.min.js', 'jquery.balloon.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO TDC
		$content = $this->parser->parse('transfer/transfers-error-tdc-content', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin= $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);
		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
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

		$pais = $this->session->userdata('pais');
		log_message('info', 'PAIS Cta Destino Controller: ' . $pais);

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

		$tarjeta = $dataRequest->nroTarjeta;
		$prefijo = $dataRequest->prefijo;
		$operacion = $dataRequest->operacion;

		$json = $this->ctaDestino->ctasDestino_load($tarjeta, $prefijo, $operacion);

		$this->output->set_content_type('application/json')->set_output($json);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsValidarClave(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'operaciones');

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

		$clave = $dataRequest->clave;

		$rpta['response']= $this->operaciones->validarClave_load($clave);
		$rc = json_decode($rpta['response']);
		$rc = $rc->rc;

		if($rc==0){
			$data = array('transferir' => true);
			$this->session->set_userdata($data);
		}else{
			$data = array('transferir' => false);
			$this->session->set_userdata($data);
		}

		$rpta['transferir'] = $this->session->userdata('transferir');

		$response = $this->cryptography->encrypt($rpta);
		$this->output->set_content_type('application/json')->set_output(json_encode($response));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsClaveAutenticacion(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'transfer');
		$this->output->set_content_type('application/json')->set_output($this->transfer->claveAutenticacion_load());

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsValidarClaveAutenticacion(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'confirmacion');
		$clave =  $this->input->post('clave');

		$this->output->set_content_type('application/json')->set_output($this->confirmacion->validarClaveAutenticacion_load($clave));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsProcesarTransferencia(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'procesar');

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

		$cuentaOrigen = $dataRequest->cuentaOrigen;
		$cuentaDestino = $dataRequest->cuentaDestino;
		$monto = $dataRequest->monto;
		$descripcion = $dataRequest->descripcion;
		$tipoOpe = $dataRequest->tipoOpe;
		$id_afil_terceros = $dataRequest->id_afil_terceros;
		$expDate = $dataRequest->expDate;

		$this->output->set_content_type('application/json')->set_output(
			$this->procesar->procesarTransferencia_load(
				$cuentaOrigen, $cuentaDestino, $monto, $descripcion, $tipoOpe, $id_afil_terceros, $expDate
			)
		);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------


}// FIN
