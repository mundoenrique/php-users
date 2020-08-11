'use strict'
var reportsResults;
var options = document.querySelectorAll(".nav-item-config");

$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

	/* $('#resultsAccount').DataTable({
		"ordering": false,
		"responsive": true,
		"pagingType": "full_numbers",
		"language": dataTableLang
	}); */

	//core
	$.each(options, function(key, val){
		$('#'+options[key].id+'View').hide();
		options[key].addEventListener('click', function(e) {
			var idName = this.id;
			$.each(options, function(key, val){
				options[key].classList.remove("active");
				$('#'+options[key].id+'View').hide();
			})
			this.classList.add("active");
			$('#'+idName+'View').fadeIn(700, 'linear');
		});
	});

	switch (client) {
		case 'banco-bog':
		case 'pichincha':
		case 'novo':
		case 'banorte':
			$('#notifications').addClass('active');
			$('#notificationsView').show();
			break;
	}
});
