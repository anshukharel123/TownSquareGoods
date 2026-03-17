<?php
function getDbConnection() {
  $conn = oci_connect('townsquare','townsquare', 'localhost/XE');
  if (!$conn) {
			$e = oci_error();
			echo htmlentities($e['message'], ENT_QUOTES), "\n";
			exit;
	} else {
			echo "Connected to Oracle!";
	}
	oci_close($conn);
}
?>