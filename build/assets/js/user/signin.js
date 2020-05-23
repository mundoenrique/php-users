'use strict'
var userName;
var userPass;
$(function () {
	var signinBtn = $('#signin-btn');
	userName = $('#userName');
	userPass = $('#userPass');
	$.balloon.defaults.css = null;
	insertFormInput(false);

	signinBtn.on('click', function (e) {
		e.preventDefault();
		var recaptcha = lang.GEN_ACTIVE_RECAPTCHA;
		form = $('#signin-form');
		btnText = $(this).html().trim();
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form)
			data.userPass = cryptoPass(data.userPass);
			$(this).html(loader);
			insertFormInput(true);
			where = 'signin';

			if (recaptcha) {
				grecaptcha.ready(function () {
					grecaptcha
						.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', { action: 'login' })
						.then(function (token) {
							if (token) {
								validateSignin(token, signinBtn);
							}
						}, function (token) {
							if (!token) {
								icon = lan.GEN_ICON_WARNING;
								data = {
									btn1: {
										link: 'inicio',
										action: 'redirect'
									}
								};
								notiSystem(lang.GEN_SYSTEM_NAME, lang.GEN_SYSTEM_MESSAGE, icon, data);
								validateSignin(signinBtn);
							}
						});
				});
			} else {
				validateSignin(false, signinBtn);
			}
		}
	})
})
/**
 * @info Valida credenciales de usuario
 * @author J. Enrique Peñaloza Piñero
 * @date May 19th, 2020
 */
function validateSignin(token, signinBtn) {
	who = 'User';
	data.currentTime = new Date().getHours()
	data.token = token || ''

	callNovoCore(who, where, data, function (response) {
		switch (response.code) {
			case 0:
				$(location).attr('href', response.data);
			break;
			case 1:
				userName.showBalloon({
					html: true,
					classname: response.className,
					position: response.position,
					contents: response.msg
				});
			break;
		}

		if (response.code != 0) {
			restarForm(signinBtn);
		}
	})
}
/**
 * @info restaura el formulario
 * @author J. Enrique Peñaloza Piñero
 * @date May 22th, 2020
 */
function restarForm(signinBtn) {
	insertFormInput(false);
	signinBtn.html(btnText);
	setTimeout(function () {
		userName.hideBalloon();
	}, 2000);
	userPass.val('')

	if (client == 'pichincha') {
		userName.val('')
	}
}
