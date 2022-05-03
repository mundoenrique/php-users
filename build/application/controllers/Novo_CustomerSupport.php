<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Controlador para el manejo de las tarjetas
 * @author J. Enrique Peñaloza Piñero
 * @date May 21th, 2020
*/
class Novo_CustomerSupport extends NOVO_Controller {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO CustomerSupport Controller Class Initialized');
	}
	/**
	 * @info Método para obtener las opciones de atención al cliente
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function services()
	{
		log_message('INFO', 'NOVO CustomerSupport: services Method Initialized');

		$view = 'services';
		array_push(
			$this->includeAssets->jsFiles,
			"modalCards",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"support/services"
		);
		$this->load->model('Novo_Business_Model', 'business');
		$this->request->module = $view;
		$userCardList = $this->business->callWs_UserCardsList_Business($this->request);
		$this->responseAttr($userCardList);
		$cardsList = $userCardList->data->cardsList;
		$serviceList = $userCardList->data->serviceList;
		$serviceTotal = 0;
		$pinManagement = FALSE;

		foreach ($serviceList AS $service) {
			if (in_array($service, ['112', '117', '120'])) {
				$pinManagement = TRUE;
				continue;
			}

			if (in_array($service, ['130', '217']) && count($serviceList) == 1) {
				$serviceTotal++;
			}

			$serviceTotal++;
		}

		$serviceTotal = $pinManagement ? $serviceTotal + 1 : $serviceTotal;

		$this->render->titlePage = lang('GEN_MENU_CUSTOMER_SUPPORT');
		$this->render->operations = TRUE;
		$this->render->serviceList = $serviceList;
		$this->render->serviceTotal = $serviceTotal;
		$this->render->cardsList = $cardsList;
		$this->render->statustext = lang('CUST_TEMPORARY_LOCK');
		$this->render->statustextCard =  lang('CUST_TEMPORARILY_LOCK');
		$this->render->RecoverPinText = lang('CUST_RETRIEVE_PIN');
		$this->render->activePointer = 'no-pointer';
		$this->render->uniqueEvent = $this->render->totalCards == 1 && $serviceTotal == 1;

		if ($this->render->totalCards == 1) {
			foreach ($userCardList->data->cardsList[0] as $index => $render) {
				$this->render->$index = $render;
			}

			$this->render->activePointer = '';

			if (!in_array($this->render->status, ['PB', ''])) {
				$this->render->serviceList = [];
				unset($userCardList->data->cardsList, $userCardList->data->serviceList);
				$userCardList->code = 3;
				$userCardList->title = lang('GEN_MENU_CUSTOMER_SUPPORT');

				switch ($this->render->status) {
					case '':
						$userCardList->msg = '';
					break;
					case 'NE':
						$userCardList->msg = lang('CUST_INACTIVE_PRODUCT');
					break;
					case '75':
						$userCardList->msg = lang('CUST_LOCK_CARD_WRONG_PIN_EXCESS');
					break;
					default:
						$userCardList->msg = lang('CUST_PERMANENT_LOCK');
					break;
				}

				$userCardList->modalBtn['btn1']['link'] = lang('CONF_LINK_CARD_DETAIL');
				$this->responseAttr($userCardList);
			}
		}

		if (count($serviceList) == 1 && $serviceList[0] == '120') {
			$this->render->RecoverPinText = lang('CUST_GENERATE_PIN');
		}

		$this->views = ['support/'.$view];
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
			"third_party/jquery.easyPaginate-1.2",
			"third_party/jquery.validate",
			"form_validation",
			"third_party/additional-methods",
			"support/notifications"
		);

		$notifications = $this->loadModel();
		$this->responseAttr($notifications);

		foreach($notifications->data AS $index => $render) {
			$this->render->$index = $render;
		}

		$this->render->titlePage = lang('GEN_MENU_NOTIFICATIONS');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
}
