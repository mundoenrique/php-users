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
		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: true});
		if(form.valid()) {


			var typeDocument = $$.getElementById('typeDocument');
			var document_id = $$.getElementById('idNumber').value;
			disableInputsForm(true, msgLoading);

			data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				typeDocument: typeDocument.options[typeDocument.selectedIndex].value,
				nitBussines: $$.getElementById('nitBussines').value,
				telephone_number: $$.getElementById('telephoneNumber').value,
				codeOTP: ''
			}

			callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
			{
				disableInputsForm(true, txtBtnTrigger);
				if (response.code == 0) {
					// notiSystem(response.title, response.msg, response.classIconName, response.data);
					verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
					$$.getElementById("verification").classList.remove("none");
					$$.getElementById('codeOTP').disabled = false;
					var countdown = verificationMsg.querySelector("span");
					startTimer(setTimerOTP, countdown);
					btnTrigger.disabled = false;
				}
				else{
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					disableInputsForm(false, txtBtnTrigger);
				}
			});
		}else{
			disableInputsForm(false, txtBtnTrigger);
		}
	});

	$$.getElementById("accept").addEventListener('click', function(){

		var btnTrigger = $$.getElementById('accept');
		var inpCodeOTP = $$.getElementById('codeOTP');
		if (inpCodeOTP){

			var form = $('#formNotiSystem');
			validateForms(form, {handleMsg: true});
			if(form.valid()) {
				btnTrigger.disabled = true;
				btnTrigger.innerHTML = msgLoading;

				data['codeOTP'] = CryptoJS.MD5(inpCodeOTP.value).toString();
				callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
				{
					if (response.code === 0){
						$$.location.href = response.data;
					}
					else{
						if (response.code === 3){
							resendCodeOTP ('Codigo inválido');
						}
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
			$$.getElementById('accept').classList.add("none");
			$$.getElementById('codeOTP').disabled = true;

			$$.getElementById('resendCode').addEventListener('click', function(){
				console.log('solicitando el nuevo código....');
			});
		}
	}
});



