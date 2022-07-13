<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo para la peticion de los servicios
 * @author Luis Molina.
 * @date June 29th, 2022
 */
class Novo_Mfa_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO Mfa Model Class Initialized');
	}
	/**
	 * @info Método para habilitar multifactor de autenticación
   * @author Luis Molina.
   * @date June 29th, 2022
	 */
	public function callWs_AutenticationEnable_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa AutenticationEnable Method Initialized');

		$this->dataAccessLog->modulo = 'modulo';
		$this->dataAccessLog->function = 'function';
		$this->dataAccessLog->operation = 'operation';

		$this->dataRequest->idOperation = 'idOperation';
		$this->dataRequest->className = 'className';
		$this->dataRequest->userName = 'userName';

		log_message('INFO', '****NOVO Mfa Model dataRequest*****'.$dataRequest->activationType);

		$response = $this->sendToCoreServices('callWs_AutenticationEnable');

		/*switch($this->isResponseRc) {

		}*/

		return $this->responseToTheView('callWs_AutenticationEnable');
	}

	/**
	 * @info Método para validar codigo multifactor autenticación
   * @author Luis Molina.
   * @date Jul 07th, 2022
	 */
	public function callWs_validateCode_Mfa($dataRequest)
	{
		log_message('INFO', 'NOVO Mfa Model: Mfa validateCode Method Initialized');

		$this->dataAccessLog->modulo = 'modulo';
		$this->dataAccessLog->function = 'function';
		$this->dataAccessLog->operation = 'operation';

		$this->dataRequest->idOperation = 'idOperation';
		$this->dataRequest->className = 'className';
		$this->dataRequest->userName = 'userName';

		$response = $this->sendToCoreServices('callWs_validateCode');

		switch($this->isResponseRc) {
			//
			//
			//
		}

		return $this->responseToTheView('callWs_validateCode');
	}

}
