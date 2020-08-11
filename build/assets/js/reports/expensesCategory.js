'use strict'
var reportsResults;
$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

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
		inputModal+= 	'<div id="cardList" class="dashboard-items flex mt-3 mx-auto flex-wrap" styles="height: 208px;">';
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

	/* $('#resultsAccount').DataTable({
		"ordering": false,
		"responsive": true,
		"pagingType": "full_numbers",
		"language": dataTableLang
	}); */
});
