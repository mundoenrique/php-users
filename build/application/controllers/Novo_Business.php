<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para el manejo de las tarjetas
 * @author J. Enrique Peñaloza Piñero
 * @date May 20th, 2020
*/
class Novo_Business extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Business Controller Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function userCardsList()
	{
		log_message('INFO', 'NOVO User: userCardsList Method Initialized');

		$view = 'userCardsList';
		array_push(
			$this->includeAssets->jsFiles,
			"business/userCardsList"
		);

		$this->render->activeHeader = TRUE;
		$this->render->activeMenuUser = TRUE;
		$this->render->titlePage = lang('GEN_MENU_CARDS_LIST');
		$this->render->lastSession = $this->session->lastSession;
		$this->views = ['business/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener la lista de tarjetas de un usuario
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 20th, 2020
	 */
	public function cardDetail()
	{
		log_message('INFO', 'NOVO User: cardDetail Method Initialized');

		$view = 'cardDetail';
		array_push(
			$this->includeAssets->jsFiles,
			"business/cardDetail"
		);

		$this->render->activeHeader = TRUE;
		$this->render->activeMenuUser = TRUE;
		$this->render->titlePage = lang('GEN_MENU_CARD_DETAIL');
		$this->views = ['business/'.$view];
		$this->loadView($view);
	}
}
