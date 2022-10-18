"use strict";
$(function () {
	var operationType = $("#transferView").attr("operation-type");
	var liOptions = $(".nav-item-config");
	var cardData;
	var affiliationsList = [];


	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

	// Si existe una sola tarjeta
	if ($("#productdetail").attr("call-balance") == "1") {
		getBalance();
	}

	$("#filterInputYear").datepicker({
		dateFormat: "mm/yy",
		showButtonPanel: true,
		closeText: lang.GEN_BTN_ACCEPT,

		onClose: function (dateText, inst) {
			$(this).datepicker(
				"setDate",
				new Date(inst.selectedYear, inst.selectedMonth, 1)
			);
			$(this).focus().blur();
			var monthYear = $("#filterInputYear").val().split("/");
			$("#filterMonth").val(monthYear[0]);
			$("#filterYear").val(monthYear[1]);
		},

		beforeShow: function (input, inst) {
			inst.dpDiv.addClass("ui-datepicker-month-year");
		},
	});

	// Al seleccionar una tarjeta
	$("#system-info").on("click", ".dashboard-item", function (e) {
		e.preventDefault();
		$(liOptions).removeClass("active");
		$("#affiliationsView").css("display", "none");
		$("#toTransferView").show();
		$("#toTransfer").addClass("active");
		getBalance();
	});

	// Mostrar vista correspondiente al seleccionar una operación
	// (Transferir|Adm. Afiliaciones|Historial)
	$(liOptions).on("click", function (e) {
		e.preventDefault();
		var liOptionId = e.currentTarget.id;
		$(liOptions).removeClass("active");
		$(this).addClass("active");
		$(".transfer-operation").hide();
		$("#manageAffiliateView").hide();
		$("#" + liOptionId + "View").fadeIn(700, "linear");
	});

	$("#affiliations").on("click", function (e) {
		e.preventDefault();
		who = "Transfer";
		where = "GetAffiliations";
		data = { operationType: operationType };

		callNovoCore(who, where, data, function (response) {
			// if (response.code == 0) {

			// } else {

			// }
			console.log(response);
		});
		// getAffiliations();
	});

	// Al hacer click en Nueva afiliación
	$("#newAffiliate").on("click", (e) => showManageAffiliateView("new"));

	// Al hacer click en Editar afiliación
	$("#affiliationTable tbody tr").on(
		"click",
		"button[data-action='edit']",
		(e) => showManageAffiliateView("edit")
	);

	$("#affiliateCancelBtn").on("click", function (e) {
		e.preventDefault();
		$("#manageAffiliateView").hide();
		$("#affiliationsView").fadeIn(700, "linear");
	});

	// Submit en formulario de Afiliación
	$("#manageAffiliateBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#manageAffiliate");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			who = "Transfer";
			where = "Affiliate";
			data = getDataForm(form);
			data.operationType = operationType;
			Object.assign(data, cardData);

			insertFormInput(true);
			$(this).html(loader);
			$(".nav-config-box").addClass("no-pointer");

			callNovoCore(who, where, data, function (response) {
				insertFormInput(false);
				$(e.target).html(btnText);
				$(".nav-config-box").removeClass("no-pointer");

				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			});
		}
	});

	// Submit en formulario de Transferencia
	$("#transferBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#transferForm");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			who = "Transfer";
			where = "Transfer";
			data = getDataForm(form);
			data.operationType = operationType;
			data.currentOperKey = cryptoPass(data.currentOperKey);

			insertFormInput(true);
			$(this).html(loader);
			$(".nav-config-box").addClass("no-pointer");

			callNovoCore(who, where, data, function (response) {
				insertFormInput(false);
				$(e.target).html(btnText);
				$(".nav-config-box").removeClass("no-pointer");

				if (response.code == 0) {
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
				}
			});
		}
	});

	// Funcionalidad del selector/buscador
	$("body").on("focus", ".select-search-input", function () {
		var search = $(this).val().trim();
		$(this).val(search || "");
		var selector = $(this).next(".select-search");
		selector.css("display", "block");
		$(this)
			.closest(".select-by-search")
			.find(".close-selector")
			.css("display", "block");
	});

	$("body").on("input", ".select-search-input", function () {
		var selector = $(this).next(".select-search");
		var search = $(this).val().trim().toLowerCase();
		selector.find("li").addClass("hidden");
		var matches = selector.find('li:contains("' + search + '")');
		selector.find(".no-results").remove();
		if (matches.length == 0) {
			selector.append(
				'<li class="no-results">' + lang.GEN_NO_RESULTS + "</li>"
			);
		}
		matches.removeClass("hidden");
	});

	$("body").on("click", ".select-search>*:not(.no-results)", function () {
		var value = $(this).attr("value"),
			text = $(this).text().trim(),
			container = $(this).closest(".select-by-search");
		container.find("input.select-search-input").val(text);
		container.find("li").removeClass("active");
		$(this).addClass("active").prependTo(container.find(".select-search"));
		container.find(".select-search").css("display", "none");
		$(".close-selector").css("display", "none");
		container.find("#directory").val(value);
	});

	$("body").on("click", ".close-selector", function () {
		$(".select-search").css("display", "none");
		$(this).css("display", "none");
	});

	function getAffiliations() {
		who = "Transfer";
		where = "GetAffiliations";
		data = { operationType: operationType };

		callNovoCore(who, where, data, function (response) {
			console.log(response);
		});
	}

	function getBalance() {
		form = $("#operation");
		data = cardData = getDataForm(form);
		who = "Business";
		where = "GetBalance";
		$(".nav-config-box").removeClass("no-pointer");
		$("#currentBalance").text(lang.GEN_WAIT_BALANCE);
		$("#avaibleBalance").text(lang.TRANSF_AVAILABLE_BALANCE);

		callNovoCore(who, where, data, function (response) {
			$("#currentBalance").text(response.msg);
		});
	}

	function showManageAffiliateView(action) {
		var bankField = $("#manageAffiliateView #bank");
		var currentBank = bankField.val() ? bankField.val() : "";
		$("#affiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
		$("#affiliateTitle").text(
			action == "new" ? lang.TRANSF_NEW_AFFILIATE : lang.TRANSF_EDIT_AFFILIATE
		);

		switch (operationType) {
			case "P2P":
				$("#affiliateMessage").text(
					action == "new"
						? lang.TRANSF_NEW_AFFILIATE_CARD_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "P2T":
				$("#affiliateMessage").text(
					action == "new"
						? lang.TRANSF_NEW_AFFILIATE_BANK_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "PMV":
				$("#affiliateMessage").text(
					action == "new"
						? lang.TRANSF_NEW_AFFILIATE_PAY_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
		}

		bankField.prop("disabled", true);
		bankField.find("option").get(0).remove();
		bankField.append(
			`<option value="" selected disabled>${lang.TRANSF_WAITING_BANKS}</option>`
		);

		who = "Transfer";
		where = "GetBanks";

		callNovoCore(who, where, {}, function (response) {
			if (response.code == 0) {
				var selected;
				$.each(response.data, function (pos, bank) {
					selected = currentBank == bank.codBcv;
					bankField.append(
						`<option value="${bank.codBcv}"${selected ? " selected" : ""}>${
							bank.nomBanco
						}</option>`
					);
				});

				bankField.find("option").get(0).remove();

				if (currentBank == "") {
					bankField.prepend(
						`<option value="" selected disabled>${lang.GEN_SELECTION}</option>`
					);
				}
			}

			bankField.prop("disabled", false);
		});
	}
});
