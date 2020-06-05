'use strict'
var reportsResults;
$(function () {
	$('#pre-loader')
		.removeClass('flex')
		.addClass('hide')
	$('.hide-out').removeClass('hide');

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

})
