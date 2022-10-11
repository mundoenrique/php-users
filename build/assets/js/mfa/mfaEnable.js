'use strict'

$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#mfaEnableBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#mfaEnableForm')
		btnText = $(this).html().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.activationType = $('input:radio[name=twoFactorEnablement]:checked').val();
			$(this).html(loader);
			insertFormInput(true);
			var url = baseURL + lang.CONF_LINK_MFA_CONFIRM + '/' + data.activationType;
			$(location).attr('href', url);
		}
	});

	$('input:radio[name=twoFactorEnablement]').change(function() {
		if($(this).attr('value') == lang.CONF_MFA_CHANNEL_EMAIL){
			$('#verifyMsg').removeClass('visible');
		} else {
			$('#verifyMsg').addClass('visible');
		}
	});
});
