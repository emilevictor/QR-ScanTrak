<?php 
	date_default_timezone_set('Australia/Brisbane');
	
	//Attempt to connect to the Urban Challenge database
	$conn = include '../admin/db_helper/db_connect.php';
	$currentCode = 1;
	$triggered = FALSE;
	$userPassComboCorrect = FALSE;
	
	// For every code entered, check whether illegal characters are part of the code.
	while ($currentCode < 10) {
		/*if ($_POST[strval($currentCode)] != "") {
			echo "Code: " . strval($currentCode) . " is filled.<br />";
		}*/
		/* Perform a regex check upon the string to check for whitespace and weird characters */
		//echo strval($currentCode);
		$text = $_POST[strval($currentCode)];
		if (preg_match("/[^A-Za-z0-9]/", $text)) {
			echo "Code number " . $currentCode . " has an illegal character. Please go back to the previous page and enter your codes again.<br />";
			$triggered = TRUE;
		}
		$currentCode = $currentCode + 1;
	}
	
	
	//If there was an error
	if ($triggered == TRUE) {
		echo "<br /><p>Illegal characters include all punctuation marks and spaces.</p>";
		echo "<br /><p>This irritating error message brought to you by the uberseer.</p>";
		die();
	}
	
	// else
	if ($triggered == FALSE) {
		//Check that the team username is correct. Also check for sql injection.
		if (preg_match("/[^A-Za-z0-9]/", $_POST['tNum'])) {
			echo "Illegal characters in your team number.";
			die();
		}
		if (preg_match("/[^A-Za-z0-9]/", $_POST['pwd'])) {
			echo "Illegal characters in your password.";
			die();
		}
		$result = $conn->prepare("SELECT * FROM Teams WHERE teamNum=:id");
		$result->bindValue(':id', $_POST['tNum']);
		$result->execute();
		$row = $result->fetch(PDO::FETCH_OBJ);
		if ($row->password == $_POST['pwd']) {
			$userPassComboCorrect = TRUE;
		}
		
		//If username is correct, then the $userPassComboCorrect variable will be TRUE at this point.
		
		//echo "Codes do not contain any illegal characters.<br />";
		$currentCode = 1;
		//Loop through all of the $_POST'ed codes. Check each one hasn't been scanned yet by that team.
		//If it has, then spit out an error and die.
		//If not, add it to the total.
		if ($userPassComboCorrect == TRUE) {

			// Let's prepare some startments, to avoid doing them 10 times
			$stmt = $conn->prepare('SELECT * FROM Bases WHERE basePassword=:pass');

			$ts_select = $conn->prepare("SELECT * FROM Timestamps WHERE teamNum=:num AND baseID=:id");
			$ts_select->bindValue(':num', $_POST['tNum']);

			$pw_stmt = $conn->prepare("SELECT * FROM Bases WHERE basePassword=:pass");

			$ts_insert = $conn->prepare(
				"INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints, comment) " .
				"VALUES (NOW(), :team, :id, :pts, 'No Phone input')"
			);
			$ts_insert->bindValue(':team', $_POST['tNum']);

			$points = $conn->prepare('SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum=:num GROUP BY teamNum');
			$points->bindValue(':num', $_POST['tNum']);

			$update_score = $conn->prepare("UPDATE Teams SET totalScore=:score WHERE teamNum=:num");
			$update_score->bindValue(':num', $_POST['tNum']);
			
			while ($currentCode < 9) {
				$currentCode++;
				
				if ($_POST[$currentCode] != "") {
					$stmt->bindValue(':pass', $_POST[$currentCode]);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_OBJ);
					
					if ($row->baseTrivia != "!") {
						echo "This code requires trivia to be completed. In order to complete this code, go to <a href=\"http://www.urbanchallenge.com.au/index.php?q=".$row->basePassword."\">this page</a>.<br />";
						continue;
					}

					$ts_select->bindValue(':id', $_POST[$currentCode]);
					$ts_select->execute();
					if ($ts_select->rowCount() !== 0) {
						echo "You have already scanned code ".$currentCode.". Please do not enter it again. You have received no points for that code. <br />";
						continue;
					}

					//If you are at this point, the user has been authenticated (dodgily, might I say)...
						
					//Check the amount of points to be added to the team.
					$pw_stmt->bindValue(':pass', $_POST[$currentCode]);
					$pw_stmt->execute();
					$row = $pw_stmt->fetch(PDO::FETCH_OBJ);
					$pointsToBeAdded = $row->baseScanPoints;
					$baseID = $row->baseID;
					
					//Update the timestamps table.
					$ts_insert->bindValue(':id', $baseID);
					$ts_insert->bindValue(':pts', $baseID);
					$ts_insert->execute();
					
					//Update total scores.
					$points->execute();
					$row = $points->fetch(PDO::FETCH_ASSOC);
					$totalScore = $row['SUM(baseScanPoints)'];

					$update_score->bindValue(':score', $totalScore);
					$update_score->execute();
					echo "Added " . $pointsToBeAdded . " points to team " . $_POST['tNum'] . ". New total score is " . $totalScore . ".<br />";
				}
			}
			echo "END OF LINE.<br />";
		}

		
	}
	
	
?>
