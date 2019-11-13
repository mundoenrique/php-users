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
var msgLoading = '<span class="spinner-border spinner-border-sm yellow" role="status" aria-hidden="true"></span>Cargando...';

var verb, who, where, data, title, msg, icon, data, dataResponse;

$('input[type=text], input[type=password], input[type=email]').attr('autocomplete', 'off');

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

function notiSystem(title, message, icon = 'ui-icon-closethick', data) {

	var dialogMoldal = $('#system-info');
	var title = title || titleNotiSystem;
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
				dialogMoldal.dialog('close');
				if(btn1.action === 'redirect') {
					$(location).attr('href', btn1.link);
				}
				$(this).off('click');
			});

			$('#cancel').hide();
			if (btn2) {
				$('#cancel')
				.text(btn2.text)
				.on('click', function(e) {
					dialogMoldal.dialog('close');
					if(btn2.action === 'redirect') {
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

// Toggle if navbar menu is open or closed
if (toggleMenu){
	toggleMenu.addEventListener('click', function (){
			collapseMenu.classList.toggle('show');
	});
}

/* Inicio Funciones para Custom Select
	========================================================================== */

// Custom Select
$(".custom-select").each(function () {
	var classes = $(this).attr("class"),
		id = $(this).attr("id"),
		name = $(this).attr("name");
	var template = '<div class="' + classes + '">';
	template +=
		'<span class="custom-select-trigger">' +
		$(this).attr("placeholder") +
		"</span>";
	template += '<div class="custom-options">';
	$(this)
		.find("option")
		.each(function () {
			template +=
				'<span class="custom-option ' +
				$(this).attr("class") +
				'" data-value="' +
				$(this).attr("value") +
				'">' +
				$(this).html() +
				"</span>";
		});
	template += "</div></div>";

	$(this).wrap('<div class="custom-select-wrapper"></div>');
	$(this).hide();
	$(this).after(template);
});

// Custom Option Hover
$(".custom-option:first-of-type").hover(
	function () {
		$(this)
			.parents(".custom-options")
			.addClass("option-hover");
	},
	function () {
		$(this)
			.parents(".custom-options")
			.removeClass("option-hover");
	}
);

// Custom Select Trigger
$(".custom-select-trigger").on("click", function () {
	$("html").on("click", function () {
		$(".custom-select").removeClass("opened");
	});
	$(".custom-select-trigger").not(this)
		.parents(".custom-select")
		.removeClass("opened");
	$(this)
		.parents(".custom-select")
		.toggleClass("opened");
	event.stopPropagation();
});

$(".custom-select option[value='X']").each(function () {
	$(this).remove();
});

// Custom Option
$(".custom-option").on("click", function () {
	$(this)
		.parents(".custom-select-wrapper")
		.find("select")
		.val($(this).data("value"));
	$(this)
		.parents(".custom-options")
		.find(".custom-option")
		.removeClass("selection");
	$(this).addClass("selection");
	$(this)
		.parents(".custom-select")
		.removeClass("opened");
	$(this)
		.parents(".custom-select")
		.find(".custom-select-trigger")
		.text($(this).text());
});

/* Fin Funciones para Custom Select
	========================================================================== */

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
