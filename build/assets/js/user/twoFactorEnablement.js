'use strict'
var radioType = 'input:radio[name=twoFactorEnablement]';

$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#twoFactorEnablementBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#twoFactorEnablementForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);

			$(this).html(loader);
			insertFormInput(true);
		}
	});

	$(radioType).change(function() {
		if($(this).attr('value') == 'email'){
			$('#verifyMsg').removeClass('visible');
		} else {
			$('#verifyMsg').addClass('visible');
		}
	});

	$('#system-info').on('click', '.send-otp', function(e) {
		e.preventDefault();
		form = $('#otpModal');
		validateForms(form);

		if (form.valid()) {
			$('#accept').removeClass('send-otp');
			data = getDataForm(form);
			data.email = $('#email').val();
			$('#accept')
				.html(loader)
				.prop('disabled', true);
			insertFormInput(true);
		}
	});
});
