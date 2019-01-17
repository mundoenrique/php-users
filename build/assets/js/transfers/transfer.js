$(function() {
	operationType = 'P2P';
	//CARGA MODAL CTA ORIGEN------------------------------------------------------------------------
	$(".dialog").on('click', function() {

		modalCtasOrigen();

		if(country !== 'Ve') {
			// FUNCION LLAMAR SALDO
			$.each($(".dashboard-item"),function(pos,item){
				$.post(base_url+"/dashboard/saldo",{"tarjeta":$(item).attr("card")},function(data){
					var moneda=$(".dashboard-item").attr("moneda");
					var id=$(".dashboard-item").attr("doc");
					var saldo=data.disponible;
					if (typeof saldo != 'string'){
						saldo="---";
					}

					$(item).find(".dashboard-item-balance").html(moneda+saldo);
				});
			});
		}
	});
	//----------------------------------------------------------------------------------------------

	//OBTENER DATOS CTA ORIGEN----------------------------------------------------------------------
	$(".dashboard-item").click(function() {
		var imagen, tarjeta, marca, mascara, producto, empresa, montoDebitar, cadena, nombre,
			saldoCero, fechaExp, yearNow, fullYearDate, fiveyearLess, fiveYearMore, i,
			yearSelect = [];
		yearNow = new Date();
		fullYearDate = yearNow.getFullYear();
		fiveyearLess = fullYearDate - 5;
		fiveYearMore = fullYearDate + 15;

		for (i = fiveyearLess; i <= fiveYearMore; i++) {
			yearSelect.push(i);
		}

		imagen = $(this).find('img').attr('src');
		tarjeta = $(this).attr('card');
		marca = $(this).attr('marca').toLowerCase();
		mascara = $(this).attr('mascara');
		producto = $(this).attr('producto1');
		empresa = $(this).attr('empresa');
		nombre = $(this).attr('nombre');
		pais = $(this).attr("pais");
		montoDebitar = saldoCero = (pais == 'Pe' || pais == 'Usd') ? '0.00' : '0,00';

		$("#donor").children().remove();

		cadena='<div class="product-presentation" producto="'+producto+'">';
		cadena+=	'<img src="'+imagen+'" width="200" height="130" alt="" />';
		cadena+=			'<div class="product-network '+marca.toLowerCase()+'"></div>';
		cadena+=				'<input id="donor-cardnumber-origen" name="donor-cardnumber" type="hidden" cardOrigen="'+tarjeta+'" />';
		cadena+=			'</div>';
		cadena+=			'<div class="product-info">';
		cadena+=				'<p class="product-cardholder" id="nombreCtaOrigen">'+nombre+'</p>';
		cadena+=				'<p class="product-cardnumber">'+mascara+'</p>';
		cadena+=				'<p class="product-metadata">'+producto+'</p>';
		cadena+=				'<nav class="product-stack">';
		cadena+=					'<ul class="stack">';
		cadena+=						'<li class="stack-item">';
		cadena+=							'<a dialog button product-button rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
		cadena+=						'</li>';
		cadena+=					'</ul>';
		cadena+=				'</nav>';
		cadena+=			'</div>';
		cadena+=	'<div class="product-scheme">';
		cadena+=		'<ul class="product-balance-group" style="margin: 10px 0">';
		cadena+=			'<li>Disponible <span class="product-balance" id="balance-available">' + moneda +' ' + saldoCero + '</span></li>';
		cadena+=			'<li>A debitar <span class="product-balance debitar" monto-transfer id="balance-debit">' + moneda + ' ' + montoDebitar + '</span></li>';
		cadena+=		'</ul>';
		cadena+= 	"<ul class='field-group'>";
		cadena+= 		"<li class='field-group-item'>";
		cadena+= 			"<label for='dayExp'>Fecha de Vencimiento</label>";
		cadena+= 			"<select id='month-exp' name='month-exp' style='margin-right: 5px;'>";
		cadena+=            	"<option value=''>Mes</option>";
		cadena+=				"<option value='01'>01</option>";
		cadena+=				"<option value='02'>02</option>";
		cadena+=				"<option value='03'>03</option>";
		cadena+=				"<option value='04'>04</option>";
		cadena+=				"<option value='05'>05</option>";
		cadena+=				"<option value='06'>06</option>";
		cadena+=				"<option value='07'>07</option>";
		cadena+=				"<option value='08'>08</option>";
		cadena+=				"<option value='09'>09</option>";
		cadena+=				"<option value='10'>10</option>";
		cadena+=				"<option value='11'>11</option>";
		cadena+=				"<option value='12'>12</option>";
		cadena+= 			"</select>";
		cadena+= 			"<select id='year-exp' name='year-exp'>";
		cadena+=				"<option value=''>Año</option>";
		cadena+= 			"</select>";
		cadena+= 		"</li>";
		cadena+=	"</ul>";
		cadena+= '</div>';

		// MOSTRAR DATOS CUENTAS ORIGEN EN LA VISTA PRINCIPAL---------------------------------------
		$("#donor").append(cadena);
		$.each(yearSelect, function(index,value) {
			var lastDigit = value.toString().substring(2,4);
			var yearPrueba =  "<option value='" + lastDigit+"'>" + value + "</option>";
			$("#year-exp").append(yearPrueba);
		});

		$('#wait').show();
		//------------------------------------------------------------------------------------------

		// CARGAR SALDO CUENTAS ORIGEN--------------------------------------------------------------
		$.post(base_url + "/dashboard/saldo", {"tarjeta":$(this).attr("card")},
			function(data) {
				var saldoCtaOrigen = data.disponible;
				if (typeof saldoCtaOrigen != 'string') {
					saldoCtaOrigen = "---";
				}

				$("#balance-available").html(moneda + ' ' + saldoCtaOrigen);
				$("#balance-available").attr("saldo", saldoCtaOrigen);
			});

		$("#agregarCuenta").attr("href","#");
		$("#agregarCuenta").parents("li").removeClass("disabled-group-action-item");

		$.each($(".dashboard-item"), function(pos,item){
			if($(this).hasClass("current-dashboard-item")){
				$(this).removeClass("current-dashboard-item");
			}
		});

		$(this).addClass("current-dashboard-item");
		$("#content-product").dialog("close");
		var nroTarjeta = $(this).attr("card"),
			prefijo = $(this).attr("prefix"),
			operacion = 'P2P';

		getCtasDestino(nroTarjeta, prefijo, operacion)
	});
	//----------------------------------------------------------------------------------------------

	//EDITAR CUENTAS ORIGEN-------------------------------------------------------------------------
	$('#donor').on('click', '.stack-item', function() {
		// DESHABILITAR SELECCIÓN CUENTAS DESTINO
		$(".product-button").addClass("disabled-button");
		$('#tdestino').children().remove();
		$("#tdestino").append(ctasDestino);
		$("#continuar").prop("disabled", true);
		modalCtasOrigen();
	});
	//----------------------------------------------------------------------------------------------

	//OBTENER DATOS DE CTA DESTINO------------------------------------------------------------------
	$('#content-destino').on('click', '.muestraDestino', function() {
		if ($(this).hasClass('disabled-dashboard-item') == true) {
			$("#content-destino").dialog("close");

		} else {
			var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre, number, idAfil;

			imagen = $(this).find('img').attr('src');
			tarjeta = $(this).attr('card');
			marca = $(this).attr('marca');
			mascara = $(this).attr('mascara');
			producto = $(this).attr('producto');
			empresa = $(this).attr('empresa');
			nombre = $(this).attr('nombre');
			idAfil = $(this).attr('id-afil');

			number = editCard ? editCard : countBeneficiary ('get');
			editCard = false;
			$(".edit").remove();

			cadena= '<div class="group" count-Beneficiary = "' + number + '"> ';
			cadena+=    '<div class="product-presentation">';
			cadena+=	    '<img src="'+imagen+'" width="200" height="130" alt="" />';
			cadena+=		'<div class="product-network '+marca.toLowerCase()+'"></div>';
			cadena+=		    '<input id="tarjetaDestino" name="tarjetaDestino" type="hidden" value="'+tarjeta+'" />';
			cadena+=			'<input id="id-afil" name="marcaDestino" type="hidden" value="' + idAfil + '" />';
			cadena+=			'<input id="marca" name="marcaDestino" type="hidden" value="' + producto + '" />';
			cadena+=        '</div>';
			cadena+=		'<div class="product-info">';
			cadena+=			'<p class="product-cardholder">'+nombre+'</p>';
			cadena+=			'<p class="product-cardnumber">'+mascara+'</p>';
			cadena+=			'<p class="product-metadata">'+producto+'</p>';
			cadena+=			'<nav class="product-stack">';
			cadena+=				'<ul class="stack">';
			cadena+=					'<li class="stack-item modifica">';
			cadena+=					    '<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit"></span></a>';
			cadena+=					'</li>';
			cadena+=					'<li class="stack-item elimina">';
			cadena+=					   	'<a rel="section" title="Remover"><span aria-hidden="true" class="icon-cancel"></span></a>';
			cadena+=					'</li>';
			cadena+=				'</ul>';
			cadena+=			'</nav>';
			cadena+=		'</div>';
			cadena+=		'<div class="product-scheme">';
			cadena+=            '<fieldset class="form-inline">';
			cadena+=                '<label for="beneficiary-1x-description" title="Descripción de la transferencia.">Concepto</label>';
			cadena+=                '<input class="field-large mont" id="beneficiary-'+number+'x-description" maxlength="60" name="beneficiary-1x-description" type="text" />';
			cadena+=                '<label for="beneficiary-1x-amount" title="Monto a transferir.">Importe</label>';
			cadena+=                '<div class="field-category"> '+moneda+' ';
			cadena+=                    '<input id="beneficiary-1x-coin" name="beneficiary-1x-coin" type="hidden" value="'+moneda+'."/>';
			cadena+=                '</div>';
			cadena+=                    '<input class="field-small monto dinero" id="beneficiary-'+number+'-amount" maxlength="12" name="beneficiary-1x-amount"/> <br/>';
			cadena+=            '</fieldset>';
			cadena+=        '</div>';
			cadena+= '</div>';

			//MOSTRAR LA TARJETA DESTINO SELECCIONADA
			$("#content_plata #tdestino").append(cadena);
			$("#beneficiary-1x").removeClass("obscure-group");
			$("#content-destino").dialog("close");
			$("#tdestino").children("#btn-destino").remove();
			$("#tdestino").append(ctasDestino);

			marcar_destino();
			modalCtasDestino();
			if(contar_tarjetas() >= 3) {
				$("#tdestino").children("#btn-destino").remove();
			}

			if(contar_tarjetas() > 0){
				$('#continuar').prop('disabled', false);
				$(".product-button").removeClass("disabled-button");
			}
		}
	});
	//----------------------------------------------------------------------------------------------

	//MODIFICAR LA TARJETA DESTINO------------------------------------------------------------------
	$('#content_plata').on('click',".modifica",function(){
		$(this).parents('.group').addClass('edit');
		editCard = $(this).parents('.group').attr('count-beneficiary');
		$("#content-destino").dialog({
			title:"Selección de Cuentas Destino",
			modal:"true",
			width:"940px",
			beforeClose: function( event, ui ) {
				$('.group').removeClass('edit');
				editCard = false;
			},
			open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
	});
	//----------------------------------------------------------------------------------------------

	//ELIMINAR TARJETA DESTINO----------------------------------------------------------------------
	$('#content_plata').on('click',".elimina",function() {
		var numBen =  $(this).parents('.group').attr('count-beneficiary');

		countBeneficiary ('set', numBen);
		$(this).parents('.group').remove();
		marcar_destino();
		if($("#tdestino").find("#btn-destino").length == 0){
			$("#tdestino").append(ctasDestino);
			modalCtasDestino();
			$(".product-button").removeClass("disabled-button");
		}
		if(contar_tarjetas() < 1) {
			$('#continuar').prop('disabled', true);
		}
		sumar_saldo();
	});
	//----------------------------------------------------------------------------------------------

	//Capturar el monto por transferencia
	$('#content_plata').on('keyup','.monto',function() {
		sumar_saldo();
	});
	//----------------------------------------------------------------------------------------------

	//confirmar transferencia-----------------------------------------------------------------------
	$('#content_plata').on('click',".confir", function() {
		var camposInput = true, validateTrans = true,
			expr= /^-?[0-9]+([\,\.][0-9]{0,2})?$/, validateInput = [], dif, msg;

		//Validar campos input----------------------------------------------------------------------
		if($('#month-exp').val() === '') {
			validateInput.push('Seleccione el mes de vencimiento');
			$('#month-exp').addClass('field-error');
			camposInput = false;
		} else {
			$('#month-exp').removeClass('field-error');
		}

		if($('#year-exp').val() === '') {
			validateInput.push('Seleccione el año de vencimiento');
			$('#year-exp').addClass('field-error');
			camposInput = false;
		} else {
			$('#year-exp').removeClass('field-error');
		}

		var validConcept = 0,
			validAmount = 0,
			validStr = 0;
		$.each($('#tdestino > .group > .product-scheme > fieldset')
				.children('input').not('.skip'), function() {
			if($(this).val() === '') {
				$(this).addClass('field-error');
				if($(this).hasClass('field-large') && validConcept === 0){
					validateInput.push('El campo concepto no debe estar vacío.');
					validConcept = 1;
					camposInput = false;
				}
				if($(this).hasClass('monto') && validAmount === 0){
					validateInput.push('El campo importe no debe estar vacío.');
					validAmount = 1;
					camposInput = false;
				}
			} else if($(this).hasClass('monto') && !expr.test($(this).val())) {
				$(this).addClass('field-error');
				camposInput = false;
				if(validStr === 0) {
					validateInput.push('El campo importe solo admite números y máximo dos decimales.');
					validStr = 1;
				}
			} else {
				$(this).removeClass('field-error');
			}
		});
		//------------------------------------------------------------------------------------------

		if(camposInput === true) {
			transferNumber = contar_tarjetas();
			if((pais ==='Pe') || (pais ==='Usd')) {
				saldoDisp = $("#balance-available").attr("saldo").replace(/\,/g, '');
			} else if ((pais === 'Ve') || (pais ==='Co')) {
				saldoDisp = $("#balance-available").attr("saldo").replace(/\./g, '');
				saldoDisp = saldoDisp.replace(',', '.');
			}
			saldoDisp = parseFloat(saldoDisp);
			totalTrans = parseFloat($("#balance-debit").attr('monto-transfer'));

			//Verificar monto de transferencias-----------------------------------------------------
			var validMinMax = 0;
			$.each($('#tdestino > .group > .product-scheme > fieldset')
				.children('input').not('.skip'), function() {
				if($(this).hasClass('monto') && ($(this).val() < montoMinOperaciones ||
				                                 $(this).val() > montoMaxOperaciones)) {
					$(this).addClass('field-error');
					validateTrans = false;
					if(validMinMax === 0 ){
						validateInput.push('Las transferencias deben ser mínimo ' + moneda + ' ' +
						                   montoMinOperaciones + ', máximo ' + moneda + ' ' +
						                   montoMaxOperaciones);
						validMinMax = 1;
					}

				} else {
					$(this).removeClass('field-error');
				}
			});

			if(totalTrans > saldoDisp) {

				validateInput.push('El monto de la transferencia excede su saldo disponible.');
				validateTrans = false;

			} else if((montoAcumMensual + totalTrans) > montoMaxMensual) {

				dif = montoMaxMensual - montoAcumMensual;
				msg = dif === 0 ? '.<br>No puede realizar otra transferencia este mes' : '';

				validateInput.push('El monto máximo mensual que puede transferir es ' + moneda +
				                   ' ' + montoMaxMensual + '.<br>Este mes ha transferido  ' +
				                   moneda + ' ' + montoAcumMensual + msg);

				validateTrans = false;

			} else if((montoAcumSemanal + totalTrans) > montoMaxSemanal) {

				dif = montoMaxSemanal - montoAcumSemanal;
				msg = dif === 0 ? '.<br>No puede realizar otra transferencia esta semana' : '';

				validateInput.push('El monto máximo semanal que puede transferir es ' + moneda +
				                   ' ' + montoMaxSemanal + '.<br>Esta semana ha transferido  ' +
				                   moneda + ' ' + montoAcumSemanal + msg);

				validateTrans = false;

			} else if((montoAcumDiario + totalTrans) > montoMaxDiario) {

				dif = montoMaxDiario - montoAcumDiario;
				msg = dif === 0 ? '.<br>No puede realizar otra transferencia hoy' : '';

				validateInput.push('El monto máximo diario que puede transferir es ' + moneda +
				                   ' ' + montoMaxDiario + '.<br>Hoy ha transferido  ' +
				                   moneda + ' ' + montoAcumDiario + msg);

				validateTrans = false;
			}
			//--------------------------------------------------------------------------------------

			//Verficar cantidad de operaciones------------------------------------------------------
			if((acumCantidadOperacionesMensual + transferNumber) >
			         cantidadOperacionesMensual) {

				dif = cantidadOperacionesMensual - acumCantidadOperacionesMensual;
				msg = dif === 0 ? '.<br>No puede realizar otra operación este mes' : '';

				validateInput.push('Puede realizar: ' + cantidadOperacionesMensual +
				                   ' operaciones mensuales.<br>Este mes ha realizado: ' +
				                   acumCantidadOperacionesMensual + msg);

				validateTrans = false;
			} else if((acumCantidadOperacionesSemanales + transferNumber) >
			          cantidadOperacionesSemanales) {

				dif = cantidadOperacionesSemanales - acumCantidadOperacionesSemanales;
				msg = dif === 0 ? '.<br>No puede realizar otra operación esta semana' : '';

				validateInput.push('Puede realizar: ' + cantidadOperacionesSemanales +
				                   ' operaciones semanales.<br>Esta semana ha realizado: ' +
				                   acumCantidadOperacionesSemanales + msg);
				validateTrans = false;

			} else if((acumCantidadOperacionesDiarias + transferNumber) >
			          cantidadOperacionesDiarias) {

				dif = cantidadOperacionesDiarias - acumCantidadOperacionesDiarias;
				msg = dif === 0 ? '.<br>No puede realizar otra operación hoy' : '';

				validateInput.push('Puede realizar: ' + cantidadOperacionesDiarias +
				                   ' operaciones diarias.<br>Hoy ha realizado: ' +
				                   acumCantidadOperacionesDiarias + msg);

				validateTrans = false;
			}
		}
		//------------------------------------------------------------------------------------------

		if(camposInput === false || validateTrans === false) {
			$('#info-system').dialog({
				title: 'Transferencia entre tarjetas',
				modal: 'true',
				width: '440px',
				draggable: false,
				rezise: false,
				open: function(event, ui) {
					$(".ui-dialog-titlebar-close", ui.dialog).hide();
					$.each(validateInput, function(index, value) {
						$('#content-info').append('<p>' + value + '</p>');
					});
				}
			});
			$('#close-info').on('click', function(){
				$(this).off('click');
				validateInput = [];
				$('#content-info').children().not('span').remove();
				$('#info-system').dialog('close');
			});
		} else {
			//Recopilar información para transferencias---------------------------------------------
			var appendDataTransfer, transferNo = 1;

			nameSource = $('#donor').find('.product-cardholder').html();
			maskSource = $('#donor').find('.product-cardnumber').html();
			sourceNumber = $('#donor').find('#donor-cardnumber-origen').attr('cardOrigen');
			brand = $('#donor').find('.product-metadata').html();
			expDate = $('#month-exp').val() + $('#year-exp').val();

			appendDataTransfer =   '<tr>';
			appendDataTransfer +=      '<td class="data-label"><label>Cuenta Origen</label></td>';
			appendDataTransfer +=      '<td class="data-reference" colspan="2">' + nameSource + '<br/>';
			appendDataTransfer +=          '<span class="highlight">' + maskSource + '</span><br/>';
			appendDataTransfer +=          '<span class="lighten">' + brand + '</span>';
			appendDataTransfer +=      '</td>';
			appendDataTransfer +=  '</tr>';
			appendDataTransfer +=  '<tr>';
			appendDataTransfer +=      '<td class="data-label"><label>Cuentas Destino</label></td>';
			appendDataTransfer +=  '</tr>';

			$('#progress > ul > li:nth-child(1)')
				.removeClass('current-step-item')
				.addClass('completed-step-item');

			$("#cargarConfirmacion").append(appendDataTransfer);
			$.each($('#tdestino').children(':not(.obscure-group)'), function(pos, item){
				destination['account' + pos] = {
					nameDest: $(item).find('.product-cardholder').html(),
					maskDest : $(item).find('.product-cardnumber').html(),
					accountDes : $(item).find('#tarjetaDestino').val(),
					amountDest : $(item).find('.monto').val(),
					conceptDest : $(item).find('.field-large').val(),
					brandDest : $(item).find("#marca").val(),
					idAfil : $(item).find('#id-afil').val(),
					transfer : (transferNo + pos)
				};

				appendDataTransfer = '<tr class="trdestino-' + (transferNo + pos) + '">';
				appendDataTransfer +=    '<td class="data-label"> </td>';
				appendDataTransfer +=    '<td class="data-reference">' + $(item).find('.product-cardholder').html() + '<br/>';
				appendDataTransfer +=        '<span class="highlight">' + $(item).find('.product-cardnumber').html() + '</span><br/>';
				appendDataTransfer +=        '<span class="lighten"> ' + $(item).find("#marca").val() + ' </span>';
				appendDataTransfer +=    '</td>';
				appendDataTransfer +=	'<td class="data-metadata data-resultado">';
				appendDataTransfer +=		'<div class="data-indicator">';
				appendDataTransfer +=		    '<span aria-hidden="true" class="iconoTransferencia"></span>';
				appendDataTransfer +=        '</div>';
				appendDataTransfer +=        '<span class="data-metadata conceptoDestino"></span>';
				appendDataTransfer +=        '<strong>Concepto: </strong>'+$(item).find('.field-large').val()+'<br />';
				appendDataTransfer +=        '<strong>Monto: </strong>';
				appendDataTransfer +=        '<span class="money-amount"> ' + moneda + ' '+changeDecimals(totalTrans)+'<br /> </span>';
				appendDataTransfer +=        '<strong>Estatus: </strong>';
				appendDataTransfer +=        '<span class="money-amount estatus">En espera por confirmación.</span>';
				appendDataTransfer +=    '</td>';
				appendDataTransfer += '</tr>';
				appendDataTransfer += '<tr>';
				appendDataTransfer +=      '<td class="data-spacing" colspan="3"></td>';
				appendDataTransfer += '</tr>';

				$("#cargarConfirmacion").append(appendDataTransfer);
			});

			appendDataTransfer= '<tr>';
			appendDataTransfer+=    '<td class="data-spacing" colspan="3"></td>';
			appendDataTransfer+= '</tr>';
			appendDataTransfer+= '<tr>';
			appendDataTransfer+=    '<td colspan="2"></td>';
			appendDataTransfer+=    '<td class="data-metadata">Total<br/>';
			appendDataTransfer+=        '<span class="money-amount">' + moneda + ' ' + changeDecimals(totalTrans) + '</span>';
			appendDataTransfer+= '</tr>';

			$("#cargarConfirmacion").append(appendDataTransfer);

			$('#progress > ul > li:nth-child(2)')
				.addClass('current-step-item');
			$('#continuar')
				.removeClass('confir')
				.addClass('sol-transfer');

			$("#transfer-date").append($('#confirm-transfer').html());
			$('#affiliate-account, #transfer-date > fieldset, #confirm-transfer').remove();
		}
	});
	//----------------------------------------------------------------------------------------------

	//Solicitar transferencia-----------------------------------------------------------------------
	$('#content_plata').on('click',".sol-transfer", function() {
		$('.sol-transfer').prop('disabled', true);
		$('#next-step').append('<span aria-hidden="true" class="icon-refresh icon-spin"'
		                       + ' style="font-size: 25px; float: right"></span>');

		if(dobleAutenticacion === "S") {
			requestPassword();
		} else if(dobleAutenticacion === "N") {
			makeTransfer(operationType);
		}

	});
	//----------------------------------------------------------------------------------------------

});
/*-----------------------------------------ESPACIO DE FUNCIONES-----------------------------------*/

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

//OBTENER CTAS DESTINO
function getCtasDestino(nroTarjeta, prefijo, operacion)
{
	$.post(base_url + "/transferencia/ctaDestino",
		{"nroTarjeta": nroTarjeta, "prefijo": prefijo,"operacion": operacion},
		function(data) {
			switch (data.rc) {
				case 0:
					$('#wait').hide();
					$(".product-button").removeClass("disabled-button");
					//OBTENER PARÁMETROS DE TRANSFERENCIA
					montoMaxOperaciones = parseFloat(data.parametrosTransferencias[0].montoMaxOperaciones);
					montoMinOperaciones = parseFloat(data.parametrosTransferencias[0].montoMinOperaciones);
					montoMaxDiario = parseFloat(data.parametrosTransferencias[0].montoMaxDiario);
					montoMaxSemanal = parseFloat(data.parametrosTransferencias[0].montoMaxSemanal);
					montoMaxMensual = parseFloat(data.parametrosTransferencias[0].montoMaxMensual);
					cantidadOperacionesDiarias = parseInt(data.parametrosTransferencias[0].cantidadOperacionesDiarias);
					cantidadOperacionesSemanales = parseInt(data.parametrosTransferencias[0].cantidadOperacionesSemanales);
					cantidadOperacionesMensual = parseInt(data.parametrosTransferencias[0].cantidadOperacionesMensual);
					montoAcumDiario = parseFloat(data.parametrosTransferencias[0].montoAcumDiario);
					montoAcumSemanal = parseFloat(data.parametrosTransferencias[0].montoAcumSemanal);
					montoAcumMensual = parseFloat(data.parametrosTransferencias[0].montoAcumMensual);
					acumCantidadOperacionesDiarias = parseInt(data.parametrosTransferencias[0].acumCantidadOperacionesDiarias);
					acumCantidadOperacionesSemanales = parseInt(data.parametrosTransferencias[0].acumCantidadOperacionesSemanales);
					acumCantidadOperacionesMensual = parseInt(data.parametrosTransferencias[0].acumCantidadOperacionesMensual);
					dobleAutenticacion = data.parametrosTransferencias[0].dobleAutenticacion;

					$("#dashboard-beneficiary").empty();

					$.each(data.cuentaDestinoPlata,function(pos,item){
						imagen1=item.nombre_producto.toLowerCase();
						imagen2=normaliza(imagen1);
						imagen3=imagen2.replace(" ", "-");
						imagen4=imagen3.replace(" ", "-");
						imagen=imagen4.replace('/','-');

						cadena = "<li class='dashboard-item "+item.nomEmp+" muestraDestino' card='"+item.noTarjeta+"' nombre='"+item.NombreCliente+"' marca='"+item.marca+"' mascara='"+item.noTarjetaConMascara+"' empresa='"+item.nomEmp+"' producto='"+item.nombre_producto+"' id-afil='"+item.id_afiliacion+"'>";
						cadena += "<a rel='section' class='escogerDestino'>";
						cadena += "<img src='"+base_cdn+"img/products/"+pais+"/"+imagen+".png' width='200' height='130' alt='' />";
						cadena +=  "<div class='dashboard-item-network "+item.marca.toLowerCase()+"'>"+item.marca+"</div>";
						cadena += "<div class='dashboard-item-info'>";
						cadena += "<p class='dashboard-item-cardholder'>"+item.NombreCliente+"</p>";
						cadena +=  "<p class='dashboard-item-cardnumber'>"+item.noTarjetaConMascara+"</p>";
						cadena +=  "<p class='dashboard-item-category'>"+item.nombre_producto+"</p>";
						cadena += "</div>";
						cadena += " </a>";
						cadena +=  "</li>";

						$("#dashboard-beneficiary").append(cadena);

						modalCtasDestino();
					});
					break;
				case -150:
					$("#transfer-date").append($('#without-account').html());
					$('#affiliate-account, #transfer-date > fieldset, #without-account, #next-step')
						.remove();
					$('#progress > ul > li:nth-child(1)')
						.removeClass('current-step-item')
						.addClass('failed-step-item');
					break;
				default:
					$(location).attr('href', base_url + '/users/error_gral');
			}

		});
}
/*------------------------------------------------------------------------------------------------*/
