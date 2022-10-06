<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la información de las transferencias del usuario
 * @author Hector D. Corredor Gutierrez
 * @date May 06th, 2022
 */
class Novo_Transfer_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Transfer Model Class Initialized');
	}
	public function CallWs_SetOperationKey_Tranfer($dataRequest)
	{
		log_message('INFO', 'NOVO Transfer Model: SetOperationKey Method Initialized');

		return $this->responseToTheView('CallWs_SetOperationKey');
	}

}
