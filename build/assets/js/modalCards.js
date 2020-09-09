'use strict'
$(function () {
	$('#donor').on('click', function () {
		cardModal()
	});

	$('#productdetail').on('click', '#other-product', function () {
		cardModal()
	});

	$('#system-info').on('click', '.dashboard-item', function (e) {
		var cardDetail;
		var event = e.currentTarget;
		var img = $(event).find('img').attr('src');
		var productName = $(event).find('.item-category').text();
		var cardNumber = $(event).find('input[type=hidden][name="cardNumber"]').val();
		var cardNumberMask = $(event).find('input[type=hidden][name="cardNumberMask"]').val();
		var prefix = $(event).find('input[type=hidden][name="prefix"]').val();
		var status = $(event).find('input[type=hidden][name="status"]').val();
		var brand = $(event).find('input[type=hidden][name="brand"]').val();

		cardDetail = '<div class="flex flex-colunm justify-center col-6 py-5">';
		cardDetail += '<div class="product-presentation relative">';
		cardDetail += '<div class="item-network ' + brand + '"></div>';
		cardDetail += '<img class="card-image" src="' + img + '">';
		cardDetail += '</div>';
		cardDetail += '</div>';
		cardDetail += '<div class="flex flex-column items-start col-6 self-center pr-0 pl-1">';
		cardDetail += '<p class="semibold mb-0 h5 truncate">' + productName + '</p>';
		cardDetail += '<p id="card" class="mb-2">' + cardNumberMask + '</p>';
		cardDetail += '<a id="other-product" class="btn hyper-link btn-small p-0" href="' + lang.GEN_NO_LINK + '">';
		cardDetail += '<i aria-hidden="true" class="icon-find"></i>&nbsp;Otro producto';
		cardDetail += '</a>';
		cardDetail += '</div>';

		$('#donor, #accountSelect').remove();
		$('#productdetail').html(cardDetail);
		$('#cardNumber').val(cardNumber);
		$('#cardNumberMask').val(cardNumberMask);
		$('#prefix').val(prefix);
		$('#status').val(status);
		$('#system-info').dialog('destroy');
	});
});

function cardModal() {
	var inputModal = $('#cardList').html();
	$('.nav-config-box').removeClass('no-events');
	data = {
		btn2: {
			text: lang.GEN_BTN_CANCEL,
			action: 'close'
		},
		maxHeight: 600,
		width: 655,
		posMy: 'top+50px',
		posAt: 'top+50px',
	}
	appMessages(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_SUCCESS, data);
}
