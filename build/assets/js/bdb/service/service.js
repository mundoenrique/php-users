var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){

  //vars
  var lockOption = $$.getElementById('lock');
  var replaceOption = $$.getElementById('replace');
  var keyOption = $$.getElementById('key');
  var recoverOption = $$.getElementById('recover');

  var lockForm = $$.getElementById('lockAcount');
  var keyForm = $$.getElementById('changeKey');
  var recoverForm = $$.getElementById('recKey');

  //core
	lockOption.addEventListener('click',function(e){
    lockForm.classList.remove("none");
    keyForm.classList.add("none");
    recoverForm.classList.add("none");
  });

	replaceOption.addEventListener('click',function(e){
    lockForm.classList.remove("none");
    keyForm.classList.add("none");
    recoverForm.classList.add("none");
  });

	keyOption.addEventListener('click',function(e){
    keyForm.classList.remove("none");
    lockForm.classList.add("none");
    recoverForm.classList.add("none");
  });

	recoverOption.addEventListener('click',function(e){
    recoverForm.classList.remove("none");
    lockForm.classList.add("none");
    keyForm.classList.add("none");
  });

});
