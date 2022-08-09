'use strict'
$(function () {
	getSecretToken('send');
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#twoFactorCodeBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#twoFactorCodeForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			$(this).html(loader);
			insertFormInput(true);
			who = 'Mfa'; where = 'ValidateOTP2fa';
			callNovoCore(who, where, data, function(response) {
				switch (response.code) {
					case 0:
						appMessages(response.title, response.msg, response.icon, response.modalBtn);
					break;
				}
			});
		}
	});

	$('#resendCode').on('click', function(e) {
		getSecretToken('resend')
	});
});

function getSecretToken(method) {
	var data = new Object();
	data.method = method;
	data.channel = $('#channel').val()
	who = 'Mfa'; where = 'GenerateSecretToken';
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				var imgCode=$(`<img src="data:image/png;base64,${response.data.qrCode}" >`);
				$('#secretToken').append(response.data.secretToken);
				$('#qrCodeImg').html(imgCode);
				break;
			case 2:
				inputModal = response.msg
				appMessages(response.title, inputModal, response.icon, response.modalBtn);
			break;
		}
	});
}
