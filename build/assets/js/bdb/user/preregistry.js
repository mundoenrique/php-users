'use strict';
var $$ = document;
var data = {};

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnTrigger = $$.getElementById('btnValidar');
	var txtBtnTrigger = btnTrigger.innerHTML.trim();
	var verificationMsg = $$.getElementById("verificationMsg");

	//core
	btnTrigger.addEventListener('click',function(e){
		e.preventDefault();
		var md5CodeOTP = '';
		var inpCodeOTP = $$.getElementById('codeOTP');
		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: true});
		if(form.valid()) {

			var typeDocument = $$.getElementById('typeDocument');
			var document_id = $$.getElementById('idNumber').value;

			var codeTypeDocument = typeDocument.options[typeDocument.selectedIndex].value;
			var abbrTypeDocument = dataPreRegistry.typeDocument.find(function(e){return e['id'] == codeTypeDocument}).abreviatura

			disableInputsForm(true, msgLoading);

			if (inpCodeOTP.value){
				md5CodeOTP = CryptoJS.MD5(inpCodeOTP.value).toString()
			}

			data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				codeTypeDocument: codeTypeDocument,
				abbrTypeDocument: abbrTypeDocument,
				nitBussines: $$.getElementById('nitBussines').value,
				telephone_number: $$.getElementById('telephoneNumber').value,
				codeOTP: md5CodeOTP
 			}

			callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
			{
				disableInputsForm(true, txtBtnTrigger);
				if (response.code == 0) {

					btnTrigger.disabled = false;

					if (inpCodeOTP.value){
						$$.location.href = response.data;
					}

					verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
					$$.getElementById("verification").classList.remove("none");
					$$.getElementById('codeOTP').disabled = false;
					var countdown = verificationMsg.querySelector("span");
					startTimer(20, countdown);

				}
				else if (response.code === 3){
						resendCodeOTP (response.msg);
				}else{
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					disableInputsForm(false, txtBtnTrigger);
				}
			});
		}else{
			disableInputsForm(false, txtBtnTrigger);
		}
	});

	$$.getElementById("btnVerifyOTP").addEventListener('click', function(){

		var btnTriggerOTP = $$.getElementById('btnVerifyOTP');
		var inpCodeOTP = $$.getElementById('codeOTP');
		if (inpCodeOTP){

			var form = $('#formVerifyAccount');
			validateForms(form, {handleMsg: true});
			if(form.valid()) {
				btnTriggerOTP.disabled = true;
				btnTriggerOTP.innerHTML = msgLoading;

				data['codeOTP'] = CryptoJS.MD5(inpCodeOTP.value).toString();
				callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
				{
					if (response.code === 0){
						$$.location.href = response.data;
					}
					else{
					}
				});
			}
		}
		else{
			return false;
		}
	});

	//functions
	function formatDate_ddmmy(dateToFormat)
	{
		var month = dateToFormat.getMonth();
		var day = dateToFormat.getDate().toString();
		var year = dateToFormat.getFullYear();

		year = year.toString().substr(-2);
		month = (month + 1).toString();

		if (month.length === 1)
		{
				month = '0' + month;
		}

		if (day.length === 1)
		{
				day = '0' + day;
		}
		return month + day + year;
	}

	function disableInputsForm(status, txtButton)
	{
		$$.getElementById('idNumber').disabled = status;
		$$.getElementById('telephoneNumber').disabled = status;
		$$.getElementById('nitBussines').disabled = status;
		$$.getElementById('typeDocument').disabled = status;
		$$.getElementById('acceptTerms').disabled = status;
		btnTrigger.innerHTML = txtButton;
		btnTrigger.disabled = status;
	}

	function startTimer(duration, display)
	{
		var timer = duration, minutes, seconds;
		var interval = setInterval(myTimer, 1000);

		function myTimer() {
			minutes = parseInt(timer / 60, 10)
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.textContent = minutes + ":" + seconds;

			if (--timer < 0) {
				clearInterval(interval);
				resendCodeOTP ('Tiempo expirado');
			}
		}

		function resendCodeOTP (message) {
			verificationMsg.innerHTML = `${message}, <a id="resendCode" class="primary" href="#">Reenviar codigo</a>`;
			btnTrigger.disabled = true;
			$$.getElementById('codeOTP').disabled = true;

			$$.getElementById('resendCode').addEventListener('click', function(){
				disableInputsForm(true, msgLoading);
				callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
				{
					if (response.code == 0) {
						btnTrigger.disabled = false;
						btnTrigger.innerHTML = txtBtnTrigger;
						verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
						$$.getElementById('codeOTP').disabled = false;
						var countdown = verificationMsg.querySelector("span");
						startTimer(15, countdown);
					}
					else{
						notiSystem(response.title, response.msg, response.classIconName, response.data);
						disableInputsForm(false, txtBtnTrigger);
					}
				});
			});
		}
	}
});



