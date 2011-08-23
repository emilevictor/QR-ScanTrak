<?php
	include("../db_connect.php");
	
	$sql = "SELECT * FROM Timestamps WHERE baseID IS NOT NULL ORDER BY timestamp DESC LIMIT 30";
	
	$result = mysql_query($sql);
	
	$arr = array();
	
	/* Fill array */
	
	while($baseTableRow = mysql_fetch_array($result)) {
		$newSql = "SELECT * FROM Bases WHERE baseID='".$baseTableRow['baseID']."'";
		$newResult = mysql_query($newSql);
		$newRow = mysql_fetch_assoc($newResult);
		$arr[] = $newRow;
	}
	
	mysql_close($con);
	
	$encoded = json_encode($arr);
	
	die($encoded);
	

?>