<?php
	//Connect to database
	include("db_connect.php");
  	
	//Query the database
  	$result = mysql_query("DELETE FROM Bases WHERE baseID='" . $_GET['baseNum'] . "'");  	
  	
  	if (!$result) {
  		echo "I was unable to delete base " . $_GET['baseNum'];
  		die("<a href=\"../addBases.php\">Back to team adding with you!</a>");
  	}
  	header("Location: ../addBases.php");
  	mysql_close($con);
?>