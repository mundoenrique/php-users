'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	who = 'User'

	$('#nickName').on('blur', function() {
		$(this).addClass('available');
		form = $('#signUpForm');
		validateForms(form)
		if ($(this).valid()) {
			where = 'ValidNickName'
			data = {
				nickName: $(this).val().trim()
			}
			$(this).prop('disabled', true);
			getResponseServ(where);
		} else {
			$(this).focus();
		}
	})

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	})

	$('#birthDate').datepicker({
		yearRange: '-90:' + currentDate.getFullYear(),
		maxDate: '-18y',
		changeMonth: true,
		changeYear: true,
		onSelect: function (selectedDate) {
			$(this).focus();
			$('#genderMale').focus();
		}
	})

	$('#signUpBtn').on('click', function(e) {
		e.preventDefault()
		form = $('#signUpForm');
		formInputTrim(form);
		validateForms(form);

		if (form.valid()) {
			btnText = $(this).text().trim();
			data = getDataForm(form);
			delete data.genderMale;
			delete data.genderFemale;
			data.gender = $('input[name=gender]:checked').val();
			data.newPass = cryptoPass(data.newPass);
			data.confirmPass = cryptoPass(data.confirmPass);
			$(this).html(loader);
			insertFormInput(true);
			where = 'SignUpData';
			getResponseServ(where);
		}
	})

	$('#imageUpload').change(function () {
    $('#imagePreviewContainer').hide();
    $('#imagePreviewContainer').css("height", "0")
    $('#imagePreviewContainer').fadeIn(650);
  });

	// Funtion drag and drop
	var zoneInput = $(".drop-zone-input");
	$.each (zoneInput, function(i, inputElement){
		var dropZoneElement = inputElement.closest(".drop-zone");

		$(dropZoneElement).on("click", function(e){
			inputElement.click();
		});

		$(inputElement).on("change", function(e){
			if (inputElement.files.length) {
				updateThumbnail(dropZoneElement, inputElement.files[0]);
			}
		});

		$('.drop-zone').on('dragover', function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).addClass('drop-zone-over');
		});

		$('.dropzone-wrapper').on('dragleave', function(e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).removeClass('drop-zone-over');
		});

		$(dropZoneElement).on("drop", function(e){
			e.preventDefault();
			if (e.originalEvent.dataTransfer.files.length) {
				inputElement.files = e.originalEvent.dataTransfer.files;
				updateThumbnail(dropZoneElement, e.originalEvent.dataTransfer.files[0]);
			}
			$(this).removeClass('drop-zone-over');
		});

	});

	function updateThumbnail(dropZoneElement, file) {
		var thumbnailElement = dropZoneElement.querySelector(".drop-zone-thumb");

		if (dropZoneElement.querySelector(".drop-zone-prompt")) {
			dropZoneElement.querySelector(".drop-zone-prompt").remove();
		}

		if (!thumbnailElement) {
			thumbnailElement = document.createElement("div");
			thumbnailElement.classList.add("drop-zone-thumb");
			dropZoneElement.appendChild(thumbnailElement);
		}

		thumbnailElement.dataset.label = file.name;

		if (file.type.startsWith("image/")) {
			var reader = new FileReader();

			reader.readAsDataURL(file);
			reader.onload = () => {
				thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
			};
		} else {
			thumbnailElement.style.backgroundImage = null;
		}
	}
})

function getResponseServ(currentaction) {
	callNovoCore(who, where, data, function(response) {
		if (currentaction == 'ValidNickName') {
			$('#nickName').prop('disabled', false)
			switch (response.code) {
				case 0:
					$('#nickName')
					.removeClass('has-error')
					.addClass('has-success available')
					.parent('.input-group').siblings('.help-block').text('');
				break;
				case 1:
					$('#nickName')
					.addClass('has-error')
					.removeClass('has-success available')
					.parent('.input-group').siblings('.help-block').text(response.msg);
				break;
			}
		}

		if (currentaction == 'SignUpData') {
			$('#signUpBtn').html(btnText)
			insertFormInput(false)
		}
	})
}
