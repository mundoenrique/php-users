'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){

  //vars
  var options = $$.querySelectorAll(".services-item");
  var lockOption = $$.getElementById('lock');
  var replaceOption = $$.getElementById('replace');
  var keyOption = $$.getElementById('key');
  var recoverOption = $$.getElementById('recover');

  var lockForm = $$.getElementById('lockAcount');
  var keyForm = $$.getElementById('changeKey');
  var recoverForm = $$.getElementById('recKey');

  var preventBloq = $$.getElementById('preventBloq');
  var reasonRep = $$.getElementById('reasonRep');

  var bloqRepTitle = $$.getElementById('msgBlock').querySelector("h2");

  //core
	lockOption.addEventListener('click',function(e){
    var i;
    for (i = 0; i < options.length; i++) {
      options[i].classList.remove("active");
    }
    this.classList.add("active");

    keyForm.classList.add("none");
    recoverForm.classList.add("none");
    lockForm.classList.remove("none");

    reasonRep.classList.add("none");
    preventBloq.classList.remove("none");

    bloqRepTitle.textContent = "Bloquear cuenta";
  });

	replaceOption.addEventListener('click',function(e){
    var i;
    for (i = 0; i < options.length; i++) {
      options[i].classList.remove("active");
    }
    this.classList.add("active");


    keyForm.classList.add("none");
    recoverForm.classList.add("none");
    lockForm.classList.remove("none");

    preventBloq.classList.add("none");
    reasonRep.classList.remove("none");

    bloqRepTitle.textContent = "Solicitud de reposición";
  });

	keyOption.addEventListener('click',function(e){
    var i;
    for (i = 0; i < options.length; i++) {
      options[i].classList.remove("active");
    }
    this.classList.add("active");


    lockForm.classList.add("none");
    recoverForm.classList.add("none");
    keyForm.classList.remove("none");
  });

	recoverOption.addEventListener('click',function(e){
    var i;
    for (i = 0; i < options.length; i++) {
      options[i].classList.remove("active");
    }
    this.classList.add("active");


    lockForm.classList.add("none");
    keyForm.classList.add("none");
    recoverForm.classList.remove("none");
  });

});
