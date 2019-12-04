'use strict';
var $$ = document;
var form, btnTrigger, txtBtnTrigger = btnTrigger.innerHTML.trim();

$$.addEventListener('DOMContentLoaded', function(){

  //vars
  var options = $$.querySelectorAll(".services-item");
	var i;

	//core
	for (i = 0; i < options.length; i++) {
		options[i].addEventListener('click',function(e){
			if (!this.classList.contains("is-disabled")) {
				var j, idNameCapitalize, idName;
				idName = this.id;
				idNameCapitalize = idName.charAt(0).toUpperCase() + idName.slice(1);

				for (j = 0; j < options.length; j++) {
					options[j].classList.remove("active");
					$$.getElementById(`${idName}View`).classList.add("none");
				}
				this.classList.add("active");
				$$.getElementById(`${idName}View`).classList.remove("none");

				btnTrigger = $$.getElementById(`btn${idNameCapitalize}`);

				btnTrigger.addEventListener('click',function(e){
					e.preventDefault();

					form = $(`#form${idNameCapitalize}`);
					validateForms(form, {handleMsg: true});
					if(form.valid()) {
						disableInputsForm(idName, true, msgLoading);
						var data = new requestFactory(`fn${idNameCapitalize}`);
						callNovoCore('POST', 'ServiceProduct', idName, data, function(response) {

							switch (response.code) {
								case 0:
									console.log('fino con OTP');
									break;

								case 1:
									console.log('fino sin OTP');
									btnTrigger.disabled = false;
									btnTrigger.innerHTML = txtBtnTrigger;
									$$.getElementById("verificationOTP").classList.remove("none");
									$$.getElementById('codeOTP').disabled = false;
									break;

								case 3:
									console.log('OTP inválido');
									resendCodeOTP (response.msg);

									break;

								default:
									disableInputsForm(idName, false, txtBtnTrigger);
									break;
							}

							$$.getElementById('resendCode').addEventListener('click', function(){
								resendCodeOTP();
							})

						});
					}
				});
			}
		});
	}

})

//functions
function requestFactory(optionMenu) {

	function fnGenerate(){
		var md5CodeOTP = '';
		var inpCodeOTP = $$.getElementById('codeOTP').value;
		if (inpCodeOTP) {
			md5CodeOTP = CryptoJS.MD5(inpCodeOTP).toString()
		}
		return {
			newPin: $$.getElementById('newPin').value,
			confirmPin: $$.getElementById('confirmPin').value,
			codeOTP: md5CodeOTP
		};
	}
	function fnChange(){
		return console.log('change function');
	}
	function fnLock(){
		return console.log('lock function');
	}
	function fnReplace(){
		return console.log('replace function');
	}

	return eval(`${optionMenu}`)();
}

function disableInputsForm(optionMenu, status, txtButton) {
	switch (optionMenu) {
		case 'generate':
			$$.getElementById('newPin').disabled = status;
			$$.getElementById('confirmPin').disabled = status;
			btnTrigger.innerHTML = txtButton;
			btnTrigger.disabled = status;
			break;

		case 'change':
			btnTrigger.innerHTML = txtButton;
			btnTrigger.disabled = status;
			break;

		case 'lock':
			btnTrigger.innerHTML = txtButton;
			btnTrigger.disabled = status;
			break;

		case 'replace':
			btnTrigger.innerHTML = txtButton;
			btnTrigger.disabled = status;
			break;
	}
}

function resendCodeOTP () {
	btnTrigger.disabled = true;
	btnTrigger.innerHTML = msgLoading;
	$$.getElementById('codeOTP').disabled = true;

	callNovoCore('POST', 'User', 'verifyAccount', data, function(response) {
		if (response.code == 0) {
			btnTrigger.disabled = false;
			btnTrigger.innerHTML = txtBtnTrigger;
			$$.getElementById('codeOTP').disabled = true;
		}
		else{
			notiSystem(response.title, response.msg, response.classIconName, response.data);
			disableInputsForm(false, txtBtnTrigger);
		}
	});
}
