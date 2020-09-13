<?php defined('BASEPATH') or exit('No direct script access allowed');

$config = [
	'signin' => [
		[
			'field' => 'userName',
			'rules' => 'trim|regex_match[/^([\wñÑ.\-+&]+)+$/i]|required'
		],
		[
			'field' => 'userPass',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		],
		[
			'field' => 'currentTime',
			'rules' => 'trim|integer|required'
		],
		[
			'field' => 'token',
			'rules' => 'trim'
		]
	],
	'userIdentify' => [
		[
			'field' => 'numberCard',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'docmentId',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'cardPIN',
			'rules' => 'trim|integer'
		],
		[
			'field' => 'acceptTerms',
			'rules' => 'trim|regex_match[/on/]|required'
		]
	],
	'signup' => [
		[
			'field' => 'dataUser',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		]
	],
	'validNickName' => [
		[
			'field' => 'nickName',
			'rules' => 'trim|regex_match[/^([a-z0-9_])+$/i]|required'
		]
	],
	'signUpData' => [
		[
			'field' => 'nickName',
			'rules' => 'trim|regex_match[/^([a-z0-9_])+$/i]|required'
		],
		[
			'field' => 'idType',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'idNumber',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'firstName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]|required'
		],
		[
			'field' => 'lastName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]|required'
		],
		[
			'field' => 'middleName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]'
		],
		[
			'field' => 'surName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]'
		],
		[
			'field' => 'gender',
			'rules' => 'trim|regex_match[/^(M|F)/]|required'
		],
		[
			'field' => 'birthDate',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		],
		[
			'field' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		],
		[
			'field' => 'landLine',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'mobilePhone',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'phoneType',
			'rules' => 'trim|alpha'
		],
		[
			'field' => 'otherPhoneNum',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'newPass',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		]
	],
	'updateProfile' => [
		[
			'field' => 'nickName',
			'rules' => 'trim|regex_match[/^([a-z0-9_])+$/i]|required'
		],
		[
			'field' => 'idTypeCode',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'idTypeText',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]|required'
		],
		[
			'field' => 'idNumber',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'firstName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]|required'
		],
		[
			'field' => 'lastName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]|required'
		],
		[
			'field' => 'middleName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]'
		],
		[
			'field' => 'surName',
			'rules' => 'trim|regex_match[/^([\wñÑáéíóúÑÁÉÍÓÚ ]+)+$/i]'
		],
		[
			'field' => 'gender',
			'rules' => 'trim|regex_match[/^(M|F)/]|required'
		],
		[
			'field' => 'birthDate',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		],
		[
			'field' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		],
		[
			'field' => 'landLine',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'mobilePhone',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'phoneType',
			'rules' => 'trim|alpha'
		],
		[
			'field' => 'otherPhoneNum',
			'rules' => 'trim|numeric'
		]
	],
	'accessRecover' => [
		[
			'field' => 'recoveryUser',
			'rules' => 'trim|regex_match[/U/]'
		],
		[
			'field' => 'recoveryPwd',
			'rules' => 'trim|regex_match[/C/]'
		],
		[
			'field' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		],
		[
			'field' => 'idNumber',
			'rules' => 'trim|alpha_numeric|required'
		]
	],
	'changePassword' => [
		[
			'field' => 'currentPass',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		],
		[
			'field' => 'newPass',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		],
		[
			'field' => 'confirmPass',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		]
	],
	'cardDetail' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		]
	],
	'monthlyMovements' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'filterMonth',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'filterYear',
			'rules' => 'trim|numeric|required'
		]
	],
	'downloadMoves' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'month',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'year',
			'rules' => 'trim|numeric|required'
		]
	],
	'temporaryLock' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'expireDate',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'status',
			'rules' => 'trim|alpha_numeric'
		]
	],
	'twirlsCommercial' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'expireDate',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'status',
			'rules' => 'trim|alpha_numeric'
		]
	],
	'transactionalLimits' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'expireDate',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'status',
			'rules' => 'trim|alpha_numeric'
		]
	],
	'replacement' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'expireDate',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'status',
			'rules' => 'trim|alpha_numeric'
		]
	],
	'userCardsList' => [
		[
			'field' => 'cardList',
			'rules' => 'trim|regex_match[/getCardList/]|required'
		]
	],
	'getBalance' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|required'
		],
		[
			'field' => 'userIdNumber',
			'rules' => 'trim|alpha_numeric|required'
		]
	],
	'getMovements' => [
		[
			'field' => 'cardNumber',
			'rules' => 'trim|regex_match[/^([a-zA-Z0-9=]+)+$/i]|required'
		],
		[
			'field' => 'cardNumberMask',
			'rules' => 'trim|regex_match[/^([0-9\*])+$/i]|required'
		],
		[
			'field' => 'prefix',
			'rules' => 'trim|alpha_numeric|required'
		],
		[
			'field' => 'status',
			'rules' => 'trim|alpha|required'
		],
		[
			'field' => 'action',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'initDate',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		],
		[
			'field' => 'finalDate',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]|required'
		]
	],
	'keepSession' => [
		[
			'field' => 'signout',
			'rules' => 'trim|alpha|required'
		]
	],
	'finishSession' => [
		[
			'field' => 'userName',
			'rules' => 'trim|regex_match[/^([\wñÑ]+)+$/i]|required'
		]
	],
	'getdetail' => [
		[
			'field' => 'request',
			'label' => 'request',
			'rules' => 'trim|required'
		],
		[
			'field' => 'plot',
			'label' => 'plot',
			'rules' => 'trim|required'
		]
	],
	'exporttopdf' => [
		[
			'field' => 'initialDate',
			'label' => 'initialDate',
			'rules' => 'required|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'finalDate',
			'label' => 'finalDate',
			'rules' => 'required|regex_match[/^[0-9\/]+$/]'
		]
	],
	'getexpenses' => [
		[
			'field' => 'fechaInicial',
			'label' => 'fechaInicial',
			'rules' => 'required|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'fechaFinal',
			'label' => 'fechaFinal',
			'rules' => 'required|regex_match[/^[0-9\/]+$/]'
		]
	],
	'updateprofile' => [
		[
			'field' => 'idType',
			'label' => 'idType',
			'rules' => 'required|trim'
		],
		[
			'field' => 'idNumber',
			'label' => 'idNumber',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'firstName',
			'label' => 'firstName',
			'rules' => 'required|trim'
		],
		[
			'field' => 'lastName',
			'label' => 'lastName',
			'rules' => 'required|trim'
		],
		[
			'field' => 'middleName',
			'label' => 'middleName',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]'
		],
		[
			'field' => 'secondSurname',
			'label' => 'secondSurname',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]'
		],
		[
			'field' => 'birthDate',
			'label' => 'birthDate',
			'rules' => 'required|trim|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'gender',
			'label' => 'gender',
			'rules' => 'required|trim'
		],
		[
			'field' => 'postalCode',
			'label' => 'postalCode',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'landLine',
			'label' => 'landLine',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'mobilePhone',
			'label' => 'mobilePhone',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'otherPhoneNum',
			'label' => 'otherPhoneNum',
			'rules' => 'numeric'
		],
		[
			'field' => 'email',
			'label' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		],
		[
			'field' => 'username',
			'label' => 'username',
			'rules' => 'required|trim'
		],
		[
			'field' => 'creationDate',
			'label' => 'creationDate',
			'rules' => 'required|trim|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'notificationsEmail',
			'label' => 'notificationsEmail',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'profession',
			'label' => 'profession',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'addressType',
			'label' => 'addressType',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'department',
			'label' => 'department',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'city',
			'label' => 'city',
			'rules' => 'required|trim|numeric'
		],
		[
			'field' => 'phoneType',
			'label' => 'phoneType',
			'rules' => 'trim'
		],
		[
			'field' => 'address',
			'label' => 'address',
			'rules' => 'required|trim'
		]
	],
	'getlistcitys' => [
		[
			'field' => 'codState',
			'label' => 'codState',
			'rules' => 'required|trim'
		]
	],
	'replace' => [
		[
			'field' => 'codeOTP',
			'label' => 'codeOTP',
			'rules' => 'regex_match[/^(\d{5})$/]|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'reasonRequest',
			'label' => 'reasonRequest',
			'rules' => 'required'
		],
	],
	'lock' => [
		[
			'field' => 'codeOTP',
			'label' => 'codeOTP',
			'rules' => 'regex_match[/^(\d{5})$/]|regex_match[/^[0-9\/]+$/]'
		],
	],
	'change' => [
		[
			'field' => 'pinCurrent',
			'label' => 'pinCurrent',
			'rules' => 'trim|numeric|regex_match[/^(\d{4})$/]'
		],
		[
			'field' => 'newPin',
			'label' => 'newPin',
			'rules' => 'trim|required|numeric|regex_match[/^(\d{4})$/]|differs[pinCurren]'
		],
		[
			'field' => 'confirmPin',
			'label' => 'confirmPin',
			'rules' => 'trim|required|numeric|regex_match[/^(\d{4})$/]|matches[newPin]'
		],
	],
	'generate' => [
		[
			'field' => 'newPin',
			'label' => 'newPin',
			'rules' => 'trim|required|numeric|regex_match[/^(\d{4})$/]'
		],
		[
			'field' => 'confirmPin',
			'label' => 'confirmPin',
			'rules' => 'trim|required|numeric|regex_match[/^(\d{4})$/]|matches[newPin]'
		],

	],
	'loadmovements' => [
		[
			'field' => 'noTarjeta',
			'label' => 'noTarjeta',
			'rules' => 'trim|required'
		],
		[
			'field' => 'month',
			'label' => 'month',
			'rules' => 'trim|required|numeric'
		],
		[
			'field' => 'year',
			'label' => 'year',
			'rules' => 'trim|required|numeric'
		]
	],
	'detailproduct' => [
		[
			'field' => 'nroTarjeta',
			'label' => 'nroTarjeta',
			'rules' => 'trim|required'
		],
		[
			'field' => 'noTarjetaConMascara',
			'label' => 'noTarjetaConMascara',
			'rules' => 'trim|required'
		],
		[
			'field' => 'prefix',
			'label' => 'prefix',
			'rules' => 'trim|required'
		],
	],
	'login' => [
		[
			'field' => 'user',
			'label' => 'user',
			'rules' => 'trim|regex_match[/^([\wñÑ*.\-]+)+$/i]|required'
		],
		[
			'field' => 'pass',
			'label' => 'pass',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|required'
		],
		[
			'field' => 'codeOTP',
			'label' => 'codeOTP',
			'rules' => 'trim|regex_match[/^[a-z0-9]+$/i]'
		],
		[
			'field' => 'saveIP',
			'label' => 'saveIP',
			'rules' => 'trim|numeric'
		]
	],
	'validatecaptcha' => [
		[
			'field' => 'user',
			'label' => 'user',
			'rules' => 'trim|regex_match[/^([\wñÑ.\-+&]+)+$/i]|required'
		],
		[
			'field' => 'token',
			'label' => 'token',
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
		],
		[
			'field' => 'userName',
			'label' => 'userName',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'nitBussines',
			'label' => 'nitBussines',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'telephone_number',
			'label' => 'telephone_number',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'codeTypeDocumentUser',
			'label' => 'codeTypeDocumentUser',
			'rules' => 'trim|required'
		],
		[
			'field' => 'abbrTypeDocumentUser',
			'label' => 'abbrTypeDocumentUser',
			'rules' => 'trim|required'
		],
		[
			'field' => 'codeTypeDocumentBussines',
			'label' => 'codeTypeDocumentBussines',
			'rules' => 'trim|required'
		],
		[
			'field' => 'abbrTypeDocumentBussines',
			'label' => 'abbrTypeDocumentBussines',
			'rules' => 'trim|required'
		]
	],
	'registry' => [
		[
			'field' => 'idType',
			'label' => 'idType',
			'rules' => 'trim|required'
		],
		[
			'field' => 'idNumber',
			'label' => 'idNumber',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'firstName',
			'label' => 'firstName',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]|required'
		],
		[
			'field' => 'middleName',
			'label' => 'middleName',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]'
		],
		[
			'field' => 'lastName',
			'label' => 'lastName',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]|required'
		],
		[
			'field' => 'secondSurname',
			'label' => 'secondSurname',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]'
		],
		[
			'field' => 'birthDate',
			'label' => 'birthDate',
			'rules' => 'trim|regex_match[/^[0-9\/]+$/]'
		],
		[
			'field' => 'email',
			'label' => 'email',
			'rules' => 'trim|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]|required'
		],
		[
			'field' => 'landLine',
			'label' => 'landLine',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'gender',
			'label' => 'gender',
			'rules' => 'trim|required'
		],
		[
			'field' => 'mobilePhone',
			'label' => 'mobilePhone',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'otherPhone',
			'label' => 'otherPhone',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'otherPhoneNum',
			'label' => 'otherPhoneNum',
			'rules' => 'trim|numeric'
		],
		[
			'field' => 'username',
			'label' => 'username',
			'rules' => 'trim|regex_match[/^([\wñÑ*.\-]+)+$/i]|required'
		],
		[
			'field' => 'userpwd',
			'label' => 'userpwd',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|required'
		],
		[
			'field' => 'confirmUserpwd',
			'label' => 'confirmUserpwd',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|matches[userpwd]|required'
		],
	],
	'recoveryaccess' => [
		[
			'field' => 'recovery',
			'label' => 'recovery',
			'rules' => 'trim|required'
		],
		[
			'field' => 'email',
			'email' => 'email',
			'rules' => 'trim|required|regex_match[/^([a-zA-Z]+[0-9_.+\-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/]'
		],
		[
			'field' => 'idNumber',
			'label' => 'idNumber',
			'rules' => 'trim|required|numeric'
		],
		[
			'field' => 'nitBussines',
			'label' => 'nitBussines',
			'rules' => 'trim|numeric|required'
		],
		[
			'field' => 'codeTypeDocumentUser',
			'label' => 'codeTypeDocumentUser',
			'rules' => 'trim|required'
		],
		[
			'field' => 'abbrTypeDocumentUser',
			'label' => 'abbrTypeDocumentUser',
			'rules' => 'trim|required'
		],
		[
			'field' => 'codeTypeDocumentBussines',
			'label' => 'codeTypeDocumentBussines',
			'rules' => 'trim|required'
		],
		[
			'field' => 'abbrTypeDocumentBussines',
			'label' => 'abbrTypeDocumentBussines',
			'rules' => 'trim|required'
		]
	],
	'closesession' => [
		[
			'field' => 'token',
			'label' => 'token',
			'rules' => 'trim|required'
		],
	],
	'changepassword' => [
		[
			'field' => 'currentPassword',
			'label' => 'currentPassword',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|required'
		],
		[
			'field' => 'newPassword',
			'label' => 'newPassword',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|differs[currentPassword]|required'
		],
		[
			'field' => 'confirmPassword',
			'label' => 'confirmPassword',
			'rules' => 'trim|regex_match[/^([\w!@\*\-\?¡¿+\/.,#]+)+$/i]|matches[newPassword]|required'
		]
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

	'detail-products' => [
		[
			'field' => 'numt',
			'label' => 'numt',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'prefix',
			'label' => 'prefix',
			'rules' => 'trim|regex_match[/^[\w\-]+$/i]|required'
		],
		[
			'field' => 'marca',
			'label' => 'marca',
			'rules' => 'trim|regex_match[/^([\w\-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]|required'
		],
		[
			'field' => 'empresa',
			'label' => 'empresa',
			'rules' => 'trim|regex_match[/^([\w\-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]|required'
		],
		[
			'field' => 'producto',
			'label' => 'producto',
			'rules' => 'trim|regex_match[/^([\w\-.,#ÑñáéíóúÑÁÉÍÓÚ]+[\s]*)+$/i]'
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
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
	],
	'movements' => [
		[
			'field' => 'card',
			'label' => 'card',
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
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
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
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
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
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
			'rules' => 'trim|regex_match[/^([\w=\/+\-]+)+$/i]|required'
		],
		[
			'field' => 'idpersona',
			'label' => 'idpersona',
			'rules' => 'trim|regex_match[/^([\w-]+)+$/i]|required'
		],
		[
			'field' => 'tipoConsulta',
			'label' => 'tipoConsulta',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]|required'
		],
		[
			'field' => 'producto',
			'label' => 'producto',
			'rules' => 'trim|regex_match[/^([\w\-]+)+$/i]|required'
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
