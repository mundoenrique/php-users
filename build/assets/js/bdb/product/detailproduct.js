'use strict';
var $$ = document;

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
			btnOptions = $$.querySelectorAll('.btn-options'), i;

	var loading = createElement('div', {id: "loading", class: "flex justify-center mt-5 py-4"});
	loading.innerHTML = '<span class="spinner-border spinner-border-lg" role="status" aria-hidden="true"></span>';
	var noMovements = createElement('div', {class: "my-5 py-4 center"});
	noMovements.innerHTML = '<span class="h4">No se encontraron movimientos</span>';


	//core

	// Gráficas de estadísticas total abonos y cargos
	if (movementsList.querySelector(".feed-item")) {
		movementsList.classList.add('fade-in');
		movementsStats.addClass('fade-in');

		movementsStats.kendoChart({
			chartArea: {
				background:"transparent"
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
			seriesColors: ["#007e33", "#cc0000"],
			series: [{
				type: "donut",
				overlay: {
					gradient: "none"
				},
				data: [{
					category: "Cargos",
					value: parseFloat(parseFloat(500).toFixed(1))
				}, {
					category: "Abonos",
					value: parseFloat(parseFloat(1000).toFixed(1))
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


	if (transitList != null) {
		transitToogle.classList.remove('is-disabled');
		transitToogle.querySelector('input').disabled = false;

		transitStats.kendoChart({
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
			seriesColors: ["#007e33", "#cc0000"],
			series: [{
				type: "donut",
				overlay: {
					gradient: "none"
				},
				data: [{
					category: "Cargos",
					value: parseFloat(parseFloat(1000).toFixed(1))
				}, {
					category: "Abonos",
					value: parseFloat(parseFloat(500).toFixed(1))
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

	// Botón para cambiar movimientos en tránsito
	transitToogle.addEventListener('click', function(){
		if ( !this.classList.contains('is-disabled') && !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			movementsTitle.classList.add('none');
			movementsList.classList.remove('fade-in');
			movementsStats.removeClass('fade-in');
			transitTitle.classList.remove('none');
			transitList.classList.add('fade-in');
			transitStats.addClass('fade-in');
		}
	})

	// Botón para cambiar a lista de movimientos
	movementsToogle.addEventListener('click', function(){
		if ( !this.classList.contains('active') ) {
			for (i = 0; i < btnOptions.length; ++i) {
				btnOptions[i].classList.toggle('active');
			};

			transitTitle.classList.add('none');
			transitList.classList.remove('fade-in');
			transitStats.removeClass('fade-in');
			movementsTitle.classList.remove('none');
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
			month: parseInt(monthSelected.value),
			year: parseInt(yearSelected.value),
		}

		while (movementsList.firstChild) {
			movementsList.removeChild(movementsList.firstChild);
		}
		movementsList.classList.remove('fade-in');
		transactions.appendChild(loading);

		callNovoCore('post', 'Product', 'loadMovements', dataRequest, function(response) {
			if (response !== '--') {
				console.log(response);

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
					feedAmount.textContent = data.currency + (sign === '-' ? " -" : " ") + amount;

					feedItem.appendChild(feedDate);
					feedItem.appendChild(feedConcept);
					feedItem.appendChild(feedAmount);

					movementsList.appendChild(feedItem);
				});
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
		}else{

			$$.getElementById('buscar').disabled = false;
			$$.getElementById('filterYear').disabled = false;
		}
	});

});

var createElement = function (tagName, attrs) {

	var el = document.createElement(tagName);
	Object.keys(attrs).forEach((key) => {
		if (attrs [key] !== undefined) {
			el.setAttribute(key, attrs [key]);
		}
	});

	return el;
}
