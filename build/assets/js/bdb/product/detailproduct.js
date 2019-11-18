'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
		//vars
		var btnGroupToggle = $('.btn-group-toggle');
		var movementsTitle = $('#period'),
				movementslist = $('#movementsList'),
				movementsStats = $('#transitList'),
				transitTitle = $('#transitTitle'),
				transitList = $('#transitList'),
				transitStats = $('#transitStats'),
				movementsToogle = $('#movementsToogle'),
				transitToogle = $('#transitToogle');

		//core

		// Gráfico de estadísticas total abonos y cargos
		$("#movementsStats").kendoChart({

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
					value: parseFloat(parseFloat(totalIncomeMovements).toFixed(1))
				}, {
					category: "Abonos",
					value: parseFloat(parseFloat(totalExpenseMovements).toFixed(1))
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

		if (transitList.length)
		{
			transitToogle.removeClass('is-disabled');
			transitToogle.children('input').prop( "disabled", false );

			$("#transitStats").kendoChart({

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
						value: parseFloat(parseFloat(totalIncomePendingTransactions).toFixed(1))
					}, {
						category: "Abonos",
						value: parseFloat(parseFloat(totalExpensePendingTransactions).toFixed(1))
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
		} else{
			transitToogle.addClass('is-disabled');
		}

		// Botones para cambiar lista de movimientos o movimientos en tránsito
		transitToogle.click(function () {
			if ( !$(this).hasClass('is-disabled') && !$(this).hasClass('active') ) {
				$(this).parent().children('.btn-options').toggleClass('active');
				movementsTitle.addClass('none');
				movementslist.addClass('none');
				movementsStats.addClass('none');
				transitTitle.removeClass('none');
				transitList.removeClass('none');
				transitStats.removeClass('none');
			}
		})

		movementsToogle.click(function () {
			if ( !$(this).hasClass('active') ) {
				$(this).parent().children('.btn-options').toggleClass('active');
				transitTitle.addClass('none');
				transitList.addClass('none');
				transitStats.addClass('none');
				movementsTitle.removeClass('none');
				movementslist.removeClass('none');
				movementsStats.removeClass('none');
			}
		})

		//functions
});


