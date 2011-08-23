<?php 
	/* QR Scan Tracker (QRST)
	 * @author by Emile Victor
	 * Originally written for Scouts Queensland, Urban Challenge 2011.
	 * Utilises PHP, Javascript and MySQL.
	 * This script is free to distribute, and use for non-commercial
	 * purposes. For commercial use, please contact the author
	 * via email (e@mediahug.com). Donations are also appreciated:
	 * paypal: emilevictor@gmail.com
	 * 
	 * Please contact me if you are using this script - I am always
	 * interested to know how this work is being used. I am currently
	 * a student, so feedback (and money!) is appreciated.
	 * 
	 * Address: http://www.mediahug.com/
	 */

	//Check the authentication
	include("db_helper/checkForAuthentication.php");
?>

<html>
<head>
<title>Edit a Base</title>
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
<a href="addBases.php"> <- Back</a>
<?php

	
	/******* Get the base number from URL *******/
	$baseID = $_GET['baseNum'];
	
	/******* DATABASE CONNECTION ********/
	include("db_helper/db_connect.php");
	
	$result = mysql_query("SELECT * FROM Bases WHERE baseID='". $baseID ."'");
	$row = mysql_fetch_array($result);
	echo "<h1>Edit \"". $row['baseName']."\"</h1>";
	
	/******** FORM FOR CURRENT FIELD DATA *********/
	
	echo "<form action=\"db_helper/baseEdit.php\" method=\"post\">";
	echo "Base/QR Code Name: <input type=\"text\" name=\"baseName\" value=\"". $row['baseName'] ."\" /><br />";
	echo "Base Password (the URL of the base): <input type=\"text\" name=\"pwd\" value=\"". $row['basePassword'] ."\" /><br />";
	echo "Base Scan Points: <input type=\"text\" name=\"baseScanPoints\" value=\"". $row['baseScanPoints'] ."\" /><br />";
	echo "Base Trivia (to be displayed as question):<br />";
	echo "<textarea rows=\"5\" cols=\"100\" name=\"baseTrivia\">".$row['baseTrivia']."</textarea><br/>";
	echo "Multi-choice answer (1,2,3,4?): <input type=\"text\" name=\"baseAnswer\" /><br />";
	echo "Latitude (decimal): <input type=\"text\" name=\"lat\" value=\"". $row['lat'] ."\" /><br />";
	echo "Longitude (decimal): <input type=\"text\" name=\"long\" value=\"". $row['longitude'] ."\" /><br />";
	echo "<input type=\"hidden\" name=\"baseID\" value=\"".$baseID."\">";
	echo "<br /><input type=\"submit\" value=\"Edit Base\"/>";
	echo "</form>";
	
?>
<a href="addBases.php"> <- Back</a>
</body>
</html>