'use strict'
$(function () {
	var ulOptions = $('.nav-item-config');
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$.each(ulOptions, function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$(ulOptions).removeClass('active');
			$('.option-service').hide();
			$(this).addClass('active');
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		});
	});

	if (ulOptions.length == 1) {
		$(ulOptions).addClass('active');
	}

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
