'use strict';
var $$ = document;
var form, btnTrigger, txtBtnTrigger, coreOperation, response, idName, verificationMsg, interval;

$$.addEventListener('DOMContentLoaded', function () {

	//vars
	var options = $$.querySelectorAll(".services-item");
	var i;

	//core
	if (dataCustomerProduct.numberServiceProduct === 0) {
		notiSystem('Atención al cliente', dataCustomerProduct.messageReposition, iconInfo, {
			btn1: {
				link: 'vistaconsolidada',
				action: 'redirect',
				text: txtBtnAcceptNotiSystem
			}
		});
	}

	for (i = 0; i < options.length; i++) {
		options[i].addEventListener('click', function (e) {
			if (!this.classList.contains("is-disabled") && !this.classList.contains("active")) {
				var j, idNameCapitalize;
				resetForms(form);
				idName = this.id;
				idNameCapitalize = idName.charAt(0).toUpperCase() + idName.slice(1);
				form = $(`#form${idNameCapitalize}`);

				for (j = 0; j < options.length; j++) {
					options[j].classList.remove("active");
					$$.getElementById(`${options[j].id}View`).classList.remove("fade-in");
				}
				this.classList.add("active");
				$$.getElementById(`${idName}View`).classList.add("fade-in");

				btnTrigger = $$.getElementById(`btn${idNameCapitalize}`);
				txtBtnTrigger = btnTrigger.innerHTML.trim();
				disableInputsForm(idName, false, txtBtnTrigger);

				btnTrigger.addEventListener('click', function (e) {
					e.preventDefault();

					coreOperation = new operationFactory(`fn${idNameCapitalize}`);

					validateForms(form, {
						handleMsg: true
					});
					if (form.valid()) {
						disableInputsForm(idName, true, msgLoadingWhite);
						proccessPetition(coreOperation, idName);
					} else {
						disableInputsForm(idName, false, txtBtnTrigger);
					}
				});
			}
		});
	}
})

//functions
function operationFactory(optionMenu, response = null) {
	var responseForm = {
		0: function (response) {
			notiSystem(response.title, response.msg, response.classIconName, response.data);
			btnTrigger.innerHTML = txtBtnTrigger;
		},
		1: function (response) {
			btnTrigger.disabled = false;
			btnTrigger.innerHTML = txtBtnTrigger;
			$$.getElementById(`${idName}TxtMsgErrorCodeOTP`).innerText = '';
			$$.getElementById(`${idName}CodeOTP`).disabled = false;
			verificationMsg = $$.getElementById(`${idName}VerificationMsg`);
			verificationMsg.innerHTML = `${dataCustomerProduct.msgResendOTP} Tiempo restante:<span class="ml-1 danger"></span>`;
			verificationMsg.querySelector("a").setAttribute('id', `${idName}ResendCode`);
			$$.getElementById(`${idName}ResendCode`).addEventListener('click', function (e) {
				e.preventDefault();
				resendCodeOTP(coreOperation);
			});
			verificationMsg.classList.remove("semibold", "danger");
			var countdown = verificationMsg.querySelector("span");
			startTimer(response.validityTime, countdown);
			$$.getElementById(`${idName}VerificationOTP`).classList.remove("none");
		},
		2: function (response) {
			btnTrigger.innerHTML = txtBtnTrigger;
			btnTrigger.disabled = false;
			notiSystem(response.title, response.msg, response.classIconName, response.data);
			// disableInputsForm (idName, false, txtBtnTrigger);
		},
		3: function (response) {
			$$.getElementById(`${idName}CodeOTP`).value = '';
			$$.getElementById(`${idName}CodeOTP`).disabled = true;
			$$.getElementById(`${idName}VerificationMsg`).innerHTML = response.msg + ' ' + dataCustomerProduct.msgResendOTP;
			$$.getElementById(`${idName}VerificationMsg`).classList.add("semibold", "danger");
			$$.getElementById(`${idName}VerificationMsg`).classList.remove('none');
			btnTrigger.innerHTML = txtBtnTrigger;

			$$.getElementById(`${idName}VerificationMsg`).querySelector("a").setAttribute('id', `${idName}ResendCode`);
			$$.getElementById(`${idName}ResendCode`).addEventListener('click', function (e) {
				e.preventDefault();
				resendCodeOTP(coreOperation);
			});
		},
		5: function (response) {
			$$.getElementById(`${idName}CodeOTP`).value = '';
			btnTrigger.innerHTML = txtBtnTrigger;
			btnTrigger.disabled = false;
			notiSystem(response.title, response.msg, response.classIconName, response.data);
		},
		99: function (response) {
			notiSystem(response.title, response.msg, response.classIconName, response.data);
			btnTrigger.innerHTML = txtBtnTrigger;
			btnTrigger.disabled = false;
		}
	}

	function fnGenerate() {

		var dataForm = {
			newPin: $$.getElementById('generateNewPin').value,
			confirmPin: $$.getElementById('generateConfirmPin').value,
			codeOTP: $$.getElementById('generateCodeOTP').value
		}
		return {
			data: dataForm,
			response: responseForm
		};
	}

	function fnChange() {

		var dataForm = {
			codeOTP: $$.getElementById('changeCodeOTP').value,
			pinCurrent: $$.getElementById('changeCurrentPin').value,
			newPin: $$.getElementById('changeNewPin').value,
			confirmPin: $$.getElementById('changeConfirmPin').value,
		};
		return {
			data: dataForm,
			response: responseForm
		};
	}

	function fnLock() {
		var dataForm = {
			codeOTP: $$.getElementById('lockCodeOTP').value,
			unlock: !dataCustomerProduct.availableServices.includes("111"),
		};
		return {
			data: dataForm,
			response: responseForm
		};
	}

	function fnReplace() {
		var dataForm = {
			reasonRequest: $$.getElementById('replaceMotSol').value,
			codeOTP: $$.getElementById('replaceCodeOTP').value,
		};
		return {
			data: dataForm,
			response: responseForm
		};
	}

	return eval(`${optionMenu}`)(response);
}

function disableInputsForm(optionMenu, status, txtButton) {
	var elementsForm;
	switch (optionMenu) {
		case 'generate':
			elementsForm = ['generateNewPin', 'generateConfirmPin'];
			break;

		case 'change':
			elementsForm = ['changeCurrentPin', 'changeNewPin', 'changeConfirmPin'];
			break;

		case 'lock':
			elementsForm = [];
			break;

		case 'replace':
			elementsForm = ['replaceMotSol'];
			break;
	}
	elementsForm.forEach(function (element) {
		$$.getElementById(element).disabled = status;
	});
	btnTrigger.innerHTML = txtButton;
	btnTrigger.disabled = status;
}

function resendCodeOTP(coreOperation) {
	clearInterval(interval);
	btnTrigger.disabled = true;
	coreOperation.data.codeOTP = '';
	$$.getElementById(`${idName}VerificationMsg`).innerHTML = msgLoading;
	proccessPetition(coreOperation, idName);
}

function proccessPetition(coreOperation, idName) {
	callNovoCore('POST', 'ServiceProduct', idName, coreOperation.data, function (response) {

		const responseCode = coreOperation.response.hasOwnProperty(response.code) ? response.code : 99
		coreOperation.response[responseCode](response);
	});
}

function resetForms(formData) {
	if (formData) {
		if (validator) {
			formData.find(".has-error").each(function () {
				validator.successList.push(this); //mark as error free
			});
			validator.showErrors(); //remove error messages if present
			validator.resetForm(); //remove error class on name elements and clear history
		}
		clearInterval(interval);
		$$.getElementById(`${idName}VerificationMsg`).innerHTML = '';
		$$.getElementById(`${idName}CodeOTP`).disabled = true;
		$$.getElementById(`${idName}VerificationOTP`).classList.add('none');
		formData[0].reset();
	}
}

function startTimer(duration, display) {
	var timer = duration,
		minutes, seconds;
	interval = setInterval(myTimer, 1000);

	function myTimer() {
		minutes = parseInt(timer / 60, 10)
		seconds = parseInt(timer % 60, 10);

		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;

		display.textContent = minutes + ":" + seconds;

		if (--timer < 0) {
			clearInterval(interval);

			$$.getElementById(`${idName}CodeOTP`).value = '';
			$$.getElementById(`${idName}CodeOTP`).disabled = true;
			verificationMsg.innerHTML = `Tiempo expirado. ${dataCustomerProduct.msgResendOTP}`;
			verificationMsg.classList.add("semibold", "danger");
			btnTrigger.disabled = true;

			verificationMsg.querySelector("a").setAttribute('id', `${idName}ResendCode`);
			$$.getElementById(`${idName}ResendCode`).classList.add("regular");
			$$.getElementById(`${idName}ResendCode`).addEventListener('click', function (e) {
				e.preventDefault();
				resendCodeOTP(coreOperation);
			});
		}
	}
}
