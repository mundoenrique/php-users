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
				var j, idName = this.id;
				for (j = 0; j < options.length; j++) {
					options[j].classList.remove("active");
					$$.getElementById(`${idName}View`).classList.add("none");
				}
				this.classList.add("active");
				$$.getElementById(`${idName}View`).classList.remove("none");

				idName = idName.charAt(0).toUpperCase() + idName.slice(1);
				form = $('#form'+idName);
				btnTrigger = $$.getElementById(`btn${idName}`);

				btnTrigger.addEventListener('click',function(e){
					e.preventDefault();
					validateForms(form, {handleMsg: false});
					if(form.valid()) {
						console.log("Válido");

					} else {
						console.log("No válido");
					}
				});
			}
		});
	}

})
