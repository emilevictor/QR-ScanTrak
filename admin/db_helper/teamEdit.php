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
	$sql = "UPDATE Teams
	SET teamName='".$_POST[teamName]."',password='".$_POST[pwd]."',emergencyPhone='".$_POST[emergencyPhone]."'
	WHERE teamNum=".$_POST[teamNum]."" or die(mysql_error());
	
	if (!mysql_query($sql,$con)) {
	  die('Error: ' . mysql_error());
	}
	echo "Successfully edited team " . $_POST[teamName];
	
	mysql_close($con);
	
	echo "<br /><img src=\"images/mrbean.jpg\">";
	echo "<br />Emile says hi, Matt.";
	
	echo "<br /><a href=\"../addTeams.php\">Back to work, fool. Add some more teams.</a>";
?>