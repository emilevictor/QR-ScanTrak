<?php 
	date_default_timezone_set('Australia/Brisbane');

    
	// Connect to the database
	$conn = include '../admin/db_helper/db_connect.php';
  	
	
	/* Old code */
  	$result = $conn->prepare("SELECT * FROM Teams WHERE teamNum=:num");
  	$result->bindValue(':num', $_POST['tNum']);
  	$result->execute();
  	$row = $result->fetch(PDO::FETCH_OBJ);
  	/* END OLD CODE */
  	
  	$stmt = $conn->prepare(
	  	"INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints, comment) " .
		"VALUES (NOW(), :num, 'Points check','0','Checked points balance')"
	);
	$stmt->bindValue(':num', $_POST['tNum']);
	$stmt->execute();
  	
  	$leaderboard = $conn->query("SELECT * FROM Teams ORDER BY totalScore DESC LIMIT 10");
	//$arr = array(0 => 0);
	$position = 1;

	foreach ($leaderboard->fetchAll(PDO::FETCH_NUM) as $resultRows) {
    	//printf("ID: %s  Name: %s", $row[0], $row[1]);
    	if ((int) $resultRows[0] === (int) $row->teamNum) {
    		break;
    	} else {
    		$position++;
    	}
	}
	
  	if ($row->password != $_POST['pwd']) {
  		header('Location: ../checkPoints.php?success=epicfail');
  	}
  	
?>

<html>

<head>
<title>Your team's score</title>

<style type="text/css">
<!--
body,td,th {
	color: #FFF;
}
body {
	background-color: #000;
}

#notice {
	background-color: #ff9900;
	padding: 5px 5px 5px 5px;
	color:#000;
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
<a href="../checkPoints.php"> <- Back to Points check</a>
  	
  	<?php
  	
  	/***** Get the total score from database and set into local variable ******/
  	$result = $conn->prepare("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum=:num GROUP BY teamNum");
  	$result->bindValue(':num', $_POST['tNum']);
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$totalScore = $row['SUM(baseScanPoints)'];
	
	$result = $conn->query("SELECT noticeNum, title, body FROM Notice WHERE noticeNum = 1");
	$row = $result->fetch(PDO::FETCH_OBJ);
	
	/****** Print a notice if there is one available *******/
	if (($row->title != "!")&&($row->body != "!")) {
		echo "<div id=\"notice\">";
		echo "<h2>Notice from HQ: ".$row->title."</h2>";
		echo "<p>".$row->body."</p></div>";
	}
	
	echo "<h2>Team ".$_POST['tNum']."'s total score is <u>".$totalScore."</u> points.";
	/*if ($position < 11) {
		echo " You are currently in <u>".$position;
		if ($position == 1) {
			echo "st place</u>.</h2>";
		} else if ($position == 2) {
			echo "nd place</u>.</h2>";
		} else if ($position == 3) {
			echo "rd place</u>.</h2>";
		} else {
			echo "th place</u>.</h2>";
		}
	} else {
		echo "</h2>";
	}*/
  	
  	echo "<hr><h2>Most recent check-ins. Current time is ".date('G:i:s')."</h2>";
  	
  	$result = $conn->prepare("SELECT * FROM Timestamps WHERE teamNum=:num ORDER BY timestamp DESC LIMIT 20");
  	$result->bindValue(':num', $_POST['tNum']);
  	$result->execute();
  	
  	echo "<table border=\"0\" width=\"100%\">
	  <tr>
	  <th align=\"left\">Checked in at base/QR</th>
	  <th align=\"left\">Time</th>
	  <th align=\"left\">Points scanned</th>
	  </tr>";
  	
    foreach($result->fetchAll(PDO::FETCH_OBJ) as $row) {
  		echo "<tr>";
  		echo "<td>" . $row->baseID . "</td>";
  		echo "<td>" . $row->timestamp . "</td>";
  		echo "<td>" . $row->baseScanPoints . "</td>";
  		echo "</tr>";
  	}
  	echo "</table>";
?>
<br />
<a href="../checkPoints.php"> <- Back to Points check</a>

</body>
</html>
