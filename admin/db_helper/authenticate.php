<?php

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	// Encrypt the password sent from the form.
	$pwd = sha1($_POST['password']);
	
	//Insert what was posted from last form.
	$result = mysql_query("SELECT * FROM Admins
	WHERE username='".$_POST[username]."' AND password='".$pwd."'") or die(mysql_error());
	
	$row = mysql_fetch_array($result);
	
	// If username doesn't exist
	if(mysql_num_rows($result) == 0) {
		/*Wrong password/username combo*/
		header('Location: ../login.php?success=wrongcredentials');
		die();
	} else {
		/*Access granted*/
		session_start();
  		header("Cache-control: private");
  		$_SESSION["access"] = "granted";
  		$_SESSION["lastname"] = $row['lastName'];
  		$_SESSION["gender"] = $row['gender'];
  		header("Location: ../index.php");
		die();
	}
	
	
	mysql_close($con);

?>