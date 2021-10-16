'use strict'
$(function () {
	$('#pre-loader').addClass('hide');
	$('.hide-out').removeClass('hide');

	if (code == 3) {
		$('#btn-notifications').prop('disabled', true);
		$('input[type="checkbox"]').prop('disabled', true);
	}

	$('.nav-item-config').on('click', function(e) {
		if ($(this).attr('render') == 'on') {
			$('.nav-item-config').attr('render', 'on');
			$('.nav-item-config').removeClass('active');
			$('.nav-item-config > a').removeClass('not-pointer');
			$('div[option-service]').hide();
			$(this).addClass('active');
			$(this).find('a').addClass('not-pointer');
			var liOptionId = e.currentTarget.id;
			$('#' + liOptionId + 'View').fadeIn(700, 'linear');

			switch (liOptionId) {
				case 'notifications':
					notifications();
				break;
				case 'notificationHistory':
					notificationHistory(false);
				break;
			}

			$(this).attr('render', 'off');
		}
	});

	$('.datepicker').datepicker({
		onSelect: function (selectedDate) {
			$(this)
				.focus()
				.blur();
			var dateSelected = selectedDate.split('/');
			dateSelected = dateSelected[1] + '/' + dateSelected[0] + '/' + dateSelected[2];
			dateSelected = new Date(dateSelected);
			var inputDate = $(this).attr('id');

			if (inputDate == 'initDate') {
				$('#finalDate').datepicker('option', 'minDate', dateSelected);
				var maxTime = new Date(dateSelected.getFullYear(), dateSelected.getMonth() + 3, dateSelected.getDate() - 1);

				if (currentDate > maxTime) {
					$('#finalDate').datepicker('option', 'maxDate', maxTime);
				} else {
					$('#finalDate').datepicker('option', 'maxDate', currentDate);
				}
			}
		}
	});

	$('#btn-notifications').on('click', function(e) {
		e.preventDefault();

		$('input[type="checkbox"]').each(function(index, element) {
			$(element).is(':checked') ? $(this).val('1') : $(this).val('0');
		});

		form = $('#form-notifications');
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			$(this).html(loader);
			who = 'customerSupport';
			where = 'notificationsUpdate';
			data = getDataForm(form);
			insertFormInput(true);

			callNovoCore(who, where, data, function(response) {
				$('#btn-notifications').html(btnText);
				insertFormInput(false);
			});
		}
	});

	$('#btn-noti-history').on('click', function(e) {
		e.preventDefault();
		form = $('#form-noti-history');
		btnText = $(this).html();
		validateForms(form);

		if (form.valid()) {
			$(this).html(loader);
			var dataHistory = getDataForm(form);
			dataHistory.notificationText = $('#notificationType option:selected').text()
			insertFormInput(true);
			notificationHistory(dataHistory);
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
			case 3:
				appMessages(response.title, response.msg, response.icon, response.modalBtn);
			break;
		}

		$('#pre-loader').addClass('hide');
		$('.hide-out').removeClass('hide');
	});
}

function notificationHistory(dataHistory) {
	$('.easyPaginateNav').remove();
	$('#loader-history').removeClass('hide');
	$('.history-out').addClass('hide');
	$('#no-notifications').addClass('hide');
	$('#notifications-history li').not('.thead').remove();

	if (!dataHistory) {
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		var dataHistory = {
			initDate: '01/' + (month < 10 ? '0' : '') + month + '/' + year,
			finalDate: (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year,
			notificationType: '00',
			notificationText: lang.CUST_SELECT_ALL
		}
	}

	who = 'customerSupport';
	where = 'notificationHistory';
	data = dataHistory;

	callNovoCore(who, where, data, function (response) {
		switch (response.code) {
			case 0:
				$('#noti-type').text(dataHistory.notificationText);
				$('#noti-from').text(dataHistory.initDate);
				$('#noti-to').text(dataHistory.finalDate);
				var notification;
				$.each(response.data, function(index, notifications) {
					notification = '<li class="feed-item flex items-center">';
					notification+= 		'<div class="flex px-2 py-2 flex-column col-6 feed-date">';
					notification+= 			'<span class="h5">' + notifications.description + '</span>';
					notification+=	 	'</div>';
					notification+=	 	'<div class="flex px-2 py-2 flex-column col-6">';
					notification+=		 	'<span class="h5">' + notifications.date + '</span></span>';
					notification+=	 	'</div>';
					notification+= '</li>';
					$('#item-history').append(notification)
				});

				if ($('#item-history > li').length > 5) {
					$('#item-history').easyPaginate({
						paginateElement: 'li',
						hashPage: lang.GEN_DATATABLE_PAGE,
						elementsPerPage: 5,
						effect: 'default',
						slideOffset: 200,
						firstButton: true,
						firstButtonText: lang.GEN_DATATABLE_SFIRST,
						firstHashText: lang.GEN_DATATABLE_PAGE_FIRST,
						lastButton: true,
						lastButtonText: lang.GEN_DATATABLE_SLAST,
						lastHashText: lang.GEN_DATATABLE_PAGE_LAST,
						prevButton: true,
						prevButtonText: '<',
						prevHashText: lang.GEN_PICKER_PREVTEXT,
						nextButton: true,
						nextButtonText: '>',
						nextHashText: lang.GEN_PICKER_NEXTTEXT
					})
				}
			break;
		}

		if (dataHistory) {
			$('#btn-noti-history').html(btnText);
		}

		$('#form-noti-history')[0].reset();
		insertFormInput(false);
		$('#loader-history').addClass('hide');
		response.data.length == 0 ? $('#no-notifications').removeClass('hide') : $('.history-out').removeClass('hide');
	});
}
