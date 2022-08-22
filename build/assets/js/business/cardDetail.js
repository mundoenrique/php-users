'use strict'
var interval,inputModal,inputModalCard,inputModalCardOtp;
var img = $('#cardImage').val();
var imgRev = $('#cardImageRev').val();
var brand = $('#brand').val();

$(function () {
	displaymoves()
	who = 'Business';

	$("#filterInputYear").datepicker({
		dateFormat: 'mm/yy',
		showButtonPanel: true,
		closeText: lang.GEN_BTN_ACCEPT,

		onClose: function (dateText, inst) {
			$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			$(this)
				.focus()
				.blur();
			var monthYear = $('#filterInputYear').val().split('/');
			$('#filterMonth').val(monthYear[0]);
			$('#filterYear').val(monthYear[1]);
			$('#filterInputMonth').prop('checked', false);
		},

		beforeShow: function (input, inst) {
			inst.dpDiv.addClass("ui-datepicker-month-year");
		}
	});

	$('#filterInputMonth').on('click', function(e) {
		where = 'CardDetail';
		data = {
			cardNumber: $('#cardNumber').val()
		}
		$('#filterInputYear').val('');
		$('#filterInputYear').removeClass('has-error');
		$('#error').text('');
		$('#filterYear').val('0');
		$('#filterMonth').val('0');
		$('#month').val('0');
		$('#year').val('0');
		getMovements();
	});

	$('#search').on('click', function(e) {
		e.preventDefault();
		where = 'MonthlyMovements';
		form = $('#movements');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			$('#month').val(data.filterMonth);
			$('#year').val(data.filterYear);
			getMovements();
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
	});

	$('#virtual-details').on('click', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		$('#accept').removeClass('disable-two-factor');
		if (lang.CONF_TWO_FACTOR == 'ON') {
			cardDetailsTwoFactor(true);
		} else {
			sensitiveInformation();
		}
	});

	$('#system-info').on('click', '.sensitive-btn', function (e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		btnText = $(this).html();
		if (lang.CONF_TWO_FACTOR == 'ON') {
			var form = $('#twoFactorCodeCardForm');
			validateForms(form);
			if (form.valid()) {
				$(this).html(loader);
				validateFormCard()
			}
		} else {
			validateFormCard()
		}
	});

	$('#system-info').on('click', '.virtualDetail-btn', function (e) {
		$(this)
		.removeClass('virtualDetail-btn');
		clearInterval(interval);
	});

	$('#system-info').on('click', '#resendCodeCardDetails', function (e) {
		$('#accept').removeClass('sensitive-btn');
		$('#accept').addClass('resend-code-sensitive');
		cardDetailsTwoFactor(false)
	});
});

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
	var graphicValue = [parseFloat($('#debit').val()).toFixed(2),  parseFloat($('#credit').val()).toFixed(2)];
	var graphicLabel = ['Cargos', 'Abonos'];
	$('#pre-loader')
		.removeClass('mt-5 mx-auto flex justify-center')
		.addClass('hide');

	if ($('#movementsList > li').length > 0) {
		$('.hide-downloads').removeClass('hide');
		$('#movementsList').removeClass('hide');
		$('#movementsStats').removeClass('hide');

		var chart = new Chart($('#chart'), {
    	type: 'doughnut',
    	data: {
      	labels: graphicLabel,
      	datasets: [{
					label: '',
					data: graphicValue,
					backgroundColor: ['#E74C3C', '#2ECC71'],
        	borderColor: ['#E74C3C','#2ECC71'],
        	borderWidth: 1
      	}]
    	},
    	options: {
				tooltips: {
					callbacks: {
						label: function(tooltipItem) {
							return graphicLabel[tooltipItem.index] + ": " + lang.CONF_CURRENCY+ " " + graphicValue[tooltipItem.index]
						}
					}
				},
				responsive: true,
				aspectRatio: 2,
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						gridLines: {
							display:false
					},
						ticks: {
								display: false
						}
					}],
					xAxes: [{
						gridLines: {
							display:false
						},
						ticks: {
							display: false
						}
					}]
				}
    	}
		});
	} else {
		$('#no-moves').removeClass('hide');
		$('.hide-downloads').addClass('hide');
	}

	if ($('#movementsList > li').length > 10) {
		$('#movementsList').easyPaginate({
			paginateElement: 'li',
			hashPage: lang.GEN_DATATABLE_PAGE,
			elementsPerPage: 10,
			effect: 'default',
			slideOffset: 200,
			firstButton: true,
			firstButtonText: lang.GEN_DATATABLE_SFIRST,
			firstHashText: lang.GEN_DATATABLE_PAGE_FIRST,
			lastButton: true,
			lastButtonText: lang.GEN_DATATABLE_SLAST,
			lastHashText: lang.GEN_DATATABLE_PAGE_LAST,
			prevButton: true,
			prevButtonText: lang.CONF_DATATABLE_SPREVIOUS,
			prevHashText: lang.GEN_DATEPICKER_PREVTEXT,
			nextButton: true,
			nextButtonText: lang.CONF_DATATABLE_SNEXT,
			nextHashText: lang.GEN_DATEPICKER_NEXTTEXT
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
		posMy: 'top+150px',
		posAt: 'top+50px'
	}

	if (lang.CONF_TWO_FACTOR == 'ON') {
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
			width : 530,
			posMy: 'top+60px',
			posAt: 'top+50px'
		}

		inputModal = '<form id="twoFactorCodeCardForm" name="formTwoFactorCode" class="mr-2" method="post" onsubmit="return false;">';
			inputModal += 	'<div class="justify pr-1">';
			inputModal += 		'<div class="justify pr-1">';
			inputModal += 			'<p>' + lang.GEN_SENSITIVE_DATA + '</p>';
			inputModal += 			'<p>' + lang.GEN_TWO_FACTOR_CODE_VERIFY.replace("%s", lang.GEN_EMAIL)+ '</p>';
			inputModal += 		'</div>';
			inputModal += 		'<div class="form-group col-8 p-0">';
			inputModal += 			'<label for="authenticationCode">' + lang.GEN_AUTHENTICATION_CODE + '</label>'
			inputModal += 			'<input id="authenticationCode" class="form-control" type="text" name="authenticationCode" autocomplete="off" maxlength="6" placeholder="'+lang.GEN_PLACE_HOLDER_AUTH_CODE+'">';
			inputModal += 			'<div class="help-block"></div>'
			inputModal += 		'</div">';
			inputModal += 	'</div>';
			inputModal += '</form>';
	} else {
		inputModal = '<div class="justify pr-1">' + lang.GEN_SENSITIVE_DATA + '</div>';
	}
	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.CONF_ICON_SUCCESS, modalBtn);
}

function cardDetailsTwoFactor(action) {
	$('#cancel').prop('disabled',false);
	form = $('#channelFormCardDetail');
	validateForms(form);
	if (form.valid()) {
		data = getDataForm(form);
		data.sendResendToken = action;
		who = 'Mfa'; where = 'GenerateSecretToken';
		callNovoCore(who, where, data, function(response) {
			switch (response.code) {
				case 0:
					$('#accept').addClass('sensitive-btn').removeClass('virtualDetail-btn');
					modalTokenCardDetails(response)
				break;
				case 2:
					appMessages(response.title, response.msg, response.icon, response.modalBtn);
					$('#system-info').on('click', '.resend-code-sensitive', function (e) {
						$('#accept').removeClass('resend-code-sensitive');
						$('#accept').addClass('sensitive-btn');
						modalTokenCardDetails(response)
					});
				break;
			}
		});
	}
}

function validateCardDetail() {
	who = 'Business'; where = 'getVirtualDetail'
	callNovoCore(who, where, data, function(response) {
		switch (response.code) {
			case 0:
				$('#accept').addClass('virtualDetail-btn').removeClass('sensitive-btn');

				inputModalCard = '<h4 class="h5">' + lang.GEN_MENU_CARD_DETAIL + '</h4>';
				inputModalCard += '<div class="flex mt-3 mx-auto flex-wrap justify-center">';
				inputModalCard += 	'<div class="card-details row justify-center mx-5">';
				inputModalCard += 		'<div class="card3d-contain">';
				inputModalCard += 		  '<div class="card3d-automatic">';
				inputModalCard += 		    '<div class="card-detail card3d-front">';
				inputModalCard += 			    '<img class="item-img" src="' + img + '" alt="' + response.dataDetailCard.cardholderName + '">';
				inputModalCard += 			    '<div class="item-info ' + (lang.CONF_FRANCHISE_LOGO === 'ON' ? brand : '') + ' p-2 h5 '+ lang.CONF_CARD_COLOR +'">';
				inputModalCard += 				    '<p class="item-cardnumber mb-0 h4">' + response.dataDetailCard.cardNumber + '</p>';
				inputModalCard += 			  	  '<p class="item-cardnumber mb-0 ml-5 uppercase"><small>Vence '+ response.dataDetailCard.expirationDate +'</small></p>';
				inputModalCard += 				    '<p class="item-category uppercase">' + response.dataDetailCard.cardholderName + '</p>';
				inputModalCard += 			    '</div>';
				inputModalCard += 	    	'</div>';
				inputModalCard += 		    '<div class="card-detail card3d-back">';
				inputModalCard += 			    '<img class="item-img" src="' + imgRev + '" alt="' + response.dataDetailCard.cardholderName + '">';
				inputModalCard += 			    '<div class="item-info p-2 white center">';
				inputModalCard += 				    '<p class="item-cardnumber h4 black bold">' + response.dataDetailCard.securityCode + ' CVV2</p>';
				inputModalCard += 			    '</div>';
				inputModalCard += 	    	'</div>';
				inputModalCard += 			'</div>';
				inputModalCard += 		'</div>';
				inputModalCard += 		'<div class="form-group col-12 pt-3">';
				inputModalCard += 			'<div class="control-switch bold">';
				inputModalCard += 				'<input type="checkbox" id="control-switch" name="check"/>';
				inputModalCard += 				'<label for="control-switch" class="center trasnform"><i aria-hidden="true" class="icon-rotary h2 white"></i></label>';
				inputModalCard += 			'</div>';
				inputModalCard += 		'</div>';
				inputModalCard += 	'</div>';
				inputModalCard += '</div>';

				response.modalBtn = {
					btn1: {
						text: lang.GEN_BTN_CLOSE,
						action: 'destroy'
					},
					maxHeight : 600,
					width : 530,
					posMy: 'top+50px',
					posAt: 'top+50px'
				}

				appMessages(lang.USER_TERMS_TITLE, inputModalCard, lang.CONF_ICON_SUCCESS, response.modalBtn);

				$('#accept').append('&nbsp;<span id="countdownTimer">'+lang.CONF_TIMER_MODAL_VIRTUAL+'s</span>');
				clickCard3d();
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

function clickCard3d() {
	var card3d = $('.card3d-automatic');
	var controlSwitch = $('#control-switch');

	$('.control-switch').on('click', function() {
		if (controlSwitch.prop('checked') == false) {
			card3d.addClass('hover');
			controlSwitch.prop('checked', true);
		} else {
			card3d.removeClass('hover');
			controlSwitch.prop('checked', false);
		}
	})

	card3d.on('click', function () {
		if (card3d.hasClass('hover')) {
			card3d.removeClass('hover');
			controlSwitch.prop('checked', false);
		} else {
			card3d.addClass('hover');
			controlSwitch.prop('checked', true);
		}
	});
}

function startTimer(duration, display) {
	var timer = duration,
			minutes, seconds;

	interval = setInterval(myTimer, 1000);

	function myTimer() {
		seconds = parseInt(timer % 61, 10);
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

function validateFormCard() {
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
}

function modalTokenCardDetails(response) {
	var message = response.otpChannel == 'Email' ? lang.GEN_EMAIL : (response.otpChannel == 'app' ? lang.GEN_APLICATION : '') ;
	modalBtn = {
		btn1: {
			text: lang.GEN_BTN_ACCEPT,
			action: 'none'
		},
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'none'
		},
		maxHeight : 600,
		width : 530,
		posMy: 'top+60px',
		posAt: 'top+50px'
	}

	inputModal = '<form id="twoFactorCodeCardForm" name="formTwoFactorCode" class="mr-2" method="post" onsubmit="return false;">';
	inputModal += 	'<div class="justify pr-1">';
	inputModal += 		'<div class="justify pr-1">';
	inputModal += 			'<p>' + lang.GEN_SENSITIVE_DATA + '</p>';
	inputModal += 			'<p>' + lang.GEN_TWO_FACTOR_CODE_VERIFY.replace("%s", message);
	if (response.otpChannel == 'Email') {
		inputModal += 			' ' + lang.GEN_TWO_FACTOR_SEND_CODE+ ' ';
		inputModal += 				'<a id="resendCodeCardDetails" href="#" class="btn btn-small btn-link p-0" >'+lang.GEN_BTN_RESEND_CODE+'</a>';
	}
	inputModal += 			'</p>';
	inputModal += 		'</div>';
	inputModal += 		'<div class="form-group col-8 p-0">';
	inputModal += 			'<label for="authenticationCode">' + lang.GEN_AUTHENTICATION_CODE + '</label>'
	inputModal += 			'<input id="authenticationCode" class="form-control" type="text" name="authenticationCode" autocomplete="off" maxlength="6" placeholder="'+lang.GEN_PLACE_HOLDER_AUTH_CODE+'">';
	inputModal += 			'<div class="help-block"></div>'
	inputModal += 		'</div">';
	inputModal += 	'</div>';
	inputModal += '</form>';
	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.CONF_ICON_SUCCESS, modalBtn);
}
