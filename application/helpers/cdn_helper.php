<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------
if ( ! function_exists('base_cdn'))
{
	/**
	 * [base_cdn description]
	 * @param  string $uri
	 * @return [type]
	 */
	function base_cdn($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->item('base_url_cdn');
	}
}

if ( ! function_exists('insert_js_cdn'))
{
    /**
     * [insert_js_cdn description]
     * @param  string $filename
     * @return [type]
     */
    function insert_js_cdn($filename = '')
    {
        $CI =& get_instance();
        $url_cdn = $CI->config->item('base_url_cdn');
        $path_cdn = $CI->config->item('base_path_cdn');
        if ((ENVIRONMENT === 'testing' || ENVIRONMENT === 'production') && strpos($filename, '.min.js') === false)
            $filename = str_replace('.js', '.min.js', $filename);

        $filepath = $path_cdn . 'js/' . $filename;
        $fileurl = $url_cdn . 'js/' . $filename;
        $version = '';
        if (file_exists($filepath))
            $version = '?v=' . date('Ymd-B', filemtime($filepath));

        $js='<script src="' . $fileurl . $version . '" type="text/javascript"></script>';
        return $js;
    }
}

if ( ! function_exists('insert_css_cdn'))
{
    /**
     * [insert_css_cdn description]
     * @param  string $filename
     * @param  string $media
     * @return [type]
     */
    function insert_css_cdn($filename = '', $media = 'screen')
    {
        $CI =& get_instance();
        $url_cdn = $CI->config->item('base_url_cdn');
        $path_cdn = $CI->config->item('base_path_cdn');
        $skin = $CI->input->cookie('cpo_skin');
        $skin_folder = '';
        if ($skin === 'latodo') $skin_folder = $skin . '/';
        if ((ENVIRONMENT === 'testing' || ENVIRONMENT === 'production') && strpos($filename, '.min.js') === false)
            $filename = str_replace('.css', '.min.css', $filename);

        $filepath = $path_cdn . 'css/' . $filename;
        $fileurl = $url_cdn . 'css/' . $skin_folder .  $filename;
        $version = '';
        if (file_exists($filepath))
            $version = '?v=' . date('Ymd-B', filemtime($filepath));

        $css='<link href="' . $fileurl . $version .  '" media="' . $media . '" rel="stylesheet" type="text/css" />';
        return $css;
    }
}

if ( ! function_exists('insert_image_cdn'))
{
	/**
	 * [insert_image_cdn description]
	 * @param  string $filename [description]
	 * @return [type]           [description]
	 */
	function insert_image_cdn($filename = '')
	{
		$CI =& get_instance();
		$url_cdn = $CI->config->item('base_url_cdn');
		$full_url = $url_cdn . 'media/img/' . $filename;

		$css='<img src="' . $full_url . '" />';
		return $css;
	}
}

if ( ! function_exists('get_cdn'))
{
	/**
	 * [get_cdn description]
	 * @return [type]           [description]
	 */
	function get_cdn()
	{
		$CI =& get_instance();
		$url_cdn = $CI->config->item('base_url_cdn');
		return $url_cdn;
	}
}

// session die function

if ( ! function_exists('insert_js_diesession'))
{
	/**
	 * [insert_js_cdn description]
	 * @param  string $filename
	 * @return [type]
	 */
	
	function insert_js_diesession()  // Function that call Die Session Function 
	{
		$CI =& get_instance();
		$url_cdn = $CI->config->item('base_url_cdn');
 		$filename = "diesession.js";
		$full_url = $url_cdn . 'js/' . $filename;
		$js = '<script src="' . $full_url . '"></script>';
		return $js;
	}
}





if ( ! function_exists('verify_img_ctaDestino'))
{
	/**
	 * [get_cdn description]
	 * @return [type]           [description]
	 */
	function verify_img_ctaDestino($json,$pais)
	{
		$json =json_decode($json);

		$cdn = str_replace("online", "cdn", $_SERVER["DOCUMENT_ROOT"]);
		//$cdn = $CI->config->item('base_url_cdn');
		//$pais=ucwords($this->session->userdata('pais'));
		log_message("info", "PAIS Cta Destino : ".$pais);
		if(property_exists($json,"cuentaDestinoPlata")){
			if ($json->cuentaDestinoPlata != 0) {
				foreach ($json->cuentaDestinoPlata as $key => $value) {
					$imagen1= stripAccents($value->nombre_producto);

					$imagen2 = strtolower(str_replace(" ", "-", $imagen1));
					$imagen = strtolower(str_replace("/", "-", $imagen2));

					log_message("info","IMAGEN1".$imagen1);
					log_message("info","IMAGEN".$imagen);
					log_message("info", "PAIS Cta Destino 11111111: ".$pais);
					log_message("info","ruta".$cdn."personas/img/products/".$pais."/".$imagen.".png");
					if(file_exists($cdn."/personas/img/products/".$pais."/".$imagen.".png")){
						$value->imagen = $pais."/".$imagen;
					}else{
						$value->imagen = "default/card-".rand(1,5);
					}
				}
			}
		}
		if(property_exists($json,"tarjetaDestinoTercero")){
			if($json->tarjetaDestinoTercero != 0){
				foreach ($json->tarjetaDestinoTercero as $key => $value) {

					$value->imagen = "default/card-".rand(1,5);
				}
			}
		}

		if(property_exists($json,"cuentaDestinoTercero")){
			$ruta=  "default/card-".rand(1,5);
			log_message("info","RUTA DESTINO TERCERO".$ruta);
			if($json->cuentaDestinoTercero != 0){
				foreach ($json->cuentaDestinoTercero as $key => $value) {
						$value->imagen = "default/bank-".rand(1,5);
				}
			}
		}

		return json_encode($json);
	}


// Function stripAccents($String){
// 	return strtr($String,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ',
// 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

    // $String = ereg_replace("[äáàâãª]","a",$String);

    // $String = ereg_replace("[ÁÀÂÃÄ]","A",$String);

    // $String = ereg_replace("[ÍÌÎÏ]","I",$String);

    // $String = ereg_replace("[íìîï]","i",$String);

    // $String = ereg_replace("[éèêë]","e",$String);

    // $String = ereg_replace("[ÉÈÊË]","E",$String);

    // $String = ereg_replace("[óòôõöº]","o",$String);

    // $String = ereg_replace("[ÓÒÔÕÖ]","O",$String);

    // $String = ereg_replace("[úùûü]","u",$String);

    // $String = ereg_replace("[ÚÙÛÜ]","U",$String);

    // $String = ereg_replace("[^´`¨~]","",$String);

    // $String = str_replace("ç","c",$String);

    // $String = str_replace("Ç","C",$String);

    // $String = str_replace("ñ","n",$String);

    // $String = str_replace("Ñ","N",$String);

    // $String = str_replace("Ý","Y",$String);

    // $String = str_replace("ý","y",$String);

    // return $String;

//}
// function normaliza($cadena){
// 	$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞ
// 	ßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
// 	$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
// 	bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
// 	$cadena = utf8_decode($cadena);
// 	$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
// 	$cadena = strtolower($cadena);
// 	return utf8_encode($cadena);
// }

function stripAccents($string){
	return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûü',
'aaaaaceeeeiiiinooooouuuu');
}

}
