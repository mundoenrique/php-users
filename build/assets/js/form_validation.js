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
	var alphaName = /^[a-zñáéíóú ]{1,70}$/i;
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
			"currentPass": {required: true},
			"newPass": {required: true, differs: "#currentPass", validatePass: true},
			"confirmPass": {required: true, equalTo: "#newPass"},
			"confirmPass": {required: true, equalTo: "#newPass"},
			"filterMonth": {required: true, pattern: numeric},
			"filterYear": {required: true, pattern: numeric},
			"numberCard": {required: true, pattern: numeric, maxlength: 16},
			"docmentId": {required: true, pattern: alphanum},
			"cardPIN": {required: true, pattern: numeric},
			"acceptTerms": {required: true},
			"nickName": {required: true, pattern: validNickName, differs: "#idNumber", dbAvailable: true},
			"middleName": {pattern: alphaName},
			"surName": {pattern: alphaName},
			"birthDate": {required: true, pattern: date.dmy},
			"gender": {required: true},
			"confirmEmail": {required: true, pattern: emailValid, equalTo: "#email"},
			"landLine": {pattern: phone},
			"mobilePhone": {required: true, pattern: phone},
			"otherPhoneNum": {
				required: {
					depends: function (element) {
						return $('#phoneType').val() != ''
					}
				},
				pattern: phone
			},
			"initDate": { required: true, pattern: date.dmy },
			"finalDate": { required: true, pattern: date.dmy },
			"replaceMotSol": { requiredSelect: true },
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
			"currentPass": lang.VALIDATE_CURRENT_PASS,
			"newPass": {
				required: lang.VALIDATE_NEW_PASS,
				differs: lang.VALIDATE_DIFFERS_PASS,
				validatePass: lang.VALIDATE_REQUIREMENTS_PASS
			},
			"confirmPass": {
				required: lang.VALIDATE_CONFIRM_PASS,
				equalTo: lang.VALIDATE_IQUAL_PASS
			},
			"filterYear": lang.VALIDATE_FILTER_YEAR,
			"numberCard": lang.VALIDATE_NUMBER_CARD,
			"docmentId": lang.VALIDATE_DOCUMENT_ID,
			"cardPIN": lang.VALIDATE_CARD_PIN,
			"acceptTerms": lang.VALIDATE_ACCEPT_TERMS,
			"nickName": {
				required: lang.VALIDATE_NICK_REQ,
				pattern: lang.VALIDATE_NICK_PATT,
				differs: lang.VALIDATE_NICK_DIFFER,
				dbAvailable: lang.VALIDATE_AVAILABLE_NICKNAME,
			},
			"middleName": lang.VALIDATE_MIDDLE_NAME,
			"surName": lang.VALIDATE_SUR_NAME,
			"birthDate": lang.VALIDATE_BIRTHDATE,
			"gender": lang.VALIDATE_GENDER,
			"confirmEmail": {
				required: lang.VALIDATE_EMAIL,
				pattern: lang.VALIDATE_EMAIL,
				equalTo: lang.VALIDATE_CONFIRM_EMAIL,
			},
			"landLine": lang.VALIDATE_PHONE,
			"mobilePhone": lang.VALIDATE_MOBIL_PHONE,
			"otherPhoneNum": lang.VALIDATE_PHONE,
			"initDate": lang.VALIDATE_DATE_DMY,
			"finalDate": lang.VALIDATE_DATE_DMY,
			"replaceMotSol": lang.VALIDATE_REPLACE_REASON,
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

	$.validator.methods.requiredSelect = function (value, element, param) {
		var valid = true;

		if ($(element).find('option').length > 0) {
			valid = alphanumunder.test($(element).find('option:selected').val().trim());
		}

		return valid
	}

	form.validate().resetForm();
}
