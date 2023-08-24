<?php
if ($_COOKIE['user_id']) {
	require_once('config.php');
	require_once('head.php');

	$id = $_GET['id'];

?>
	<div class="body-wrapper">
		<div class="container">

			<?php

			require_once('header.php');
			require_once('search-form.php');

			if (ctype_digit($id)) {
				$query = mysqli_query($connect, "SELECT *, d.id as id_ats, n.np_name as gpon_np, s.street_name as gpon_street, street.street_name as cli_street, np.np_name as cli_np
				FROM db_ats d
				LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
				LEFT JOIN street ON street.id = id_ul
				LEFT JOIN np ON np.id = id_np
				LEFT JOIN gpon ON gpon.id = id_gpon
				LEFT JOIN np n ON n.id = id_gpon_np
				LEFT JOIN street s ON s.id = id_gpon_street
				WHERE d.id = $id");

				if (mysqli_num_rows($query) !== 0) {

					$line = mysqli_fetch_assoc($query);


			?>

					<div class="block block__client">
						<div class="d-flex justify-content-end mb-2">
							<span class="me-2" style="font-size: 12px;">id: <?= $line['id_ats'] ?></span>
							<span style="font-size: 12px;">edited: <?php echo date("d.m.Y H:i:s", $line["date_edit"]); ?></span>
						</div>
						<div class="client__head">
							<div class="d-flex align-items-center">

								<?php //echo "status ".$line['status'];
								if ($line['status'] == 1) {
									echo "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"Відключений\" class=\"text-danger me-2 mb-2\"><i class=\"fa-solid fa-triangle-exclamation fa-fade fs-3\"></i></div>";
								} ?>

								<h4>Картка абонента ТЗ:&nbsp <?= $line['phone'] ?></h4>
							</div>

							<?php if ($group_id == 1 || $group_id == 2 || $group_id == 3) { ?>
								<div class="client__action">
									<div class="client__action-item">
										<a href="" data-bs-toggle="modal" data-bs-target="#general-edit">
											<div data-tooltip="tooltip" data-bs-placement="bottom" title="Рeдагувати">
												<i class="fa-solid fa-pen-to-square fs-4"></i>
											</div>
										</a>
									</div>

									<?php
									if ($line['status'] == 0) {
									?>

										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#change-phone">
												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Заміна ТЗ">
													<i class="fa-solid fa-square-phone fs-4"></i>
												</div>
											</a>
										</div>

									<?php } ?>

									<?php if ($line["line_data"]) { ?>

										<div class="client__action-item">
											<a data-bs-toggle="modal" data-bs-target="#change-linedata" href="">
												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Змінити лінійні дані">
													<i class="fa-solid fa-arrow-right-arrow-left fs-4"></i>
												</div>
											</a>
										</div>

									<? } ?>

									<?php
									if ($line["ip_dslam"] && $line["port_number"]) { ?>

										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#change-profile">
												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Змінити профайл">
													<i class="fa-solid fa-screwdriver-wrench fs-4 text-success"></i>
												</div>

											</a>
										</div>

									<?php } ?>

									<?php
									if ($line["port_number"]) { ?>
										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#change-internet">
												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Заміна порту">
													<i class="fa-solid fa-ethernet fs-4"></i>
												</div>
											</a>
										</div>

										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#remove-internet">
												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Зняти інтернет">
													<i class="fa-solid fa-link-slash fs-4"></i>
												</div>
											</a>
										</div>
									<?php } ?>


									<?php
									if ($line["status"] == 0) { ?>
										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#disconnect-client">

												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Відключити">
													<i class="fa-solid fa-square-minus fs-4"></i>
												</div>
											</a>

										</div>
									<?php } ?>

									<?php
									if ($line["status"] == 1) { ?>
										<div class="client__action-item">
											<a href="" data-bs-toggle="modal" data-bs-target="#connect-client">

												<div data-tooltip="tooltip" data-bs-placement="bottom" title="Включити">
													<i class="fa-solid fa-circle-check fs-4 text-success"></i>
												</div>
											</a>

										</div>
									<?php } ?>


								<?php } ?>

								<?php
								if ($group_id == 1) {
								?>
									<div class="client__action-item">
										<a href="" data-bs-toggle="modal" data-bs-target="#delete-record">
											<div data-tooltip="tooltip" data-bs-placement="bottom" title="Видалити запис">
												<i class="fa-solid fa-circle-xmark fs-4 text-danger"></i>
											</div>

										</a>

									</div>
								<?php } ?>




								</div>

						</div>
						<div class="client__head-row client__head-row--primary row">
							<div class="client__head-title col-md-4">
								<h5>Особисті дані</h5>
							</div>
							<div class="client__head-title col-md-4">
								<h5>Технічний засіб</h5>
							</div>
							<div class="client__head-title col-md-4">
								<h5>Інтернет</h5>
							</div>
							<div class="client__head-title-mobile">
								<h5>Інформація про абонента</h5>
							</div>
						</div>

						<div class="client__row row">

							<!-- personal data -->

							<div class="col-lg-4">

								<?php if ($line["or_us"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Особовий рахунок:
										</div>
										<div class="client__row-data col-7">
											<?= $line["or_us"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line['client']) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Абонент:
										</div>
										<div class="client__row-data col-7">
											<?= $line["client"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line['cli_np']) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Населений пункт:
										</div>
										<div class="client__row-data col-7">
											<?= $line["cli_np"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line['cli_street']) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Вулиця:
										</div>
										<div class="client__row-data col-7">
											<?php
											if ($line['cli_street']) {
												echo $line['cli_street'];
											}
											if ($line['nomer_doma']) {
												echo " " . $line['nomer_doma'];
											}
											if ($line['korpus']) {
												echo "/" . $line['korpus'];
											}
											if ($line['kv']) {
												echo " КВ." . $line['kv'];
											}
											?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["mobile_phone"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Мобільний телефон:
										</div>
										<div class="client__row-data col-7">
											<?= $line["mobile_phone"] ?>
										</div>
									</div>
								<?php } ?>

							</div>

							<!-- ./personal data -->

							<!-- phone data -->
							<?php
							if ($line['id_gpon']) {
								$col_port_1 = 4;
								$col_port_2 = 8;
								$fz_12 = "style=\"font-size: 14px;\"";
							} else {
								$col_port_1 = 5;
								$col_port_2 = 7;
							}
							?>

							<div class="col-lg-4">

								<?php if ($line["date_phone"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Дата підключення:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= date("d.m.Y", $line["date_phone"]) ?>
										</div>
									</div>
								<?php } ?>


								<?php if ($line["phone"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Технічний засіб:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?> text-break text-wrap" <?= $fz_12 ?>>
											<?= $line["phone"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["line_data"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Лінінійні дані:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= $line["line_data"] ?>
										</div>
									</div>
								<?php } ?>
								<?php if ($line["cross_data"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Додатковий КРОСЗ:
										</div>
										<div class="client__row-data col-7">
											<?= $line["cross_data"] ?>
										</div>
									</div>
								<?php } ?>
								<?php if ($line["linked_phone"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Порт SI2000:
										</div>
										<div class="client__row-data col-7">
											<?= $line["linked_phone"] ?>
										</div>
									</div>
								<?php } ?>
								<?php if ($line["cross_port"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Станційний КРОСЗ:
										</div>
										<div class="client__row-data col-7">
											<?= $line["cross_port"] ?>
										</div>
									</div>
								<?php } ?>

							</div>

							<!-- ./phone data -->

							<!-- internet data -->
							<div class="col-lg-4">

								<?php if ($line["date_internet"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Дата підключення:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= date("d.m.Y", $line["date_internet"]) ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["name_dslam"]) { ?>
									<div class="row" style="cursor:pointer" onclick="javascript:document.location.href='info.php?m=3&adsl=<?= $line['id_dslam'] ?>'">
										<div class="client__row-title col-5">
											Назва плати:
										</div>
										<div class="client__row-data col-7">
											<?= $line["name_dslam"] ?>
										</div>
									</div>
								<?php } ?>
								<?php if ($line["id_gpon"]) {
								?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Локація:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?> text-break text-wrap" <?= $fz_12 ?>>
											<?= $line["gpon_location"] ?>
										</div>
									</div>
									<div class="row" style="cursor:pointer" onclick="javascript:document.location.href='info.php?m=7&gpon=<?= $line['id_gpon'] ?>'">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Сплітер:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= $line["gpon_splitter"] ?>
										</div>
									</div>
								<?php }  ?>

								<?php if ($line["port_number"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Порт:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?> d-flex justify-content-between align-content-center">
											<span><?= $line["port_number"] ?></span>
											<?php
											if ($line["string_id"] && $line["nomer_slota"] && $line["port_number"] && $line["vendor"]) {
											?>
												<span id="idString" style="position: absolute; color: transparent; opacity: 0; font-size: 0px;"><?= mb_strtoupper($line["vendor"]) . ":" . $line["string_id"] . " atm " . $line["nomer_slota"] . "/" . $line["port_number"] ?></span>
												<div class="copy-clipboard" style="cursor:pointer" data-tooltip="tooltip" data-bs-placement="bottom" title="копіювати" data-clipboard-target="#idString">
													<i class="fa-solid fa-copy fs-5 text-primary"></i>
												</div>

											<?php
											}
											?>

										</div>
									</div>
								<?php } ?>

								<?php
								if ($line["id_gpon"]) {	?>

									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Адреса сплітера:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?php
											if ($line['gpon_bulding_korpus']) {
												echo $line["gpon_np"] . ", " . $line["gpon_street"] . ", " . $line["gpon_building_number"] . "/" . $line["gpon_building_korpus"];
											} else {
												echo $line["gpon_np"] . ", " . $line["gpon_street"] . ", " . $line["gpon_building_number"];
											}
											?>
										</div>
									</div>

								<?php } ?>

								<?php if ($line["ip_dslam"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											ІР-адреса:
										</div>
										<div class="client__row-data col-7 d-flex justify-content-between align-content-center">
											<span id="ipAddr"><?= $line["ip_dslam"] ?></span>
											<div class="copy-clipboard" style="cursor:pointer" data-tooltip="tooltip" data-bs-placement="bottom" title="копіювати" data-clipboard-target="#ipAddr">
												<i class="fa-solid fa-copy fs-5 text-primary"></i>
											</div>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["type_client"]) { ?>
									<div class="row">
										<div class="client__row-title col-5">
											Тип з'єднання:
										</div>
										<div class="client__row-data col-7">
											<?= $line["type_client"] ?>
											<?php
											if ($line["type_connection"]) {
												echo " / " . $line["type_connection"];
											}
											?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["ppp_login"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Логін:
										</div>
										<div class="client__row-data client__row-data--login col-<?= $col_port_2 ?>" <?= $fz_12 ?>>
											<?= $line["ppp_login"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["ppp_password"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Пароль з'єднання:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= $line["ppp_password"] ?>
										</div>
									</div>
								<?php } ?>

								<?php if ($line["tp"]) { ?>
									<div class="row">
										<div class="client__row-title col-<?= $col_port_1 ?>">
											Тарифний план:
										</div>
										<div class="client__row-data col-<?= $col_port_2 ?>">
											<?= $line["tp"] ?>
										</div>
									</div>
								<?php } ?>

							</div>

							<!-- ./internet data -->

						</div>


						<!-- note -->

						<?php
						if ($line["note"]) { ?>
							<div class="client__head-row client__head-row--primary row">
								<div class="client__head-title col-md-12">
									<h5>Примітка</h5>
								</div>
								<div class="client__head-title-mobile">
									<h5>Примітка</h5>
								</div>

							</div>

							<div class="client__row row">
								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12">
											<?= $line["note"] ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- ./note -->

						<!-- history -->

						<?php

						$history_query = mysqli_query($connect, "SELECT * FROM history WHERE ats_id = $id ORDER BY date DESC");


						if (mysqli_num_rows($history_query) !== 0) {
						?>

							<div class="row">
								<div class="client__head-title col-md-12">
									<h5>Історія</h5>
								</div>

							</div>

							<div class="client__head-row client__head-row--primary client__head-row--history row">
								<div class="client__head-title col-md-1">
									<h5>Дата</h5>
								</div>
								<div class="client__head-title col-md-2">
									<h5>Тип операції</h5>
								</div>
								<div class="client__head-title col-md-3">
									<h5>ПІБ/Адреса</h5>
								</div>
								<div class="client__head-title col-md-4">
									<h5>Дані</h5>
								</div>
								<div class="client__head-title col-md-2">
									<h5>Виконав</h5>
								</div>

							</div>
							<div class="client__row row">
								<div class="col-md-12">

									<?php
									while ($his_row = mysqli_fetch_assoc($history_query)) {
										switch ($his_row['type']) {
											case 1:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"відключення\"><i class=\"fa-solid fa-circle-minus fs-4 text-danger\"></i></div>";
												break;
											case 2:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"відключення інтернету\"><i class=\"fa-solid fa-link-slash fs-4 text-danger\"></i></div>";
												break;
											case 3:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"заміна магістралі\"><i class=\"fa-solid fa-arrow-right-arrow-left fs-4 text-primary\"></i></div>";
												break;
											case 4:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"заміна номеру\"><i class=\"fa-solid fa-square-phone fs-4 text-primary\"></i></div>";
												break;
											case 5:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"заміна порту\"><i class=\"fa-solid fa-ethernet fs-4 text-primary\"></i></div>";
												break;
											case 6:
												$type = "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"включення\"><i class=\"fa-solid fa-circle-check fs-4 text-success\"></i></div>";

												break;
										}
									?>
										<div class="row">
											<div class="client__history-col col-lg-1 col-12">
												<div class="row flex-grow-1 ">
													<div class="client__history-title col-5 fw-bold">Дата</div>
													<div class="col-lg-12 col-7">
														<?php echo date("d.m.y", $his_row["date"]); ?>
													</div>
												</div>
											</div>
											<div class="client__history-col client__history-col--type col-lg-2 col-12">
												<div class="row flex-grow-1 ">
													<div class="client__history-title col-5 fw-bold">Тип операції</div>
													<div class="col-lg-12 col-7 d-flex">
														<?= $type ?>
													</div>
												</div>

											</div>
											<div class="client__history-col col-lg-3 col-12">
												<?php
												if ($his_row['client'] && $his_row['adress']) {
												?>
													<div class="row flex-grow-1 ">
														<div class="client__history-title col-5 fw-bold">ПІБ/Адреса</div>
														<div class="col-lg-12 col-7 d-flex">
															<?php echo $his_row['client'] . '<br>' . $his_row['adress']; ?>
														</div>
													</div>
												<?php } ?>




											</div>
											<div class="client__history-col client__history-col--linedata col-lg-4 col-12">
												<div class="row flex-grow-1 ">
													<div class="client__history-title col-5 fw-bold">Дані</div>
													<div class="col-lg-12 col-7 d-flex">
														<?php
														if ($his_row['line_data'] && $his_row['internet']) {
															$br = "<br/>";
														}
														if ($his_row['line_data']) {
															echo $his_row['line_data'];
														}
														echo $br;

														if ($his_row['internet']) {
															echo $his_row['internet'];
														}
														?>
													</div>
												</div>



											</div>
											<div class="client__history-col col-lg-2 col-12">
												<div class="row flex-grow-1 ">
													<div class="client__history-title col-5 fw-bold">Виконав</div>
													<div class="col-lg-12 col-7 d-flex">
														<?= $his_row['user'] ?>
													</div>
												</div>


											</div>
										</div>

								<?php
									}
								}
								?>
								</div>
							</div>

							<!-- ./history -->

					</div>
				<?php
				} else {
					echo "<div class=\"error__message\">Wrong data!!!</div>";
				}

				require_once('footer.php');
				?>

		</div>
	</div>



<?php
				if ($group_id == 1 || $group_id == 2 || $group_id == 3) {
					require_once('edit-modals.php');
				}
			}
		} else {
			header('Location: /');
		}

		require_once('scripts.php');
?>
</body>

</html>