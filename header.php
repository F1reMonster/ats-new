<?php
$username = $_COOKIE['name'];
$userid = $_COOKIE['user_id'];
$group_id = $_COOKIE['group'];

if ($group_id == 1) $namegroup = "<span class=\"text-danger\">Адміністратори</span>";
if ($group_id == 2) $namegroup = "<span class=\"text-success\">Чергові зміни</span>";
if ($group_id == 3) $namegroup = "<span class=\"text-primary\">Інженери</span>";
if ($group_id == 4) $namegroup = "<span class=\"text-secondary\">Користувачі</span>";
if ($group_id == 5) $namegroup = "<span class=\"text-warning\">ЦОА</span>";
?>

<header class="header">
	<div class="header__wrapper">
		<div class="header__logo-wrapper">
			<a href="index.php" class="header__logo fw-bold me-3">
				<div class="header__logo-icon">
					<svg xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 48 48" fill="none">
						<rect width="48" height="48" fill="white" fill-opacity="0.01" />
						<path d="M24 36V30" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M20 40H6" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M28 40H42" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M28 40C28 42.2091 26.2091 44 24 44C21.7909 44 20 42.2091 20 40C20 37.7909 21.7909 36 24 36C26.2091 36 28 37.7909 28 40Z" fill="#2F88FF" stroke="black" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M39 9V25C39 27.7614 32.2843 30 24 30C15.7157 30 9 27.7614 9 25V9" fill="#fffb00" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M39 17C39 19.7614 32.2843 22 24 22C15.7157 22 9 19.7614 9 17" fill="#fffb00" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M39 9C39 11.7614 32.2843 14 24 14C15.7157 14 9 11.7614 9 9C9 6.23858 15.7157 4 24 4C32.2843 4 39 6.23858 39 9Z" fill="#2F88FF" />
						<path d="M39 9C39 11.7614 32.2843 14 24 14C15.7157 14 9 11.7614 9 9C9 6.23858 15.7157 4 24 4C32.2843 4 39 6.23858 39 9Z" fill="#2F88FF" />
						<path d="M39 9C39 11.7614 32.2843 14 24 14C15.7157 14 9 11.7614 9 9C9 6.23858 15.7157 4 24 4C32.2843 4 39 6.23858 39 9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						<path d="M39 9C39 11.7614 32.2843 14 24 14C15.7157 14 9 11.7614 9 9C9 6.23858 15.7157 4 24 4C32.2843 4 39 6.23858 39 9Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>

				<?= $sitename . " " . $version ?>
			</a>
			<?php
			// таймер відображення що версія нова -> тривалість 30 днів
			$today = time();
			$q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `changelog` ORDER BY `id` DESC LIMIT 1"));
			if ($today - $q['date'] < 604800) {

			?>
				<div class="header__logo-new" data-tooltip="tooltip" data-bs-placement="bottom" title="нова версія">
					<a href="info.php?m=4">
						<i class="fa-solid fa-cog fa-spin text-warning"></i>

					</a>
				</div>
			<?php	} ?>
		</div>




		<div class="header__action">
			<div class="header__menu">

				<div class="header__menu-item dropdown">
					<a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						Довідники
					</a>
					<ul class="dropdown-menu">
						<li>
							<a class="dropdown-item d-flex align-items-center" href="info.php?m=2">
								<i class="fa-solid fa-fax me-2"></i>
								<span>Довідник ADSL плат</span>
							</a>
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center" href="info.php?m=6">
								<i class="fa-solid fa-house-signal me-2"></i>
								<span>Довідник GPON локацій</span>
							</a>
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center disabled" href="#">
								<i class="fa-solid fa-arrow-right-to-city me-2"></i>
								<span>Довідник FTTB локацій</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center disabled" href="#">
								<i class="fa-solid fa-city me-2"></i>
								<span>Довідник населених пунктів</span>
							</a>
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center disabled" href="#">
								<i class="fa-solid fa-tree-city me-2"></i>
								<span>Довідник вулиць</span>
							</a>
						</li>
						<li>
							<hr class="dropdown-divider">
						</li>
						<li>
							<a class="dropdown-item d-flex align-items-center" href="info.php?m=4">
								<i class="fa-solid fa-code-branch me-2"></i>
								<span>Історія версій</span>
							</a>
						</li>
						<?php if ($group_id == 1) { ?>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="info.php?m=5">
									<i class="fa-solid fa-users me-2"></i>
									<span>Довідник користувачів</span>
								</a>
							</li>
						<?php } ?>

					</ul>
				</div>


			</div>
			<div class="user">
				<div class="user__wrapper">

					<div class="user__menu dropdown">
						<a class="nav-link dropdown-toggle user__link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="fa-regular fa-user"></i>
							<div class="user__name"><?= $username ?> / <?= $namegroup ?></div>
						</a>
						<ul class="dropdown-menu">
							<?php if ($group_id == 4 || $group_id == 5) {
								$disabled = 'disabled';
							}
							?>
							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addNewClient">
									<i class="fa-solid fa-square-plus me-2"></i>
									<span>Додати новий запис</span>
								</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>


							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addAdslPlate">
									<i class="fa-solid fa-fax me-2"></i>
									<span>Додати ADSL плату</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addGponLoc">
									<i class="fa-solid fa-house-signal me-2"></i>
									<span>Додати GPON локацію </span>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addFttbLoc">
									<i class="fa-solid fa-arrow-right-to-city me-2"></i>
									<span>Додати FTTB локацію</span>
								</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addSettlement">
									<i class="fa-solid fa-city me-2"></i>
									<span>Додати населений пункт</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item d-flex align-items-center <?= $disabled ?>" href="" data-bs-toggle="modal" data-bs-target="#addStreet">
									<i class="fa-solid fa-tree-city me-2"></i>
									<span>Додати вулицю</span>
								</a>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>

							<?php if ($group_id == 1) { ?>
								<li>
									<a class="dropdown-item d-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#addNewUser">
										<i class="fa-solid fa-person-circle-plus me-2"></i>
										Додати користувача
									</a>
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#addChangeLog">
										<i class="fa-solid fa-clock-rotate-left me-2"></i>
										Додати changelog
									</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center disabled" href="#">
										<i class="fa-solid fa-file-excel me-2"></i>
										<span>Експорт в Excel</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item d-flex align-items-center<?php ($db_url) ?: ' disabled'; ?>" target="_blank" href="<?= $db_url ?>">
										<i class="fa-solid fa-table me-2"></i>
										<span>phpmyadmin</span>
									</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>


							<?php } ?>
							<li>
								<a class="dropdown-item d-flex align-items-center disabled" href="" data-bs-toggle="modal" data-bs-target="#changePassword">
									<i class="fa-solid fa-key me-2"></i>
									<span>Змінити пароль</span>
								</a>
							</li>

						</ul>
					</div>


					<div class="user__btn">
						<form action="index.php" method="POST">
							<input type="text" name="logout" value="1" hidden>
							<button class="btn btn-outline-primary" type="submit">Вихід</button>
						</form>
					</div>


				</div>

			</div>

		</div>
	</div>
</header>

<?php
require_once("addnewdata.php");
?>