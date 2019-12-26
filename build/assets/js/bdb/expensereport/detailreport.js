'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnGetMovementHistory = $$.getElementById('buscar');
	var btnExportPDF = $$.getElementById('downloadPDF');
	var btnExportXLS = $$.getElementById('downloadXLS');

	//core
	var fromDate, toDate, dateFormat = "dd/mm/yy",
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

		callNovoCore('POST', 'ExpenseReport', 'getExpenses', data, function(response) {

			if (response.code === 0){
				console.log(response.data);
			} else {
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			}
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
		if (dataExpensesReport.listExpenses !== '' && dataExpensesReport.listExpenses !== '--') {
			$$.getElementsByName("frmInitialDate")[0].value = $$.getElementById("fromDate").value;
			$$.getElementsByName("frmFinalDate")[0].value = $$.getElementById("toDate").value;

			$$.getElementsByTagName('form')[0].submit();
		}
	}
})

