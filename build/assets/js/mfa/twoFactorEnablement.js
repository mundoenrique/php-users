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
			data.activationType = $('input:radio[name=twoFactorEnablement]:checked').val();
			$(this).html(loader);
			insertFormInput(true);
			var url = baseURL + "two-factor-code/" + data.activationType;
			$(location).attr('href', url);
		}
	});

	$(radioType).change(function() {
		if($(this).attr('value') == lang.CONF_MFA_CHANNEL_EMAIL){
			$('#verifyMsg').removeClass('visible');
		} else {
			$('#verifyMsg').addClass('visible');
		}
	});
});
