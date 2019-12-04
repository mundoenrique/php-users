'use strict';
var $$ = document;
var form, btnTrigger;

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
					var txtBtnTrigger = btnTrigger.innerHTML.trim();

					form = $(`#form${idNameCapitalize}`);
					validateForms(form, {handleMsg: true});
					if(form.valid()) {
						var data = new requestFactory(`fn${idNameCapitalize}`);
						disableInputsForm(true, txtBtnTrigger);
						// callNovoCore('POST', 'ServiceProduct', idName, data, function(response) {
							// if (response.code == 0) {
								console.log('fino fino');
								$$.getElementById("verification").classList.remove("none");
								$$.getElementById('codeOTP').disabled = false;
							// }
						// });
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
		var inpCodeOTP = $$.getElementById('codeOTP');
		if (inpCodeOTP.value) {
			md5CodeOTP = CryptoJS.MD5(inpCodeOTP.value).toString()
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

