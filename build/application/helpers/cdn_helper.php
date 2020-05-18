<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
		return $CI->config->item('asset_url');
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

        $url_cdn = $CI->config->item('asset_url');
        $path_cdn = $CI->config->item('asset_path');

        $filepath = $path_cdn . 'js/default/' . $filename;
        $fileurl = $url_cdn . 'js/default/' . $filename;
        $version = '';
        if (file_exists($filepath)) {
					$version = '?v=' . date('Ymd-U', filemtime($filepath));
				}

        $js = '<script src="' . $fileurl . $version . '" type="text/javascript"></script>' . "\n";
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

        $url_cdn = $CI->config->item('asset_url');
        $path_cdn = $CI->config->item('asset_path');
        $skin = $CI->input->cookie('cpo_skin');
        $skin_folder = $skin . '/';
        $filepath = $path_cdn . 'css/' . $skin_folder . $filename;
        $fileurl = $url_cdn . 'css/' . $skin_folder .  $filename;
        $version = '';
        if (file_exists($filepath)) {
					$version = '?v=' . date('Ymd-U', filemtime($filepath));
				}

        $css = '<link href="' . $fileurl . $version .  '" media="' . $media . '" rel="stylesheet" type="text/css" />' . "\n";
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
	function insert_image_cdn($filename = 'default.png', $dash = FALSE)
	{
		$CI =& get_instance();

		$url_cdn = $CI->config->item('asset_url');
		$cdnPath = $CI->config->item('asset_path');
		$country = $CI->config->item('country');
		$filename = $filename.'.png';
		$filepath = $cdnPath.'img/products/'.$country.'/'.$filename;
		$version = '';
		log_message('INFO', '----------------'.json_encode(file_exists($filepath)));
		if (!file_exists($filepath)) {
			$filename = 'default.png';
			$filepath = $cdnPath.'img/products/'.$country.'/'.$filename;
		}
		if (file_exists($filepath)) {
			$version = '?v='.date('Ymd-U', filemtime($filepath));
		}
		$dash = $dash ? 'class="'.$dash.'" id="cardImage"' : '';
		$img='<img src="'.$url_cdn.'img/products/'.$country.'/'.$filename.$version.'"  width="200" height="130" alt="" '.$dash.'>';
		return $img;
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

		$url_cdn = $CI->config->item('asset_url');
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
		$url_cdn = $CI->config->item('asset_url');
 		$filename = "diesession.js";
		$full_url = $url_cdn . 'js/' . $filename;

		$js = '<script src="' . $full_url . '"></script>' . "\n";
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
					log_message("info","ruta".$cdn."img/products/".$pais."/".$imagen.".png");
					if(file_exists($cdn."/img/products/".$pais."/".$imagen.".png")){
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

	function stripAccents($string){
		return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûü',
	'aaaaaceeeeiiiinooooouuuu');
	}
}

if ( !function_exists('insertFile'))
{
	function insertFile($fileName, $folder = 'img/')
	{
		$CI =& get_instance();
		$url_cdn = $CI->config->item('asset_url');
		$path_cdn = $CI->config->item('asset_path');

		$filepath = $path_cdn . $folder . $fileName;
		echo $fileurl = $url_cdn . $folder . $fileName;
		$version = '';
		if (file_exists($filepath)) {
			$version = '?v=' . date('Ymd-U', filemtime($filepath));
		}
	}
}
