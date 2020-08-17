'use strict'
$(function () {
	$('#pre-loader').remove();
	$('.hide-out').removeClass('hide');
	who = 'User'

	$('#nickName').on('blur', function() {
		$(this).addClass('available')
		form = $('#signUpForm');
		validateForms(form)
		if ($(this).valid()) {
			where = 'ValidNickName'
			data = {
				nickName: $(this).val().trim()
			}
			$(this).prop('disabled', true)
			getResponseServ(where)
		} else {
			$(this).focus()
		}
	})

	$('#newPass').on('keyup focus', function () {
		var pswd = $(this).val();
		passStrength(pswd);
	})

	$('#birthDate').datepicker({
		yearRange: '-80:' + currentDate.getFullYear(),
		maxDate: "-18y",
		changeMonth: true,
		changeYear: true
	})

	$('#signUpbTN').on('click', function(e) {
		e.preventDefault()
		form = $('#signUpForm');
		formInputTrim(form)
		validateForms(form)

		if (form.valid()) {
			btnText = $(this).text().trim()
			data = getDataForm(form);
			delete data.genderMale
			delete data.genderFemale
			data.gender = $('input[name=gender]:checked', '#signUpForm').val()
			data.newPass = cryptoPass(data.newPass);
			data.confirmPass = cryptoPass(data.confirmPass);
			$(this).html(loader)
			insertFormInput(true)
			where = 'SignUpData'
			getResponseServ(where)
		}
	})

	$('#imageUpload').change(function () {
    $('#imagePreviewContainer').hide();
    $('#imagePreviewContainer').css("height", "0")
    $('#imagePreviewContainer').fadeIn(650);
  });

	// Funtion drag and drop
	document.querySelectorAll(".drop-zone-input").forEach((inputElement) => {
		const dropZoneElement = inputElement.closest(".drop-zone");

		dropZoneElement.addEventListener("click", (e) => {
			inputElement.click();
		});

		inputElement.addEventListener("change", (e) => {
			if (inputElement.files.length) {
				updateThumbnail(dropZoneElement, inputElement.files[0]);
			}
		});

		dropZoneElement.addEventListener("dragover", (e) => {
			e.preventDefault();
			dropZoneElement.classList.add("drop-zone-over");
		});

		["dragleave", "dragend"].forEach((type) => {
			dropZoneElement.addEventListener(type, (e) => {
				dropZoneElement.classList.remove("drop-zone-over");
			});
		});

		dropZoneElement.addEventListener("drop", (e) => {
			e.preventDefault();

			if (e.dataTransfer.files.length) {
				inputElement.files = e.dataTransfer.files;
				updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
			}

			dropZoneElement.classList.remove("drop-zone-over");
		});
	});

	/**
	 * Updates the thumbnail on a drop zone element.
	 *
	 * @param {HTMLElement} dropZoneElement
	 * @param {File} file
	 */
	function updateThumbnail(dropZoneElement, file) {
		let thumbnailElement = dropZoneElement.querySelector(".drop-zone-thumb");

		// First time - remove the prompt
		if (dropZoneElement.querySelector(".drop-zone-prompt")) {
			dropZoneElement.querySelector(".drop-zone-prompt").remove();
		}

		// First time - there is no thumbnail element, so lets create it
		if (!thumbnailElement) {
			thumbnailElement = document.createElement("div");
			thumbnailElement.classList.add("drop-zone-thumb");
			dropZoneElement.appendChild(thumbnailElement);
		}

		thumbnailElement.dataset.label = file.name;

		// Show thumbnail for image files
		if (file.type.startsWith("image/")) {
			const reader = new FileReader();

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
			$('#signUpbTN').html(btnText)
			insertFormInput(false)
		}
	})
}
