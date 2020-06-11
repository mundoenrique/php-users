'use strict'
function validateForms(form) {
	var validCountry = country;
	var onlyNumber = /^[0-9]{6,8}$/;
	var namesValid = /^([a-zñáéíóú.]+[\s]*)+$/i;
	var validNickName = /^(([a-z]{2,})+([a-z0-9_]){4,16})$/i;
	var regNumberValid = /^['a-z0-9']{6,45}$/i;
	var shortPhrase = /^['a-z0-9ñáéíóú ().']{4,25}$/i;
	var middlePhrase = /^['a-z0-9ñáéíóú ().']{5,45}$/i;
	var longPhrase = /^[a-z0-9ñáéíóú ]{3,70}$/i;
	var emailValid = /^([a-zA-Z]+[0-9_.+-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var alphanumunder = /^([\w.\-+&ñÑ ]+)+$/i;
	var alphanum = /^[a-z0-9]+$/i;
	var userPassword = validatePass;
	var numeric = /^[0-9]+$/;
	var phone = /^[0-9]{7,15}$/;
	var alphabetical = /^[a-z]+$/i;
	var text = /^['a-z0-9ñáéíóú ,.:()']+$/i;
	var usdAmount = /^[0-9]+(\.[0-9]*)?$/;
	var date = {
		dmy: /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/[0-9]{4}$/,
		my: /^(0?[1-9]|1[012])\/[0-9]{4}$/,
		y: /^[0-9]{4}$/,
	};
	var defaults = {
		debug: true,
		errorClass: lang.CONF_VALID_ERROR,
		validClass: lang.CONF_VALID_VALID,
		success: lang.CONF_VALID_SUCCESS,
		ignore: lang.CONF_VALID_IGNORE,
		errorElement: lang.CONF_VALID_ELEMENT
	};

	jQuery.validator.setDefaults(defaults);

	form.validate({
		focusInvalid: false,
		rules: {
			"userName":	{required: true, pattern: alphanumunder},
			"userPass": 	{verifyRequired: '#userName', verifyPattern: '#userName'},
			"recoveryAccess": 	{required: true},
			"email": 	{required: true, pattern: emailValid},
			"idNumber": 	{required: true, pattern: alphanum},
			"current-pass": {required: true},
			"new-pass": {required: true, differs: "#currentPass", validatePass: true},
			"confirm-pass": {required: true, equalTo: "#newPass"},
			"confirm-pass": {required: true, equalTo: "#newPass"},
			"filterMonth": {required: true, pattern: numeric},
			"filterYear": {required: true, pattern: numeric},
			"numberCard": {required: true, pattern: numeric, maxlength: 16},
			"docmentId": {required: true, pattern: alphanum},
			"secretPassword": {required: true, pattern: numeric},
			"acceptTerms": {required: true},
			"nickName": {required: true, pattern: validNickName, differs: "#idNumber", dbAvailable: true},
			"middleName": {pattern: longPhrase},
			"secondSurname": {pattern: longPhrase},
			"birthDate": {required: true, pattern: date.dmy},
			"gender": {required: true},
			"confirmEmail": {required: true, equalTo: "#email"},
			"landLine": {pattern: phone},
			"mobilePhone": {required: true, pattern: phone},
			"otherPhoneNum": {
				required: {
					depends: function (element) {
						return $('#phoneType').val() != ''
					}
				},
				pattern: phone
			}
		},
		messages: {
			"userName": lang.VALIDATE_USERLOGIN,
			"userPass": {
				verifyRequired: lang.VALIDATE_USERPASS_REQ,
				verifyPattern: lang.VALIDATE_USERPASS_PATT,
			},
			"recoveryAccess": lang.VALIDATE_RECOVER_OPTION,
			"email": lang.VALIDATE_EMAIL,
			"idNumber": lang.VALIDATE_ID_NUMBER,
			"current-pass": lang.VALIDATE_CURRENT_PASS,
			"new-pass": {
				required: lang.VALIDATE_NEW_PASS,
				differs: lang.VALIDATE_DIFFERS_PASS,
				validatePass: lang.VALIDATE_REQUIREMENTS_PASS
			},
			"confirm-pass": {
				required: lang.VALIDATE_CONFIRM_PASS,
				equalTo: lang.VALIDATE_IQUAL_PASS
			},
			"filterYear": 'Selecciona un año',
			"numberCard": 'Indica el número de tu tarjeta',
			"docmentId": 'Indica el número de tu CURO',
			"secretPassword": 'Indica el PIN de tu tarjeta',
			"acceptTerms": 'Debes aceptar los términos de uso',
			"nickName": {
				required: lang.VALIDATE_NICK_REQ,
				pattern: lang.VALIDATE_NICK_PATT,
				differs: lang.VALIDATE_NICK_DIFFER,
				dbAvailable: 'Usuario no disponible, intenta con otro',
			},
			"middleName": 'Indica tu segundo nombre',
			"secondSurname": 'Indica tu segundo apellido',
			"birthDate": 'Indica tu fecha de cunpleaños',
			"gender": 'indica tu genero',
			"confirmEmail": 'debe ser igual a tu correo',
			"landLine": 'Indica un telefono válido min 7 max 15',
			"mobilePhone": 'Indica un movil válido min 7 max 15',
			"otherPhoneNum": 'Indica un telefono válido min 7 max 15',
		},
		errorPlacement: function(error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		}
	});

	$.validator.methods.verifyRequired = function(value, element, param) {
		return value != '' && $(param).val() != '';
	}

	$.validator.methods.verifyPattern = function(value, element, param) {
		return userPassword.test(value) && alphanumunder.test($(param).val());
	}

	$.validator.methods.differs = function(value, element, param) {
		var target = $(param);
		return value !== target.val();
	}

	$.validator.methods.validatePass = function(value, element, param) {
		return passStrength(value);
	}

	$.validator.methods.dbAvailable = function(value, element, param) {
		return $(element).hasClass('available');
	}

	form.validate().resetForm();
}
