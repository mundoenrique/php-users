"use strict";
$(function () {
	var liOptions = $(".nav-item-config");
	var operationType = "P2T";

	$("#pre-loader").remove();
	$(".hide-out").removeClass("hide");

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
		$("#manageAffiliationsView").hide();
		$("#manageAffiliateView").fadeIn(700, "linear");
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
