<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria peticiones get de la aplicación
 * @author J. Enrique Peñaloza Piñero
 *
 */

class Request_Data {
	private $CI;
	private $BDB_Model;

	public function __construct()
	{
		log_message('INFO', 'NOVO Request Library Class Initialized');
		$this->CI = &get_instance();
	}
	/**
	 * @info Método para obtener la lista de empresas asociadas al usuario
	 * @author: J. Enrique Peñaloza P.
	 */
	public function getEnterprises($dataRequest)
	{
		$this->BDB_Model = new BDB_Model();
		$this->BDB_Model->className = "";
	}
}
