'use strict'
var $$ = document;
/**
 * lee una propiedad especifica de un elemento html
 * de no indicarse el elemento se toma por defecto el body
 *
 * @param {*} element  elemento al cual quiero extraer su propiedad
 * @param {*} property  propiedad a leer
 * @author pedro torres
 * @date 27/08/2019
 */
function getPropertyOfElement(property, element) {
	var element = element || 'body';
	return $(element).attr(property);
}

// Navbar
var toggleMenu = document.getElementsByClassName('navbar-toggler')[0],
	collapseMenu = document.getElementsByClassName('navbar-collapse')[0];
//icons
var iconInfo = 'ui-icon-info';
var iconSuccess = 'ui-icon-circle-check';
var iconWarning = 'ui-icon-alert';
var iconDanger = 'ui-icon-closethick';
//app
var baseURL = getPropertyOfElement('base-url');
var baseAssets = getPropertyOfElement('asset-url');
var country = getPropertyOfElement('country');
var pais = getPropertyOfElement('pais');
var showDetailsCompanies = getPropertyOfElement('type-over-detail-companies');
var showRazonSocial = getPropertyOfElement('show-razon-social-detail-companies');
var isoPais = pais;
var prefixCountry = country !== 'bp' ? 'Empresas Online ' : '';
var settingsCountry = { bp: 'Conexión Empresas', co: 'Colombia', pe: 'Perú', us: 'Perú', ve: 'Venezuela' };
var strCountry = settingsCountry[country];
var msgLoading = '<span class="spinner-border spinner-border-sm white" role="status" aria-hidden="true"></span>';


var verb, who, where, data, title, msg, icon, data, dataResponse;

$('input[type=text], input[type=password], input[type=email], input[type=radio]').attr('autocomplete', 'off');

(function() {
	var actualPage = window.location.pathname.split("/").pop();

	if ( actualPage !== 'inicio'){
		var itemsMenu = $$.getElementsByClassName('nav-item');
		var structureMenu = {
			atencioncliente: 'customerSupport',
			listaproducto: 'customerSupport',
			vistaconsolidada: 'listProduct',
			detalle: 'listProduct'
		}

		for (var i = 0; i < itemsMenu.length; i++) {
			itemsMenu[i].classList.remove('active');
		}
		$$.getElementById(structureMenu[actualPage]).classList.add('active');
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

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, { format: CryptoJSAesJson }).toString();
	$.ajax({
		method: verb,
		url: urlBase + 'async-call',
		data: { request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook) },
		context: document.body,
		dataType: 'json'
	}).done(function (response) {
		response = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8));

		if (response.code == codeResp) {
			notiSystem(response.title, response.msg, response.classIconName, response.data);
		}

		_response_(response);

	}).fail(function (xhr) {
		title = titleNotiSystem;
		icon = iconDanger;
		data = {
			btn1: {
				action: 'redirect',
				link: uriRedirecTarget,
				text: txtBtnAcceptNotiSystem
			}
		};
		notiSystem(title, null, icon, data);
		_response_(data);
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
	var btn1 = data.btn1 || { link: false, action: 'close', text: txtBtnAcceptNotiSystem };
	var btn2 = data.btn2;

	dialogMoldal.dialog({
		title: title,
		modal: true,
		draggable: false,
		resizable: false,
		closeOnEscape: false,
		minWidth: 370,
		// minHeight: 170,
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
			.on('click', function(e) {
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
				.on('click', function(e) {
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
		formGroup.append(element,`<div class="help-block"></div>`);
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
    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
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
