'use strict'
$(function () {
	$('#identityForm')[0].reset();
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

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
