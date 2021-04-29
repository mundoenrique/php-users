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

		appMessages(lang.USER_TERMS_TITLE, inputModal, lang.CONF_ICON_INFO, modalBtn);
		$(this).off('click');
	});

	$('#protection').on('click', function() {
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
		var inputModal = '<h1 class="h0">' + lang.USER_CONT_PROTECTION_SUBTITLE+'</h1>';
		inputModal += lang.USER_CONT_PROTECTION_CONTENT;

		appMessages(lang.USER_CONT_PROTECTION_TITLE, inputModal, lang.CONF_ICON_INFO, modalBtn);
		$(this).off('click');
	});

	$('#contract').on('click', function() {
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
		var inputModal = '<h1 class="h0">' + lang.USER_CONT_BENEFITS_SUBTITLE+'</h1>';

		switch ($('#generalAccount').val()) {
			case 'S':
				inputModal += lang.USER_CONT_GENERAL_CONTENT;
			break;
			default:
				inputModal += lang.USER_CONT_BENEFITS_CONTENT;
		}

		appMessages(lang.USER_CONT_BENEFITS_TITLE, inputModal, lang.CONF_ICON_INFO, modalBtn);
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

		$(inputElement).on("change", function(e, validIgnore){
			if (inputElement.files.length) {
				updateThumbnail(dropZoneElement, inputElement.files[0], inputElement);
				validateForms(formFile);

				if ($(inputElement).valid()) {
					$('.drop-zone-input').each(function (index, element) {
						$(element).parent('.drop-zone').removeClass('has-error-file');
					});
				} else {
					$('.drop-zone-input').each(function (index, element) {
						if ($(element).hasClass('has-error')) {
							$(element).parent('.drop-zone').addClass('has-error-file');
						}
					});
				}
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
});

function updateThumbnail(dropZoneElement, file, validIgnore) {
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

		if (validIgnore.classList.contains('ignore')) {
			validIgnore.classList.remove('ignore');
		}
	} else {
		thumbnailElement.style.backgroundImage = null;
	}
}

// ACTIVA BARRA E INDICE DE FIELSETS ACTUAL EN MULTISTEP
function moveTo(msContainer, index) {
	if (animating > 0) {
		return;
	}
	let steps = msContainer.find('div.progress-container').find(`div.progress-bar`).length + 1;
	if (index > steps) {
		return;
	}
	let currFs = msContainer.find(`fieldset.active`);
	let currIndex = currFs.data('index');
	if (currIndex == index) {
		return;
	}
	let next = msContainer.find(`fieldset[data-index=${index}]`);
	let formContainer = msContainer.find('.form-container');
	let stagger = 300;
	animating++;
	formContainer.animate({
		opacity: 0.0,
	}, {
		step: function (now, fx) {
			let scaleAmount = 1 - ((1 - now) * ((1 - 0.9) / (1 - 0.0)));
			$(this).css('transform', 'scale(' + scaleAmount + ')');
		},
		duration: 350,
		easing: 'easeInSine',
		complete: function () {
			currFs.removeClass('active');
			currFs.css({
				'display': 'none'
			});
			next.addClass('active');
			next.css({
				'display': 'block'
			});
			formContainer.animate({
				opacity: 1,
			}, {
				step: function (now, fx) {
					let scaleAmount = 1 - ((1 - now) * ((0.9 - 1) / (0 - 1)));
					$(this).css('transform', 'scale(' + scaleAmount + ')');
				},
				duration: 350,
				easing: 'easeInSine',
				complete: function () {
					animating--;
				}
			})
		}
	});
	if (currIndex > index) {
		for (let i = currIndex; i >= index; i--) {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${i}]`);
			if (i === index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					if (i === steps - 1) {
						thisProgress.find('.progress-icon').first().addClass('active');
					} else {
						thisProgress.find('.progress-icon').addClass('active');
					}
					animating--;
				}, (currIndex - i - 1) * stagger);
			} else {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					animating--;
				}, (currIndex - i - 1) * stagger);
			}
		}
	} else {
		for (let i = currIndex; i <= index; i++) {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${i}]`);
			if (i < index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '100%'
					});
					thisProgress.find('.progress-icon').addClass('active');
					animating--;
				}, (i - currIndex) * stagger);
			} else if (i === index) {
				animating++;
				setTimeout(function () {
					thisProgress.css({
						'width': '0%'
					});
					thisProgress.find('.progress-icon').removeClass('active');
					if (i === steps - 1) {
						thisProgress.find('.progress-icon').first().addClass('active');
					} else {
						thisProgress.find('.progress-icon').addClass('active');
					}
					animating--;
				}, (i - currIndex - 1) * stagger);
			}
		}
	}
	if (index === steps) {
		animating++;
		setTimeout(function () {
			let thisProgress = msContainer.find('div.progress-container').find(`div.progress-bar[data-index=${index - 1}]`);
			thisProgress.find('.progress-icon').last().addClass('active');
			animating--;
		}, (steps - currIndex - 1) * stagger);
	}
}

// OBTIENE INDICES DE FIELSETS CON ERROR EN MULTISTEP
function getErrorIndexes() {
	var errorElements;
	var indexes = [];
	errorElements = formFile.find('.has-error');
	errorElements.each(function () {
		if (!indexes.includes($(this).closest('fieldset').data('index'))) {
			indexes.push($(this).closest('fieldset').data('index'));
		}
	})

	return indexes;
}

// ESTABLECE COLOR AL TEXTO CON ERROR EN TITULOS EN MULTISTEP
function setTextClass(indexes) {
	var progressIcons = $('div.progress-icon');
	progressIcons.each(function () {
		if (indexes.includes($(this).data('index'))) {
			$(this).find('.progress-text').addClass('danger');
		} else {
			$(this).find('.progress-text').removeClass('danger');
		}
	})
}
