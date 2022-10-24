'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	});

	$('#setOperationKeyBtn').on('click', function (e) {
		e.preventDefault();
		var changeBtn = $(this);
		form = $('#setOperationKeyForm');
		btnText = changeBtn.text().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.newPass = cryptography.encrypt(data.newPass);
			data.confirmPass = cryptography.encrypt(data.confirmPass);
			changeBtn.html(loader);
			insertFormInput(true);
			who = 'Transfer';
			where = 'SetOperationKey';

			callNovoCore(who, where, data, function (response) {
					$('.pwd-rules')
					.find('li')
					.removeClass('rule-valid')
					.addClass('rule-invalid')
				form[0].reset();
				insertFormInput(false);
				changeBtn.html(btnText);

				if (response.code === 0) {
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
				}
			});
		}
	});
});


