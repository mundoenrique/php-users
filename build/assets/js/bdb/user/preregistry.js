'use strict';
var $$ = document;
var data = {};

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnTrigger = $$.getElementById('btnValidar');
	var txtBtnTrigger = btnTrigger.innerHTML.trim();

	//core
	btnTrigger.addEventListener('click',function(e){
		e.preventDefault();
		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: true});
		if(form.valid()) {

			disableInputsForm(true, msgLoading);

			var document_id = $$.getElementById('idNumber').value;
			data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				nitBussines: $$.getElementById('nitBussines').value,
				telephone_number: $$.getElementById('telephoneNumber').value,
				codeOTP: ''
			}

			callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
			{
				disableInputsForm(true, txtBtnTrigger);
				if (response.code == 0) {
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					$("#footerSistemInfo").prepend(`<span class="align-middle">Tiempo restante:<span class="ml-1 danger"></span></span>`);
					var baseElement = $$.getElementById("footerSistemInfo");
					var countdown = baseElement.querySelector("span span");
					startTimer(setTimerOTP, countdown);
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
							inpCodeOTP.disabled = true;
							btnTrigger.disabled = false;
							btnTrigger.innerHTML = txtBtnAcceptNotiSystem;
							var lastPosition = $$.getElementsByClassName('help-block').length-1;
							$$.getElementsByClassName('help-block').item(lastPosition).innerText = response.msg;

							$('#accept')
							.on('click', function() {
								$$.location.href = response.data;
							});
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
					display.textContent = 'tiempo expirado';
					setTimeout(function(){

						clearInterval(interval);

						$$.getElementById('accept').disabled = true;
						$$.getElementById('codeOTP').disabled = true;

						$$.location.href = uriRedirecTarget;

					}, 2000);

			}
		}
	}
});



