'use strict'
function validateForms(form) {
	formInputTrim(form);
	var validCountry = country;
	var onlyNumber = /^[0-9]{3,20}$/;
	var onlyOneNumber = /^[0-9]{1}$/;
	var onlyOneLetter = /^[SCV]{1}$/;
	var namesValid = /^([a-zñáéíóú.]+[\s]*)+$/i;
	var validNickName = new RegExp(lang.VALIDATE_REGEX_NICKNAME, 'i');
	var regNumberValid = /^['a-z0-9']{6,45}$/i;
	var shortPhrase = /^['a-z0-9ñáéíóú ().']{4,25}$/i;
	var middlePhrase = /^['a-z0-9ñáéíóú ().']{5,45}$/i;
	var longPhrase = /^[a-z0-9ñáéíóú ().,;-]{5,150}$/i;
	var alphaName = /^[a-zñáéíóú ]{1,50}$/i;
	var alphaLetter = /^[a-zñáéíóú]{4,20}$/i;
	var emailValid = /^([\.0-9a-zA-Z_\-])+\@(([\.0-9a-zA-Z\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var alphanumunder = /^([\w.\-+&ñÑ\@\* ]+)+$/i;
	var alphanum = /^[a-z0-9]+$/i;
	var userPassword = validatePass;
	var numeric = /^[0-9]+$/;
	var phone = lang.CONF_ACCEPT_MASKED_PHONES == 'OFF' ? new RegExp(lang.VALIDATE_MOBIL, 'i') : new RegExp(lang.VALIDATE_MOBIL_MASKED, 'i');
	var alphabetical = /^[a-z]+$/i;
	var text = /^['a-z0-9ñáéíóú ,.:()']+$/i;
	var floatAmount = new RegExp(lang.VALIDATE_FLOAT_AMOUNT, 'i');
	var validCode = /^[a-z0-9]+$/i;
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
			"userName": { required: true, pattern: alphanumunder },
			"userPass": { verifyRequired: '#userName', verifyPattern: '#userName' },
			"otpCode": { required: true, pattern: alphanum },
			"recoveryAccess": { required: true },
			"email": { required: true, pattern: emailValid },
			"idNumber": { required: true, pattern: alphanum },
			"currentPass": { required: true },
			"newPass": { required: true, differs: "#currentPass", validatePass: true },
			"confirmPass": { required: true, equalTo: "#newPass" },
			"filterMonth": { required: true, pattern: numeric },
			"filterYear": { required: true, pattern: numeric },
			"numberCard": { required: true, pattern: numeric, maxlength: 16 },
			"documentId": { required: true, pattern: alphanum },
			"cardPIN": { required: true, pattern: numeric },
			"codeOTP": { required: true, pattern: validCode, maxlength: 8 },
			"acceptTerms": { required: true },
			"nickName": { required: true, pattern: validNickName, differs: lang.VALIDATE_NICK_DIFFER, dbAvailable: true },
			"firstName": { required: true, pattern: alphaName },
			"middleName": { pattern: alphaName },
			"lastName": { required: true, pattern: alphaName },
			"surName": { pattern: alphaName },
			"birthDate": { required: true, pattern: date.dmy },
			"nationality": { required: true, pattern: alphaLetter, minlength: 4, maxlength: 20 },
			"birthPlace": { pattern: alphaLetter, minlength: 4, maxlength: 20 },
			"civilStatus": { pattern: onlyOneLetter },
			"addressType": { required: true, requiredSelect: true },
			"postalCode": { pattern: onlyNumber },
			"state": { required: true, requiredSelect: true },
			"city": { required: true, requiredSelect: true },
			"address": { required: true, pattern: longPhrase },
			"verifierCode": { required: true, pattern: onlyOneNumber, matchVerifierCode: true },
			"gender": { required: true },
			"confirmEmail": { required: true, pattern: emailValid, equalTo: "#email" },
			"landLine": { pattern: phone, differs: "#mobilePhone", differs: "#otherPhoneNum" },
			"mobilePhone": { required: true, pattern: phone, differs: "#landLine", differs: "#otherPhoneNum" },
			"otherPhoneNum": {
				required: {
					depends: function (element) {
						return $('#phoneType').val() != ''
					}
				},
				pattern: phone,
				differs: "#mobilePhone",
				differs: "#landLine"
			},
			"workplace": { required: true, pattern: alphaName },
			"profession": { required: true, requiredSelect: true },
			"laborOld": { required: true, requiredSelect: true },
			"position": { pattern: namesValid },
			"averageIncome": { pattern: floatAmount, maxlength: 9 },
			"publicOfficeOld": { required: true },
			"publicOffice": {
				required: {
					depends: function (element) {
						return $('#yesPublicOfficeOld').is(':checked');
					}
				}, pattern: shortPhrase },
			"publicInst": {
				required: {
					depends: function (element) {
						return $('#yesPublicOfficeOld').is(':checked');
					}
				}, pattern: shortPhrase },
			"taxesObligated": { required: true },
			"protection": { required: true },
			"contract": { required: true },
			"initDate": { required: true, pattern: date.dmy },
			"finalDate": { required: true, pattern: date.dmy },
			"replaceMotSol": { requiredSelect: true},
			"temporaryLockReason": { requiredSelect: true},
			"currentPin": { required: true, pattern: numeric, maxlength: 4 },
			"newPin": { required: true, pattern: numeric, maxlength: 4, differs: "#currentPin", fourConsecutivesDigits: true },
			"confirmPin": { required: true, equalTo: "#newPin" },
			"generateNewPin": { required: true, pattern: numeric, maxlength: 4, fourConsecutivesDigits: true },
			"generateConfirmPin": { required: true, equalTo: "#generateNewPin" },
			"typeDocument": { requiredSelect: true, },
			"SEL_A":	{required: true, extension: lang.VALIDATE_FILES_EXT, filesize: true},
			"INE_A":	{required: true, extension: lang.VALIDATE_FILES_EXT, filesize: true},
			"INE_R":	{required: true, extension: lang.VALIDATE_FILES_EXT, filesize: true},
			"PASS_A":	{required: true, extension: lang.VALIDATE_FILES_EXT, filesize: true},
			"PASS_R":	{required: true, extension: lang.VALIDATE_FILES_EXT, filesize: true},
		},
		messages: {
			"userName": lang.VALIDATE_USERLOGIN,
			"userPass": {
				verifyRequired: lang.VALIDATE_USERPASS_REQ,
				verifyPattern: lang.VALIDATE_USERPASS_PATT,
			},
			"otpCode": lang.VALIDATE_OTP_CODE,
			"typeDocument": lang.VALIDATE_TYPE_DOCUMENT,
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
			"documentId": lang.VALIDATE_DOCUMENT_ID,
			"cardPIN": lang.VALIDATE_CARD_PIN,
			"codeOTP": {
				required: lang.VALIDATE_CODE_RECEIVED,
				pattern: lang.VALIDATE_INVALID_FORMAT,
				maxlength: lang.VALIDATE_INVALID_FORMAT
			},
			"acceptTerms": lang.VALIDATE_ACCEPT_TERMS,
			"nickName": {
				required: lang.VALIDATE_NICK_REQ,
				pattern: lang.VALIDATE_NICK_PATT,
				differs: lang.VALIDATE_NICK_DIFFER_TEXT,
				dbAvailable: lang.VALIDATE_AVAILABLE_NICKNAME,
			},
			"firstName": lang.VALIDATE_FIRST_NAME,
			"lastName": lang.VALIDATE_LAST_NAME,
			"middleName": lang.VALIDATE_MIDDLE_NAME,
			"surName": lang.VALIDATE_SUR_NAME,
			"birthDate": lang.VALIDATE_BIRTHDATE,
			"nationality": lang.VALIDATE_NATIONALITY,
			"birthPlace": lang.VALIDATE_BIRTHPLACE,
			"civilStatus": lang.VALIDATE_RECOVER_OPTION,
			"addressType": lang.VALIDATE_RECOVER_OPTION,
			"postalCode": lang.VALIDATE_POSTAL_CODE,
			"state": lang.VALIDATE_RECOVER_OPTION,
			"city": lang.VALIDATE_RECOVER_OPTION,
			"address": lang.VALIDATE_ADDRESS,
			"verifierCode": lang.VALIDATE_VERIFIER_CODE,
			"gender": lang.VALIDATE_GENDER,
			"confirmEmail": {
				required: lang.VALIDATE_EMAIL,
				pattern: lang.VALIDATE_EMAIL,
				equalTo: lang.VALIDATE_CONFIRM_EMAIL,
			},
			"landLine": {
				pattern: lang.VALIDATE_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			"mobilePhone": {
				pattern: lang.VALIDATE_MOBIL_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			"otherPhoneNum": {
				pattern: lang.VALIDATE_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			"workplace": lang.VALIDATE_WORKPLACE,
			"profession": lang.VALIDATE_RECOVER_OPTION,
			"laborOld": lang.VALIDATE_RECOVER_OPTION,
			"position": lang.VALIDATE_POSITION,
			"averageIncome": lang.VALIDATE_AVERAGE_INCOME,
			"publicOfficeOld": lang.VALIDATE_RECOVER_OPTION,
			"publicOffice": lang.VALIDATE_SHORT_PHRASE,
			"publicInst": lang.VALIDATE_SHORT_PHRASE,
			"taxesObligated": lang.VALIDATE_RECOVER_OPTION,
			"protection": lang.VALIDATE_PROTECTION,
			"contract": lang.VALIDATE_CONTRACT,
			"initDate": lang.VALIDATE_DATE_DMY,
			"finalDate": lang.VALIDATE_DATE_DMY,
			"replaceMotSol": lang.VALIDATE_REPLACE_REASON,
			"temporaryLockReason": lang.VALIDATE_TEMPORARY_LOCK_REASON,
			"currentPin": {
				required: lang.VALIDATE_CURRENT_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				maxlength: lang.VALIDATE_FORMAT_PIN,
			},
			"newPin": {
				required: lang.VALIDATE_NEW_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				maxlength: lang.VALIDATE_FORMAT_PIN,
				differs: lang.VALIDATE_DIFFERS_PIN,
				fourConsecutivesDigits: lang.VALIDATE_CONSECUTIVE_NUMS
			},
			"confirmPin": {
				required: lang.VALIDATE_CONFIRM_PIN,
				equalTo: lang.VALIDATE_IQUAL_PIN
			},
			"generateNewPin": {
				required: lang.VALIDATE_NEW_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				maxlength: lang.VALIDATE_FORMAT_PIN,
				differs: lang.VALIDATE_DIFFERS_PIN,
				fourConsecutivesDigits: lang.VALIDATE_CONSECUTIVE_NUMS
			},
			"generateConfirmPin": {
				required: lang.VALIDATE_CONFIRM_PIN,
				equalTo: lang.VALIDATE_IQUAL_PIN
			},
			"SEL_A": {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE
			},
			"INE_A": {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE
			},
			"INE_R": {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE
			},
			"PASS_A": {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE
			},
			"PASS_R": {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE
			},
		},
		errorPlacement: function (error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		}
	});

	$.validator.methods.verifyRequired = function (value, element, param) {
		return value != '' && $(param).val() != '';
	}

	$.validator.methods.verifyPattern = function (value, element, param) {
		return userPassword.test(value) && alphanumunder.test($(param).val());
	}

	$.validator.methods.differs = function (value, element, param) {
		var target = $(param);
		return value !== target.val();
	}

	$.validator.methods.validatePass = function (value, element, param) {
		return passStrength(value);
	}

	$.validator.methods.dbAvailable = function (value, element, param) {
		return $(element).hasClass('available');
	}

	$.validator.methods.requiredSelect = function (value, element, param) {
		var valid = true;

		if ($(element).find('option').length > 0) {
			valid = alphanumunder.test($(element).find('option:selected').val().trim());
		}

		return valid
	}

	$.validator.methods.fourConsecutivesDigits = function (value, element, param) {
		return !value.match(/(0123|1234|2345|3456|4567|5678|6789|9876|8765|7654|6543|5432|4321|3210)/);
	}

	$.validator.methods.matchVerifierCode = function (value, element, param) {
		var valid = true;
		if (CurrentVerifierCode != '') {
			valid = value == CurrentVerifierCode;
		}

		return valid
	}

	$.validator.methods.filesize = function (value, element, param) {
		var maxSize = parseInt(lang.CONF_CONFIG_UPLOAD_FILE.max_size) * 1024
		var minSize = parseInt(lang.CONF_CONFIG_UPLOAD_FILE.min_size) * 1024

		return element.files[0].size <= maxSize && element.files[0].size >= minSize;
	}

	form.validate().resetForm();
}
