'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){

  //vars
  var options = $$.querySelectorAll(".services-item");
	var form, i, btnTrigger;

	//core
	for (i = 0; i < options.length; i++) {
		options[i].addEventListener('click',function(e){
			if (!this.classList.contains("is-disabled")) {
				var j, idNameCapitalize, idName = this.id;
				for (j = 0; j < options.length; j++) {
					options[j].classList.remove("active");
					$$.getElementById(`${idName}View`).classList.add("none");
				}
				this.classList.add("active");
				$$.getElementById(`${idName}View`).classList.remove("none");

				idNameCapitalize = idName.charAt(0).toUpperCase() + idName.slice(1);
				form = $('#form'+idNameCapitalize);
				btnTrigger = $$.getElementById(`btn${idNameCapitalize}`);

				btnTrigger.addEventListener('click',function(e){
					e.preventDefault();

					// if(form.valid()) {
					// 	console.log("Válido");
					var data = new requestFactory(`fn${idNameCapitalize}`);
					callNovoCore('POST', 'ServiceProduct', idName, data, function(response)
					{
						disableInputsForm(true, txtBtnTrigger);
						if (response.code == 0) {
							console.log('fino fino');
						}
					});
					// } else {
					// 	console.log("No válido");
					// }
				});
			}
		});
	}

	//functions
	function requestFactory(optionMenu){

		function fnGenerate(){
			return {
				newPin: $$.getElementById('newPin').value,
				confirmPin: $$.getElementById('confirmPin').value,
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

})
