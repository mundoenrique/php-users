'use strict'
var reportsResults;
var options = $(".nav-item-config").toArray();
var radios = $('input[type=radio][name="recovery"]').toArray();
var i;
var modalReq = {};

$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');
	$('.slide-slow').click(function() {
		$(this).next(".section").slideToggle("slow");
		$(".help-block").text("");
	});

	$('#donor').on('click', function() {
		var inputModal;
		data = {
			btn1: {
				text: lang.GEN_BTN_CANCEL,
				action: 'close'
			},
			maxHeight: 600,
			width: 655,
			posMy: 'top+60px',
			posAt: 'top+60px',
		}
		inputModal =  '<h4 class="h4">'+lang.GEN_ACCOUNT_SELECTION+'</h4>';
		inputModal+= 	'<div id="cardList" class="dashboard-items flex mt-3 mx-auto flex-wrap">';
		inputModal+= 		'<div class="dashboard-item p-1 mx-1 mb-1 get-detail big-modal">';
		inputModal+= 			'<img class="item-img" src="http://personas.novopayment.lc/assets/images/default/bnt_default.svg" alt="PLATA VIÁTICOS" />';
		inputModal+= 			'<div class="item-info maestro p-2 h5 bg-white">';
		inputModal+=			 	 '<p class="item-category semibold">PLATA VIÁTICOS</p>';
	  inputModal+= 				 '<p class="item-cardnumber mb-0">604842******1511</p>';
		inputModal+= 				 '<p class="item-balance mb-0 h6 light text">clic para consultar tu saldo</p>';
		inputModal+= 			'</div>';
		inputModal+= 			'<form action=""  method="POST">';
		inputModal+= 				'<input type="hidden" id="userIdNumber" name="userIdNumber" class="hidden" value="<?= $cards->userIdNumber ?>">';
		inputModal+=				'<input type="hidden" id="cardNumber" name="cardNumber" class="hidden" value="<?= $cards->cardNumber ?>">';
		inputModal+= 		    '<input type="hidden" id="cardNumberMask" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask ?>">';
		inputModal+= 			  '<input type="hidden" id="productName" name="productName" class="hidden" value="<?= $cards->productName ?>">';
		inputModal+=			 	'<input type="hidden" id="brand" name="brand" class="hidden" value="<?= $cards->brand ?>">';
		inputModal+= 			  '<input type="hidden" id="productImg" name="productImg" class="hidden" value="<?= $cards->productImg ?>">';
		inputModal+= 				'<input type="hidden" id="productUrl" name="productUrl" class="hidden" value="<?= $cards->productUrl ?>">';
		inputModal+= 			  '<input type="hidden" id="cardsTotal" name="cardsTotal" class="hidden" value="<?= $cardsTotal ?>">';
		inputModal+= 		  '</form>';
		inputModal+= 		'</div>';
		inputModal+= 		'<div class="dashboard-item p-1 mx-1 mb-1 get-detail big-modal">';
		inputModal+= 			'<img class="item-img" src="http://personas.novopayment.lc/assets/images/default/bnt_default.svg" alt="PLATA VIÁTICOS" />';
		inputModal+= 			'<div class="item-info maestro p-2 h5 bg-white">';
		inputModal+=			 	 '<p class="item-category semibold">PLATA VIÁTICOS</p>';
	  inputModal+= 				 '<p class="item-cardnumber mb-0">604842******1511</p>';
		inputModal+= 				 '<p class="item-balance mb-0 h6 light text">clic para consultar tu saldo</p>';
		inputModal+= 			'</div>';
		inputModal+= 			'<form action=""  method="POST">';
		inputModal+= 				'<input type="hidden" id="userIdNumber" name="userIdNumber" class="hidden" value="<?= $cards->userIdNumber ?>">';
		inputModal+=				'<input type="hidden" id="cardNumber" name="cardNumber" class="hidden" value="<?= $cards->cardNumber ?>">';
		inputModal+= 		    '<input type="hidden" id="cardNumberMask" name="cardNumberMask" class="hidden" value="<?= $cards->cardNumberMask ?>">';
		inputModal+= 			  '<input type="hidden" id="productName" name="productName" class="hidden" value="<?= $cards->productName ?>">';
		inputModal+=			 	'<input type="hidden" id="brand" name="brand" class="hidden" value="<?= $cards->brand ?>">';
		inputModal+= 			  '<input type="hidden" id="productImg" name="productImg" class="hidden" value="<?= $cards->productImg ?>">';
		inputModal+= 				'<input type="hidden" id="productUrl" name="productUrl" class="hidden" value="<?= $cards->productUrl ?>">';
		inputModal+= 			  '<input type="hidden" id="cardsTotal" name="cardsTotal" class="hidden" value="<?= $cardsTotal ?>">';
		inputModal+= 		  '</form>';
		inputModal+= 		'</div>';
		inputModal+= 	'</div>';
		notiSystem(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_SUCCESS, data);
		$(this).on('click');
	})

	switch (client) {
		case 'banco-bog':
		case 'pichincha':
		case 'novo':
		case 'banorte':
			$('#cardLock').addClass('active');
			$('#cardLockView').show();
			break;
	}

	/* $('#resultsAccount').DataTable({
		"ordering": false,
		"responsive": true,
		"pagingType": "full_numbers",
		"language": dataTableLang
	});

	$.each(options, function(key, val){
		$('#'+options[key].id+'View').hide();
		options[key].addEventListener('click', function(e) {
				var idName = this.id;
				$.each(options, function(key, val){
						options[key].classList.remove("active");
						$('#'+options[key].id+'View').hide();
				})
				this.classList.add("active");
				$('#'+idName+'View').fadeIn(700, 'linear');
		});
	});

	for (i = 0; i < radios.length; i++) {
		radios[i].addEventListener('change', function (e) {
			if (this.id == 'generate-pin') {
				$("#pinRequestOTP").addClass('none');
				$("#current-pin-field").addClass('none');
				$("#changeCurrentPin").attr("disabled", true);
			} else {
				$("#pinRequestOTP").addClass('none');
				$("#changeCurrentPin").attr("disabled", false);
				$("#current-pin-field").removeClass('none');
			}
			if (this.id == 'pin-request') {
				$("#sectionPin").addClass('none');
				$("#pinRequestOTP").removeClass('none');
			} else {
				$("#sectionPin").removeClass('none');
			}
		});
	}*/
	$('#blockBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#operation');
		btnText = $(this).text().trim()
		data = getDataForm(form);
		insertFormInput(true);
		$(this).html(loader);
		who = 'CustomerSupport'; where = data.action

		callNovoCore(who, where, data, function(response) {
			if (data.action == 'TemporaryLock' && response.success) {
				var statusText = $('#status').val() == '' ? 'Desbloquear' : 'Bloquear'
				$('.status-text1').text(statusText);
				$('.status-text2').text(statusText.toLowerCase());
				var status = $('#status').val() == '' ? 'PB' : ''
				$('#status').val(status);
				insertFormInput(false);
				$('#blockBtn').html(btnText);
			}
		})
	})
});
