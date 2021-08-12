'use strict'
var setTimesession;
var resetTimesession;

$(function() {
	if (logged || userId) {
		clearTimeout(resetTimesession);
		clearTimeout(setTimesession);

		sessionExpire();

		$('#cancel.ctrlSession').on('click', function (e) {
			e.preventDefault();

			$('#accept.ctrlSession').prop('disabled', true);
			$('#cancel.ctrlSession').html(msgLoading).prop('disabled', true);

			$(location).attr('href', urlBase+'cerrarsesion');
		});
	}
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
	var btnCloseSession = $('#cancel');

	if ($('#system-info').parents('.ui-dialog').length) {
		$('#system-info').dialog('destroy');
	}

	btnKeepSession.addClass('ctrlSession');
	btnCloseSession.addClass('ctrlSession');

	notiSystem(titleNotiSystem, txtCloseSession, iconDanger, {
		btn1: {
			text: txtBtnStayNotiSystem,
			action: 'destroy'
		},
		btn2: {
			text: txtBtnYesNotiSystem,
			action: 'redirect',
			link: 'cerrarsesion'
		},
	});

	resetTimesession = setTimeout(function() {
		$('#accept.ctrlSession').prop('disabled', true);
		$('#cancel.ctrlSession').html(msgLoading).prop('disabled', true);
		$(location).attr('href', urlBase+'cerrarsesion');
	}, callServer);

	btnKeepSession.on('click', function() {
		$(this).off('click');
		callNovoCore('POST', 'User', 'KeepSession', {signout: 'logout'}, function(response) {
			clearTimeout(resetTimesession);
			clearTimeout(setTimesession);
			sessionExpire();
		})
	})
}

