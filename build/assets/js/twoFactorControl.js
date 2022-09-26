'use strict'
var otpProps = new Object();;
otpProps.reSend = false;
$(function() {

	$('#disableTwoFactor').on('click', function (e) {
		e.preventDefault();
		$('#accept').addClass('sure-disable-two-factor');
		otpProps.msgInfo = lang.GEN_TWO_FACTOR_REMEMBER
		otpProps.action = lang.CONF_MFA_DEACTIVATE;

		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'none'
			},
			btn2: {
				text: lang.GEN_BTN_CANCEL,
				action: 'destroy'
			},
		}

		appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, lang.GEN_TWO_FACTOR_SURE_DISABLE, lang.CONF_ICON_INFO, modalBtn);
	});

	$('#system-info').on('click', '.sure-disable-two-factor', function (e) {
		e.preventDefault();
		btnText = $(this).html();
		$(this).html(loader);
		$(this).prop('disabled', true);
		$(this).removeClass('sure-disable-two-factor');

		generateOtp();
	});

	$('#system-info').on('click', '.disable-two-factor', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		btnText = $(this).html();
		form = $('#twoFactorDisableForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.operationType = otpProps.action === lang.CONF_MFA_DEACTIVATE ? otpProps.action : lang.CONF_MFA_VALIDATE_OTP;
			$(this).removeClass('disable-two-factor');
			$(this).html(loader);
			$(this).prop('disabled', true);
			insertFormInput(true);
			who = 'Mfa';
			where = 'ValidateOtp';
			callNovoCore(who, where, data, function(response) {

				switch (response.code) {
					case 0:
						if (otpProps.action === lang.CONF_MFA_VALIDATE_OTP) {
							validateCardDetail();
						}
						break;
					case 1:
						appMessages(response.title, response.msg, response.icon, response.modalBtn);
						$('#accept').addClass('invalid-code');
						break;
				}

				insertFormInput(false);
				$('#accept')
					.prop('disabled', false)
					.html(btnText);



			});
		}
	});

	$('#system-info').on('click', '.invalid-code', function (e) {
		$('#accept').removeClass('invalid-code');
		$('#accept').addClass('disable-two-factor');
		modalSecretToken()
	});

	$('#system-info').on('click', '#resendCode', function (e) {
		$('#system-info').dialog('destroy');
		coverSpin(true);
		otpProps.reSend = true;
		generateOtp();
	});

	$('#cancel').on('click', function(e) {
		$('#accept').removeClass('sure-disable-two-factor disable-two-factor invalid-code');
	});
});


function generateOtp () {
	data = {
		operationType: otpProps.action,
		resendToken: otpProps.reSend,
	}
	who = 'Mfa';
	where = 'GenerateOtp';

	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				otpProps.msgContent = response.msg;
				modalSecretToken();
				$('#accept').addClass('disable-two-factor');
			break;
		}

		coverSpin(false)
		$('#accept')
			.prop('disabled', false)
			.html(btnText);
	});
}

function modalSecretToken() {
	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'none'
		},
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'destroy'
		},
		maxHeight : 600,
		width : 530,
		posMy: 'top+60px',
		posAt: 'top+50px'
	}

	inputModal = '<form id="twoFactorDisableForm" name="formTwoFactorDisable" class="mr-2" method="post" onsubmit="return false;">';
	inputModal += 	'<div class="justify pr-1">';
	inputModal += 		'<div class="justify pr-1">';
	inputModal += 			'<p>' + otpProps.msgInfo + '</p>';
	inputModal += 			'<p class=" pb-1">' + otpProps.msgContent + ' ';

	if (otpChannel === lang.CONF_MFA_CHANNEL_EMAIL || otpProps.action === lang.CONF_MFA_DEACTIVATE) {
		inputModal += 				'<a id="resendCode" href="' + lang.CONF_NO_LINK + '" class="btn btn-small btn-link p-0" >'; inputModal +=						lang.GEN_BTN_RESEND_CODE+'</a>';
	}

	inputModal += 			'</p>';
	inputModal += 		'</div>';
	inputModal += 		'<div class="form-group col-8 p-0">';
	inputModal += 			'<label for="authenticationCode">' + lang.GEN_AUTHENTICATION_CODE + '</label>'
	inputModal += 			'<input id="authenticationCode" class="form-control" type="text" name="authenticationCode" autocomplete="off" maxlength="6" placeholder="'+lang.GEN_PLACE_HOLDER_AUTH_CODE+'">';
	inputModal += 			'<div class="help-block"></div>'
	inputModal += 		'</div">';
	inputModal += 	'</div>';
	inputModal += '</form>';

	appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, inputModal, lang.CONF_ICON_INFO, modalBtn);
}

