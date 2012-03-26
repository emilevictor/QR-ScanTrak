<?php

	//Check the authentication
	include("checkForAuthentication.php");

	//Get the PDO connection for use in our PDO statements.
	$conn = include 'db_connect.php';
	
	//Insert what was posted from last form.
	$baseScanPoints = $_POST['baseScanPoints'];
	$lastname = $_SESSION['lastname'];
	$comment = $_POST['comment'];
	
	if (preg_match("/[^0-9]/", $_POST['teamNum'])) {
		echo "Your team number has an illegal character in it. Only numbers are allowed.";
		die();
	}
	
	if (preg_match("/[^-0-9]/", $_POST['baseScanPoints'])) {
		echo "You specified a number of scan points which has an illegal character.";
		die();
	}
	
	if ($_POST['comment'] == "") {
		echo "You did not specify a comment. You must specify a comment for a points addition or subtraction for accountability reasons.";
		die();
	}

	
	//Prepare the PDO statement for insertion into the database
	$stmt = $conn->prepare("INSERT INTO Timestamps (timestamp, teamNum, baseScanPoints, comment) VALUES" .
	 "(:timestamp, :teamNum, :baseScanPoints, :comment)");
	
	$stmt->bindParam(':timestamp', date('Y-m-d H:i:s'));
	$stmt->bindParam(':teamNum', $_POST['teamNum']);
	$stmt->bindParam(':baseScanPoints', $_POST['teamNum']);
	
	//The comment is essentially your last name, followed by the comment.
	$comment = $_SESSION['lastname'] . ": " . $_POST['comment'];
	
	$stmt->bindParam(':comment', $comment);	
	
	//Execute the PHP PDO statement.
	$stmt->execute();
	
	//PDO get total amount of points from database, add to it, then update database again.
	$stmt = $conn->prepare('SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum=:teamNum GROUP BY teamNum');
	$stmt->bindParam(':teamNum', $_POST['teamNum']);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	
	//Add points to their score
	$totalScore = $result['SUM(baseScanPoints)'];
	
	//This is used to get the 
	$stmt = $conn->prepare('UPDATE Teams SET totalScore=:totalScore WHERE teamNum=:teamNum');
	$stmt->bindParam(':teamNum', $_POST['teamNum']);
	$stmt->bindParam(':totalScore', $totalScore);
	$stmt->execute();
	
	if ($_POST[baseScanPoints] < 0) {
		echo "Successfully punished team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
	} else {
		echo "Successfully pleased team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
	}
		
	
	
//	/******* Update team's total in database ********/
//	$result = mysql_query("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum='" . $_POST['teamNum'] . "' GROUP BY teamNum") or die(mysql_error());
//	$row = mysql_fetch_array($result);
//	$totalScore = $row['SUM(baseScanPoints)'];
//	$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['teamNum']."'");
//	$row = mysql_fetch_array($result);
//	mysql_query("UPDATE Teams SET totalScore='".$totalScore."' WHERE teamNum='".$_POST['teamNum']."'")  or die(mysql_error());
//	
//	if ($_POST[baseScanPoints] < 0) {
//		echo "Successfully punished team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
//	} else {
//		echo "Successfully pleased team ".$_POST[teamNum]." for " . $_POST[baseScanPoints] . " points.";
//	}
//
//	mysql_close($con);
	
	echo "<br /><a href=\"../pleaseOrPunish.php\">Back to the please or punish page.</a>";
?>