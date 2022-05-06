<?php
require_once('config.php');
require_once('head.php');
$m = $_GET['m'];
$id_dslam = $_GET['adsl'];
$id_gpon = $_GET['gpon'];
$err_msg = "<div class=\"error__message error__message--with-icon\"><i class=\"icon-exclamation-sign\"></i> <span>Щось пішло не так...</span></div>";
?>


<div class="container">

	<?php

	if ($_COOKIE['group']) {

		require_once('header.php');
		require_once('search-form.php');

		// довідник адсл-плат
		if ($m == 2) {
			$q = mysqli_query($connect, "SELECT *, (nomer_dslam * 1) AS n_dslam FROM name_dslam ORDER BY n_dslam"); ?>

			<div class="block">
				<div class="d-flex align-content-center justify-content-between">
					<h3>Довідник ADSL плат</h3>
					<div class="d-flex align-items-center">
						<a href="" data-bs-toggle="modal" data-bs-target="#addAdslPlate">
							<div data-tooltip="tooltip" data-bs-placement="bottom" title="додати плату">
								<i class="fa-solid fa-square-plus fs-4"></i>
							</div>
						</a>

					</div>


				</div>
				<div class="client__head-row client__head-row--primary row">
					<div class="head-title head-title--primary col-sm-2">Id DSLAM</div>
					<div class="head-title head-title--primary col-sm-3">Пазва плати</div>
					<div class="head-title head-title--primary col-sm-2">IP-адреса</div>
					<div class="head-title head-title--primary col-sm-2">Зайнятих портів</div>
					<div class="head-title head-title--primary col-sm-3">Розміщення на КРОСЗі</div>
				</div>
				<?php
				while ($am = mysqli_fetch_assoc($q)) {
					$ports = mysqli_num_rows(mysqli_query($connect, "SELECT id_dslam FROM db_ats WHERE id_dslam = '$am[id]'"));
				?>


					<div class="row row-stripped py-2" style="cursor:pointer" onclick="javascript:document.location.href='info.php?m=3&adsl=<?= $am['id'] ?>'">
						<div class="col-sm-2 d-flex align-items-center"><?= $am["nomer_dslam"] ?></div>
						<div class="col-sm-3 d-flex align-items-center"><?= $am["name_dslam"] ?></div>
						<div class="col-sm-2 d-flex align-items-center"><?= $am["ip_dslam"] ?></div>
						<div class="col-sm-2 d-flex align-items-center"><?= $ports ?></div>
						<div class="col-sm-3 d-flex align-items-center"><?= $am["cross_name"] ?></a></div>
					</div>



				<?php } ?>


			</div>


			<?php
		}

		// адсл плата із абонентами
		if ($m == 3) {

			if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM name_dslam WHERE id=$id_dslam")) != 0 && $id_dslam) {
				mb_internal_encoding("UTF-8");
				$q1 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM name_dslam WHERE id=$id_dslam"));
				$ports = mysqli_num_rows(mysqli_query($connect, "SELECT id_dslam FROM db_ats WHERE id_dslam = '$id_dslam'"));

			?>
				<div class="block">
					<div class="d-flex algn-items-center justify-content-between">
						<h3>Плата: <?php echo $q1["name_dslam"] ?> / ip: <?php echo $q1["ip_dslam"] ?></h3>
						<div class="d-flex align-items-center">
							<a href="" data-bs-toggle="modal" data-bs-target="#edit-dslam" class="<?php if ($ports == 0) {
																																echo 'me-2';
																															} ?>">
								<div data-tooltip="tooltip" data-bs-placement="bottom" title="Редагувати">
									<i class="fa-solid fa-pen-to-square fs-4"></i>
								</div>
							</a>
							<?php

							if ($group_id == 1 && $ports == 0) {

							?>

								<a href="" data-bs-toggle="modal" data-bs-target="#delete-dslam">
									<div data-tooltip="tooltip" data-bs-placement="bottom" title="Видалити плату">
										<i class="fa-solid fa-circle-xmark fs-4 text-danger"></i>
									</div>

								</a>


							<?php
							}

							?>
						</div>


					</div>
					<div class="mb-2" style="font-size: 14px;"><?= $q1["notes"] ?></div>
					<div class="client__head-row client__head-row--primary row">
						<div class="head-title head-title--primary col-sm-1">Порт</div>
						<div class="head-title head-title--primary col-sm-2">Номер ТЗ</div>
						<div class="head-title head-title--primary col-sm-1">Лін.дані</div>
						<div class="head-title head-title--primary col-sm-4">Абонент</div>
						<div class="head-title head-title--primary col-sm-4">Адреса</div>
					</div>

					<?php

					for ($i = 1; $i <= $q1['total_ports']; $i++) {
						$q = mysqli_query($connect, "SELECT *, db_ats.id AS id_ats FROM db_ats 
													LEFT JOIN name_dslam ON id_dslam = name_dslam.id 
													LEFT JOIN street ON street.id = id_ul
													LEFT JOIN np ON np.id = id_np
													WHERE id_dslam='$id_dslam' AND port_number='$i'");

						$adsl = mysqli_fetch_assoc($q);

						if (mysqli_num_rows($q) == 1) {

					?>
							<div class="row row-stripped py-2" style="cursor:pointer" onclick="javascript:document.location.href='client.php?id=<?= $adsl['id_ats'] ?>'">
								<div class="col-sm-1 d-flex align-items-center"><?= $adsl["port_number"] ?></div>
								<div class="col-sm-2 d-flex align-items-center"><?= $adsl["phone"] ?></div>
								<div class="col-sm-1 d-flex align-items-center"><?= $adsl["line_data"] ?></div>
								<div class="col-sm-4 d-flex align-items-center"><?= $adsl["client"] ?></div>
								<div class="col-sm-4 d-flex align-items-center">
									<?php

									if ($adsl["np_name"]) {
										if ($adsl['street_name'] || $adsl['nomer_doma'] || $adsl['korpus'] || $adsl['kv']) {
											echo $adsl['np_name'] . ", ";
										} else {
											echo $adsl['np_name'];
										}
									}



									if ($adsl["street_name"]) {

										echo $adsl["street_name"];

										if ($adsl["nomer_doma"]) {

											echo " " . $adsl["nomer_doma"];
										}
										if ($adsl["korpus"]) {
											echo "/" . $adsl["korpus"];
										}
										if ($adsl["kv"]) {
											echo " КВ." . $adsl["kv"];
										}
									}
									?>
								</div>
							</div>

						<?php } else { ?>
							<div class="row row-stripped py-2 bg-teal-300" style="cursor:pointer;">
								<div class="col-sm-12">
									<?= $i ?>
								</div>
							</div>
					<?php }
					} ?>




				</div>

			<?php
			}
		}


		// виведення списку змін logversion
		if ($m == 4) {
			$q = mysqli_query($connect, "SELECT * FROM changelog ORDER BY `date` DESC");
			?>
			<div class="block">
				<div class="d-flex align-items-center justify-content-between">
					<h3>Історія версій</h3>
					<?php
					if ($group_id == 1) {
					?>

						<a href="" data-bs-toggle="modal" data-bs-target="#addChangeLog">
							<div data-tooltip="tooltip" data-bs-placement="bottom" title="Додати changelog">
								<i class="fa-solid fa-clock-rotate-left fs-4"></i>
							</div>

						</a>


					<?php
					} ?>
				</div>
				<div class="client__head-row client__head-row--primary row">
					<div class="head-title head-title--primary col-sm-2">Дата</div>
					<div class="head-title head-title--primary col-sm-2">Версія</div>
					<div class="head-title head-title--primary col-sm-8">Зміни</div>
				</div>

				<?php
				while ($r = mysqli_fetch_assoc($q)) { ?>
					<div class="row row-stripped py-2">
						<div class="col-sm-2"><?= date("d.m.Y", $r["date"]); ?></div>
						<div class="col-sm-2"><?= $r['version'] ?></div>
						<div class="col-sm-8"><?= $r['log'] ?></div>
					</div>

				<?php }
				?>

			</div>
		<?php	}

		// таблиця користувачів
		if ($m == 5 && $group_id == 1) {
			$query = mysqli_query($connect, "SELECT * FROM `users` ORDER BY `user_name`");
		?>
			<div class="block">
				<div class="d-flex align-content-center justify-content-between">
					<div class="d-flex align-items-center">
						<i class="fa-solid fa-users mb-2 me-2 fs-4 text-primary"></i>
						<h3>Довідник користувачів</h3>
					</div>
					<div class="d-flex align-items-center">
						<a href="" data-bs-toggle="modal" data-bs-target="#addNewUser">
							<div data-tooltip="tooltip" data-bs-placement="bottom" title="додати користувача">
								<i class="fa-solid fa-square-plus fs-4"></i>
							</div>
						</a>
					</div>
				</div>
				<div class="client__head-row client__head-row--primary row">
					<div class="head-title head-title--primary col-sm-1">№ з/п</div>
					<div class="head-title head-title--primary col-sm-2">П.І.Б.</div>
					<div class="head-title head-title--primary col-sm-2">Група</div>
					<div class="head-title head-title--primary col-sm-2">Посада</div>
					<div class="head-title head-title--primary col-sm-2">Логін</div>
					<div class="head-title head-title--primary col-sm-2">Дата реєстрації</div>
					<div class="head-title head-title--primary col-sm-1">Дії</div>
				</div>


				<?php
				$num = 0;
				while ($line = mysqli_fetch_assoc($query)) {
					$num++;
				?>
					<div class="row row-stripped py-2">
						<div class="col-sm-1 d-flex align-items-center"><?= $num ?></div>
						<div class="col-sm-2 d-flex align-items-center"><?= $line["user_name"] ?></div>
						<div class="col-sm-2 d-flex align-items-center">
							<?php
							switch ($line["group"]) {
								case 1:
									echo "<span class=\"text-danger\">Адміністратори</span>";
									break;
								case 2:
									echo "<span class=\"text-success\">Чергові зміни</span>";
									break;
								case 3:
									echo "<span class=\"text-primary\">Інженери</span>";
									break;
								case 4:
									echo "<span class=\"text-secondary\">Користувачі</span>";
									break;
								case 5:
									echo "<span class=\"text-warning\">ЦОА</span>";
									break;
							}
							?>
						</div>
						<div class="col-sm-2 d-flex align-items-center"><?= $line["position"] ?></div>
						<div class="col-sm-2 d-flex align-items-center"><?= $line["login"] ?></div>
						<div class="col-sm-2 d-flex align-items-center"><?php echo date('d.m.Y', $line["joindate"]);  ?></div>
						<div class="col-sm-1 d-flex align-items-center">

							<a data-bs-toggle="modal" data-bs-target="#edit-user" href="">
								<div data-tooltip="tooltip" data-bs-placement="bottom" title="Редагувати">
									<i class="fa-solid fa-pen-to-square fs-5 me-2"></i>
								</div>
							</a>

							<a data-bs-toggle="modal" data-bs-target="#delete-user" href="">
								<div data-tooltip="tooltip" data-bs-placement="bottom" title="Видалити">
									<i class="fa-solid fa-circle-xmark fs-5 text-danger"></i>
								</div>
							</a>

						</div>
					</div>
				<?php } ?>
			</div>
		<?php
		}

		// таблиця сплітерів
		if ($m == 6) {
			$q = mysqli_query($connect, "SELECT *, gpon.id AS g_id FROM gpon LEFT JOIN np ON np.id = id_gpon_np LEFT JOIN street ON street.id = id_gpon_street ORDER BY np_name, street_name, gpon_building_number")
		?>


			<div class="block">
				<div class="d-flex align-content-center justify-content-between">
					<h3>Довідник GPON-сплітерів</h3>
					<div class="d-flex align-items-center">
						<a href="" data-bs-toggle="modal" data-bs-target="#addGponLoc">
							<div data-tooltip="tooltip" data-bs-placement="bottom" title="додати сплітер">
								<i class="fa-solid fa-square-plus fs-4"></i>
							</div>
						</a>

					</div>


				</div>
				<div class="client__head-row client__head-row--primary row">
					<div class="head-title head-title--primary col-sm-3">Адреса локації</div>
					<div class="head-title head-title--primary col-sm-4">Локація</div>
					<div class="head-title head-title--primary col-sm-4">Сплітер</div>
					<div class="head-title head-title--primary col-sm-1">Портів</div>

				</div>
				<?php
				while ($am = mysqli_fetch_assoc($q)) {

					$ports = mysqli_num_rows(mysqli_query($connect, "SELECT id_gpon FROM db_ats WHERE id_gpon = '$am[g_id]'"));
				?>
					

					<div class="row row-stripped py-2" style="cursor:pointer" onclick="javascript:document.location.href='info.php?m=7&gpon=<?= $am['g_id'] ?>'">
						<div class="col-sm-3 d-flex align-items-center">
							<?php


							if ($am['gpon_building_korpus']) {
								echo $am["np_name"] . ", " . $am["street_name"] . ", б." . $am["gpon_building_number"] . "/" . $am["gpon_building_korpus"];
							} else {
								echo $am["np_name"] . ", " . $am["street_name"] . ", б." . $am["gpon_building_number"];
							}




							?></div>
						<div class="col-sm-4 d-flex align-items-center"><?= $am["gpon_location"] ?></div>
						<div class="col-sm-4 d-flex align-items-center"><?= $am["gpon_splitter"] ?></div>
						<div class="col-sm-1 d-flex align-items-center"><span data-tooltip="tooltip" data-bs-placement="bottom" title="зайнято / всього"><?= $ports . " / " . $am["gpon_slitter_ports"] ?></span></div>

					</div>



				<?php } ?>


			</div>


			<?php
		}

		if ($m == 7) {
			if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM gpon WHERE id=$id_gpon")) != 0 && $id_gpon) {
				mb_internal_encoding("UTF-8");
				$q1 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM gpon WHERE id=$id_gpon"));
				$ports = mysqli_num_rows(mysqli_query($connect, "SELECT id_gpon FROM db_ats WHERE id_gpon = '$id_gpon'"));

			?>
				<div class="block">
					<div class="d-flex algn-items-center justify-content-between">
						<h4>Локація: <?php echo $q1["gpon_location"] ?><br />сплітер: <?php echo $q1["gpon_splitter"] ?></h4>
						<div class="d-flex align-items-center">
							<a href="" data-bs-toggle="modal" data-bs-target="#edit-gpon" class="<?php if ($ports == 0) {
																															echo 'me-2';
																														} ?>">
								<div data-tooltip="tooltip" data-bs-placement="bottom" title="Редагувати">
									<i class="fa-solid fa-pen-to-square fs-4"></i>
								</div>
							</a>
							<?php

							if ($group_id == 1 && $ports == 0) {

							?>

								<a href="" data-bs-toggle="modal" data-bs-target="#delete-gpon">
									<div data-tooltip="tooltip" data-bs-placement="bottom" title="Видалити плату">
										<i class="fa-solid fa-circle-xmark fs-4 text-danger"></i>
									</div>

								</a>


							<?php
							}

							?>
						</div>


					</div>

					<div class="client__head-row client__head-row--primary row">
						<div class="head-title head-title--primary col-sm-1">Порт</div>
						<div class="head-title head-title--primary col-sm-3">Номер ТЗ</div>
						<div class="head-title head-title--primary col-sm-1">Лін.дані</div>
						<div class="head-title head-title--primary col-sm-3">Абонент</div>
						<div class="head-title head-title--primary col-sm-4">Адреса</div>
					</div>

					<?php

					for ($i = 1; $i <= $q1['gpon_slitter_ports']; $i++) {
						$q = mysqli_query($connect, "SELECT *, db_ats.id AS id_ats FROM db_ats 
													LEFT JOIN name_dslam ON id_dslam = name_dslam.id 
													LEFT JOIN street ON street.id = id_ul
													LEFT JOIN np ON np.id = id_np
													LEFT JOIN gpon ON gpon.id = id_gpon
													WHERE id_gpon ='$id_gpon' AND port_number='$i'");

						$adsl = mysqli_fetch_assoc($q);

						if (mysqli_num_rows($q) == 1) {

					?>
							<div class="row row-stripped py-2" style="cursor:pointer" onclick="javascript:document.location.href='client.php?id=<?= $adsl['id_ats'] ?>'">
								<div class="col-sm-1 d-flex align-items-center"><?= $adsl["port_number"] ?></div>
								<div class="col-sm-3 d-flex align-items-center text-wrap text-break"><?= $adsl["phone"] ?></div>
								<div class="col-sm-1 d-flex align-items-center"><?= $adsl["line_data"] ?></div>
								<div class="col-sm-3 d-flex align-items-center"><?= $adsl["client"] ?></div>
								<div class="col-sm-4 d-flex align-items-center">
									<?php

									if ($adsl["np_name"]) {
										if ($adsl['street_name'] || $adsl['nomer_doma'] || $adsl['korpus'] || $adsl['kv']) {
											echo $adsl['np_name'] . ", ";
										} else {
											echo $adsl['np_name'];
										}
									}



									if ($adsl["street_name"]) {

										echo $adsl["street_name"];

										if ($adsl["nomer_doma"]) {

											echo " " . $adsl["nomer_doma"];
										}
										if ($adsl["korpus"]) {
											echo "/" . $adsl["korpus"];
										}
										if ($adsl["kv"]) {
											echo " КВ." . $adsl["kv"];
										}
									}
									?>
								</div>
							</div>

						<?php } else { ?>
							<div class="row row-stripped py-2 bg-teal-300" style="cursor:pointer;">
								<div class="col-sm-12">
									<?= $i ?>
								</div>
							</div>
					<?php }
					} ?>




				</div>

	<?php
			}
		}
	} else {
		header('Location: /');
	}
	?>

	<?php
	require_once('footer.php');
	if ($group_id == 1 || $group_id == 2 || $group_id == 3) {
		require_once('edit-modals.php');
	}
	?>

</div>

<?php
require_once('scripts.php');
?>

</body>

</html>