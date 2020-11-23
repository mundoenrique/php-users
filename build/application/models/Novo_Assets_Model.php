<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @info Módelo obtener activo para la aplicación
 * @author J. Enrique Peñaloza Piñero
 * @date 25 10th, 2020
 */
class Novo_Assets_Model extends NOVO_Model {

	public function __construct()
	{
		parent:: __construct();
		log_message('INFO', 'NOVO User Model Class Initialized');
	}
	/**
	 * @info Método para obtener la lista de estados
	 * @author J. Enrique Peñaloza Piñero
	 * @date 25 10th, 2020
	 */
	public function callWs_StatesList_Assets($dataRequest)
	{
		log_message('INFO', 'NOVO Assets Model: StatesList Method Initialized');

		$this->dataAccessLog->modulo = 'Activos';
		$this->dataAccessLog->function = 'Lista de Estados';
		$this->dataAccessLog->operation = 'Obtener lista de Estados';

		$this->dataRequest->idOperation = '34';
		$this->dataRequest->className = 'com.novo.objects.TOs.PaisTO';
		$this->dataRequest->codPais = $this->country;

		$response = $this->sendToService('callWs_StatesList');
		$statesList = [];
		$this->response->code = 0;

		switch($this->isResponseRc) {
			case 0:
				foreach ($response->listaEstados as $pos => $state) {
					$list = new stdClass();
					$list->regId = trim($state->codEstado);
					$list->regDesc = trim($state->estados);
					$statesList[] = $list;
					$this->response->modal = TRUE;
				}
			break;
		}

		$this->response->data = $statesList;

		return $this->responseToTheView('callWs_StatesList');
	}
	/**
	 * @info Método para obtener la lista de Ciudades
	 * @author J. Enrique Peñaloza Piñero
	 * @date 25 10th, 2020
	 */
	public function callWs_CityList_Assets($dataRequest)
	{
		log_message('INFO', 'NOVO Assets Model: CityList Method Initialized');

		$this->dataAccessLog->modulo = 'Activos';
		$this->dataAccessLog->function = 'Lista de Ciudades';
		$this->dataAccessLog->operation = 'Obtener lista de Ciudades';

		$this->dataRequest->idOperation = '35';
		$this->dataRequest->className = 'com.novo.objects.TOs.EstadoTO';
		$this->dataRequest->codEstado = $dataRequest->stateCode;
		$this->dataRequest->codPais = $this->country;

		$response = $this->sendToService('callWs_CityList');
		$citiesList = [];
		$this->response->code = 0;

		switch($this->isResponseRc) {
			case 0:
				foreach ($response->listaCiudad as $pos => $city) {
					$list = new stdClass();
					$list->regId = trim($city->codCiudad);
					$list->regDesc = trim($city->ciudad);
					$citiesList[] = $list;
					$this->response->modal = TRUE;
				}
			break;
		}

		$this->response->data = $citiesList;

		return $this->responseToTheView('callWs_CityList');
	}
	/**
	 * @info Método para obtener la lista de Ciudades
	 * @author J. Enrique Peñaloza Piñero
	 * @date 25 10th, 2020
	 */
	public function callWs_Regions_Assets($dataRequest)
	{
		log_message('INFO', 'NOVO Assets Model: Regions Method Initialized');

		$this->dataAccessLog->modulo = 'Activos';
		$this->dataAccessLog->function = 'Lista de Distritos';
		$this->dataAccessLog->operation = 'Obtener lista de Distritos';

		$this->dataRequest->idOperation = 'buscarRegiones';
		$this->dataRequest->className = 'com.novo.objects.TOs.UsuarioTO';
		$this->dataRequest->userName = 'REGISTROCPO';
		$this->dataRequest->codigoGrupo = $dataRequest->groupCode;

		$response = $this->sendToService('callWs_Regions');
		$regionsList = [];
		$this->response->code = 0;

		switch($this->isResponseRc) {
			case 0:
				foreach ($response->listaSubRegiones as $pos => $region) {
					$list = new stdClass();
					$list->regId = trim($region->codregion);
					$list->regDesc = trim($region->region);
					$regionsList[] = $list;
					$this->response->modal = TRUE;
				}
			break;
		}

		$this->response->data = $regionsList;

		return $this->responseToTheView('callWs_Regions');
	}
	/**
	 * @info Método para obtener la lista de Ciudades
	 * @author J. Enrique Peñaloza Piñero
	 * @date 25 10th, 2020
	 */
	public function callWs_ProfessionsList_Assets($dataRequest)
	{
		log_message('INFO', 'NOVO Assets Model: Professions Method Initialized');

		$this->dataAccessLog->modulo = 'Activos';
		$this->dataAccessLog->function = 'Lista de profesiones';
		$this->dataAccessLog->operation = 'Obtener lista de profesiones';

		$this->dataRequest->idOperation = '37';
		$this->dataRequest->className = 'com.novo.objects.MO.ListaTipoProfesionesMO';

		$response = $this->sendToService('callWs_ProfessionsList');
		$profList = [];
		$this->response->code = 0;

		switch($this->isResponseRc) {
			case 0:
				foreach ($response->listaProfesiones AS $pos => $professions) {
					$list = new stdClass();
					$list->profId = $professions->idProfesion;
					$list->profDesc = $professions->tipoProfesion;
					$profList[] = $list;
					$this->response->modal = TRUE;
				}
			break;
		}

		$this->response->data = $profList;

		return $this->responseToTheView('callWs_ProfessionsList');
	}
	/**
	 * @info Método para solictar token de doble autenticación
	 * @author J. Enrique Peñaloza Piñero.
	 * @date November 10th, 2020
	 */
	public function callWs_GetToken_Assets()
	{
		log_message('INFO', 'NOVO Business Model: GetToken_Assets Method Initialized');

		$this->dataAccessLog->modulo = 'Activos';
		$this->dataAccessLog->function = 'Generar token';
		$this->dataAccessLog->operation = 'Obtener token de operaciones';

		$this->dataRequest->idOperation = '113';
		$this->dataRequest->className = 'com.novo.objects.TOs.TarjetaTO';
		$this->dataRequest->id_ext_per = $this->session->userId;
		$this->dataRequest->accodUsuario = $this->session->userName;

		$response = $this->sendToService('callWs_GetToken');

		switch($this->isResponseRc) {
			case 0:
				$this->response->code = 2;
				$this->response->icon = lang('CONF_ICON_INFO');
				$this->response->msg = 'Hemos enviado un código de seguridad a tu correo electrónico, por favor indicalo a continuación:';
				$this->response->modalBtn['btn1']['action'] = 'none';
				$this->response->modalBtn['btn2']['text'] = lang('GEN_BTN_CANCEL');
				$this->response->modalBtn['btn2']['action'] = 'destroy';
			break;
			case -173:
				$this->response->msg = 'No fue posible enviar el código de seguridad a tu correo, por favor intenta de nuevo.';
				$this->response->modalBtn['btn1']['action'] = 'destroy';
			break;
		}

		return $this->responseToTheView('callWs_GetToken');
	}
}
