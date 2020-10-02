<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para gestionar los procesos con API
 * @author Pedro Torres
 * @date Septiembre 18th, 2020
 */
class Tool_Api {

	public function __construct()
	{
		log_message('INFO', 'NOVO Tool_Api Library Class Initialized');

		$this->CI = &get_instance();
		$this->namePropRequest = "";
		$this->structureValidRequest = "";
	}
	/**
	 * @info Extrae el contenido del API
	 * @author Pedro Torres
	 * @date Oct 1th, 2020
	 */
	public function getContentAPI($objRequest = [], $nameApi = '')
	{
		log_message('INFO', 'Novo Tool_Api: getContentAPI Method Initialized');

		$decrypParams = $this->getPropertiesRequest($objRequest, $nameApi);

		return count($decrypParams) > 0 ? $this->getContentRequest($decrypParams): [];
	}
	/**
	 * @info Método que establece el contrato para el API solicitada
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	private function setContract($nameApi)
	{
		$this->CI->load->helper('contracts_api');

		$functionGetContract = "getContractApi_" . $nameApi;
		if (function_exists($functionGetContract)){
			$this->structureValidRequest = $functionGetContract();
			$this->namePropRequest = array_keys($this->structureValidRequest)[0];
		}
	}
	/**
	 * @info Método para extraer las propiedades de la petición API
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	private function getPropertiesRequest($objRequest, $nameApi)
	{
		log_message('INFO', 'Novo Tool_Api: getPropertiesRequest Method Initialized');

		$request = [];
		$decrypParams = [];

		if (!is_null($objRequest) || !is_null($nameApi)) {
			$this->setContract($nameApi);

			if (!is_null($objRequest) && property_exists($objRequest, $this->namePropRequest) ) {
				$decrypParams[$this->namePropRequest] = $objRequest->{$this->namePropRequest};

				if (is_string($objRequest->{$this->namePropRequest})) {
					$decrypParams[$this->namePropRequest] = json_decode(
						$this->CI->encrypt_connect->cryptography($objRequest->{$this->namePropRequest}, FALSE)
					);
				}
			}
		}

		return $decrypParams;
	}
	/**
	 * @info Método para extraer el contenido por cada propiedad de la petición
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	private function getContentRequest($decrypParams = NULL)
	{
		log_message('INFO', 'Novo Tool_Api: getContentRequest Method Initialized');

		$contentRequest = [];

		if (!is_null($decrypParams)) {
			$paramsValidsBodyRequest = $this->structureValidRequest[$this->namePropRequest];

			foreach ($paramsValidsBodyRequest as $valor) {

				$contentRequest[$valor] = property_exists($decrypParams[$this->namePropRequest], $valor) ?
				$this->CI->security->xss_clean(strip_tags($decrypParams[$this->namePropRequest]->{$valor})) :
				NULL;
			}
			log_message('DEBUG', "Novo Tool_Api: getContentRequest " . $this->prepareArrayForDisplay($contentRequest, ['password']));
		}

		return $contentRequest;
	}
	/**
	 * @info Genera un array con los datos a mostrarse en el log,
	 * si se indica cual no puede ser visible aplica un hash al mismo
	 * @author Pedro Torres
	 * @date Oct 1th, 2020
	 */
	private function prepareArrayForDisplay($arrayToWork = [], $protectedValues = [])
	{
		log_message('INFO', 'Novo Tool_Api: prepareArrayForDisplay Method Initialized');

		$arrayForDisplay = [];

		foreach ($arrayToWork as $key => $valor) {

			$arrayForDisplay[$key] = in_array($key, $protectedValues) ?
			"[Protected => ******** ]":
			$valor;
		}

		return json_encode($arrayForDisplay);
	}
	/**
	 * @info Método para armar respuesta a petición API en caso de no cumplir las validaciones
	 * @author Pedro A. Torres F.
	 * @date Oct 2, 2020
	 */
	public function setResponseNotValid($reason = '')
	{
		log_message('INFO', 'NOVO Tool_Api: setResponseNotValid method initialized');

		$this->responseDefect = new stdClass();
		$this->responseDefect->code = 400;
		$this->responseDefect->data = '';

		return $this->responseDefect;
	}
}
