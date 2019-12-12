
'use strict'
function validateForms(form, options) {
	var telephoneNumber = /^\(?([0-9]{4})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$/;
	var shortPhoneNumber = /^([0-9]{3})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$/;
	var generalPhoneNumber = /^([0-9]{7,14})+$/;
	var validCountry = typeof country!=='undefined'? country : isoPais;
	var onlyNumber = /^[0-9]{6,8}$/;
	var namesValid = /^([a-záéíóúüñ.]+[\s]*)+$/i;
	var validNickName = /^([a-z]{2,}[0-9_]*)$/i;
	var regNumberValid = /^[a-z0-9]{6,45}$/i;
	var shortPhrase = /^[a-z0-9áéíóúüñ ().]{4,25}$/i;
	var middlePhrase = /^[a-z0-9áéíóúüñ ().]{15,45}$/i;
	var longPhrase = /^[a-z0-9áéíóúüñ ().]{10,70}$/i;
	var emailValid = /^([a-zA-Z]+[0-9_.+-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var alphanumber = /^([\w.\-+&áéíóúüñ]+)+$/i;
	var alphanum = /^[a-z0-9]+$/i;
	var alphanumEs = /^[a-z0-9áéíóúüñ ]+$/i;
	var username = /^[a-z0-9_-]{6,16}$/i
	var userPassword = /^[\w!@\*\-\?¡¿+\/.,#]+$/;
	var numeric = /^[0-9]+$/;
	var alphabetical = /^[a-z]+$/i;
	var alphabeticalEs = /^[a-záéíóúüñ ]+$/i;
	var text = /^[a-z0-9áéíóúüñ ,.:()]+$/i;
	var usdAmount = /^[0-9]+(\.[0-9]*)?$/;
	var fiscalReg = {
		'bp': /^(00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24)+(6|9)[\d]{5,6}[\d]{3,4}$/,
		'co': /^([0-9]{9,17})/,
		'pe': /^(10|15|16|17|20)[\d]{8}[\d]{1}$/,
		'us': /^(10|15|16|17|20)[\d]{8}[\d]{1}$/,
		've': /^([VEJPGvejpg]{1})-([0-9]{8})-([0-9]{1}$)/
	};
	var date = {
		dmy: /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/[0-9]{4}$/,
		my: /^(0?[1-9]|1[012])\/[0-9]{4}$/,
	};
	var amount = {
		'Ec-bp': usdAmount,
		'bp': usdAmount
	};
	var fiscalRegMsg = {
		'bp': 'RUC',
		'co': 'NIT',
		'pe': 'RUC',
		'us': 'RUC',
		've': 'RIF'
	};
	var gender = /^[MF]$/;
	var civilStatus = /^[SCV]$/;
	var phoneType = /^(OFC|FAX|OTRO)$/;
	var defaults = {
		debug: true,
		errorClass: "has-error",
		validClass: "has-success",
		success: " ",
		ignore: ".ignore",
		errorElement: 'div',
		highlight: function(element, errorClass, validClass) {
			$(element).addClass(errorClass).removeClass(validClass);
			$(element.form).find("label[for=" + element.id + "]").addClass(errorClass);
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).removeClass(errorClass).addClass(validClass);
			$(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
		}
	};

	$.validator.methods.fiscalRegistry = function(value, element, param) {
		return fiscalReg[validCountry].test(value);
	}

	$.validator.methods.validatePass = function(value, element, param) {
		return passStrength(value);
	}

	$.validator.methods.differs = function(value, element, param) {
		var target = $(param);
		return value !== target.val();
	}

	function ignoreMsgHandling() {
		defaults.onfocusout = false;
		defaults.onkeyup = function() {};
		defaults.errorPlacement = function(error, element) {}
	}

	if(typeof options!=='undefined') {
		if(options.handleMsg===false)
			ignoreMsgHandling();
		if(options.handleStyle===false)
			errorClass = '';
	} else {
		ignoreMsgHandling();
	}

	jQuery.validator.setDefaults(defaults);


	// Letras alfabéticas con acentos, ñ y espacio en blanco
	jQuery.validator.addMethod("spanishAlphabetical", function(value, element) {
		return this.optional( element ) || /^[a-záéíóúüñ ]+$/i.test( value );
	});

	// Números y Letras alfabéticas con acentos, ñ y espacio en blanco
	jQuery.validator.addMethod("spanishAlphanum", function(value, element) {
		return this.optional( element ) || /^[a-z0-9áéíóúüñ ]+$/i.test( value );
	});

	jQuery.validator.addMethod("exactlength", function(value, element, param) {
		return this.optional(element) || value.length == param;
	 });

	jQuery.validator.addMethod("emailValid",function(value, element) {
		return /^([a-zA-Z]+[0-9_.+-]*)+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value);
	});

	jQuery.validator.addMethod("username",function(value, element) {
		return /^[a-z0-9_-]+$/i.test(value);
	});

	jQuery.validator.addMethod("numberEqual1", function(value,element) {
		if(element.value.length>0 && (element.value == $("#landLine").val() || element.value == $("#mobilePhone").val()))
			return false;
		else return true;
	}, "Teléfono Otro está repetido.");

	jQuery.validator.addMethod("numberEqual2", function(value, element) {
		if(element.value.length>0 && (element.value == $("#mobilePhone").val() || element.value == $("#otherPhoneNum").val()))
			return false;
		else return true;
	}, "Teléfono Fijo está repetido.");

	jQuery.validator.addMethod("numberEqual3", function(value, element) {
		if(element.value.length>0 && (element.value == $("#otherPhoneNum").val() || element.value == $("#otherPhoneNum").val()))
				return false;
		else return true;
	}, "Teléfono Móvil está repetido.");

	// Metodo que valida si la fecha es invalida
	jQuery.validator.addMethod("fechaInvalida", function(value, element) {
		var fecha = moment(value, "DD/MM/YYYY");
		return fecha.isValid();
	});

	// Metodo que valida si el usuario es mayor de edad
	jQuery.validator.addMethod("mayorEdad", function(value, element){
		var hoy, fechanacimiento, years
		hoy = moment();
		fechanacimiento = moment(value, "DD/MM/YYYY");
		years = hoy.diff(fechanacimiento, 'years');
		return years >= 18;
	}, "Usted no es mayor de edad.");

	jQuery.validator.addMethod("validatePassword", function(value,element) {
		return value.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && value.match(/\d{1}/gi)? false : true;
	 });

	jQuery.validator.addMethod("digValido",function(value, element, regex){
		return value == digVer ? true : false;
	});

	$.validator.addMethod("selectRequired", function(value, element, arg){
		return value !== '0';
	 }, "Este campo es obligatorio.");

	jQuery.validator.addMethod("generateConfirmPin", function(value,element){
		if(element.value.length>0 && element.value == $("#newPin").val()) {
			return true;
		}
		else return false;
	}, "Debe ser igual al nuevo PIN.");

	jQuery.validator.addMethod("changeConfirmPin", function(value,element){
		if(element.value.length>0 && element.value == $("#changeNewPin").val()) {
			return true;
		}
		else return false;
	}, "Debe ser igual al nuevo PIN.");

	jQuery.validator.addMethod("changeNewPin", function(value, element) {
		if(element.value.length>0 && element.value == $("#changeCurrentPin").val())
			return false;
		else return true;
	}, "El nuevo PIN no debe ser igual a su PIN anterior.");

	jQuery.validator.addMethod("fourConsecutivesDigits", function(value, element) {
		return !value.match(/(0123|1234|2345|3456|4567|5678|6789|9876|8765|7654|6543|5432|4321|3210)/);
	}, "Los 4 dígitos no deben ser consecutivos.");

	form.validate({
		rules: {
			generateNewPin: { required: true, number: true, exactlength: 4, "fourConsecutivesDigits": true },
			generateConfirmPin: { required: true, number: true, "generateConfirmPin": true },
			changeCurrentPin: { required: true, number: true, exactlength: 4 },
			changeNewPin: { required: true, number: true, exactlength: 4, "changeNewPin": true, "fourConsecutivesDigits": true },
			changeConfirmPin: { required: true, number: true, "changeConfirmPin": true },
			replaceMotSol: { required: true, "selectRequired": true},
			gender: { required: true},
			typeDocument: { required: true, "selectRequired": true},
			generateCodeOTP: { required: true, digits: true, exactlength: 5 },
			changeCodeOTP: { required: true, digits: true, exactlength: 5 },
			nitBussines: { required: true, number: true,},
			currentPassword: { required: true},
			newPassword: { required: true, minlength:8, maxlength: 15, "validatePassword": true },
			confirmPassword: { required: true, equalTo: "#newPassword" },
			idNumber: { required: true, number: true },
			telephoneNumber: { required: true, number: true, minlength: 7, maxlength: 11 },
			acceptTerms: { required: true },
			idType: { required: true },
			digVer: { required: true, digits: true, maxlength: 1, "digValido": true },
			firstName: { required: true, "spanishAlphabetical": true},
			middleName: { "spanishAlphabetical": true },
			lastName: { required: true, "spanishAlphabetical": true },
			secondSurname: { "spanishAlphabetical": true },
			birthPlace: { "spanishAlphabetical": true },
			birthDate: { required: true, "fechaInvalida": true, "mayorEdad": true },
			nationality: { required: true, "spanishAlphabetical": true },
			addressType: { required: true },
			postalCode: { digits: true },
			country: { required: true },
			departament: { required: true },
			province: { required: true },
			district: { required: true },
			address: { required: true },
			email: { required: true, emailValid: true },
			confirmEmail: { required: true, equalTo: "#email" },
			landLine: { number: true, minlength: 7, maxlength: 11, "numberEqual2": true },
			mobilePhone: { required: true, number: true, minlength: 7, maxlength: 11, "numberEqual3": true },
			otherPhoneNum: { number: true, minlength: 7, maxlength: 11, "numberEqual1": true },
			rucLaboral: { required: true },
			jobCenter: { required: true },
			employmentSituation: { required: false },
			jobOccupation: { required: true },
			jobTitle: { "spanishAlphabetical": true },
			income: { required: true, number: true },
			publicPerformance: { required: true },
			publicOffice: { required: true, "spanishAlphabetical": true  },
			institution: { required: true, "spanishAlphanum": true },
			uif: { required: true },
			username: { required: true, username: true, nowhitespace: true, rangelength: [6, 16] },
			userpwd: { required: true, minlength:8, maxlength: 15, "validatePassword": true },
			confirmUserpwd: { required: true, equalTo: "#userpwd" },
			contract: { required: true },
			protection: { required: true },
			loginUsername: { required: true },
			loginUserpwd: { required: true },
			recovery: { required: true }
		},
		errorPlacement: function(error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		}
	});

}
