'use strict'
$(function () {
	$('#pre-loader').addClass('hide');
	$('.hide-out').removeClass('hide');

	$('.nav-item-config').on('click', function(event) {
		if ($(this).attr('render') == 'on') {
			$('.nav-item-config').attr('render', 'on');
			$('.nav-item-config').removeClass('active');
			$('.nav-item-config > a').removeClass('not-pointer');
			$('div[option-service]').hide();
			$(this).addClass('active');
			$(this).find('a').addClass('not-pointer');
			var liOptionId = event.currentTarget.id;
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');

			switch (liOptionId) {
				case 'notifications':
					notifications();
				break;
				case 'notificationHistory':
					notificationHistory();
				break;
			}

			$(this).attr('render', 'off');
		}
	});
});

function notifications() {
	$('#pre-loader').removeClass('hide');
	$('.hide-out').addClass('hide');
	who = 'customerSupport';
	where = 'notifications';
	data = {};

	callNovoCore(who, where, data, function (response) {

		switch (response.code) {
			case 0:
				$('input[type="checkbox"]').prop('checked', false);
				$('input[type="checkbox"]').removeAttr('checked');
				$.each(response.data, function(key, value) {
					if (value.active == '1') {
						$('#' + key).prop('checked', true);
					}
				});
			break;
		}

		$('#pre-loader').addClass('hide');
		$('.hide-out').removeClass('hide');
	});
}

function notificationHistory() {
	$('#loader-history').removeClass('hide');
	$('.history-out').addClass('hide');
	who = 'customerSupport';
	where = 'notifications';
	data = {};

	/* callNovoCore(who, where, data, function (response) {

		$('#loader-history').addClass('hide');
		$('.history-out').removeClass('hide');
	}); */
}
