'use strict'
var changeBtn;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	});

	$('#change-pass-btn').on('click', function (e) {
		e.preventDefault();
		changeBtn = $(this);
		form = $('#change-pass-form');
		btnText = changeBtn.text().trim();
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form);
			data.currentPass = cryptoPass(data.currentPass);
			data.newPass = cryptoPass(data.newPass);
			data.confirmPass = cryptoPass(data.confirmPass);
			insertFormInput(true);
			changeBtn.html(loader);
			changePassword(data, btnText);
		}
	});
});

function changePassword(passData, textBtn) {
	who = 'User'; where = 'ChangePassword'; data = passData;

	callNovoCore(who, where, data, function (response) {
		$('.pwd-rules').find('li').removeClass('rule-valid').addClass('rule-invalid')
		form[0].reset();
		insertFormInput(false);
		changeBtn.html(textBtn);
	});
}
