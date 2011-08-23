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
<title>Edit the HQ Notice</title>
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

	
	/******* Get the base number from URL *******/
	$baseID = $_GET['baseNum'];
	
	/******* DATABASE CONNECTION ********/
	include("db_helper/db_connect.php");
	
	$result = $conn->query("SELECT * FROM Notice WHERE noticeNum=1");
	$row = $result->fetch(PDO::FETCH_OBJ);
	echo "<h1>Edit the HQ notice to participants.</h1>";
	
	echo "<p>If you do not wish to show a notice, simply place a ! in either the title or the body. This notice is shown on the
	 score checking screen. It can be used to display warnings, requests, or advertise the location of roverblocks.</p>";
	
	/******** FORM FOR CURRENT FIELD DATA *********/
	
	echo "<form action=\"db_helper/noticeEdit.php\" method=\"post\">";
	echo "Title: <input type=\"text\" name=\"title\" value=\"". $row->title ."\" /><br />";
	echo "Body:<br />";
	echo "<textarea rows=\"5\" cols=\"100\" name=\"body\">".$row->body."</textarea><br/>";
	echo "<br /><input type=\"submit\" value=\"Submit New Notice\"/>";
	echo "</form>";
	
?>
<a href="index.php"> <- Back</a>
</body>
</html>