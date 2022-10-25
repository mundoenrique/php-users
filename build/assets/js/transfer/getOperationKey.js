'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#getOperationKeyBtn').on('click', function (e) {
		e.preventDefault();
		var changeBtn = $(this);
		form = $('#getOperationKeyForm');
		btnText = changeBtn.text().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentPass = cryptography.encrypt(data.currentPass);
			changeBtn.html(loader);
			insertFormInput(true);
			who = 'Transfer';
			where = 'GetOperationKey';

			callNovoCore(who, where, data, function (response) {
				if (response.code === 0) {
					$('.cover-spin').show();
					$(location).attr('href', response.data);
				}

				if (response.code != 0 || response.code != -22) {
					changeBtn.html(btnText);
					insertFormInput(false);
				}
			});
		}
	});
});
