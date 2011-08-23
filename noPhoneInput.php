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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Urban Challenge :: No Phone? Input your codes here.</title>
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

#notice {
	background-color: #ff9900;
	padding: 5px 5px 5px 5px;
	color:#000;
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
</style></head>

<body>

<?php
	/******* DATABASE CONNECTION ********/
	
	include("admin/db_helper/db_connect.php");
	
	$stmt = $conn->query("SELECT noticeNum, title, body FROM Notice WHERE noticeNum = 1");
	$noticeRow = $stmt->fetch(PDO::FETCH_OBJ);
	
	/****** Print a notice if there is one available *******/
	if (($noticeRow->title != "!")&&($noticeRow->body != "!")) {
		echo "<div id=\"notice\">";
		echo "<h2>Notice from HQ: ".$noticeRow->title."</h2>";
		echo "<p>".$noticeRow->body."</p></div>";
	}
	
	echo "<h1>Phoneless Input Centre</h1>";
	
	echo "<p>You can input codes you've collected from labels here. Input up to 10 at a time.<br />Your team number and password will be provided to you by UC administrators.
	<br />If you need help, ask personell at a Hub. <strong>PLEASE NOTE THAT ALL CODES ARE CASE SENSITIVE ONLY</strong></p>";
	
	echo "<form action=\"helper/checkCodes.php\" method=\"post\">";
	
	echo "ID Number: <input type=\"text\" name=\"tNum\" placeholder=\"e.g. 42.\"/><br />";
	echo "Password: <input type=\"password\" name=\"pwd\" placeholder=\"Your password please!\"/><br /><br />";
	
	echo "Code 1: <input type=\"text\" name=\"1\" placeholder=\"optional\"/> E.g: \"QBFB2Fc1tXk\"<br />";
	echo "Code 2: <input type=\"text\" name=\"2\" placeholder=\"optional\" /><br />";
	echo "Code 3: <input type=\"text\" name=\"3\" placeholder=\"optional\" /><br />";
	echo "Code 4: <input type=\"text\" name=\"4\" placeholder=\"optional\" /><br />";
	echo "Code 5: <input type=\"text\" name=\"5\" placeholder=\"optional\" /><br />";
	echo "Code 6: <input type=\"text\" name=\"6\" placeholder=\"optional\" /><br />";
	echo "Code 7: <input type=\"text\" name=\"7\" placeholder=\"optional\" /><br />";
	echo "Code 8: <input type=\"text\" name=\"8\" placeholder=\"optional\" /><br />";
	echo "Code 9: <input type=\"text\" name=\"9\" placeholder=\"optional\" /><br />";
	echo "Code 10: <input type=\"text\" name=\"10\" placeholder=\"optional\" /><br />";
	echo "<br /><input type=\"submit\" />";
	echo "</form>";
	echo "<a href=\"http://www.qldrovers.org.au/\"><img src=\"images/QLDRovers.jpg\"></a>&nbsp;<a href=\"http://www.scoutsqld.com.au/\"><img src=\"images/ScoutsQLD.jpg\"></a>
	<p><small>System written in PHP by <a href=\"http://www.facebook.com/pages/St-Johns-Wood-Rover-Crew/141056449255004\">St John's Wood Rover</a> Emile Victor.</small></p>";
	
	
	

	
?>
</body>
</html>