<?php
if ($_COOKIE['user_id']) {
	// Cable switchgear of communication systems -> CSCS
	// Кабельне розподільне обладнання систем зв'язку -> КРОСЗ

?>
	<!-- add new client -->
	<div class="modal fade" id="addNewClient" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Додавання нового запису</h5>
					<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

					</button>
				</div>
				<div class="modal-body">
					<form id="newClientForm" action="admin.php?mode=1" method="post">
						<h5>Загальні дані</h5>

						<!-- date phone connect & personal code US-->
						<div class="row align-items-center">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-4">
										<label for="newDatePhoneConnection" class="col-form-label">Дата підключення технічного засобу:</label>
									</div>
									<div class="col-8">
										<input id="newDatePhoneConnection" class="form-control" type=text value="" name="new_date_phone">
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row ">
									<div class="col-4">
										<label for="newOr" class="me-2 col-form-label">Особовий рахунок</label>


									</div>
									<div class="col-8">
										<input id="newOr" class="form-control" type=text value="" name="new_or_us">
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
										<label for="newPhone" class="col-form-label">Технійчий засіб</label>
									</div>
									<div class="col-6">
										<input id="newPhone" type="text" name="new_phone" class="form-control" value="">
									</div>
								</div>

							</div>
							<!-- ./phone -->

							<!-- linked number -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="newLinkedPhone" class="col-form-label">Лінк на який номер</label>
									</div>
									<div class="col-6">
										<input id="newLinkedPhone" type="text" name="new_linked_phone" class="form-control" value="">
									</div>
								</div>

							</div>
							<!-- ./linked number -->

							<!-- linked port -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="newLinkedCroszPort" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" title="*наприклад: 3.20.2">Порт на кросі*</label>
									</div>
									<div class="col-6">
										<input id="newLinkedCroszPort" type="text" name="new_cross_port" class="form-control" value="">
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
										<label for="newLineData" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" data-bs-html="true" title="*наприклад:<br> №2-10, 23-20">Лінійні дані<span style="color: #f00;">*</span></label>
									</div>
									<div class="col-6">
										<input id="newLineData" type="text" name="new_line_data" class="form-control" value="">
									</div>
								</div>
							</div>
							<!-- ./line data -->

							<!-- crosz data -->
							<div class="col-sm-4">
								<div class="row">
									<div class="col-6">
										<label for="newCroszData" class="col-form-label" data-tooltip="tooltip" data-bs-placement="bottom" title="*наприклад: АДСЛ15(85,86), нч 2/2">Дані кросу*</label>
									</div>
									<div class="col-6">
										<input id="newCroszData" type="text" name="new_cross_data" class="form-control" value="">
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
										<label for="newClient" class="col-form-label">Клієнт</label>
									</div>
									<div class="col-10">
										<input id="newClient" type="text" name="new_client" class="form-control" value="">
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
										<select id="newSettlement" name="new_id_settlement" class="form-select">
											<option value="0"></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM `np` ORDER by `np_name` COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["np_name"] . "</option>";
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
										<label for="newMobPhone" class="col-form-label">Мобільний телефон</label>
									</div>
									<div class="col-8">
										<input id="newMobPhone" type="text" name="new_mobile_phone" class="form-control" value="">
									</div>
								</div>

							</div>
							<!-- ./mobile phone -->
						</div>

						<!-- location -->
						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="newLocation" class="col-form-label">Адреса</label>
									</div>
									<div class="col-8">
										<select id="newLocation" name="new_id_ul" class="form-select">
											<option value="0"></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM street ORDER by street_name COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["street_name"] . "</option>";
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row">

									<div class="d-flex col-3">
										<label for="newBuilding" class="me-2 col-form-label">буд.</label>
										<input id="newBuilding" class="form-control" type=text value="" name="new_nomer_bud">
									</div>

									<div class="d-flex col-3">
										<label for="newCorp" class="me-2 col-form-label">корп.</label>
										<input id="newCorp" class="form-control" type=text value="" name="new_korpus">
									</div>
									<div class="d-flex col-3">
										<label for="newApart" class="me-2 col-form-label">кв.</label>
										<input id="newApart" class="form-control" type=text value="" name="new_kv">
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
										<label for="newDateInternetConnection" class="col-form-label">Дата підключення до мережі інтернет:</label>
									</div>
									<div class="col-8">
										<input id="newDateInternetConnection" class="form-control" type=text value="" name="new_date_internet">
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="newTariff" class="col-form-label">Тарифний план:</label>
									</div>
									<div class="col-8">
										<select id="newTariff" name="new_tp" class="form-select">
											<option value=""></option>
											<?php
											$q = mysqli_query($connect, "SELECT * FROM tariffs order by id");
											while ($row = mysqli_fetch_assoc($q)) {
												echo "<option  value=\"" . $row["name"] . "\">" . $row["name"] . "</option>";
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
										<label for="newLogin" class="col-form-label">Логін підключення:</label>
									</div>
									<div class="col-8">
										<input id="newLogin" type="text" name="new_ppp_login" class="form-control" value="">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-4">
										<label for="newPass" class="col-form-label">Пароль підключення:</label>
									</div>
									<div class="col-8">
										<input id="newPass" type="text" name="new_ppp_password" class="form-control" value="">
									</div>
								</div>
							</div>

						</div>
						<!-- ./login, passw -->

						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center active" href="#tabAdsl" data-bs-toggle="tab" aria-controls="adsl">
									<i class="fa-solid fa-fax me-2"></i>
									<span>ADSL</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center" href="#tabGpon" data-bs-toggle="tab" aria-controls="gpon">
									<i class="fa-solid fa-house-signal me-2"></i>
									<span>GPON</span>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link d-flex align-items-center" href="#tabFttb" data-bs-toggle="tab" aria-controls="fttb">
									<i class="fa-solid fa-arrow-right-to-city me-2"></i>
									<span>FTTB</span>
								</a>
							</li>
						</ul>

						<div class="tab-content ">
							<div class="tab-pane fade show active" id="tabAdsl" role="tabpanel" aria-labelledby="adsl-tab">
								<!-- adsl plates & ports -->
								<div class="row my-2">
									<div class="col-sm-6">
										<div class="row">
											<div class="col-4">
												<label for="newSelectDslam" class="col-form-label">Назва плати:</label>
											</div>
											<div class="col-8">
												<select id="newSelectDslam" name="new_id_dslam" class="form-select">
													<option value=""></option>
													<?php
													$d = mysqli_query($connect, "SELECT *, (nomer_dslam * 1) AS n_dslam FROM name_dslam ORDER BY n_dslam");
													while ($row = mysqli_fetch_array($d)) {

														//$val++;
														if ($row["name_dslam"] == 'PL-xorol-eci-m82-s1') {
															$row["name_dslam"] = $row["name_dslam"] . "&nbsp;/&nbsp;" . "слот&nbsp;" . $row["nomer_slota"];
														}

														print "<option value=$row[id]>$row[nomer_dslam]&nbsp;>&nbsp;$row[name_dslam]&nbsp;|&nbsp;$row[cross_name]</option>\n";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<div class="col-4">
												<label for="newAdslPort" class="col-form-label">Номер порта:</label>
											</div>
											<div class="col-3">
												
												<select id="newAdslPort" name="new_port_adsl" class="form-select">
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
								<div class="row mb-2">
									<!-- type connections adsl,vpn, etc -->
									<div class="col-sm-6">
										<div class="row align-items-center">
											<div class="col-4">
												Тип підключення
											</div>
											<div class="col-8 d-flex">
												<div class="d-flex align-items-center me-3">
													<input id="newAdsl" class="form-check-input  mt-0 me-2" type="radio" name="new_type_client" value="ADSL">
													<label for="newAdsl" class="col-form-label">ADSL</label>
												</div>
												<div class="d-flex align-items-center me-3">
													<input id="newMpls" class="form-check-input  mt-0 me-2" type="radio" name="new_type_client" value="MPLS">
													<label for="newMpls" class="col-form-label">MPLS</label>
												</div>
												<div class="d-flex align-items-center">
													<input id="newNoTypeClient" class="form-check-input  mt-0 me-2" type="radio" name="new_type_client" value="" checked>
													<label for="newNoTypeClient" class="col-form-label">немає</label>
												</div>
											</div>

										</div>
									</div>
									<!-- ./type connections adsl,vpn, etc -->

									<!-- type auth dhcp, pppoe -->
									<div class="col-sm-6">
										<div class="row align-items-center">
											<div class="col-4">
												Тип авторизації
											</div>
											<div class="col-8 d-flex">
												<div class="d-flex align-items-center me-3">
													<input id="newDhcp" class="form-check-input  mt-0 me-2" type="radio" name="new_type_connection" value="DHCP">
													<label for="newDhcp" class="col-form-label">DHCP</label>
												</div>
												<div class="d-flex align-items-center me-3">
													<input id="newPppoe" class="form-check-input  mt-0 me-2" type="radio" name="new_type_connection" value="PPPoE">
													<label for="newPppoe" class="col-form-label">PPPoE</label>
												</div>
												<div class="d-flex align-items-center">
													<input id="newNoTypeConnection" class="form-check-input  mt-0 me-2" type="radio" name="new_type_connection" value="" checked>
													<label for="newNoTypeConnection" class="col-form-label">немає</label>
												</div>

											</div>
										</div>
									</div>
									<!-- ./type auth dhcp, pppoe -->
								</div>
							</div>

							<div class="tab-pane fade" id="tabGpon" role="tabpanel" aria-labelledby="gpon-tab">
								<div class="row my-2">
									<div class="col-sm-8">
										<div class="row">
											<div class="col-2">
												<label for="newSelectGpon" class="col-form-label">Сплітер:</label>
											</div>
											<div class="col-10">

												<select id="newSelectGpon" name="new_id_gpon" class="form-select">
													<option value=""></option>
													<?php

													$d = mysqli_query($connect, "SELECT *, gpon.id AS g_id FROM gpon LEFT JOIN np ON np.id = id_gpon_np LEFT JOIN street ON street.id = id_gpon_street ORDER BY np_name, street_name, gpon_building_number");
													while ($row = mysqli_fetch_array($d)) {

														print "<option value=$row[g_id]>$row[np_name],&nbsp;$row[street_name],&nbsp;б.$row[gpon_building_number]&nbsp;|&nbsp;$row[gpon_splitter]</option>\n";
													}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="row">
											<div class="col-5">
												<label for="newGponPort" class="col-form-label">Номер порта:</label>
											</div>
											<div class="col-3">
												
												<select id="newGponPort" name="new_port_gpon" class="form-select">
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
							<div class="tab-pane fade" id="tabFttb" role="tabpanel" aria-labelledby="fttb-tab">
								<div class="row my-2">
									<p>FTTB Comming soon...</p>
								</div>
							</div>
						</div>

						<h5 class="pt-2 border-top">Примітка</h5>
						<div class="row mb-2">
							<div class="col-sm-12">
								<textarea name="new_note" class="form-control"></textarea>

							</div>
						</div>

					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відмінити</button>
					<button class="btn btn-primary" type="submit" id="btnNewClientFormSubmit">Зберегти</button>
				</div>
			</div>
		</div>
	</div>
	<!-- ./ add new client -->

	<!-- add changelog -->
	<div class="modal fade" id="addChangeLog" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="admin.php?mode=10&groupid=<?= $group_id ?>" method="POST">

				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Додавання змін у версії</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="newVersion" class="col-form-label">Нова версія:</label>
							</div>
							<div class="col-sm-10">
								<input id="newVersion" class="form-control" type=text value="" name="new_version">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<label for="newLog" class="col-form-label">Що зроблено:</label>
							</div>
							<div class="col-sm-10">
								<textarea id="newLog" class="form-control" type=text value="" name="new_changelog" style="height: 100px;"></textarea>
							</div>
						</div>







					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

						<button class="btn btn-primary" type="submit">Додати</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./add changelog -->

	<!-- add user -->
	<div class="modal fade" id="addNewUser" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="admin.php?mode=11&groupid=<?= $group_id ?>" method="POST">

				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Додавання користувача</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">
						<div class="row align-items-center mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-3">
										<label for="newUser" class="col-form-label">Прізвище, ініціали:</label>
									</div>
									<div class="col-sm-9">
										<input id="newUser" class="form-control" type=text value="" minlength="3" name="new_user" required>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newPosition" class="col-form-label">Посада:</label>
									</div>
									<div class="col-sm-9">
										<input id="newPosition" class="form-control" type=text value="" name="new_position">
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newEmail" class="col-form-label">E-mail:</label>
									</div>
									<div class="col-sm-9">
										<input id="newEmail" class="form-control" type="email" value="" name="new_email">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newGroup" class="col-form-label">Група:</label>
									</div>
									<div class="col-sm-9">
										<select id="newGroup" name="new_group" class="form-select" required>
											<option value=""></option>
											<option value="1">Адміністратори</option>
											<option value="2">Чергові зміни</option>
											<option value="3">Інженери</option>
											<option value="4">Користувачі</option>
											<option value="5">ЦОА</option>
										</select>
									</div>

								</div>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newLogin" class="col-form-label">Логін:</label>
									</div>
									<div class="col-sm-9">
										<input id="newLogin" class="form-control" type="text" value="" minlength="3" required name="new_login">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newPassword" class="col-form-label">Пароль:</label>
									</div>
									<div class="col-sm-9">
										<input id="newPassword" class="form-control" type="text" value="" minlength="6" required name="new_password">
									</div>

								</div>
							</div>
						</div>








					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

						<button class="btn btn-primary" type="submit">Додати</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./add user -->

	<!-- add adsl plate -->
	<div class="modal fade" id="addAdslPlate" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<form action="admin.php?mode=14&groupid=<?= $group_id ?>" method="POST">

				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Додавання ADSL плати</h5>
						<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

						</button>
					</div>
					<div class="modal-body">

						<div class="row align-items-center mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="newNumberDslam" class="col-form-label">id DSLAM</label>
									</div>
									<div class="col-sm-8">
										<input id="newNumberDslam" class="form-control" type=text value="" name="new_dslam_id" required>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newPlateName" class="col-form-label">Назва DSLAM:</label>
									</div>
									<div class="col-sm-8">
										<input id="newPlateName" class="form-control" type=text value="" name="new_dslam_name" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newIpDslam" class="col-form-label">IP DSLAM:</label>
									</div>
									<div class="col-sm-8">
										<input id="newIpDslam" class="form-control" type="text" value="" name="new_dslam_ip">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newTotalPorts" class="col-form-label">К-сть портів:</label>
									</div>
									<div class="col-sm-8">
										<input id="newTotalPorts" class="form-control" type="text" value="" name="new_dslam_ports">
									</div>

								</div>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newSlotNumber" class="col-form-label">Номер слота:</label>
									</div>
									<div class="col-sm-8">
										<input id="newSlotNumber" class="form-control" type="text" value="" name="new_slot_number">
									</div>

								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newVendor" class="col-form-label">Vendor:</label>
									</div>
									<div class="col-sm-8">
										<input id="newVendor" class="form-control" type="text" value="" name="new_vendor">
									</div>

								</div>
							</div>
						</div>


						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="newCscsName" class="col-form-label">Назва на КРОСзі:</label>
									</div>
									<div class="col-sm-8">
										<input id="newCscsName" class="form-control" type="text" value="" name="new_cscs_name">
									</div>

								</div>
							</div>

						</div>

						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="newDslamString" class="col-form-label">Ідентифікатор:</label>
							</div>
							<div class="col-sm-10">
								<input id="newDslamString" class="form-control" type="text" value="" name="new_dslam_string">
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="newDslamNote" class="col-form-label">Примітка:</label>
							</div>
							<div class="col-sm-10">
								<textarea id="newDslamNote" class="form-control" type="text" value="" name="new_dslam_note"></textarea>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

						<button class="btn btn-primary" type="submit">Додати</button>
					</div>



				</div>
			</form>
		</div>
	</div>
	<!-- ./add adsl plate -->

	<!-- add gpon loc -->
	<div class="modal fade" id="addGponLoc" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">


			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Додавання GPON-локації</h5>
					<button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close">

					</button>
				</div>
				<div class="modal-body">
					<form action="admin.php?mode=18&groupid=<?= $group_id ?>" method="POST">
						<div class="row mb-2">
							<div class="col-sm-2">
								<label for="newGponLoc" class="col-form-label">Локація:</label>
							</div>
							<div class="col-sm-10">
								<input id="newGponLoc" class="form-control" type="text" value="" name="new_gpon_loc" required>
							</div>
						</div>

						<div class="row mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="newGponSlitter" class="col-form-label">Сплітер</label>
									</div>
									<div class="col-sm-8">
										<input id="newGponSlitter" class="form-control" type=text value="" name="new_gpon_splitter" required>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newGponSlitterPorts" class="col-form-label">Портів:</label>
									</div>
									<div class="col-sm-3">
										<input id="newGponSlitterPorts" class="form-control" type=text value="" name="new_gpon_slitter_ports" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row align-items-center mb-2">
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-4">
										<label for="newGponSettlement" class="col-form-label">Населений пункт</label>
									</div>
									<div class="col-sm-8">
										<select id="newGponSettlement" name="new_id_gpon_settlement" class="form-select" required>
											<option value=""></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM `np` ORDER by `np_name` COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["np_name"] . "</option>";
											}
											?>
										</select>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row align-items-center">
									<div class="col-sm-3">
										<label for="newGponOltIp" class="col-form-label">IP OLT:</label>
									</div>
									<div class="col-sm-8">
										<input id="newGponOltIp" class="form-control" type=text value="" name="new_gpon_olt_ip">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-4">
										<label for="newGponStreet" class="col-form-label">Вулиця</label>
									</div>
									<div class="col-sm-8">
										<select id="newLocation" name="new_gpon_id_street" class="form-select" required>
											<option value=""></option>
											<?

											$q = mysqli_query($connect, "SELECT * FROM street ORDER by street_name COLLATE utf8_unicode_ci");

											while ($row = mysqli_fetch_assoc($q)) {
												echo "<option value=\"" . $row["id"] . "\">" . $row["street_name"] . "</option>";
											}
											?>
										</select>

									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="row">
									<div class="col-sm-3">
										<label for="newGponBulding" class="col-form-label">Будинок</label>
									</div>
									<div class="col-sm-3">
										<input id="newGponBulding" class="form-control" type=text value="" name="new_gpon_bulding" required>
									</div>
									<div class="col-sm-2">
										<label for="newGponBuldingKorpus" class="col-form-label">Корп.</label>
									</div>
									<div class="col-sm-3">
										<input id="newGponBuldingKorpus" class="form-control" type=text value="" name="new_gpon_bulding_korpus" required>
									</div>
								</div>
							</div>
						</div>





					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Відміна</button>

					<button class="btn btn-primary" type="submit">Додати</button>
				</div>



			</div>
		</div>
	</div>
	<!-- ./add gpon loc -->
<?php } else {
	header("Location: /");
} ?>