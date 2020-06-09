'use strict'
var reportsResults;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#acceptTerms').on('click', function() {
		data = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'close'
			},
			maxHeight: 600,
			width: 800,
			posMy: 'top',
			posAt: 'top'
		}
		var inputModal = '<h1 class="h0">'+lang.TERMS_SUBTITLE+'</h1>';
		inputModal+= lang.TERMS_CONTENT;

		notiSystem(lang.TERMS_TITLE, inputModal, lang.GEN_ICON_INFO, data);
		$(this).off('click')
	})
	$('#signupBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#signupForm')
		formInputTrim(form)
		validateForms(form)

		if (form.valid()) {

		}
	})



	/* validator = $('#status-bulk-form').validate();
validator.destroy();
form.submit(); */

});
