'use strict'
var reportsResults;
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
});

$('#phoneType').change(function() {
  var selectedOption = $(this).children('option:selected').val();
  var disableInput = false;

  if (selectedOption == '') {
    $('#otherPhoneNum').val('');
    disableInput = true;
	}

  $('#otherPhoneNum').prop('disabled', disableInput);
});
