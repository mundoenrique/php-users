'use strict'
$(function () {
	form = $('#cardListForm')

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

	if ($('.get-detail').length <= 4) {
		var formBalance;

		$('.get-detail').each(function(index, element) {
			formBalance = $(element).find('form')
			data = getDataForm(formBalance);
			who = 'Business';  where = 'GetBalance'
			if (data.status == '' || data.status == 'PB') {
				callNovoCore(who, where, data, function(response) {
					$(element).find('.item-info .item-balance').text(response.msg)
				})
			}
		})
	} else {
		$('.get-detail').find('.item-balance').text('clic para consultar tu saldo')
	}

	$('.get-detail').on('click', function(e) {
		e.preventDefault();
		form = $(this).find('form')
		formInputTrim(form)
		insertFormInput(true, form)

		form.submit()
	})

});
