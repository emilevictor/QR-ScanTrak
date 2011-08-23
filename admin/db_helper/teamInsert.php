<?php

	//Attempt connection to UC2011 database
	$con = mysql_connect("localhost","xitanto_uc2011","3f8923hfsjkljaJKJ");
	
	//If it fails...
	if (!$con) {
		die('Couldn\'t connect to the UC2011 database: ' . mysql_error());
	}
	
	//Select the database
	mysql_select_db("xitanto_urbanchallenge2011", $con);
	
	//Insert what was posted from last form.
	$sql = "INSERT INTO Teams (teamName, password, emergencyPhone)
	VALUES('$_POST[teamName]','$_POST[password]','$_POST[emergencyPhones]')";
	
	if (!mysql_query($sql,$con))
	  {
	  die('Error: ' . mysql_error());
	  }
	echo "Successfully added team " . $_POST[teamName];
	
	mysql_close($con);
	
	echo "<br /><a href=\"../addTeams.php\">Back to the team adding page</a>";
?>