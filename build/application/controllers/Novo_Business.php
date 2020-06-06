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

		$request = (array) $this->request;

		$getList = 'obtain';
		$cardsList = [];
		$cardsTotal = 0;

		if (!empty($request)) {
			$userCardList = $this->loadModel();
			$getList = 'obtained';
			$this->responseAttr($userCardList);
			$cardsList = $userCardList->data->cardsList;
			$cardsTotal = count($cardsList);
		}

		$this->render->titlePage = lang('GEN_MENU_CARDS_LIST');
		$this->render->lastSession = $this->session->lastSession;
		$this->render->getList = $getList;
		$this->render->cardsTotal = $cardsTotal;
		$this->render->cardsList = $cardsList;
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
			"third_party/jquery.easyPaginate-1.2",
			"business/cardDetail"
		);

		$detailCard = $this->loadModel($this->request);
		$this->responseAttr($detailCard);

		$this->render->titlePage = lang('GEN_MENU_CARD_DETAIL');
		$this->render->currentYear = date('Y');

		foreach ($detailCard->data AS $index => $render) {
			if($index !== 'resp') {
				$this->render->$index = $render;
			}
		}

		foreach ($this->request AS $index => $render) {
			$this->render->$index = $render;
		}

		$this->views = ['business/'.$view];
		$this->loadView($view);
	}
}
