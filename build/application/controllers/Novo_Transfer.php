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
	 * @info Método para crear clave de operaciones especiales
	 * @author Hector D. Corredor Gutierrez.
	 * @date October 04th, 2022
	 */
	public function setOperationKey()
	{
		log_message('INFO', 'NOVO Transfer: setOperationKey Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'setOperationKey';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/validPass",
			"transfer/setOperationKey"
		);

		$this->render->titlePage = lang('GEN_MENU_PAYS_TRANSFER');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
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

		$this->render->titlePage = lang('GEN_MENU_PAYS_TRANSFER');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
		/**
	 * @info Método para cambiar la clave de operaciones especiales
	 * @author Hector D. Corredor Gutierrez.
	 * @date October 04th, 2022
	 */
	public function changeOperationKey()
	{
		log_message('INFO', 'NOVO Transfer: changeOperationKey Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'changeOperationKey';
		array_push(
			$this->includeAssets->jsFiles,
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"user/validPass",
			"transfer/changeOperationKey"
		);

		$this->render->titlePage = lang('GEN_MENU_PAYS_TRANSFER');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener las opciones de transferencias entre tarjetas
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 10th, 2022
	 */
	public function cardToCard()
	{
		log_message('INFO', 'NOVO Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'cardToCard';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"transfer/cardToCard",
			"transfer/transferHelpers"
		);

		$this->modelClass = 'Novo_Business_Model';
		$this->modelMethod = 'callWs_CardListOperations_Business';
		$this->request->operation = 'Transferencias';
		$this->request->operType = 'P2P';
		$userCardList = $this->loadModel($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);
		$attrNoPointer = 'no-pointer';

		$this->render->titlePage = lang('GEN_MENU_TRANSFERS');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->activePointer = $attrNoPointer;
		$this->render->callBalance = '0';

		if ($totalCards == 1) {
			$this->render->activePointer = '';
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callBalance = '1';
		}

		$this->render->titleTransfer = lang('TRANSF_TO_TRANSFER');
		$this->render->msgTransfer = lang('TRANSF_BANK_ACCOUNTS_MSG');
		$this->render->titleTable = lang('TRANSF_ACCOUNT_PHONE');
		$this->render->navItemsConfig = [
			'transfer' => [
				'id' => 'toTransfer',
				'icon' => 'icon-user-transfer h00',
				'title' => lang('TRANSF_TO_TRANSFER'),
				'activeSection' => $totalCards === 1 ? 'active' : '',
				'activePointer' => $attrNoPointer,
			],
			'affiliate' => [
				'id' => 'affiliations',
				'icon' => 'icon-user-config h3',
				'title' => lang('TRANSF_MANAGE_AFFILIATIONS'),
				'activeSection' => '',
				'activePointer' => '',
			],
			'history' => [
				'id' => 'history',
				'icon' => 'icon-history h0',
				'title' => lang('TRANSF_HISTORY'),
				'activeSection' => '',
				'activePointer' => $attrNoPointer,
			],
		];

		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener la lista para transferencias entre cuentas bancarias
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 04th, 2022
	 */
	public function cardToBank()
	{
		log_message('INFO', 'NOVO Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'cardToBank';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"transfer/cardToBank"
		);

		$this->modelClass = 'Novo_Business_Model';
		$this->modelMethod = 'callWs_CardListOperations_Business';
		$this->request->operation = 'Transferencias';
		$this->request->operType = 'P2T';
		$userCardList = $this->loadModel($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);

		$this->render->titlePage = lang('GEN_MENU_TRANSFERS');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->activePointer = 'no-pointer';
		$this->render->callBalance = '0';

		if ($totalCards == 1) {
			$this->render->activePointer = '';
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callBalance = '1';
		}

		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener la lista para pago móvil
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 04th, 2022
	 */
	public function mobilePayment()
	{
		log_message('INFO', 'NOVO Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'mobilePayment';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"transfer/mobilePayment"
		);

		$this->render->titlePage = lang('GEN_MENU_PAYMENTS');
		$this->views = ['transfer/'.$view];
		$this->loadView($view);
	}
}
