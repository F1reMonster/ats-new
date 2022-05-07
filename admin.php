<?php
require_once('config.php');
require_once('head.php');

$mode = $_GET['mode'];
$id = (int) $_GET['id'];
$groupid = (int) $_GET['groupid'];
$err_msg = "<div class=\"error__message error__message--with-icon\"><i class=\"icon-exclamation-sign\"></i> <span>Щось пішло не так...</span></div>";
$spinner = "<div class=\"row\">
					<div class=\"col-12 d-flex justify-content-center\">
						<div class=\"spinner-border\" style=\"width: 3rem; height: 3rem;\" role=\"status\">
							<span class=\"visually-hidden\">Loading...</span>
						</div>
					</div>
				</div>";

function saltGenerator($n = 3)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%^&-=+';
	$randomString = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($characters) - 1);
		$randomString .= $characters[$index];
	}

	return $randomString;
}

?>
<div class="container">
	<?php

	if ($_COOKIE['user_id']) {

		require_once('header.php');
		require_once('search-form.php');

		if ($group_id == 1 || $group_id == 2 || $group_id == 3) {

			$_POST = array_map('addslashes', $_POST);
			$d = date("Y-m-d H:i:s");
			$d_edit = time();

			// add new client
			if ($mode == 1) {
				// echo "mode " . $mode . " add new client <br/>";

				$new_client = mb_strtoupper($_POST["new_client"], 'utf-8');
				// echo $new_client . "<br/>";
				// echo $_POST['new_line_data'] . "<br/>";
				// echo $d . "<br/>";

				// if (!get_magic_quotes_gpc())


				// echo '<pre>';
				// print_r($_POST);
				// echo '</pre>'; 
				echo $spinner;

				if ($_POST['new_date_internet']) {
					$dateinternet = strtotime($_POST['new_date_internet']);
					$datenow = strtotime(date("d.m.Y", time()));
					$datetimenow = time();
					$timenow = $datetimenow - $datenow;
					$dateinternet = $dateinternet + $timenow;
				} else {
					$dateinternet = 0;
				}

				if ($_POST['new_date_phone']) {
					$datephone = strtotime($_POST['new_date_phone']);
				} else {
					$datephone = 0;
				}

				$id_ul = (int)$_POST['new_id_ul'];
				$id_np = (int)$_POST['new_id_settlement'];
				$nomer_doma = (int)$_POST['new_nomer_bud'];
				$kv = (int)$_POST['new_nomer_kv'];

				if ($_POST['new_port_adsl']) {
					$new_port = $_POST['new_port_adsl'];
				}
				if ($_POST['new_port_gpon']) {
					$new_port = $_POST['new_port_gpon'];
				}
				if ($_POST['new_port_fttb']) {
					$new_port = $_POST['new_port_fttb'];
				}

				mysqli_query(
					$connect,
					"INSERT INTO db_ats (
						`date_begin`, 
						`date_edit`, 
						`date_phone`,
						`phone`,
						`cross_data`,
						`linked_phone`,
						`cross_port`,
						`client`,
						`line_data`,
						`mobile_phone`,
						`ppp_login`,
						`ppp_password`,
						`tp`,
						`or_us`,
						`type_client`,
						`type_connection`,
						`note`,
						`id_np`,
						`id_ul`,
						`nomer_doma`,
						`korpus`,
						`kv`,
						`id_dslam`,
						`port_number`,
						`date_internet`,
						`id_gpon`
						)
					VALUES (
						'$d', 
						'$d_edit',
						'$datephone',
						'$_POST[new_phone]',
						'$_POST[new_cross_data]',
						'$_POST[new_linked_phone]',
						'$_POST[new_cross_port]',
						'$new_client',
						'$_POST[new_line_data]',
						'$_POST[new_mobile_phone]',
						'$_POST[new_ppp_login]',
						'$_POST[new_ppp_password]',
						'$_POST[new_tp]',
						'$_POST[new_or_us]',
						'$_POST[new_type_client]',
						'$_POST[new_type_connection]',
						'$_POST[new_note]',
						'$id_np',
						'$id_ul',
						'$nomer_doma',
						'$_POST[korpus]',
						'$kv',
						'$_POST[new_id_dslam]',
						'$new_port',
						'$dateinternet',
						'$_POST[new_id_gpon]'
						)"
				) or die("<br/>error in query of append new data " . mysqli_error($connect));


				$id = mysqli_insert_id($connect);

				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// edit client data
			if ($mode == 2) {
				echo $spinner;

				$t = mysqli_fetch_assoc(mysqli_query($connect, "SELECT date_internet FROM db_ats WHERE id  = $id"));

				// дата підключення в форматі часу unix
				if ($_POST['d_internet']) {
					$dateinternet = strtotime($_POST['d_internet']);

					if ($t['date_internet'] == 0) {

						$datetimenow = time();
						$datenow = strtotime(date("d.m.Y", $datetimenow));
						$time = $datetimenow - $datenow;
					} else {
						//$datetimenow = time ();
						$datenow1 = strtotime(date("d.m.Y", $t['date_internet']));
						$time = $t['date_internet'] - $datenow1;
					}

					$dateinternet = $dateinternet + $time;
				} else {
					$dateinternet = 0;
				}

				if ($_POST['d_phone']) {
					$datephone = strtotime($_POST['d_phone']);
				} else {
					$datephone = 0;
				}

				$client = mb_strtoupper($_POST["client"], 'utf-8');
				$id_ul = (int)$_POST['id_ul'];
				$nomer_doma = (int)$_POST['nomer_bud'];
				$kv = (int)$_POST['kv'];
				if ($_POST['edit_port_adsl']) {
					$edit_port = $_POST['edit_port_adsl'];
				}
				if ($_POST['edit_port_gpon']) {
					$edit_port = $_POST['edit_port_gpon'];
				}
				if ($_POST['edit_port_fttb']) {
					$edit_port = $_POST['edit_port_fttb'];
				}

				mysqli_query($connect, "UPDATE db_ats SET
					`phone` = '" . $_POST['phone'] . "',
					`linked_phone` = '" . $_POST['linked_phone'] . "',
					`mobile_phone` = '" . $_POST['mobile_phone'] . "',
					`client` = '" . $client . "',
					`line_data` = '" . $_POST['line_data'] . "',
					`cross_port` = '" . $_POST['cross_port'] . "',
					`ppp_login` = '" . $_POST['ppp_login'] . "',
					`tp` = '" . $_POST['tp'] . "',
					`or_us` = '" . $_POST['or_us'] . "',
					`or_inek` = '" . $_POST['or_inek'] . "',
					`type_client` = '" . $_POST['type_client'] . "',
					`type_connection` = '" . $_POST['type_connection'] . "',
					`note` = '" . $_POST['note'] . "',
					`ppp_password` = '" . $_POST['ppp_password'] . "',
					`id_dslam` = '" . $_POST['id_dslam'] . "',
					`id_gpon` = '" . $_POST['id_gpon'] . "',
					`cross_data` = '" . $_POST['cross_data'] . "',
					`port_number` = '" . $edit_port . "',
					`date_phone` = '" . $datephone . "',
					`date_internet` = '" . $dateinternet . "',
					`date_begin` = '" . $d . "',
					`date_edit` = '" . $d_edit . "',
					`who_edited` = '" . $_POST['who_edited'] . "',
					`id_np` = '" . $_POST['id_settlement'] . " ',
					`id_ul` = '" . $id_ul . "',
					`nomer_doma` = '" . $nomer_doma . "',
					`korpus` = '" . $_POST['korpus'] . "',
					`kv` = '" . $kv . "',
					`status` = '" . $_POST['status'] . "'
					WHERE id='$id'") or die("<br/>error in query of update data " . mysqli_error($connect));


				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// delete record
			if ($mode == 3) {
				echo $spinner;
				mysqli_query($connect, "DELETE FROM db_ats WHERE id='$id'");
				print "<script type=\"text/javascript\">window.location = \"index.php\"</script>";
			}

			// [додавання логу версій]
			if ($mode == 4) {
				// echo $_POST["datelog"] . "<br/>";
				// echo $_POST["version"] . "<br/>";
				// echo $_POST["log"] . "<br/>";
				// echo $d . "<br/>";

				echo $spinner;
				$datelog = strtotime($_POST['datelog']);
				mysqli_query($connect, "INSERT INTO changelog (`date`, `version`, `log`) VALUES ('$datelog', '$_POST[version]', '$_POST[log]')
					") or die("<br>error in query of append new data " . mysqli_error($connect));

				print "<script type=\"text/javascript\">window.location = \"changelog.php\"</script>";
			}

			// disconnect user
			if ($mode == 5) {
				// echo "id=" . $id;
				// echo "userid=" . $userid;
				echo $spinner;

				/**/
				$datenow = strtotime(date("d.m.Y", time()));
				$query = mysqli_query($connect, "SELECT *, d.id as id_ats, n.np_name as gpon_np, s.street_name as gpon_street, street.street_name as cli_street, np.np_name as cli_np
				FROM db_ats d
				LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
				LEFT JOIN street ON street.id = id_ul
				LEFT JOIN np ON np.id = id_np
				LEFT JOIN gpon ON gpon.id = id_gpon
				LEFT JOIN np n ON n.id = id_gpon_np
				LEFT JOIN street s ON s.id = id_gpon_street
				WHERE d.id = $id");

				$row = mysqli_fetch_assoc($query);


				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = '$userid'"));

				if ($row["id_dslam"]) {
					$int = "крос: $row[cross_data]<br>плата: $row[name_dslam]<br>порт:$row[port_number]";
				} 

				if ($row["id_gpon"]) {
					if ($row["gpon_building_korpus"]) {
						$gpon_building = $row["gpon_building_number"] . "/" . $row["gpon_building_korpus"];
					} else {
						$gpon_building = $row["gpon_building_number"];
					}
					$int = "локація: $row[gpon_location]<br>сплітер: $row[gpon_splitter]<br>порт на сплітері: $row[port_number]<br>адреса сплітера: $row[gpon_np], $row[gpon_street], $gpon_building";
					$row["line_data"] = "port id: ".$row["line_data"];
				}

				// $adress = $row["np_name"] . ", " . $row["street_name"] . " б." . $row["nomer_doma"] . "/" . $row["korpus"] . " кв." . $row["kv"];

				if ($row["street_name"]) {
					if ($row["nomer_doma"]) {
						$nomer_doma = " б." . $row["nomer_doma"];
					}
					if ($row["korpus"]) {
						$korpus = "/" . $row["korpus"];
					}
					if ($row["kv"]) {
						$kv = " кв." . $row["kv"];
					}

					$adress = $row["street_name"] . $nomer_doma . $korpus . $kv;
				}

				if ($row["np_name"]) {
					$adress = $row["np_name"] . ", " . $adress;
				}

				$row["client"] = addslashes($row["client"]);

				mysqli_query(
					$connect,
					"INSERT INTO history (
						`ats_id`,
						`line_data`,
						`internet`,
						`date`,
						`user`,
						`type`
					)
					VALUES (
						'$row[id_ats]',
						'$row[line_data]',
						'$int',
						'$d_edit',
						'$access[user_name]',
						'1'
						)"
				) or die("<br/>error in query of update data " . mysqli_error($connect));


				mysqli_query($connect, "UPDATE db_ats SET
					`line_data` = '',
					`cross_port` = '',
					`ppp_login` = '',
					`tp` = '',
					`type_client` = '',
					`type_connection` = '',
					`ppp_password` = '',
					`id_dslam` = '',
					`id_gpon` = '',
					`id_fttb` = '',
					`cross_data` = '',
					`port_number` = '',
					`date_phone` = '',
					`date_internet` = '',
					`date_begin` = '',
					`date_edit` = '$d_edit',
					`loc` = '',
					`who_edited` = '',
					`status` = '" . $_POST['status'] . "'
					WHERE id='$id'") or die("<br/>error in query of update data " . mysqli_error($connect));




				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// remove internet
			if ($mode == 6) {
				$datenow = strtotime(date("d.m.Y", time()));

				$query = mysqli_query($connect, "SELECT *, d.id as id_ats, n.np_name as gpon_np, s.street_name as gpon_street, street.street_name as cli_street, np.np_name as cli_np
				FROM db_ats d
				LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
				LEFT JOIN street ON street.id = id_ul
				LEFT JOIN np ON np.id = id_np
				LEFT JOIN gpon ON gpon.id = id_gpon
				LEFT JOIN np n ON n.id = id_gpon_np
				LEFT JOIN street s ON s.id = id_gpon_street
				WHERE d.id = $id");

				$row = mysqli_fetch_assoc($query);

				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = '$userid'"));

				if ($row["name_dslam"]) {

					if ($row["name_dslam"] == "PL-xorol-eci-m82-s1") {

						$row["name_dslam"] = $row["name_dslam"] . " / " . $row["nomer_slota"];
					}

					$int = "крос: $row[cross_data]<br>плата: $row[name_dslam]<br>порт:$row[port_number]";
				}

				if ($row["id_gpon"]) {
					if ($row["gpon_building_korpus"]) {
						$gpon_building = $row["gpon_building_number"] . "/" . $row["gpon_building_korpus"];
					} else {
						$gpon_building = $row["gpon_building_number"];
					}
					$int = "локація: $row[gpon_location]<br>сплітер: $row[gpon_splitter]<br>порт на сплітері: $row[port_number]<br>port id: $row[line_data]<br>адреса сплітера: $row[gpon_np], $row[gpon_street], $gpon_building";
				}

				mysqli_query(
					$connect,
					"INSERT INTO history (
								`ats_id`,
								`client`,
								`adress`,
								`line_data`,
								`internet`,
								`date`,
								`user`,
								`type`
							)
							VALUES (
								'$row[id_ats]',
								'',
								'',
								'',
								'$int',
								'$d_edit',
								'$access[user_name]',
								'2'
								)"
				) or die("<br/>error in query of update data " . mysqli_error($connect));

				if ($row["id_dslam"]) {
					mysqli_query($connect, "UPDATE db_ats SET
							`date_edit` = '$d_edit',
							`ppp_login` = '',
							`tp` = '',
							`type_client` = '',
							`type_connection` = '',
							`ppp_password` = '',
							`date_internet` = '',
							`id_dslam` = '',
							`cross_data` = '',
							`port_number` = '',
							`loc` = ''
							WHERE id='$id'") or die("<br/>error in query of update data " . mysqli_error($connect));
				}

				if ($row["id_gpon"]) {
					mysqli_query($connect, "UPDATE db_ats SET
							`date_edit` = '$d_edit',
							`ppp_login` = '',
							`tp` = '',
							`type_client` = '',
							`type_connection` = '',
							`ppp_password` = '',
							`date_internet` = '',
							`id_gpon` = '',
							`line_data` = '',
							`cross_data` = '',
							`port_number` = '',
							`loc` = ''
							WHERE id='$id'") or die("<br/>error in query of update data " . mysqli_error($connect));
				}



				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// change line data
			if ($mode == 7) {
				$data = $_POST['old_linedata'] . "<i class=\"fa-solid fa-arrow-right fs-5 mx-1\"></i>" . $_POST['linedata'];
				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = $_POST[userid]"));
				echo $spinner;

				mysqli_query($connect, "INSERT INTO history (
					`ats_id`,
					`client`,
					`adress`,
					`line_data`,
					`internet`,
					`date`,
					`user`,
					`type`
					)
					VALUES (
					'$_POST[id_ats]',
					'',
					'',
					'$data',
					'',
					'$d_edit',
					'$access[user_name]',
					'3'
				)") or die("<br/>error in query of update data " . mysqli_error($connect));

				mysqli_query($connect, "UPDATE db_ats SET `date_edit` = '$d_edit', `line_data` = '$_POST[linedata]' WHERE id='$_POST[id_ats]'") or die("<br/>error in query of update data " . mysqli_error($connect));

				print "<script type=\"text/javascript\">window.location = \"client.php?id=$_POST[id_ats]\"</script>";
			}

			// заміна ТЗ
			if ($mode == 8) {
				$data = "старий ТЗ&nbsp;" . $_POST['old_phone'];
				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = $_POST[userid]"));

				echo $spinner;

				mysqli_query($connect, "INSERT INTO history (
					`ats_id`,
					`client`,
					`adress`,
					`line_data`,
					`internet`,
					`date`,
					`user`,
					`type`
					)
					VALUES (
					'$_POST[id_ats]',
					'',
					'',
					'$data',
					'',
					'$d_edit',    
					'$access[user_name]',
					'4'
				)") or die("<br/>error in query of update data " . mysqli_error($connect));

				mysqli_query($connect, "UPDATE db_ats SET `date_edit` = '$d_edit', `phone` = '$_POST[phone]' WHERE id='$_POST[id_ats]'") or die("<br/>error in query of update data " . mysqli_error($connect));

				print "<script type=\"text/javascript\">window.location = \"client.php?id=$_POST[id_ats]\"</script>";
			}

			// ! connect after disconnect client
			if ($mode == 12) {
				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = '$userid'"));
				mysqli_query($connect, "UPDATE db_ats SET `status` = 0 WHERE `id` = $id");

				mysqli_query($connect, "INSERT INTO history (
					`ats_id`,
					`date`,
					`user`,
					`type`
					)
					VALUES (
					'$id',
					'$d_edit',
					'$access[user_name]',
					'6'
						)") or die("<br/>error in query of update data " . mysqli_error($connect));

				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// ! change adsl port
			if ($mode == 13) {
				echo $spinner;
				$access = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `user_name` FROM users WHERE id = '$userid'"));

				$query = mysqli_query($connect, "SELECT *, d.id as id_ats
						FROM db_ats d
						LEFT JOIN name_dslam ON name_dslam.id = d.id_dslam
						LEFT JOIN street ON id_ul = street.id
						LEFT JOIN np ON id_np = np.id
						WHERE d.id = $id");
				$row = mysqli_fetch_assoc($query);

				if ($row['cross_data'] && $row['name_dslam'] && $row['port_number']) {
					$int = "крос:&nbsp;$row[cross_data]<br>плата:&nbsp;$row[name_dslam]<br>порт:&nbsp;$row[port_number]";
				}

				if (!$row['cross_data'] && $row['name_dslam'] && $row['port_number']) {
					$int = "плата:&nbsp;$row[name_dslam]<br>порт:&nbsp;$row[port_number]";
				}

				mysqli_query($connect, "UPDATE db_ats SET  
				`id_dslam` = '" . $_POST['id_dslam_change'] . "', 
				`port_number` = '" . $_POST['port_number_change'] . "', 
				`cross_data` = '" . $_POST['crosz_data_change'] . "',
				`date_edit` = '" . $d_edit . "'
				WHERE `id` = $id") or die(mysqli_error($connect));

				mysqli_query($connect, "INSERT INTO history (
					`ats_id`,
					`date`,
					`internet`,
					`user`,
					`type`
					)
					VALUES (
					'$id',
					'$d_edit',
					'$int',
					'$access[user_name]',
					'5'
						)") or die("<br/>error in query of update data " . mysqli_error($connect));

				print "<script type=\"text/javascript\">window.location = \"client.php?id=$id\"</script>";
			}

			// ! new dslam
			// new_dslam_id, new_dslam_name, new_dslam_ip, new_dslam_ports, new_slot_number, new_vendor
			// new_cscs_name, new_dslam_note
			if ($mode == 14) {
				mysqli_query($connect, "INSERT INTO `name_dslam` (
					`name_dslam`,
					`ip_dslam`,
					`nomer_dslam`,
					`vendor`,
					`total_ports`,
					`cross_name`,
					`notes`,
					`string_id`
				) VALUES (
					'$_POST[new_dslam_name]',
					'$_POST[new_dslam_ip]',
					'$_POST[new_dslam_id]',
					'$_POST[new_vendor]',
					'$_POST[new_dslam_ports]',
					'$_POST[new_cscs_name]',
					'$_POST[new_dslam_note]',
					'$_POST[new_dslam_string]'
				)") or die("<br/>error in query of update data " . mysqli_error($connect));
				$id = mysqli_insert_id($connect);
				print "<script type=\"text/javascript\">window.location = \"info.php?m=3&adsl=$id\"</script>";
			}

			// update adsl plate
			if ($mode == 15) {
				echo $spinner;
				mysqli_query($connect, "UPDATE `name_dslam` SET 
					`name_dslam` = '" . $_POST["edit_dslam_name"] . "',
					`ip_dslam` = '" . $_POST["edit_dslam_ip"] . "',
					`nomer_dslam` = '" . $_POST["edit_dslam_id"] . "',
					`nomer_slota` = '" . $_POST["edit_slot_number"] . "',
					`vendor` = '" . $_POST["edit_vendor"] . "',
					`total_ports` = '" . $_POST["edit_dslam_ports"] . "',
					`cross_name` = '" . $_POST["edit_cscs_name"] . "',
					`notes` = '" . $_POST["edit_dslam_note"] . "',
					`string_id` = '" . $_POST["edit_dslam_string"] . "'
					WHERE `id` = '" . $_POST["edit_id_adsl"] . "'");

				print "<script type=\"text/javascript\">window.location = \"info.php?m=3&adsl=$_POST[edit_id_adsl]\"</script>";
			}

			// delete adsl plate
			if ($mode == 16) {
				echo $spinner;
				mysqli_query($connect, "DELETE FROM name_dslam WHERE id='$_POST[delete_adsl_plate_id]'");
				print "<script type=\"text/javascript\">window.location = \"info.php?m=2\"</script>";
			}

			// change profile
			if ($mode == 17) {
				echo $spinner;
				print "<script type=\"text/javascript\">window.open('http://10.27.2.197/php/index.php?ip=$_POST[profile_ip_dslam]&port=$_POST[profile_dslam_port]&prof=$_POST[profile_id]','_blank').focus();</script>";
				print "<script type=\"text/javascript\">window.location = \"client.php?id=$_POST[client_id]\"</script>";
			}

			// add gpon loc
			if ($mode == 18) {
				echo $spinner;
				mysqli_query($connect, "INSERT INTO `gpon` (
					`gpon_location`,
					`ip_address_olt`,
					`gpon_splitter`,
					`gpon_slitter_ports`,
					`id_gpon_np`,
					`id_gpon_street`,
					`gpon_building_number`,
					`gpon_building_korpus`
				) VALUES (
					'$_POST[new_gpon_loc]',
					'$_POST[new_gpon_olt_ip]',
					'$_POST[new_gpon_splitter]',
					'$_POST[new_gpon_slitter_ports]',
					'$_POST[new_id_gpon_settlement]',
					'$_POST[new_gpon_id_street]',
					'$_POST[new_gpon_bulding]',
					'$_POST[new_gpon_bulding_korpus]'
				)") or die("<br/>error in query of update data " . mysqli_error($connect));
				$id = mysqli_insert_id($connect);
				print "<script type=\"text/javascript\">window.location = \"info.php?m=7&gpon=$id\"</script>";
			}
		}

		// global delete record
		if ($group_id == 1 && $mode == 9) {
			echo $spinner;
			mysqli_query($connect, "DELETE FROM db_ats WHERE id='$_POST[id_ats]'");
			mysqli_query($connect, "DELETE FROM history WHERE ats_id='$_POST[id_ats]'");
			print "<script type=\"text/javascript\">window.location = \"index.php\"</script>";
		}

		// add changelog
		if ($group_id == 1 && $mode == 10) {

			$date_changelog = time();
			echo $spinner;
			mysqli_query($connect, "INSERT INTO changelog (
				`date`,
				`version`,
				`log`
				) 
				VALUES (
					'$date_changelog',
					'$_POST[new_version]',
					'$_POST[new_changelog]'
					)") or die(mysqli_error($connect));

			print "<script type=\"text/javascript\">window.location = \"info.php?m=4\"</script>";
		}

		// add new user
		if ($group_id == 1 && $mode == 11) {
			$date_registred_user = time();
			$salt = saltGenerator();
			$user_password = md5(md5($_POST['new_password']) . $salt);

			echo $spinner;
			mysqli_query($connect, "INSERT INTO users (
				`login`,
				`password`,
				`email`,
				`group`,
				`joindate`,
				`salt`,
				`user_name`,
				`position`
				) 
				VALUES (
					'$_POST[new_login]',
					'$user_password',
					'$_POST[new_email]',
					'$_POST[new_group]',
					'$date_registred_user',
					'$salt',
					'$_POST[new_user]',
					'$_POST[new_position]'
					)") or die(mysqli_error($connect));

			print "<script type=\"text/javascript\">window.location = \"info.php?m=5\"</script>";
		}
	} else {
		echo $err_msg;
	}
	?>
</div>

<?php

require_once('footer.php');
?>;