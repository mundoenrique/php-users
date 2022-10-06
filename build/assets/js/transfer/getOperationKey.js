'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#getOperationKeyBtn').on('click', function (e) {
		e.preventDefault();
		form = $('#getOperationKeyForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentOperKey = cryptoPass(data.currentOperKey);
			$(this).html(loader);
			insertFormInput(true);
		}
	});
});
