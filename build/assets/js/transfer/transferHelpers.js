"use strict";
var cardData, affiliationsList, currentAffiliaton, bankList;

$(function () {
	var operationType = $("#transferView").attr("operation-type");
	var liOptions = $(".nav-item-config");

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
		$("#toTransfer").addClass("active no-pointer");
		$("#affiliationsView").css("display", "none");
		$("#toTransferView").show();
		getBalance();
	});

	// Mostrar vista correspondiente al seleccionar una operación
	// (Transferir|Adm. Afiliaciones|Historial)
	$(liOptions).on("click", function (e) {
		e.preventDefault();
		var liOptionId = e.currentTarget.id;
		$(liOptions).removeClass("active");
		$(cardData ? liOptions : "#affiliations").removeClass("no-pointer");
		$(this).addClass("active no-pointer");
		$(".transfer-operation").hide();
		$("#manageAffiliateView").hide();
		$("#" + liOptionId + "View").fadeIn(700, "linear");
	});

	// Carga tabla lista de afiliados
	$("#affiliations").on("click", function (e) {
		e.preventDefault();
		$("#transferRecord").hide();
		$("#searchAffiliate").hide();
		$("#no-moves").hide();
		$("#pre-loader").fadeIn(700, "linear");
		who = "Affiliations";
		where = "GetAffiliations";
		data = { operationType: operationType };

		callNovoCore(who, where, data, function (response) {
			$("#pre-loader").hide();
			switch (response.code) {
				case 0:
					setAffiliateDataTable(response.data);
					break;
				case 1:
					$("#no-moves").fadeIn(700, "linear");
					break;
				default:
					appMessages(
						response.title,
						response.msg,
						response.icon,
						response.modalBtn
					);
					break;
			}
		});
	});

	// Al hacer click en Nueva afiliación
	$("#newAffiliate").on("click", (e) => showManageAffiliateView("create"));

	// Al hacer click en Editar afiliación
	$("#affiliationTable tbody").on(
		"click",
		"button[data-action='edit']",
		function () {
			currentAffiliaton = affiliationsList[$(this).data("index")];
			showManageAffiliateView("edit");
		}
	);

	// Al hacer click en Eliminar afiliación
	$("#affiliationTable tbody").on(
		"click",
		"button[data-action='delete']",
		function () {
			currentAffiliaton = affiliationsList[$(this).data("index")];
			who = "Affiliations";
			where = "DeleteAffiliation";
			data.idAfiliation = currentAffiliaton.id_afiliacion;

			$(".nav-config-box").addClass("no-pointer");
			$("#pre-loader").fadeIn(700, "linear");

			callNovoCore(who, where, data, function (response) {
				$("#pre-loader").hide();
				$(".nav-config-box").removeClass("no-pointer");
				appMessages(
					response.title,
					response.msg,
					response.icon,
					response.modalBtn
				);
			});
		}
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
			who = "Affiliations";
			where = `Affiliation${operationType}`;
			data = getDataForm(form);

			if ($(this).data("action") == "edit") {
				data.idAfiliation = currentAffiliaton.id_afiliacion;
			}

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

	function getBanks(operation, action = "") {
		var bankField =
			operation == "affiliation"
				? $("#manageAffiliateView #bank")
				: $("#transferView #bank");

		var currentBank =
			action == "edit" && currentAffiliaton?.codBanco
				? currentAffiliaton?.codBanco
				: "";

		bankField.prop("disabled", true);
		bankField.find("option").remove();
		bankField.append(
			currentBank == ""
				? `<option value="" selected disabled>${lang.TRANSF_WAITING_BANKS}</option>`
				: `<option value="${currentBank}" selected disabled>${currentAffiliaton.banco}</option>`
		);

		who = "Transfer";
		where = "GetBanks";

		callNovoCore(who, where, {}, function (response) {
			if (response.code == 0) {
				$.each(response.data, function (pos, bank) {
					if (currentBank != bank.codBcv) {
						bankField.append(
							`<option value="${bank.codBcv}">${bank.nomBanco}</option>`
						);
					}
				});

				if (currentBank == "") {
					bankField.find("option").first().text(lang.GEN_SELECTION);
				} else {
					bankField.find("option").first().prop("disabled", false);
				}
			}

			bankField.prop("disabled", false);
		});
	}

	function setAffiliateDataTable(data) {
		var columns, row, tdOptions;
		affiliationsList = data;
		$("#affiliationTable tbody").html();

		switch (operationType) {
			case "P2P":
				columns = ["NombreCliente", "id_ext_per", "noTarjetaConMascara"];
				break;
			case "P2T":
				columns = ["beneficiario", "banco", "noCuenta"];
				break;
			case "PMV":
				columns = ["beneficiario", "banco", "telefono"];
				break;
		}

		data.forEach((value, index) => {
			row = $("<tr></tr>");
			columns.forEach((element) => {
				row.append(`<td>${value[element]}</td>`);
			});
			tdOptions = `<td class="py-0 px-1 flex justify-center items-center">
				<button class="btn mx-1 px-0" title="${lang.TRANSF_EDIT}" data-index="${index}" data-action="edit" data-toggle="tooltip">
					<i class="icon icon-edit" aria-hidden="true"></i>
				</button>
				<button class="btn mx-1 px-0 big-modal" title="${lang.TRANSF_DELETE}" data-index="1" data-action="delete" data-toggle="tooltip">
					<i class="icon icon-remove" aria-hidden="true"></i>
				</button>
			</td>`;
			row.append(tdOptions);
			$("#affiliationTable tbody").append(row);
		});

		$("#transferRecord").fadeIn(700, "linear");
		$("#searchAffiliate").fadeIn(700, "linear");
	}

	function showManageAffiliateView(action) {
		if (action == "create") {
			$("#manageAffiliate")[0].reset();
		}
		$("#affiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
		$("#manageAffiliateBtn")
			.text(action == "create" ? lang.TRANSF_AN_AFFILIATE : lang.GEN_BTN_SAVE)
			.data("action", action);
		$("#affiliateTitle").text(
			action == "create"
				? lang.TRANSF_NEW_AFFILIATE
				: lang.TRANSF_EDIT_AFFILIATE
		);

		switch (operationType) {
			case "P2P":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_CARD_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "P2T":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_BANK_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "PMV":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_PAY_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
		}

		if (action == "edit") {
			setFieldNames("affiliation");
		}

		if (operationType != "P2P") {
			getBanks("affiliation", action);
		}
	}

	function showTransferView() {
		if (action == "create") {
			$("#manageAffiliate")[0].reset();
		}
		$("#affiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
		$("#manageAffiliateBtn")
			.text(action == "create" ? lang.TRANSF_AN_AFFILIATE : lang.GEN_BTN_SAVE)
			.data("action", action);
		$("#affiliateTitle").text(
			action == "create"
				? lang.TRANSF_NEW_AFFILIATE
				: lang.TRANSF_EDIT_AFFILIATE
		);

		switch (operationType) {
			case "P2P":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_CARD_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "P2T":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_BANK_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
			case "PMV":
				$("#affiliateMessage").text(
					action == "create"
						? lang.TRANSF_NEW_AFFILIATE_PAY_MSG
						: lang.TRANSF_EDIT_AFFILIATE_MSG
				);
				break;
		}

		if (action == "edit") {
			setValues("transfer");
		}

		if (operationType != "P2P") {
			getBanks("transfer");
		}
	}

	function setValues(formID, objectValues) {
		Object.entries(objectValues).forEach(([fieldId, value]) => {
			$(`${formID} #${fieldId}`).val(value);
		});
	}

	function setFieldNames(operation) {
		var documentType, documentNumber, objectValues;

		if (operation == "affiliation") {
			if (currentAffiliaton.id_ext_per) {
				documentType = currentAffiliaton.id_ext_per.slice(0, 1);
				documentNumber = currentAffiliaton.id_ext_per.slice(1);
			}

			var setObjectValues = {
				P2P: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationCard: currentAffiliaton.nroCuentaDestino,
					beneficiaryEmail: currentAffiliaton.email,
				},
				P2T: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					destinationAccount: currentAffiliaton.noCuenta,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
				PMV: {
					beneficiary: currentAffiliaton.beneficiario,
					typeDocument: documentType,
					idNumber: documentNumber,
					mobilePhone: currentAffiliaton.telefono,
					beneficiaryEmail: currentAffiliaton.email,
				},
			};

			objectValues = setObjectValues[operationType];

			setValues("#manageAffiliateView", objectValues);
		}
	}
});
