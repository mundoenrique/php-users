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
			"support/services"
		);

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_CUSTOMER_SUPPORT');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
	/**
	 * @info Método para obtener las opciones de atención al cliente
	 * @author J. Enrique Peñaloza Piñero.
	 * @date May 21th, 2020
	 */
	public function reports()
	{
		log_message('INFO', 'NOVO CustomerSupport: reports Method Initialized');

		$view = 'reports';
		array_push(
			$this->includeAssets->jsFiles,
			"support/reports"
		);

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_REPORTS');
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

		$this->render->activeHeader = TRUE;
		$this->render->titlePage = lang('GEN_MENU_NOTIFICATIONS');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
}
