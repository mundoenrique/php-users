'use strict';
var traslate
$(function () {
	$('input[type=text], input[type=password], input[type=email]').attr('autocomplete', 'off');
	traslate = $('#traslate').val() === '1' ? true : false;
	assetsClient = cryptography.decrypt(assetsClient.response);

	$.each(assetsClient, function(item, value) {
		window[item] = value
	});

	loader = $('#loader').html();
	validatePass = /^[\w!@\*\-\?¡¿+\/.,#ñÑ]+$/;
	defaultCode = parseInt(lang.SETT_DEFAULT_CODE);

	$('body').on('click', '.pwd-action', function () {
		var pwdInput = $(this).closest('div.input-group').find('.pwd-input')
		var inputType = pwdInput.attr('type');

		if (pwdInput.val() !== '') {
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
		who = 'User';
		where = 'changeLanguage';
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

	$('.big-modal').on('click', function () {
		coverSpin(true);
	});

	if (code > 2) {
		appMessages(title, msg, icon, modalBtn)
	}

	if (response && (response.code === defaultCode)) {
		appMessages(response.title, response.msg, response.icon, response.modalBtn);
	}
});

function callNovoCore(who, where, request, _response_) {
	var formData = new FormData();
	var dataRequest = {
		who: who,
		where: where,
		data: request
	};

	dataRequest = cryptography.encrypt(dataRequest);
	formData.append('request', dataRequest);
	formData.append('cpo_name', cpo_cook);

	if (request.files) {
		request.files.forEach(function (element) {
			formData.append(element.name, element.file);
		});

		delete request.files;
	}

	if (logged || userId) {
		sessionControl();
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
	}).done(function (data, status, jqXHR) {
		response = cryptography.decrypt(data.response);

		var modalClose = response.modal ? false : true;
		modalDestroy(modalClose);

		if (response.code === defaultCode) {
			appMessages(response.title, response.msg, response.icon, response.modalBtn);
		}

		if (_response_) {
			_response_(response);
		}

	}).fail(function (jqXHR, textStatus, errorThrown) {
		modalDestroy(true);

		var response = {
			code: defaultCode,
			modalBtn: {
				btn1: {
					link: redirectLink,
					action: 'redirect'
				}
			}
		};

		appMessages(lang.GEN_SYSTEM_NAME, lang.GEN_SYSTEM_MESSAGE, lang.SETT_ICON_DANGER, response.modalBtn);

		if (_response_) {
			_response_(response);
		}
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
		width: modalBtn.width || lang.SETT_MODAL_WIDTH,
		minWidth: modalBtn.minWidth || lang.SETT_MODAL_WIDTH,
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
				$('#system-icon').addClass(lang.SETT_ICON + ' ' + icon);
			}

			$('#system-msg').html(message);

			if (!btn1) {
				$('#accept').addClass('hide');
			} else {
				createButton($('#accept'), btn1);
			}

			if (!btn2) {
				$('#cancel').addClass('hide');
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
				modalDestroy(true);
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
		form.append('<input type="hidden" name="cpo_name" value="' + cpo_cook + '"></input>');
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
	$('#download-file').attr('href', lang.SETT_NO_LINK);
	$('#download-file').attr('download', '');
	coverSpin(false);
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

function coverSpin(show) {
	show ? $('.cover-spin').show(0) : $('.cover-spin').hide();
}

function modalDestroy(close) {
	if ($('#system-info').parents('.ui-dialog').length && close) {
		$('#system-info').dialog('destroy');
		$('#accept')
			.prop('disabled', false)
			.html(lang.GEN_BTN_ACCEPT)
			.removeClass()
			.addClass(lang.SETT_MODAL_BTN_CLASS['accept'])
			.off('click');
		$('#cancel')
			.prop('disabled', false)
			.removeClass()
			.addClass(lang.SETT_MODAL_BTN_CLASS['cancel'])
			.html(lang.GEN_BTN_CANCEL)
			.off('click');
	}
}

function resetForms(formData) {
	if (formData) {
		if (validator) {
			formData.find('input, select, textarea').each(function () {
				validator.successList.push(this); // Libera errores
				validator.showErrors(); // Elimina los mensajes de error si están presentes
			});
			validator.resetForm(); // Elimina la clase de error en los campos y borrar el historial
			validator.reset(); // Elimina todos los datos de error y éxito
		}
		formData[0].reset();
	}
}
