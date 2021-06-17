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

	notiSystem(titleNotiSystem, txtCloseSession, iconDanger, {
		btn1: {
			text: txtBtnAcceptNotiSystem,
			action: 'redirect',
			link: 'cerrarsesion'
		},
		btn2: {
			text: txtBtnCancelNotiSystem,
			action: 'destroy'
		},
	});

	resetTimesession = setTimeout(function() {
		btnKeepSession
		.html(msgLoading)
		.prop('disabled', true);
		$(location).attr('href', urlBase+'cerrarsesion');
	}, callServer);

	btnKeepSession = $('#cancel');
	btnKeepSession.on('click', function() {
		$(this).off('click')
		who= 'User'; where = 'KeepSession';
		data = {
			signout: 'logout',
		}
		callNovoCore('POST', who, where, data, function(response) {
			btnKeepSession
			.text(txtBtnAcceptNotiSystem);
		})
	})
}

function logoutInformation() {
	notiSystem(titleNotiSystem, txtCloseIdleSession, iconDanger, {
		btn1: {
			action: 'redirect',
			link: 'cerrarsesion',
			text: txtBtnAcceptNotiSystem
		}
	});
}
