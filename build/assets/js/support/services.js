'use strict'
var reportsResults;
var options = $(".nav-item-config").toArray();
var radios = $('input[type=radio][name="recovery"]').toArray();
var i;
var modalReq = {};

$(function () {
	$('.pre-loader').remove();
	$('.hide-out').removeClass('hide');

	switch (client) {
		case 'banco-bog':
		case 'pichincha':
		case 'novo':
		case 'banorte':
			$('#cardLock').addClass('active');
			$('#cardLockView').show();
			break;
	}
	/* $('#resultsAccount').DataTable({
		"ordering": false,
		"responsive": true,
		"pagingType": "full_numbers",
		"language": dataTableLang
	});

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

	for (i = 0; i < radios.length; i++) {
		radios[i].addEventListener('change', function (e) {
			if (this.id == 'generate-pin') {
				$("#pinRequestOTP").addClass('none');
				$("#current-pin-field").addClass('none');
				$("#changeCurrentPin").attr("disabled", true);
			} else {
				$("#pinRequestOTP").addClass('none');
				$("#changeCurrentPin").attr("disabled", false);
				$("#current-pin-field").removeClass('none');
			}
			if (this.id == 'pin-request') {
				$("#sectionPin").addClass('none');
				$("#pinRequestOTP").removeClass('none');
			} else {
				$("#sectionPin").removeClass('none');
			}
		});
	}*/

});
