'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
		//vars

		//core

		$("#estadisticas").kendoChart({

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
			seriesColors: ["#E74C3C", "#2ECC71"],
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
				template: "#= category # - #= kendo.format('{0:P}', percentage) #"
			}
		});

		//functions
});


