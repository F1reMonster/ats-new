$(document).ready(function () {
	var clipboard = new ClipboardJS(".copy-clipboard");

	clipboard.on("success", function (e) {
		e.clearSelection();
	});

	$.datepicker.regional["uk"] = {
		closeText: "Закрити",
		prevText: "&#x3c;",
		nextText: "&#x3e;",
		currentText: "Сьогодні",
		monthNames: [
			"Січень",
			"Лютий",
			"Березень",
			"Квітень",
			"Травень",
			"Червень",
			"Липень",
			"Серпень",
			"Вересень",
			"Жовтень",
			"Листопад",
			"Грудень",
		],
		monthNamesShort: [
			"Січ",
			"Лют",
			"Бер",
			"Кві",
			"Тра",
			"Чер",
			"Лип",
			"Сер",
			"Вер",
			"Жов",
			"Лис",
			"Гру",
		],
		dayNames: [
			"неділя",
			"понеділок",
			"вівторок",
			"середа",
			"четвер",
			"п’ятниця",
			"субота",
		],
		dayNamesShort: ["нед", "пнд", "вів", "срд", "чтв", "птн", "сбт"],
		dayNamesMin: ["Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"],
		weekHeader: "Не",
		dateFormat: "dd.mm.yy",
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: "",
	};
	$.datepicker.setDefaults($.datepicker.regional["uk"]);

	// edit
	$("#select_dslam").change(function () {
		console.log("change 1");
		$.post("select_port.php", { id: $("#select_dslam").val() }, function (res) {
			$("#port").html(res);
		});
	});

	// заміна порту
	$("#select_dslam_change").change(function () {
		console.log("change 2");
		$.post(
			"select_port.php",
			{ id: $("#select_dslam_change").val() },
			function (res) {
				$("#port_change").html(res);
			}
		);
	});

	// новий абонент
	$("#newSelectDslam").change(function () {
		console.log("change 3");
		$.post(
			"select_port.php",
			{ id: $("#newSelectDslam").val() },
			function (res) {
				$("#newAdslPort").html(res);
			}
		);
	});

	$("#newSelectGpon").change(function () {
		console.log("change gpon");
		$.post(
			"select_gpon_port.php",
			{ id: $("#newSelectGpon").val() },
			function (res) {
				$("#newGponPort").html(res);
			}
		);
	});

	$(function () {
		$('[data-tooltip="tooltip"]').tooltip();
	});

	$(function () {
		$(
			"#date1, #date2, #newDatePhoneConnection, #newDateInternetConnection"
		).datepicker({
			changeMonth: true,
			changeYear: true,
		});
	});

	// boostrap tooltip change
	$(".copy-clipboard").on("click", function (e) {
		let tooltipId;
		tooltipId = "#" + $(this).attr("aria-describedby");
		$(tooltipId).find(".tooltip-inner").text("скопійовано!");
	});

	$("#btnEditFormSubmit").click(function (e) {
		e.preventDefault();
		$("#editForm").submit();
	});



	// $("#general-edit").find("input").keypress(function (event) {
	// 	var keycode = event.keyCode ? event.keyCode : event.which;
	// 	if (keycode == "13") {
	// 		$("#editForm").submit();
	// 	}
		
	// });
	

	$("#btnNewClientFormSubmit").click(function (e) {
		e.preventDefault();
		$("#newClientForm").submit();
	});
});
