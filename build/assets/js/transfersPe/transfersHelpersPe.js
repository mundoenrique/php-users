var base_url, base_cdn, ctasDestino, moneda, pais, editCard, numberBeneficiary = [3 , 2, 1],
	totalTrans, saldoDisp, transferNumber, montoMinOperaciones, montoMaxOperaciones, montoAcumMensual,
	montoMaxMensual, montoAcumSemanal, montoMaxSemanal, montoAcumDiario, montoMaxDiario,
	acumCantidadOperacionesMensual, cantidadOperacionesMensual, acumCantidadOperacionesSemanales,
	cantidadOperacionesSemanales, acumCantidadOperacionesDiarias, cantidadOperacionesDiarias,
	montoComision, nameSource, maskSource, sourceNumber, brand, destination = {}, dobleAutenticacion,
	operationType, expDate, country;

base_url = $('body').attr('data-app-url');
base_cdn = $('body').attr('data-app-cdn');
country = $('body').data('country');

$(function() {
	$('#tabs-menu').show();
	$('#content_plata').show();

	moneda = $('#donor').attr('moneda');

	//----------------------------------------------------------------------------------------------

	//Menu desplegable usuario----------------------------------------------------------------------
	$('.user').hover(function () {
		$('.submenu-user').attr("style", "display:block")
	}, function () {
		$('.submenu-user').attr("style", "display:none")
	});

});


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


function validar_campos(valida) {

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    jQuery.validator.addMethod("tokenValid", function(value, element) {
        var regEx = /^[a-zA-Z0-9]+$/,
            token = element.value;

        if (regEx.test(token)) {
            return true;
        } else {
            return false;
        }
    });

		//valida el monto minimo y maximo
		jQuery.validator.addMethod("amountsValue", function(value, element) {
				;
        var amount = element.value;
        if (amount < $("#limitAmount").attr('minAmount') || amount >= $("#limitAmount").attr('maxAmount')) {
            return true;
        } else {
            return false;
        }
    });


		//Valida el formulario de busqueda de cuentas por telefono
		$("#form-search").validate({
			errorElement: "label",
			ignore : ".ignore",
			errorContainer: "#msg-history",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg-history",
			rules: {
				"telefonoDestino":{"number":true, "required":true, "minlength":9, "maxlength": 9}
			},
			messages: {
				"telefonoDestino": {
					required: "El número de teléfono no puede estar vacío",
					number: "El teléfono debe ser numérico y no debe tener caracteres especiales",
					minlength: "El número de teléfono debe tener un mínimo de 7 caracteres",
					maxlength: "El número de teléfono debe tener un máximo de 7 caracteres",
					numOnly: "El teléfono debe ser numérico y no debe tener caracteres especiales",
				}
			},
			submitHandler: function(form) {
				var ajax_data = {
						"telefonoDestino": $("#telefonoDestino").val()
				};
				var data_seralize = $.param(ajax_data);

				//petición de tarjetas por telefono
				$.ajax({
					url: base_url + '/transferencia/peGeneral',
					type: "post",
					data: {data : data_seralize, model : "AccountPhone"},
					datatype: 'JSON',
					success: function(data){
						switch(data.code){
							case 0:
							$('select').empty();
							$('#ctaDestino').append('<option value="" selected>Seleccione una cuenta</option>');
							$.each(data.phone, function (i, item) {
								$('#ctaDestino').append($('<option>', {
										value: item.noTarjeta,
										text : item.noTarjetaConMascara
								}));
							});
							$('#form-trx').find('input, textarea, button, select').attr('disabled',false);
							$("#continuar").attr('disabled',false);

								break;
							case 1:
								$("#telefonoDestino").val('');
								notiSystem('fail',data.title, data.msg)
								break;

						}
					}
				});
			}
		});

		//Valida el formulario de transacción
		$("#form-trx").validate({
			errorElement: "label",
			ignore : ".ignore",
			errorContainer: "#msg-history",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg-history",
			rules: {
				"descripcion":{"required":true, "minlength":4, "maxlength": 30},
				"monto":{"number":true, "required":true, "min":99, "max": 999},
				"ctaDestinoText":{"number":true, "required":true, "minlength":16, "maxlength": 16},
				"ctaDestino":{"required":true},
			},
			messages: {
				"descripcion": {
					required: "El campo descripción no puede estar vacio",
					minlength: "El campo descripción debe contener mínimo 4 caracteres",
					maxlength: "El campo descripción debe contener máximo 30 caracteres",
				},
				"monto": {
					required: "El campo monto no puede estar vacio",
					number: "El campo monto debe ser numérico y no debe tener caracteres especiales",
					min: "El campo monto mínimo debe ser 99 " + montoLabel + ".",
					max: "El campo monto máximo debe ser 999 " + montoLabel + ".",

				},
				"ctaDestinoText": {
					required: "El campo tarjeta no puede estar vacio",
					number: "El campo tarjeta debe ser numérico y no debe tener caracteres especiales",
					minlength: "El campo tarjeta debe contener 16 dígitos",
					maxlength: "El campo tarjeta debe contener 16 dígitos",
				},
				"ctaDestino": {
					required: "El campo tarjeta no puede estar vacio",
				},
			},
			submitHandler: function(form) {

					//carga info en la vista de confirmación
					var cuentaDestino = ($("#ctaDestinoText").val() === '') ? $("#ctaDestino").val() : $("#ctaDestinoText").val();
					var ini = cuentaDestino.substring(0,8);
					var fin = cuentaDestino.substring(12,16);
					cuentaDestino = ini + "****" + fin;

					$("#conDescripcion").html($("#descripcion").val());
					$("#conMonto, #conMonto2").html($("#monto").val());
					$("#conCtaOrigen").html($('#donor').find('.product-cardnumber').html());
					$("#conCtaDestino").html(cuentaDestino);

					$('#progress > ul > li:nth-child(2)')
						.addClass('current-step-item');

					$("#confirmTrxValues").show();
					$("#transfer-date").hide();
					$("#continuar").attr('action','form-trx');
			}
		});

		//Valida el formulario de envio de pin
    $("#form-pin").validate({
			errorElement: "label",
			ignore : "",
			errorContainer: "#msg-history2",
			errorClass: "field-error",
			validClass: "field-success",
			errorLabelContainer: "#msg-history2",
        rules: {
            "pin": {"required": true, tokenValid: true},
        },
        messages: {
            "pin": {
                required:"Debe colocar su código de seguridad",
								tokenValid:"El código de seguridad no puede tener caracteres especiales",
            },
        },
				submitHandler: function(form) {

					var ajax_data = {
							'ctaOrigen' : $("#ctaOrigen").val(),
							'ctaDestino' :$("#ctaDestino").val(),
							'monto' : $("#monto").val(),
							'descripcion' : $("#descripcion").val(),
							'pin' : hex_md5($("#pin").val())
					};
					var formData = $.param(ajax_data);
					makeTransferPe(formData);
				},

    }); // VALIDATE
}



//ENVIO DE INFORAMCIÓN AL CONTROLADOR ----------------------------------------------------
function makeTransferPe(formData)
{
	$.ajax({
		url: base_url + '/transfererencia/transferPe',
		type: "post",
		data: {data : formData},
		dataType: 'json',
		success: function(data) {
			switch (data.code) {
				case 0:

					//carga datos en la vista de confirmación
					$("#transfer-date").hide();
					$("#confirmTrxValues").hide();
					$("#pinDiv").hide();

					//Carga datos en la interfaz de confirmación
					$("#confirmacion").show();
					$("#fecha").html(data.fecha);
					$("#origen").html(data.ctaOrigenMascara);
					$("#destino").html(data.ctaDestinoMascara);
					$("#montoConfirm").html(data.monto);
					$("#nomCuentaDestinoCon").html(data.nombreCuentaOrigen);
					$("#nomCuentaOrigenCon").html(data.nombreCuentaDestino);

					//botones
					$("#finalTrx").show();
					$("#buttonTrx").hide();
					//mueve el progress bar confirm operation
					$('#progress > ul > li:nth-child(3)')
						.addClass('current-step-item');
				break;

				case 1:
					//carga el modal de pin
					$("#pinDiv").show();
					$("#transfer-date").hide();
					$("#confirmTrxValues").hide();
					$("#continuar").attr('action','form-pin');
					$("#ctaOrigen").val();
					$("#ctaDestino").val();
					$("#monto").val();
					$("#descripcion").val();

					//mueve el progress bar a confirm pin
					$('#progress > ul > li	:nth-child(2)')
						.removeClass('current-step-item')
						.addClass('completed-step-item');
				break;

				default:
					//notifica errores
					notiSystem(data.title, data.msg, 'error', 'out');
				break;

			}
		}
	});

}


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
