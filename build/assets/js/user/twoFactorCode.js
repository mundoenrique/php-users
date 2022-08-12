'use strict'
$(function () {
	getSecretToken(true);
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
			data.enabled = true;
			$(this).html(loader);
			insertFormInput(true);
			who = 'Mfa'; where = 'ValidateOTP2fa';
			callNovoCore(who, where, data, function(response) {
				switch (response.code) {
					case 0:
						$('#twoFactorCodeBtn').html(btnText);
						appMessages(response.title, response.msg, response.icon, response.modalBtn);
					break;
				}
			});
		}
	});

	$('#resendCode').on('click', function(e) {
		getSecretToken(false);
	});
});

function getSecretToken(action) {
	var data = new Object();
	data.sendResendToken = action;
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
				appMessages(response.title, response.msg, response.icon, response.modalBtn);
			break;
		}
	});
}
