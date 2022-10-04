'use strict'
$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#recoverAccessBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#recoverAccessForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);

			if (lang.CONF_RECOVER_SHOW_OPTIONS == 'ON') {
				if ($('#recoveryUser').is(':checked')) {
					delete data.recoveryPwd;
				}

				if ($('#recoveryPwd').is(':checked')) {
					delete data.recoveryUser;
				}
			}

			$(this).html(loader);
			insertFormInput(true);

			getRecaptchaToken('AccessRecover', function (recaptchaToken) {
			  data.token = recaptchaToken;
				getAccessRecover();
			});
		}
	});

	$('#system-info').on('click', '.send-otp', function(e) {
		e.preventDefault();
		form = $('#otpModal');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.email = $('#email').val();
			$(this)
				.html(loader)
				.prop('disabled', true);
			insertFormInput(true);

			getRecaptchaToken('ValidateOTP', function (recaptchaToken) {
				data.token = recaptchaToken;
				getValidateOTP();
			});
		}
	});
});

function showModalOTP(response) {
	if (response.code == 0) {
		inputModal = response.msg;
		inputModal +=	'<form id="otpModal" name="otpModal" onsubmit="return false" class="pt-2">';
		inputModal +=		'<div class="form-group col-auto">';
		inputModal += 		'<div class="input-group">';
		inputModal += 			'<input class="form-control" type="text" id="otpCode" name="otpCode" autocomplete="off">';
		inputModal += 		'</div>';
		inputModal += 		'<div class="help-block"></div>';
		inputModal += 	'</div>';
		inputModal += '</form>';

		$('#accept').addClass('send-otp');
		appMessages(response.title, inputModal, response.icon, response.modalBtn)
	}
}

function getAccessRecover() {
	who = 'User';
	where = lang.CONF_LINK_SERVICE_RECOVER_ACCESS;

	callNovoCore(who, where, data, function (response) {
		if (lang.CONF_LINK_SERVICE_RECOVER_ACCESS == 'AccessRecoverOTP') {
			showModalOTP(response);
		}

		insertFormInput(false);
		$('#recoverAccessBtn').html(btnText);
	});
}

function getValidateOTP(){
	who = 'User';
	where = 'ValidateOTP';
	insertFormInput(true);

	callNovoCore(who, where, data, function(response) {
		insertFormInput(false);
	});
}
