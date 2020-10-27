'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
		//vars
		var products = $$.querySelectorAll('.dashboard-item');

		//core
		for (var i = 0; i < products.length; i++) {
			products[i].addEventListener('click',function(e){
				var formElement = $$.getElementById("frmProduct-"+e.currentTarget.id);
				formElement.submit();
			});
		}
		//functions
});


