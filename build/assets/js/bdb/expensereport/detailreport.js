'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnGetMovementHistory = $$.getElementById('buscar'),
			btnExportPDF = $$.getElementById('downloadPDF'),
			btnExportXLS = $$.getElementById('downloadXLS'),
			results = $$.getElementById('results'),
			reportAnnual = $$.getElementById('reportAnnual'),
			reportMonthly = $$.getElementById('reportMonthly'),
			chart = $('#chart'),
			noRecords = $$.getElementById('noRecords'),
			btnOptions = $$.querySelectorAll('.btn-options'),
			stackItems = $$.querySelectorAll('.stack-item'),
			detailToogle = $$.getElementById('detailToogle'),
			statsToogle = $$.getElementById('statsToogle');

	var i, jsonChart, jsonDataTables, dateFormat = "dd/mm/yy";
	var fromDate, toDate, startDate, endDate;

	var loading = createElement('div', {id: "loading", class: "flex justify-center mt-5 py-4"});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';

	//core

	// Da formato a rango de fechas
	fromDate = $( "#fromDate" ).datepicker({
		maxDate: 0,
		defaultDate: 0,
		onSelect: function() {
			endDate = new Date(getDate(this).setMonth(getDate(this).getMonth() + 3));
			endDate = (endDate > new Date()) ? 0 : endDate ;

			toDate.datepicker( "option", "minDate", getDate(this) );
			toDate.datepicker( "option", "maxDate", endDate );
			toDate.datepicker( "option", "defaultDate", getDate(this) );
		}
	});

	toDate = $( "#toDate" ).datepicker({
		maxDate: 0,
		defaultDate: 0,
		onSelect: function() {
			startDate = new Date(getDate(this).setMonth(getDate(this).getMonth() - 3));

			fromDate.datepicker( "option", "maxDate", getDate(this) );
			fromDate.datepicker( "option", "minDate", startDate );
			fromDate.datepicker( "option", "defaultDate", getDate(this) );
		}
	});

	jsonChart = {
    chartArea: {
      background:"transparent",
      width: 640,
			height: 320
		},
		seriesDefaults: {
			labels: {
				template: "#= category #  #= kendo.format('{0:P}')#",
				position: "outsideEnd",
				visible: false,
				background: "transparent",
				format: coinSimbol + " {0}"
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
      template: "#= category # - #= formatCurrency('es-CO', currencyOptions, value) #",
			padding: {
				right: 4,
				left: 4
			},
      color: "#012c71",
      background: "#d8d8d8"
		}
  }

	jsonDataTables = {
		"ordering": false,
		"pagingType": "full_numbers",
		"autoWidth": false,
		"language": {
			"sProcessing": "Procesando...",
			"sLengthMenu": "Mostrar _MENU_ registros",
			"sZeroRecords": "No se encontraron resultados",
			"sEmptyTable": "Ningún dato disponible en esta tabla",
			"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix": "",
			"slengthMenu": "Mostrar _MENU_ registros por pagina",
			"sSearch": "",
			"sSearchPlaceholder": "Buscar...",
			"sUrl": "",
			"sInfoThousands": ",",
			"sLoadingRecords": "Cargando...",
			"sprocessing": "Procesando ...",
			"oPaginate": {
				"sFirst": "Primera",
				"sLast": "Última",
				"sNext": "»",
				"sPrevious": "«"
			},
			"oAria": {
				"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			},
			"select": {
				"rows": "%d Lote seleccionado"
			}
		}
	}
	// Muestra reportes y genera gráfica de estadísticas
	if (reportAnnual.querySelector(".feed-table")) {
		$('#reportAnnual table').DataTable(jsonDataTables);
		reportAnnual.classList.add('fade-in');

		invokeChart(chart, jsonChart, dataExpensesReport.listExpenses.data.listaGrafico[0]);
		statsToogle.classList.remove('is-disabled');
		statsToogle.querySelector('input').disabled = false;
		for (i = 0; i < stackItems.length; ++i) {
			stackItems[i].classList.remove('is-disabled');
		}
	} else {
		noRecords.classList.remove('none');
	}

	// Botón para cambiar a gráfica
	statsToogle.addEventListener('click', function(){
		if ( !this.classList.contains('is-disabled') && !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			results.classList.add('none');
			chart.addClass('fade-in');
		}
	})

	// Botón para cambiar a detalles
	detailToogle.addEventListener('click', function(){
		if ( !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			chart.removeClass('fade-in');
			results.classList.remove('none');
		}
	})

	function getDate( element ) {
		var date;
		try {
			date = $.datepicker.parseDate( dateFormat, element.value );
		} catch( error ) {
			date = null;
		}

		return date;
	}

	btnGetMovementHistory.addEventListener('click', function(e){
		e.preventDefault();

		var data = {
			fechaInicial: $$.getElementById("fromDate").value,
			fechaFinal: $$.getElementById("toDate").value
		};

		var tr, td;

		reportAnnual.classList.remove('fade-in');
		reportMonthly.classList.remove('fade-in');
		chart.removeClass('fade-in');
		noRecords.classList.add('none');
		statsToogle.classList.add('is-disabled');
		statsToogle.querySelector('input').disabled = true;
		for (i = 0; i < stackItems.length; ++i) {
			stackItems[i].classList.add('is-disabled');
		}
		detailToogle.classList.add('active');
		statsToogle.classList.remove('active');
		results.classList.remove('none');
		results.appendChild(loading);

		callNovoCore('POST', 'ExpenseReport', 'getExpenses', data, function(response) {
			var monto, totalMonto, totalCategoria, totalGeneral;
			var formatterMonto, formatterTotalMonto, formatterTotalCategoria, formatterTotalGeneral;

			switch (response.code) {
				case 0:
					var tbody = $$.getElementById('tbodyMes');
					var trTotales = $$.getElementById('totalesMes');
					while (tbody.firstChild) {
						tbody.removeChild(tbody.firstChild);
					}
					while (trTotales.firstChild) {
						trTotales.removeChild(trTotales.firstChild);
					}
					response.data.totalesPorDia.forEach(function callback(total, index, array) {
						tr = $$.createElement('tr');
						td = createElement('td', {class: 'feed-headline'});
						td.textContent = total.fechaDia;
						tr.appendChild(td);
						response.data.listaGrupo.forEach(function callback(day) {
							monto = parseFloat(day.gastoDiario[index].monto.replace(/\,/g, ''));
							formatterMonto = formatCurrency("es-CO", decimalOptions, monto);
							td = createElement('td', {class: 'feed-monetary'});
							td.textContent = formatterMonto;
							tr.appendChild(td);
						});
						totalMonto = parseFloat(total.monto.replace(/\,/g, ''));
						formatterTotalMonto = formatCurrency("es-CO", decimalOptions, totalMonto);
						td = createElement('td', {class: 'feed-total'});
						td.textContent = formatterTotalMonto;
						tr.appendChild(td);
						tbody.appendChild(tr);
					});
					td = createElement('td', {class: 'feed-headline'});
					td.textContent = 'Total';
					trTotales.appendChild(td);
					response.data.listaGrupo.forEach(function callback(day, index, array) {
						totalCategoria = parseFloat(day.totalCategoria.replace(/\,/g, ''));
						formatterTotalCategoria = formatCurrency("es-CO", decimalOptions, totalCategoria);
						td = createElement('td', {class: 'feed-monetary feed-category-'+(index+1)+'x'});
						td.textContent = formatterTotalCategoria;
						trTotales.appendChild(td);
					});
					totalGeneral = parseFloat(response.data.totalGeneral.replace(/\,/g, ''));
					formatterTotalGeneral = formatCurrency("es-CO", decimalOptions, totalGeneral);
					td = createElement('td', {class: 'feed-total'});
					td.textContent = formatterTotalGeneral;
					trTotales.appendChild(td);

					$('#reportMonthly table').DataTable(jsonDataTables);
					reportMonthly.classList.add('fade-in');

					invokeChart(chart, jsonChart, response.data.listaGrafico[0]);
					statsToogle.classList.remove('is-disabled');
					statsToogle.querySelector('input').disabled = false;
					for (i = 0; i < stackItems.length; ++i) {
						stackItems[i].classList.remove('is-disabled');
					}
					break;

				case 1:
					noRecords.classList.remove('none');
					break;

				default:
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					break;
			}
			results.removeChild(results.lastChild);
		});

	});

	btnExportPDF.addEventListener('click', function(e){
		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'pdf';
		processForm();

	});

	btnExportXLS.addEventListener('click', function(e){
		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'xls';
		processForm();

	});

	//functions
	function processForm() {

			$$.getElementsByName("frmInitialDate")[0].value = $$.getElementById("fromDate").value;
			$$.getElementsByName("frmFinalDate")[0].value = $$.getElementById("toDate").value;

			$$.getElementsByTagName('form')[0].submit();

	}
})

function invokeChart(selector, json, data) {
	json.categoryAxis.categories = [];
	json.series[0].data = [];
	$.each(data.categorias, function (posLista, itemLista) {
		json.categoryAxis.categories.push(itemLista.nombreCategoria);
		var datos = {};
		datos.category = itemLista.nombreCategoria;
		datos.value = parseFloat(data.series[0].valores[posLista]);
		json.series[0].data.push(datos);
	});

	selector.kendoChart(json);
}
