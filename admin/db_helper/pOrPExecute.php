<?php

	//Check the authentication
	include("checkForAuthentication.php");


	//Attempt connection to UC2011 database
	$con = mysql_connect("localhost","xitanto_uc2011","3f8923hfsjkljaJKJ");
	
	//If it fails...
	if (!$con) {
		die('Couldn\'t connect to the UC2011 database: ' . mysql_error());
	}
	
	//Select the database
	mysql_select_db("xitanto_urbanchallenge2011", $con);
	
	//Insert what was posted from last form.
	
	$baseScanPoints = $_POST['baseScanPoints'];
	$lastname = $_SESSION['lastname'];
	$comment = $_POST['comment'];
	
	if (preg_match("/[^0-9]/", $_POST['teamNum'])) {
		echo "Your team number has an illegal character in it. Only numbers are allowed.";
		mysql_close($con);
		die();
	}
	
	if (preg_match("/[^-0-9]/", $_POST['baseScanPoints'])) {
		echo "You specified a number of scan points which has an illegal character.";
		mysql_close($con);
		die();
	}
	
	if ($_POST['comment'] == "") {
		echo "You did not specify a comment. You must specify a comment for a points addition or subtraction for accountability reasons.";
		mysql_close($con);
		die();
	}
	
	
	mysql_query("INSERT INTO Timestamps (timestamp, teamNum, baseScanPoints, comment)
				VALUES (NOW(), '" . $_POST['teamNum'] . "', '" . $_POST['baseScanPoints'] . "','".$_SESSION['lastname'].": ". $_POST['comment'] . "')") or die(mysql_error());
	
	
	
	/******* Update team's total in database ********/
	$result = mysql_query("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum='" . $_POST['teamNum'] . "' GROUP BY teamNum") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$totalScore = $row['SUM(baseScanPoints)'];
	$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['teamNum']."'");
	$row = mysql_fetch_array($result);
	mysql_query("UPDATE Teams SET totalScore='".$totalScore."' WHERE teamNum='".$_POST['teamNum']."'")  or die(mysql_error());
	
	if ($_POST[baseScanPoints] < 0) {
		echo "Successfully punished team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
	} else {
		echo "Successfully pleased team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
	}

	mysql_close($con);
	
	echo "<br /><a href=\"../pleaseOrPunish.php\">Back to the please or punish page.</a>";
?>