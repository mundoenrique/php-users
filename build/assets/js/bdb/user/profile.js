'use strict';
var $$ = document;

$$.addEventListener('DOMContentLoaded', function(){
	//vars
	var maxBirthdayDate = new Date();
  maxBirthdayDate.setFullYear( maxBirthdayDate.getFullYear() - 18);

	//core
	$( "#birthDate" ).datepicker( {
		maxDate: maxBirthdayDate,
    yearRange: "-99:"+maxBirthdayDate,
		defaultDate: "-30y"
  });

})
