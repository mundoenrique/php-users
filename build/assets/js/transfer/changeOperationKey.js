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
		var changeBtn = $(this);
		form = $('#changeOperKeyForm');
		btnText = changeBtn.text().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentPass = cryptography.encrypt(data.currentPass);
			data.newPass = cryptography.encrypt(data.newPass);
			data.confirmPass = cryptography.encrypt(data.confirmPass);
			changeBtn.html(loader);
			insertFormInput(true);
			who = 'PasswordOperation';
			where = 'ChangeOperationKey';

			callNovoCore(who, where, data, function (response) {
				$('.pwd-rules')
					.find('li')
					.removeClass('rule-valid')
					.addClass('rule-invalid')
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
