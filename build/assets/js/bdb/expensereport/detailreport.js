'use strict';
var $$ = document;
var form, btnTrigger, txtBtnTrigger, coreOperation, response, idName, validator;

$$.addEventListener('DOMContentLoaded', function(){

	//vars
  var options = $$.querySelectorAll(".services-item");
	var i;

	//core
	for (i = 0; i < options.length; i++) {
		options[i].addEventListener('click',function(e) {
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

				btnTrigger.addEventListener('click',function(e){
					e.preventDefault();

					coreOperation = new operationFactory(`fn${idNameCapitalize}`);

					validateForms(form, {handleMsg: true});
					if(form.valid()) {
						disableInputsForm(idName, true, msgLoadingWhite);
						proccessPetition(coreOperation, idName);
					} else {
						disableInputsForm (idName, false, txtBtnTrigger);
					}
				});
			}
		});
	}
})

//functions
function operationFactory(optionMenu, response = null)
{
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

			$$.getElementById(`${idName}VerificationMsg`).firstChild.setAttribute('id',`${idName}ResendCode`)
			$$.getElementById(`${idName}ResendCode`).addEventListener('click', function(e){
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

	function fnGenerate() {

		var dataForm = {
			newPin: $$.getElementById('generateNewPin').value,
			confirmPin: $$.getElementById('generateConfirmPin').value,
			codeOTP: $$.getElementById('generateCodeOTP').value
		}
		return {data: dataForm, response: responseForm};
	}

	function fnChange() {

		var dataForm = {
			codeOTP: $$.getElementById('changeCodeOTP').value,
			pinCurrent: $$.getElementById('changeCurrentPin').value,
			newPin: $$.getElementById('changeNewPin').value,
			confirmPin: $$.getElementById('changeConfirmPin').value,
		}
		return {data: dataForm, response: responseForm};
	}
	function fnLock() {
		var dataForm = {
			codeOTP: $$.getElementById('lockCodeOTP').value,
		}
		return {data: dataForm, response: responseForm};
	}
	function fnReplace() {
		var dataForm = {
			reasonRequest: $$.getElementById('replaceMotSol').value,
			codeOTP: $$.getElementById('replaceCodeOTP').value,
		}
		return {data: dataForm, response: responseForm};
	}

	return eval(`${optionMenu}`)(response);
}

function disableInputsForm(optionMenu, status, txtButton)
{
	var elementsForm;
	switch (optionMenu) {
		case 'generate':
			elementsForm = ['generateNewPin', 'generateConfirmPin'];
			break;

		case 'change':
			elementsForm = ['changeCurrentPin','changeNewPin', 'changeConfirmPin'];
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

function resendCodeOTP (coreOperation)
{
	btnTrigger.disabled = true;
	coreOperation.data.codeOTP = '';
	$$.getElementById(`${idName}VerificationMsg`).innerHTML = msgLoading;
	proccessPetition(coreOperation, idName);
}

function proccessPetition(coreOperation, idName)
{
	callNovoCore('POST', 'ServiceProduct', idName, coreOperation.data, function(response) {

		const responseCode = coreOperation.response.hasOwnProperty(response.code) ? response.code : 99
		coreOperation.response[responseCode](response);
	});
}

function resetForms(formData){
	if(formData) {
		if (validator) {
			formData.find(".has-error").each(function(){
				validator.successList.push(this);//mark as error free
			});
			validator.showErrors();//remove error messages if present
			validator.resetForm();//remove error class on name elements and clear history
		}
		formData[0].reset();
	}
}
