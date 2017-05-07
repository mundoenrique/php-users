<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter XML Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/xml_helper.html
 */

// ------------------------------------------------------------------------

if ( ! function_exists('np_hoplite_Encryption'))
{
	/**
	 * [np_Hoplite_Encryption description]
	 * @param  [type] $data
	 * @return [type]
	 */
	function np_Hoplite_Encryption($data, $keyId=1)
	{
		$CI =& get_instance();
		
		 $dataB = base64_encode($data);
		 while( (strlen($dataB)%8) != 0) {
                $dataB .= " ";
         }
         if($keyId == 1){
         	$cryptData = @mcrypt_encrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $dataB, MCRYPT_MODE_CBC,$iv);
         }else{
			$cryptData = @mcrypt_encrypt(MCRYPT_DES, $CI->config->item('keyNovo'), $dataB, MCRYPT_MODE_CBC,$iv);
         }
	    return base64_encode($cryptData);
	}
}

if ( ! function_exists('np_hoplite_Decrypt'))
{
	/**
	 * [np_Hoplite_Decrypt description]
	 * @param  [type] $cryptDataBase64
	 * @return [type]
	 */
	function np_Hoplite_Decrypt($cryptDataBase64, $keyId=1)
	{
		$CI =& get_instance();
		$a = base64_decode($cryptDataBase64);
		if($keyId == 1){
         	$descryptData = @mcrypt_decrypt(MCRYPT_DES, base64_decode($CI->session->userdata('keyId')), $a, MCRYPT_MODE_CBC);
         }else{
    		$descryptData = @mcrypt_decrypt(MCRYPT_DES, $CI->config->item('keyNovo'), $a, MCRYPT_MODE_CBC);
         }
    	$decryptData = trim($descryptData); 
    	return base64_decode($decryptData);
	}
}