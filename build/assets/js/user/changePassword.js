'use strict'
var reportsResults;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	'use strict'
	$(function () {
		var changePassBtn = $('#change-pass-btn');
		var newPass = $('#newPass');

		newPass.on('keyup focus', function () {
			var pswd = $(this).val();
			passStrength(pswd);
		});

		changePassBtn.on('click', function (e) {
			e.preventDefault();
			changeBtn = $(this);
			form = $('#change-pass-form');
			btnText = changeBtn.text().trim();
			validateForms(form)

			if (form.valid()) {
				data = getDataForm(form)

				if (data.userType == '1') {
					data.currentPass = data.currentPass.toUpperCase();
				}

				data.currentPass = cryptoPass(data.currentPass);
				data.newPass = cryptoPass(data.newPass);
				data.confirmPass = cryptoPass(data.confirmPass);
				insertFormInput(true, form);
				changeBtn.html(loader);
				changePassword(data, btnText);
			}
		});
	});
});

var changeBtn;
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

	if (pswd.match(validatePass)) {
		$('.pwd-rules #special').removeClass('rule-invalid').addClass('rule-valid');
		valid = !valid ? valid : true;
	} else {
		$('.pwd-rules #special').removeClass('rule-valid').addClass('rule-invalid');
		valid = false;
	}

	return valid;
}

function changePassword(passData, textBtn) {
	who = 'User'; where = 'ChangePassword'; data = passData;
	var validRules = $('.pwd-rules');
	callNovoCore(who, where, data, function (response) {

		validRules.find('li').removeClass('rule-valid').addClass('rule-invalid')
		form[0].reset();
		insertFormInput(false, form);
		changeBtn.html(textBtn)
	})
}
