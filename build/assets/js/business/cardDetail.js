'use strict'
var reportsResults;
$(function () {
	$('#pre-loader')
		.removeClass('mt-5 mx-auto flex justify-center')
		.addClass('hide')
	if ($('#movementsList > li').length > 0) {
		$('#movementsList').removeClass('hide');
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

})
