<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para el manejo de las tarjetas
 * @author J. Enrique Peñaloza Piñero
 * @date May 21th, 2020
*/
class Novo_Reports extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Reports Controller Class Initialized');
	}
	/**
	 * @info Método para obtener las opciones de atención al cliente
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function expensesCategory()
	{
		log_message('INFO', 'NOVO Reports: expensesCategory Method Initialized');

		$view = 'expensesCategory';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"reports/expensesCategory"
		);
		$this->load->model('Novo_Business_Model', 'business');
		$this->request->operation = 'Reportes';
		$this->request->operType = 'RGR';
		$userCardList = $this->business->callWs_CardListOperations_Business($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$cardsTotal = count($cardsList);
		$this->render->titlePage = lang('GEN_MENU_REPORTS');
		$this->render->operations = TRUE;
		$this->render->cardsTotal = $cardsTotal;
		$this->render->cardsList = $cardsList;
		$this->render->brand = '';
		$this->render->productImg = '';
		$this->render->productUrl = '';
		$this->render->productName = '';
		$this->render->cardNumberMask = '';
		$this->render->cardNumber = '';
		$this->render->prefix = '';
		$this->render->status = '';

		if ($cardsTotal == 1) {
			$this->render->brand = $cardsList[0]->brand;
			$this->render->productImg = $cardsList[0]->productImg;
			$this->render->productUrl = $cardsList[0]->productUrl;
			$this->render->productName = $cardsList[0]->productName;
			$this->render->cardNumberMask = $cardsList[0]->cardNumberMask;
			$this->render->cardNumber = $cardsList[0]->cardNumber;
			$this->render->prefix = $cardsList[0]->prefix;
			$this->render->status = $cardsList[0]->status;
		}

		$this->views = ['reports/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener las opciones de notificación del cliente
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function notifications()
	{
		log_message('INFO', 'NOVO CustomerSupport: notifications Method Initialized');

		$view = 'notifications';
		array_push(
			$this->includeAssets->jsFiles,
			"support/notifications"
		);

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_NOTIFICATIONS');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
}
