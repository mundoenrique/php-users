'use strict'
$(function () {
	displaymoves()
	who = 'Business';

	$('#filterMonth').on('change', function() {
		$('#search').prop('disabled',false);
		if ($(this).val() != '0') {
			$('#filterYear')
				.prop('disabled', false);
		} else {
			$('#filterYear')
				.prop('selectedIndex', 0)
				.prop('disabled', true);
		}
	});

	$('#search').on('click', function(e) {
		e.preventDefault();

		if ($('#filterMonth').val() == '0') {
			where = 'CardDetail';
			data = {
				cardNumber: $('#cardNumber').val()
			}
			$('#month').val('0');
			$('#year').val('0');
			getMovements();
		} else {
			where = 'MonthlyMovements';
			form = $('#movements');
			formInputTrim(form);
			validateForms(form);

			if (form.valid()) {
				data = getDataForm(form);
				$('#month').val(data.filterMonth);
				$('#year').val(data.filterYear);
				getMovements();
			}
		}
	});

	$('#downloadFiles').on('click', 'a', function(e) {
		e.preventDefault();
		var event = $(e.currentTarget);
		form = $('#downd-send')
		validateForms(form);
		if (form.valid()) {
			data = getDataForm(form);
			data.action = event.attr('action');
			data.id = event.attr('id');
			where = 'DownloadMoves';
			$('.cover-spin').show(0);
			callNovoCore(who, where, data, function(response) {
				if (data.action == 'download') {
					filesAction(data.action, response);
				} else {
					$('.cover-spin').hide();
				}
			})
		}
	})
})

function getMovements() {
	$('#pre-loader')
		.removeClass('hide')
		.addClass('mt-5 mx-auto flex justify-center')
	$('.easyPaginateNav').remove();
	$('#movementsList')
		.addClass('hide')
		.children()
		.remove();
	$('#movementsStats').addClass('hide');
	$('#no-moves').addClass('hide');
	insertFormInput(true);
	callNovoCore(who, where, data, function(response) {
		insertFormInput(false);
		$('#credit').val(response.data.totalMoves.credit);
		$('#debit').val(response.data.totalMoves.debit);

		if (response.data.balance) {
			$('#currentBalance').text(response.data.balance.currentBalance);
			$('#inTransitBalance').text(response.data.balance.inTransitBalance);
			$('#availableBalance').text(response.data.balance.availableBalance);
		}

		if (response.data.movesList.length > 0) {
			$.each(response.data.movesList, function(item, moves) {
				var classCss = moves.sign == '-' ? 'feed-expense' : 'feed-income';
				var appendLi;

				appendLi =	'<li class="feed-item '+classCss+' flex py-2 items-center">';
				appendLi+=		'<div class="flex px-2 flex-column items-center feed-date">';
				appendLi+=			'<span class="h5">'+moves.date+'</span>';
				appendLi+=		'</div>';
				appendLi+=		'<div class="flex px-2 flex-column mr-auto">';
				appendLi+=			'<span class="h5 semibold feed-product">'+moves.desc+'</span>';
				appendLi+=			'<span class="h6 feed-metadata">'+moves.ref+'</span>';
				appendLi+=		'</div>';
				appendLi+=		'<span class="px-2 feed-amount items-center">'+moves.sign+' '+moves.amount+'</span>';
				appendLi+=	'</li>';

				$('#movementsList').append(appendLi);
			})
		}
		displaymoves();
	})
}

function displaymoves() {
	$('#pre-loader')
		.removeClass('mt-5 mx-auto flex justify-center')
		.addClass('hide');

	if ($('#movementsList > li').length > 0) {
		$('.hide-downloads').removeClass('hide');
		$('#movementsList').removeClass('hide');
		$('#movementsStats').removeClass('hide');
		$("#movementsStats").kendoChart({
			chartArea: {
				width: 300,
				height:200
			},
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
			series: [{
				type: "donut",
				overlay: {
					gradient: "none"
				},
				data: [{
					category: "Cargos",
					value: parseFloat($('#debit').val()).toFixed(2),
					color: "#E74C3C"
				}, {
					category: "Abonos",
					value: parseFloat($('#credit').val()).toFixed(2),
					color: "#2ECC71"
				}]
			}],
			tooltip: {
				visible: true,
				template: "#= category # #= kendo.format('{0:P}', percentage) #"
			}
		});
	} else {
		$('#no-moves').removeClass('hide');
		$('.hide-downloads').addClass('hide');
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
}

function filesAction(action, response) {
	if (action == 'download' && response.code == 0) {
		delete (response.data.btn1);
		downLoadfiles(response.data);
	}
}
