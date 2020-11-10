'use strict'
var interval,inputModal,inputModalCard,inputModalCardOtp;
var img = $('#cardImage').val();
var brand = $('#brand').val();

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

	$('#productdetail').on('click', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		sensitiveInformation();
	});

	$('#system-info').on('click', '.sensitive-btn', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		btnText = $(this).html();

		form= $('#downd-send');

		validateForms(form);
		if (form.valid()) {
			$(this)
			.removeClass('sensitive-btn')
			.html(loader)
			.prop('disabled',true)
			.off('click');

			$('#cancel')
			.prop('disabled',true);

			data = getDataForm(form);
			data.codeOTP = '';
			delete data.month;
			delete data.year;
			validateCardDetail();
		}
	});

	$('#system-info').on('click', '.virtualDetail-btn', function (e) {
		$(this)
		.removeClass('virtualDetail-btn');
		clearInterval(interval);
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

function sensitiveInformation() {
	$('#accept').addClass('sensitive-btn').removeClass('virtualDetail-btn');
	$('#cancel').prop('disabled',false);

	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'none'
		},
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'destroy'
		},
		maxHeight : 600,
		width : 430,
		posMy: 'top+50px',
		posAt: 'top+50px'
	}

	inputModal = '<div class="justify">' + lang.GEN_SENSITIVE_DATA + '</div>';
	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_SUCCESS, modalBtn);
}

function validateCardDetail() {
	who = 'Business'; where = 'getVirtualDetail'
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				$('#accept').addClass('virtualDetail-btn').removeClass('sensitive-btn');

				response.modalBtn.maxHeight = 600;
				response.modalBtn.width = 530;
				response.modalBtn.posMy = 'top+50px';
				response.modalBtn.posAt = 'top+50px';

				inputModalCard = '<h4 class="h5">' + lang.GEN_MENU_CARD_DETAIL + '</h4>';
				inputModalCard += '<div class="flex mt-3 mx-auto flex-wrap justify-center">';
				inputModalCard += 	'<div class="card-details row justify-center ml-4 mr-5">';
				inputModalCard += 		'<div class="card-detail p-1 mx-1">';
				inputModalCard += 			'<img class="item-img" src="' + img + '" alt="' + response.dataDetailCard.cardholderName + '">';
				inputModalCard += 			'<div class="item-info ' + brand + ' p-2 h5 '+ lang.CONF_CARD_COLOR +'">';
				inputModalCard += 				'<p class="item-cardnumber mb-0 h4">' + response.dataDetailCard.cardNumber + '</p>';
				inputModalCard += 				'<p class="item-cardnumber mb-0 ml-5 uppercase"><small>Vence '+ response.dataDetailCard.expirationDate +'</small></p>';
				inputModalCard += 				'<p class="item-category uppercase">' + response.dataDetailCard.cardholderName + '</p>';
				inputModalCard += 			'</div>';
				inputModalCard += 		'</div>';
				inputModalCard += 		'<div id="checked-form" class="form-group col-12 py-1">';
				inputModalCard += 			'<div class="custom-control custom-switch custom-control-inline flex justify-center">';
				inputModalCard += 				'<input id="travelAgency" class="custom-control-input" type="checkbox" name="travelAgency" >';
				inputModalCard += 				'<label class="custom-control-label custom-switch-text" for="travelAgency" title="'+response.dataDetailCard.securityCode+'"></label>';
				inputModalCard += 			'</div>';
				inputModalCard += 		'</div>';
				inputModalCard += 	'</div>';
				inputModalCard += '</div>';

				appMessages(lang.USER_TERMS_TITLE, inputModalCard, lang.GEN_ICON_SUCCESS, response.modalBtn);

				$('#accept').append('&nbsp;<span id="countdownTimer">'+lang.CONF_TIMER_MODAL_VIRTUAL+'s</span>');
				startTimer(lang.CONF_TIMER_MODAL_VIRTUAL, $('#countdownTimer'));
			break;
			case 2:
				$('#accept').addClass('virtualOtp-btn');
				$('#cancel').prop('disabled',false);

				response.modalBtn.posMy = 'top+50px';
				response.modalBtn.posAt = 'top+50px';

				inputModalCardOtp = '<form id="formVirtualOtp" name="formVirtualOtp" class="mr-2" method="post" onsubmit="return false;">';
				inputModalCardOtp+= 		'<p class="pt-0 p-0">'+ lang.GEN_MESSAGE_OTP +'</p>';
				inputModalCardOtp+= 			'<div class="row">';
				inputModalCardOtp+= 				'<div class="form-group col-8">';
				inputModalCardOtp+= 					'<label for="codeOTP">'+ lang.GEN_VERIFICATION_COD +'<span class="danger">*</span></label>';
				inputModalCardOtp+= 					'<input id="codeOTP" class="form-control" type="text" name="codeOTP" autocomplete="off">';
				inputModalCardOtp+= 					'<div id="msgErrorCodeOTP" class="help-block"></div>';
				inputModalCardOtp+= 				'</div>';
				inputModalCardOtp+= 		'</div>';
				inputModalCardOtp+= '</form>';

				appMessages(response.title, inputModalCardOtp, response.icon, response.modalBtn);
			break;
			default:
				$('#accept').html(btnText);
			break;
		}
	})
}

function startTimer(duration, display) {
	var timer = duration,
			minutes, seconds;

	interval = setInterval(myTimer, 1000);

	function myTimer() {
		seconds = parseInt(timer % 61, 10);
		//console.log(seconds);
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.text(+seconds+"s");

		if (--timer < 0) {
			stopInterval()
		}
	}
}

function stopInterval() {
	clearInterval(interval);
	$('#accept').off('click');
	$("#system-info").dialog("destroy");
}
