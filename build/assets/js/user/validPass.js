'use strict'
function passStrength(pswd) {
	var valid;

	if (pswd.length < 8 || pswd.length > 15) {
		$('.pwd-rules #length').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	} else {
		$('.pwd-rules #length').removeClass('rule-invalid').addClass('rule-valid');
		valid = true;
	}

	if (pswd.match(/[a-z]/)) {
		$('.pwd-rules #letter').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #letter').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	if (pswd.match(/[A-Z]/)) {
		$('.pwd-rules #capital').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #capital').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	if (pswd.split(/[0-9]/).length - 1 >= 1 && pswd.split(/[0-9]/).length - 1 <= 3) {
		$('.pwd-rules #number').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #number').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	if ((pswd.length > 0) && !pswd.match(/(.)\1{2,}/)) {
		$('.pwd-rules #consecutive').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #consecutive').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	if (pswd.match(/([!@\*\-\?¡¿+\/.,_#])/) && pswd.match(/^([a-z0-9!@\*\-\?¡¿+\/.,_#])+$/i)) {
		$('.pwd-rules #special').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #special').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	return valid;
}
