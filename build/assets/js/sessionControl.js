'use strict'
var setTimesession;
var resetTimesession;
$(function() {

	clearTimeout(resetTimesession);
	clearTimeout(setTimesession);
	sessionExpire();

	$('#logout-session').on('click', function (e) {
		e.preventDefault();
		logoutInformation();
	});
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
	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_KEEP_SESSION,
			action: 'destroy'
		}
	}
	appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_FINISH_TEXT, lang.CONF_ICON_INFO, modalBtn);
	btnKeepSession = $('.signout');

	resetTimesession = setTimeout(function() {
		btnKeepSession
		.html(loader)
		.prop('disabled', true);
		$(location).attr('href', baseURL + lang.CONF_LINK_SIGNOUT + lang.CONF_LINK_SIGNOUT_END);
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

function logoutInformation() {
	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'redirect',
			link: lang.CONF_LINK_SIGNOUT + lang.CONF_LINK_SIGNOUT_START
		},
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'destroy'
		},
	}

	appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_CLOSE_SESSION, lang.CONF_ICON_INFO, modalBtn);
}
