<?php

	//Attempt connection to UC2011 database
	include("admin/db_helper/db_connect.php");
	
	/* Check that the QR code hasn't been scanned. */
	$result = mysql_query("SELECT * FROM Timestamps WHERE teamNum='".$_POST['tNum']."' AND baseID='".$_POST['baseID']."'");
	if(mysql_num_rows($result) == 0) {
		$allowScan = TRUE;
	} else {
		$allowScan = FALSE;
	}
	
	//Update score and check password.
	$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['tNum']."'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if ($row['password'] == $_POST['pwd']) {
		//Check that the score for base is currently 0.
		if($allowScan) {
			if ($_POST['boolRequireTrivia'] == 1) {
				$result = mysql_query("SELECT * FROM Bases WHERE baseID='" . $_POST['baseID'] . "'") or die(mysql_error());
				$row = mysql_fetch_array($result);
				if ($row['baseAnswer'] != $_POST['triviaAnswer']) {
					header('Location: index.php?q='.$_POST[basePassword].'&success=epicfail');
					die();
				}
			}
?>

<html>

<head>
<title>Urban Challenge 2011: get your points here!</title>
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
<p align="center"><img src="../images/UCLogoInverted.jpg"></p>
	<?php 	
			
			/**** get the number of points to be added to score ******/
			$result = mysql_query("SELECT * FROM Bases WHERE baseID='" . $_POST['baseID'] . "'") or die(mysql_error());
			$row = mysql_fetch_array($result);
			$pointsToBeAdded = $row['baseScanPoints'];
						
			/* Update the timestamps */
			mysql_query("INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints)
				VALUES (NOW(), '" . $_POST['tNum'] . "', '" . $_POST['baseID'] . "','" . $pointsToBeAdded . "')") or die(mysql_error());
			
			
			/******* Update team's total in database ********/
			$result = mysql_query("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum='" . $_POST['tNum'] . "' GROUP BY teamNum") or die(mysql_error());
			$row = mysql_fetch_array($result);
			$totalScore = $row['SUM(baseScanPoints)'];
			$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['tNum']."'");
			$row = mysql_fetch_array($result);
			mysql_query("UPDATE Teams SET totalScore='".$totalScore."' WHERE teamNum='".$_POST['tNum']."'")  or die(mysql_error());
			echo "Added " . $score . " points to team " . $_POST['tNum'] . ". New total score is " . $totalScore . ".";
		} else {
			/* If they have already scanned this QR Code */
			echo "You have already scanned this QR code.";
		}
	} else {
		/* What to do when a password is wrong */
		echo "Your password was wrong. Scan the code and try again.";
	}
	
	mysql_close($con);
?>
</body>
</html>