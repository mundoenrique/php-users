"use strict";

document.addEventListener('DOMContentLoaded', function(){

	// vars
	var btnLogin = document.getElementById('btn-login');
	var txtBtnLogin = btnLogin.innerHTML.trim();
	var btnShowPwd = document.getElementById('pwd-addon');
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
			notiSystem(response.title, response.msg, response.classIconName, response.data);
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
			notiSystem(response.title, response.msg, response.classIconName, response.data);
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
			notiSystem(response.title, response.msg, response.classIconName, response.data);
		}
	}

	// core
	btnShowPwd.style.cursor = "pointer";
	btnShowPwd.addEventListener("click", function() {
		var x = $(this).closest('.input-group').find('input');
		if (x.prop("type") == 'password') {
			x.prop("type", "text");
		} else {
			x.prop("type", "password");
		}
	});

	btnLogin.addEventListener("click", function(e) {
		e.preventDefault();

		document.getElementById("userpwd").type = 'password';
		document.getElementById("formMsg").innerHTML = '';

		var credentialUser = getCredentialsUser();
		var form = $('#form-login');
		validateForms(form, {handleMsg: false});

		if(form.valid()) {

			$(this).html(msgLoading);
			disableInputsForm(true)

			if (activatedCaptcha) {
				grecaptcha.ready(function() {
					grecaptcha
					.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', {action: 'login'})
					.then(function(token) {
						validateLogin({token: token, user: credentialUser, text: txtBtnLogin});
					},function() {

						title = titleNotiSystem;
						icon = iconWarning;
						data = {
							btn1: {
								link: false,
								action: 'close',
								text: 'Continuar'
							}
						};
						restartForm(txtBtnLogin);
						notiSystem(title, '', icon, data);
					});
				});
			}else{
				validateLogin({user: credentialUser, text: txtBtnLogin});
			}
		} else {
			document.getElementById("formMsg").innerHTML = 'Todos los campos son requeridos';
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
		verb = "POST"; who = 'User'; where = dataValidateLogin.token ? 'validateCaptcha' : 'login';

		if (dataValidateLogin.token){
			var data = {
				user: dataValidateLogin.user.user,
				token: dataValidateLogin.token,
				dataLogin: [dataValidateLogin.user, dataValidateLogin.text]
			}
		}else{
			var data = dataValidateLogin.user;
		}

		callNovoCore(verb, who, where, data, function(response) {

			if (response.code !== 0 && response.owner === 'captcha'){
				restartForm(dataValidateLogin.text);
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			} else {
				validateResponseLogin(response, dataValidateLogin.text);
			}
		})
	}

	function validateResponseLogin(response, textBtn)
	{
		response.code != 0 ? restartForm(txtBtnLogin): '';
		const property = responseCodeLogin.hasOwnProperty(response.code) ? response.code : 99
		responseCodeLogin[property](response, textBtn);
	}
});
