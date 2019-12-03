'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){

  //vars
  var options = $$.querySelectorAll(".services-item");
  var generateOption = $$.getElementById('generate');
  var changeOption = $$.getElementById('change');
  var lockOption = $$.getElementById('lock');
  var replaceOption = $$.getElementById('replace');

	var generateView = $$.getElementById('generatePin');
  var changeView = $$.getElementById('changePin');
  var lockView = $$.getElementById('lockAccount');
  var replacementView = $$.getElementById('replacement');

	var generateForm = $$.getElementById('generatePinForm');
  var changeForm = $$.getElementById('changePinForm');
  var lockForm = $$.getElementById('lockAccountForm');
	var replacementForm = $$.getElementById('replacementForm');

	//core
	generateOption.addEventListener('click',function(e){
		if (!this.classList.contains("is-disabled")) {
			var i;
			for (i = 0; i < options.length; i++) {
				options[i].classList.remove("active");
			}
			this.classList.add("active");

			changeView.classList.add("none");
			lockView.classList.add("none");
			replacementView.classList.add("none");
			generateView.classList.remove("none");
		}
	});

	changeOption.addEventListener('click',function(e){
		if (!this.classList.contains("is-disabled")) {
			var i;
			for (i = 0; i < options.length; i++) {
				options[i].classList.remove("active");
			}
			this.classList.add("active");


			generateView.classList.add("none");
			lockView.classList.add("none");
			replacementView.classList.add("none");
			changeView.classList.remove("none");
		}
	});

	lockOption.addEventListener('click',function(e){
		if (!this.classList.contains("is-disabled")) {
			var i;
			for (i = 0; i < options.length; i++) {
				options[i].classList.remove("active");
			}
			this.classList.add("active");

			generateView.classList.add("none");
			changeView.classList.add("none");
			replacementView.classList.add("none");
			lockView.classList.remove("none");
		}
  });

	replaceOption.addEventListener('click',function(e){
		if (!this.classList.contains("is-disabled")) {
			var i;
			for (i = 0; i < options.length; i++) {
				options[i].classList.remove("active");
			}
			this.classList.add("active");

			generateView.classList.add("none");
			changeView.classList.add("none");
			lockView.classList.add("none");
			replacementView.classList.remove("none");
		}
	});

})
