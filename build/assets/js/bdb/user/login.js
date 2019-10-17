"use strict";

document.addEventListener('DOMContentLoaded', function(){

	// vars
	var txtBtnLogin = document.getElementById('btn-login').innerText;
	$.balloon.defaults.css = null;
	disableInputsForm(false);

	const responseCodeLogin = {
		0: function(response){
			$(location).attr('href', response.data);
		},
		1: function(response, textBtn){
			$('#user_login').showBalloon({
				html: true,
				classname: response.className,
				position: "left",
				contents: response.msg
			});
			alert(response.msg)
			restartForm(textBtn);
		},
		2: function(){
			user.active = 1;
			verb = "POST"; who = 'User'; where = 'Login'; data = getCredentialsUser();
			callNovoCore(verb, who, where, data, function(response) {
				validateResponseLogin(response);
			})
		},
		3: function(response, textBtn){
			var dataLogin = getCredentialsUser();
			notiSystem(response.title, response.msg, response.icon, response.data);
			var btn = response.data.btn1;
			if(btn.action == 'logout') {
				$('#accept').on('click', function() {
					verb = 'POST'; who = btn.link.who; where = btn.link.where; data = dataLogin;
					callNovoCore (verb, who, where, data);
				});
			}
			restartForm(textBtn);
		},
		99: function(response, textBtn){
			notiSystem(response.title, response.msg, response.icon, response.data);
			alert(response.msg);
			restartForm(textBtn);
		}
	}

	// core
	document.getElementById('btn-login').addEventListener("click", function(e){
		e.preventDefault();

		document.getElementById('btn-login').disabled = true;
		document.getElementById('divSpinner').classList.remove("hidden");
		document.getElementsByClassName('general-form-msg').innerHTML = '';

		$(this).html($('#divSpinner').html());

		var form = $('#form-login');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {
			grecaptcha.ready(function() {
				grecaptcha
				.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', {action: 'login'})
				.then(function(token) {
					var text = document.getElementById('btn-login').innerHTML;
					var credentialUser = getCredentialsUser();
					validateLogin({token: token, user: credentialUser, text: text});
				},function() {
					title = prefixCountry + strCountry;
					icon = iconWarning;
					data = {
						btn1: {
							link: false,
							action: 'close'
						}
					};
					notiSystem(title, msg, icon, data);
					restartForm(text);
				});
			});
		}
		else{
			document.getElementById('btn-login').innerText = txtBtnLogin;
			{}
		}
	});

	// Functions

	function disableInputsForm(status)
	{
		document.getElementById('username').disabled = status;
		document.getElementById('userpwd').disabled = status;
	}

	function restartForm(textBtn)
	{
		disableInputsForm(false);
		document.getElementById('btn-login').innerHTML = textBtn;
		document.getElementById("userpwd").value = '';
		if(country == 'bp') {
			document.getElementById("username").value = '';
		}
		setTimeout(function() {
			$("#username").hideBalloon();
		}, 2000);
	}

	function getCredentialsUser()
	{
		return {
			user: document.getElementById("username").value,
			pass: $.md5(document.getElementById("userpwd").value),
			active: ''
		}
	};

	function validateLogin(dataValidateLogin){
		var data = {
			user: dataValidateLogin.user.user,
			token: dataValidateLogin.token,
			dataLogin: [dataValidateLogin.user, dataValidateLogin.text]
		}
		verb = "POST"; who = 'User'; where = 'validateCaptcha';
		// verb = "POST"; who = 'User'; where = 'Login'; data = user; // llama al login
		callNovoCore(verb, who, where, data, function(response) {

			if (response.code !== 0 && response.owner === 'captcha'){

				notiSystem(response.title, response.msg, response.icon, response.data);
				restartForm(dataValidateLogin.text);

				setTimeout(function() {
					$("#user_login").hideBalloon();
				}, 2000);
			} else {
				validateResponseLogin(response, dataValidateLogin.text);
			}
		})
	}

	function validateResponseLogin(response, textBtn)
	{
		document.getElementById('btn-login').innerText = txtBtnLogin;
		const property = responseCodeLogin.hasOwnProperty(response.code) ? response.code : 99
		responseCodeLogin[property](response, textBtn);
	}

});
