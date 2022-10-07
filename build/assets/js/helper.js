'use strict'
var screenSize;
var inputModal;
var who, where, dataResponse, cpo_cook, btnText, form, cypherPass;
var loader = $('#loader').html();
var validatePass = /^[\w!@\*\-\?¡¿+\/.,#ñÑ]+$/;
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

	$('#change-lang').on('click', function () {
		who = 'User'; where = 'changeLanguage';
		data = {
			lang: $(this).find('span.text').text()
		};

		callNovoCore(who, where, data, function (response) {
			if (response.code === 0) {
				var url = $(location).attr('href').split("/");
				var currentCodLang = url[url.length - 1];

				if (currentCodLang == lang.GEN_BEFORE_COD_LANG) {
					var module = url[url.length - 2];
					$(location).attr('href', baseURL + module + '/' + lang.GEN_AFTER_COD_LANG);
				} else {
					location.reload();
				}
			}
		});
	});

	if (code > 2) {
		appMessages(title, msg, icon, modalBtn)
	}

	$('.big-modal').on('click', function () {
		$('.cover-spin').show(0)
	});
	//dataTale lang
	dataTableLang = {
		"sLengthMenu": lang.GEN_DATATABLE_SLENGTHMENU,
		"sZeroRecords": lang.GEN_DATATABLE_SZERORECORDS,
		"sEmptyTable": lang.GEN_DATATABLE_SEMPTYTABLE,
		"sInfo": lang.GEN_DATATABLE_SINFO,
		"sInfoEmpty": lang.GEN_DATATABLE_SINFOEMPTY,
		"sInfoFiltered": lang.GEN_DATATABLE_SINFOFILTERED,
		"sInfoPostFix": lang.CONF_DATATABLE_SINFOPOSTFIX,
		"slengthMenu": lang.GEN_DATATABLE_SLENGTHMENU,
		"sSearch": lang.CONF_DATATABLE_SSEARCH,
		"sSearchPlaceholder": lang.GEN_DATATABLE_SSEARCHPLACEHOLDER,
		"sUrl": lang.CONF_DATATABLE_SSEARCH,
		"sInfoThousands": lang.CONF_DATATABLE_SINFOTHOUSANDS,
		"sProcessing": lang.GEN_DATATABLE_SPROCESSING,
		"sloadingrecords": lang.GEN_DATATABLE_SLOADINGRECORDS,
		"oPaginate": {
			"sFirst": lang.GEN_DATATABLE_SFIRST,
			"sLast": lang.GEN_DATATABLE_SLAST,
			"sNext": lang.CONF_DATATABLE_SNEXT,
			"sPrevious": lang.CONF_DATATABLE_SPREVIOUS
		},
		"oAria": {
			"sSortAscending": lang.GEN_DATATABLE_SSORTASCENDING,
			"sSortDescending": lang.GEN_DATATABLE_SSORTDESCENDING
		},
		"select": {
			"rows": {
				_: lang.GEN_DATATABLE_ROWS_SELECTED,
				0: lang.CONF_DATATABLE_ROWS_NO_SELECTED,
				1: lang.GEN_DATATABLE_ROW_SELECTED
			}
		}
	}
	//datepicker
	currentDate = new Date();
  $.datepicker.regional['es'] = {
    closeText: lang.GEN_DATEPICKER_CLOSETEXT,
    prevText: lang.GEN_DATEPICKER_PREVTEXT,
    nextText: lang.GEN_DATEPICKER_NEXTTEXT,
    currentText: lang.GEN_DATEPICKER_CURRENTTEXT,
    monthNames: lang.GEN_DATEPICKER_MONTHNAMES,
    monthNamesShort: lang.GEN_DATEPICKER_MONTHNAMESSHORT,
    dayNames: lang.GEN_DATEPICKER_DAYNAMES,
    dayNamesShort: lang.GEN_DATEPICKER_DAYNAMESSHORT,
    dayNamesMin: lang.GEN_DATEPICKER_DAYNAMESMIN,
		weekHeader: lang.CONF_DATEPICKER_WEEKHEADER,
    dateFormat: lang.CONF_DATEPICKER_DATEFORMAT,
    firstDay: lang.CONF_DATEPICKER_FIRSTDATE,
    isRTL: lang.CONF_DATEPICKER_ISRLT,
		showMonthAfterYear: lang.CONF_DATEPICKER_SHOWMONTHAFTERYEAR,
		yearRange: lang.CONF_DATEPICKER_YEARRANGE + currentDate.getFullYear(),
		minDate: lang.CONF_DATEPICKER_MINDATE,
		maxDate: currentDate,
		changeMonth: lang.CONF_DATEPICKER_CHANGEMONTH,
    changeYear: lang.CONF_DATEPICKER_CHANGEYEAR,
		showAnim: lang.CONF_DATEPICKER_SHOWANIM,
    yearSuffix: lang.CONF_DATEPICKER_YEARSUFFIX
  };
	$.datepicker.setDefaults($.datepicker.regional['es']);

	$("body").on("focus", ".select-search-input", function () {
		var search = $(this).val().trim();
		$(this).val(search || "");
		var selector = $(this).next(".select-search");
		selector.css("display", "block");
		$(this)
			.closest(".select-by-search")
			.find(".close-selector")
			.css("display", "block");
	});

	$("body").on("input", ".select-search-input", function () {
		var selector = $(this).next(".select-search");
		var search = $(this).val().trim();
		selector.find("li").addClass("hidden");
		var matches = selector.find('li:contains("' + search + '")');
		selector.find(".no-results").remove();
		if (matches.length == 0) {
			selector.append(
				'<li class="no-results">' + lang.GEN_NO_RESULTS + '</li>'
			);
		}
		matches.removeClass("hidden");
	});

	$("body").on("click", ".select-search>*:not(.no-results)", function () {
		var value = $(this).attr("value"),
		text = $(this).text().trim(),
		container = $(this).closest(".select-by-search");
		container.find("input.select-search-input").val(text);
		container.find("li").removeClass("active");
		$(this)
			.addClass("active")
			.prependTo(container.find(".select-search"));
		container.find(".select-search").css("display", "none");
		$(".close-selector").css("display", "none");
		container.find("#directory").val(value);
	});

	$("body").on("click", ".close-selector", function () {
		$(".select-search").css("display", "none");
		$(this).css("display", "none");
	});
});

function callNovoCore(who, where, request, _response_) {
	request.screenSize = screen.width;
	var dataRequest = JSON.stringify({
		who: who,
		where: where,
		data: request
	});
	var codeResp = parseInt(lang.CONF_DEFAULT_CODE);
	var formData = new FormData();

	dataRequest = cryptoPass(dataRequest, true);

	if (request.files) {
		data.files.forEach(function (element) {
			formData.append(element.name, element.file);
		});
		delete request.files;
	}

	formData.append('request', dataRequest);

	if (lang.CONF_CYPHER_DATA == 'ON') {
		formData.append('cpo_name', cpo_cook);
		formData.append('plot', btoa(cpo_cook));
	}

	if (logged || userId) {
		clearTimeout(resetTimesession);
		clearTimeout(setTimesession);
		sessionExpire();
	}

	$.ajax({
		method: 'POST',
		url: baseURL + 'novo-async-call',
		data: formData,
		context: document.body,
		cache: false,
		contentType: false,
		processData: false,
		dataType: 'json'
	}).done(function (response, status, jqXHR) {

		if (lang.CONF_CYPHER_DATA == 'ON') {
			response = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))
		}

		var modalClose = response.modal ? false : true;

		if ($('#system-info').parents('.ui-dialog').length && modalClose) {
			$('#accept').prop('disabled', false)
			$('#system-info').dialog('destroy');
		}

		if (response.code === codeResp) {
			appMessages(response.title, response.msg, response.icon, response.modalBtn);
		}

		_response_(response);

	}).fail(function (jqXHR, textStatus, errorThrown) {

		if ($('#system-info').parents('.ui-dialog').length) {
			$('#accept').prop('disabled', false)
			$('#system-info').dialog('destroy');
		}

		var response = {
			code: codeResp,
			modalBtn: {
				btn1: {
					link: redirectLink,
					action: 'redirect'
				}
			}
		};
		appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_SYSTEM_MESSAGE, lang.CONF_ICON_DANGER, response.modalBtn);
		_response_(response);
	});
}

function getCookieValue() {
	return decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);
}

function appMessages(title, message, icon, modalBtn) {
	var btn1 = modalBtn.btn1;
	var btn2 = modalBtn.btn2;
	var maxHeight = modalBtn.maxHeight || 350;

	$('#system-info').dialog({
		title: title || lang.GEN_SYSTEM_NAME,
		closeText: '',
		modal: 'true',
		position: { my: modalBtn.posMy || 'center', at: modalBtn.posAt || 'center' },
		draggable: false,
		resizable: false,
		closeOnEscape: false,
		width: modalBtn.width || lang.CONF_MODAL_WIDTH,
		minWidth: modalBtn.minWidth || lang.CONF_MODAL_WIDTH,
		minHeight: modalBtn.minHeight || 100,
		maxHeight: maxHeight !== 'none' ? maxHeight : false,
		dialogClass: "border-none",
		classes: {
			"ui-dialog-titlebar": "border-none",
		},
		open: function (event, ui) {
			if (!modalBtn.close) {
				$('.ui-dialog-titlebar-close').hide();
			}

			$('#system-icon').removeAttr('class');

			if (icon != '') {
				$('#system-icon').addClass(lang.CONF_ICON + ' ' + icon);
			}

			$('#system-msg').html(message);

			if (!btn1) {
				$('#accept').hide();
			} else {
				createButton($('#accept'), btn1);
			}

			if (!btn2) {
				$('#cancel').hide();
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
		if (thisValInput == null || $(this).attr('type') === 'file') {
			return;
		}
		var trimVal = thisValInput.trim()
		$(this).val(trimVal)
	});
}

function cryptoPass(jsonObject, req) {
	req = req == undefined ? false : req;
	cpo_cook = getCookieValue();
	var cipherObject = jsonObject;

	if (lang.CONF_CYPHER_DATA == 'ON') {
		cipherObject = CryptoJS.AES.encrypt(jsonObject, cpo_cook, { format: CryptoJSAesJson }).toString();

		if (!req) {
			cipherObject = btoa(JSON.stringify({
				password: cipherObject,
				plot: btoa(cpo_cook)
			}));
		}
	}


	return cipherObject;
}

function getDataForm(form) {
	var dataForm = {};
	form.find('input, select, textarea').each(function (index, element) {
		dataForm[$(element).attr('id')] = $(element).val();
	})

	return dataForm
}

function downLoadfiles(data) {
	var File = new Int8Array(data.file);
	var blob = new Blob([File], { type: "application/" + data.ext });
	var url = window.URL.createObjectURL(blob);
	$('#download-file').attr('href', url);
	$('#download-file').attr('download', data.name);
	document.getElementById('download-file').click();
	window.URL.revokeObjectURL(url);
	$('#download-file').attr('href', lang.CONF_NO_LINK);
	$('#download-file').attr('download', '');
	$('.cover-spin').hide();
}

function scrollTopPos(formValidate) {
	var errorElements = $('.has-error');
	var firstElement = $(errorElements[0]).offset().top;

	if (firstElement > 0) {
		$("html, body").animate({
			scrollTop: firstElement - formValidate
		}, 400);
	}
}
