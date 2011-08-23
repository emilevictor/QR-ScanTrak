<?php 
	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>
<head>
<title>Bulk Notify</title>
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

a:hover {
	color:#FF0;	
}
-->
</style>
</head>
<body>
<a href="index.php"> <- Back</a>
<?php

	
	/******* DATABASE CONNECTION ********/
	include("db_helper/db_connect.php");
	
	$result = mysql_query("SELECT * FROM Bases WHERE baseID='". $baseID ."'");
	$row = mysql_fetch_array($result);
	echo "<h1>Bulk Notify</h1>";
	
	/******** FORM FOR CURRENT FIELD DATA *********/
	
	echo "<form action=\"db_helper/notifyBulk.php\" method=\"post\">";
	echo "Email address: <input type=\"text\" name=\"email\" value=\"\" /><br />";
	echo "Enter bases, separated by commas. No trailing comma please. Example provided:<br />";
	echo "<textarea rows=\"5\" cols=\"100\" name=\"bases\">20,21,22,23,24,25</textarea><br/>";
	echo "<br /><input type=\"submit\" value=\"Add Notifier\"/>";
	echo "</form>";
	
?>
<a href="index.php"> <- Back</a>
</body>
</html>