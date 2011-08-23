<?php

	include('db_connect.php');
	
	//Insert what was posted from last form.
	$stmt = $conn->prepare('UPDATE Teams SET teamName=:name,password=:pass,emergencyPhone=:phone WHERE teamNum=:id');
	$stmt->bindValue(':name',  $_POST['teamName']);
	$stmt->bindValue(':pass',  $_POST['pwd']);
	$stmt->bindValue(':phone', $_POST['emergencyPhone']);
	$stmt->bindValue(':id',    $_POST['teamNum']);
	
	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Error: ' . $err[2]);
	}
	echo "Successfully edited team " . $_POST['teamName'];
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt.";
	
	echo "<br /><a href=\"../addTeams.php\">Back to work, fool. Add some more teams.</a>";
?>