<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
if (!function_exists('construccion_menu'))
{
	/**
	 * [construccion_menu]
	 */

  function construccion_menu($pagina)
  {

	$items = json_decode(propiedades_menu());

		$menu = '<nav class="nav" style="margin-top: 6px"><ul class="nav">'."\n";

		foreach($items as $item)
		{
			$result=0;
			$acceso=$item->acceso;
			$menu_actual=$item->id;

			#SI EXISTE EL ACCESO ENTRO EN LA CONDICION
			if($acceso==true){

			$actual = ($item->pagina_actual == $pagina) ? "actual" : "";
			$hancor =  (is_array($item->submenu)) ? '<span aria-hidden="true" class="icon-chevron-down"></span>':'';

				#ARMANDO LOS MENU PADRES
				$menu .= '<li><a href="'.$item->link.'" rel="section" class="'.$actual.' hover" >'.$item->titulo.' '.$hancor.'</a>'."\n";

				if (is_array($item->submenu)){

				$submenu = '<ul class="border">';

					foreach($item->submenu as $sub){
						#ARMANDO LOS MENU HIJOS
						$submenu.='<li><a href="'.$sub->link2.'" class="hover2">'.$sub->titulo2.'</a></li>';

					}
				$submenu.= '</ul>';
				$menu=$menu.$submenu;
				}
			$menu=$menu.$menu2='</li>';

			}
		}
		$menu .= '</ul></nav>'."\n";
  return $menu;
  }
}


if (!function_exists('propiedades_menu'))
{

	function propiedades_menu(){

		$CI =& get_instance();

		$fullname = ucwords($CI->session->userdata('nombreCompleto'));
		$country = $CI->session->userdata('pais');
		$opciones=json_decode(opciones_menu($country));

		if (strlen($fullname) >= 15) {
			$fullname = substr($fullname, 0, 12) . '...';
		}

		if(!isset($opciones->dashboard) || $opciones->dashboard==false){
			$opciones->dashboard=0;
		}
		if(!isset($opciones->transfer) || $opciones->transfer==false){
			$opciones->transfer=0;
		}
		if(!isset($opciones->transfer_pe) || $opciones->transfer_pe==false){
			$opciones->transfer_pe=0;
		}
		if(!isset($opciones->transfer_usd) || $opciones->transfer_usd==false){
			$opciones->transfer_usd=0;
		}
		if(!isset($opciones->pago) || $opciones->pago==false){
			$opciones->pago=0;
		}
		if(!isset($opciones->pago_ve) || $opciones->pago_ve==false){
			$opciones->pago_ve=0;
		}
		if(!isset($opciones->reportes) || $opciones->reportes==false){
			$opciones->reportes=0;
		}
		if(!isset($opciones->service) || $opciones->service==false){
			$opciones->service=0;
		}
		if(!isset($opciones->perfil) || $opciones->perfil==false){
			$opciones->perfil=0;
		}

		$propiedades='[
			{
			"id":"dashboard",
			"acceso":'.$opciones->dashboard.',
			"pagina_actual":"dashboard",
			"titulo":"Vista consolidada",
			"link":"'.$CI->config->item('base_url').'/dashboard'.'",
			"submenu":""
			},
			{
			"id":"transfer",
			"acceso":'.$opciones->transfer.',
			"pagina_actual":"transfer",
			"titulo":"Transferencias",
			"link":"'.$CI->config->item('base_url').'/transferencia'.'",
			"submenu":[
				{
				"titulo2":"'.lang("MENU_P2P").'",
				"link2":"'.$CI->config->item('base_url').'/transferencia'.'"
				},
				{
				"titulo2":"Cuenta Bancaria",
				"link2":"'.$CI->config->item('base_url').'/transfer/index_bank'.'"
				}]
			},
			{
			"id":"transfer_pe",
			"acceso":'.$opciones->transfer_pe.',
			"pagina_actual":"transfer",
			"titulo":"Transferencias",
			"link":"'.$CI->config->item('base_url').'/transferencia/pe'.'",
			"submenu":""
			},
			{
			"id":"transfer_usd",
			"acceso":'.$opciones->transfer_usd.',
			"pagina_actual":"transfer",
			"titulo":"Transferencias",
			"link":"'.$CI->config->item('base_url').'/transferencia/pe'.'",
			"submenu":""
			},
			{
			"id":"pago",
			"acceso":'.$opciones->pago.',
			"pagina_actual":"pago",
			"titulo":"Pagos",
			"link":"'.$CI->config->item('base_url').'/transfer/index_tdc'.'",
			"submenu":""
			},
			{
			"id":"pago_ve",
			"acceso":'.$opciones->pago_ve.',
			"pagina_actual":"pago",
			"titulo":"Pagos",
			"link":"'.$CI->config->item('base_url').'/transfer/index_tdc'.'",
			"submenu":[
				{
				"titulo2":"Pago TDC",
				"link2":"'.$CI->config->item('base_url').'/transfer/index_tdc'.'"
				},
				{
				"titulo2":"Recarga Digitel",
				"link2":"'.$CI->config->item('base_url').'/pagos/digitel'.'"
				}]
			},
			{
			"id":"reportes",
			"acceso":'.$opciones->reportes.',
			"pagina_actual":"reportes",
			"titulo":"Reportes",
			"link":"'.$CI->config->item('base_url').'/report'.'",
			"submenu":""
			},
			{
			"id":"service",
			"acceso":'.$opciones->service.',
			"pagina_actual":"service",
			"titulo":"Atención al cliente",
			"link":"'.$CI->config->item('base_url').'/servicios'.'",
			"submenu":""
			},
			{
			"id":"perfil",
			"acceso":'.$opciones->perfil.',
			"pagina_actual":"perfil",
			"titulo":"'.$fullname.'",
			"link":"'.$CI->config->item('base_url').'/perfil'.'",
			"submenu":[
				{
				"titulo2":"Perfil",
				"link2":"'.$CI->config->item('base_url').'/perfil"
				},
				{
				"titulo2":"Cerrar Sesion",
				"link2":"'.$CI->config->item('base_url').'/users/closeSess'.'"
				}]
			}
			]';

			return $propiedades;
	}
}

		function opciones_menu($country){

			switch ($country) {

				case 'Ve':
					$opcion_menu='{"dashboard":true,"transfer":false,"pago_ve":true,"reportes":true,"service":true,"perfil":true}';
						break;
				case 'Co':
					$opcion_menu='{"dashboard":true,"transfer":true,"pago":true,"reportes":true,"service":true,"perfil":true}';
						break;
				case 'Pe':
					$opcion_menu='{"dashboard":true,"transfer_pe":true,"pago":true,"reportes":true,"service":true,"perfil":true}';
						break;
				case 'Usd':
					$opcion_menu='{"dashboard":true,"transfer_usd":true,"pago":true,"reportes":true,"service":true,"perfil":true}';
						break;
				case 'Ec-bp':
					$opcion_menu='{"dashboard":true,"transfer":false,"pago":false,"reportes":false,"service":true,"perfil":true}';
						break;
			}

			return $opcion_menu;
		}
?>
