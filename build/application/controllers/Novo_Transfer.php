<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para el manejo de los Pagos y transferencias
 * @author J. Enrique Peñaloza Piñero
 * @date August 20th, 2021
*/
class Novo_Transfer extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Transfer Controller Class Initialized');
	}
	/**
	 * @info Método para obtener la lista para transferencias entre tarjetas
	 * @author J. Enrique Peñaloza Piñero.
	 * @date August 20th, 2021
	 */
	public function cardToCard()
	{
		log_message('INFO', 'NOVO Transfer: cardToCard Method Initialized');

		$view = 'cardToCard';

		/* array_push(
			$this->includeAssets->jsFiles,
			"business/userCardsList"
		); */

		$this->render->titlePage = lang('GEN_MENU_CARD_LIST');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
}
