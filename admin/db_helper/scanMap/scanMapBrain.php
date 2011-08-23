<?php
	include("../db_connect.php");
	
	$result = $conn->prepare("SELECT * FROM Timestamps WHERE baseID IS NOT NULL ORDER BY timestamp DESC LIMIT 30");
	
	$arr = array();
	
	/* Fill array */
	$basestmt = $conn->prepare('SELECT * FROM Bases WHERE baseID=:id');


	foreach($result->fetchAll(PDO::FETCH_OBJ) as $baseTableRow) {
		$basestmt->bindValue(':id', $baseTableRow->baseID);
		$basestmt->execute();
		$arr[] = $basestmt->fetch(PDO::FETCH_ASSOC);
	}
	echo json_encode($arr);
	
	die();
	

?>