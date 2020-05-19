'use strict'
$(function() {
	var signinBtn = $('#signin-btn');
	var forWho, forWhere;
	$.balloon.defaults.css = null;
	insertFormInput(false);

	signinBtn.on('click', function(e) {
		e.preventDefault();
		var recaptcha = lang.GEN_ACTIVE_RECAPTCHA;
		form = $('#signin-form');
		btnText = $(this).html().trim();
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			data = getDataForm(form)
			data.userPass = cryptoPass(data.userPass);
			data.active = '';
			$(this).html(loader);
			insertFormInput(true);
			where = 'signin';

			if (recaptcha) {
				grecaptcha.ready(function () {
					grecaptcha
						.execute('6Lejt6MUAAAAANd7KndpsZ2mRSQXuYHncIxFJDYf', { action: 'login' })
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
								insertFormInput(false);
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

	callNovoCore(verb, who, where, data, function (response) {
		switch (response.code) {
			case 0:
				break;
		}

		insertFormInput(false);
		signinBtn.html(btnText)

	})
}
