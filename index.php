<?php
session_start();
require_once('config.php');
require_once('head.php');
?>

<div class="container">
	<?php
	//require_once('err_check.php');
	if ($_POST['logout']) {
		session_unset();
		setcookie('user_id', '', 0, "/");
		// setcookie('login', '', 0, "/");
		// setcookie('password', '', 0, "/");
		setcookie('group', '', 0, "/");
		setcookie('name', '', 0, "/");
		$_POST = [];
		header('Location: /');
	}

	if ($_POST) {
		$login = $_POST['login'];

		$auth = mysqli_query($connect, "SELECT salt FROM users WHERE `login` = '$login' LIMIT 1");

		if (mysqli_num_rows($auth) == 1) {
			$row = mysqli_fetch_assoc($auth);
			$salt = $row['salt'];
			$password = md5(md5($_POST['password']) . $salt);

			$auth1 = mysqli_query($connect, "SELECT * FROM users WHERE `login` = '$login' AND `password` = '$password' LIMIT 1");

			if (mysqli_num_rows($auth1) == 1) {
				$row1 = mysqli_fetch_assoc($auth1);
				$login_row = $row1['login'];
				$password_row = $row1['password'];
				// $_SESSION['user_id'] = $row1['id'];
				// $_SESSION['login'] = $row1['login'];
				// $_SESSION['password'] = $row1['password'];
				// $_SESSION['group_id'] = $row1['group'];
				// $_SESSION['name'] = $row1['fio'];

				$cookie_time = 86400; // ставим куку на сутки

				if (isset($_POST['remember'])) {
					setcookie('user_id', $row1['id'], time() + $cookie_time, "/");
					// setcookie('login', $row1['login'], time() + $cookie_time, "/");
					// setcookie('password', $row1['password'], time() + $cookie_time, "/");
					setcookie('group', $row1['group'], time() + $cookie_time, "/");
					setcookie('name', $row1['user_name'], time() + $cookie_time, "/");
				}
				header('Location: /');
			}
		}
	}




	if (!$_COOKIE['user_id']) {

		require_once('auth_form.php');
	} else {

		$query = mysqli_query($connect, "SELECT *, d.id as id_ats
					FROM db_ats d
					LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
					LEFT JOIN street ON street.id = d.id_ul
					LEFT JOIN np ON np.id = d.id_np
					LEFT JOIN gpon ON gpon.id = d.id_gpon
					ORDER BY date_edit DESC LIMIT 14");

		require_once('header.php');
		require_once('search-form.php');
	?>

		<div class="block block__table">
			<h3><?= $table_title ?></h3>
			<table class="table table-striped align-middle table__hovered">
				<?= $table_head ?>

				<tbody>

					<?php


					while ($line = mysqli_fetch_assoc($query)) {

						$tootip_gpon = $line['phone'];

						if ($search) {

							switch ($what) {
								case 0: {
										$string1 = "<span style=\"font-weight: 500; color: red;\">" . $search . "</span>";
										$line['phone'] = mb_ereg_replace($search, $string1, $line['phone']);
										break;
									}
								case 1: {
										$search = mb_strtoupper($search, 'utf-8');
										$string1 = "<span style=\"font-weight: 500; color: red;\">" . $search . "</span>";
										$line['client'] = mb_strtoupper($line['client'], 'utf-8');
										$line['client'] = mb_ereg_replace($search, $string1, $line['client']);
										break;
									}
								case 2: {
										$search = mb_strtoupper($search, 'utf-8');
										$string1 = "<span style=\"font-weight: 500; color: red;\">" . $search . "</span>";
										$line['street_name'] = mb_strtoupper($line['street_name'], 'utf-8');
										$line['street_name'] = mb_ereg_replace($search, $string1, $line['street_name']);
										break;
									}
								case 3: {
										$string1 = "<span style=\"font-weight: 500; color: red;\">" . $search . "</span>";
										$line['line_data'] = mb_ereg_replace($search, $string1, $line['line_data']);
										break;
									}
							}
						}
						print "
						<tr class=\"table__row\" onclick=\"javascript:document.location.href='client.php?id=" . $line['id_ats'] . "'\" style=\"cursor:pointer\">";

						if ($line["id_gpon"]) {

							print "<th scope=\"row\"><div class=\"text-break text-wrap\" style=\"width: 150px; font-size: 14px;\">" . $line['phone'] . "</div></th>";
						} else {
							print "<th scope=\"row\">" . $line['phone'] . "</th>";

						}

						

						if ($line['line_data'] && $line['cross_data']) {
							print "<td>" . $line['line_data'] . " | " . $line['cross_data'] . "</td>";
						}

						if ($line['line_data'] && !$line['cross_data']) {
							print "<td>" . $line['line_data'] . "</td>";
						}

						if (!$line['line_data'] && $line['cross_data']) {
							print "<td>" . $line['cross_data'] . "</td>";
						}

						if (!$line['line_data'] && !$line['cross_data'] && $line['status'] == 0) {
							print "<td></td>";
						}

						if (!$line['line_data'] && !$line['cross_data'] && $line['status'] == 1) {
							echo "<td><div data-tooltip=\"tooltip\" data-bs-placement=\"bottom\" title=\"Відключений\" class=\"d-inline text-danger\"><i class=\"fa-solid fa-triangle-exclamation fs-4\"></i></div></td>";
						}

						print "<td>" . $line['client'] . "</td><td>";

						if ($line["np_name"]) {
							if ($line['street_name'] || $line['nomer_doma'] || $line['korpus'] || $line['kv']) {
								echo $line['np_name'] . ", ";
							} else {
								echo $line['np_name'];
							}
						}


						if ($line['street_name']) {
							echo $line['street_name'];
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
						print "</td></tr>";
					}

					?>

				</tbody>
			</table>
		</div>


	<?php

	}

	require_once('footer.php');

	?>
</div>
<?php
require_once('scripts.php');
?>



</body>

</html>