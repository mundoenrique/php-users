'use strict'
var reportsResults;
$(function () {
	insertFormInput(false);
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	var recoverAccessBtn = $('#recoverAccessBtn');

	recoverAccessBtn.on('click', function(e) {
		e.preventDefault();
		form = $('#recoverAccessForm')
		btnText = $(this).html().trim();
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);

			if ($('#recoveryUser').is(':checked')) {
				delete data.recoveryPwd
			}

			if ($('#recoveryPwd').is(':checked')) {
				delete data.recoveryUser
			}

			$(this).html(loader);
			insertFormInput(true);
			who = 'User'; where = 'AccessRecover'

			callNovoCore(who, where, data, function (response) {
				insertFormInput(false);
				recoverAccessBtn.html(btnText)
			})
		}
	})
});
