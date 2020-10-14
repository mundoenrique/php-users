'use strict'

var interval;

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

	$('#productdetail').on('click', '#virtual-details', function (e) {
		e.preventDefault();
		cardModal()
	});

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

function cardModal() {
	var inputModal;
	var img = $('#cardImage').val();
	var fullName = $('#fullName').val();
	var cardNumberMask = $('#cardNumberMask').val();
	var brand = $('#brand').val();

	$('.nav-config-box').removeClass('no-events');
	data = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'destroy'
		},
		maxHeight: 600,
		width: 530,
		posMy: 'top+50px',
		posAt: 'top+50px',
	}

	inputModal = '<h4 class="h5">' + lang.GEN_MENU_CARD_DETAIL + '</h4>';
	inputModal += '<div class="flex mt-3 mx-auto flex-wrap justify-center">';
	inputModal += 	'<div class="card-details row justify-center ml-4 mr-5">';
	inputModal += 		'<div class="card-detail p-1 mx-1">';
	inputModal += 			'<img class="item-img" src="' + img + '" alt="' + fullName + '">';
	inputModal += 			'<div class="item-info ' + brand + ' p-2 h5 '+ lang.CONF_CARD_COLOR +'">';
	inputModal += 				'<p class="item-cardnumber mb-0 h4">' + cardNumberMask + '</p>';
	inputModal += 				'<p class="item-cardnumber mb-0 ml-5 uppercase"><small>Vence 06/25</small></p>';
	inputModal += 				'<p class="item-category uppercase">' + fullName + '</p>';
	inputModal += 			'</div>';
	inputModal += 		'</div>';
	inputModal += 		'<div id="checked-form" class="form-group col-12 py-1">';
	inputModal += 			'<div class="custom-control custom-switch custom-control-inline flex justify-center">';
	inputModal += 				'<input id="travelAgency" class="custom-control-input" type="checkbox" name="travelAgency" >';
	inputModal += 				'<label class="custom-control-label custom-switch-text" for="travelAgency" title="4555"></label>';
	inputModal += 			'</div>';
	inputModal += 		'</div>';
	inputModal += 	'</div>';
	inputModal += '</div>';

	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_SUCCESS, data);

	$('#accept').append('&nbsp;<span id="countdownTimer">30s</span>');
	startTimer(30, $('#countdownTimer'));
}

function startTimer(duration, display) {
	var timer = duration,
			minutes, seconds;

	interval = setInterval(myTimer, 1000);

	function myTimer() {
		seconds = parseInt(timer % 60, 10);
		console.log(seconds);
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.text(+seconds+"s");

		if (--timer < 0) {
			$("#system-info").dialog("destroy");
			stopInterval()
		}
	}
}

function stopInterval() {
	clearInterval(interval);
}

$('#accept').on('click', function(e) {
	e.preventDefault();
	e.stopImmediatePropagation();
	stopInterval();
	$("#system-info").dialog("destroy");
});
