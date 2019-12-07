'use strict';
var $$ = document;
var form, btnTrigger, txtBtnTrigger, coreOperation, response, idName;

$$.addEventListener('DOMContentLoaded', function(){

	//vars
  var options = $$.querySelectorAll(".services-item");
	var i;

	//core
	for (i = 0; i < options.length; i++) {
		options[i].addEventListener('click',function(e){
			if (!this.classList.contains("is-disabled")) {
				var j, idNameCapitalize
				idName = this.id;
				idNameCapitalize = idName.charAt(0).toUpperCase() + idName.slice(1);

				for (j = 0; j < options.length; j++) {
					options[j].classList.remove("active");
					$$.getElementById(`${options[j].id}View`).classList.add("none");
				}
				this.classList.add("active");
				$$.getElementById(`${idName}View`).classList.remove("none");

				btnTrigger = $$.getElementById(`btn${idNameCapitalize}`);
				txtBtnTrigger = btnTrigger.innerHTML.trim();

				btnTrigger.addEventListener('click',function(e){
					e.preventDefault();

					coreOperation = new operationFactory(`fn${idNameCapitalize}`);

					form = $(`#form${idNameCapitalize}`);
					validateForms(form, {handleMsg: true});
					if(form.valid()) {

						disableInputsForm(idName, true, msgLoadingWhite);
						proccessPetition(coreOperation, idName);

					}else{
						notiSystem (response.title, response.msg, response.classIconName, response.data);
						disableInputsForm (idName, false, txtBtnTrigger);
					}

				});
			}
		});
	}
})

//functions
function operationFactory(optionMenu, response = null) {

	function fnGenerate(response = null){
		var md5CodeOTP = '';
		var inpCodeOTP = $$.getElementById('codeOTP').value;
		if (inpCodeOTP) {
			md5CodeOTP = CryptoJS.MD5(inpCodeOTP).toString()
		}

		var dataForm = {
			newPin: $$.getElementById('newPin').value,
			confirmPin: $$.getElementById('confirmPin').value,
			codeOTP: md5CodeOTP
		}

		var responseForm = {
			0: function (response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
			},
			1: function(){
				btnTrigger.disabled = false;
				btnTrigger.innerHTML = txtBtnTrigger;
				$$.getElementById("verificationOTP").classList.remove("none");
				$$.getElementById("verificationMsg").classList.add("none");
				$$.getElementById('txtMsgErrorCodeOTP').innerText = '';
				$$.getElementById('codeOTP').disabled = false;
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			},
			2: function(response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
				disableInputsForm (idName, false, txtBtnTrigger);
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			},
			3: function(response){
				$$.getElementById('codeOTP').value = '';
				$$.getElementById('codeOTP').disabled = true;
				$$.getElementById('verificationMsg').innerHTML =  dataCustomerProduct.msgResendOTP;
				$$.getElementById('verificationMsg').classList.remove('none');
				$$.getElementById('txtMsgErrorCodeOTP').innerText = response.msg;
				btnTrigger.innerHTML =txtBtnTrigger;

				$$.getElementById('resendCode').addEventListener('click', function(e){
					e.preventDefault();
					resendCodeOTP(coreOperation);
				});
			},
			99: function(response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			}
		}
		return {data: dataForm, response: responseForm};
	}
	function fnChange(){
		var md5CodeOTP = '';
		var inpCodeOTP = $$.getElementById('changeCodeOTP').value;
		if (inpCodeOTP) {
			md5CodeOTP = CryptoJS.MD5(inpCodeOTP).toString()
		}

		var dataForm = {
			codeOTP: md5CodeOTP,
			pinCurrent: $$.getElementById('changeCurrentPin').value,
			newPin: $$.getElementById('changeNewPin').value,
			confirmPin: $$.getElementById('changeConfirmPin').value,
		}

		var responseForm = {
			0: function (response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
			},
			1: function(){
				btnTrigger.disabled = false;
				btnTrigger.innerHTML = txtBtnTrigger;
				$$.getElementById(`${idName}VerificationOTP`).classList.remove("none");
				$$.getElementById(`${idName}VerificationMsg`).classList.add("none");
				$$.getElementById(`${idName}TxtMsgErrorCodeOTP`).innerText = '';
				$$.getElementById(`${idName}CodeOTP`).disabled = false;
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			},
			2: function(response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
				disableInputsForm (idName, false, txtBtnTrigger);
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			},
			3: function(response){
				$$.getElementById(`${idName}CodeOTP`).value = '';
				$$.getElementById(`${idName}CodeOTP`).disabled = true;
				$$.getElementById(`${idName}VerificationMsg`).innerHTML =  dataCustomerProduct.msgResendOTP;
				$$.getElementById(`${idName}VerificationMsg`).classList.remove('none');
				$$.getElementById(`${idName}TxtMsgErrorCodeOTP`).innerText = response.msg;
				btnTrigger.innerHTML =txtBtnTrigger;

				$$.getElementById('resendCode').addEventListener('click', function(e){
					e.preventDefault();
					resendCodeOTP(coreOperation);
				});
			},
			99: function(response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			}
		}

		return {data: dataForm, response: responseForm};
	}
	function fnLock(){
		return console.log('lock function');
	}
	function fnReplace(){
		return console.log('replace function');
	}

	return eval(`${optionMenu}`)(response);
}

function disableInputsForm(optionMenu, status, txtButton) {
	var elementsForm;
	switch (optionMenu) {
		case 'generate':
			elementsForm = ['newPin', 'confirmPin'];
			break;

		case 'change':
				elementsForm = ['changeCurrentPin','changeNewPin', 'changeConfirmPin'];
				break;

		case 'lock':
			break;

		case 'replace':
			break;
	}
	elementsForm.forEach(function (element) {
		$$.getElementById(element).disabled = status;
	});
	btnTrigger.innerHTML = txtButton;
	btnTrigger.disabled = status;
}

function resendCodeOTP (coreOperation) {

	btnTrigger.disabled = true;
	coreOperation.data.codeOTP = '';
	$$.getElementById('verificationMsg').innerHTML = msgLoading;
	proccessPetition(coreOperation, 'generate');
}

function proccessPetition(coreOperation, idName)
{
	callNovoCore('POST', 'ServiceProduct', idName, coreOperation.data, function(response) {

		const responseCode = coreOperation.response.hasOwnProperty(response.code) ? response.code : 99
		coreOperation.response[responseCode](response);
	});
}
