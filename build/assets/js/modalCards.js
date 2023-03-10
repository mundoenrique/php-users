'use strict'
$(function () {
	$('#donor').on('click', function (e) {
		cardModal();
	});

	$('#productdetail').on('click', '#other-product', function (e) {
		cardModal();
	});

	$('#system-info').on('click', '.dashboard-item', function (e) {
		var cardDetail;
		var event = e.currentTarget;
		var img = $(event).find('img').attr('src');
		var productName = $(event).find('input[type=hidden][name="productName"]').val();
		var cardNumber = $(event).find('input[type=hidden][name="cardNumber"]').val();
		var cardNumberMask = $(event).find('input[type=hidden][name="cardNumberMask"]').val();
		var prefix = $(event).find('input[type=hidden][name="prefix"]').val();
		var status = $(event).find('input[type=hidden][name="status"]').val();
		var brand = $(event).find('input[type=hidden][name="brand"]').val();
		var isVirtual = $(event).find('input[type=hidden][name="isVirtual"]').val();
		var module = $(event).find('input[type=hidden][name="module"]').val();

		$('.nav-config-box li').removeClass('no-pointer');

		if (module == 'services' && status != '' && status != 'PB') {
			return true;
		}

		cardDetail = '<div class="flex flex-column justify-center col-auto py-4 pr-0">';
		cardDetail += '<div class="product-presentation relative">';
		cardDetail += '<div class="item-network ' + (lang.SETT_FRANCHISE_LOGO === 'ON' ? brand : '') + ' "></div>';
		cardDetail += '<img class="card-image" src="' + img + '">';
		cardDetail += '</div>';

		if (isVirtual) {
			cardDetail += '<span class="warning semibold h6 mx-auto">'+ lang.GEN_VIRTUAL_CARD +'</span>';
		}

		cardDetail += '</div>';
		cardDetail += '<div class="flex flex-column items-start col-6 self-center px-0 ml-1">';
		cardDetail += '<p class="semibold mb-0 h5 truncate">' + productName + '</p>';
		cardDetail += '<p id="card" class="mb-2">' + cardNumberMask + '</p>';
		cardDetail += '<a id="other-product" class="btn hyper-link btn-small p-0" href="' + lang.SETT_NO_LINK + '">';
		cardDetail += '<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto';
		cardDetail += '</a>';
		cardDetail += '</div>';

		if (isVirtual) {
			$('#replaceMotSol').val(lang.CUST_STOLEN_CARD);
			$('#selectReplacementCard').addClass('none');
			$('#msgReplacementCard').removeClass('none');
		} else {
			$('#replaceMotSol').val('');
			$('#selectReplacementCard').removeClass('none');
			$('#msgReplacementCard').addClass('none');
		}

		$('#temporaryLockReason').val('');

		if (status == '' && lang.SETT_TEMPORARY_LOCK_REASON == 'ON') {
			$('#temporaryLockReason').removeClass('ignore');
			$('#selectTempLockReason').removeClass('none');
			$('#msgTemporaryLock').addClass('none');
		} else {
			$('#temporaryLockReason').addClass('ignore');
			$('#selectTempLockReason').addClass('none');
			$('#msgTemporaryLock').removeClass('none');
		}

		$('#virtual').val(isVirtual);
		$('#donor, #accountSelect').remove();
		$('#productdetail').html(cardDetail);
		$('#cardNumber').val(cardNumber);
		$('#cardNumberMask').val(cardNumberMask);
		$('#prefix').val(prefix);
		$('#status').val(status);
		modalDestroy(true);
	});
});

function cardModal() {
	var inputModal = $('#cardListModal').html();

	modalBtn = {
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'destroy'
		},
		maxHeight: 600,
		width: 655,
		posMy: 'top+50px',
		posAt: 'top+50px',
	}

	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.SETT_ICON_SUCCESS, modalBtn);
}
