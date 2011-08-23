<?php
$con = mysql_connect("localhost","xitanto_uc2011","3f8923hfsjkljaJKJ");
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	
  	mysql_select_db("xitanto_urbanchallenge2011", $con);
  	
  	$result = mysql_query("DELETE FROM Teams WHERE teamNum='" . $_GET['teamNum'] . "'");  	
  	
  	if (!$result) {
  		echo "I was unable to delete team" . $_GET['teamNum'];
  		die("<a href=\"../addTeams.php\">Back to team adding with you!</a>");
  	}
  	
  	mysql_close($con);
  	echo "<img src=\"images/nuclear_bomb.jpg\"><br />";
  	echo "<h2>Target neutralised.</h2>";
  	echo "<a href=\"../addTeams.php\">Back to team adding with you!</a>";
?>