'use strict';
var $$ = document,
				totalExpense = 0,
				totalIncome = 0;

moment.updateLocale('en', {
  monthsShort : [
    "Ene", "Feb", "Mar", "Abr", "May", "Jun",
    "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
  ]
});

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var transactions = $$.getElementById('transactions'),
			movementsTitle = $$.getElementById('period'),
			movementsList = $$.getElementById('movementsList'),
			movementsStats = $('#movementsStats'),
			transitTitle = $$.getElementById('transitTitle'),
			transitList = $$.getElementById('transitList'),
			transitStats = $('#transitStats'),
			movementsToogle = $$.getElementById('movementsToogle'),
			transitToogle = $$.getElementById('transitToogle'),
			btnOptions = $$.querySelectorAll('.btn-options'),
			stackItems = $$.querySelectorAll('.stack-item'),
			btnExportPDF = $$.getElementById('downloadPDF'),
			btnExportXLS = $$.getElementById('downloadXLS'),
			btnExportExtract = $$.getElementById('downloadExtract');

	var	i, movementsPaginate, transitPaginate;

	var loading = createElement('div', {id: "loading", class: "flex justify-center mt-5 py-4"});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';
	var noMovements = createElement('div', {class: "my-5 py-4 center"});
	noMovements.innerHTML = '<span class="h4">No se encontraron movimientos</span>';

	//core

	// Gráficas de estadísticas total abonos y cargos
	if (movementsList.querySelector(".feed-item")) {
		$('#movementsList').easyPaginate({});
		movementsPaginate = movementsList.nextElementSibling;
		movementsPaginate.id = 'movementsPaginate';
		movementsStats.addClass('fade-in');
		for (i = 0; i < stackItems.length; ++i) {
			stackItems[i].classList.remove('is-disabled');
		}

		invokeChart(movementsStats);
	}

	if (transitList != null) {
		$('#transitList').easyPaginate({});
		transitPaginate = transitList.nextElementSibling;
		transitPaginate.id = 'transitPaginate';
		transitPaginate.classList.add('none');

		transitToogle.classList.remove('is-disabled');
		transitToogle.querySelector('input').disabled = false;

		invokeChart(transitStats);
	}

	transitToogle.addEventListener('click', function(){
		if ( !this.classList.contains('is-disabled') && !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			movementsTitle.classList.add('none');
			movementsPaginate.classList.add('none');
			movementsList.classList.remove('fade-in');
			movementsStats.removeClass('fade-in');
			transitTitle.classList.remove('none');
			transitPaginate.classList.remove('none');
			transitList.classList.add('fade-in');
			transitStats.addClass('fade-in');
		}
	})

	movementsToogle.addEventListener('click', function(){
		if ( !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			transitTitle.classList.add('none');
			transitPaginate.classList.add('none');
			transitList.classList.remove('fade-in');
			transitStats.removeClass('fade-in');
			movementsTitle.classList.remove('none');
			movementsPaginate.classList.remove('none');
			movementsList.classList.add('fade-in');
			movementsStats.addClass('fade-in');
		}
	})

	$$.getElementById('buscar').addEventListener('click', function(){
		var filterMonth = $$.getElementById('filterMonth');
		var filterYear = $$.getElementById('filterYear');

		var monthSelected = filterMonth.options[filterMonth.selectedIndex];
		var yearSelected = filterYear.options[filterYear.selectedIndex];

		var dataRequest = {
			noTarjeta: data.noTarjeta,
			month: monthSelected.value,
			year: yearSelected.value,
		};

		while (movementsList.firstChild) {
			movementsList.removeChild(movementsList.firstChild);
		}
		movementsList.classList.remove('fade-in');
		if (movementsPaginate != null) {
			movementsPaginate.remove();
		}
		movementsStats.removeClass('fade-in');
		for (i = 0; i < stackItems.length; ++i) {
			stackItems[i].classList.add('is-disabled');
		}
		transactions.appendChild(loading);

		callNovoCore('post', 'Product', 'loadMovements', dataRequest, function(response) {
			if (response !== '--') {

				response.forEach(function callback(currentValue, index, array) {
					var date = moment(currentValue.fecha, "DD/MM/YYYY").format('DD/MMM/YYYY').split('/'),
							day = date[0],
							month = date[1],
							year = date[2],
							concept = currentValue.concepto,
							reference = currentValue.referencia,
							sign = currentValue.signo,
							amount = currentValue.monto;

					var feedItem, feedDate, dateDay, dateMonth, dateYear, feedConcept, feedProduct, feedMeta, feedConcept, feedAmount;

					feedItem = createElement('li', {class: 'feed-item ' + (sign === '+' ? "feed-income" : "feed-expense") + ' flex py-1 items-center'});

					feedDate = createElement('div', {class: 'flex px-2 flex-column items-center feed-date'});
					dateDay = createElement('span', {class: 'h5 feed-date-day'});
					dateDay.textContent = day;
					dateMonth = createElement('span', {class: 'h5 feed-date-month'});
					dateMonth.textContent = month;
					dateYear = createElement('span', {class: 'h5 feed-date-year'});
					dateYear.textContent = year;
					feedDate.appendChild(dateDay);
					feedDate.appendChild(dateMonth);
					feedDate.appendChild(dateYear);

					feedConcept = createElement('div', {class: 'flex px-2 flex-column mr-auto'});
					feedProduct = createElement('span', {class: 'h5 semibold feed-product'});
					feedProduct.textContent = concept;
					feedMeta = createElement('span', {class: 'h6 feed-metadata'});
					feedMeta.textContent = reference;
					feedConcept.appendChild(feedProduct);
					feedConcept.appendChild(feedMeta);

					feedAmount = createElement('span', {class: 'px-2 feed-amount items-center'});
					if (sign === '-') {
						totalExpense += amount;
						sign = "- ";
					} else {
						totalIncome += amount;
						sign = "";
					}
					feedAmount.textContent = sign + coinSimbol + ' ' + amount;

					feedItem.appendChild(feedDate);
					feedItem.appendChild(feedConcept);
					feedItem.appendChild(feedAmount);

					movementsList.appendChild(feedItem);
				});
				$('#movementsList').easyPaginate({});
				movementsPaginate = movementsList.nextElementSibling;
				movementsPaginate.id = 'movementsPaginate';
				invokeChart(movementsStats);
				movementsStats.addClass('fade-in');
				for (i = 0; i < stackItems.length; ++i) {
					stackItems[i].classList.remove('is-disabled');
				}
			} else {
				movementsList.appendChild(noMovements);
			}
			transactions.removeChild(transactions.lastChild);
			movementsList.classList.add('fade-in');
		});
	});

	//functions
	$$.getElementById('filterMonth').addEventListener('change', function() {

		if (this.value == 0) {

			$$.getElementById('filterYear').disabled = true;
			$$.getElementById('filterYear').selectedIndex = 0;
		}else{

			$$.getElementById('buscar').disabled = false;
			$$.getElementById('filterYear').disabled = false;
		}
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

	btnExportExtract.addEventListener('click', function(e){

		e.preventDefault();
		$$.getElementsByName("frmTypeFile")[0].value = 'ext';
		processForm();
	});

	function processForm() {

			var monthRequest = $$.getElementById('filterMonth').options[$$.getElementById('filterMonth').selectedIndex].value,
					yearRequest = $$.getElementById('filterYear').options[$$.getElementById('filterYear').selectedIndex].value,
					objDate = new Date(),
  				fullYear = objDate.getFullYear();

			$$.getElementsByName("frmMonth")[0].value = monthRequest == '01'? '': monthRequest;
			$$.getElementsByName("frmYear")[0].value = yearRequest == fullYear? '': yearRequest;

			$$.getElementsByTagName('form')[1].submit();
	}


});

function invokeChart(selector, cargos, abonos) {
	var cargos, abonos;
	if (selector[0] === movementsStats) {
		cargos = data.totalExpenseMovements;
		abonos = data.totalIncomeMovements;
	} else {
		cargos = data.totalExpensePendingTransactions;
		abonos = data.totalIncomePendingTransactions;
	}
	selector.kendoChart({
		chartArea: {
			background:"transparent",
			width: 300,
			height: 250
		},
		legend: {
			position: "top",
			visible: false
		},
		seriesDefaults: {
			labels: {
				template: "#= category # - #= kendo.format('{0:P}', percentage)#",
				position: "outsideEnd",
				visible: false,
				background: "transparent",
			}
		},
		seriesColors: ["#cc0000", "#007e33"],
		series: [{
			type: "donut",
			overlay: {
				gradient: "none"
			},
			data: [{
				category: "Cargos",
				value: parseFloat(parseFloat(cargos).toFixed(1))
			}, {
				category: "Abonos",
				value: parseFloat(parseFloat(abonos).toFixed(1))
			}]
		}],
		tooltip: {
			visible: true,
			template: "#= category # - #= kendo.format('{0:P}', percentage) #",
			padding: {
				right: 4,
				left: 4
			},
			color: "#ffffff"
		}
	});
}
