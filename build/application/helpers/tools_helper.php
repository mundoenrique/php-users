<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
if ( ! function_exists('np_hoplite_log'))
{
	/**
	 * [np_hoplite_log description]
	 * @param  [type] $username
	 * @param  [type] $canal
	 * @param  [type] $modulo
	 * @param  [type] $function
	 * @param  [type] $operacion
	 * @return [type]
	 */
	function np_hoplite_log($sessionId,$username,$canal,$modulo,$function,$operacion)
	{
		$CI =& get_instance();

		$logAcceso = array(
			"sessionId"=> $sessionId,
			"userName" => $username,
			"canal" => $canal,
			"modulo"=>$modulo,
			"function"=>$function,
			"operacion"=>$operacion,
			"RC"=>0,
			"IP"=>$CI->input->ip_address(),
			"dttimesstamp"=>date("m/d/Y H:i"),
			"lenguaje"=>"ES"
			);
	    return $logAcceso;
	}
}

if ( ! function_exists('np_hoplite_countryCheck'))
{
/**
 * [np_hoplite_countryCheck description]
 * @param  [type] $countryISO [description]
 * @return [type]             [description]
 */
	function np_hoplite_countryCheck($countryISO)
	{
		$CI =& get_instance();

		$iso = strtolower($countryISO);
		if (strtolower($iso) !== '') {
			$CI->config->load('config-' . $iso);
		}
	}
}

if ( ! function_exists('np_hoplite_byteArrayToFile'))
{
/**
 * [np_hoplite_byteArrayToFile description]
 * @param  [type] $bytes [description]
 * @return [type]        [description]
 */
	function np_hoplite_byteArrayToFile($bytes, $typeFile, $filename)
	{
		$CI =& get_instance();

		switch ($typeFile) {
 			case 'pdf':
 				header('Content-type: application/pdf');
				header('Content-Disposition: attachment; filename='.$filename.'.pdf');
				header('Pragma: no-cache');
				header('Expires: 0');
 				break;
 			case 'xls':
 				header('Content-type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename='.$filename.'.xls');
				header('Pragma: no-cache');
				header('Expires: 0');
 				break;
 			default:
 				break;
 		}
		foreach ($bytes as $chr) {
			echo chr($chr);
		}
	}
}

if ( ! function_exists('np_hoplite_jsontoiconsector'))
{
/**
 * [np_hoplite_jsontoiconsector description]
 * @param  [type] $bytes    [description]
 * @param  [type] $typeFile [description]
 * @param  [type] $filename [description]
 * @return [type]           [description]
 */
	function np_hoplite_jsontoiconsector($nroIcon)
	{
		$string = file_get_contents("/opt/httpd-2.4.4/vhost/online/application/eol/uploads/sector.json");
		$json_a=json_decode($string);
		$icon = $json_a->pe->{$nroIcon};

		return $icon;
	}
}


if ( ! function_exists('np_hoplite_existeLink'))
{
/**
 * [np_hoplite_existeLink description]
 * @param  [type] $menuP    [description]
 * @param  [type] $link [description]
 * @return [type]           [description]
 */
	function np_hoplite_existeLink($menuP, $link)
	{

		$arrayMenu = unserialize($menuP);
		$modulos = "";

		if($arrayMenu!=""){

			foreach ($arrayMenu as $value) {
				foreach ($value->modulos as $modulo) {
					$modulos.= strtolower($modulo->idModulo).",";
				}
			}
			return strrpos($modulos, strtolower($link));

		}else{
			return false;
		}

	}
}


if ( ! function_exists('np_hoplite_modFunciones'))
{
/**
 * [np_hoplite_modFunciones description]
 * @param  [type] $menuP    [description]
 * @return [type]           [description]
 */
	function np_hoplite_modFunciones($menuP)
	{

		$arrayMenu = unserialize($menuP);
		$funciones = "";

		if($arrayMenu!=""){

			foreach ($arrayMenu as $value) {
				foreach ($value->modulos as $modulo) {
					foreach ($modulo->funciones as $func) {
						$funciones.= strtolower($func->accodfuncion).",";
					}
				}
			}

			return explode(',', strtolower($funciones));

		}else{
			return false;
		}

	}

	function np_hoplite_verificLogin()
	{

		$CI =& get_instance();

		if(!($CI->session->userdata('logged_in'))){
			$append = '';
			$skin = $CI->input->cookie($CI->config->item('cookie_prefix') . 'skin');
			if ($skin !== false && $skin !== 'default'){
				$append = '/' . $skin . '/home';
			}

			redirect($CI->config->item('base_url') . $append);
		}

	}

	function np_hoplite_verificSession()
	{

		$CI =& get_instance();

		if($CI->session->userdata('logged_in') === true){
			$append = '/dashboard';

			redirect($CI->config->item('base_url') . $append);
		}

	}
}




// ------------------------------------------------------------------------
if ( ! function_exists('np_hoplite_decimals'))
{
	//AFILIACIÓN DE NÚMERO
	/**
	 * @access public
	 * @params: $number
	 * @info: Función para agregar decimales a valores según país
	 * @autor: Alexander Cuestas
	 * @date:  17/03/2018
	 */
	function np_hoplite_decimals($number,$pais)
	{
		if(($pais ==='Pe') || ($pais ==='Usd')) {
      $result = number_format($number, 2, '.', ',');
    } else if (($pais === 'Ve') || ($pais ==='Co')) {
      $result = number_format($number, 2, ',', '.');
    }
	  return $result;
	}
}
