
'use strict'
var validator;

function validateForms(form, options) {

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


	jQuery.validator.addMethod("spanishAlphabetical", function(value, element) {
		return this.optional( element ) || /^[a-záéíóúüñ ]+$/i.test( value );
	});

	jQuery.validator.addMethod("spanishAlphanum", function(value, element) {
		return this.optional( element ) || /^[a-z0-9áéíóúüñ ]+$/i.test( value );
	});

	jQuery.validator.addMethod("alphanum", function(value, element) {
		return this.optional( element ) || /^[a-z0-9]+$/i.test( value );
	});

	jQuery.validator.addMethod("exactLength", function(value, element, param) {
		return this.optional(element) || value.length == param;
	});

	jQuery.validator.addMethod("exactNumbers", function(value, element, param) {
		return this.optional(element) || value.length == param;
	});

	jQuery.validator.addMethod("minNumLength", function(value, element, param) {
		return this.optional(element) || value.length >= param;
	});

	jQuery.validator.addMethod("maxNumLength", function(value, element, param) {
		return this.optional(element) || value.length <= param;
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

	jQuery.validator.addMethod("fechaInvalida", function(value, element) {
		var fecha = moment(value, "DD/MM/YYYY");
		return fecha.isValid();
	});

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
		return value !== '0' && value !== '';
	 }, "Este campo es obligatorio.");

	jQuery.validator.addMethod("generateConfirmPin", function(value,element){
		if(element.value.length>0 && element.value == $("#generateNewPin").val()) {
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

	jQuery.validator.addMethod("codeOTPLogin", function(value, element) {
		if (/^[a-z0-9]+$/i.test(value) && value.length == 8)
			return true;
		else return false;
	}, "El formato de código es inválido.");

	jQuery.validator.addMethod("fourConsecutivesDigits", function(value, element) {
		return !value.match(/(0123|1234|2345|3456|4567|5678|6789|9876|8765|7654|6543|5432|4321|3210)/);
	}, "Los 4 números no deben ser consecutivos.");

	jQuery.validator.addMethod("dependOtherPhoneNum", function(value, element) {
		return ($('#otherPhoneNum').val() == '' || value != '');
	}, "Selecciona una opción.");

	jQuery.validator.addMethod("dependPhoneType", function(value, element) {
		return ($('#phoneType').val() == '' || element.value != '');
	}, "Introduce el número.");

	validator = form.validate({
		rules: {
			generateNewPin: { required: true, number: true, exactNumbers: 4, "fourConsecutivesDigits": true },
			generateConfirmPin: { required: true, number: true, exactNumbers: 4, "generateConfirmPin": true },
			changeCurrentPin: { required: true, number: true, exactNumbers: 4 },
			changeNewPin: { required: true, number: true, exactNumbers: 4, "changeNewPin": true, "fourConsecutivesDigits": true },
			changeConfirmPin: { required: true, number: true, "changeConfirmPin": true },
			replaceMotSol: { required: true, "selectRequired": true},
			gender: { required: true},
			typeDocument: { required: true, "selectRequired": true},
			generateCodeOTP: { required: true, number: true, exactNumbers: 5 },
			changeCodeOTP: { required: true, number: true, exactNumbers: 5 },
			lockCodeOTP: { required: true, number: true, exactNumbers: 5 },
			replaceCodeOTP: { required: true, number: true, exactNumbers: 5 },
			nitBussines: { required: true, number: true,},
			currentPassword: { required: true},
			newPassword: { required: true, minlength:8, maxlength: 15, "validatePassword": true },
			confirmPassword: { required: true, equalTo: "#newPassword" },
			typeDocumentUser: { required: true, "selectRequired": true },
			typeDocumentBussines: { required: true, "selectRequired": true },
			idNumber: { required: true, number: true },
			telephoneNumber: { required: true, number: true, minNumLength: 7, maxNumLength: 11 },
			codeOTP: { required: true, number: true, exactNumbers: 5 },
			codeOTPLogin: { required: true, "codeOTPLogin": true },
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
			addressType: { required: true, "selectRequired": true },
			postalCode: { digits: true },
			country: { required: true },
			department: { required: true, "selectRequired": true },
			province: { required: true, "selectRequired": true },
			district: { required: true, "selectRequired": true },
			city: { required: true, "selectRequired": true },
			address: { required: true },
			email: { required: true, emailValid: true },
			confirmEmail: { required: true, equalTo: "#email" },
			landLine: { number: true, minNumLength: 7, maxNumLength: 11, "numberEqual2": true },
			mobilePhone: { required: true, number: true, minNumLength: 7, maxNumLength: 11, "numberEqual3": true },
			phoneType: { "dependOtherPhoneNum": true },
			otherPhoneNum: { number: true, minNumLength: 7, maxNumLength: 11, "numberEqual1": true, "dependPhoneType": true },
			rucLaboral: { required: true },
			jobCenter: { required: true },
			employmentSituation: { required: false },
			jobOccupation: { required: true },
			profession: { required: true, "selectRequired": true },
			jobTitle: { "spanishAlphabetical": true },
			income: { required: true, number: true },
			publicPerformance: { required: true },
			publicOffice: { required: true, "spanishAlphabetical": true },
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
