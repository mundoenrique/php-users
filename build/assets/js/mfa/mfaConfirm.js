'use strict'
$(function () {
	var mfaChannel = $('#channel').val();
	activeteMfa(response, mfaChannel);

	$('#mfaConfirmBtn').on('click', function(e) {
		e.preventDefault();
		btnText = $(this).html().trim();
		form = $('#mfaConfirmForm');
		validateForms(form);

		if (form.valid()) {
			$(this).html(loader);
			who = 'Mfa';
			where = 'ValidateTotp';
			data = getDataForm(form);
			data.operationType = lang.SETT_MFA_ACTIVATE;
			data.channel = mfaChannel;
			insertFormInput(true);

			callNovoCore(who, where, data, function() {
				$('#mfaConfirmBtn').html(btnText);
				$('#authenticationCode').val('');
				insertFormInput(false);
			});
		}
	});

	$('#resendCode').on('click', function(e) {
		who = 'Mfa';
		where = 'ActivateSecretToken';
		data = {
			channel: mfaChannel,
			resendToken: true
		}
		insertFormInput(true);

		callNovoCore(who, where, data, function(response) {
			activeteMfa(response, mfaChannel);
			coverSpin(false);
		});
	});
});

function activeteMfa(responseData, channel) {
	if (channel === lang.SETT_MFA_CHANNEL_APP && responseData.data.qrCode) {
		$('#secretToken').append(responseData.data.secretToken);
		$('#qrCodeImg').html($(`<img src="data:image/png;base64,${responseData.data.qrCode}" >`));
	}

	$('#authenticationCode').val('');
	$('.hide-out').removeClass('hide');
	$('#pre-loader').remove();
	insertFormInput(false);
}
