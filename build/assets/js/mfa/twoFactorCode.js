'use strict'

$(function () {
	coverSpin(true);
	insertFormInput(false);
	getSecretToken(false, channel);

	$('#twoFactorCodeBtn').on('click', function(e) {
		e.preventDefault();
		var form = $('#twoFactorCodeForm');
		btnText = $(this).html().trim();

		validateForms(form);
		if (form.valid()) {
			var data = getDataForm(form);
			data.operationType = lang.CONF_MFA_ACTIVATE;
			data.channel = $('#channel').val();
			$(this).html(loader);
			insertFormInput(true);
			who = 'Mfa'; where = 'ValidateOtp';
			callNovoCore(who, where, data, function() {
				$('#twoFactorCodeBtn').html(btnText);
				$('#authenticationCode').val('');
				insertFormInput(false);
			});
		}
	});

	$('#resendCode').on('click', function(e) {
		getSecretToken(true);
	});
});

function getSecretToken(reSend) {
	data = {
		channel: $('#channel').val(),
		resendToken: reSend
	}
	who = 'Mfa';
	where = 'ActivateSecretToken';
	callNovoCore(who, where, data, function(response) {

		if (data.channel === lang.CONF_MFA_CHANNEL_APP && response.data.qrCode) {
			$('#secretToken').append(response.data.secretToken);
			$('#qrCodeImg').html($(`<img src="data:image/png;base64,${response.data.qrCode}" >`));
		}

		$('#authenticationCode').val('');
		coverSpin(false);
	});

}
