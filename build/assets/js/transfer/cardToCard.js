"use strict";
$(function () {
	var liOptions = $(".nav-item-config");
	var operationType = "P2T";

	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

	$('#system-info').on('click', '.dashboard-item', function (e) {
		$('#manageAffiliations').removeClass('active');
		$('#manageAffiliationsView').css('display', 'none');
		$('#toTransferView').show();
		$('#toTransfer').addClass('active');
	});

	$.each(liOptions, function (pos, liOption) {
		$("#" + liOption.id).on("click", function (e) {
			var liOptionId = e.currentTarget.id;
			$(liOptions).removeClass("active");
			$(this).addClass("active");
			$(".transfer-operation").hide();
			$("#manageAffiliateView").hide();
			$("#" + liOptionId + "View").fadeIn(700, "linear");
		});
	});

	$("#system-info").on("click", ".dashboard-item", function (e) {
		e.preventDefault();
		form = $("#operation");
		data = getDataForm(form);
		who = "Business";
		where = "GetBalance";
		$(".cover-spin").show(0);
		$(".nav-config-box").removeClass("no-pointer");
		$("#currentBalance").text(lang.GEN_WAIT_BALANCE);
		$("#avaibleBalance").text(lang.TRANSF_AVAILABLE_BALANCE);

		callNovoCore(who, where, data, function (response) {
			$(".cover-spin").hide();
			if (response.code == 0) {
				$("#currentBalance").text(response.msg);
			} else {
				$("#currentBalance").text("---");
			}
		});
	});

	$("#editAffiliate, #newAffiliate").on("click", function (e) {
		var bankField = $("#manageAffiliateView #bank");
		var currentBank = bankField.val()
			? bankField.val()
			: "";
		$("#manageAffiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");

		bankField.prop("disabled", true);
		bankField.find("option").get(0).remove();
		bankField.append(
			`<option value="" selected disabled>${lang.TRANSF_WAITING_BANKS}</option>`
		);

		who = "transfer";
		where = "getBanks";

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
	});

	$("#affiliateCancelBtn").on("click", function (e) {
		e.preventDefault();
		$("#manageAffiliateView").hide();
		$("#manageAffiliationsView").fadeIn(700, "linear");
	});

	$("#manageAffiliateBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#manageAffiliate");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			who = "transfer";
			where = "affiliate";
			data = getDataForm(form);
			data.operationType = operationType;

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

	$("#transferBtn").on("click", function (e) {
		e.preventDefault();
		form = $("#transferForm");
		btnText = $(this).text().trim();
		validateForms(form);

		if (form.valid()) {
			who = "transfer";
			where = "transfer";
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
});
