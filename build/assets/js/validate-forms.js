
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

	$.validator.methods.validatePass	= function(value, element, param) {
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

	jQuery.validator.addMethod("numberEqual1", function(value,element) {
		if(element.value.length>0 && (element.value == $("#landLine").val() || element.value == $("#mobilePhone").val()))
			return false;
		else return true;
	}, "Teléfono Otro está repetido");

	jQuery.validator.addMethod("numberEqual2", function(value, element) {
		if(element.value.length>0 && (element.value == $("#mobilePhone").val() || element.value == $("#otherPhoneNum").val()))
			return false;
		else return true;
	}, "Teléfono Fijo está repetido");

	jQuery.validator.addMethod("numberEqual3", function(value, element) {
		if(element.value.length>0 && (element.value == $("#otherPhoneNum").val() || element.value == $("#otherPhoneNum").val()))
				return false;
		else return true;
	}, "Teléfono Movil está repetido");

	// Metodo que valida si la fecha es invalida
	jQuery.validator.addMethod("fechaInvalida", function(value, element) {
		var fecha = moment(value, "DD/MM/YYYY");
		return fecha.isValid();
	}, "Fecha invalida");

	// Metodo que valida si el usuario es mayor de edad
	jQuery.validator.addMethod("mayorEdad", function(value, element) {
		var hoy, fechanacimiento, years
		hoy = moment();
		console.log("fecha hoy: " + hoy);
		fechanacimiento = moment(value, "DD/MM/YYYY");
		console.log("fecha nac: " + fechanacimiento);
		years = hoy.diff(fechanacimiento, 'years');
		console.log(years);

    return years >= 18;
	}, "Usted no es mayor de edad");

	jQuery.validator.addMethod("validatePassword", function(value,element) {
		return value.match(/((\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#$%])*\d(\w|[!@#\$%])*\d(\w|[!@#$%])*(\d)*)/) && value.match(/\d{1}/gi)? false : true;
	 }, "El campo debe tener mínimo 1 y máximo 3 números consecutivos");

	jQuery.validator.addMethod("digValido",function(value, element, regex){
		return value == digVer ? true : false;
	});

	form.validate({
		rules: {
			documentID: { required: true, number: true },
			telephoneNumber: { required: true, pattern: generalPhoneNumber },
			acceptTerms: 'required',
			idType: { required: true },	//1
			idNumber: { required: true, pattern: onlyNumber },	//2
			digVer: { required: true, digits: true, maxlength: 1, "digValido": true },
			firstName: { required: true, pattern: alphabeticalEs },	//3
			middleName: { pattern: alphabeticalEs }, //4
			lastName: { required: true, pattern: alphabeticalEs }, //5
			secondSurname: { pattern: alphabeticalEs },	//6
			birthPlace: { pattern: alphabeticalEs },	//7
			birthDate: { required: true, pattern: date.dmy, "fechaInvalida": true, "mayorEdad": true },	//8
			gender: { pattern: gender },	//9
			civilStatus: { pattern: civilStatus },	//10
			nationality: { required: true, pattern: alphabeticalEs },	//11
			addressType: { required: true },	//12
			postalCode: { digits: true },	//13
			country: { required: true },	//14
			departament: { required: true },	//15
			province: { required: true },	//16
			district: { required: true },	//17
			address: { required: true },	//18
			email: { required: true, pattern: emailValid },	//19
			confirmEmail: { required: true, equalTo: "#email" },	//20
			landLine: { minlength: 7, maxlength: 11, number: true, "numberEqual2": true },	//21
			mobilePhone: { required: true, minlength: 7, maxlength: 11, number: true, "numberEqual3": true },	//22
			phoneType: { pattern: phoneType },	//23
			otherPhoneNum: {  minlength: 7, maxlength: 11, number: true, "numberEqual1": true },	//24
			rucLaboral: { required: true },	//25
			jobCenter: { required: true },	//26
			employmentSituation: { required: false },	//28
			jobOccupation: { required: true },	//29
			jobTitle: { pattern: alphanumEs },	//30
			income: { required: true, number: true },	//31
			publicPerformance: { required: true },	//32
			publicOffice: { required: true, pattern: alphabeticalEs  },	//33
			institution: { required: true, pattern: alphanumEs },	//34
			uif: { required: true },	//35
			username: { required: true, pattern: username },
			userpwd: { required: true, pattern: userPassword, minlength:8, maxlength: 15,"validatePassword": true },
			confirmUserpwd: { required: true, equalTo: "#userpwd" },
			contract: { required: true },
			protection: { required: true }
		},
		errorPlacement : function(error, element) {
			$(element).closest('.form-group').find('.help-block').html(error.html());
		}
	});

}
