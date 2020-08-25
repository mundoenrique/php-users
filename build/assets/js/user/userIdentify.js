'use strict'
$(function () {
	$('#identityForm')[0].reset();
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
		var inputModal = '<h1 class="h0">'+lang.USER_TERMS_SUBTITLE+'</h1>';
		inputModal+= lang.USER_TERMS_CONTENT;

		notiSystem(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_INFO, data);
		$(this).prop('disabled','disabled');
	})

	$('#identityBtn').on('click', function(e) {
		e.preventDefault();
		form = $('#identityForm')
		formInputTrim(form)
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim()
			data = getDataForm(form);
			insertFormInput(true)
			who = 'user'; where = 'UserIdentify'
			$(this).html(loader)
			callNovoCore(who, where, data, function(response) {
				if (response.code == 0) {
					var dataUser = response.data;
					dataUser = JSON.stringify({dataUser})
					dataUser = cryptoPass(dataUser);
					$('#signupForm')
						.append('<input type="hidden" name="dataUser" value="'+dataUser+'">')
						.submit()
				} else {
					insertFormInput(false)
					$('#identityBtn').html(btnText)
				}
			})
		}
	})
});

/* validator = $('#signupForm').validate();
validator.destroy();
form.submit(); */
