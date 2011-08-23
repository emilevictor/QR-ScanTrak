<?php
	//Connect to database
	include("db_connect.php");
  	
	//Query the database
  	$result = $conn->prepare("DELETE FROM Bases WHERE baseID=:id");
    $result->bindValue(':id', $_GET['baseNum']);
  	
  	if (!$result->execute()) {
  		echo "I was unable to delete base " . $_GET['baseNum'];
  		die("<a href=\"../addBases.php\">Back to team adding with you!</a>");
  	}
  	header("Location: ../addBases.php");
?>