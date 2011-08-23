<?php

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	//Insert what was posted from last form.
	$stmt = $conn->prepare(
		'UPDATE Bases SET baseName=:name,basePassword=:pass,baseScanPoints=:pts,' . 
		'baseTrivia=:trivia,baseAnswer=:answer,lat=:lat,longitude=:long WHERE baseID=:id'
	);
	$stmt->bindValue(':name', $_POST['baseName']);
	$stmt->bindValue(':pass', $_POST['pwd']);
	$stmt->bindValue(':pts', $_POST['baseScanPoints']);
	$stmt->bindValue(':trivia', $_POST['baseTrivia']);
	$stmt->bindValue(':answer', $_POST['baseAnswer']);
	$stmt->bindValue(':lat', $_POST['lat']);
	$stmt->bindValue(':long', $_POST['long']);
	$stmt->bindValue(':id', $_POST['baseID']);

	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Could not update: ' . $err[2]);
	}
	
	header("Location: ../addBases.php?edited=yes");
?>