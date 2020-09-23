<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Libreria para gestionar los procesos con API
 * @author Pedro Torres
 * @date Septiembre 18th, 2020
 */
class Tool_Api {
	private $CI;

	public function __construct()
	{
		log_message('INFO', 'NOVO Tool_Browser Library Class Initialized');

		$this->CI = &get_instance();
		$this->key_api = $this->CI->config->item('key_api');
		$this->structureValidRequest = "";
	}
	/**
	 * @info Método que establece el contrato para el API solicitada
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	private function setContract($nameApi = NULL)
	{
		if (!is_null($nameApi)) {
			$functionGetContract = "getContractApi_" . $nameApi;
			$this->structureValidRequest = $functionGetContract();
		}
	}

	/**
	 * @info Método para extraer las propiedades de la petición API
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	public function getPropertiesRequest($objRequest = NULL, $nameApi = NULL)
	{
		log_message('INFO', 'Novo Tool_Api: getPropertiesRequest Method Initialized');

		$request = [];
		$decrypParams = [];

		if (!is_null($objRequest) || !is_null($nameApi)) {

			$this->setContract($nameApi);

			$whiteListNamePropRequest = array_keys($this->structureValidRequest[$nameApi]);
			foreach ($whiteListNamePropRequest as $value) {

				if (property_exists ($objRequest, $value)) {
					$request[$value] = $this->CI->security->xss_clean(strip_tags($objRequest->{$value}));
					$decrypParams[$value] = $this->CI->encrypt_connect->cryptography($request[$value], FALSE);
				}
			}
		}
		log_message('INFO', "[ {$nameApi} ] Novo Tool_Api: getPropertiesRequest " . json_encode($decrypParams));

		return $decrypParams;
	}
	/**
	 * @info Método para extraer el contenido por cada propiedad de la petición
	 * @author Pedro Torres
	 * @date Septiembre 18th, 2020
	 */
	public function getContentRequest($decrypParams = NULL, $nameApi = NULL)
	{
		log_message('INFO', 'Novo Tool_Api: getContentRequest Method Initialized');

		$contentRequest = [];

		if (!is_null($nameApi) && !is_null($decrypParams)) {
			$whiteListNamePropRequest = array_keys($this->structureValidRequest[$nameApi]);
			foreach ($whiteListNamePropRequest as $valueProp) {

				$paramsBodyRequest = json_decode($decrypParams[$valueProp]);

				if (!is_null($paramsBodyRequest )) {
					$whiteListNameParamsBodyRequest = $this->structureValidRequest[$nameApi][$valueProp];

					foreach ($whiteListNameParamsBodyRequest as $valor) {
						$contentRequest[$valor] = property_exists ($paramsBodyRequest, $valor) ?
						$this->CI->security->xss_clean(strip_tags($paramsBodyRequest->{$valor})) :
						NULL;
					}
				}
			}
		}
		log_message('INFO', "[ {$nameApi} ] Novo Tool_Api: getContentRequest " . json_encode($contentRequest));

		return $contentRequest;
	}
}
