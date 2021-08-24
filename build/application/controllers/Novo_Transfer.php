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

		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods"
		);

		$this->load->model('Novo_Business_Model', 'business');
		$this->request->operation = 'Transferencia P2P';
		$this->request->operType = 'P2P';
		$userCardList = $this->business->callWs_CardListOperations_Business($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);
		$this->render->cardsList = $cardsList;
		$this->render->totalCards = $totalCards;
		$this->render->activeEvents = 'no-pointer';
		$this->render->operations = TRUE;

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->activeEvents = '';
		}

		$this->render->titlePage = lang('GEN_MENU_CARD_LIST');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
}
