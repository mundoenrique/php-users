<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
if ( ! function_exists('getContractApi_generateHash'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_generateHash()
	{
		return [
			"generateHash" => [
				"request" => ["key", "password"]
			]
		];
	}
}
