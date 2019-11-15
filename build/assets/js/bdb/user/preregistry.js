'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnTrigger = $$.getElementById('btnValidar');

	//core
	btnTrigger.addEventListener('click',function(e){
		e.preventDefault();

		var form = $('#formVerifyAccount');
		validateForms(form, {handleMsg: false});
		if(form.valid()) {

			var txtBtnTrigger = btnTrigger.innerHTML.trim();
			btnTrigger.innerHTML = msgLoading;
			btnTrigger.disabled = true;

			var document_id = $$.getElementById('idNumber').value;

			var data = {
				userName: document_id + '' + formatDate_ddmmy(new Date),
				id_ext_per: document_id,
				telephone_number: $$.getElementById('telephoneNumber').value
			}

			callNovoCore('POST', 'User', 'verifyAccount', data, function(response) {

				if (response.code == 0) {
					$$.location.href = response.data;
				}
				else{
					notiSystem(response.title, response.msg, response.classIconName, response.data);
				}
				btnTrigger.innerHTML = txtBtnTrigger;
				btnTrigger.disabled = false;
			});
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

});



