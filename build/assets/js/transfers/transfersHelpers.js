var base_cdn, base_url, ctasDestino, moneda, pais, editCard, numberBeneficiary = [3 , 2, 1],
	totalTrans, saldoDisp, transferNumber, montoMinOperaciones, montoMaxOperaciones, montoAcumMensual,
	montoMaxMensual, montoAcumSemanal, montoMaxSemanal, montoAcumDiario, montoMaxDiario,
	acumCantidadOperacionesMensual, cantidadOperacionesMensual, acumCantidadOperacionesSemanales,
	cantidadOperacionesSemanales, acumCantidadOperacionesDiarias, cantidadOperacionesDiarias,
	montoComision, nameSource, maskSource, sourceNumber, brand, destination = {}, dobleAutenticacion,
	operationType, expDate;

path = window.location.href.split('/');
base_url = path[0] + '//' + path[2];
base_cdn = base_url + '/assets';

$(function() {
	ctasDestino = $('#tdestino').html();
	moneda = $('#donor').attr('moneda');

	//Menu desplegable transferencias---------------------------------------------------------------
	$('.transfers').hover(function () {
		$('.submenu-transfer').attr("style", "display:block")
	}, function () {
		$('.submenu-transfer').attr("style", "display:none")
	});
	//----------------------------------------------------------------------------------------------

	//Menu desplegable usuario----------------------------------------------------------------------
	$('.user').hover(function () {
		$('.submenu-user').attr("style", "display:block")
	}, function () {
		$('.submenu-user').attr("style", "display:none")
	});
	//----------------------------------------------------------------------------------------------

	//Verifica si fue ingresada la clave de operaciones---------------------------------------------
	var confirmacion = $("#content").attr("confirmacion");
	if (confirmacion == '1') {
		$('#content-clave').hide();
		$('#tabs-menu').show();
		$('#content_plata').show();

	} else {
		$('#content-clave').show();
	}
	//----------------------------------------------------------------------------------------------

	//Boton para confirmar la clave de operaciones--------------------------------------------------
	$("#continuar_transfer").click(function () {
		var pass = $("#transpwd").val();
		if(pass == '') {
			$('#transpwd').addClass('field-error');
		} else {
			$('#transpwd').removeClass('field-error');
			if ((confirmPassOperac(pass))) {
				$('#content-clave').hide();
				$('#tabs-menu').show();
				$('#content_plata').show();
			} else {

				$('#content_clave').show();
				$.balloon.defaults.classname = "field-error";
				$.balloon.defaults.css = null;
				$("#transpwd").showBalloon({position: "right", contents: "Clave inválida"});
				setTimeout(function () {
					$("#transpwd").hideBalloon();

				}, 3000);
			}
		}
	});
	//----------------------------------------------------------------------------------------------
});

//VERIFICAR SI LA CONTRASEÑA DE OPERACIONES ES CORRECTA---------------------------------------------
function confirmPassOperac(clave)
{
	var response;
	var ajax_data = {
		"clave":hex_md5(clave)
	};

	$.ajax({
		url: base_url +"/transferencia/operaciones",
		data: ajax_data,
		type: "post",
		dataType: 'json',
		async: false,
		success: function(data) {
			response = $.parseJSON(data.response);
			switch (response.rc) {
				case 0:
					response = $.parseJSON(data.transferir);
					break;
				case -61:
					$(location).attr('href', base_url + '/users/error_gral');
					break;
				default:
					response = $.parseJSON(data.transferir);

			}
		}
	});

	return response;
}
/*------------------------------------------------------------------------------------------------*/

//MODAL CTAS ORIGEN---------------------------------------------------------------------------------
function modalCtasOrigen()
{
	$("#content-product").dialog({
		title:"Selección de Cuentas Origen",
		modal:"true",
		width:"950px",
		open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
	});
	$("#cerrar").click(function(){
		$("#content-product").dialog("close");
	});
}
/*------------------------------------------------------------------------------------------------*/

//MODAL CTAS DESTINO
function modalCtasDestino()
{
	$('.dialogDestino').on('click', function(){
		$("#content-destino").dialog({
			title:"Selección de Cuentas Destino",
			modal:"true",
			width:"940px",
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
		$("#close").click(function(){
			$("#content-destino").dialog("close");
		});
	});
}

//Sustituye acentos
function normaliza(text)
{
	var acentos = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç";
	var original = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc";
	for (var i=0; i<acentos.length; i++) {
		text = text.replace(acentos.charAt(i), original.charAt(i));
	}

	return text;
}
/*------------------------------------------------------------------------------------------------*/

//OBTENER ID DEL INPUT PARA CTA DESTINO
function countBeneficiary (action, number)
{
	var length = numberBeneficiary.length,
		numBen;

	if(action == 'get') {

		numBen = numberBeneficiary[length - 1];
		numberBeneficiary.pop();
		return numBen;

	} else if(action == 'set') {
		numBen = parseInt(number);
		numberBeneficiary.push(numBen);
	}
}
/*------------------------------------------------------------------------------------------------*/

//DESHABILITAR/HABILITAR SELECCIÓN DE TARJETA DESTINO
function marcar_destino()
{
	$.each($('#dashboard-beneficiary').children('.dashboard-item'), function(posd,itemd) {
		$(itemd).removeClass("disabled-dashboard-item");
		$.each($('#tdestino').children(':not(.obscure-group)'), function(pos, item) {
			if($(item).find("#tarjetaDestino").val()==$(itemd).attr("card")) {
				$(itemd).addClass("disabled-dashboard-item");
			}
		});
	});
}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para contar las tarjetas a las que se la hará la transferencia
 * @return void
 */
function contar_tarjetas()
{
	var count = 0;
	$.each($('#tdestino').children().not('.obscure-group'), function(pos, item) {
		count++
	});
	return count;
}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para sumar el saldo de las transferencias
 * @return void
 */
function sumar_saldo()
{
	var saldoTrans = 0;
	var montoItem;
	$.each($('.dinero'), function(pos, item) {
		montoItem = $(item).val().replace(',', '.');
		if(isNaN(montoItem)) {
			saldoTrans = 0;
			return false;
		}
		if(montoItem !== '') {
			saldoTrans = saldoTrans + parseFloat(montoItem);
		}

	});

	$("#balance-debit").html(moneda + ' ' + changeDecimals(saldoTrans));
	$("#balance-debit").attr('monto-transfer',  saldoTrans);

}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para solicitar la clave de confirmacion
 * @return void
 */
function requestPassword()
{
	var  msg;
	$.ajax({
		url: base_url + '/transferencia/crearClave',
		type: "post",
		dataType: 'json',
		success: function(data) {
			$('#next-step span').remove();
			switch (data.rc) {
				case 0:
					msg = 'Hemos enviado una notificación a su correo electrónico con el código '
					      + 'aleatorio que se solicita a continuación para confirmar la operación '
					      + 'en curso.';
					notiSystem('passReq', 'Verificación requerida.', msg);
					$('#input-pass').focus();
					$('#button-action').on('click', '#send-pass', function() {
						$('#content-input p').remove();
						var inputPass = $('#input-pass').val();
						if(inputPass === '') {
							$('#input-pass').addClass('field-error');
						} else {
							$('#button-action').append('<span aria-hidden="true" '
							                           + 'class="icon-refresh icon-spin" '
							                           + 'style="font-size: 25px; float: right">'
							                           + '</span>');
							$('#send-pass').prop('disabled', true);
							validar_clave(inputPass);
						}
					});

					break;
				case -176:
					msg = 'No fue posible enviar la <strong>clave de confirmación.</strong> '
					      + 'Por favor, intente nuevamente.';
					notiSystem('fail', 'Verificación requerida.', msg);
					break;
				default:
					$(location).attr('href', base_url + '/users/error_gral');

			}
		}
	});
}
//--------------------------------------------------------------------------------------------------

/**
 * @function para verificar la clave de confirmación
 * @param claveConfir
 * @return void
 */
function validar_clave(claveConfir)
{
	var ajax_data = {
		'clave':hex_md5(claveConfir)
	};

	$.ajax({
		url: base_url + '/transferencia/confirmacion',
		data: ajax_data,
		type: "post",
		dataType: 'json',
		success: function(data) {
			$('#button-action span').remove();
			switch (data.rc) {
				case 0:
					$('#info-system').dialog('close');
					$('#next-step').append('<span aria-hidden="true" class="icon-refresh icon-spin"'
					                       + ' style="font-size: 25px; float: right"></span>');
					makeTransfer(operationType);
					break;
				case -22:
					$('#input-pass')
						.addClass('field-error')
						.val('');
					$('#content-input').append('<p style="color: #f04848;">La <strong>clave de '
					                           + 'confirmación</strong> es incorrecta. Por favor, '
					                           + 'verifique e intente nuevamente.</p>');
					$('#send-pass').prop('disabled', false);
					break;
				default:
					$(location).attr('href', base_url + '/users/error_gral');

			}
		}
	});
}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para realizar la transferencia
 * @return void
 */
function makeTransfer(type)
{
	var transfer = 1;
	$.each(destination, function(pos, item) {

		var dataRequest = {
			"cuentaOrigen" : sourceNumber,
			"cuentaDestino" : item.accountDes,
			"monto" : item.amountDest,
			"descripcion" : item.conceptDest,
			"tipoOpe" : type,
			"idUsuario" : nameSource,
			"id_afil_terceros": item.idAfil,
			"expDate" : expDate
		};

		$.ajax({
			url: base_url + '/transferencia/procesar',
			data: dataRequest,
			type: "post",
			dataType: 'json',
			async: false,
			success: function(data) {
				var rc, classR = 'data-error', iconR = 'icon-cancel-sign', transferId = '', msg,
					men = '';
				$('#next-step span').remove();
				$('#button-action span').remove();
				switch (data.rc) {
					case 0:
						transferId = data.dataTransaccion.referencia;
						classR = ('data-success');
						iconR = ('icon-ok-sign');
						msg = 'Transacción exitosa. No. de Referencia: ';
						$('#transfer-success').show();
						break;
					case -61:
						$(location).attr('href', base_url + '/users/error_gral');
						break;
					default:
						rc = data.rc;
						switch(rc) {
							case -340:
								msg = 'Cantidad de dígitos de la cuenta es invalida.';
								break;
							case -341:
								msg = 'El número de cuenta no corresponde al banco.';
								break;
							case -342:
								msg = 'Número de cuenta invalido.';
								break;
							case -343:
								men = transferencia.msg;
								msg = 'Su tarjeta se encuentra bloqueada, código de bloqueo: ' + men.substr(34,35);
								break;
							case -344:
								msg = 'La fecha de vencimiento es incorrecta.';
								break;
							default:
								msg = 'No fue posible realizar la transferencia.';
						}
				}
				$('#titulo > h2').text('Finalización');
				$('#cargarConfirmacion > tr.trdestino-' + (transfer) + ' > td.data-resultado')
					.addClass(classR);
				$('#cargarConfirmacion > tr.trdestino-' + (transfer) + ' > td.data-resultado > '
				  + 'div.data-indicator > span.iconoTransferencia').addClass(iconR);
				$('#cargarConfirmacion > tr.trdestino-' + (transfer) + ' > td.data-resultado > '
				  + 'span.estatus')
					.empty()
					.text(msg + transferId);
			}
		});

		transfer++;
	});

	$('#progress > ul > li:nth-child(2)')
		.removeClass('current-step-item')
		.addClass('completed-step-item');

	$('#progress > ul > li:nth-child(3)')
		.addClass('current-step-item');

	$('#cancel > button')
		.removeAttr('type')
		.text('Finalizar');
	$('#continuar').remove();




}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para cambiar punto decimal de acuerdo al pais
 * @param amount sin punto decimal
 * @return float
 */
function changeDecimals(amount)
{
	var amountDec;
	amountDec =  amount.toFixed(2);

	if(pais == 'Ve' || pais == 'Co') {
		amountDec = amountDec.replace('.', ',')
	}

	return amountDec;
}
/*------------------------------------------------------------------------------------------------*/

/**
 * @function para el modal de respuestas del servicio
 * @param action
 * @param title
 * @param msg
 * @return void
 */
function notiSystem(action, title, msg)
{
	$('#send-pass').remove();
	$('#button-action').children().not('.skip').remove();
	$('#content-info').children().not('.skip').remove();
	$('#content-input').children().not('.skip').remove();
	$('#close-info')
		.text('Aceptar')
		.removeAttr('type', 'reset');

	$('#info-system').dialog({
		title: title,
		modal: 'true',
		width: '440px',
		draggable: false,
		resizable: false,
		focus: false,
		open: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			switch(action) {
				case 'passReq':
					$('#button-action').append('<button id="send-pass">Aceptar</button>');
					$('#close-info')
						.text('Cancelar')
						.attr('type', 'reset');
					$('#content-info')
						.removeClass('alert-warning')
						.addClass('alert-info')
						.append('<p>' + msg + '</p>');
					$('#content-input')
						.append('<input class="field-medium" id="input-pass" name="transpwd" placeholder="Código Aleatorio" type="password" />')
					break;
				case 'fail':
					$('#content-info')
						.removeClass('alert-info')
						.addClass('alert-warning')
						.append('<p>' + msg + '</p>');
					break;
			}
		}

	});
	$('#close-info').on('click', function() {
		$(this).off('click');
		$('#info-system').dialog('close');
		$('.sol-transfer').prop('disabled', false);
	});
}
/*------------------------------------------------------------------------------------------------*/
