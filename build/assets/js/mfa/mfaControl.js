'use strict'
var otpProps = new Object();;
otpProps.reSend = false;
$(function() {

	$('#disableTwoFactor').on('click', function (e) {
		e.preventDefault();
		$('#accept').addClass('sure-disable-two-factor');

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

		appMessages(lang.GEN_MENU_MFA, lang.GEN_TWO_FACTOR_SURE_DISABLE, lang.CONF_ICON_INFO, modalBtn);
	});

	$('#system-info').on('click', '.sure-disable-two-factor', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		$(this)
			.html(loader)
			.prop('disabled', true);
		otpProps.msgInfo = lang.GEN_MFA_REMEMBER;
		otpProps.generateAction = lang.CONF_MFA_DEACTIVATE;
		otpProps.validateAction = lang.CONF_MFA_DEACTIVATE;

		generateOtp();
	});

	$('#system-info').on('click', '.otp-validate', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		form = $('#twoFactorDisableForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.operationType = otpProps.validateAction;
			$(this).html(loader);
			$(this).prop('disabled', true);
			who = 'Mfa';
			where = 'ValidateOtp';
			data = getDataForm(form);
			data.operationType = otpProps.validateAction;
			insertFormInput(true);

			callNovoCore(who, where, data, function(response) {
				switch (response.code) {
					case 0:
						if (otpProps.validateAction === lang.CONF_MFA_VALIDATE_OTP) {
							otpMfaAuth = true;
							validateCardDetail();
						}
						break;
					case 1:
						appMessages(response.title, response.msg, response.icon, response.modalBtn);
						$('#accept').addClass('invalid-code');
						break;
				}

				if (response.code !== 0) {
					insertFormInput(false);
				}
			});
		}
	});

	$('#system-info').on('click', '.invalid-code', function (e) {
		modalDestroy(true);
		$('#accept').addClass('otp-validate');
		modalOtpValidate();
	});

	$('#system-info').on('click', '#resendCode', function (e) {
		otpProps.reSend = true;
		modalDestroy(true);
		coverSpin(true);
		generateOtp();
	});
});


function generateOtp() {
	data = {
		operationType: otpProps.generateAction,
	}
	who = 'Mfa';
	where = 'GenerateOtp';
	insertFormInput(true);

	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				otpProps.msgContent = response.msg;
				modalOtpValidate();
				$('#accept').addClass('otp-validate');
				insertFormInput(false);
			break;
		}

		coverSpin(false);
	});
}

function modalOtpValidate() {
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

	if (otpChannel === lang.CONF_MFA_CHANNEL_EMAIL || otpProps.generateAction === lang.CONF_MFA_DEACTIVATE) {
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

	appMessages(lang.GEN_MENU_MFA, inputModal, lang.CONF_ICON_INFO, modalBtn);
}

