var base_url, base_cdn, ctasDestino, moneda, pais, editCard, numberBeneficiary = [3 , 2, 1],
	totalTrans, saldoDisp, transferNumber, montoMinOperaciones, montoMaxOperaciones, montoAcumMensual,
	montoMaxMensual, montoAcumSemanal, montoMaxSemanal, montoAcumDiario, montoMaxDiario,
	acumCantidadOperacionesMensual, cantidadOperacionesMensual, acumCantidadOperacionesSemanales,
	cantidadOperacionesSemanales, acumCantidadOperacionesDiarias, cantidadOperacionesDiarias,
	montoComision, nameSource, maskSource, sourceNumber, brand, destination = {}, dobleAutenticacion,
	operationType, expDate, country;

$("#cargandoInfo").hide();
$("#cargandoPhone").hide();
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
    });+

		jQuery.validator.addMethod("onlyLetters", function(value, element) {
        var regEx = /^[A-Za-z0-9\s]+$/,
            token = element.value;

        if (regEx.test(token)) {
            return true;
        } else {
            return false;
        }
    });

		//valida el monto minimo y maximo
		jQuery.validator.addMethod("amountAvailable", function(value, element) {
        var amount = parseFloat(element.value);
	        if (amount > saldoVerifica) {
            return false;
        } else {
            return true;
        }
    });

		//valida el monto minimo y maximo
		jQuery.validator.addMethod("amountsValue", function(value, element) {
        var amount = parseFloat(element.value);
        if (amount < montoMinOperaciones || amount >= montoMaxOperaciones) {
            return false;
        } else {
            return true;
        }
    });


		//valida monto diario
		jQuery.validator.addMethod("amountDay", function(value, element) {
        var amount = parseFloat(element.value);
				var compara = montoAcumDiario + amount;
        if (compara >= montoMaxDiario) {
            return false;
        } else {
            return true;
        }
    });

		//valida monto semanales
		jQuery.validator.addMethod("amountWeek", function(value, element) {
			 var amount = parseFloat(element.value);
			 var compara = montoAcumSemanal + amount;

	        if ( compara >= montoMaxSemanal) {
            return false;
        } else {
            return true;
        }
    });

		//valida monto mensual
		jQuery.validator.addMethod("amountMonth", function(value, element) {

        var amount = parseFloat(element.value);
				var compara = montoAcumMensual + amount;

        if (compara >= montoMaxMensual) {
            return false;
        } else {
            return true;
        }
    });

		//valida operacion Diaria
		jQuery.validator.addMethod("trxDay", function(value, element) {
				var compara = acumCantidadOperacionesDiarias + 1;

        if (compara > cantidadOperacionesDiarias) {
            return false;
        } else {
            return true;
        }
    });

		//valida operacion semanal
		jQuery.validator.addMethod("trxWeek", function(value, element) {
				var compara = acumCantidadOperacionesSemanales + 1;

        if (compara > cantidadOperacionesSemanales) {
            return false;
        } else {
            return true;
        }
    });

		//valida operacion mensual
		jQuery.validator.addMethod("trxMonth", function(value, element) {

        var count = element.value;
				var compara = acumCantidadOperacionesMensual + 1;

        if (compara > cantidadOperacionesMensual) {
            return false;
        } else {
            return true;
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
					beforeSend: function (xrh, status) {
							cleanBefore($("#cargandoPhone"),$("#search-cards"));
					},
					success: function(data){
						cleanComplete($("#cargandoPhone"),$("#search-cards"));
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
								msgService (data.title, data.msg, 'alert-warning', 0);
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
				"descripcion":{"required":true, "minlength":4, "maxlength": 30, 'onlyLetters':true},
				"monto":{"number":true, "required":true, 'amountAvailable':true, 'amountsValue':true, 'amountDay':true, 'amountWeek':true, 'amountMonth':true},
				"ctaDestinoText":{"number":true, "required":true, "minlength":16, "maxlength": 16},
				"ctaDestino":{"required":true},
				"opeMax":{required:true, 'trxDay':true, 'trxWeek':true, 'trxMonth':true },
			},
			messages: {
				"descripcion": {
					required: "El campo descripción no puede estar vacio",
					minlength: "El campo descripción debe contener mínimo 4 caracteres",
					maxlength: "El campo descripción debe contener máximo 30 caracteres",
					onlyLetters : "Este campo no puede contener caracteres especiales."

				},
				"opeMax": {
						trxDay : "Se ha superado la cantidad máxima de transacciones diarias, ha realizado: " + acumCantidadOperacionesDiarias + " transacciones",
						trxWeek : "Se ha superado la cantidad máxima de transacciones semanales, ha realizado: " + acumCantidadOperacionesSemanales + " transacciones",
						trxMonth : "Se ha superado la cantidad máxima de transacciones mensuales, ha realizado: " + acumCantidadOperacionesMensual + " transacciones",
				},
				"monto": {
					required: "El campo monto no puede estar vacio",
					amountAvailable : "El monto de la transferencia excede su saldo disponible",
					number: "El campo monto debe ser numérico y no debe tener caracteres especiales",
					amountsValue: "El monto mínimo de la transacción debe ser "+ moneda +". "+ montoMinOperaciones + " y el máximo "+ moneda +". " + montoMaxOperaciones + "",
					amountDay : "El monto máximo diario que puede transferir es: "+ moneda +". " + montoMaxDiario + ",  hoy a transferido: "+ moneda +". " + montoAcumDiario,
					amountWeek: "El monto máximo semanal que puede transferir es: "+ moneda +". " + montoMaxSemanal + ", esta semana a transferido: "+ moneda +". " + montoAcumSemanal,
					amountMonth : "El monto máximo mensual que puede transferir es: "+ moneda +". " + montoMaxMensual + ", este mes a transferido: "+ moneda +". " + montoAcumMensual,
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

					$('#progress > ul > li	:nth-child(2)')
						.removeClass('current-step-item')
						.addClass('completed-step-item');
					//carga info en la vista de confirmación
					var cuentaDestino = ($("#ctaDestinoText").val() === '') ? $("#ctaDestino").val() : $("#ctaDestinoText").val();
					var ini = cuentaDestino.substring(0,6);
					var fin = cuentaDestino.substring(12,16);
					cuentaDestino = ini + "******" + fin;

					$("#conDescripcion").html($("#descripcion").val());
					$("#conMonto, #conMonto2").html($("#monto").val());
					$("#conCtaOrigen").html($('#donor').find('.product-cardnumber').html());
					$("#conCtaDestino").html(cuentaDestino);

					$('#progress > ul > li:nth-child(1)')
						.addClass('completed-step-item');
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

					var cuentaDestino = ($("#ctaDestinoText").val() === '') ? $("#ctaDestino").val() : $("#ctaDestinoText").val();
					var ajax_data = {
							'ctaOrigen' : $("#ctaOrigen").val(),
							'ctaDestino' : cuentaDestino,
							'monto' : $("#monto").val(),
							'descripcion' : $("#descripcion").val(),
							'pin' : ($("#pin").val()) //hex_md5
					};

					var formData = $.param(ajax_data);
					makeTransferPe(formData, 1);
				},

    }); // VALIDATE
}



//ENVIO DE INFORAMCIÓN AL CONTROLADOR ----------------------------------------------------
function makeTransferPe(formData, token)
{

	$.ajax({
		url: base_url + '/transfererencia/transferPe',
		type: "post",
		data: {data : formData, token : token},
		dataType: 'json',
		beforeSend: function (xrh, status) {
				cleanBefore ($("#cargandoInfo"),$("#continuar"));
		},
		success: function(data) {
			cleanComplete($("#cargandoInfo"),$("#continuar"));
			switch (data.code) {
				case 0:

					//carga datos en la vista de confirmación

					$('#progress > ul > li:nth-child(3)')
						.removeClass('current-step-item')
						.addClass('completed-step-item');

					$("#transfer-date").hide();
					$("#confirmTrxValues").hide();
					$("#pinDiv").hide();

					//Carga datos en la interfaz de confirmación
					$("#confirmacion").show();
					$("#conCtaOrigenTrx").html(data.ctaOrigenMascara);
					$("#conCtaDestinoTrx").html(data.ctaDestinoMascara);
					$("#montoConfirm").html(data.monto);
					$("#conNombreOrigen").html(data.nombreCuentaOrigen);
					$("#conNombreDestino").html(data.nombreCuentaDestino);
					$("#conDescripcionTrx").html(data.descripcion);

					//botones
					$("#finalTrx").show();
					$("#buttonTrx").hide();
					//mueve el progress bar confirm operation

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

				break;

			case 2:
				$("#msgInfoPin").addClass("pinError");
				$("#msgInfoPin").html("El PIN ingresado no coincide, verifique e intente nuevamente.");
				$("#pin").addClass("field-error").removeClass('field-success');
				$("#pin").val("");
				break;

			case 3:
				msgService (data.title, data.msg, 'alert-error', 1);
				break;

			case 4:
				$(location).attr('href', base_url + '/users/error_gral');
				break;

			default:
					//notifica errores
					msgService (data.title, data.msg, 'alert-error', 1);
					break;

			}
		}
	});

}

/*------------------------------------------------------------------------------------------------*/


//Función para enviar mensajes del sistema al usuario
function msgService (title, msg, modalType, redirect) {
	$("#registrar").fadeIn();
	$("#dialogo-movil").dialog({
		title	:title,
		modal	:"true",
		resizable: false,
		closeOnEscape: false,
		draggable:false,
		width	:"440px",
		open	: function(event, ui) {
			$(".ui-dialog-titlebar-close", ui.dialog).hide();
			//Cambia el tipo de alerta - warning - error - success
		  $("#modalType").addClass(modalType);
			$('#msgService').html(msg);
		}

	});
	$("#inva5").click(function(){
		$("#dialogo-movil").dialog("close");
		if(redirect == 1){
			$(location).attr('href', base_url + '/transferencia/pe');
		}
	});
}


function cleanBefore (img, button) {
    img.show();
    button.hide();
}

function cleanComplete (img, button) {
    img.hide();
    button.show();
}
