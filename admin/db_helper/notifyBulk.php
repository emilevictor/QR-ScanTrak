<?php

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	// Create Goo.gl link
	
	
	//Insert what was posted from last form.
	$stmt = $conn->bindValue('INSERT INTO Notifications (email, bases) VALUES(:email, :bases)');
	$stmt->bindValue(':email', $_POST['email']);
	$stmt->bindValue(':bases', $_POST['bases']);
	
	if (!$stmt->execute()) {
		$err = $stmt->errorInfo();
		die('Error: ' . $err[2]);
	}
	echo "Successfully added notification for email: " . $_POST['email'];
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt.";
	
	echo "<br /><a href=\"../bulkNotify.php\">Back to notification adding with you</a>";
?>