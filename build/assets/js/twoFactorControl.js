'use strict'
$(function() {
	$('#disableTwoFactor').on('click', function (e) {
		$('#accept').addClass('disable-two-factor');
		e.preventDefault();
		inputModal = lang.USER_SURE_DISABLE_TWO_FACTOR
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
		appMessages(lang.GEN_MENU_TWO_FACTOR_ENABLEMENT, inputModal, lang.CONF_ICON_INFO, modalBtn);

	});

	$('#system-info').on('click', '.disable-two-factor', function (e) {
		e.preventDefault();
		disableTwoFactortInfo();
		$('#accept').removeClass('disable-two-factor');
	});
});

function disableTwoFactortInfo() {
	var data = new Object();
	data.value = '';
	who = 'Mfa'; where = 'DesactivateSecretToken';
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				appMessages(response.title, response.msg, response.icon, response.modalBtn);
			break;
			}
	});
}
