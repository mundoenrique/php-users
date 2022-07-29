'use strict'
$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#twoFactorCodeBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#twoFactorCodeForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			$(this).html(loader);
			insertFormInput(true);

			who = 'Mfa'; where = 'ValidateOTP2fa';
			callNovoCore(who, where, data, function(response) {
				switch (response.code) {
					case 0:
						inputModal = response.msg
						appMessages(response.title, inputModal, response.icon, response.modalBtn);
					break;

				}
			});
		}
	});
});
