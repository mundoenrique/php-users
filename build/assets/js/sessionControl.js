'use strict'
var setTimesession;
var resetTimesession;
$(function() {

	sessionControl();

	$('#logout-session').on('click', function (e) {
		e.preventDefault();
		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'redirect',
				link: lang.SETT_LINK_SIGNOUT + lang.SETT_LINK_SIGNOUT_START
			},
			btn2: {
				text: lang.GEN_BTN_CANCEL,
				action: 'none'
			},
		}

		$('#cancel').addClass('keep-session');
		appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_CLOSE_SESSION, lang.SETT_ICON_INFO, modalBtn);
	});

	$('#system-info').on('click', '.keep-session', function(e) {
		e.preventDefault();
		who = 'User';
		where = 'KeepSession';
		data = {
			keep: 'session',
		}
		$('#accept')
			.html(loader)
			.prop('disabled', true);

		modalDestroy(true);
		callNovoCore(who, where, data);
	});
});

function sessionControl () {
	clearTimeout(resetTimesession);
	clearTimeout(setTimesession);

	if(sessionTime > 0) {
		setTimesession = setTimeout(function() {
			keepSession();
		}, (sessionTime - callServer));
	}
}

function keepSession() {
	modalDestroy(true);
	$('#accept').addClass('btn-large-xl keep-session');
	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_KEEP_SESSION,
			action: 'none'
		}
	}

	appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_FINISH_TEXT, lang.SETT_ICON_INFO, modalBtn);

	resetTimesession = setTimeout(function() {
		$('#accept')
			.html(loader)
			.prop('disabled', true);

		$(location).attr('href', baseURL + lang.SETT_LINK_SIGNOUT + lang.SETT_LINK_SIGNOUT_END);
	}, callServer);
}
