'use strict'
var $$ = document;
var toggleMenu = document.getElementsByClassName('navbar-toggler')[0],
	collapseMenu = document.getElementsByClassName('navbar-collapse')[0];

var iconInfo = 'ui-icon-info';
var iconSuccess = 'ui-icon-circle-check';
var iconWarning = 'ui-icon-alert';
var iconDanger = 'ui-icon-closethick';

var msgLoading = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
var msgLoadingWhite = '<span class="spinner-border spinner-border-sm white" role="status" aria-hidden="true"></span>';

var verb, who, where, data, title, msg, icon, data, dataResponse;

var currencyOptions = {
	style: "currency",
	currency: "COP",
	minimumFractionDigits: 2
};

var decimalOptions = {
	minimumFractionDigits: 2
};

$('input[type=text], input[type=password], input[type=email], input[type=radio]').attr('autocomplete', 'off');

$('.big-modal').on('click', function (e) {
	if (window.location.pathname.split("/").pop() === 'listaproducto' && this.classList.contains('inactive')) {
		$(this).off('click');
	} else {
		$('.cover-spin').show(0);
	}
});

(function () {
	var actualPage = window.location.pathname.split("/").pop();

	var itemsMenu = $$.getElementsByClassName('nav-item');
	var structureMenu = {
		atencioncliente: 'customerSupport',
		listaproducto: 'customerSupport',
		vistaconsolidada: 'listProduct',
		detalle: 'listProduct',
		perfil: 'profile',
		reporte: 'reports',
		detallereporte: 'reports'
	};

	if (actualPage !== 'inicio' && structureMenu.hasOwnProperty(actualPage)) {

		for (var i = 0; i < itemsMenu.length; i++) {
			itemsMenu[i].classList.remove('active');
		}
		$$.getElementById(structureMenu[actualPage]).classList.add('active');
	}

	if (isLoadNotiSystem) {
		let dataNotiSystem = {};
		if (redirectNotiSystem){
			dataNotiSystem = {
				btn1: {
					link: redirectNotiSystem,
					action: 'redirect',
					text: txtBtnAcceptNotiSystem
				}
			};
		}
		notiSystem(titleNotiSystem, txtMessageNotiSystem, iconDanger, dataNotiSystem);
	}

})();

function callNovoCore(verb, who, where, data, _response_) {

	var cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);

	var dataRequest = JSON.stringify({
		who: who,
		where: where,
		data: data
	});

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, {
		format: CryptoJSAesJson
	}).toString();
	$.ajax({
		method: verb,
		url: urlBase + 'async-call',
		data: {
			request: dataRequest,
			cpo_name: cpo_cook,
			plot: btoa(cpo_cook)
		},
		context: document.body,
		dataType: 'json'
	}).done(function (response) {
		response = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, {
			format: CryptoJSAesJson
		}).toString(CryptoJS.enc.Utf8));

		if (response.code == codeResp) {
			notiSystem(response.title, response.msg, response.classIconName, response.data);
		}

		_response_(response);

	}).fail(function (xhr) {
		var response = {
			title: titleNotiSystem,
			data: {
				btn1: {
					action: 'close',
					link: false,
					text: txtBtnCloseNotiSystem
				}
			},
			icon: iconDanger
		};
		_response_(response);
	});
}

function formatterDate(date) {
	var dateArray = date.split('/');
	var dateStr = dateArray[1] + '/' + dateArray[0] + '/' + dateArray[2];

	return new Date(dateStr);
}

function createButton(dialogMoldal, elementBotton, valuesButton) {
	valuesButton.text && elementBotton.text(valuesButton.text);
	elementBotton.show();
	elementBotton.on('click', function (e) {
		if (valuesButton.action === 'redirect') {
			$(location).attr('href', valuesButton.link);
		}
		$(this).off('click');
		dialogMoldal.dialog('close');
	});
}

function notiSystem(title, message, icon, data) {

	var dialogMoldal = $('#system-info');
	var title = title || titleNotiSystem;
	var icon = icon || 'ui-icon-closethick';
	var message = message || $('#system-msg').text();
	var btn1 = data.btn1 || {
		link: false,
		action: 'close',
		text: txtBtnAcceptNotiSystem
	};
	var btn2 = data.btn2;

	dialogMoldal.dialog({
		title: title,
		modal: true,
		draggable: false,
		resizable: false,
		closeOnEscape: false,
		minWidth: 370,
		position: {
			my: "center top+200",
			at: "center top",
			of: window
		},
		dialogClass: "border-none",
		classes: {
			"ui-dialog-titlebar": "border-none",
		},
		show: {
			duration: 250
		},
		hide: {
			duration: 250
		},
		open: function (event, ui) {
			$('.ui-dialog-titlebar-close').hide();
			$('#system-icon').addClass(icon);
			$('#system-msg').html(message);
			$('#accept, #cancel').removeClass("ui-button ui-corner-all ui-widget");

			$('#accept')
				.text(btn1.text)
				.on('click', function (e) {
					if (btn1.action !== 'wait') {
						dialogMoldal.dialog('close');
						$(this).off('click');
					}
					if (btn1.action === 'redirect') {
						$(location).attr('href', btn1.link);
					}
				});

			$('#cancel').hide();
			if (btn2) {
				$('#cancel')
					.text(btn2.text)
					.on('click', function (e) {
						dialogMoldal.dialog('close');
						if (btn2.action === 'redirect') {
							$(location).attr('href', btn2.link);
						}
						$(this).off('click');
					})
					.show();
			}
			dialogMoldal.removeClass("none");
		}

	});
}

// Crea campos para formularios en dialog
function createFields(fields) {
	var element, label, formGroup;
	var dialogForm = $(`<form id="formNotiSystem" action="">`);
	for (var field of fields) {
		switch (field.typeElement) {
			case 'text':
				element = $(`<input id="${field.id}" class="form-control" type="text" name="${field.name}" autocomplete="off"></input>`);
				break;

			case 'password':
				element = $(`<input id="${field.id}" class="form-control" type="password" name="${field.name}"></input>`);
				break;

			default:
				break;
		}
		if (field.label !== '') {
			label = $(`<label for="${field['id']}">${field.label}</label>`);
			formGroup = $(`<div class="form-group px-3 pb-1"></div>`).append(label);
		}
		formGroup.append(element, `<div class="help-block"></div>`);
		dialogForm.append(formGroup);
	}
	return dialogForm;
}

// Toggle if navbar menu is open or closed
if (toggleMenu) {
	toggleMenu.addEventListener('click', function () {
		collapseMenu.classList.toggle('show');
	});
}

/* Inicio Opciones por defecto para Datepicker
	========================================================================== */

$.datepicker.regional['es'] = {
	closeText: 'Cerrar',
	prevText: '<Ant',
	nextText: 'Sig>',
	currentText: 'Hoy',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
	dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
	dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
	dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
	weekHeader: 'Sm',
	dateFormat: 'dd/mm/yy',
	firstDay: 1,
	isRTL: false,
	showMonthAfterYear: false,
	yearSuffix: '',
	changeMonth: true,
	changeYear: true,
	showAnim: "slideDown"
};
$.datepicker.setDefaults($.datepicker.regional['es']);

/* Fin Opciones por defecto para Datepicker
========================================================================== */

// Crea elementos html
var createElement = function (tagName, attrs) {

	var el = document.createElement(tagName);
	Object.keys(attrs).forEach((key) => {
		if (attrs[key] !== undefined) {
			el.setAttribute(key, attrs[key]);
		}
	});

	return el;
}

function formatCurrency(locales, options, number) {
	var formatted = new Intl.NumberFormat(locales, options).format(number);
	return formatted;
}
