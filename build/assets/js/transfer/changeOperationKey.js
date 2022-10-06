'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	});

	$('#changeOperKeyBtn').on('click', function (e) {
		e.preventDefault();
		form = $('#changeOperKeyForm');
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentOperKey = cryptoPass(data.currentOperKey);
			$(this).html(loader);
			insertFormInput(true);
		}
	});
});
