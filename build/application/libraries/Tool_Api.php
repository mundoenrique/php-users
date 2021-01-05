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
	 * @info Lee la cabecera de la petición
	 * @author Pedro Torres
	 * @date Oct 5th, 2021
	 */
	public function readHeader($nameApi)
	{
		log_message('INFO', 'Novo Tool_Api: readHeader Method Initialized');

		$objRequest = new stdClass();
		$typeHeader = $this->CI->input->get_request_header('Content-Type', TRUE);
		$typeResource = preg_split('/;/i', $typeHeader)[0];

		$objRequest = json_decode($this->CI->input->raw_input_stream);

		log_message('DEBUG', 'readHeader type resource: ' . json_encode($typeResource));
		return $this->getContentAPI($objRequest, $nameApi);
	}

	/**
	 * @info Extrae el contenido del API
	 * @author Pedro Torres
	 * @date Oct 1th, 2020
	 */
	public function getContentAPI($objRequest = [], $nameApi = '')
	{
		log_message('INFO', 'Novo Tool_Api: getContentAPI Method Initialized');
		$infoDecryptParams = [];
		foreach ($objRequest as $property => $value) {
			$infoDecryptParams[$property] = strlen($value) < 150 ? $value : substr($value,0,147).'...';
		}
		log_message('DEBUG', 'getContentAPI object received: ' . json_encode($infoDecryptParams));

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

		log_message('DEBUG', 'setContract for ['.$functionGetContract.'] structure valid: ' . json_encode($this->structureValidRequest));
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

			// TODO
			// Solo para generar datos en prueba
		  // $objRequest->request = $this->CI->tool_file->fakeDataUpload('mbueno');
			// $objRequest->request = $this->CI->tool_file->fakeDataErase('mrojas');

			if (!is_null($objRequest) && property_exists($objRequest, $this->namePropRequest) ) {
				$decrypParams[$this->namePropRequest] = $objRequest->{$this->namePropRequest};

				if (is_string($objRequest->{$this->namePropRequest})) {
					$decrypParams[$this->namePropRequest] = json_decode(
						$this->CI->encrypt_connect->cryptography($objRequest->{$this->namePropRequest}, FALSE)
					);
				}
			}
		}

		$infoDecryptParams = [];
		foreach ((array)$decrypParams['request'] as $property => $value) {
			$infoDecryptParams[$property] = strlen($value) < 150 ? $value : substr($value,0,147).'...';
		}
		log_message('DEBUG', 'getPropertiesRequest object decrypt: ' . json_encode($infoDecryptParams));

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

		if (!is_null($decrypParams[$this->namePropRequest])) {
			$paramsValidsBodyRequest = $this->structureValidRequest[$this->namePropRequest];

			foreach ($paramsValidsBodyRequest as $property) {
				$contentRequest[$property] = NULL;

				if (property_exists($decrypParams[$this->namePropRequest], $property)) {
					$value = $decrypParams[$this->namePropRequest]->{$property} ?? FALSE;

					if ($value) {
						$value = strlen($value) < 150 ? $value : substr($value,0,147).'...';
						$contentRequest[$property] = $this->clearProperty($decrypParams[$this->namePropRequest]->{$property});
					}
				}
				$value = $contentRequest[$property] == NULL ? 'Error: not valid...' : $value;

				log_message('DEBUG', 'getContentRequest get content for '.$property.': ' . $value);
			}
		}else{
			log_message('DEBUG', 'ERROR: getContentRequest not content file recieved.');
		}
		return $contentRequest;
	}

	/**
	 * @info Genera un array con los datos a mostrarse en el log,
	 * si se indica cual no puede ser visible aplica un hash al mismo
	 * @author Pedro Torres
	 * @date Oct 1th, 2020
	 */
	private function prepareArrayForDisplay($arrayToWork = [])
	{
		log_message('INFO', 'Novo Tool_Api: prepareArrayForDisplay Method Initialized');

		$arrayForDisplay = [];

		foreach ($arrayToWork as $key => $valor) {

			$arrayForDisplay[$key] = in_array($key, lang('CONF_FILTER_ATTRIBUTES_LOG')) ?
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
	public function setResponseNotValid()
	{
		log_message('INFO', 'NOVO Tool_Api: setResponseNotValid method initialized');

		$this->responseDefect = new stdClass();
		$this->responseDefect->code = 400;
		$this->responseDefect->data = '';

		return $this->responseDefect;
	}

	/**
	 * @info Método para securizar el contenido de los campos permitidos en la petición
	 * @author Pedro A. Torres F.
	 * @date Oct 16, 2020
	 * @param: $property ==> dato a securizar
	 */
	private function clearProperty ($property = null)
	{
		return is_string($property) && !strpos($property, 'base64') ?
			$this->CI->security->xss_clean(strip_tags($property)) :
			$property;
	}
}
