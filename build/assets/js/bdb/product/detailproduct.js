'use strict';
var $ = document;

$.addEventListener('DOMContentLoaded', function(){
		//vars
		var listTransaccion = JSON.parse(pendingTransactions);

		//core
		for (var i = 0; i < products.length; i++) {
			products[i].addEventListener('click',function(e){
				var formElement = $$.getElementById("frmProducto");
				$$.getElementById("nroTarjeta").value = this.id;
				formElement.submit();
			});
		}
		//functions
});


