<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @info Controlador para el manejo de los Pagos y transferencias
 * @author J. Enrique Peñaloza Piñero
 * @date August 20th, 2021
 */
class Novo_Transfer extends NOVO_Controller
{

	private $navItemsConfig;
	private $attrNoPointer;

	public function __construct()
	{
		parent::__construct();
		writeLog('INFO', 'Transfer Controller Class Initialized');

		$currentMethod = $this->controllerMethod;
		$validateOperKey = $this->session->operKey;
		$validaTransferAuth = !$this->session->transferAuth;
		$validateChangeOperKey = $currentMethod !== 'changeOperationKey';
		$validateSetOperKey = $currentMethod !== 'setOperationKey';
		$validateGetOperKey = $currentMethod !== 'getOperationKey';
		$validateUriOperKey = lang('SETT_REDIRECT_OPER_KEY');
		$validateRedirect = ($validateChangeOperKey && $validaTransferAuth);

		if ($validateOperKey && $validateGetOperKey && $validateRedirect) {
			$this->session->set_flashdata('currentUri', $validateUriOperKey[$currentMethod]);
			redirect(base_url(lang('SETT_LINK_GET_OPER_KEY')), 'Location', 301);
			exit();
		}

		if (!$validateOperKey && $validateSetOperKey && $validateRedirect) {
			$this->session->set_flashdata('currentUri', $validateUriOperKey[$currentMethod]);
			redirect(base_url(lang('SETT_LINK_SET_OPER_KEY')), 'Location', 301);
			exit();
		}

		$this->session->keep_flashdata('currentUri');
		$this->attrNoPointer = 'no-pointer';
		$this->navItemsConfig = [
			'transfer' => [
				'id' => 'toTransfer',
				'icon' => 'icon-user-transfer h00',
				'title' => lang('TRANSF_TO_TRANSFER'),
				'activeSection' => '',
				'activePointer' => $this->attrNoPointer,
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
				'activePointer' => $this->attrNoPointer,
			],
		];
	}

	/**
	 * @info Método para crear clave de operaciones especiales
	 * @author Hector D. Corredor Gutierrez.
	 * @date October 04th, 2022
	 */
	public function setOperationKey()
	{
		writeLog('INFO', 'Transfer: setOperationKey Method Initialized');

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

		$this->render->titleCredential = ['title' => strtolower(lang('GEN_KEY'))];
		$this->render->titlePage = lang('GEN_MENU_PAYS_TRANSFER');
		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
	/**
	 * @info Método para validar clave de operaciones especiales
	 * @author J. Enrique Peñaloza Piñero.
	 * @date October 21th, 2021
	 */
	public function getOperationKey()
	{
		writeLog('INFO', 'Transfer: getOperationKey Method Initialized');

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
		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
	/**
	 * @info Método para cambiar la clave de operaciones especiales
	 * @author Hector D. Corredor Gutierrez.
	 * @date October 04th, 2022
	 */
	public function changeOperationKey()
	{
		writeLog('INFO', 'Transfer: changeOperationKey Method Initialized');

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

		$this->render->titleCredential = ['title' => strtolower(lang('GEN_KEY'))];
		$this->render->titlePage = lang('GEN_MENU_PAYS_TRANSFER');
		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener las opciones de transferencias entre tarjetas
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 10th, 2022
	 */
	public function cardToCard()
	{
		writeLog('INFO', 'Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'cardToCard';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"third_party/jquery.mask-1.14.16",
			"third_party/jquery.easyPaginate-1.2",
			"form_validation",
			"third_party/additional-methods",
			"transfer/transferHelpers",
			"transfer/transferParams",
			"transfer/affiliations",
			"transfer/history",
		);

		$this->modelClass = 'Novo_Business_Model';
		$this->modelMethod = 'callWs_CardListOperations_Business';
		$this->request->operation = 'Transferencias';
		$this->request->operType = 'P2P';
		$userCardList = $this->loadModel($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);

		$this->render->view = $view;
		$this->render->titlePage = lang('GEN_MENU_TRANSFERS');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->callBalance = '0';

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callBalance = '1';
			$this->navItemsConfig['transfer']['activeSection'] = 'active';
			$this->navItemsConfig['transfer']['activePointer'] = '';
			$this->navItemsConfig['history']['activePointer'] = '';
		}

		$this->render->navItemsConfig = $this->navItemsConfig;
		$this->render->titleTransfer = lang('TRANSF_TO_TRANSFER');
		$this->render->msgTransfer = lang('TRANSF_BETWEEN_CARDS_MSG');
		$this->render->tHeaders = [
			lang('TRANSF_BENEFICIARY'),
			lang('GEN_DNI'),
			lang('TRANSF_DESTINATION_CARD'),
			lang('TRANSF_OPTIONS')
		];

		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener la lista para transferencias entre cuentas bancarias
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 04th, 2022
	 */
	public function cardToBank()
	{
		writeLog('INFO', 'Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'cardToBank';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"third_party/jquery.mask-1.14.16",
			"third_party/jquery.easyPaginate-1.2",
			"form_validation",
			"third_party/additional-methods",
			"transfer/transferHelpers",
			"transfer/transferParams",
			"transfer/affiliations",
			"transfer/history",
		);

		$this->modelClass = 'Novo_Business_Model';
		$this->modelMethod = 'callWs_CardListOperations_Business';
		$this->request->operation = 'Transferencias';
		$this->request->operType = 'PCI';
		$userCardList = $this->loadModel($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);

		$this->render->view = $view;
		$this->render->titlePage = lang('GEN_MENU_TRANSFERS');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->callBalance = '0';

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callBalance = '1';
			$this->navItemsConfig['transfer']['activeSection'] = 'active';
			$this->navItemsConfig['transfer']['activePointer'] = '';
			$this->navItemsConfig['history']['activePointer'] = '';
		}

		$this->render->navItemsConfig = $this->navItemsConfig;
		$this->render->titleTransfer = lang('TRANSF_TO_TRANSFER');
		$this->render->msgTransfer = lang('TRANSF_BANK_ACCOUNTS_MSG');
		$this->render->tHeaders = [
			lang('TRANSF_BENEFICIARY'),
			lang('TRANSF_BANK'),
			lang('TRANSF_ACCOUNT_PHONE'),
			lang('TRANSF_OPTIONS')
		];

		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener la lista para pago móvil
	 * @author Hector D. Corredor Gutierrez, Jhonatan Llerena.
	 * @date October 04th, 2022
	 */
	public function mobilePayment()
	{
		writeLog('INFO', 'Transfer: cardToCard Method Initialized');

		$this->session->keep_flashdata('transfer');
		$view = 'mobilePayment';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"third_party/jquery.mask-1.14.16",
			"third_party/jquery.easyPaginate-1.2",
			"form_validation",
			"third_party/additional-methods",
			"transfer/transferHelpers",
			"transfer/transferParams",
			"transfer/affiliations",
			"transfer/history",
		);

		$this->modelClass = 'Novo_Business_Model';
		$this->modelMethod = 'callWs_CardListOperations_Business';
		$this->request->operation = 'Transferencias';
		$this->request->operType = 'PMV';
		$userCardList = $this->loadModel($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$totalCards = count($cardsList);
		$this->navItemsConfig['transfer']['title'] = lang('TRANSF_MAKE_PAYMENT');

		$this->render->view = $view;
		$this->render->titlePage = lang('GEN_MENU_MOBILE_PAYMENT');
		$this->render->operations = TRUE;
		$this->render->totalCards = $totalCards;
		$this->render->cardsList = $cardsList;
		$this->render->callBalance = '0';

		if ($totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->callBalance = '1';
			$this->navItemsConfig['transfer']['activeSection'] = 'active';
			$this->navItemsConfig['transfer']['activePointer'] = '';
			$this->navItemsConfig['history']['activePointer'] = '';
		}

		$this->render->navItemsConfig = $this->navItemsConfig;
		$this->render->titleTransfer = lang('TRANSF_MAKE_PAYMENT');
		$this->render->msgTransfer = lang('TRANSF_PAY_MOVIL_MSG');
		$this->render->tHeaders = [
			lang('TRANSF_BENEFICIARY'),
			lang('TRANSF_BANK'),
			lang('TRANSF_NUMBER_PHONE'),
			lang('TRANSF_OPTIONS')
		];

		$this->views = ['transfer/' . $view];
		$this->loadView($view);
	}
}
