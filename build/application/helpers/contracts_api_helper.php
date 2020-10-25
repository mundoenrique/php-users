<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
if (!function_exists('getContractApi_generateHash'))
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

if (!function_exists('getContractApi_generateRequest'))
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

if (!function_exists(','))
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

if (!function_exists('getContractApi_dataErase'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_dataErase()
	{
		return [
			"request" => ["key", "client", "files", "user_name"],
		];
	}
}

if (!function_exists('getContractApi_dataUpload'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_dataUpload()
	{
		return [
			"request" => ["key", "client", "user_name", "type_document", "nro_document"],
		];
	}
}

if (!function_exists('getContractApi_uploadFile'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_uploadFile()
	{
		return [
			"request" => ["key", "anverso", "reverso", "data"]
		];
	}
}

if (!function_exists('getContractApi_eraseFiles'))
{
	/**
	 * Retorna el contrato de aceptacion de petición a Api
	 * @return array con estructura de API
	 */
	function getContractApi_eraseFiles()
	{
		return [
			"request" => ["data", "key"]
		];
	}
}
