<?php

	//Attempt connection to UC2011 database
	$conn = include 'admin/db_helper/db_connect.php';
	
	/* Check that the QR code hasn't been scanned. */
	$stmt = $conn->prepare('SELECT * FROM Timestamps WHERE teamNum=:teamNum AND baseID=:baseID');
	$stmt->bindValue(':teamNum', $_POST['tNum']);
	$stmt->bindValue(':baseID', $_POST['baseID']);
	$stmt->execute();
	$allowScan = ($stmt->rowCount() === 0);

	if (!$allowScan) {
		/* If they have already scanned this QR Code */
		echo "You have already scanned this QR code.";
		die();
	}
	
	//Update score and check password.
	$stmt = $conn->prepare('SELECT * FROM Teams WHERE teamNum=:teamNum');
	$stmt->bindValue(':teamNum', $_POST['tNum']);
	if (!$stmt->execute()) {
		$info = $stmt->errorInfo();
		die($info[2]);
	}
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	if ($row->password !== $_POST['pwd']) {
		/* What to do when a password is wrong */
		echo "Your password was wrong. Scan the code and try again.";
		die();
	}

	//Check that the score for base is currently 0.
	if ($_POST['boolRequireTrivia'] == 1) {
		$stmt = $conn->prepare('SELECT * FROM Bases where baseID=:baseID');
		$stmt->bindValue(':baseID',$_POST['baseID']);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ);

		if ($row->baseAnswer != $_POST['triviaAnswer'])
		{
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
	$stmt = $conn->prepare('SELECT * FROM Bases WHERE baseID=:baseID');
	$stmt->bindValue(':baseID',$_POST['baseID']);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_OBJ);
	$pointsToBeAdded = $row->baseScanPoints;

	echo "I am about to add ". $pointsToBeAdded . "points\n";

	/* Update the timestamps */
	$stmt = $conn->prepare('INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints) VALUES (NOW(), :tNum, :baseID, :pointsToBeAdded)');
	$stmt->bindValue(':tNum',$_POST['tNum']);
	$stmt->bindValue(':baseID',$_POST['baseID']);
	$stmt->bindValue(':pointsToBeAdded',$pointsToBeAdded);
	$stmt->execute();


	//mysql_query("INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints)
	//	VALUES (NOW(), '" . $_POST['tNum'] . "', '" . $_POST['baseID'] . "','" . $pointsToBeAdded . "')") or die(mysql_error());
	
	
	/******* Update team's total in database ********/
	$stmt = $conn->prepare('SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum=:teamNum GROUP BY teamNum');
	$stmt->bindValue(':teamNum',$_POST['tNum']);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_NUM);
	$totalScore = $row[1];
	
	echo "TOTAL SCORE IS:" . $totalScore;
	$stmt = $conn->prepare('UPDATE Teams SET totalScore=:totalScore WHERE teamNum=:teamNum');
	$stmt->bindValue(':totalScore',$totalScore);
	$stmt->bindValue(':teamNum',$_POST['tNum']);
	$stmt->execute();
	//$result = mysql_query("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum='" . $_POST['tNum'] . "' GROUP BY teamNum") or die(mysql_error());
	//$row = mysql_fetch_array($result);
	//$totalScore = $row['SUM(baseScanPoints)'];
	//$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['tNum']."'");
	//$row = mysql_fetch_array($result);
	//mysql_query("UPDATE Teams SET totalScore='".$totalScore."' WHERE teamNum='".$_POST['tNum']."'")  or die(mysql_error());
	echo "Added " . $score . " points to team " . $_POST['tNum'] . ". New total score is " . $totalScore . ".";
?>
</body>
</html>
