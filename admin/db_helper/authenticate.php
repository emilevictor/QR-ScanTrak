<?php

	//Attempt connection to UC2011 database
	$conn = include 'db_connect.php';
	
	// Encrypt the password sent from the form.
	$pwd = sha1($_POST['password']);
	
	//Insert what was posted from last form.
	$result = $conn->prepare("SELECT * FROM Admins WHERE username=:user AND password=:pass");
	$result->bindValue(':user', $_POST[username]);
	$result->bindValue(':pass', $pwd);
	$result->execute();
	
	$row = $result->fetch(PDO::FETCH_OBJ);
	
	// If username doesn't exist
	if($result->rowCount() === 0) {
		/*Wrong password/username combo*/
		header('Location: ../login.php?success=wrongcredentials');
		die();
	} else {
		/*Access granted*/
		session_start();
  		header("Cache-control: private");
  		$_SESSION["access"] = "granted";
  		$_SESSION["lastname"] = $row->lastName;
  		$_SESSION["gender"] = $row->gender;
  		header("Location: ../index.php");
		die();
	}

?>
