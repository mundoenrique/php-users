'use strict'
$(function () {
	form = $('#cardListForm')
	var cardList = $('#cardList')

	if (form.attr('card-list') == 'obtain') {
		insertFormInput(true, form);
		form.submit();
	} else {
		$('#pre-loader').remove();

		switch (code) {
			case 0:
				$('.hide-out').removeClass('hide');
			break;
			default:
				$('#no-products').removeClass('hide');
		}
	}

	if (country != 've' || (country == 've' && cardList.lngth < 3)) {
		var getDetail = $('.get-detail')
		var formBalance;

		getDetail.each(function(index, element) {
			formBalance = $(element).find('form')
			data = getDataForm(formBalance);
			who = 'Business';  where = 'GetBalance'

			callNovoCore(who, where, data, function(response) {
				$(element).find('.item-info .item-balance').text(response.msg)

			})
		})
	}

});
