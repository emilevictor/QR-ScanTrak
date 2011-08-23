<?php

	//Attempt connection to UC2011 database
	include("db_helper/db_connect.php");
	
//Create the structure
	$sql = "CREATE TABLE Admins
	(
	userID int NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(userID),
	username varchar(50) NOT NULL,
	password varchar(32) NOT NULL,
	adminStatus int,
	firstName varchar(50),
	lastName varchar(50),
	phoneNumber varchar(50),
	UNIQUE KEY username (username)
	)";

//$sql = "ALTER TABLE Bases ADD shortURL varchar(100) AFTER baseEasyName";

// Execute query
	$stmt = $conn->prepare($sql);
	if (!$stmt->execute()) {
		die('unsuccessful');
	}

	echo "successful completion";
	
	echo $sql;
?>