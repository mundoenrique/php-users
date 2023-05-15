"use strict";
var validator;

function validateForms(form) {
	formInputTrim(form);

	var onlyNumber = new RegExp(lang.REGEX_ONLY_NUMBER);
	var onlyOneNumber = new RegExp(lang.REGEX_ONLY_ONE_NUMBER);
	var onlyOneLetter = new RegExp(lang.REGEX_ONLY_ONE_LETTER);
	var namesValid = new RegExp(lang.REGEX_NAMES_VALID, "i");
	var validNickName = new RegExp(lang.REGEX_NICKNAME, "i");
	var validNickNameProfile = new RegExp(lang.REGEX_NICKNAME_PROFILE, "i");
	var shortPhrase = new RegExp(lang.REGEX_SHORT_PHRASE, "i");
	var longPhrase = new RegExp(lang.REGEX_LONG_PHRASE, "i");
	var alphaName = new RegExp(lang.REGEX_ALPHA_NAME, "i");
	var alphaLetter = new RegExp(lang.REGEX_ALPHA_LETTER, "i");
	var emailValid = new RegExp(lang.REGEX_EMAIL_VALID);
	var alphanumunder = new RegExp(lang.REGEX_ALPHANUM_UNDER, "i");
	var alphanum = new RegExp(lang.REGEX_ALPHANUM, "i");
	var maxlengthDocId = parseInt(lang.REGEX_MAXLENGTH_DOC_ID);
	var minlengthDocId = parseInt(lang.REGEX_MINLENGTH_DOC_ID);
	var userPassword = validatePass;
	var numeric = new RegExp(lang.REGEX_NUMERIC);
	var twoFactor = new RegExp(lang.REGEX_TWO_FACTOR);
	var phone = new RegExp(lang.REGEX_PHONE, "i");
	var phoneMasked = new RegExp(lang.REGEX_PHONE_MASKED, "i");
	var floatAmount = new RegExp(lang.REGEX_FLOAT_AMOUNT, "i");
	var transType = new RegExp(lang.REGEX_TRANS_TYPE);
	var docType = new RegExp(lang.REGEX_DOC_TYPE);
	var destInstrument = new RegExp(lang.REGEX_DESTINATION_INSTRUMENT);
	var checkedOption = new RegExp(lang.REGEX_CHECKED);
	var titleCredencial = lang.GEN_PASSWORD.toLowerCase();
	var date = {
		dmy: new RegExp(lang.REGEX_DATE_DMY),
		my: new RegExp(lang.REGEX_DATE_MY),
		y: new RegExp(lang.REGEX_DATE_Y),
	};
	var intCode = new RegExp(lang.REGEX_INT_CODE);
	var defaults = {
		debug: true,
		errorClass: lang.SETT_VALID_ERROR,
		validClass: lang.SETT_VALID_VALID,
		success: lang.SETT_VALID_SUCCESS,
		ignore: lang.SETT_VALID_IGNORE,
		errorElement: lang.SETT_VALID_ELEMENT,
	};

	$.each(lang.GEN_TITLE_PASS_FORM, function (key, val) {
		if ($(form).attr("id") === key) {
			titleCredencial = val.toLowerCase();
		}
		return titleCredencial;
	});

	jQuery.validator.setDefaults(defaults);

	validator = form.validate({
		focusInvalid: false,
		rules: {
			userName: { required: true, pattern: alphanumunder },
			userPass: { verifyRequired: "#userName", verifyPattern: "#userName" },
			otpCode: { required: true, pattern: alphanum },
			recoveryAccess: { required: true },
			twoFactorEnablement: { required: true },
			authenticationCode: { required: true, pattern: twoFactor },
			email: { required: true, pattern: emailValid },
			idNumber: {
				required: true,
				validateIdNumberVE: {
					param: { minlength: minlengthDocId, maxlength: maxlengthDocId },
				},
			},
			currentPass: { required: true },
			newPass: { required: true, differs: "#currentPass", validatePass: true },
			confirmPass: { required: true, equalTo: "#newPass" },
			filterMonth: { required: true, pattern: numeric },
			filterYear: { required: true, pattern: numeric },
			filterInputYear: { required: true, pattern: date.my },
			filterHistoryDate: { required: true, pattern: date.my },
			numberCard: { required: true, pattern: numeric, maxlength: 16 },
			documentId: {
				required: true,
				validateDocumentId: true,
				maxlength: maxlengthDocId,
			},
			cardPIN: { required: true, pattern: numeric },
			codeOTP: { required: true, pattern: alphanum, maxlength: 8 },
			acceptTerms: { required: true },
			nickName: {
				required: true,
				pattern: validNickName,
				differs: lang.VALIDATE_NICK_DIFFER,
				dbAvailable: true,
			},
			nickNameProfile: {
				required: true,
				pattern: validNickNameProfile,
				differs: lang.VALIDATE_NICK_DIFFER,
				dbAvailable: true,
			},
			firstName: { required: true, pattern: alphaName },
			middleName: { pattern: alphaName },
			lastName: { required: true, pattern: alphaName },
			surName: { pattern: alphaName },
			birthDate: { required: true, pattern: date.dmy },
			nationality: {
				required: true,
				pattern: alphaLetter,
				minlength: 4,
				maxlength: 20,
			},
			birthPlace: { pattern: alphaLetter, minlength: 4, maxlength: 20 },
			civilStatus: { pattern: onlyOneLetter },
			country: { required: true, requiredSelect: true },
			addressType: { required: true, requiredSelect: true },
			postalCode: { pattern: onlyNumber },
			state: { required: true, requiredSelect: true },
			stateInput: { required: true, pattern: alphanumunder },
			city: { required: true, requiredSelect: true },
			cityInput: { required: true, pattern: alphanumunder },
			district: { required: true, requiredSelect: true },
			districtInput: { required: true, pattern: alphanumunder },
			notificationType: { required: true, requiredSelect: true },
			address: { required: true, pattern: longPhrase },
			verifierCode: {
				required: true,
				pattern: onlyOneNumber,
				matchVerifierCode: true,
			},
			gender: { required: true },
			channel: { pattern: alphanumunder },
			confirmEmail: { required: true, pattern: emailValid, equalTo: "#email" },
			landLine: {
				pattern:
					lang.SETT_ACCEPT_MASKED_LANDLINE == "OFF" ? phone : phoneMasked,
				differs: ["#mobilePhone", "#otherPhoneNum"],
			},
			mobilePhone: {
				required: dependsMobilePhone,
				pattern: {
					param: lang.SETT_ACCEPT_MASKED_MOBILE == "OFF" ? phone : phoneMasked,
					depends: function (element) {
						return $(element).val() != "";
					},
				},
				differs: ["#landLine", "#otherPhoneNum"],
			},
			internationalCode: { required: true, pattern: intCode },
			otherPhoneNum: {
				required: {
					depends: function (element) {
						return $("#phoneType").val() != "";
					},
				},
				pattern: phone,
				differs: ["#mobilePhone", "#landLine"],
			},
			workplace: { required: true, pattern: alphaName },
			profession: { required: true, requiredSelect: true },
			laborOld: { required: true, requiredSelect: true },
			position: { pattern: namesValid },
			averageIncome: { pattern: floatAmount, maxlength: 9 },
			publicOfficeOld: { required: true },
			publicOffice: {
				required: {
					depends: function (element) {
						return $("#yesPublicOfficeOld").is(":checked");
					},
				},
				pattern: shortPhrase,
			},
			publicInst: {
				required: {
					depends: function (element) {
						return $("#yesPublicOfficeOld").is(":checked");
					},
				},
				pattern: shortPhrase,
			},
			taxesObligated: { required: true },
			protection: { required: true },
			contract: { required: true },
			initDate: { required: true, pattern: date.dmy },
			finalDate: { required: true, pattern: date.dmy },
			replaceMotSol: { requiredSelect: true },
			temporaryLockReason: { requiredSelect: true },
			bank: {
				required: true,
				requiredSelect: true,
				digits: true,
				exactLength: 4,
			},
			beneficiary: { required: true, pattern: alphaName, minlength: 3 },
			destinationCard: {
				required: true,
				destinationCard: { pattern: numeric, length: 16 },
			},
			destinationInstrument: { required: true, pattern: destInstrument },
			destinationAccount: {
				required: dependsDestinationAccount,
				destinationAccount: {
					param: { pattern: numeric, length: 20 },
					depends: function (element) {
						return $(element).val() != "";
					},
				},
				accountMatchBank: {
					depends: function (element) {
						return $(element).val() != "";
					},
				},
			},
			beneficiaryEmail: { pattern: emailValid },
			amount: { required: true, pattern: floatAmount, maxlength: 16 },
			concept: { pattern: alphanumunder },
			expDateCta: { required: true, pattern: date.my },
			currentPin: { required: true, pattern: numeric, exactLength: 4 },
			newPin: {
				required: true,
				pattern: numeric,
				exactLength: 4,
				differs: "#currentPin",
				fourConsecutivesDigits: true,
			},
			confirmPin: { required: true, equalTo: "#newPin" },
			generateNewPin: {
				required: true,
				pattern: numeric,
				exactLength: 4,
				fourConsecutivesDigits: true,
			},
			generateConfirmPin: { required: true, equalTo: "#generateNewPin" },
			typeDocument: { requiredSelect: true, pattern: docType },
			SEL_A: {
				required: true,
				extension: lang.VALIDATE_FILES_EXT,
				filesize: true,
			},
			INE_A: {
				required: true,
				extension: lang.VALIDATE_FILES_EXT,
				filesize: true,
			},
			INE_R: {
				required: true,
				extension: lang.VALIDATE_FILES_EXT,
				filesize: true,
			},
			PASS_A: {
				required: true,
				extension: lang.VALIDATE_FILES_EXT,
				filesize: true,
			},
			PASS_R: {
				required: true,
				extension: lang.VALIDATE_FILES_EXT,
				filesize: true,
			},
			transType: { pattern: transType },
			notify: { pattern: checkedOption },
		},
		messages: {
			userName: lang.VALIDATE_USERLOGIN,
			userPass: {
				verifyRequired: lang.VALIDATE_USERPASS_REQ,
				verifyPattern: lang.VALIDATE_USERPASS_PATT,
			},
			otpCode: lang.VALIDATE_OTP_CODE,
			typeDocument: lang.VALIDATE_TYPE_DOCUMENT,
			recoveryAccess: lang.VALIDATE_RECOVER_OPTION,
			twoFactorEnablement: lang.VALIDATE_RECOVER_OPTION,
			authenticationCode: {
				required: lang.VALIDATE_REQUIRED_TWO_FACTOR,
				pattern: lang.VALIDATE_TWO_FACTOR_PATT,
			},
			email: lang.VALIDATE_EMAIL,
			idNumber: {
				required: lang.VALIDATE_ID_NUMBER,
				validateIdNumberVE: function () {
					var typeDoc = form.find("#typeDocument option:selected").val();
					return typeDoc == "P"
						? lang.VALIDATE_PASSPORT_FORMAT
						: lang.VALIDATE_ID_NUMBER_FORMAT;
				},
			},
			currentPass: lang.VALIDATE_CURRENT_PASS.replace("%s", titleCredencial),
			newPass: {
				required: lang.VALIDATE_NEW_PASS.replace("%s", titleCredencial),
				differs: lang.VALIDATE_DIFFERS_PASS.replace("%s", titleCredencial),
				validatePass: lang.VALIDATE_REQUIREMENTS_PASS.replace(
					"%s",
					titleCredencial
				),
			},
			confirmPass: {
				required: lang.VALIDATE_CONFIRM_PASS.replace("%s", titleCredencial),
				equalTo: lang.VALIDATE_IQUAL_PASS.replace("%s", titleCredencial),
			},
			filterYear: lang.VALIDATE_FILTER_YEAR,
			filterInputYear: lang.VALIDATE_DATE_MY,
			filterHistoryDate: lang.VALIDATE_DATE_MY,
			numberCard: {
				required: lang.VALIDATE_NUMBER_CARD,
				pattern: lang.VALIDATE_INVALID_FORMAT
			},
			documentId: {
				required: lang.VALIDATE_DOCUMENT_ID,
				validateDocumentId: lang.VALIDATE_INVALID_FORMAT_DOCUMENT_ID,
				maxlength: lang.VALIDATE_MAX_NUMBER.replace("%s", lang.REGEX_MAXLENGTH_DOC_ID)
			},
			cardPIN: {
				required: lang.VALIDATE_CARD_PIN,
				pattern: lang.VALIDATE_INVALID_FORMAT
			},
			codeOTP: {
				required: lang.VALIDATE_CODE_RECEIVED,
				pattern: lang.VALIDATE_INVALID_FORMAT,
				maxlength: lang.VALIDATE_INVALID_FORMAT,
			},
			acceptTerms: lang.VALIDATE_ACCEPT_TERMS,
			nickName: {
				required: lang.VALIDATE_NICK_REQ,
				pattern: lang.VALIDATE_NICK_PATT,
				differs: lang.VALIDATE_NICK_DIFFER_TEXT,
				dbAvailable: lang.VALIDATE_AVAILABLE_NICKNAME,
			},
			nickNameProfile: {
				required: lang.VALIDATE_NICK_REQ,
				pattern: lang.VALIDATE_NICK_PATT,
				differs: lang.VALIDATE_NICK_DIFFER_TEXT,
				dbAvailable: lang.VALIDATE_AVAILABLE_NICKNAME,
			},
			firstName: lang.VALIDATE_FIRST_NAME,
			lastName: lang.VALIDATE_LAST_NAME,
			middleName: lang.VALIDATE_MIDDLE_NAME,
			surName: lang.VALIDATE_SUR_NAME,
			birthDate: lang.VALIDATE_BIRTHDATE,
			nationality: lang.VALIDATE_NATIONALITY,
			birthPlace: lang.VALIDATE_BIRTHPLACE,
			civilStatus: lang.VALIDATE_RECOVER_OPTION,
			addressType: lang.VALIDATE_RECOVER_OPTION,
			country: lang.VALIDATE_RECOVER_OPTION,
			postalCode: lang.VALIDATE_POSTAL_CODE,
			state: lang.VALIDATE_RECOVER_OPTION,
			stateInput: lang.VALIDATE_STATE,
			city: lang.VALIDATE_RECOVER_OPTION,
			cityInput: lang.VALIDATE_CITY,
			district: lang.VALIDATE_RECOVER_OPTION,
			districtInput: lang.VALIDATE_SECTOR,
			notificationType: lang.VALIDATE_RECOVER_OPTION,
			address: lang.VALIDATE_ADDRESS,
			verifierCode: lang.VALIDATE_VERIFIER_CODE,
			gender: lang.VALIDATE_GENDER,
			confirmEmail: {
				required: lang.VALIDATE_EMAIL,
				pattern: lang.VALIDATE_EMAIL,
				equalTo: lang.VALIDATE_CONFIRM_EMAIL,
			},
			landLine: {
				pattern: lang.VALIDATE_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			mobilePhone: {
				required: lang.VALIDATE_MOBIL_PHONE,
				pattern: lang.VALIDATE_MOBIL_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			internationalCode: lang.VALIDATE_INT_CODE,
			otherPhoneNum: {
				required: lang.VALIDATE_REQUIRED_PHONE,
				pattern: lang.VALIDATE_PHONE,
				differs: lang.VALIDATE_DIFFERS_PHONE,
			},
			workplace: lang.VALIDATE_WORKPLACE,
			profession: lang.VALIDATE_RECOVER_OPTION,
			laborOld: lang.VALIDATE_RECOVER_OPTION,
			position: lang.VALIDATE_POSITION,
			averageIncome: lang.VALIDATE_AVERAGE_INCOME,
			publicOfficeOld: lang.VALIDATE_RECOVER_OPTION,
			publicOffice: lang.VALIDATE_SHORT_PHRASE,
			publicInst: lang.VALIDATE_SHORT_PHRASE,
			taxesObligated: lang.VALIDATE_RECOVER_OPTION,
			protection: lang.VALIDATE_PROTECTION,
			contract: lang.VALIDATE_CONTRACT,
			initDate: lang.VALIDATE_DATE_DMY,
			finalDate: lang.VALIDATE_DATE_DMY,
			replaceMotSol: lang.VALIDATE_REPLACE_REASON,
			temporaryLockReason: lang.VALIDATE_TEMPORARY_LOCK_REASON,
			bank: lang.VALIDATE_BANK,
			beneficiary: {
				required: lang.VALIDATE_BENEFIT,
				pattern: lang.VALIDATE_BENEFIT_FORMAT,
				minlength: lang.VALIDATE_BENEFIT_FORMAT,
			},
			destinationCard: lang.VALIDATE_DESTINATION_CARD,
			destinationInstrument: lang.VALIDATE_DESTINATION_INSTRUMENT,
			destinationAccount: {
				required: lang.VALIDATE_DESTINATION_ACCOUNT,
				destinationAccount: lang.VALIDATE_DESTINATION_ACCOUNT,
				accountMatchBank: lang.VALIDATE_ACCOUNT_MATCH_BANK,
			},
			beneficiaryEmail: lang.VALIDATE_EMAIL,
			amount: lang.VALIDATE_AMOUNT,
			expDateCta: lang.VALIDATE_DATE_MY,
			currentPin: {
				required: lang.VALIDATE_CURRENT_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				exactLength: lang.VALIDATE_FORMAT_PIN,
			},
			newPin: {
				required: lang.VALIDATE_NEW_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				exactLength: lang.VALIDATE_FORMAT_PIN,
				differs: lang.VALIDATE_DIFFERS_PIN,
				fourConsecutivesDigits: lang.VALIDATE_FORMAT_PIN,
			},
			confirmPin: {
				required: lang.VALIDATE_CONFIRM_PIN,
				equalTo: lang.VALIDATE_IQUAL_PIN,
			},
			generateNewPin: {
				required: lang.VALIDATE_NEW_PIN,
				pattern: lang.VALIDATE_FORMAT_PIN,
				exactLength: lang.VALIDATE_FORMAT_PIN,
				differs: lang.VALIDATE_DIFFERS_PIN,
				fourConsecutivesDigits: lang.VALIDATE_FORMAT_PIN,
			},
			generateConfirmPin: {
				required: lang.VALIDATE_CONFIRM_PIN,
				equalTo: lang.VALIDATE_IQUAL_PIN,
			},
			SEL_A: {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE,
			},
			INE_A: {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE,
			},
			INE_R: {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE,
			},
			PASS_A: {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE,
			},
			PASS_R: {
				required: lang.VALIDATE_FILE_TYPE,
				extension: lang.VALIDATE_FILE_TYPE,
				filesize: lang.VALIDATE_FILE_SIZE,
			},
			notify: lang.VALIDATE_NOTIFICATIONS,
		},
		errorPlacement: function (error, element) {
			$(element).closest(".form-group").find(".help-block").html(error.html());
		},
	});

	$.validator.methods.verifyRequired = function (value, element, param) {
		return value != "" && $(param).val() != "";
	};

	$.validator.methods.verifyPattern = function (value, element, param) {
		return userPassword.test(value) && alphanumunder.test($(param).val());
	};

	$.validator.methods.differs = function (value, element, param) {
		var valid = true;

		if (value != "") {
			if (Array.isArray(param)) {
				valid = !param.some(function (el) {
					return value === $(el).val();
				});
			} else {
				valid = value !== $(param).val();
			}
		}

		return valid;
	};

	$.validator.methods.validatePass = function (value, element, param) {
		return passStrength(value);
	};

	$.validator.methods.dbAvailable = function (value, element, param) {
		return $(element).hasClass("available");
	};

	$.validator.methods.requiredSelect = function (value, element, param) {
		var valid = true;

		if ($(element).find("option").length > 0) {
			valid = alphanumunder.test(
				$(element).find("option:selected").val().trim()
			);
		}

		return valid;
	};

	$.validator.methods.fourConsecutivesDigits = function (
		value,
		element,
		param
	) {
		return !value.match(
			/(0123|1234|2345|3456|4567|5678|6789|9876|8765|7654|6543|5432|4321|3210)/
		);
	};

	$.validator.methods.exactLength = function (value, element, param) {
		return value.length == param;
	};

	$.validator.methods.matchVerifierCode = function (value, element, param) {
		var valid = true;
		if (CurrentVerifierCode != "") {
			valid = value == CurrentVerifierCode;
		}

		return valid;
	};

	$.validator.methods.filesize = function (value, element, param) {
		var maxSize = parseInt(lang.SETT_CONFIG_UPLOAD_FILE.max_size) * 1024;
		var minSize = parseInt(lang.SETT_CONFIG_UPLOAD_FILE.min_size) * 1024;

		return element.files[0].size <= maxSize && element.files[0].size >= minSize;
	};

	$.validator.methods.validateDocumentId = function (value, element, param) {
		var pattern = alphanum;
		var typeDocument = form.find("#typeDocument option:selected");

		if (lang.SETT_DOC_TYPE === "ON" || typeDocument.length > 0) {
			if (lang.SETT_NUMERIC_DOCUMENT_ID.includes(typeDocument.val())) {
				pattern = numeric;
			}
		}

		return pattern.test(value);
	};

	$.validator.methods.validateIdNumberVE = function (value, element, param) {
		var pattern;
		var min = value.length >= param.minlength;
		var max = value.length <= param.maxlength;
		var typeDocument = form.find("#typeDocument option:selected");

		if (typeDocument.length > 0) {
			pattern = typeDocument.val() == "P" ? alphanum : numeric;
			return min && max && pattern.test(value);
		}

		return true;
	};

	$.validator.methods.destinationAccount = function (value, element, param) {
		var accountFormat = value.replace(/-/g, "");
		return (
			accountFormat.length == param.length && param.pattern.test(accountFormat)
		);
	};

	$.validator.methods.destinationCard = function (value, element, param) {
		var accountFormat = value.replace(/-/g, "");
		return (
			accountFormat.length == param.length && param.pattern.test(accountFormat)
		);
	};

	$.validator.methods.accountMatchBank = function (value, element, param) {
		var selectedBank = form.find("#bank option:selected");
		var firstFourDigits = value.substring(0, 4);

		return firstFourDigits == selectedBank.val();
	};

	form.validate().resetForm();

	function dependsMobilePhone(element) {
		var accountField = form.find("#destinationAccount");
		var instrumentField = form.find(
			"input[name=destinationInstrument]:checked"
		);
		if (accountField.length > 0) {
			if (instrumentField.length > 0) {
				return instrumentField.val() == "t";
			} else {
				return accountField.val() == "";
			}
		} else {
			return true;
		}
	}

	function dependsDestinationAccount(element) {
		var phoneField = form.find("#mobilePhone");
		var instrumentField = form.find(
			"input[name=destinationInstrument]:checked"
		);
		if (phoneField.length > 0) {
			if (instrumentField.length > 0) {
				return instrumentField.val() == "c";
			} else {
				return phoneField.val() == "";
			}
		} else {
			return true;
		}
	}
}
