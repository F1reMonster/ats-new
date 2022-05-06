<?php
require_once("config.php");
if (isset($_POST['id']) && $_POST['id'] != "") {
	
	$id_gpon = $_POST['id'];
	
	$q = mysqli_fetch_assoc(mysqli_query($connect, "SELECT gpon_slitter_ports FROM gpon WHERE id = $id_gpon"));
?>
	<select id="select_gpon_port1" name="port_number" class="form-select">
		<option value="" selected="selected"></option>
		<?php
		for ($i = 1; $i <= $q["gpon_slitter_ports"]; $i++) {

			$w = mysqli_fetch_assoc(mysqli_query($connect, "SELECT id_gpon, port_number FROM db_ats WHERE id_gpon = $id_gpon AND port_number = $i"));
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