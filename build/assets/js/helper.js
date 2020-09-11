'use strict'
var screenSize;
var who, where, dataResponse, cpo_cook, btnText, form, cypherPass;
var loader = $('#loader').html();
var validatePass = /^[\w!@\*\-\?¡¿+\/.,#]+$/;
var dataTableLang;
var validator;
var currentDate;
$(function () {
	$('input[type=text], input[type=password], input[type=email]').attr('autocomplete', 'off');

	$('body').on('click', '.pwd-action', function () {
		var pwdInput = $(this).closest('div.input-group').find('.pwd-input')
		var inputType = pwdInput.attr('type');

		if (pwdInput.val() != '') {
			if (inputType === 'password') {
				pwdInput.attr('type', 'text');
				$(this).attr('title', lang.GEN_HIDE_PASS);
			} else {
				pwdInput.attr('type', 'password');
				$(this).attr('title', lang.GEN_SHOW_PASS);
			}
		}
	});

	if (code > 2) {
		appMessages(title, msg, icon, data)
	}

	$('.big-modal').on('click', function () {
		$('.cover-spin').show(0)
	});
	//dataTale lang
	dataTableLang = {
		"sLengthMenu": lang.GEN_TABLE_SLENGTHMENU,
		"sZeroRecords": lang.GEN_TABLE_SZERORECORDS,
		"sEmptyTable": lang.GEN_TABLE_SEMPTYTABLE,
		"sInfo": lang.GEN_TABLE_SINFO,
		"sInfoEmpty": lang.GEN_TABLE_SINFOEMPTY,
		"sInfoFiltered": lang.GEN_TABLE_SINFOFILTERED,
		"sInfoPostFix": lang.GEN_TABLE_SINFOPOSTFIX,
		"slengthMenu": lang.GEN_TABLE_SLENGTHMENU,
		"sSearch": lang.GEN_TABLE_SSEARCH,
		"sSearchPlaceholder": lang.GEN_TABLE_SSEARCHPLACEHOLDER,
		"sUrl": lang.GEN_TABLE_SSEARCH,
		"sInfoThousands": lang.GEN_TABLE_SINFOTHOUSANDS,
		"sProcessing": lang.GEN_TABLE_SPROCESSING,
		"sloadingrecords": lang.SLOADINGRECORDS,
		"oPaginate": {
			"sFirst": lang.GEN_TABLE_SFIRST,
			"sLast": lang.GEN_TABLE_SLAST,
			"sNext": lang.GEN_TABLE_SNEXT,
			"sPrevious": lang.GEN_TABLE_SPREVIOUS
		},
		"oAria": {
			"sSortAscending": lang.GEN_TABLE_SSORTASCENDING,
			"sSortDescending": lang.GEN_TABLE_SSORTDESCENDING
		},
		"select": {
			"rows": {
				_: lang.GEN_TABLE_ROWS_SELECTED,
				0: lang.GEN_TABLE_ROWS_NO_SELECTED,
				1: lang.GEN_TABLE_ROW_SELECTED
			}
		}
	}
	//datepicker
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
		minDate: new Date(lang.GEN_PICKER_MINDATE, 1 - 1, 1),
		maxDate: currentDate,
		changeMonth: lang.GEN_PICKER_CHANGEMONTH,
    changeYear: lang.GEN_PICKER_CHANGEYEAR,
    showAnim: lang.SHOWANIM,
    yearSuffix: lang.GEN_PICKER_YEARSUFFIX
  };
	$.datepicker.setDefaults($.datepicker.regional['es']);
});

function callNovoCore(who, where, request, _response_) {
	request.screenSize = screen.width;
	var dataRequest = JSON.stringify({
		who: who,
		where: where,
		data: request
	});
	var codeResp = parseInt(lang.GEN_DEFAULT_CODE);
	var formData = new FormData();

	dataRequest = cryptoPass(dataRequest, true);

	if (request.file) {
		formData.append('file', request.file);
		delete request.file;
	}
	formData.append('request', dataRequest);
	formData.append('cpo_name', cpo_cook);
	formData.append('plot', btoa(cpo_cook));

	if (logged) {
		clearTimeout(resetTimesession);
		clearTimeout(setTimesession);
		sessionExpire();
	}

	$.ajax({
		method: 'POST',
		url: baseURL + 'async-call',
		data: formData,
		context: document.body,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json'
	}).done(function (response, status, jqXHR) {

		if ($('#system-info').parents('.ui-dialog').length) {
			$('#accept').prop('disabled', false)
			$('#system-info').dialog('destroy');
		}

		response = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))

		if (response.code === codeResp) {
			appMessages(response.title, response.msg, response.icon, response.data);
		}

		_response_(response);

	}).fail(function (jqXHR, textStatus, errorThrown) {

		if ($('#system-info').parents('.ui-dialog').length) {
			$('#accept').prop('disabled', false)
			$('#system-info').dialog('destroy');
		}

		var response = {
			code: codeResp,
			data: {
				btn1: {
					link: logged ? lang.GEN_LINK_CARDS_LIST : 'inicio',
					action: 'redirect'
				}
			}
		};
		appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_SYSTEM_MESSAGE, lang.GEN_ICON_DANGER, response.data);
		_response_(response);
	});
}

function getCookieValue() {
	return decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);
}

function appMessages(title, message, icon, data) {
	var btn1 = data.btn1;
	var btn2 = data.btn2;
	var maxHeight = data.maxHeight || 350;

	$('#system-info').dialog({
		title: title || lang.GEN_SYSTEM_NAME,
		modal: 'true',
		position: { my: data.posMy || 'center', at: data.posAt || 'center' },
		draggable: false,
		resizable: false,
		closeOnEscape: false,
		width: data.width || lang.CONF_MODAL_WIDTH,
		minWidth: data.minWidth || lang.CONF_MODAL_WIDTH,
		minHeight: 100,
		maxHeight: maxHeight !== 'none' ? maxHeight : false,
		dialogClass: "border-none",
		classes: {
			"ui-dialog-titlebar": "border-none",
		},
		open: function (event, ui) {
			$('.ui-dialog-titlebar-close').hide();
			var classIcon = $('#system-icon').attr('class').split(' ');
			classIcon = classIcon.pop();

			if (classIcon != 'mt-0') {
				$('#system-icon').removeClass(classIcon);
			}

			$('#system-icon').addClass(icon);
			$('#system-msg').html(message);
			$('#accept, #cancel').removeClass("ui-button ui-corner-all ui-widget");

			if (!btn1) {
				$('#accept').hide();
			} else {
				createButton($('#accept'), btn1);
			}

			if (!btn2) {
				$('#cancel').hide();
				$('#accept').addClass('modal-btn-primary');
				$('.novo-dialog-buttonset').addClass('modal-buttonset');
			} else {
				createButton($('#cancel'), btn2);
			}
		}
	});
}

function createButton(elementButton, valuesButton) {
	elementButton.text(valuesButton.text);
	elementButton.show();
	elementButton.on('click', function (e) {
		switch (valuesButton.action) {
			case 'redirect':
				$(this)
					.html(loader)
					.prop('disabled', true);
				$(this).children('span').addClass('spinner-border-sm');
				if ($(this).attr('id') == 'cancel') {
					$(this).children('span')
						.removeClass('secondary')
						.addClass('primary');
				}
				$(location).attr('href', baseURL + valuesButton.link);
				break;
			case 'close':
				$('#system-info').dialog('close');
				break;
			case 'destroy':
				$('#system-info').dialog('destroy');
				break;
		}

		$(this).off('click');
	});
}

function insertFormInput(disabled, form) {
	form = form == undefined ? false : form;
	var notDisabled = '#product-select, #enterprise-widget-btn'

	if (disabled) {
		notDisabled = false;
	}

	$('form button, form select, form textarea, form input:not([type=hidden]), button')
		.not(notDisabled)
		.not('.btn-modal')
		.prop('disabled', disabled);

	if (form) {
		cpo_cook = getCookieValue();
		screenSize = screen.width;
		form.append('<input type="hidden" name="cpo_name" value="' + cpo_cook + '"></input>');
		form.append('<input type="hidden" name="screenSize" value="' + screenSize + '"></input>');
	}
}

function getPropertyOfElement(property, element) {
	var element = element || 'body';
	return $(element).attr(property);
}

function formInputTrim(form) {
	form.find('input, select, textarea').each(function () {
		var thisValInput = $(this).val();
		if(thisValInput == null) {
			return;
		}
		var trimVal = thisValInput.trim()
		$(this).val(trimVal)
	});
}

function cryptoPass(jsonObject, req) {
	req = req == undefined ? false : req;
	cpo_cook = getCookieValue();
	var cipherObject = CryptoJS.AES.encrypt(jsonObject, cpo_cook, { format: CryptoJSAesJson }).toString();

	if(!req) {
		cipherObject = btoa(JSON.stringify({
			password: cipherObject,
			plot: btoa(cpo_cook)
		}));
	}

	return cipherObject;
}

function getDataForm(form) {
	var dataForm = {};
	form.find('input, select, textarea').each(function (index, element) {
		dataForm[$(element).attr('id')] = $(element).val().trim()
	})

	return dataForm
}

function downLoadfiles (data) {
	var File = new Int8Array(data.file);
	var blob = new Blob([File], {type: "application/"+data.ext});
	var url = window.URL.createObjectURL(blob);
	$('#download-file').attr('href', url);
	$('#download-file').attr('download', data.name);
	document.getElementById('download-file').click();
	window.URL.revokeObjectURL(url);
	$('#download-file').attr('href', lang.GEN_NO_LINK);
	$('#download-file').attr('download', '');
	$('.cover-spin').hide();
}
