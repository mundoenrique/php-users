'use strict'

$(function () {
	if (!(performance.getEntriesByType("navigation")[0].type == 'reload')) {
		sessionStorage.clear();
		getSecretToken(true);
	}else{
		$('#secretToken').append(sessionStorage.secretToken);
		$('#qrCodeImg').html($(`<img src="data:image/png;base64,${sessionStorage.imgCode}" >`));
	}

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
			data.enableOTP2fa = true;
			data.operationType = lang.CONF_MFA_ACTIVATE_SECRET_TOKEN;
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
					sessionStorage.secretToken = response.data.secretToken ? response.data.secretToken : '';
					sessionStorage.imgCode = response.data.qrCode ? response.data.qrCode : '';
					$('#secretToken').append(sessionStorage.secretToken);
					$('#qrCodeImg').html($(`<img src="data:image/png;base64,${sessionStorage.imgCode}" >`));
					break;
				case 2:
					appMessages(response.title, response.msg, response.icon, response.modalBtn);
				break;
			}
		});
	}
}
