<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail extends CI_Controller {

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

		$tarjeta = $this->input->post('numt');
		$prefix = $this->input->post('prefix');
		$marca = $this->input->post('marca');
		$empresa = $this->input->post('empresa');
		$producto = $this->input->post('producto');
		$numt_mascara = $this->input->post('numt_mascara');

		log_message('DEBUG', 'NOVO DATA TO VALIDATE detail-products: '.json_encode($_POST));
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('detail-products');

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			redirect(base_url('dashboard'), 'location');
		}

		//INSTANCIA PARA TITULO DE PAGINA
 		$titlePage = 'Conexión Personas Online';
		//INSTANCIA PARA INSETAR HOJAS DE ESTILOS
		$styleSheets = array(
			array('url' => 'base.css', 'media' => 'screen'),
			array('url' => 'base-320.css', 'media' => 'screen and (max-width: 767px)'),
			array('url' => 'base-768.css', 'media' => 'screen and (min-width: 768px) and (max-width: 1023px)'),
			array('url' => 'print.css', 'media' => 'print')
		);
		//INSTANCIA GENERAR  HEADER
		$menuHeader = $this->parser->parse('widgets/widget-menuHeader', array('pagina' => 'dashboard'), true);
		//INSTANCIA GENERAR  FOOTER
		$menuFooter = $this->parser->parse('widgets/widget-menuFooter', array(), true);
		//INSTANCIA DEL CONTENIDO PARA EL HEADER ,  INCLUYE MENU
		$header = $this->parser->parse('layouts/layout-header', array('menuHeaderActive' => true, 'menuHeaderMainActive' => false, 'menuHeader' => $menuHeader, 'titlePage' => $titlePage, 'styleSheets' => $styleSheets), true);
		//INSTANCIA DEL CONTENIDO PARA EL FOOTER.
		$FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'cypher/aes.min.js', 'cypher/aes-json-format.min.js', 'detail.js', 'kendo.dataviz.min.js');
		//INSTANCIA DEL FOOTER
		$footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'menuFooter' => $menuFooter, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
		//INSTANCIA DE PARTE DE CUERPO
		$content = $this->parser->parse('detail/detail-content', array('tarjeta' => $tarjeta, 'prefix' => $prefix, 'marca' => $marca, 'producto' => $producto, 'empresa' => $empresa, 'numt_mascara' => $numt_mascara), true);
		//INSTANCIA DE SIDERBAR
		$sidebarlogin = $this->parser->parse('dashboard/widget-account', array('sidebarActive' => false), true);

		//DATA QUE SE PASA AL LAYOUT EN GENERAL
		//ACA SE INSTANCIA EL HEADER FOOTER CONTENT Y SIDERBAR
		$data = array('header' => $header, 'content' => $content, 'footer' => $footer, 'sidebar' => $sidebarlogin);

		$this->parser->parse('layouts/layout-b', $data);
	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsDetail() {
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

		$this->load->model('detail_model', 'detail');

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
		$tarjeta = $dataRequest->tarjeta;
		$_POST['card'] = $tarjeta;
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('detail-card');
		unset($_POST);

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));

			$response = json_encode($this->cryptography->encrypt(['rc'=> -9999]));
		} else {
			$response = $this->detail->detail_load($tarjeta);
		}

		$this->output->set_content_type('application/json')->set_output($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsMovimientos(){
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

		$this->load->model('detail_model', 'detail');
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
		$tarjeta = $dataRequest->tarjeta;
		$mes = $dataRequest->mes !== '' ? sprintf("%02d", $dataRequest->mes) : $dataRequest->mes;
		$anio = $dataRequest->anio;

		$_POST['card'] = $tarjeta;
		$_POST['month'] = $mes;
		$_POST['year'] = $anio;
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('movements');
		unset($_POST);

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));

			$response = json_encode($this->cryptography->encrypt(['rc'=> -9999]));
		} else {
			$response = $this->detail->movimientos_load($tarjeta, $mes, $anio);
		}

		$this->output->set_content_type('application/json')->set_output($response);

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsExportar(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('detail_model', 'detail');
		$tarjeta = $this->input->post('tarjeta');
		$mes = $this->input->post('mes') !== '' ? sprintf("%02d", $this->input->post('mes')) : $this->input->post('mes');
		$anio = $this->input->post('anio');
		$idOperation = $this->input->post('idOperation');

		log_message('DEBUG', 'NOVO DATA TO VALIDATE CallWsExportar: '.json_encode($_POST));
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('CallWsExportar');

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));
			redirect(base_url('dashboard'), 'location');
			exi();
		}

		$response = $this->detail->exportar($tarjeta, $mes, $anio, $idOperation);
		$response = json_decode($response);
		$file_ext = "pdf";
		$file_bytes;
		if($idOperation != 46){
			$file_bytes = $response->archivo;
		}else{
			$file = json_decode($response->bean);
			$file_bytes = $file->archivo;
			$file_ext = $file->formatoArchivo;
		}

		np_hoplite_byteArrayToFile($file_bytes, $file_ext, 'Movimientos');

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function CallWsGastos(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTIRIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('detail_model', 'detail');

	}

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	public function inTransit(){

		// VERIFICA SI LA SESION ESTA ACTIVA
		$verificLogin = np_hoplite_verificLogin();
		// VERIFICA QUE ARCHIVO DE CONFIGURACION UTILIZARA, SEGUN EL PAIS
		np_hoplite_countryCheck($this->session->userdata('pais'));
		// CARGO EL ARCHIVO DE LENGUAJE
		$this->lang->load('format');

		$this->load->model('detail_model', 'detail');

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
		$idPrograma = $dataRequest->idPrograma;
		$tarjeta = $dataRequest->tarjeta;

		$data = (object) [
			'idPrograma' => $idPrograma,
			'tarjeta' => $tarjeta
		];

		$_POST['idPrograma'] = $idPrograma;
		$_POST['tarjeta'] = $tarjeta;
		$this->form_validation->set_error_delimiters('', '---');
		$result = $this->form_validation->run('inTransit');
		unset($_POST);

		if(!$result){
			log_message('DEBUG', 'NOVO VALIDATION ERRORS: '.json_encode(validation_errors()));

			$response = json_encode($this->cryptography->encrypt(['rc'=> -9999]));
		} else {
			$response = $this->detail->WSinTransit($data);
		}

		$this->output->set_content_type('application/json')->set_output($response);

	}
}
