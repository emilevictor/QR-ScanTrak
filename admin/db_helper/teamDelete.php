<?php

    $conn = include 'db_connect.php';
  	
  	$result = $conn->prepare('DELETE FROM Teams WHERE teamNum=:id');
    $result->bindValue(':id', $_GET['teamNum']);
  	
  	if (!$result->execute()) {
  		echo "I was unable to delete team" . $_GET['teamNum'];
  		die("<a href=\"../addTeams.php\">Back to team adding with you!</a>");
  	}
  	
  	echo "<img src=\"images/nuclear_bomb.jpg\"><br />";
  	echo "<h2>Target neutralised.</h2>";
  	echo "<a href=\"../addTeams.php\">Back to team adding with you!</a>";
?>
