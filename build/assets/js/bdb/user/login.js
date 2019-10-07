"use strict";

(function(){

  var onloadCallback = function() {
    alert("grecaptcha is ready!");
  };

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

	function disableInputsForm(disable)
	{
		document.getElementById('username').disabled = disable;
		document.getElementById('userpwd').disabled = disable;
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

	document.getElementById('btn-login').addEventListener("click", function(e){

		e.preventDefault();

		document.getElementsByClassName('general-form-msg').innerHTML = '';
		var form = $('#form-login');

		validateForms(form, {handleMsg: false});
		if(form.valid()) {
			var text = document.getElementById('btn-login').innerHTML;
			var credentialUser = getCredentialsUser();
			grecaptcha.ready(function() {
				grecaptcha
				.execute('6LdRI6QUAAAAAEp5lA831CK33fEazexMFq8ggA4-', {action: 'login'})
				.then(function(token) {
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
			console.log('no paso la validación...');
		}
	});

	function validateResponseLogin(response, textBtn)
	{
		const property = responseCodeLogin.hasOwnProperty(response.code) ? response.code : 99
		responseCodeLogin[property](response, textBtn);
	}

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
})();
