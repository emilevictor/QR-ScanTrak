<?php
	//Connect to the database with PDO, provide a connection.
	$conn = include 'db_connect.php';
	
	//Insert what was posted from last form.
	$stmt = $conn->prepare('INSERT INTO Teams (teamName, password, emergencyPhone) VALUES(:name, :pass, :phone)');
	$stmt->bindValue(':name',  $_POST['teamName']);
	$stmt->bindValue(':pass',  $_POST['password']);
	$stmt->bindValue(':phone', $_POST['emergencyPhones']);

	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
	  die('Error: ' . $err[2]);
	  }
	echo "Successfully added team " . $_POST['teamName'];
	
	echo "<br /><a href=\"../addTeams.php\">Back to the team adding page</a>";
?>
