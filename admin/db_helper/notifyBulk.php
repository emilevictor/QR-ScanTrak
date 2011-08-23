<?php

	//Attempt connection to UC2011 database
	include("db_connect.php");
	
	// Create Goo.gl link
	
	
	//Insert what was posted from last form.
	$sql = "INSERT INTO Notifications (email, bases)
	VALUES('$_POST[email]','$_POST[bases]')";
	
	if (!mysql_query($sql,$con))
	  {
	  die('Error: ' . mysql_error());
	  }
	echo "Successfully added notification for email: " . $_POST[email];
	
	mysql_close($con);
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt.";
	
	echo "<br /><a href=\"../bulkNotify.php\">Back to notification adding with you</a>";
?>