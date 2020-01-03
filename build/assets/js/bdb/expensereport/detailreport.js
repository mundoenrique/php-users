'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnGetMovementHistory = $$.getElementById('buscar');
	var btnExportPDF = $$.getElementById('downloadPDF');
	var btnExportXLS = $$.getElementById('downloadXLS');
	var results = $$.getElementById('results');
	var reportAnnual = $$.getElementById('reportAnnual');
	var reportMonthly = $$.getElementById('reportMonthly');
	var noRecords = $$.getElementById('noRecords');

	var fromDate, toDate, dateFormat = "dd/mm/yy";

	var loading = createElement('div', {id: "loading", class: "flex justify-center mt-5 py-4"});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';

	//core
	fromDate = $( "#fromDate" )
		.datepicker({
			maxDate: 0,
			defaultDate: 0
		})
		.on( "change", function() {
			toDate.datepicker( "option", "minDate", getDate( this ) );
		}),
	toDate = $( "#toDate" ).datepicker({
		maxDate: 0,
		defaultDate: 0
	})
	.on( "change", function() {
		fromDate.datepicker( "option", "maxDate", getDate( this ) );
	});

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

		reportAnnual.classList.add('none');
		reportMonthly.classList.add('none');
		noRecords.classList.add('none');
		results.appendChild(loading);

		callNovoCore('POST', 'ExpenseReport', 'getExpenses', data, function(response) {

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
							td = createElement('td', {class: 'feed-monetary'});
							td.textContent = day.gastoDiario[index].monto;
							tr.appendChild(td);
						});
						td = createElement('td', {class: 'feed-total'});
						td.textContent = total.monto;
						tr.appendChild(td);
						tbody.appendChild(tr);
					});
					td = createElement('td', {class: 'feed-headline'});
					td.textContent = 'Total';
					trTotales.appendChild(td);
					response.data.listaGrupo.forEach(function callback(day, index, array) {
						td = createElement('td', {class: 'feed-monetary feed-category-'+(index+1)+'x'});
						td.textContent = day.totalCategoria;
						trTotales.appendChild(td);
					});
					td = createElement('td', {class: 'feed-total'});
					td.textContent = response.data.totalGeneral;
					trTotales.appendChild(td);

					reportMonthly.classList.remove('none');

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

