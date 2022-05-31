<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TransferPe extends CI_Controller {

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
	$this->load->model('transferPe_model', 'transfer');
	//INSTANCIA PARA TITULO DE PAGINA
	$titlePage = 'Conexión Personas Online';
	//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS
	$styleSheets = array(
		array('url' => 'base.css', 'media' => 'screen'),
		array('url' => 'transfer-pe.css', 'media' => 'screen'),
		array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
		array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
	);
	//INSTANCIA GENERAR  HEADER
	$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
	//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
	$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
	//INSTANACIA DEL CONTENIDO PARA EL FOOTER
	$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfersPe/transfersHelpersPe.js', 'transfersPe/transferPe.js', 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
	//INSTANCIA DEL FOOTER
	$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
	//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
	$content = $this->parser->parse('transferPe/transfers-pe', array('data' => serialize(json_decode($this->transfer->ctasOrigen_load('P2P')))), true);
	//INSTANCIA DE SIDERBAR
	$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

	//DATA QUE SE PASA AL LAYOUT EN GENERAL
	//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
	$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

	$this->parser->parse('layouts/layout-a', $data);
}


// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsValidarClave(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transferPe_model', 'operaciones');
		$clave = $this->input->post('clave');

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

		$dataResponse = $this->session->userdata('transferir');

		$this->output->set_content_type('application/json')->set_output(json_encode($dataResponse));

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	// Montos base sin autorizaciónote

	public function limit()
	{
		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->lang->load('transfer');
		$this->load->model('transferPe_model', 'transfer');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online Limite';
		//INSTANCIA PARA INSERTAR HOJAS DE ESTILOS

		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'transfer-pe.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfersPe/limitPe.js', 'transfersPe/limitPe-functions.js' ,'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO PLATA-PLATA
		$content = $this->parser->parse('transferPe/limit_pe', array('amounts' => serialize(json_decode($this->transfer->baseAmount()))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);

	}


	// HISTORIAL DE OPERACIONES P2P PERU
	public function historial_pe(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');
		$this->load->model('transferPe_model', 'transfer');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'transfer-pe.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'transfer'), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeader' => $menuHeader, 'menuHeaderMainActive' => false, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.13.1.min.js', 'jquery.isotope.min.js', 'jquery.ui.sliderbutton.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'transfersPe\historialPe.js',  'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'additional-methods.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DEL CUERPO BANCO
		$content = $this->parser->parse('transferPe/historial-p2p-pe', array('data' => serialize(json_decode($this->transfer->ctasOrigen_load('P2P')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-a', $data);
	}

	// HISTORIAL DE OPERACIONES P2P PERU
	public function maketransferPe(){

		//VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		//VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		//Load model file
		$this->load->model('transferPe_model', 'transferPe');
		//Get Data
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
		$data_request = $dataRequest->data;
		$token = $dataRequest->token;

		//Llama al metodo según sea necesario, con token o sin token
		if($token === '1'){

				$dataResponse = $this->transferPe->makeTransferPinPe($data_request);
		}
		else{
				$dataResponse = $this->transferPe->makeTransferPe($data_request);
		}

		//Response to the js file
		$this->output->set_content_type('application/json')->set_output(($dataResponse));

	}

	// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallModel() {

			//VERIFICA SI LA SESION ESTA ACTIVA
			np_hoplite_verificLogin();
			//VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
			np_hoplite_countryCheck($this->session->userdata('pais'));
			//Load model file
			$this->load->model('transferPe_model', 'transferPe');

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
			//Get method
			$method = $dataRequest->model;
			//Get Data
			$dataRequest = $dataRequest->data;
			//Call the method
			$dataResponse = $this->transferPe->$method($dataRequest);
			//Response to the js file
			$this->output->set_content_type('application/json')->set_output(($dataResponse));
	}


}// FIN
