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
			"reports/expensesCategory"
		);

		$this->render->activeHeader = TRUE;
		$this->render->activeMenuUser = TRUE;
		$this->render->titlePage = lang('GEN_MENU_REPORTS');
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
		$this->render->activeMenuUser = TRUE;
		$this->render->titlePage = lang('GEN_MENU_NOTIFICATIONS');
		$this->views = ['support/'.$view];
		$this->loadView($view);
	}
}
