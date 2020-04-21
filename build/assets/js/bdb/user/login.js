"use strict";
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){

	// vars
	var btnLogin = $$.getElementById('btn-login');
	var txtBtnLogin = btnLogin.innerHTML.trim();
	var btnShowPwd = $$.getElementById('pwdAddon');
	var btnTrigger, txtBtnTrigger;
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
		5: function(response, textBtn)
		{
			var btn = response.data.btn1;
			var loginIpMsg =
			`<form id="formVerificationOTP" class="mr-2" method="post">
				<p>${response.msg}</p>
				<div class="row">
					<div class="form-group col-7">
						<label for="codeOTP">${response.labelInput}<span class="danger">*</span></label>
						<input id="codeOTP" class="form-control" type="text" name="codeOTP" value="">
						<div id="msgErrorCodeOTP" class="help-block"></div>
					</div>
				</div>
				<div class="form-group custom-control custom-switch">
					<input id="acceptAssert" class="custom-control-input" type="checkbox" name="acceptAssert">
					<label class="custom-control-label" for="acceptAssert">
						${response.assert}
					</label>
					<div class="help-block"></div>
				</div>
			</form>`;

			notiSystem(response.title, loginIpMsg, response.classIconName, response.data);
			$("#system-info").dialog("option", "minWidth", 480);
			$("#system-info").dialog("option", "position", {
				my: "center top+100",
				at: "center top",
				of: window
			});

			if(btn.action == 'wait') {
				btnTrigger = $$.getElementById('accept');
				txtBtnTrigger = btnTrigger.innerHTML.trim();

				btnTrigger.addEventListener('click', function (e) {
					var form = $('#formVerificationOTP');
					btnTrigger.innerHTML = msgLoadingWhite;
					btnTrigger.disabled = true;

					validateForms(form, {
						handleMsg: true
					});

					if (form.valid()) {
						var dataLogin = getCredentialsUser();

						verb = "POST"; who = 'User'; where = 'Login'; data = dataLogin;

						btnTrigger.innerHTML = txtBtnTrigger;
						btnTrigger.disabled = false;

						$("#system-info").dialog("close");
						$("#system-info").dialog("destroy");
						$("#system-info").addClass("none");

						callNovoCore (verb, who, where, data, function(response) {

							if (response.code !== 0){
								//restartForm(dataValidateLogin.text);
								notiSystem(response.title, response.msg, response.classIconName, response.data);
							}
						});
					} else {
						btnTrigger.innerHTML = txtBtnTrigger;
						btnTrigger.disabled = false;
					}


				});
			}

		},
		99: function(response, textBtn)
		{
			notiSystem(response.title, response.msg, response.classIconName, response.data);
		}
	}

	// core

	// Mostrar/Ocultar Contraseña
	btnShowPwd.style.cursor = "pointer";
	btnShowPwd.addEventListener("click", function() {
		var inputpwd = this.closest('.input-group').querySelector('input');
		if (inputpwd.type == 'password') {
			inputpwd.type = "text";
		} else {
			inputpwd.type= "password";
		}
	});

	btnLogin.addEventListener("click", function(e) {
		e.preventDefault();

		$$.getElementById("userpwd").type = 'password';
		$$.getElementById("formMsg").innerHTML = '';

		var credentialUser = getCredentialsUser();
		var form = $('#form-login');
		validateForms(form, {handleMsg: false});

		if(form.valid()) {

			$(this).html(msgLoadingWhite);
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
			$$.getElementById("formMsg").innerHTML = 'Todos los campos son requeridos';
		}
	});

	// Functions
	function disableInputsForm(status)
	{
		$$.getElementById('username').disabled = status;
		$$.getElementById('userpwd').disabled = status;
		btnLogin.disabled = status;
	}

	function restartForm(textBtn)
	{
		disableInputsForm(false);

		$$.getElementById('btn-login').innerHTML = textBtn;
		$$.getElementById("userpwd").value = '';
	}

	function getCredentialsUser()
	{
		return {
			user: $$.getElementById('username').value,
			pass: $.md5($$.getElementById('userpwd').value),
			saveIP: $$.getElementById('acceptAssert') == null? 'false': $$.getElementById('acceptAssert').checked,
			codeOTP: $$.getElementById('codeOTP') == null? '': $$.getElementById('codeOTP').value,
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
