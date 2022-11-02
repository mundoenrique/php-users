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

		$this->CI =& get_instance();
		$this->namePropRequest = "";
		$this->structureValidRequest = "";
		$this->nameApi = "";
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
		$this->nameApi = $nameApi;
		$decrypParams = [];
		$typeHeader = $this->CI->input->get_request_header('Content-Type', TRUE);
		$typeResource = preg_split('/;/i', $typeHeader)[0];
		log_message('DEBUG', '['.$this->nameApi.'] readHeader type resource: ' . json_encode($typeResource));

		$objRequest = json_decode($this->CI->input->raw_input_stream);
		if (property_exists($objRequest, 'request')) {
			if (is_string($objRequest->request)) {
				$sizeObject = strval(round(strlen($objRequest->request)/1000,2));
				log_message('DEBUG', '['.$this->nameApi.'] size object received ('.$sizeObject.'KB)');
			}
			log_message('DEBUG', '['.$this->nameApi.'] detail object received: ' . json_encode($this->shortValues($objRequest)));

			$decrypParams = $this->getPropertiesRequest($objRequest, $nameApi);
		}

		return count($decrypParams) > 0 ? $this->getContentRequest($decrypParams) : [];
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

		log_message('DEBUG', '['.$this->nameApi.'] setContract for ['.$functionGetContract.'] structure valid: ' . json_encode($this->structureValidRequest));
	}

	/**
	 * @info Método para extraer las propiedades de la petición API
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	private function getPropertiesRequest($objRequest, $nameApi)
	{
		log_message('INFO', 'Novo Tool_Api: getPropertiesRequest Method Initialized');

		$decrypParams = [];
		if (!is_null($objRequest) || !is_null($nameApi)) {
			$this->setContract($nameApi);

			$decrypParams[$this->namePropRequest] = $objRequest->{$this->namePropRequest};
			if (!is_null($objRequest) && property_exists($objRequest, $this->namePropRequest) ) {
				if (is_string($objRequest->{$this->namePropRequest})) {
					$decrypParams[$this->namePropRequest] = json_decode(
						$this->CI->encrypt_decrypt->aesCryptography($objRequest->{$this->namePropRequest}, FALSE)
					);
				}
			}
		}
		log_message('DEBUG', '['.$this->nameApi.'] getPropertiesRequest object decrypt: ' . json_encode($this->shortValues($decrypParams, $this->namePropRequest)));

		return $decrypParams;
	}

	/**
	 * @info Acorta valores extensos para mostrar en log
	 * @author Pedro Torres
	 * @date Septiembre 07, 2021
	 */
	private function shortValues ($objectProcess, $property = NULL)
	{
		log_message('INFO', 'Novo Tool_Api: shortValues Method Initialized');

		$infoDecryptParams = [];
		$arrayToProcess = (array) $objectProcess;
		foreach ($arrayToProcess as $param => $value) {
			if (is_string($value)) {
				$value = $this->prepareForDisplay($param, $value);
				$infoDecryptParams[$param] = strlen($value) < 150 ? $value : substr($value,0,147).'...';
			}else{
				foreach ($value as $property => $value) {
					$value = $this->prepareForDisplay($property, $value);
					$infoDecryptParams[$property] = strlen($value) < 150 ? $value : substr($value,0,147).'...';
				}
			}
		}
		return $infoDecryptParams;
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
					$contentRequest[$property] = $this->clearProperty($decrypParams[$this->namePropRequest]->{$property});
				}
			}
			log_message('DEBUG', '['.$this->nameApi.'] properties values cleaned: ' . json_encode($this->shortValues($contentRequest), JSON_UNESCAPED_SLASHES));
		}else{
			log_message('DEBUG', '['.$this->nameApi.'] ERROR: getContentRequest not content file recieved.');
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

	/**
	 * @info Coloca una máscara a las llaves de arreglo marcadas como segura,
	 *  desde el archivo de configuración correspondiente.
	 * @author Pedro Torres
	 * @date Octubre 1, 2020
	 */
	private function prepareForDisplay($property = NULL,$value = '')
	{
		return in_array($property, lang('CONF_FILTER_ATTRIBUTES_LOG')) ? "[Protected => ******** ]" : $value;
	}
}
