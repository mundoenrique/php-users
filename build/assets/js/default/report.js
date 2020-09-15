var fecha = new Date();
fecha = fecha.getFullYear();
var i = 0;
var anio, fechaIni, fechaFin, tipoConsulta, producto, tipoConsulta, reporte;
var imagen, tarjeta, marca, mascara, producto, empresa, cadena, nombre, tipo;
var skin = $('body').attr('data-app-skin');

$(function () {
	//Menu desplegable transferencia
	$('.transfers').hover(function () {
		$('.submenu-transfer').attr("style", "display:block")
	}, function () {
		$('.submenu-transfer').attr("style", "display:none")
	});
	//Menu desplegable usuario
	$('.user').hover(function () {
		$('.submenu-user').attr("style", "display:block")
	}, function () {
		$('.submenu-user').attr("style", "display:none")
	});
	$("#filter-range-to, #filter-range-from").on('focus', function() {
		$(this)
			.removeClass('field-error')
			.attr('placeholder', 'DD/MM/AAAA')
	});
	dialogo();

	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: 'Previo',
		nextText: 'Próximo',
		monthNames: [
			'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
			'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
		],
		monthNamesShort: [
			'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
			'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'
		],
		monthStatus: 'Ver otro mes',
		yearStatus: 'Ver otro año',
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		dateFormat: 'dd/mm/yy',
		firstDay: 0,
		maxDate: 0,
		initStatus: 'Selecciona la fecha',
		isRTL: false
	};

	$.datepicker.setDefaults($.datepicker.regional['es']);

	$("#filter-range-from").datepicker({
		onSelect: function (selectedDate) {
		$(this)
		.focus()
		.blur();
		var dateSelected = selectedDate.split('/');
		dateSelected = dateSelected[1] + '/' + dateSelected[0] + '/' + dateSelected[2];
		var maxTime = new Date(dateSelected);
		var currentDate = new Date();

			$('#filter-range-to').datepicker('option', 'minDate', selectedDate);
			maxTime.setMonth(maxTime.getMonth() + 1);
			if (currentDate > maxTime) {
				$('#filter-range-to').datepicker('option', 'maxDate', maxTime);
			} else {
				$('#filter-range-to').datepicker('option', 'maxDate', currentDate);
			}
		}
	});

	$("#filter-range-to").datepicker();

	$(".dashboard-item").on('click', function (event) {
		event.preventDefault();

		imagen = $(this).find('img').attr('src');
		tarjeta = $(this).attr('card');
		marca = $(this).attr('marca');
		mascara = $(this).attr('mascara');
		producto = $(this).attr('producto1');
		empresa = $(this).attr('empresa');
		nombre = $(this).attr('nombre');
		idexper = $(this).attr('idpersona');
		tipo = $(this).attr('tipo');
		id = $(this).attr('id');
		prefix = $(this).attr('prefix');


		$("#donor").children().remove();
		disableElements();

		var rangeBottom = $('#filter-range-from');
		var rangeTop = $('#filter-range-to');
		rangeBottom.val('');
		rangeBottom.removeClass('field-success');
		rangeBottom.removeClass('field-error');
		rangeTop.val('');
		rangeTop.removeClass('field-success');
		rangeTop.removeClass('field-error');

		cadena = '<div class="product-presentation">';
		cadena += '<img src="' + imagen + '" width="200" height="130" alt="" />';
		cadena += '<div class="product-network ' + marca + '"></div>';
		cadena += '<input id="donor-cardnumber" name="donor-cardnumber" prefix="' + prefix + '" tarjeta="' + tarjeta + '" idexper="' + idexper + '" tipo="' + tipo + '" type="hidden" value="' + tarjeta + '" />';
		cadena += '</div>';
		cadena += '<div class="productoct-info-full">';
		cadena += '<p class="product-cardholder">' + nombre + ' <span class="product-cardholder-id">' + id + ' ' + idexper + '</span></p>';
		cadena += '<p class="product-cardnumber">' + mascara + '</p>';
		cadena += '<p class="product-metadata">' + producto + '</p>';
		cadena += '<nav class="product-stack">';
		cadena += '<ul class="stack">';
		cadena += '<li class="stack-item dialog">';
		cadena += '<a rel="section" title="Seleccionar otra cuenta"><span aria-hidden="true" class="icon-edit dialog"></span></a>';
		cadena += '</li>';
		cadena += '</ul>';
		cadena += '</nav>';
		cadena += '</div>';


		$("#donor").append(cadena);
		$("#content-product").dialog("close");
		dialogo();

		producto = $("#donor").find("#donor-cardnumber").attr('prefix');
		var fecha = new Date();
		var anio = fecha.getFullYear();
		fechaIni = "01/01/" + anio;
		fechaFin = "31/12/" + anio;
		tipoConsulta = "0";
		generar_info(tarjeta, tipoConsulta, producto, idexper, fechaIni, fechaFin, "anual");
	});


	$("#grafico").on('click', function () {
		$("#chart").show();
		$("#results").hide();
		$("#chart").children("svg").css("width", "910px");

	});

	$("#detalle").on('click', function () {
		$("#chart").hide();
		$("#results").show();
	});

	$("#mens").on('click', function (e) {
		e.preventDefault();
		var date = /^(0?[1-9]|[12][0-9]|3[01])\/(0?[1-9]|1[012])\/[0-9]{4}$/
		var fechaIni = $("#filter-range-from");
		var fechaFin = $("#filter-range-to");
		var valid = true;

		if (!date.test(fechaIni.val())) {
			fechaIni.addClass('field-error');
			fechaIni.attr('placeholder', 'Formato incorrecto');
			valid = false;
		}

		if (!date.test(fechaFin.val())) {
			fechaFin.addClass('field-error');
			fechaFin.attr('placeholder', 'Formato incorrecto');
			valid = false;
		}

		if (valid) {
			disableElements();
			tipoConsulta = "1";
			fechaIni = fechaIni.val();
			fechaFin = fechaFin.val();
			generar_info(tarjeta, tipoConsulta, producto, idexper, fechaIni, fechaFin, "mensual");
		}
	});

	$("#export_pdf").click(function (event) {
		event.preventDefault();
		if (reporte == false) {
			$("#report-detail").children().remove();
			$("#chart").children().remove();
			cadena = '<div id="empty-state" style="position: static;">';
			cadena += '<h2>No se encontraron movimientos</h2>';
			cadena += '<p>Vuelva a realizar la busqueda con un filtro distinto para obtener resultados.</p>';
			cadena += '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>';
			cadena += '</div>';
			$("#report-detail").append(cadena);
			$("#chart").append(cadena);
		}
		else {
			$("#tarjeta_pdf").val($("#donor-cardnumber").attr("tarjeta"));
			$("#idpersona_pdf").val(idexper);
			$("#producto_pdf").val($("#donor-cardnumber").attr("prefix"));
			$("#tipoConsulta_pdf").val(tipoConsulta);
			$("#fechaIni_pdf").val(fechaIni);
			$("#fechaFin_pdf").val(fechaFin);
			$("#idOperation").val('5');
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
			$('#form_pdf').append('<input type="hidden" name="cpo_name" value="' + cpo_cook + '">');
			$("#form_pdf").submit();
		}

	});

	$("#export_excel").click(function (event) {
		event.preventDefault();
		if (reporte == false) {
			$("#report-detail").children().remove();
			$("#chart").children().remove();
			cadena = '<div id="empty-state" style="position: static;">';
			cadena += '<h2>No se encontraron movimientos</h2>';
			cadena += '<p>Vuelva a realizar la busqueda con un filtro distinto para obtener resultados.</p>';
			cadena += '<span aria-hidden="true" class="icon-cancel-sign" style="position: relative;right: -410px;"></span>';
			cadena += '</div>';
			$("#report-detail").append(cadena);
			$("#chart").append(cadena);
		}
		else {
			$("#tarjeta").val($("#donor-cardnumber").attr("tarjeta"));
			$("#idpersona").val(idexper);
			$("#producto").val($("#donor-cardnumber").attr("prefix"));
			$("#tipoConsulta").val(tipoConsulta);
			$("#fechaIni").val(fechaIni);
			$("#fechaFin").val(fechaFin);
			$("#idOperation").val('5');
			var cpo_cook = decodeURIComponent(
				document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
			);
			$('#form').append('<input type="hidden" name="cpo_name" value="' + cpo_cook + '">');
			$("#form").submit();
		}

	});

});

function dialogo() {
	$(".dialog").click(function (event) {
		event.preventDefault();

		$("#content-product").dialog({
			title: "Seleccion de Cuentas Origen",
			modal: "true",
			width: "940px",
			open: function (event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); }
		});
		$("#cerrar").click(function () {
			$("#content-product").dialog("close");
		});

		var $container = $('#dashboard-donor');

		$container.isotope({
			itemSelector: '.dashboard-item',
			animationEngine: 'jQuery',
			animationOptions: {
				duration: 800,
				easing: 'easeOutBack',
				queue: true
			}
		});

		var $optionSets = $('#filters-stack .option-set'),
			$optionLinks = $optionSets.find('a');

		$optionLinks.click(function (event) {
			event.preventDefault();

			var $this = $(this);
			// don't proceed if already selected
			if ($this.hasClass('selected')) {
				return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');

			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[key] = value;
			if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
				// changes in layout modes need extra logic
				changeLayoutMode($this, options)
			} else {
				// otherwise, apply new options
				$container.isotope(options);
			}

			return false;
		});
	});

	$('li.stack-item a').click(function () {
		$('.stack').find('.current-stack-item').removeClass('current-stack-item');
		$(this).parents('li').addClass('current-stack-item');
	});
}

function generar_info(tarjeta, tipo, producto, idpersona, fechaIni, fechaFin, consulta) {
	$("#mens").addClass("disabled-button");  //Habilita el boton buscar del filtro
	$("#filter-range-from").prop("disabled", true);
	$("#filter-range-to").prop("disabled", true);
	$('#empty-state > h2').text('');
	$('#empty-state > p').text('');
	$('#empty-state').show();
	$("#dialog").show();

	var moneda = $("#reporte").attr("moneda");

	var cpo_cook = decodeURIComponent(
		document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
	);

	var dataRequest = JSON.stringify({
		tarjeta: tarjeta,
		idpersona: idpersona,
		tipo: tipo,
		producto: producto,
		fechaIni: fechaIni,
		fechaFin: fechaFin
	});

	dataRequest = CryptoJS.AES.encrypt(dataRequest, cpo_cook, { format: CryptoJSAesJson }).toString();

	$.post(base_url + "/report/CallWsGastos", { request: dataRequest, cpo_name: cpo_cook, plot: btoa(cpo_cook) }, function (response) {
		$("#mens").removeClass("disabled-button");
		$("#filter-range-from").prop("disabled", false);
		$("#filter-range-to").prop("disabled", false);
		$('#mens').prop('disabled', false);
		$("#dialog").css("display", "none");

		data = JSON.parse(CryptoJS.AES.decrypt(response.code, response.plot, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))

		switch (data.rc) {
			case 0:
				genreteResult(data, moneda, consulta)
				break;
			case -150:
				$('#empty-state > h2').text('No se encontraron registros');
				$('#empty-state > p').text('Seleccione un rango de fecha a consultar.');
				break;
			case -9999:
				$('#empty-state > h2').text('Atención');
				$('#empty-state > p').text('Combinación de caracteres no válida.');
				break;
			default:
				$(location).attr('href', base_url + '/users/error_gral');
		}
	});
}

function genreteResult(data, moneda, consulta) {
	$("#download-boxes").show();
	$("#results").show();
	$("#empty-state").hide();
	$('#grafico').prop('disabled', false);
	$('#detalle').prop('disabled', false).prop('checked', true);
	var jsonChart = {
		seriesDefaults: {
			labels: {
				template: "#= category #  #= kendo.format('{0:P}')#",
				position: "outsideEnd",
				visible: false,
				background: "transparent",
				format: moneda + " {0}"
			}
		},
		seriesColors: ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#f1c40f", "#e67e22", "#e74c3c", "#16a085", "#27ae60", "#2980b9"],
		series: [{
			type: "pie",
			overlay: {
				gradient: "none"
			},
			data: []
		}],
		legend: {
			visible: true
		},
		categoryAxis: {
			categories: []
		},
		tooltip: {
			visible: true,
			template: "${category} - " + moneda + " ${value}"
		}
	}
	var datos = {};
	$.each(data.listaGrafico[0].categorias, function (posLista, itemLista) {
		jsonChart.categoryAxis.categories.push(itemLista.nombreCategoria);
	});

	var info = data;
	$.each(info.listaGrafico[0].categorias, function (posLista, itemLista) {
		$.each(info.listaGrafico[0].series, function (pos, item) {
			datos = {};
			datos.category = itemLista.nombreCategoria;
			datos.value = parseFloat(item.valores[posLista]);
			jsonChart.series[0].data.push(datos);
		});
	});

	$("#chart").kendoChart(jsonChart);

	if (consulta == "anual") {
		$("#report-annual").show();

		$.each(data.listaGrupo, function (posLista, itemLista) {
			$.each(itemLista.gastoMensual, function (pos, item) {
				if (item.mes == "ENERO") {
					tr = $("#enero");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}
				if (item.mes == "FEBRERO") {
					tr = $("#febrero");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "MARZO") {
					tr = $("#marzo");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "ABRIL") {
					tr = $("#abril");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "MAYO") {
					tr = $("#mayo");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "JUNIO") {
					tr = $("#junio");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "JULIO") {
					tr = $("#julio");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "AGOSTO") {
					tr = $("#agosto");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "SEPTIEMBRE") {
					tr = $("#septiembre");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "OCTUBRE") {
					tr = $("#octubre");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "NOVIEMBRE") {
					tr = $("#noviembre");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

				if (item.mes == "DICIEMBRE") {
					tr = $("#diciembre");
					td = $(document.createElement("td")).appendTo(tr);
					td.html(item.monto);
					td.attr("class", "feed-monetary");
				}

			});

			tr = $("#totales");
			th = $(document.createElement("td")).appendTo(tr);
			th.html(itemLista.totalCategoria);
			th.attr("class", "feed-monetary feed-category-" + (posLista + 1) + "x");

		});

		$.each(data.totalesAlMes, function (pos, item) {
			if (item.mes == "ENERO") {
				tr = $("#enero");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}
			if (item.mes == "FEBRERO") {
				tr = $("#febrero");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "MARZO") {
				tr = $("#marzo");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "ABRIL") {
				tr = $("#abril");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "MAYO") {
				tr = $("#mayo");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "JUNIO") {
				tr = $("#junio");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "JULIO") {
				tr = $("#julio");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "AGOSTO") {
				tr = $("#agosto");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "SEPTIEMBRE") {
				tr = $("#septiembre");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "OCTUBRE") {
				tr = $("#octubre");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "NOVIEMBRE") {
				tr = $("#noviembre");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

			if (item.mes == "DICIEMBRE") {
				tr = $("#diciembre");
				td = $(document.createElement("td")).appendTo(tr);
				td.html(item.monto);
				td.attr("class", "feed-total");
			}

		});

		tr = $("#totales");
		th = $(document.createElement("td")).appendTo(tr);
		th.html(data.totalGeneral);
		th.attr("class", "feed-total");

	} else {
		$("#report-monthly").show();

		var tbody = $("#tbody-datos-mes");
		tbody.empty();
		var trr = $("#totales-mes");
		trr.empty();
		$.each(data.totalesPorDia, function (pos, item) {
			tr = $(document.createElement("tr")).appendTo(tbody);
			td = $(document.createElement("td")).appendTo(tr);
			td.html(item.fechaDia);
			td.attr("class", "feed-headline");
			$.each(data.listaGrupo, function (Listapos, Listaitem) {
				$.each(Listaitem.gastoDiario, function (posLista, itemLista) {
					if (item.fechaDia == itemLista.fechaDia) {
						td = $(document.createElement("td")).appendTo(tr);
						td.html(itemLista.monto);
					}
				});
			});
			td = $(document.createElement("td")).appendTo(tr);
			td.html(item.monto);
			td.attr("class", "feed-monetary");
		});

		th = $(document.createElement("td")).appendTo(trr);
		th.html("Totales");
		th.attr("class", "feed-total");
		$.each(data.listaGrupo, function (Listapos, Listaitem) {
			th = $(document.createElement("td")).appendTo(trr);
			th.attr("class", "feed-monetary feed-category-" + (Listapos + 1) + "x");
			th.html(Listaitem.totalCategoria);

		});

		th = $(document.createElement("td")).appendTo(trr);
		th.html(data.totalGeneral);
		th.attr("class", "feed-total");

	}
}

function disableElements() {
	$('#filter-range-from').prop('disabled', true);
	$('#filter-range-to').prop('disabled', true);
	$('#grafico').prop('disabled', true).prop('checked', false);
	$('#detalle').prop('disabled', true).prop('checked', false);
	$('#mens').prop('disabled', true);
	$("#results").hide();
	$("#download-boxes").hide();
	$("#chart").hide();
	$("#report-monthly").hide();
	$("#report-annual").hide();
	$("#tbody-datos-mes").children().remove();
	$("#totales-mes td:not(.feed-headline)").remove();
	$("tbody td:not(.feed-headline, #tbody-datos-mes)").remove();
	$("tfoot td:not(.feed-headline)").remove();
}
