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
		$cardsTotal = count($cardsList);
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
		$uniqueEvent = $cardsTotal == 1 && $serviceTotal == 1;
		$this->render->titlePage = lang('GEN_MENU_CUSTOMER_SUPPORT');
		$this->render->operations = TRUE;
		$this->render->serviceList = $serviceList;
		$this->render->serviceTotal = $serviceTotal;
		$this->render->cardsTotal = $cardsTotal;
		$this->render->cardsList = $cardsList;
		$this->render->brand = '';
		$this->render->productImg = '';
		$this->render->productUrl = '';
		$this->render->productName = '';
		$this->render->cardNumberMask = '';
		$this->render->cardNumber = '';
		$this->render->expireDate = '';
		$this->render->prefix = '';
		$this->render->status = '';
		$this->render->isVirtual = '';
		$this->render->tittleVirtual = '';
		$this->render->statustext = 'Bloquear';
		$this->render->RecoverPinText = 'Recuperar PIN';
		$this->render->activeEvents = 'no-events';
		$this->render->uniqueEvent = $uniqueEvent;
		$this->render->networkBrand = $cardsTotal > 1 ? 'hide' : '';

		if ($cardsTotal == 1) {
			$this->render->brand = $cardsList[0]->brand;
			$this->render->productImg = $cardsList[0]->productImg;
			$this->render->productUrl = $cardsList[0]->productUrl;
			$this->render->productName = $cardsList[0]->productName;
			$this->render->cardNumberMask = $cardsList[0]->cardNumberMask;
			$this->render->cardNumber = $cardsList[0]->cardNumber;
			$this->render->expireDate = $cardsList[0]->expireDate;
			$this->render->prefix = $cardsList[0]->prefix;
			$this->render->status = $cardsList[0]->status;
			$this->render->isVirtual = $cardsList[0]->isVirtual;
			$this->render->tittleVirtual = $cardsList[0]->tittleVirtual;
			$this->render->statustext = $cardsList[0]->status == '' ? 'Bloquear' : 'Desbloquear';
			$this->render->activeEvents = '';

			if (!in_array($this->render->status, ['PB', ''])) {
				$this->render->serviceList = [];
				unset($userCardList->data->cardsList, $userCardList->data->serviceList);
				$userCardList->code = 3;
				$userCardList->title = lang('GEN_MENU_CUSTOMER_SUPPORT');
				$userCardList->msg = $this->render->status == 'NE' ? lang('CUST_INACTIVE_PRODUCT') : lang('CUST_PERMANENT_LOCK');
				$this->responseAttr($userCardList);
			}
		}

		if (count($serviceList) == 1 && $serviceList[0] == '120') {
			$this->render->RecoverPinText = 'Generar PIN';
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
			"support/notifications"
		);
		$this->render->titlePage = lang('GEN_MENU_NOTIFICATIONS');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
}
