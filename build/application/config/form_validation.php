<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = [
	'login' => [

		[
			'field' => 'user',
			'label' => 'user',
			'rules' => 'trim|regex_match[/^([\wñÑ*.-]+)+$/i]|required'
		],
		[
			'field' => 'pass',
			'label' => 'pass',
			'rules' => 'trim|required'
		]
	],
	'verifyaccount' => [
		[
			'field' => 'plot',
			'rules' => 'trim|required'
		],
		[
			'field' => 'request',
			'rules' => 'trim|required'
		]
	],
	'registry' => [
		[
			'field' => 'idType',
			'label' => 'idType',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'idNumber',
			'label' => 'idNumber',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'firstName',
			'label' => 'firstName',
			'rules' => 'trim|alpha|required'
		],
		[
			'field' => 'middleName',
			'label' => 'middleName',
			'rules' => 'trim|alpha'
		],
	],
	'finishsession' => [
		[
			'field' => 'user',
			'label' => 'user',
			'rules' => 'trim|regex_match[/^([\wñ]+)+$/i]|required'
		]
	],
	'recoverypass' => [
		[
			'field' => 'userName',
			'label' => 'userName',
			'rules' => 'trim|regex_match[/^([\wñ]+)+$/i]|required'
		],
		[
			'field' => 'idEmpresa',
			'label' => 'idEmpresa',
			'rules' => 'trim|regex_match[/^([\w-]+[\s]*)+$/i]|required'
		],
		[
			'field' => 'email',
			'label' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		]
	],
	'changepassword' => [
		[
			'field' => 'currentPass',
			'label' => 'currentPass',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|required'
		],
		[
			'field' => 'newPass',
			'label' => 'newPass',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|differs[currentPass]|required'
		],
		[
			'field' => 'confirmPass',
			'label' => 'confirmPass',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|matches[newPass]|required'
		]
	],
	'detail-products' => [
		[
			'field' => 'numt',
			'label' => 'numt',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'label' => 'prefix',
			'rules' => 'trim|regex_match[/^[\w-]+$/i]|required'
		],
		[
			'field' => 'marca',
			'label' => 'marca',
			'rules' => 'trim|regex_match[/^([\w-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]|required'
		],
		[
			'field' => 'empresa',
			'label' => 'empresa',
			'rules' => 'trim|regex_match[/^([\w-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]|required'
		],
		[
			'field' => 'producto',
			'label' => 'producto',
			'rules' => 'trim|regex_match[/^([\w-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]'
		],
		[
			'field' => 'numt_mascara',
			'label' => 'numt_mascara',
			'rules' => 'trim|regex_match[/^[0-9\*]+$/]|required'
		]
	],
	'detail-card' => [
		[
			'field' => 'card',
			'label' => 'card',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
	],
	'movements' => [
		[
			'field' => 'card',
			'label' => 'card',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
		[
			'field' => 'month',
			'label' => 'month',
			'rules' => 'trim|regex_match[/^([\w])+$/i]|required'
		],
		[
			'field' => 'year',
			'label' => 'year',
			'rules' => 'trim|numeric|required'
		]
	],
	'CallWsExportar' => [
		[
			'field' => 'tarjeta',
			'label' => 'tarjeta',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
		[
			'field' => 'mes',
			'label' => 'mes',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'anio',
			'label' => 'anio',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'idOperation',
			'label' => 'idOperation',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		]
	],
	'CallWsGastos' => [
		[
			'field' => 'tarjeta',
			'label' => 'tarjeta',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
		[
			'field' => 'idpersona',
			'label' => 'idpersona',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'tipo',
			'label' => 'tipo',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'producto',
			'label' => 'producto',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'fechaIni',
			'label' => 'fechaIni',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		],
		[
			'field' => 'fechaFin',
			'label' => 'fechaFin',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		]
	],
	'inTransit' => [
		[
			'field' => 'idPrograma',
			'label' => 'idPrograma',
			'rules' => 'trim|regex_match[/^[\w-]+$/i]|required'
		],
		[
			'field' => 'tarjetaMascara',
			'label' => 'tarjetaMascara',
			'rules' => 'trim|regex_match[/^[0-9\*]+$/]|required'
		]
	],
	'download-file' => [
		[
			'field' => 'tarjeta',
			'label' => 'tarjeta',
			'rules' => 'trim|regex_match[/^([\w=\/+-]+)+$/i]|required'
		],
		[
			'field' => 'idpersona',
			'label' => 'idpersona',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'tipoConsulta',
			'label' => 'tipoConsulta',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'producto',
			'label' => 'producto',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'fechaIni',
			'label' => 'fechaIni',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		],
		[
			'field' => 'fechaFin',
			'label' => 'fechaFin',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		]
	]
];
