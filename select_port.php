<?php
require_once("config.php");
if (isset($_POST['id']) && $_POST['id'] != "") {
	$id_dslam = $_POST['id'];
	$q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT total_ports FROM name_dslam WHERE id = $id_dslam"));
?>
	<select id="select_porta" name="port_number" class="form-select">
		<option value="5464" selected="selected"></option>
		<?php
		for ($i = 1; $i <= $q["total_ports"]; $i++) {

			$w = mysqli_fetch_assoc(mysqli_query($connect, "SELECT id_dslam, port_number FROM db_ats WHERE id_dslam = $id_dslam AND port_number = $i"));
			if ($w["port_number"] == $i) {
				$s = 'disabled';
			} else {
				$s = '';
			}
			echo "<option $s value=" . $i . ">" . $i . "</option>\n";
		}
		?>
	</select>

<?php
}
?>