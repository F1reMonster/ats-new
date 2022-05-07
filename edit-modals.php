<?php
if ($_COOKIE['user_id']) {

	if ($line["date_phone"] == 0) {
		$date_phone = "";
	} else {
		$date_phone = date("d.m.Y", $line["date_phone"]);
	}

	if ($line["date_internet"] == 0) {
		$date_internet = "";
	} else {
		$date_internet = date("d.m.Y", $line["date_internet"]);
	}


	if ($line['id_dslam']) {
		$tab_adsl_title = "active";
		$tab_adsl_active = "active show";
		$tab_gpon_title = "disabled";
		$tab_gpon_active = "";
		$tab_fttb_title = "disabled";
		$tab_fttb_active = "";
	}

	if ($line['id_gpon']) {
		$tab_adsl_title = "disabled";
		$tab_adsl_active = "";
		$tab_gpon_title = "active";
		$tab_gpon_active = "active show";
		$tab_fttb_title = "disabled";
		$tab_fttb_active = "";
	}

	if ($line['id_fttb']) {
		$tab_adsl_title = "disabled";
		$tab_adsl_active = "";
		$tab_gpon_title = "disabled";
		$tab_gpon_active = "";
		$tab_fttb_title = "active";
		$tab_fttb_active = "active show";
	}

	if (!$line['id_dslam'] && !$line['id_gpon'] && !$line['id_fttb']) {
		$tab_adsl_title = "active";
		$tab_adsl_active = "active show";
		$tab_gpon_title = "";
		$tab_gpon_active = "";
		$tab_fttb_title = "";
		$tab_fttb_active = "";
	}

?>

	<!-- modal general edit -->
	<div class="modal fade" id="general-edit" aria-hidden="true">

		<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">


			<div class="modal-content">


				<div class="modal-header">
					<div class="d-flex align-items-center">

						<?php
						if ($line['status'] == 1) {
							echo "<div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"Відключений\" class=\"d-flex align-items-center me-2 text-danger\"><i class=\"fa-solid fa-triangle-exclamation fs-4\"></i></div>";
						}
						?>
						<h5 class="modal-title me-2">Редагування ТЗ:&nbsp;<?= $line['phone'] ?></h5>

						<?php

						//if ($line['status'] == 1) { 
						?>
						<!-- <div class="d-flex align-items-center ms-2">

									<label class="form-check-label me-2 text-success fs-5 fw-bold" for="flexCheckChecked">
										Включити
									</label>

									<input class="form-check-input mt-0" type="checkbox" value="0" name="status" id="flexCheckChecked">

								</div> -->

						<?php //} 
						?>
					</div>
					<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

					</button>
				</div>
				<div class="modal-body">
					<form id="editForm" action="admin.php?mode=2&id=<?= $line['id_ats'] ?>" method="POST">

						<input type=hidden name="who_edited" value="<?= $_COOKIE['name'] ?>">
						<input hidden value="<?= $line['status'] ?>" name="status">
						<h5>Загальні дані</h5>

						<!-- date phone connect & personal code US-->
						<div class="row align-items-center">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-4">
										<label for="date1" class="col-form-label">Дата підключення телефону:</label>
									</div>
									<div class="col-8">
										<input id="date1" class="form-control" type=text value="<?= $date_phone ?>" name="d_phone">
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row ">
									<div class="col-4">
										<label for="editUS" class="me-2 col-form-label">Особовий рахунок</label>


									</div>
									<div class="col-8">
										<input id="editUS" class="form-control" type=text value="<?= $line["or_us"] ?>" name="or_us">
									</div>

								</div>
							</div>
						</div>
						<!-- ./date phone connect & personal code US-->

						<div class="row mb-2">
							<!-- phone -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="editPhone" class="col-form-label">Технічний засіб</label>
									</div>
									<div class="col-6">
										<input id="editPhone" type="text" name="phone" class="form-control" disabled value="<?= $line["phone"] ?>">
										<input hidden type="text" name="phone" value="<?= $line["phone"] ?>">
									</div>
								</div>

							</div>
							<!-- ./phone -->

							<!-- linked number -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="editLinkedPhone" class="col-form-label" data-tooltip="tooltip" data-bs-html="true" data-bs-placement="bottom" title="може бути як номер телефону згідно таблиці, так і module та port в станції - 0-277">Лінк на який номер</label>
									</div>
									<div class="col-6">
										<input id="editLinkedPhone" type="text" name="linked_phone" class="form-control" value="<?= $line["linked_phone"] ?>">
									</div>
								</div>

							</div>
							<!-- ./linked number -->

							<!-- linked port -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="editLinkedCroszPort" class="col-form-label" data-tooltip="tooltip" data-bs-html="true" data-bs-placement="bottom" title="*наприклад: 3.20.2 - де<br> 3 - ряд <br>20 - номер плінта<br> 2 - номер пари">Станційний КРОСЗ:</label>
									</div>
									<div class="col-6">
										<input id="editLinkedCroszPort" type="text" name="cross_port" class="form-control" value="<?= $line["cross_port"] ?>">
									</div>
								</div>

							</div>
							<!-- ./linked port -->
						</div>

						<div class="row mb-2">
							<!-- line data -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="editLineData" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" data-bs-html="true" title="*наприклад:<br> №2-10, 23-20">Лінійні дані<span style="color: #f00;">*</span></label>
									</div>
									<div class="col-6">
										<input id="editLineData" type="text" name="line_data" class="form-control" value="<?= $line["line_data"] ?>">
									</div>
								</div>
							</div>
							<!-- ./line data -->

							<!-- crosz data -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="editCroszData" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" title="*наприклад: 16385/22, АЦУ 8п">Додатковий КРОСЗ:</label>
									</div>
									<div class="col-6">
										<input id="editCroszData" type="text" name="cross_data" class="form-control" value="<?= $line["cross_data"] ?>">
									</div>
								</div>
							</div>
							<!-- ./crosz data -->

						</div>

						<div class="row mb-2">
							<!-- client data -->
							<div class="col-sm-12">
								<div class="row">

									<div class="col-2">
										<label for="editClient" class="col-form-label">Клієнт</label>
									</div>
									<div class="col-10">
										<input id="editClient" type="text" name="client" class="form-control" value="<?= $line["client"] ?>">
									</div>
								</div>

							</div>
							<!-- ./client data -->
						</div>

						<div class="row mb-2">
							<!-- settlement -->
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="newSettlement" class="col-form-label">Населений пункт</label>
									</div>
									<div class="col-8">
										<select id="newSettlement" name="id_settlement" class="form-select">
											<option value="0"></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM `np` ORDER by `np_name` COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {
												if ($row["id"] == $line["id_np"]) {

													$sel = 'selected';
												} else {
													$sel = '';
												}
												echo "<option $sel value=\"" . $row["id"] . "\">" . $row["np_name"] . "</option>";
											}
											?>
										</select>
									</div>
								</div>

							</div>
							<!-- ./settlement -->

							<!-- mobile phone -->
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="editMobPhone" class="col-form-label">Мобільний телефон</label>
									</div>
									<div class="col-8">
										<input id="editMobPhone" type="text" name="mobile_phone" class="form-control" value="<?= $line["mobile_phone"] ?>">
									</div>
								</div>

							</div>
							<!-- ./mobile phone -->
						</div>


						<?php
						if ($line["adress"]) { ?>
							<div class="row mb-2">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-2"><label for="editOldLocation" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" data-bs-html="true" title="ПОТРІБНО ВИДАЛИТИ!!!">Старий формат адреси<span style="color: #f00;">*</span></label></div>
										<div class="col-10">
											<input id="editOldLocation" type="text" name="client" class="form-control" value="<?= $line["client"] ?>">

										</div>
									</div>
								</div>
							</div>

						<?php }
						?>

						<!-- location -->
						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="editLocation" class="col-form-label">Вулиця</label>
									</div>
									<div class="col-8">
										<select id="editLocation" name="id_ul" class="form-select">
											<option value="0"></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM street ORDER by street_name COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {

												if ($row["id"] == $line["id_ul"]) {

													$sel = 'selected';
												} else {
													$sel = '';
												}

												echo "<option $sel value=\"" . $row["id"] . "\">" . $row["street_name"] . "</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row">

									<div class="d-flex col-3">
										<label for="editBuilding" class="me-2 col-form-label">буд.</label>
										<input id="editBuilding" class="form-control" type=text value="<?= $line["nomer_doma"]; ?>" name="nomer_bud">
									</div>

									<div class="d-flex col-3">
										<label for="editCorp" class="me-2 col-form-label">корп.</label>
										<input id="editCorp" class="form-control" type=text value="<?= $line["korpus"]; ?>" name="korpus">
									</div>
									<div class="d-flex col-3">
										<label for="editApart" class="me-2 col-form-label">кв.</label>
										<input id="editApart" class="form-control" type=text value="<?= $line["kv"]; ?>" name="kv">
									</div>
								</div>
							</div>
						</div>
						<!-- ./location -->

						<h5 class="mt-3">Інтернет</h5>

						<!-- connection date, tariff -->
						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-4">
										<label for="date2" class="col-form-label">Дата підключення до мережі інтернет:</label>
									</div>
									<div class="col-8">
										<input id="date2" class="form-control" type=text value="<?= $date_internet ?>" name="d_internet">
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="tariff" class="col-form-label">Тарифний план:</label>
									</div>
									<div class="col-8">
										<select name="tp" class="form-select">
											<option value=""></option>
											<?php
											$q = mysqli_query($connect, "SELECT * FROM tariffs order by id");
											while ($row = mysqli_fetch_assoc($q)) {
												if ($line["tp"] == $row["name"]) {
													$s = "selected=\"selected\"";
												} else {
													$s = "";
												}
												echo "<option $s value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
											}

											?>
										</select>
									</div>
								</div>
							</div>
						</div>
						<!-- ./connection date, tariff -->

						<!-- login, passw -->
						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="editLogin" class="col-form-label">Логін підключення:</label>
									</div>
									<div class="col-8">
										<input id="editLogin" type="text" name="ppp_login" class="form-control" value="<?= $line["ppp_login"] ?>">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="editPass" class="col-form-label">Пароль підключення:</label>
									</div>
									<div class="col-8">
										<input id="editPass" type="text" name="ppp_password" class="form-control" value="<?= $line["ppp_password"] ?>">
									</div>
								</div>
							</div>

						</div>
						<!-- ./login, passw -->

						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_adsl_title ?>" href="#tabAdslEdit" data-bs-toggle="tab" aria-controls="adsledit">
									<i class="fa-solid fa-fax me-2"></i>
									<span>ADSL</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_gpon_title ?>" href="#tabGponEdit" data-bs-toggle="tab" aria-controls="gponedit">
									<i class="fa-solid fa-house-signal me-2"></i>
									<span>GPON</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_fttb_title ?>" href="#tabFttbEdit" data-bs-toggle="tab" aria-controls="fttbedit">
									<i class="fa-solid fa-arrow-right-to-city me-2"></i>
									<span>FTTB</span>
								</a>
							</li>
						</ul>


						<div class="tab-content ">
							<!--  adsl tab -->
							<div class="tab-pane fade <?= $tab_adsl_active ?>" id="tabAdslEdit" role="tabpanel" aria-labelledby="adsledit-tab">
								<!-- adsl plates & ports -->
								<div class="row my-2">
									<div class="col-sm-6">
										<div class="row">
											<div class="col-4">
												<label for="select_dslam" class="col-form-label">Назва плати:</label>
											</div>
											<div class="col-8">
												<?php if ($line["id_dslam"]) {
													$disable_select = "disabled";
													echo "<input hidden name=id_dslam value=$line[id_dslam]>";
													echo "<input hidden name=edit_port_adsl value=$line[port_number]>";
												}
												?>
												<select id="select_dslam" name="id_dslam" class="form-select" <?= $disable_select ?>>
													<option value=""></option>
													<?php
													$d = mysqli_query($connect, "SELECT *, (nomer_dslam * 1) AS n_dslam FROM name_dslam ORDER BY n_dslam");

													while ($row = mysqli_fetch_array($d)) {


														if ($line["id_dslam"] == $row["id"]) {
															$s = "selected=\"selected\"";
														} else {
															$s = "";
														}
														print "<option $s value=$row[id]>$row[nomer_dslam]&nbsp;>&nbsp;$row[name_dslam]&nbsp;|&nbsp;$row[cross_name]</option>\n";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<div class="col-4">
												<label for="port" class="col-form-label">Номер порта:</label>
											</div>
											<div class="col-3">

												<select id="port" name="edit_port_adsl" class="form-select" <?= $disable_select ?>>
													<option value=""></option>
													<?php
													for ($i = 1; $i <= $line["total_ports"]; $i++) {
													?>
														<option <?php
																	if ($i == $line["port_number"]) {
																	?> selected='selected' <?php
																								}
																									?> value="<?= $i; ?>"><?= $i; ?></option>
													<?
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- ./adsl plates & ports -->

								<!-- type connections adsl,vpn, etc -->
								<div class="row mb-2">
									<div class="col-sm-6">
										<div class="row align-items-center">
											<div class="col-4">
												Тип підключення
											</div>
											<div class="col-8 d-flex">
												<div class="d-flex align-items-center me-3">
													<input id="adsl" class="form-check-input  mt-0 me-2" type="radio" name="type_client" value="ADSL" <?php if ($line["type_client"] == 'ADSL') echo "checked" ?>>
													<label for="adsl" class="col-form-label">ADSL</label>
												</div>
												<div class="d-flex align-items-center me-3">
													<input id="mpls" class="form-check-input  mt-0 me-2" type="radio" name="type_client" value="MPLS" <?php if ($line["type_client"] == 'MPLS') echo "checked" ?>>
													<label for="mpls" class="col-form-label">MPLS</label>
												</div>
												<div class="d-flex align-items-center">
													<input id="noTypeClient" class="form-check-input  mt-0 me-2" type="radio" name="type_client" value="" <?php if ($line["type_client"] == '') echo "checked" ?>>
													<label for="noTypeClient" class="col-form-label">немає</label>
												</div>
											</div>

										</div>
									</div>


									<!-- type auth dhcp, pppoe -->
									<div class="col-sm-6">
										<div class="row align-items-center">
											<div class="col-4">
												Тип авторизації
											</div>
											<div class="col-8 d-flex">
												<div class="d-flex align-items-center me-3">
													<input id="dhcp" class="form-check-input  mt-0 me-2" type="radio" name="type_connection" value="DHCP" <?php if ($line["type_connection"] == 'DHCP') echo "checked" ?>>
													<label for="dhcp" class="col-form-label">DHCP</label>
												</div>
												<div class="d-flex align-items-center me-3">
													<input id="pppoe" class="form-check-input  mt-0 me-2" type="radio" name="type_connection" value="PPPoE" <?php if ($line["type_connection"] == 'PPPoE') echo "checked" ?>>
													<label for="pppoe" class="col-form-label">PPPoE</label>
												</div>
												<div class="d-flex align-items-center">
													<input id="noTypeConnection" class="form-check-input  mt-0 me-2" type="radio" name="type_connection" value="" <?php if ($line["type_connection"] == '') echo "checked" ?>>
													<label for="noTypeConnection" class="col-form-label">немає</label>
												</div>

											</div>
										</div>
									</div>
									<!-- ./type auth dhcp, pppoe -->
								</div>
								<!-- ./type connections adsl,vpn, etc -->
							</div>

							<!-- gpon tab -->
							<div class="tab-pane fade <?= $tab_gpon_active ?>" id="tabGponEdit" role="tabpanel" aria-labelledby="gponedit-tab">
								<div class="row my-2">
									<div class="col-sm-8">
										<div class="row">
											<div class="col-2">
												<label for="editSelectGpon" class="col-form-label">Сплітер:</label>
											</div>
											<div class="col-10">
												<?php if ($line["id_gpon"]) {
													$disable_select = "disabled";
													echo "<input hidden name=id_gpon value=$line[id_gpon]>";
													echo "<input hidden name=edit_port_gpon value=$line[port_number]>";
												}
												?>

												<select id="editSelectGpon" name="id_gpon" class="form-select" <?= $disable_select ?>>
													<option value=""></option>
													<?php

													$d = mysqli_query($connect, "SELECT *, gpon.id AS g_id FROM gpon LEFT JOIN np ON np.id = id_gpon_np LEFT JOIN street ON street.id = id_gpon_street ORDER BY np_name, street_name, gpon_building_number");
													while ($row = mysqli_fetch_array($d)) {

														if ($line["id_gpon"] == $row["g_id"]) {
															$s = "selected=\"selected\"";
														} else {
															$s = "";
														}

														print "<option $s value=$row[g_id]>$row[np_name],&nbsp;$row[street_name],&nbsp;б.$row[gpon_building_number]&nbsp;|&nbsp;$row[gpon_splitter]</option>\n";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="row">
											<div class="col-5">
												<label for="editGponPort" class="col-form-label">Номер порта:</label>
											</div>
											<div class="col-3">
												<select id="editGponPort" name="edit_port_gpon" class="form-select" <?= $disable_select ?>>
													<option value=""></option>
													<?php
													for ($i = 1; $i <= $line["gpon_slitter_ports"]; $i++) {
													?>
														<option <?php
																	if ($i == $line["port_number"]) {
																	?> selected='selected' <?php
																								}
																									?> value="<?= $i; ?>"><?= $i; ?></option>
													<?
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- fttb tab -->
							<div class="tab-pane fade <?= $tab_fttb_active ?>" id="tabFttbEdit" role="tabpanel" aria-labelledby="fttbedit-tab">
								<div class="row my-2">
									<p>FTTB Comming soon...</p>
								</div>
							</div>
						</div>


						<h5 class="pt-2 border-top">Примітка</h5>
						<div class="row mb-2">
							<div class="col-sm-12">
								<textarea name="note" class="form-control"><?= $line["note"] ?></textarea>

							</div>
						</div>


					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
					<button class="btn btn-primary" type="submit" id="btnEditFormSubmit">Зберегти</button>
				</div>
			</div>
		</div>
	</div>

	<!-- ./ modal general edit -->


	<!-- modal disconnect -->
	<div class="modal fade" id="disconnect-client" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=5&user=<?= $userid ?>&id=<?= $line["id_ats"] ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Відключити ТЗ №<?= $line['phone'] ?></h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<h3 style="text-align: center; color: #f00;">Впевнені, що хочете відключити!?</h3>
						<input hidden type="numeric" name="status" value="1">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Відключити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal disconnect -->

	<!-- modal disconnect -->
	<div class="modal fade" id="connect-client" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=12&user=<?= $userid ?>&id=<?= $line["id_ats"] ?>" method="POST">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Відновити ТЗ №<?= $line['phone'] ?></h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<h3 style="text-align: center; color: #f00;">Впевнені, що хочете відновити!?</h3>
						<input hidden type="numeric" name="status" value="1">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Відновити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal disconnect -->


	<!-- modal remove internet -->
	<div class="modal fade" id="remove-internet" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=6&user=<?= $userid ?>&id=<?= $line["id_ats"] ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Зняття інтернету по ТЗ №<?= $line['phone'] ?></h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<h3 style="text-align: center; color: #f00;">Впевнені, що хочете зняти інтернет !?</h3>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Зняти</button>
					</div>

				</div>
			</form>
		</div>
	</div>
	<!-- ./modal remove internet -->

	<!-- modal change phone -->
	<div class="modal fade" id="change-phone" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=8" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Змінити ТЗ</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">


						<p>Новий ТЗ:</p>

						<div class="search-form__input search-form__input--phonedata">
							<input class="form-control" type="text" name="phone" value="<?= $line['phone'] ?>" onblur="if(this.value=='') this.value='<?= $line['phone'] ?>';" onfocus="if(this.value=='<?= $line['phone'] ?>') this.value='';" />
							<input type="hidden" name="id_ats" value="<?= $line['id_ats'] ?>">
							<input type="hidden" name="userid" value="<?= $userid ?>">
							<input type="hidden" name="old_phone" value="<?= $line['phone'] ?>">


						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Змінити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal change phone -->


	<!-- modal change linedata -->
	<div class="modal fade" id="change-linedata" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=7&user=<?= $userid ?>&id=<?= $line["id_ats"] ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Змінити лінійні дані</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">


						<p>Введіть нову магістраль та пару</p>

						<div class="search-form__input search-form__input--phonedata">
							<input class="form-control" type="text" name="linedata" value="<?= $line["line_data"] ?>" onblur="if(this.value=='') this.value='<?= $line["line_data"] ?>';" onfocus="if(this.value=='<?= $line["line_data"] ?>') this.value='';" />
							<input type="hidden" name="id_ats" value="<?= $line['id_ats'] ?>">
							<input type="hidden" name="userid" value="<?= $userid ?>">
							<input type="hidden" name="old_linedata" value="<?= $line["line_data"] ?>">


						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Змінити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal change linedata -->

	<!-- modal remove record -->
	<div class="modal fade" id="delete-record" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=9&groupid=<?= $group_id ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Видалення запису</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">


						<h4 style="text-align: center; color: #f00;">Впевнені, що хочете видалити запис !?</h4>

						<div class="search-form__input search-form__input--phonedata">

							<input type="hidden" name="id_ats" value="<?= $line['id_ats'] ?>">

						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">Ні</button>

						<button class="btn btn-danger" type="submit">Так</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal remove record -->

	<!-- modal change internet -->
	<div class="modal fade" id="change-internet" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="admin.php?mode=13&user=<?= $userid ?>&id=<?= $line["id_ats"] ?>" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Заміна порту</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<p>Виберіть нову локацію та порт</p>
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_adsl_title ?>" href="#tabAdslEdit1" data-bs-toggle="tab" aria-controls="adsledit1">
									<i class="fa-solid fa-fax me-2"></i>
									<span>ADSL</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_gpon_title ?>" href="#tabGponEdit1" data-bs-toggle="tab" aria-controls="gponedit1">
									<i class="fa-solid fa-house-signal me-2"></i>
									<span>GPON</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center <?= $tab_fttb_title ?>" href="#tabFttbEdit1" data-bs-toggle="tab" aria-controls="fttbedit1">
									<i class="fa-solid fa-arrow-right-to-city me-2"></i>
									<span>FTTB</span>
								</a>
							</li>
						</ul>

						<div class="tab-content ">
							<!-- adsl plates & ports -->
							<div class="tab-pane fade <?= $tab_adsl_active ?>" id="tabAdslEdit1" role="tabpanel" aria-labelledby="adsledit-tab1">
								<div class="row my-2">
									<div class="col-2">
										<label for="select_dslam_change" class="col-form-label">Назва плати:</label>
									</div>
									<div class="col-8">
										<select id="select_dslam_change" name="id_dslam_change" class="form-select">
											<option value=""></option>
											<?php
											$d = mysqli_query($connect, "SELECT *, (nomer_dslam * 1) AS n_dslam FROM name_dslam ORDER BY n_dslam");
											while ($row = mysqli_fetch_array($d)) {

												//$val++;
												if ($row["name_dslam"] == 'PL-xorol-eci-m82-s1') {
													$row["name_dslam"] = $row["name_dslam"] . "&nbsp;/&nbsp;" . "слот&nbsp;" . $row["nomer_slota"];
												}
												if ($line["id_dslam"] == $row["id"]) {
													$s = "selected=\"selected\"";
												} else {
													$s = "";
												}
												print "<option $s value=$row[id]>$row[nomer_dslam]&nbsp;>&nbsp;$row[name_dslam]&nbsp;|&nbsp;$row[cross_name]</option>\n";
											}
											?>
										</select>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-2">
										<label for="port_change" class="col-form-label">Номер порта:</label>
									</div>
									<div class="col-3">
										<select id="port_change" name="port_number_change" class="form-select">
											<option value=""></option>
											<?php
											for ($i = 1; $i <= $line["total_ports"]; $i++) {
											?>
												<option <?php if ($i == $line["port_number"]) { ?> selected='selected' <?php } ?> value="<?= $i; ?>"><?= $i; ?>
												</option>
											<? } ?>
										</select>
									</div>
								</div>
								<div class="row mb-2">
									<div class="col-sm-2">
										<label for="crosz_data_change" class="col-form-label">Дод.КРОСЗ:</label>
									</div>
									<div class="col-sm-3">
										<input id="crosz_data_change" type="text" name="crosz_data_change" class="form-control" value="<?= $line["cross_data"] ?>">
									</div>
								</div>
								<!-- ./adsl plates & ports -->
							</div>
							<!-- ./ adsl plates & ports-->
							
							<!--  gpon -->
							<div class="tab-pane fade <?= $tab_gpon_active ?>" id="tabGponEdit1" role="tabpanel" aria-labelledby="gponedit-tab1">
								<div class="row my-2">
									<p>GPON Comming soon...</p>
								</div>
							</div>
							<!-- ./ gpon -->
							
							<!-- ./ fttb -->
							<div class="tab-pane fade <?= $tab_fttb_active ?>" id="tabFttbEdit1" role="tabpanel" aria-labelledby="fttbedit-tab1">
								<div class="row my-2">
									<p>FTTB Comming soon...</p>
								</div>
							</div>
							<!-- ./ fttb -->
						</div>



					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>

						<button class="btn btn-primary" type="submit">Змінити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal change internet -->

	<!-- edit adsl plate -->
	<div class="modal fade" id="edit-dslam" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="admin.php?mode=15" method="POST">
				<input hidden name="edit_id_adsl" value="<?= $q1["id"] ?>">

				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Редагування ADSL плати</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="row align-items-center mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="editNumberDslam" class="col-form-label">id DSLAM</label>
									</div>
									<div class="col-sm-8">
										<input id="editNumberDslam" class="form-control" type=text value="<?= $q1["nomer_dslam"] ?>" name="edit_dslam_id" required>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="editPlateName" class="col-form-label">Назва DSLAM:</label>
									</div>
									<div class="col-sm-8">
										<input id="editPlateName" class="form-control" type=text value="<?= $q1["name_dslam"] ?>" name="edit_dslam_name" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="editIpDslam" class="col-form-label">IP DSLAM:</label>
									</div>
									<div class="col-sm-8">
										<input id="editIpDslam" class="form-control" type="text" value="<?= $q1["ip_dslam"] ?>" name="edit_dslam_ip">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="editTotalPorts" class="col-form-label">К-сть портів:</label>
									</div>
									<div class="col-sm-8">
										<input id="editTotalPorts" class="form-control" type="text" value="<?= $q1["total_ports"] ?>" name="edit_dslam_ports">
									</div>

								</div>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="editSlotNumber" class="col-form-label">Номер слота:</label>
									</div>
									<div class="col-sm-8">
										<input id="editSlotNumber" class="form-control" type="text" value="<?= $q1["nomer_slota"] ?>" name="edit_slot_number">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="editVendor" class="col-form-label">Vendor:</label>
									</div>
									<div class="col-sm-8">
										<input id="editVendor" class="form-control" type="text" value="<?= $q1["vendor"] ?>" name="edit_vendor">
									</div>

								</div>
							</div>
						</div>


						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="editCscsName" class="col-form-label">Назва на КРОСзі:</label>
									</div>
									<div class="col-sm-8">
										<input id="editCscsName" class="form-control" type="text" value="<?= $q1["cross_name"] ?>" name="edit_cscs_name">
									</div>

								</div>
							</div>

						</div>
						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="editDslamString" class="col-form-label">Ідентифікатор:</label>
							</div>
							<div class="col-sm-10">
								<input id="editDslamString" class="form-control" type="text" name="edit_dslam_string" value="<?= $q1["string_id"]  ?>">
							</div>

						</div>

						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="editDslamNote" class="col-form-label">Примітка:</label>
							</div>
							<div class="col-sm-10">
								<textarea id="editDslamNote" class="form-control" type="text" name="edit_dslam_note"><?= $q1["notes"] ?></textarea>
							</div>

						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

						<button class="btn btn-primary" type="submit">Виконати</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./add adsl plate -->

	<!-- modal remove adsl plate -->
	<div class="modal fade" id="delete-dslam" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=16" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Видалення ADSL плати</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">


						<h4 class="text-center text-danger">Впевнені, що хочете видалити ADSL-плату <span class="fs-4 blink-danger"><?= $q1['name_dslam'] ?></span> !?</h4>

						<div class="search-form__input search-form__input--phonedata">

							<input type="hidden" name="delete_adsl_plate_id" value="<?= $q1['id'] ?>">

						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">Ні</button>

						<button class="btn btn-danger" type="submit">Так</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal remove adsl plate -->

	<!-- modal change profile -->
	<div class="modal fade" id="change-profile" aria-hidden="true">
		<div class="modal-dialog modal-md" role="document">
			<form action="admin.php?mode=17" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Заміна профайлу</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<input hidden name="profile_ip_dslam" value="<?= $line["ip_dslam"] ?>">
						<input hidden name="profile_dslam_port" value="<?= $line["port_number"] ?>">
						<input hidden name="client_id" value="<?= $line["id_ats"] ?>">
						<div class="row align-items-center">
							<div class="col-sm-3">Виберіть профайл</div>
							<div class="col-sm-9">
								<select name="profile_id" class="form-select">
									<option value=""></option>
									<option value="141">VPN-64/96Adsl2</option>
									<option value="7">N96/96ADSL2+</option>
									<option value="142">VPN-96/160Adsl2+</option>
									<option value="100">N160/320ADSL2+</option>
									<option value="104">N320/608ADSL2+</option>
									<option value="143">VPN-320/608Adsl2+</option>
									<option value="108">N608/1248ADSL2+</option>
									<option value="138">N128-928/320-2464Adsl2+</option>
									<option value="136">N128-1248/320-2464ADSL2</option>
									<option value="144">VPN-608/2464Adsl2+</option>
									<option value="139">N160-928/608-4896Adsl2+</option>
									<option value="137">N160-1856/608-4896AnnexM</option>
									<option value="145">N160-1856/608-6432AnnexM</option>
									<option value="140">N320-928/1248-9824Adsl2+</option>
									<option value="135">N160-2464/1248-9824ADSL2</option>
									<option value="146">N320-2464/2464-12896AnnexM</option>
									<option value="147">N608-3008/4896-18720AnnexM</option>
									<option value="134">N608-3008/4896-24000AnnexM</option>

								</select>
							</div>
						</div>




					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

						<button class="btn btn-primary" type="submit">Змінити</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./ modal change profile -->



<?php } else {
	header("Location: /");
} ?>