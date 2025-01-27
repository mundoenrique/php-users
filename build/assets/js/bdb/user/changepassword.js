"use strict";
var $$ = document;

$$.addEventListener("DOMContentLoaded", function () {
	//vars
	var btnTrigger = $$.getElementById("btnChangePassword"),
		btnShowPwd = document.getElementsByClassName("input-group-text"),
		inputCurrentPassword = $$.getElementById("currentPassword"),
		inputNewPassword = $$.getElementById("newPassword"),
		inputConfirmPassword = $$.getElementById("confirmPassword"),
		i;

	//core
	btnTrigger.disabled = true;

	// Mostrar/Ocultar Contraseña
	for (i = 0; i < btnShowPwd.length; i++) {
		btnShowPwd[i].style.cursor = "pointer";
		btnShowPwd[i].addEventListener("click", function () {
			var inputpwd = this.closest(".input-group").querySelector("input");
			if (inputpwd.type == "password") {
				inputpwd.type = "text";
			} else {
				inputpwd.type = "password";
			}
		});
	}

	// Deshabilita copiar, cortar y pegar en inputs
	inputNewPassword.oncut =
		inputNewPassword.oncopy =
		inputNewPassword.onpaste =
		inputConfirmPassword.oncut =
		inputConfirmPassword.oncopy =
		inputConfirmPassword.onpaste =
			function (e) {
				// this.closest('.form-group').querySelector('.help-block').innerText = 'Operación no válida.';
				return false;
			};

	btnTrigger.addEventListener("click", function (e) {
		e.preventDefault();

		for (i = 0; i < btnShowPwd.length; i++) {
			btnShowPwd[i].closest(".input-group").querySelector("input").type =
				"password";
		}

		var form = $("#formChangePassword");
		validateForms(form, { handleMsg: false });
		if (form.valid()) {
			var txtBtnTrigger = btnTrigger.innerHTML.trim();
			btnTrigger.innerHTML = msgLoadingWhite;
			btnTrigger.disabled = true;

			var data = {};
			$$.getElementById("formChangePassword")
				.querySelectorAll("input")
				.forEach(function (currentValue) {
					if (currentValue.type == "radio") {
						if (currentValue.checked) {
							data[currentValue.getAttribute("name")] = currentValue.value;
						}
					} else {
						data[currentValue.getAttribute("name")] = currentValue.value;
					}
				});

			data.currentPassword = bdb_cryptoPass(data.currentPassword);
			data.newPassword = bdb_cryptoPass(data.newPassword);
			data.confirmPassword = bdb_cryptoPass(data.confirmPassword);

			callNovoCore("POST", "User", "changePassword", data, function (response) {
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
				notiSystem(
					response.title,
					response.msg,
					response.classIconName,
					response.data
				);
			});
		}
	});

	//functions
	$$.getElementById("newPassword").addEventListener("keyup", function (e) {
		var pswd = $$.getElementById("newPassword").value.trim();
		if (e.key == "@") {
			pswd += "@";
		}

		btnTrigger.disabled = !passStrength(pswd);
	});
});
