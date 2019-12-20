'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var btnGetMovementHistory = $$.getElementById('tryBuscar');

	//core
	btnGetMovementHistory.addEventListener('click', (e) => {
		e.preventDefault();

		var data = {
			fechaInicial: '01/01/2019',
			fechaFinal: '01/12/2019'
		};

		callNovoCore('POST', 'ExpenseReport', 'getExpenses', data, function(response) {

			if (response.code === 0){
				console.log(response.data);
			} else {
				notiSystem(response.title, response.msg, response.classIconName, response.data);
			}
		});
	});

	//functions
})

