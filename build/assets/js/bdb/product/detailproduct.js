'use strict';
var $$ = document;
var btnGroupToggle = $('.btn-group-toggle');
console.log(btnGroupToggle);


$$.addEventListener('DOMContentLoaded', function(){
		//vars

		//core

		// Botones para cambiar lista de movimientos o movimientos en tránsito
		btnGroupToggle.on('click', '.btn-options', function(e) {
			e.preventDefault();
			$(this).parent().children('.btn-options').toggleClass('active');
		});

		// Gráfico de estadísticas total abonos y cargos
		$("#detailStats").kendoChart({

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
					value: parseFloat(parseFloat(totalIncome).toFixed(1))
				}, {
					category: "Abonos",
					value: parseFloat(parseFloat(totalExpense).toFixed(1))
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

		//functions
});


