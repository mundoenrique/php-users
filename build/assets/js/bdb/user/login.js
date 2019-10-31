"use strict";

document.addEventListener('DOMContentLoaded', function(){

	// vars
	var btnLogin = document.getElementById('btn-login');
	var txtBtnLogin = btnLogin.innerHTML.trim();
	$.balloon.defaults.css = null;
	disableInputsForm(false);

	const responseCodeLogin = {
		0: function(response)
		{
			$(location).attr('href', response.data);
		},
		1: function(response, textBtn)
		{
			$('#user_login').showBalloon({
				html: true,
				classname: response.className,
				position: "left",
				contents: response.msg
			});
			notiSystem(response.title, response.msg, response.className, response.data);
		},
		2: function()
		{
			user.active = 1;
			verb = "POST"; who = 'User'; where = 'Login'; data = getCredentialsUser();
			callNovoCore(verb, who, where, data, function(response) {
				validateResponseLogin(response);
			})
		},
		3: function(response, textBtn)
		{
			var dataLogin = getCredentialsUser();
			notiSystem(response.title, response.msg, response.className, response.data);
			var btn = response.data.btn1;
			if(btn.action == 'logout') {
				$('#accept').on('click', function() {
					verb = 'POST'; who = btn.link.who; where = btn.link.where; data = dataLogin;
					callNovoCore (verb, who, where, data);
				});
			}
		},
		99: function(response, textBtn)
		{
			notiSystem(response.title, response.msg, response.className, response.data);
		}
	}

	// core
	btnLogin.addEventListener("click", function(e){
		e.preventDefault();

		var form = $('#form-login');
		validateForms(form, {handleMsg: false});

		if(form.valid()) {

			$(this).html(msgLoading);
			disableInputsForm(true)

			grecaptcha.ready(function() {
				grecaptcha
				.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', {action: 'login'})
				.then(function(token) {

					var credentialUser = getCredentialsUser();
					validateLogin({token: token, user: credentialUser, text: txtBtnLogin});
				},function() {

					title = 'Conexión Personas Online';
					icon = iconWarning;
					data = {
						btn1: {
							link: false,
							action: 'close',
							text: 'Continuar'
						}
					};
					notiSystem(title, '', icon, data);
					restartForm(txtBtnLogin);
				});
			});

		}
		else{
			var credentialUser = getCredentialsUser();
			validateLogin({token: '', user: credentialUser, text: txtBtnLogin});
		}

	});

	// Functions
	function disableInputsForm(status)
	{
		document.getElementById('username').disabled = status;
		document.getElementById('userpwd').disabled = status;
		btnLogin.disabled = status;
	}

	function restartForm(textBtn)
	{
		disableInputsForm(false);

		document.getElementById('btn-login').innerHTML = textBtn;
		document.getElementById("userpwd").value = '';
		if(country == 'bp') {
			document.getElementById("username").value = '';
		}
	}

	function getCredentialsUser()
	{
		return {
			user: document.getElementById("username").value,
			pass: $.md5(document.getElementById("userpwd").value),
			active: ''
		}
	};

	function validateLogin(dataValidateLogin)
	{
		var data = {
			user: dataValidateLogin.user.user,
			token: dataValidateLogin.token,
			dataLogin: [dataValidateLogin.user, dataValidateLogin.text]
		}
		verb = "POST"; who = 'User'; where = data.token == '' ? 'login': 'validateCaptcha';

		callNovoCore(verb, who, where, data, function(response) {

			if (response.code !== 0 && response.owner === 'captcha'){

				notiSystem(response.title, response.msg, response.callName, response.data);
				restartForm(dataValidateLogin.text);
			} else {
				validateResponseLogin(response, dataValidateLogin.text);
			}
		})
	}

	function validateResponseLogin(response, textBtn)
	{
		restartForm(txtBtnLogin);
		const property = responseCodeLogin.hasOwnProperty(response.code) ? response.code : 99
		responseCodeLogin[property](response, textBtn);
	}
});
