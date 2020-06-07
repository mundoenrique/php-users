'use strict'
var reportsResults;
$(function () {
	$('#pre-loader')
		.removeClass('mt-5 mx-auto flex justify-center')
		.addClass('hide')
	if ($('#movementsList > li').length > 0) {
		$('#movementsList').removeClass('hide');
		$('#movementsStats').removeClass('hide');
	} else {
		$('#no-moves').removeClass('hide');
	}

	if ($('#movementsList > li').length > 10) {
		$('#movementsList').easyPaginate({
			paginateElement: 'li',
			hashPage: 'Página',
			elementsPerPage: 10,
			effect: 'default',
			slideOffset: 200,
			firstButton: true,
			firstButtonText: 'Primera',
			firstHashText: 'Primera página',
			lastButton: true,
			lastButtonText: 'Última',
			lastHashText: 'Última página',
			prevButton: true,
			prevButtonText: '<',
			prevHashText: 'Anterior',
			nextButton: true,
			nextButtonText: '>',
			nextHashText: 'Siguiente'
		})
	}

	$("#movementsStats").kendoChart({
		legend: {
			position: "top",
			visible: false
		},
		seriesDefaults: {
			labels: {
				template: "#= category # #= kendo.format('{0:P}', percentage)#",
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
				value: parseFloat($('#debit').val()).toFixed(2)
			}, {
				category: "Abonos",
				value: parseFloat($('#credit').val()).toFixed(2)
			}]
		}],
		tooltip: {
			visible: true,
			template: "#= category # #= kendo.format('{0:P}', percentage) #"
		}
	})

})
