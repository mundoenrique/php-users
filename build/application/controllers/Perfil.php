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
        $FooterCustomInsertJS = array('jquery-3.4.0.min.js', 'jquery-ui-1.12.1.min.js', 'jquery.isotope.min.js', 'perfil.js' , 'jquery-md5.js', 'jquery.balloon.min.js', 'jquery.validate.min.js', 'kendo.dataviz.min.js', 'additional-methods.min.js','cypher/aes.min.js', 'cypher/aes-json-format.min.js');
        //INSTANCIA DEL FOOTER
        $footer = $this->parser->parse('layouts/layout-footer', array('menuFooterActive' => true, 'menuFooter' => $menuFooter, 'FooterCustomInsertJSActive' => true, 'FooterCustomInsertJS' => $FooterCustomInsertJS, 'FooterCustomJSActive' => false), true);
        //INSTANCIA DE PARTE DE CUERPO
        $content = $this->parser->parse('perfil/perfil-content', array('data' => serialize(json_decode($this->perfil->perfil_load($userName)))), true);
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

    public function CallWsPerfil(){

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

        // VERIFICA SI LA SESION ESTA ACTIVA
        np_hoplite_verificLogin();
        // VERIFICA QUE ARCHIVO DE CONFIGURACION UTILIZARA, SEGUN EL PAIS
        np_hoplite_countryCheck($this->session->userdata('pais'));
        // CARGO EL ARCHIVO DE LENGUAJE
        $this->lang->load('format');


        $this->load->model('perfil_model', 'actualizar');



        $userName = $this->input->post('userName'); // /1

        $primerNombre = $this->input->post('primer_nombre'); // /2

        $segundoNombre = $this->input->post('segundo_nombre'); // /3

        $primerApellido = $this->input->post('primer_apellido'); // /4

        $segundoApellido = $this->input->post('segundo_apellido'); // /5

        $lugarNacimiento = $this->input->post('lugar_nac');// /6

        $fechaNacimiento = $this->input->post('fecha_nacimiento'); // /7

        $sexo = $this->input->post('gender'); // /8

        $edocivil = $this->input->post('edocivil'); // /9

        $nacionalidad = $this->input->post('nacionalidad'); // /10

        $profesion = $this->input->post('profesion'); // /11

        $tipoDireccion = $this->input->post('tipo_direccion'); // /12

        $codepostal = $this->input->post('codepostal'); // /13

        $paisResidencia = $this->input->post('paisResidencia'); // /14

        $departamento_residencia = $this->input->post('departamento_residencia'); // /15

        $provincia_residencia = $this->input->post('provincia_residencia'); // /16

        $distrito_residencia = $this->input->post('distrito_residencia'); // /17

        $direccion = $this->input->post('direccion'); // /18

        $telefono_hab = $this->input->post('telefono_hab'); // /19

        $telefono = $this->input->post('telefono'); // /20

        $otro_telefono_tipo = $this->input->post('otro_telefono_tipo'); // /21

        $otro_telefono_num = $this->input->post('otro_telefono_num'); // /22

        $email = $this->input->post('email'); // /23

        $ruc_cto_labora = $this->input->post('ruc_cto_labora'); // /24

        $centro_laboral = $this->input->post('centro_laboral'); // /25

        $situacion_laboral = $this->input->post('situacion_laboral'); // /26

        $antiguedad_laboral_value = $this->input->post('antiguedad_laboral_value'); // /27

        $profesion_labora = $this->input->post('profesion_labora'); // /28

        $cargo = $this->input->post('cargo'); // /29

        $ingreso_promedio = $this->input->post('ingreso_promedio'); // /30

        $cargo_public = $this->input->post('cargo_public'); // /31

        $cargo_publico = $this->input->post('cargo_publico'); // /32

        $institucion_publica = $this->input->post('institucion_publica'); // /33

        $sujeto_obligado = $this->input->post('sujeto_obligado'); // /34

        $notEmail = $this->input->post('notEmail'); // /35

        $notSms = $this->input->post('notSms'); // /36

        $dtfechorcrea_usu = $this->input->post('dtfechorcrea_usu'); // /37

        $id_ext_per= $this->input->post('id_ext_per'); // /38

        $tipo_profesion= $this->input->post('tipo_profesion'); // /39

        $tipo_identificacion= $this->input->post('tipo_identificacion'); // /40

        $tipo_id_ext_per=$this->input->post('tipo'); // /41

        $aplicaPerfil=$this->input->post('aplica'); // /42

        $notarjeta=$this->input->post('notarjeta'); // /43

        $acCodCiudad=$this->input->post('acCodCiudad');

        $acCodEstado=$this->input->post('acCodEstado');

        $acCodPais=$this->input->post('acCodPais');

        $acTipo=$this->input->post('acTipo');

        $acZonaPostal=$this->input->post('acZonaPostal');

        $disponeClaveSMS=$this->input->post('disponeClaveSMS');

        $codigopais=$this->input->post('codigopais');

        $verifyDigit=$this->input->post('verifyDigit');

        $proteccion=$this->input->post('proteccion');

				$contrato=$this->input->post('contrato');

        $tyc=$this->input->post('tyc');


        log_message("info", "COMPROBAR ACTUALIZAR PERFIL===> ".$userName);



        $this->output->set_content_type('application/json')->set_output($this->actualizar->perfil_update($userName, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $lugarNacimiento, $fechaNacimiento, $sexo, $edocivil, $nacionalidad, $profesion, $tipoDireccion,
            $codepostal, $paisResidencia, $departamento_residencia, $provincia_residencia, $distrito_residencia, $direccion, $telefono_hab, $telefono, $otro_telefono_tipo, $otro_telefono_num, $email, $ruc_cto_labora, $centro_laboral, $situacion_laboral, $antiguedad_laboral_value,
            $profesion_labora, $cargo, $ingreso_promedio, $cargo_public, $cargo_publico, $institucion_publica, $sujeto_obligado, $notEmail, $notSms, $dtfechorcrea_usu, $id_ext_per, $tipo_profesion, $tipo_identificacion, $tipo_id_ext_per, $aplicaPerfil,
            $notarjeta, $acCodCiudad, $acCodEstado, $acCodPais, $acTipo, $acZonaPostal, $disponeClaveSMS, $codigopais, $verifyDigit, $proteccion, $contrato, $tyc));

    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsLista(){

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

        $pais		= $this->input->post('pais');
        $email		= $this->input->post('email');
        $username	= $this->input->post('username');


        $this->output->set_content_type('application/json')->set_output($this->verificarEmail->verificar_email($pais, $email, $username));

    }
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------

    public function CallWsListaEstado(){

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

    public function CallWsListaCiudad(){

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

    public function CallWsListaProfesiones(){

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
