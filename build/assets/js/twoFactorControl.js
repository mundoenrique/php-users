'use strict'
$(function() {
	$('#disableTwoFactor').on('click', function (e) {
		e.preventDefault();
		$('#accept').addClass('sure-disable-two-factor');
		$('#cancel').removeAttr('disabled');
		$('#accept').removeClass('sensitive-btn disable-two-factor');
		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'none'
			},
			btn2: {
				text: lang.GEN_BTN_CANCEL,
				action: 'none'
			},
		}
		appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, lang.GEN_TWO_FACTOR_SURE_DISABLE, lang.CONF_ICON_INFO, modalBtn);
	});

	$('#system-info').on('click', '.sure-disable-two-factor', function (e) {
		e.preventDefault();
		$('#accept').removeClass('sure-disable-two-factor');
		$('#accept').addClass('disable-two-factor');
		$(this).html(loader);
		disableSecretToken(true);
	});

	$('#system-info').on('click', '.disable-two-factor', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		form = $('#twoFactorDisableForm');
		validateForms(form);
		if (form.valid()) {
			$(this).html(loader);
			data = getDataForm(form);
			data.operationType = lang.CONF_MFA_DESACTIVATE_SECRET_TOKEN;
			insertFormInput(true);
			who = 'Mfa'; where = 'ValidateOTP2fa';
			callNovoCore(who, where, data, function(response) {
				switch (response.code) {
					case 2:
						appMessages(response.title, response.msg, response.icon, response.modalBtn);
					break;
				}
			});
		}
	});

	$('#system-info').on('click', '#resendCode', function (e) {
		$('#accept').removeClass('disable-two-factor');
		$('#accept').addClass('resend-code');
		disableSecretToken(false);
	});

	$('#system-info').on('click', '#cancel', function (e) {
		$('#system-info').dialog('destroy');
	});

});


function disableSecretToken (action){
	var data = new Object();
	data.resendDisableSecretToken = action;
	who = 'Mfa'; where = 'DesactivateSecretToken';
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				modalSecretToken(response)
			break;
			case 2:
				appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, response.msg, response.icon, response.modalBtn);
				$('#system-info').on('click', '.resend-code', function (e) {
					$('#accept').removeClass('resend-code');
					$('#accept').addClass('disable-two-factor');
					modalSecretToken(response)
				});
			break;
			}
	});
}

function modalSecretToken(response) {
	$('#cancel').prop('disabled',false);

	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'none'
		},
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'none'
		},
		maxHeight : 600,
		width : 530,
		posMy: 'top+60px',
		posAt: 'top+50px'
	}

	inputModal = '<form id="twoFactorDisableForm" name="formTwoFactorDisable" class="mr-2" method="post" onsubmit="return false;">';
	inputModal += 	'<div class="justify pr-1">';
	inputModal += 		'<div class="justify pr-1">';
	inputModal += 			'<p>'+lang.GEN_TWO_FACTOR_REMEMBER+'</p>';
	inputModal += 			'<p class=" pb-1">' + response.msg +' '+lang.GEN_TWO_FACTOR_SEND_CODE+ ' ';
	inputModal += 				'<a id="resendCode" href="#" class="btn btn-small btn-link p-0" >'+lang.GEN_BTN_RESEND_CODE+'</a>';
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

