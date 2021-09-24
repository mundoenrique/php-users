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
			"third_party/Chart",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"reports/expensesCategory"
		);
		$this->load->model('Novo_Business_Model', 'business');
		$this->request->operation = 'Reportes';
		$this->request->operType = 'RGR';
		$userCardList = $this->business->callWs_CardListOperations_Business($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);
		$yearTenant = (int) lang('CONF_TENANT_PUBLICATION');
		$years = date('Y') - 4;
		$maxYear = date('Y');

		if (($yearTenant - $years) >= 0) {
			$years = $yearTenant;
		}

		$this->render->years = $years;
		$this->render->maxYear = $maxYear;
		$this->render->titlePage = lang('GEN_MENU_REPORTS');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->callMoves = '0';

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callMoves = '1';
		}

		$this->views = ['reports/'.$view];
		$this->loadView($view);
	}
}
