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
			"request" => ["key", "password"]
		];
	}
}

if ( ! function_exists('getContractApi_generateRequest'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_generateRequest()
	{
		return [
			"request" => ["key", "password"]
		];
	}
}

if ( ! function_exists('getContractApi_uploadFile'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_uploadFile()
	{
		return [
			"request" => ["key", "anverso", "reverso", "client", "type_document", "nro_document", "user_name"]
		];
	}
}

if ( ! function_exists('getContractApi_keyForm'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_keyForm()
	{
		return [
			"request" => ["salt"]
		];
	}
}

if ( ! function_exists('getContractApi_requestFiles'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_requestFiles()
	{
		return [
			"request" => ["files", "key"]
		];
	}
}

if ( ! function_exists('getContractApi_eraseFiles'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_eraseFiles()
	{
		return [
			"request" => ["files", "key"]
		];
	}
}
