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

		if (!$this->session->has_userdata('operkeyEntered') && $this->router->fetch_method() !== 'getOperationKey') {
			$this->session->set_flashdata('transfer', $this->router->fetch_method());
			redirect(base_url('operations-key'), 'Location', 301);
		}
	}
	/**
	 * @info Método para validar clave de operaciones especiales
	 * @author J. Enrique Peñaloza Piñero.
	 * @date October 21th, 2021
	 */
	public function getOperationKey()
	{
		log_message('INFO', 'NOVO Transfer: getOperationKey Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'getOperationKey';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"transfer/getOperationKey"
		);

		$this->render->titlePage = lang('GEN_MENU_CARD_LIST');
		$this->render->cancelBtn = $this->agent->referrer() != '' ? $this->agent->referrer() : base_url(uriRedirect());
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
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
		$this->render->activePointer = 'no-pointer';
		$this->render->operations = TRUE;

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->activePointer = '';
		}

		$this->render->titlePage = lang('GEN_MENU_CARD_LIST');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
}
