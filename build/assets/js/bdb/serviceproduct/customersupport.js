'use strict';
var $$ = document;
var form, btnTrigger, txtBtnTrigger, coreOperation, response;

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
					$$.getElementById('resendCode').addEventListener('click', function(){resendCodeOTP(coreOperation)});
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

		var respnseForm = {
			0: function (response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
			},
			1: function(){
				btnTrigger.disabled = false;
				btnTrigger.innerHTML = txtBtnTrigger;
				$$.getElementById("verificationOTP").classList.remove("none");
				$$.getElementById("verificationMsg").classList.add("visible");
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
				$$.getElementById('verificationMsg').classList.remove('visible');
				$$.getElementById('txtMsgErrorCodeOTP').innerText = response.msg;
				$$.getElementById('verificationMsg').innerHtml =  dataCustomerProduct.msgResendOTP;
				btnTrigger.innerHTML =txtBtnTrigger;
			},
			99: function(response){
				notiSystem (response.title, response.msg, response.classIconName, response.data);
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			}
		}
		return {data: dataForm, response: respnseForm};
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

	return eval(`${optionMenu}`)(response);
}

function disableInputsForm(optionMenu, status, txtButton) {
	var elementsForm;
	switch (optionMenu) {
		case 'generate':
			elementsForm = ['newPin', 'confirmPin'];
			break;

		case 'change':
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
	event.preventDefault();
	btnTrigger.disabled = true;
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
