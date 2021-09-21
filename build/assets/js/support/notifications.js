'use strict'
var options = document.querySelectorAll(".nav-item-config");

$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');


	$.each($('.nav-item-config'), function (pos, liOption) {
		$('#' + liOption.id).on('click', function (e) {
			var liOptionId = e.currentTarget.id;
			$('.nav-item-config').removeClass('active');
			$('div[option-service]').hide();
			$(this).addClass('active');
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');
		});
	});


	/* $.each(options, function(key, val) {
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
	}); */
});
