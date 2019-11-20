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

				if (response.code == 0) {
					notiSystem(response.title, response.msg, response.classIconName, response.data);
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

		if ($$.getElementById('codeOTP')){

			var form = $('#formNotiSystem');
			validateForms(form, {handleMsg: true});
			if(form.valid()) {
				data['codeOTP'] = CryptoJS.MD5($$.getElementById('codeOTP').value).toString();
				callNovoCore('POST', 'User', 'verifyAccount', data, function(response)
				{
					if (response.code === 0){
						$$.location.href = response.data;
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

	function redirectPost(url, data, csrf) {

		/* var cpo_cook = decodeURIComponent(
			document.cookie.replace(/(?:(?:^|.*;\s*)cpo_cook\s*\=\s*([^;]*).*$)|^.*$/, '$1')
		); */
		// call this function --> redirectPost(response.data, response.msg.dataUser.user, cpo_cook);

    var form = $$.createElement('form');
    $$.body.appendChild(form);
    form.method = 'post';
    form.action = url;
    for (var name in data) {
			var input = $$.createElement('input');
			input.type = 'hidden';
			input.name = name;
			input.id = name;
			input.value = data[name] || ' ';
			form.appendChild(input);
		}

		var input = $$.createElement('input');
		input.type = 'hidden';
		input.name = 'cpo_name';
		input.id = 'cpo_name';
		input.value = csrf;
		form.appendChild(input);

    form.submit();
	}

	function disableInputsForm(status, txtButton)
	{
		document.getElementById('idNumber').disabled = status;
		document.getElementById('telephoneNumber').disabled = status;
		document.getElementById('nitBussines').disabled = status;
		btnTrigger.innerHTML = txtButton;
		btnTrigger.disabled = status;
	}

	function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10)
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
            alert('finish countown...');
        }
    }, 1000);
	}

});



