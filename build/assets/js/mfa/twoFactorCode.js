'use strict'

$(function () {
	sessionStorage.clear();
	getSecretToken(true);

	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#twoFactorCodeBtn').on('click', function(e) {
		e.preventDefault();
		var form = $('#twoFactorCodeForm');
		btnText = $(this).html().trim();

		validateForms(form);
		if (form.valid()) {
			var data = getDataForm(form);
			data.operationType = lang.CONF_MFA_ACTIVATE_SECRET_TOKEN;
			data.channel = sessionStorage.channel;
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
	form = $('#channelForm');
	validateForms(form);
	if (form.valid()) {
		data = getDataForm(form);
		data.sendResendToken = action;
		who = 'Mfa'; where = 'GenerateSecretToken';
		callNovoCore(who, where, data, function(response) {
			switch (response.code) {
				case 0:
					$('#secretToken').append(response.data.secretToken);
					$('#qrCodeImg').html($(`<img src="data:image/png;base64,${response.data.qrCode}" >`));
					sessionStorage.channel = data.channel;
					break;
				case 2:
					appMessages(response.title, response.msg, response.icon, response.modalBtn);
					sessionStorage.channel = data.channel;
				break;
			}
		});
	}
}
