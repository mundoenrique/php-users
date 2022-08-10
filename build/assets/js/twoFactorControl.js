'use strict'
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
		appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, lang.GEN_SURE_DISABLE_TWO_FACTOR, lang.CONF_ICON_INFO, modalBtn);
	});

	$('#system-info').on('click', '.sure-disable-two-factor', function (e) {
		e.preventDefault();
		$('#accept').removeClass('sure-disable-two-factor');
		$('#accept').addClass('disable-two-factor');
		var data = new Object();
		data.value = '';
		who = 'Mfa'; where = 'DesactivateSecretToken';
		callNovoCore(who, where, data, function(response) {
			switch (response.code) {
				case 0:
					modalSecretToken()
				break;
				}
		});
	});

	$('#system-info').on('click', '.disable-two-factor', function (e) {
		e.preventDefault();
		form = $('#twoFactorDisableForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.action = 'disabled';
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
		getSecretToken('resend')
	});

	$('#system-info').on('click', '.resend-code', function (e) {
		$('#accept').removeClass('resend-code');
		$('#accept').addClass('disable-two-factor');
		modalSecretToken()
	});

});


function getSecretToken(method) {
	var data = new Object();
	data.method = method;
	data.channel = $('#channel').val() ?  $('#channel').val() : 'email';
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

function modalSecretToken() {
	$('#cancel').prop('disabled',false);

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
	inputModal += 			'<p>Recuerda que para usar algunas operaciones debes tener activo la autenticación de dos factores.</p>';
	inputModal += 			'<p class=" pb-1">' + lang.GEN_TWO_FACTOR_EMAIL_TEXT +' '+lang.GEN_TWO_FACTOR_SEND_CODE+ ' ';
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

