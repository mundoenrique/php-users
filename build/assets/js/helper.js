'use strict'

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

//icons
var iconSuccess = 'ui-icon-circle-check';
var iconInfo = 'ui-icon-info';
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

var verb, who, where, data, title, msg, icon, data, dataResponse;

$('input[type=text], input[type=password], input[type=textarea]').attr('autocomplete', 'off');

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
		response = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))

		if(response.code === 303){
			notiSystem(response.title, response.msg, response.icon, response.data);
			response.code = 'unanswered';
		}

		if (response.data !== 'finishSession') {
			_response_(response);
		}
	}).fail(function (xhr) {
		console.log(xhr.responseText);
		title = prefixCountry + strCountry;
		icon = iconWarning;
		data = {
			btn1: {
				class: 'novo-btn-primary-modal',
				link: false,
				action: 'close'
			}
		};
		notiSystem(title, null, icon, data);
		var resp = {
			code: 'unanswered'
		}
		_response_(resp);
	});
}

function formatterDate(date) {
	var dateArray = date.split('/');
	var dateStr = dateArray[1] + '/' + dateArray[0] + '/' + dateArray[2];

	return new Date(dateStr);
}

function createButton(dialogMoldal, elementBotton, valuesButton){
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

function notiSystem(title, message, type = 'modal-warning', data) {

	var btnAccept = $('#accept');
	var btnCancel = $('#cancel');
	var dialogMoldal = $('#system-info');
	var message = message || $('#system-msg').text();
	var btn1 = data.btn1 || { link: false, action: 'close', text: btnAccept.text()};
	var btn2 = data.btn2;

	dialogMoldal.dialog({
		modal: 'true',
		title: 'title',
		minHeight: 100,
		draggable: false,
		resizable: false,
		closeOnEscape: false,
		open: function (event, ui) {
			$('.ui-dialog-titlebar-close', ui.dialog).hide();
			//$('#system-type').addClass(icon);
			$('#system-msg').html(message);

			createButton(dialogMoldal, btnAccept, btn1);
			if (!btn2) {
				btnCancel.hide();
				btnAccept.css('margin', '0');
				$('.novo-dialog-buttonset').css('width', '80px');
			}else{
				createButton(dialogMoldal, btnCancel, btn2);
			}
		}
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

$(".custom-select option[value='X']").each(function() {
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
