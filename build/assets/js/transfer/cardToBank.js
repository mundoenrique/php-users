'use strict'
$(function () {
	var liOptions = $('.nav-item-config');

	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$.each(liOptions, function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$(liOptions).removeClass('active');
			$(this).addClass('active');
			$('.transfer-operation').hide();
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		});
	});

	$('#transferBtn').on('click', function (e) {
		e.preventDefault();
		form = $('#transferForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentOperKey = cryptoPass(data.currentOperKey);
			$(this).html(loader);
			insertFormInput(true);
		}
	});
});
