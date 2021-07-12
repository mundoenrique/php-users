<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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

		$this->load->model('transfer_model', 'tran');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'reportes'), true);
		//INSTANCIA GENERAR  FOOTER
		$menuFooter = $this->parser->parse('widgets/widget-menuFooter', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeaderMainActive' => false, 'menuHeader' => $menuHeader, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js','cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'report.js', 'kendo.dataviz.min.js', 'jquery.validate.min.js', 'jquery.ui.datepicker.validation.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'menuFooter' => $menuFooter, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('report/report-content', array('data' => serialize(json_decode($this->tran->ctasOrigen_load('RGR')))), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-b', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function report_error()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('transfer_model', 'tran');
		//INSTANCIA PARA TITULO DE PAGINA
		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'reportes'), true);
		//INSTANCIA GENERAR  FOOTER
		$menuFooter = $this->parser->parse('widgets/widget-menuFooter', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeaderMainActive' => false, 'menuHeader' => $menuHeader, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANACIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.6.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'report.js', 'kendo.dataviz.min.js', 'jquery.validate.min.js','transfers/transfer-tdc.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'menuFooter' => $menuFooter, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('report/report-content-error', array(), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-b', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsGastos()
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

		$this->load->model('report_model', 'report');
		$tarjeta = $dataRequest->tarjeta;
		$tipoConsulta = $dataRequest->tipo;
		$producto = $dataRequest->producto;
		$fechaIni = $dataRequest->fechaIni;
		$fechaFin = $dataRequest->fechaFin;
		$idpersona = $dataRequest->idpersona;

		$_POST['tarjeta'] = $tarjeta;
		$_POST['tipo'] = $tipoConsulta;
		$_POST['producto'] = $producto;
		$_POST['fechaIni'] = $fechaIni;
		$_POST['fechaFin'] = $fechaFin;
		$_POST['idpersona'] = $idpersona;
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('CallWsGastos');
		unset($_POST);

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));

			$response = json_encode($this->cryptography->encrypt(['rc'=> -9999]));
		} else {
			$response = $this->report->gastos_model($tarjeta, $idpersona, $producto, $tipoConsulta, $fechaIni, $fechaFin);
		}

		$this->output->set_content_type('application/json')->set_output($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsExpXLS()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('report_model', 'detail');

		$tarjeta = $this->input->post('tarjeta');
		$producto = $this->input->post('producto');
		$idpersona = $this->input->post('idpersona');
		$tipoConsulta = $this->input->post('tipoConsulta');
		$idExtEmp = $this->input->post('id_ext_emp');
		$fechaIni = $this->input->post('fechaIni');
		$fechaFin = $this->input->post('fechaFin');

		log_message('DEBUG', 'NOVO DATA TO VALIDATE download-file: '.json_encode($_POST));
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('download-file');

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			redirect(base_url('dashboard'), 'location');
			exi();
		}

		$response = $this->detail->exp_xls($idpersona, $tarjeta, $producto, $tipoConsulta, $idExtEmp, $fechaIni, $fechaFin);
		$response = json_decode($response);

		np_hoplite_byteArrayToFile($response->archivo, 'xls', 'Reporte');

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsExpPDF()
	{

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('report_model','detail');

		$tarjeta = $this->input->post('tarjeta');
		$producto = $this->input->post('producto');
		$idpersona = $this->input->post('idpersona');
		$tipoConsulta = $this->input->post('tipoConsulta');
		$idExtEmp = $this->input->post('id_ext_emp');
		$fechaIni = $this->input->post('fechaIni');
		$fechaFin = $this->input->post('fechaFin');

		log_message('DEBUG', 'NOVO DATA TO VALIDATE download-file: '.json_encode($_POST));
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('download-file');

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			redirect(base_url('dashboard'), 'location');
			exi();
		}

		$response = $this->detail->exp_pdf($idpersona, $tarjeta, $producto, $tipoConsulta, $idExtEmp, $fechaIni, $fechaFin);
		$response = json_decode($response);

		np_hoplite_byteArrayToFile($response->archivo, 'pdf', 'Reporte');

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

} //FIN
