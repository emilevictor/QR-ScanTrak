<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Challenge - Check points for your team.</title>
<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
}

a:link {
	color:#FC0;	
}

a:visited {
	color:#FC0;	
}

a:active {
	color:#FC0;	
}

h2 {
	color: red;
}

a:hover {
	color:#FF0;	
}
-->
</style></head>

<body>

<?php
	
	if ($_GET['success'] == "epicfail") {
		echo "<h2>Epic fail: Fat man is not amused. Your password was WRONG!</h2>";
		echo "<img src=\"images/fatMan.jpg\"><br /><br />";
	}
	/******* DATABASE CONNECTION ********/
	include("admin/db_helper/db_connect.php");
  
	echo "<img src=\"images/UCLogoInverted.jpg\"><br />";
	echo "<h1>Check your team's score</h1>";
	echo "<form action=\"helper/returnPoints.php\" method=\"post\">";
	echo "ID Number: <input type=\"text\" name=\"tNum\" /><br />";
	echo "Team Password: <input type=\"password\" name=\"pwd\" /><br />";
	echo "<br /><input type=\"submit\" />";
	echo "</form>";
	echo "<br />";
	echo "<a href=\"http://www.qldrovers.org.au/\"><img src=\"images/QLDRovers.jpg\"></a>&nbsp;<a href=\"http://www.scoutsqld.com.au/\"><img src=\"images/ScoutsQLD.jpg\"></a>
	<p><small>System written in PHP by <a href=\"http://www.facebook.com/pages/St-Johns-Wood-Rover-Crew/141056449255004\">St John's Wood Rover</a> Emile Victor.</small></p>";

?>
</body>
</html>