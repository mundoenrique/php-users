'use strict'
var currentDate;
var setTimesession;
var resetTimesession;
$(function() {
	currentDate = new Date();
  $.datepicker.regional['es'] = {
    closeText: lang.GEN_PICKER_CLOSETEXT,
    prevText: lang.GEN_PICKER_PREVTEXT,
    nextText: lang.GEN_PICKER_NEXTTEXT,
    currentText: lang.GEN_PICKER_CURRENTTEXT,
    monthNames: lang.GEN_PICKER_MONTHNAMES,
    monthNamesShort: lang.GEN_PICKER_MONTHNAMESSHORT,
    dayNames: lang.GEN_PICKER_DAYNAMES,
    dayNamesShort: lang.GEN_PICKER_DAYNAMESSHORT,
    dayNamesMin: lang.GEN_PICKER_DAYNAMESMIN,
    weekHeader: lang.GEN_PICKER_WEEKHEADER,
    dateFormat: lang.GEN_PICKER_DATEFORMAT,
    firstDay: lang.GEN_PICKER_FIRSTDATE,
    isRTL: lang.GEN_PICKER_ISRLT,
		showMonthAfterYear: lang.GEN_PICKER_SHOWMONTHAFTERYEAR,
		yearRange: lang.GEN_PICKER_YEARRANGE + currentDate.getFullYear(),
		maxDate: currentDate,
		changeMonth: lang.GEN_PICKER_CHANGEMONTH,
    changeYear: lang.GEN_PICKER_CHANGEYEAR,
    showAnim: lang.SHOWANIM,
    yearSuffix: lang.GEN_PICKER_YEARSUFFIX
  };
	$.datepicker.setDefaults($.datepicker.regional['es']);
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

	if ($('#system-info').parents('.ui-dialog:visible').length) {
		$('#system-info').dialog('destroy');
	}

	btnKeepSession.addClass('btn-large-xl signout');
	data = {
		btn1: {
			text: 'Mantener sesión',
			action: 'close'
		}
	}
	notiSystem(lang.GEN_SYSTEM_NAME, lang.GEN_FINISH_TEXT, lang.GEN_ICON_INFO, data);
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
