<?php 
	date_default_timezone_set('Australia/Brisbane');
	
	//Attempt to connect to the Urban Challenge database
	include("../admin/db_helper/db_connect.php");
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
		$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['tNum']."'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		if ($row['password'] == $_POST['pwd']) {
			$userPassComboCorrect = TRUE;
		}
		
		//If username is correct, then the $userPassComboCorrect variable will be TRUE at this point.
		
		//echo "Codes do not contain any illegal characters.<br />";
		$currentCode = 1;
		//Loop through all of the $_POST'ed codes. Check each one hasn't been scanned yet by that team.
		//If it has, then spit out an error and die.
		//If not, add it to the total.
		if ($userPassComboCorrect == TRUE) {
			
			while ($currentCode < 10) {
				
				if ($_POST[$currentCode] != "") {
				
					$result = mysql_query("SELECT * FROM Bases WHERE basePassword='" . $_POST[$currentCode] . "'") or die(mysql_error());
					$row = mysql_fetch_array($result);
					
					if ($row['baseTrivia'] == "!") {
						$result = mysql_query("SELECT * FROM Timestamps WHERE teamNum='".$_POST['tNum']."' AND baseID='".$_POST[$currentCode]."'");
						if(mysql_num_rows($result) == 0) {
							//If you are at this point, the user has been authenticated (dodgily, might I say)...
							
							//Check the amount of points to be added to the team.
							$result = mysql_query("SELECT * FROM Bases WHERE basePassword='" . $_POST[$currentCode] . "'") or die(mysql_error());
							$row = mysql_fetch_array($result);
							$pointsToBeAdded = $row['baseScanPoints'];
							$baseID = $row['baseID'];
							
							//Update the timestamps table.
							mysql_query("INSERT INTO Timestamps (timestamp, teamNum, baseID, baseScanPoints, comment)
						VALUES (NOW(), '" . $_POST['tNum'] . "', '" . $baseID . "','" . $pointsToBeAdded . "','No Phone input')") or die(mysql_error());
							
							//Update total scores.
							$result = mysql_query("SELECT teamNum, SUM(baseScanPoints) FROM Timestamps WHERE teamNum='" . $_POST['tNum'] . "' GROUP BY teamNum") or die(mysql_error());
							$row = mysql_fetch_array($result);
							$totalScore = $row['SUM(baseScanPoints)'];
							$result = mysql_query("SELECT * FROM Teams WHERE teamNum='".$_POST['tNum']."'");
							$row = mysql_fetch_array($result);
							mysql_query("UPDATE Teams SET totalScore='".$totalScore."' WHERE teamNum='".$_POST['tNum']."'")  or die(mysql_error());
							echo "Added " . $pointsToBeAdded . " points to team " . $_POST['tNum'] . ". New total score is " . $totalScore . ".<br />";
							
						} else {
							echo "You have already scanned code ".$currentCode.". Please do not enter it again. You have received no points for that code. <br />";
						}
					} else {
						echo "This code requires trivia to be completed. In order to complete this code, go to <a href=\"http://www.urbanchallenge.com.au/index.php?q=".$row['basePassword']."\">this page</a>.<br />";
					}
				}
				$currentCode++;
			}
			echo "END OF LINE.<br />";
		}

		
	}
	
	
?>