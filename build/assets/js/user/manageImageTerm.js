'use strict'
$(function () {
	$('#acceptTerms').on('click', function() {
		modalBtn = {
			btn1: {
				text: lang.GEN_BTN_ACCEPT,
				action: 'destroy'
			},
			maxHeight: 600,
			width: 800,
			posMy: 'top',
			posAt: 'top'
		}
		var inputModal = '<h1 class="h0">'+lang.USER_TERMS_SUBTITLE+'</h1>';
		inputModal+= lang.USER_TERMS_CONTENT;

		appMessages(lang.USER_TERMS_TITLE, inputModal, lang.GEN_ICON_INFO, modalBtn);
		$(this).off('click');
	});

	// Funtion drag and drop
	$('#SEL_A').change(function () {
    $('#imagePreviewContainer').hide();
    $('#imagePreviewContainer').css("height", "0")
    $('#imagePreviewContainer').fadeIn(650);
  });

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
			thumbnailElement = document.createElement("img");
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

			if (thumbnailElement.classList.contains('ignore')) {
				thumbnailElement.classList.remove('ignore');
			}
		} else {
			thumbnailElement.style.backgroundImage = null;
		}
	}
});
