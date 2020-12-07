'use strict'
var reportsResults;
var inputModal;
var recoverAccessBtn;
$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	recoverAccessBtn = $('#recoverAccessBtn');

	$('#recoverAccessBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#recoverAccessForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);

			if (lang.CONF_RECOVER_SHOW_OPTIONS == 'ON') {
				validateRecoveryOptions();
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
			$('#accept').removeClass('send-otp');
			data = getDataForm(form);
			data.email = $('#email').val();
			$('#accept')
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

function validateRecoveryOptions() {

	if ($('#recoveryUser').is(':checked')) {
		delete data.recoveryPwd
	}

	if ($('#recoveryPwd').is(':checked')) {
		delete data.recoveryUser
	}
}

function showModalOTP(response) {

	if ( response.code == 0 ) {
		$('#accept').addClass('send-otp');
		inputModal = response.msg;
		inputModal +=	'<form id="otpModal" name="otpModal" onsubmit="return false" class="pt-2">';
		inputModal +=		'<div class="form-group col-auto">';
		inputModal += 		'<div class="input-group">';
		inputModal += 			'<input class="form-control" type="text" id="otpCode" name="otpCode" autocomplete="off">';
		inputModal += 		'</div>';
		inputModal += 		'<div class="help-block"></div>';
		inputModal += 	'</div>';
		inputModal += '</form>';

		appMessages(response.title, inputModal, response.icon, response.modalBtn)
	}
}

function getAccessRecover(){
	who = 'User'; where = lang.GEN_LINK_SERVICE_RECOVER_ACCESS;

	callNovoCore(who, where, data, function (response) {
		if (lang.GEN_LINK_SERVICE_RECOVER_ACCESS == 'AccessRecoverOTP') {
			showModalOTP(response);
		}
	insertFormInput(false);
	recoverAccessBtn.html(btnText)
	})
}

function getValidateOTP(){
	who = 'User'; where = 'ValidateOTP';

	callNovoCore(who, where, data, function(response) {
		insertFormInput(false)
	})
}
