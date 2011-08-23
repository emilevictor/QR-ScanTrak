<?php
	$url = "";
	if ($_POST[teamNum] != "") {
		$url .= "?teamNum=".$_POST[teamNum];
	}
	if (($_POST[baseID] != "")&&($_POST[teamNum] != "")) {
		$url .= "&baseID=".$_POST[baseID];
	} else if ($_POST[baseID]) {
		$url .= "?baseID=".$_POST[baseID];
	}
	if (($_POST[comment] != "")&&(($_POST[teamNum] != "")||($_POST[baseID] != ""))) {
		$url .= "&comment=".$_POST[comment];
	} else if ($_POST[comment]) {
		$url .= "?comment=".$_POST[comment];
	}
	/* Send the user back to the timestamps paginated page */
	header("Location: ../timestamps_paginated.php".$url."");
?>