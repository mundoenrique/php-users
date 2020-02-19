'use strict';
var $$ = document;
var data = {};
var interval;

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

		var typeDocumentUser = $$.getElementById('typeDocumentUser');
		var typeDocumentBussines = $$.getElementById('typeDocumentBussines');
		var document_id = $$.getElementById('idNumber').value;

		var codeTypeDocumentUser = typeDocumentUser.options[typeDocumentUser.selectedIndex].value;
		var codeTypeDocumentBussines = typeDocumentBussines.options[typeDocumentBussines.selectedIndex].value;

		validateForms(form, {handleMsg: true});
		if(form.valid()) {

			var abbrTypeDocumentUser = dataPreRegistry.typeDocument.find(function(e){return e['id'] == codeTypeDocumentUser}).abreviatura
			var abbrTypeDocumentBussines = dataPreRegistry.typeDocument.find(function(e){return e['id'] == codeTypeDocumentBussines}).abreviatura

			disableInputsForm(true, msgLoadingWhite);

			if (inpCodeOTP.value){
				md5CodeOTP = CryptoJS.MD5(inpCodeOTP.value).toString()
				clearInterval(interval);
			}

			data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				codeTypeDocumentUser: codeTypeDocumentUser,
				abbrTypeDocumentUser: abbrTypeDocumentUser,
				id_ext_per: document_id,
				codeTypeDocumentBussines: codeTypeDocumentBussines,
				abbrTypeDocumentBussines: abbrTypeDocumentBussines,
				nitBussines: $$.getElementById('nitBussines').value,
				telephone_number: $$.getElementById('telephoneNumber').value,
				acceptTerms: $$.getElementById('acceptTerms').checked,
				codeOTP: md5CodeOTP
 			};

			callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
			{
				disableInputsForm(true, txtBtnTrigger);
				if (response.code == 0) {

					btnTrigger.disabled = false;
					btnTrigger.innerHTML = txtBtnTrigger;

					if (inpCodeOTP.value){
						verificationMsg.classList.add("none");
						$$.location.href = response.data;
					}

					verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
					$$.getElementById("verification").classList.remove("none");
					verificationMsg.classList.remove("semibold", "danger");
					$$.getElementById('codeOTP').disabled = false;
					var countdown = verificationMsg.querySelector("span");
					startTimer(response.validityTime, countdown);

				}
				else if (response.code === 3){
						resendCodeOTP(response.msg);
				}else{
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					disableInputsForm(false, txtBtnTrigger);
				}
			});
		}else{
			disableInputsForm(false, txtBtnTrigger);
		}
	});

	$$.getElementById("termsConditions").addEventListener('click', function() {
		var dialogConditions = $('#dialogConditions');
		window.scrollTo(0,0);

		// MODAL TERMINOS Y CONDICIONES
		dialogConditions.dialog({
			autoOpen: false,
			modal: true,
			draggable: false,
			resizable: false,
			closeOnEscape: false,
			position: { my: "center top+5", at: "center top+5", of:  "#preRegistry" },
			width: 940,
			dialogClass: "border-none",
			classes: {
				"ui-dialog-titlebar": "none",
			},
			show: {
				duration: 250
			},
			hide: {
				duration: 250
			},
			open: function (event, ui) {
				$('#aceptar').on('click', function(e) {
					dialogConditions.dialog('close');
					$(this).off('click');
					$("body").css("overflowY", "auto");
					dialogConditions.dialog( "destroy" );
					dialogConditions.addClass("none");
				});
				$("body").css("overflowY", "hidden");
				$(this).css("overflowY", "scroll");
				$(this).css("max-height", "calc(-20px - 3.75rem + 100vh)");
				$(this).removeClass("none");
			}
		});

		dialogConditions.dialog("open");
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
		$$.getElementById('typeDocumentUser').disabled = status;
		$$.getElementById('typeDocumentBussines').disabled = status;
		$$.getElementById('acceptTerms').disabled = status;
		btnTrigger.innerHTML = txtButton;
		btnTrigger.disabled = status;
	}

	function startTimer(duration, display)
	{
		var timer = duration, minutes, seconds;
		interval = setInterval(myTimer, 1000);

		function myTimer() {
			minutes = parseInt(timer / 60, 10)
			seconds = parseInt(timer % 60, 10);

			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

			display.textContent = minutes + ":" + seconds;

			if (--timer < 0) {
				clearInterval(interval);
				resendCodeOTP ('Tiempo expirado.');
			}
		}
	}

	function resendCodeOTP (message) {
		verificationMsg.innerHTML = `${message} <a id="resendCode" class="primary regular" href="#">Solicitar nuevo código.</a>`;
		verificationMsg.classList.add("semibold", "danger");
		clearInterval(interval);
		btnTrigger.disabled = true;
		$$.getElementById('codeOTP').disabled = true;

		$$.getElementById('resendCode').addEventListener('click', function(e){
			e.preventDefault();

			$$.getElementById('codeOTP').value = '';
			disableInputsForm(true, msgLoadingWhite);
			data.codeOTP = '';
			callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
			{
				if (response.code == 0) {
					btnTrigger.disabled = false;
					btnTrigger.innerHTML = txtBtnTrigger;
					verificationMsg.innerHTML = 'Tiempo restante:<span class="ml-1 danger"></span></span>';
					verificationMsg.classList.remove("semibold", "danger");
					$$.getElementById('codeOTP').disabled = false;
					var countdown = verificationMsg.querySelector("span");
					startTimer(response.validityTime, countdown);
				}
				else{
					notiSystem(response.title, response.msg, response.classIconName, response.data);
					disableInputsForm(false, txtBtnTrigger);
				}
			});
		});
	}
});



