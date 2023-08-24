<div class="block block__search">

	<form class="search-form__form" action="index.php" method="GET" autocomplete="off">
		<div class="search-form__input">
			<input class="form-control" type="search" name="search" placeholder="Текст для пошуку" aria-label="Search" >
			<button class="btn btn-primary d-flex align-items-center search-btn" type="submit"><i class="fa-solid fa-magnifying-glass me-lg-1"></i><span>Пошук</span></button>
		</div>
		<div class="search-form__radio">
			<div class="search-form__radio-item">
				<input id="searchPhone" class="form-check-input" type="radio" name="what" value="0" checked>
				<label class="form-check-label" for="searchPhone">
					по телефону
				</label>
			</div>
			<div class="search-form__radio-item">
				<input id="searchClient" class="form-check-input" type="radio" name="what" value="1">
				<label class="form-check-label" for="searchClient">
					по клієнту
				</label>
			</div>
			<div class="search-form__radio-item">
				<input id="searchLocation" class="form-check-input" type="radio" name="what" value="2">
				<label class="form-check-label" for="searchLocation">
					по адресі
				</label>
			</div>
			<div class="search-form__radio-item">
				<input id="searchLineData" class="form-check-input" type="radio" name="what" value="3">
				<label class="form-check-label" for="searchLineData">
					по лінійних даних
				</label>
			</div>

		</div>

	</form>
</div>

<?php

$orderby = $_GET['orderby'];
$search = $_GET['search'];
$what = $_GET['what'];

$table_head = "
	<thead class=\"table__thead--primary\">
		<tr>
			<th class=\"table__thead-phone col-1\" scope=\"col\">№ ТЗ</th>
			<th class=\"table__thead-linedata col-2\" scope=\"col\">Лін.дані</th>
			<th class=\"table__thead-client col-5\" scope=\"col\">Абонент</th>
			<th class=\"table__thead-loacation col-4\" scope=\"col\">Адреса</th>
		</tr>
	</thead>";

$table_title = "Останні дії:";


if ($search) {

	switch ($what) {
		case 0:
			$search_type = "phone";
			$order = "phone";
			break;
		case 1:
			$search_type = "client";
			$order = "client COLLATE utf8_unicode_ci";
			break;
		case 2:
			$search_type = "street_name";
			$order = "street_name, nomer_doma, korpus, kv";
			break;
		case 3:
			$search_type = "line_data";
			$order = "line_data";
			break;
		default:
			$search_type = "phone";
			$order = "phone";
	}

	if ($search) {

		$query = mysqli_query($connect, "SELECT *, d.id as id_ats 
													FROM db_ats d
													LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
													LEFT JOIN street ON street.id = id_ul
													LEFT JOIN np ON np.id = id_np
													LEFT JOIN gpon ON gpon.id = d.id_gpon
													WHERE $search_type LIKE '%$search%'
													ORDER BY $order");

		$how_searched = mysqli_num_rows(mysqli_query($connect, " SELECT *, d.id as id_ats 
																					FROM db_ats d
																					LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
																					LEFT JOIN street ON street.id = id_ul
																					LEFT JOIN np ON np.id = id_np
																					LEFT JOIN gpon ON gpon.id = d.id_gpon
																					WHERE $search_type LIKE '%$search%'
																					ORDER BY $order"));

		if ($how_searched == 1) {
			$line = mysqli_fetch_assoc($query);
			print "<script type=\"text/javascript\">window.location = \"client.php?id=$line[id_ats]\"</script>";
		}

		if ($how_searched != 0) {
			$display_mess = "Пошуковий запит: <nobr style=\"color: red;\"><b>" . $search . "</b></nobr> • результатів: <nobr style=\"color: red;\"><b>" . $how_searched . "</b></nobr>";
			$table_head = "
				<thead class=\"table__thead--primary\">
					<tr>
						<th class=\"table__thead-phone col-1\" scope=\"col\">№ тел.</th>
						<th class=\"table__thead-linedata col-2\" scope=\"col\">Лін.дані</th>
						<th class=\"table__thead-client col-5\" scope=\"col\">Абонент</th>
						<th class=\"table__thead-loacation col-4\" scope=\"col\">Адреса</th>
					</tr>
				</thead>";
			$table_title ="";
		} else {
			$display_mess = "Пошуковий запит: <nobr style=\"color: red;\"><b>" . $search . "</b></nobr> • результатів: <nobr style=\"color: red;\"><b>" . $how_searched . "</b></nobr>";
			$display_mess2 = "На жаль, по Вашому запиту нічого не знайдено...";
			$table_head = "";
			$table_title ="";
		}
	} else {

		$query = mysqli_query($connect, "SELECT *, d.id as id_ats 
		FROM db_ats d
		LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
		WHERE id = 100000000");

		$how_searched = mysqli_num_rows(mysqli_query($connect, "SELECT *, d.id as id_ats 
		FROM db_ats d
		LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
		WHERE id = 100000000"));

		$display_mess = "Пошуковий запит: <nobr style=\"color: red;\"><b>" . $search . "</b></nobr> • результатів: <nobr style=\"color: red;\"><b>" . $how_searched . "</b></nobr>";
		$display_mess2 = "На жаль, по Вашому запиту нічого не знайдено...";
		$table_head = "";
		$table_title ="";
	}
}

if ($search) {
	print $display_mess . "<br>" . $display_mess2;
}

?>