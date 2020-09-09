'use strict'
var setTimesession;
var resetTimesession;
$(function() {

	clearTimeout(resetTimesession);
	clearTimeout(setTimesession);
	sessionExpire();
});

function sessionExpire() {
	if(sessionTime > 0) {
		setTimesession = setTimeout(function() {
			finishSession()
		}, (sessionTime - callModal));
	}
}

function finishSession() {
	var btnKeepSession = $('#accept');

	if ($('#system-info').parents('.ui-dialog').length) {
		$('#system-info').dialog('destroy');
	}

	btnKeepSession.addClass('btn-large-xl signout');
	data = {
		btn1: {
			text: 'Mantener sesión',
			action: 'close'
		}
	}
	appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_FINISH_TEXT, lang.GEN_ICON_INFO, data);
	btnKeepSession = $('.signout');

	resetTimesession = setTimeout(function() {
		btnKeepSession
		.html(loader)
		.prop('disabled', true);
		$(location).attr('href', baseURL+'cerrar-sesion/fin');
	}, callServer);

	btnKeepSession.on('click', function() {
		$(this).off('click')
		who= 'User'; where = 'KeepSession';
		data = {
			signout: 'logout',
		}
		callNovoCore(who, where, data, function(response) {
			btnKeepSession
			.text(lang.GEN_BTN_ACCEPT)
			.removeClass('btn-large-xl');
		})
	})
}
